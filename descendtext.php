<?php
$textpart = "pedigree";
include "tng_begin.php";

if (!$personID) {
    die("no args");
}
include "config/pedconfig.php";

$divctr = 1;
if ($pedigree['stdesc']) {
    $display = "none";
    $excolimg = "tng_plus";
    $imgtitle = $text['expand'];
} else {
    $display = "block";
    $excolimg = "tng_minus";
    $imgtitle = $text['collapse'];
}

function getIndividual($key, $sex, $level, $trail, $dab) {
    global $tree, $generations, $text, $righttree;
    global $divctr, $display, $excolimg, $imgtitle;

    $rval = "";
    if ($sex == "M") {
        $self = "husband";
        $spouse = "wife";
        $spouseorder = "husborder";
    } else {
        if ($sex == "F") {
            $self = "wife";
            $spouse = "husband";
            $spouseorder = "wifeorder";
        } else {
            $self = $spouse = $spouseorder = "";
        }
    }

    if ($spouse) {
        $result = getSpouseFamilyMinimal($tree, $self, $key, $spouseorder);
    } elseif ($key) {
        $result = getSpouseFamilyMinimalUnion($tree, $key);
    }
    $marrtot = tng_num_rows($result);
    if (!$marrtot && $key) {
        $result = getSpouseFamilyMinimalUnion($tree, $key);
        $self = $spouse = $spouseorder = "";
    }

    if ($result) {
        $childcounter = 0;
        while ($row = tng_fetch_assoc($result)) {
            $spouserow = [];
            $spousestr = "";
            if (!$spouse) {
                $spouse = $row['husband'] == $key ? "wife" : "husband";
            }
            if ($row[$spouse]) {
                $spouseresult = getPersonData($tree, $row[$spouse]);
                if ($spouseresult) {
                    $spouserow = tng_fetch_assoc($spouseresult);
                    $srights = determineLivingPrivateRights($spouserow, $righttree);
                    $spouserow['allow_living'] = $srights['living'];
                    $spouserow['allow_private'] = $srights['private'];
                    $spousename = getName($spouserow);
                    $vitalinfo = getVitalDates($spouserow);
                    $spousestr = "&nbsp;<a href=\"getperson.php?personID={$spouserow['personID']}&amp;tree=$tree\">$spousename</a>&nbsp; $vitalinfo<br>";
                }
            }

            $result2 = getChildrenData($tree, $row['familyID']);
            $numkids = tng_num_rows($result2);
            if ($numkids) {
                $divname = "fc$divctr";
                $divctr++;
                $rval .= str_repeat("  ", ($level - 1) * 8 - 4) . "<li><img src='img/$excolimg.gif' width='9' height='9' hspace='0' vspace='0' border='0' title='$imgtitle' id='plusminus$divname' onclick=\"return toggleDescSection('$divname');\" class=\"fakelink\" alt=\"\"> $spousestr";
                $rval .= str_repeat("  ", ($level - 1) * 8 - 2) . "<ul id=\"$divname\" class='normal' style=\"display:$display;\">\n";

                while ($crow = tng_fetch_assoc($result2)) {
                    $childcounter++;
                    $newtrail = "$trail,{$row['familyID']},{$crow['personID']}";
                    $crights = determineLivingPrivateRights($crow, $righttree);
                    $crow['allow_living'] = $crights['living'];
                    $crow['allow_private'] = $crights['private'];
                    $cname = getName($crow);
                    $vitalinfo = getVitalDates($crow);
                    $newdab = $dab . "." . $childcounter;
                    $rval .= str_repeat("  ", ($level - 1) * 8) . "<li>$level &nbsp;<a href=\"getperson.php?personID={$crow['personID']}&amp;tree=$tree\">$cname</a> <sup>[$newdab]</sup> &nbsp; <a href=\"desctracker.php?trail=$newtrail&amp;tree=$tree\" title=\"{$text['graphdesc']}\"><img src=\"img/dchart.gif\" width=\"10\" height=\"9\" alt=\"{$text['graphdesc']}\"></a> $vitalinfo\n";
                    if ($level < $generations) {
                        $ind = getIndividual($crow['personID'], $crow['sex'], $level + 1, $newtrail, $newdab);
                        if ($ind) {
                            $rval .= str_repeat("  ", ($level - 1) * 8 + 2) . "<ul class='normal'>\n$ind";
                            $rval .= str_repeat("  ", ($level - 1) * 8 + 2) . "</ul>\n";
                        }
                    } else {
                        //do union to check for children where person is either husband or wife

                        $nxtfams = getSpouseFamilyMinimalUnion($tree, $crow['personID']);
                        $nxtkids = 0;
                        while ($nxtfam = tng_fetch_assoc($nxtfams)) {
                            $result3 = countChildren($tree, $nxtfam['familyID']);
                            $nxtrow = tng_fetch_assoc($result3);
                            $nxtkids += $nxtrow['ccount'];
                            tng_free_result($result3);
                        }
                        if ($nxtkids) {
                            //chart continues
                            $rval .= "[<a href=\"descendtext.php?personID={$crow['personID']}&amp;tree=$tree\" title=\"{$text['popupnote3']}\"> =&gt;</a>]";
                        }
                    }
                    $rval .= str_repeat("  ", ($level - 1) * 8) . "</li>\n";
                }
                if ($numkids) {
                    $rval .= str_repeat("  ", ($level - 1) * 8 - 2) . "</ul> <!-- end $divname -->\n";
                    $rval .= str_repeat("  ", ($level - 1) * 8 - 4) . "</li>\n";
                }
            } elseif ($spousestr) {
                $rval .= str_repeat("  ", ($level - 1) * 8 - 4) . "<li>+ $spousestr</li>\n";
            }
            tng_free_result($result2);
        }
    }
    tng_free_result($result);
    return $rval;
}

