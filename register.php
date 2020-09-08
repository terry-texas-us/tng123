<?php
$textpart = "pedigree";
include "tng_begin.php";

if (!$personID) {
    die("no args");
}
include $subroot . "pedconfig.php";
include $cms['tngpath'] . "personlib.php";
include $cms['tngpath'] . "reglib.php";

$getperson_url = getURL("getperson", 1);
$register_url = getURL("register", 1);
$descend_url = getURL("descend", 1);
$descendtext_url = getURL("descendtext", 1);
$familygroup_url = getURL("familygroup", 1);
$desctracker_url = getURL("desctracker", 1);
$pdfform_url = getURL("rpt_pdfform", 1);

if ($tngmore) {
    $pedigree['regnotes'] = 1;
} elseif ($tngless) {
    $pedigree['regnotes'] = 0;
}

$generation = 1;
$personcount = 1;

$currgen = array();
$nextgen = array();

$result = getPersonFullPlusDates($tree, $personID);
if ($result) {
    $row = tng_fetch_assoc($result);
    $righttree = checktree($tree);
    $rightbranch = $righttree ? checkbranch($row['branch']) : false;
    $rights = determineLivingPrivateRights($row, $righttree, $rightbranch);
    $row['allow_living'] = $rights['living'];
    $row['allow_private'] = $rights['private'];
    $row['name'] = getName($row);
    $logname = $tngconfig['nnpriv'] && $row['private'] ? $admtext['text_private'] : ($nonames && $row['living'] ? $text['living'] : $row['name']);
    $row['genlist'] = "";
    $row['trail'] = $personID;
    $row['number'] = 1;
    $row['spouses'] = getSpouses($personID, $row['sex']);
    array_push($currgen, $row);
}

$treeResult = getTreeSimple($tree);
$treerow = tng_fetch_assoc($treeResult);
$disallowgedcreate = $treerow['disallowgedcreate'];
$allowpdf = !$treerow['disallowpdf'] || ($allow_pdf && $rightbranch);
tng_free_result($treeResult);

writelog("<a href=\"$register_url" . "personID=$personID&amp;tree=$tree\">{$text['descendfor']} $logname ($personID)</a>");
preparebookmark("<a href=\"$register_url" . "personID=$personID&amp;tree=$tree\">{$text['descendfor']} {$row['name']} ($personID)</a>");

$flags['tabs'] = $tngconfig['tabs'];
$flags['scripting'] = "<script type=\"text/javascript\">var tnglitbox;</script>\n";
tng_header($row['name'], $flags);

$photostr = showSmallPhoto($personID, $row['name'], $rights['both'], 0, false, $row['sex']);
echo tng_DrawHeading($photostr, $row['name'], getYears($row));

if (!$pedigree['maxdesc']) {
    $pedigree['maxdesc'] = 12;
}
if (!$pedigree['initdescgens']) {
    $pedigree['initdescgens'] = 4;
}
if (!$generations) {
    $generations = $pedigree['initdescgens'];
} else {
    if ($generations > $pedigree['maxdesc']) {
        $generations = $pedigree['maxdesc'];
    } else {
        $generations = intval($generations);
    }
}

$detail_link = "{$register_url}personID=$personID&tree=$tree&generations=$generations";
if ($pedigree['regnotes']) {
    $detail_link = "<a href=\"{$detail_link}&tngless=1\">{$text['lessdetail']}</a>";
} else {
    $detail_link = "<a href=\"{$detail_link}&tngmore=1\">{$text['moredetail']}</a>";
}