function getVitalDates($row) {
    global $text;

    $vitalinfo = "";

    if ($row['allow_living'] && $row['allow_private']) {
        if ($row['birthdate']) {
            $vitalinfo = $text['birthabbr'] . " " . displayDate($row['birthdate']) . " ";
        } else {
            if ($row['altbirthdate']) {
                $vitalinfo = $text['chrabbr'] . " " . displayDate($row['altbirthdate']) . " ";
            } else {
                $vitalinfo .= " ";
            }
        }
        if ($row['deathdate']) {
            $vitalinfo .= $text['deathabbr'] . " " . displayDate($row['deathdate']);
        } else {
            if ($row['burialdate']) {
                $vitalinfo .= $text['burialabbr'] . " " . displayDate($row['burialdate']);
            } else {
                $vitalinfo .= " ";
            }
        }
    }
    return $vitalinfo;
}

$level = 1;
$key = $personID;

$result = getPersonFullPlusDates($tree, $personID);
if ($result) {
    $row = tng_fetch_assoc($result);
    $righttree = checktree($tree);
    $rightbranch = $righttree ? checkbranch($row['branch']) : false;
    $rights = determineLivingPrivateRights($row, $righttree, $rightbranch);
    $row['allow_living'] = $rights['living'];
    $row['allow_private'] = $rights['private'];
    $namestr = getName($row);
    $logname = $tngconfig['nnpriv'] && $row['private'] ? $admtext['text_private'] : ($nonames && $row['living'] ? $text['living'] : $namestr);
}

$treeResult = getTreeSimple($tree);
$treerow = tng_fetch_assoc($treeResult);
$disallowgedcreate = $treerow['disallowgedcreate'];
$allowpdf = !$treerow['disallowpdf'] || ($allow_pdf && $rightbranch);
tng_free_result($treeResult);

writelog("<a href=\"descendtext.php?personID=$personID&amp;tree=$tree\">{$text['descendfor']} $logname ($personID)</a>");
preparebookmark("<a href=\"descendtext.php?personID=$personID&amp;tree=$tree\">{$text['descendfor']} $namestr ($personID)</a>");

echo "<!doctype html>\n";
echo "<html lang='en'>\n";

$flags['tabs'] = $tngconfig['tabs'];
$flags['scripting'] = "<script>var tnglitbox;</script>\n";

tng_header($text['descendfor'] . " $namestr", $flags);
?>
    <script>
        var collapsemsg = "<?php echo $text['collapse']; ?>";
        var expandmsg = "<?php echo $text['expand']; ?>";

        function toggleDescSection(key) {

            var section = jQuery('#' + key);
            if (section.css('display') == 'none') {
                section.show();
                swap("plusminus" + key, "minus");
            } else {
                section.hide();
                swap("plusminus" + key, "plus");
            }
            return false;
        }

        function toggleAll(disp) {
            var i = 1;

            while (jQuery("#fc" + i).length) {
                jQuery("#fc" + i).css('display', disp);
                if (disp == '')
                    swap("plusminusfc" + i, "minus");
                else
                    swap("plusminusfc" + i, "plus");
                i++;
            }
            return false;
        }

        plus = new Image;
        plus.src = "img/tng_plus.gif";
        minus = new Image;
        minus.src = "img/tng_minus.gif";

        function swap(x, y) {
            jQuery('#' + x).attr('title', y == "minus" ? collapsemsg : expandmsg);
            document.images[x].src = eval(y + '.src');
        }
    </script>

<?php
$photostr = showSmallPhoto($personID, $namestr, $rights['both'], 0, false, $row['sex']);
echo tng_DrawHeading($photostr, $namestr, getYears($row));

if (!$pedigree['maxdesc']) {
    $pedigree['maxdesc'] = 12;
}
if (!$pedigree['initdescgens']) {
    $pedigree['initdescgens'] = 4;
}
if (!$generations) {
    $generations = $pedigree['initdescgens'] > 8 ? 8 : $pedigree['initdescgens'];
} else {
    if ($generations > $pedigree['maxdesc']) {
        $generations = $pedigree['maxdesc'];
    } else {
        $generations = intval($generations);
    }
}

$innermenu = $text['generations'] . ": &nbsp;";
$innermenu .= "<select name=\"generations\" class=\"verysmall\" onchange=\"window.location.href='descendtext.php?personID=$personID&amp;tree=$tree&amp;display=$display&amp;generations=' + this.options[this.selectedIndex].value\">\n";
for ($i = 1; $i <= $pedigree['maxdesc']; $i++) {
    $innermenu .= "<option value=\"$i\"";
    if ($i == $generations) {
        $innermenu .= " selected";
    }
    $innermenu .= ">$i</option>\n";
}
$innermenu .= "</select>&nbsp;&nbsp;&nbsp;\n";
$innermenu .= "<a href=\"descend.php?personID=$personID&amp;tree=$tree&amp;display=standard&amp;generations=$generations\" class='lightlink'>{$text['pedstandard']}</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
$innermenu .= "<a href=\"descend.php?personID=$personID&amp;tree=$tree&amp;display=compact&amp;generations=$generations\" class='lightlink'>{$text['pedcompact']}</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
$innermenu .= "<a href=\"descendtext.php?personID=$personID&amp;tree=$tree&amp;generations=$generations\" class=\"lightlink3\">{$text['pedtextonly']}</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
$innermenu .= "<a href=\"register.php?personID=$personID&amp;tree=$tree&amp;generations=$generations\" class='lightlink'>{$text['regformat']}</a>\n";
if ($generations <= 12 && $allowpdf) {
    $innermenu .= " &nbsp;&nbsp; | &nbsp;&nbsp; <a href='#' class='lightlink' ";
    $innermenu .= "onclick=\"tnglitbox = new LITBox('rpt_pdfform.php?pdftype=desc&amp;personID=$personID&amp;tree=$tree&amp;generations=$generations', {width: 400, height: 480}); return false;\">PDF</a>\n";
}

echo getFORM("descend", "get", "form1", "form1");
echo tng_menu("I", "descend", $personID, $innermenu);
echo "</form>\n";
?>
    <div class="normal">
        <p>
            (<?php echo "<img src=\"img/dchart.gif\" width=\"10\" height=\"9\" alt=\"\"> = {$text['graphdesc']}, <img src=\"img/tng_plus.gif\" width=\"9\" height=\"9\" alt=\"\"> = {$text['expand']}, <img src=\"img/tng_minus.gif\" width=\"9\" height=\"9\" alt=\"\"> = {$text['collapse']}"; ?>
            )</p>

        <p><a href="#" onclick="return toggleAll('');"><?php echo $text['expandall']; ?></a> | <a href="#"
                                                                                                  onclick="return toggleAll('none');"><?php echo $text['collapseall']; ?></a>
        </p>

        <div id="descendantchart" align="left">
            <?php
            $vitalinfo = getVitalDates($row);
            echo "<ul class=\"first\">\n";
            echo "  <li>$level &nbsp;<a href=\"getperson.php?personID=$personID&amp;tree=$tree\">$namestr</a> <sup>[1]</sup>&nbsp; $vitalinfo\n";

            if ($generations > 1) {
                $ind = getIndividual($key, $row['sex'], $level + 1, $personID, "1");
                if ($ind) {
                    echo "<ul class='normal'>$ind\n";
                    echo "</ul>\n";
                }
            }
            ?>
            </li>
            </ul>
        </div>
        <br>
    </div>
    <script src="js/rpt_utils.js"></script>
<?php tng_footer(""); ?>