$innermenu = $text['generations'] . ": &nbsp;";
$innermenu .= "<select name=\"generations\" class=\"verysmall\" onchange=\"window.location.href='$register_url" . "personID=$personID&amp;tree=$tree&amp;generations=' + this.options[this.selectedIndex].value\">\n";
for ($i = 1; $i <= $pedigree['maxdesc']; $i++) {
    $innermenu .= "<option value=\"$i\"";
    if ($i == $generations) {
        $innermenu .= " selected=\"selected\"";
    }
    $innermenu .= ">$i</option>\n";
}
$innermenu .= "</select>&nbsp;&nbsp;&nbsp;\n";
$innermenu .= "<a href=\"$descend_url" . "personID=$personID&amp;tree=$tree&amp;display=standard&amp;generations=$generations\" class=\"lightlink\">{$text['pedstandard']}</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
$innermenu .= "<a href=\"$descend_url" . "personID=$personID&amp;tree=$tree&amp;display=compact&amp;generations=$generations\" class=\"lightlink\">{$text['pedcompact']}</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
$innermenu .= "<a href=\"$descendtext_url" . "personID=$personID&amp;tree=$tree&amp;generations=$generations\" class=\"lightlink\">{$text['pedtextonly']}</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
$innermenu .= "<a href=\"$register_url" . "personID=$personID&amp;tree=$tree&amp;generations=$generations\" class=\"lightlink3\">{$text['regformat']}</a>\n";
if ($generations <= 12 && $allowpdf) {
    $innermenu .= " &nbsp;&nbsp; | &nbsp;&nbsp; <a href=\"#\" class=\"lightlink\" ";
    $innermenu .= "onclick=\"tnglitbox = new LITBox('$pdfform_url" . "pdftype=desc&amp;personID=$personID&amp;tree=$tree&amp;generations=$generations', {width:350, height:350}); return false;\">PDF</a>\n";
}

echo getFORM("register", "get", "form1", "form1");
echo tng_menu("I", "descend", $personID, $innermenu);
echo "</form>\n";
?>
    <div class="titleboxmedium">
        <div class="float-right"><?php echo $detail_link; ?></div>
        <?php
        while (count($currgen) && $generation <= $generations) {
            echo "<span class=\"subhead\"><strong>{$text['generation']}: $generation</strong></span><br><br>\n";
            echo "<ol style=\"list-style-type:none; padding:0; margin:0;\">";
            while ($row = array_shift($currgen)) {
                echo "<li>";
                echo "<table cellpadding=\"0\" cellspacing=\"0\"><tr><td width=\"40\" class=\"aligntop\" align=\"right\">";
                echo "{$row['number']}.&nbsp;&nbsp;</td><td>";
                echo showSmallPhoto($row['personID'], $row['name'], $row['allow_living'] && $row['allow_private'], 0, false, $row['sex']);
                echo "<a href=\"$getperson_url" . "personID={$row['personID']}&amp;tree=$tree\" name=\"p{$row['personID']}\" id=\"p{$row['personID']}\">{$row['name']}</a>";
                if ($row['genlist']) {
                    echo " <a href=\"$desctracker_url" . "trail={$row['trail']}&amp;tree=$tree\" title=\"{$text['graphdesc']}\"><img src=\"{$cms['tngpath']}img/dchart.gif\" width=\"10\" height=\"9\" alt=\"{$text['graphdesc']}\"></a> ({$row['genlist']})";
                }
                echo getVitalDates($row);
                echo getOtherEvents($row);
                if ($row['allow_living'] && $row['allow_private'] && $pedigree['regnotes']) {
                    $notes = buildRegNotes(getRegNotes($row['personID'], "I"));
                    if ($notes) {
                        echo "<p>{$text['notes']}:<br>";
                        echo "<blockquote class=\"blocknote\">\n$notes</blockquote>\n</p>\n";
                    }
                } else {
                    $notes = "";
                }

                $fname = $row['firstname'];
                $firstfirstname = getFirstNameOnly($row);
                $personsex = $row['sex'];
                $newlist = $row['number'] . ".<a href=\"#\" onclick=\"jQuery('#p{$row['personID']}').animate({scrollTop: -200},'slow'); return false;\">$firstfirstname</a><sup style=\"font-size:8px;top:-2px;\">$generation</sup>";
                if ($row['genlist']) {
                    $newlist .= ", " . $row['genlist'];
                }
                while ($spouserow = array_shift($row['spouses'])) {
                    $marriagemsg = ($personsex == "F") ? $text['wasmarried_female'] : $text['wasmarried_male'];
                    if ($spouserow['marrdate'] || $spouserow['marrplace']) {
                        echo "<p>$firstfirstname " . $marriagemsg . " <a href=\"$getperson_url" . "personID={$spouserow['personID']}&amp;tree=$tree\">{$spouserow['name']}</a>";
                        echo getSpouseDates($spouserow, $personsex);
                    } else {
                        echo "<p>$firstfirstname " . $marriagemsg . " <a href=\"$getperson_url" . "personID={$spouserow['personID']}&amp;tree=$tree\">{$spouserow['name']}</a>.";
                    }
                    $spouseinfo = getVitalDates($spouserow);
                    $spparents = $spouserow['personID'] ? getSpouseParents($spouserow['personID'], $spouserow['sex']) : $text['unknown'];
                    if ($spouseinfo) {
                        $spname = getName($spouserow);
                        $spfirstfirstname = getFirstNameOnly($spouserow, " ");
                        echo " $spfirstfirstname $spparents $spouseinfo";
                    } else {
                        echo " $spparents";
                    }
                    echo " [<a href=\"$familygroup_url" . "familyID={$spouserow['familyID']}&amp;tree=$tree\">{$text['groupsheet']}</a>]</p>\n";

                    if ($pedigree['regnotes']) {
                        if ($famrights['both']) {
                            $notes = buildRegNotes(getRegNotes($spouserow['familyID'], "F"));
                            if ($notes) {
                                echo "<p>{$text['notes']}:<br>";
                                echo "<blockquote class=\"blocknote\">\n$notes</blockquote>\n</p>";
                            }
                        }
                    }

                    $result2 = getChildrenData($tree, $spouserow['familyID']);
                    if ($result2 && tng_num_rows($result2)) {
                        echo "<table cellpadding=\"0\" cellspacing=\"0\"><tr><td>{$text['children']}:<br>\n<ol>\n";
                        while ($childrow = tng_fetch_assoc($result2)) {
                            $childID = $childrow['personID'];
                            if ($nextgen[$childID]) {
                                $displaycount = $nextgen[$childID]['number'];
                                $name = $nextgen[$childID]['name'];
                                $vitaldates = getVitalDates($nextgen[$childID]);
                            } else {
                                $personcount++;
                                $displaycount = $personcount;
                                $childrow['spouses'] = getSpouses($childID, $childrow['sex']);
                                $childrow['genlist'] = $newlist;
                                $childrow['trail'] = $row['trail'] . ",{$spouserow['familyID']},$childID";
                                $childrow['number'] = $personcount;
                                $crights = determineLivingPrivateRights($childrow, $righttree);
                                $childrow['allow_living'] = $crights['living'];
                                $childrow['allow_private'] = $crights['private'];
                                $childrow['name'] = $name = getName($childrow);
                                $vitaldates = getVitalDates($childrow);
                                if ($childrow['spouses'] || !$pedigree['regnosp']) {
                                    $nextgen[$childID] = $childrow;
                                }
                            }
                            echo "<li style=\"list-style-type:lower-roman;\">$displaycount. <a href=\"#\" onclick=\"if(jQuery('#p$childID').length) {jQuery('html, body').animate({scrollTop: jQuery('#p$childID').offset().top-10},'slow');}else{window.location.href='$getperson_url" . "personID=$childID&amp;tree=$tree';} return false;\">$name</a> &nbsp;<a href=\"$desctracker_url" . "trail={$childrow['trail']}&amp;tree=$tree\"><img src=\"{$cms['tngpath']}img/dchart.gif\" width=\"10\" height=\"9\" alt=\"{$text['graphdesc']}\"></a> $vitaldates</li>\n";
                        }
                        echo "</ol>\n</td></tr></table>\n";
                        tng_free_result($result2);
                    }
                }
                echo "</td></tr></table>";
                echo "<br clear=\"all\"></li>\n";
            }
            $currgen = $nextgen;
            unset($nextgen);
            $nextgen = array();
            $generation++;
            echo "</ol>\n<br>\n";
        }
        ?>

    </div>
    <script type="text/javascript" src="<?php echo $cms['tngpath']; ?>js/rpt_utils.js"></script>
<?php
tng_footer("");
?>