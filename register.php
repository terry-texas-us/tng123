<?php
$textpart = "pedigree";
include "tng_begin.php";

if (!$personID) die("no args");

include "config/pedconfig.php";
include "personlib.php";
include "reglib.php";

if ($tngmore) {
    $pedigree['regnotes'] = 1;
} elseif ($tngless) {
    $pedigree['regnotes'] = 0;
}

$generation = 1;
$personcount = 1;

$currgen = [];
$nextgen = [];

$result = getPersonFullPlusDates($tree, $personID);
if ($result) {
    $row = tng_fetch_assoc($result);
    $righttree = checktree($tree);
    $rightbranch = $righttree ? checkbranch($row['branch']) : false;
    $rights = determineLivingPrivateRights($row, $righttree, $rightbranch);
    $row['allow_living'] = $rights['living'];
    $row['allow_private'] = $rights['private'];
    $row['name'] = getName($row);
    $logname = $tngconfig['nnpriv'] && $row['private'] ? _('Private') : ($nonames && $row['living'] ? _('Living') : $row['name']);
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

writelog("<a href=\"register.php?personID=$personID&amp;tree=$tree\">" . _('Descendancy for') . " $logname ($personID)</a>");
preparebookmark("<a href=\"register.php?personID=$personID&amp;tree=$tree\">" . _('Descendancy for') . " {$row['name']} ($personID)</a>");

$flags['scripting'] = "<script>var tnglitbox;</script>\n";

tng_header($row['name'], $flags);

$photostr = showSmallPhoto($personID, $row['name'], $rights['both'], 0, false, $row['sex']);
echo tng_DrawHeading($photostr, $row['name'], getYears($row));

if (!$pedigree['maxdesc']) $pedigree['maxdesc'] = 12;

if (!$pedigree['initdescgens']) $pedigree['initdescgens'] = 4;

if (!$generations) {
    $generations = $pedigree['initdescgens'];
} else {
    if ($generations > $pedigree['maxdesc']) {
        $generations = $pedigree['maxdesc'];
    } else {
        $generations = intval($generations);
    }
}

$detail_link = "register.php?personID=$personID&tree=$tree&generations=$generations";
if ($pedigree['regnotes']) {
    $detail_link = "<a href=\"{$detail_link}&tngless=1\">" . _('Less detail') . "</a>";
} else {
    $detail_link = "<a href=\"{$detail_link}&tngmore=1\">" . _('More detail') . "</a>";
}

$innermenu = _('Generations') . ": &nbsp;";
$innermenu .= "<select name=\"generations\" class=\"verysmall\" onchange=\"window.location.href='register.php?personID=$personID&amp;tree=$tree&amp;generations=' + this.options[this.selectedIndex].value\">\n";
for ($i = 1; $i <= $pedigree['maxdesc']; $i++) {
    $innermenu .= "<option value=\"$i\"";
    if ($i == $generations) $innermenu .= " selected";

    $innermenu .= ">$i</option>\n";
}
$innermenu .= "</select>&nbsp;&nbsp;&nbsp;\n";
$innermenu .= "<a href=\"descend.php?personID=$personID&amp;tree=$tree&amp;display=standard&amp;generations=$generations\" class='lightlink'>" . _('Standard') . "</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
$innermenu .= "<a href=\"descend.php?personID=$personID&amp;tree=$tree&amp;display=compact&amp;generations=$generations\" class='lightlink'>" . _('Compact') . "</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
$innermenu .= "<a href=\"descendtext.php?personID=$personID&amp;tree=$tree&amp;generations=$generations\" class='lightlink'>" . _('Text Only') . "</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
$innermenu .= "<a href=\"personID=$personID&amp;tree=$tree&amp;generations=$generations\" class=\"lightlink3\">" . _('Register Format') . "</a>\n";
if ($generations <= 12 && $allowpdf) {
    $innermenu .= " &nbsp;&nbsp; | &nbsp;&nbsp; <a href='#' class='lightlink' ";
    $innermenu .= "onclick=\"tnglitbox = new LITBox('rpt_pdfform.php?pdftype=desc&amp;personID=$personID&amp;tree=$tree&amp;generations=$generations', {width: 400, height: 480}); return false;\">PDF</a>\n";
}

echo getFORM("register", "get", "form1", "form1");
echo tng_menu("I", "descend", $personID, $innermenu);
echo "</form>\n";
?>
    <div class="titleboxmedium">
        <div class="float-right"><?php echo $detail_link; ?></div>
        <?php
        while (count($currgen) && $generation <= $generations) {
            echo "<h3 class='subhead'>" . _('Generation') . ": $generation</h3>\n";
            echo "<ol style=\"list-style-type:none; padding:0; margin:0;\">";
            while ($row = array_shift($currgen)) {
                echo "<li>";
                echo "<table cellpadding='0' cellspacing='0'><tr><td width=\"40\" class='align-top' align=\"right\">";
                echo "{$row['number']}.&nbsp;&nbsp;</td><td>";
                echo showSmallPhoto($row['personID'], $row['name'], $row['allow_living'] && $row['allow_private'], 0, false, $row['sex']);
                echo "<a href=\"getperson.php?personID={$row['personID']}&amp;tree=$tree\" name=\"p{$row['personID']}\" id=\"p{$row['personID']}\">{$row['name']}</a>";
                if ($row['genlist']) {
                    echo " <a href=\"desctracker.php?trail={$row['trail']}&amp;tree=$tree\" title=\"" . _('Descendancy chart to this point') . "\"><img src=\"img/dchart.gif\" width=\"10\" height=\"9\" alt=\"" . _('Descendancy chart to this point') . "\"></a> ({$row['genlist']})";
                }
                echo getVitalDates($row);
                echo getOtherEvents($row);
                if ($row['allow_living'] && $row['allow_private'] && $pedigree['regnotes']) {
                    $notes = buildRegNotes(getRegNotes($row['personID'], "I"));
                    if ($notes) {
                        echo "<p>" . _('Notes') . ":<br>";
                        echo "<blockquote class=\"blocknote\">\n$notes</blockquote>\n</p>\n";
                    }
                } else {
                    $notes = "";
                }

                $fname = $row['firstname'];
                $firstfirstname = getFirstNameOnly($row);
                $personsex = $row['sex'];
                $newlist = $row['number'] . ".<a href='#' onclick=\"jQuery('#p{$row['personID']}').animate({scrollTop: -200},'slow'); return false;\">$firstfirstname</a><sup style=\"font-size:8px;top:-2px;\">$generation</sup>";
                if ($row['genlist']) $newlist .= ", " . $row['genlist'];

                while ($spouserow = array_shift($row['spouses'])) {
                    $marriagemsg = ($personsex == "F") ? _('married') : _('married');
                    if ($spouserow['marrdate'] || $spouserow['marrplace']) {
                        echo "<p>$firstfirstname " . $marriagemsg . " <a href=\"getperson.php?personID={$spouserow['personID']}&amp;tree=$tree\">{$spouserow['name']}</a>";
                        echo getSpouseDates($spouserow, $personsex);
                    } else {
                        echo "<p>$firstfirstname " . $marriagemsg . " <a href=\"getperson.php?personID={$spouserow['personID']}&amp;tree=$tree\">{$spouserow['name']}</a>.";
                    }
                    $spouseinfo = getVitalDates($spouserow);
                    $spparents = $spouserow['personID'] ? getSpouseParents($spouserow['personID'], $spouserow['sex']) : _('Unknown');
                    if ($spouseinfo) {
                        $spname = getName($spouserow);
                        $spfirstfirstname = getFirstNameOnly($spouserow, " ");
                        echo " $spfirstfirstname $spparents $spouseinfo";
                    } else {
                        echo " $spparents";
                    }
                    echo " [<a href=\"familygroup.php?familyID={$spouserow['familyID']}&amp;tree=$tree\">" . _('Group Sheet') . "</a>]</p>\n";

                    if ($pedigree['regnotes']) {
                        if ($famrights['both']) {
                            $notes = buildRegNotes(getRegNotes($spouserow['familyID'], "F"));
                            if ($notes) {
                                echo "<p>" . _('Notes') . ":<br>";
                                echo "<blockquote class=\"blocknote\">\n$notes</blockquote>\n</p>";
                            }
                        }
                    }

                    $result2 = getChildrenData($tree, $spouserow['familyID']);
                    if ($result2 && tng_num_rows($result2)) {
                        echo "<table cellpadding='0' cellspacing='0'><tr><td>" . _('Children') . ":<br>\n<ol>\n";
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
                            echo "<li style=\"list-style-type:lower-roman;\">$displaycount. <a href='#' onclick=\"if(jQuery('#p$childID').length) {jQuery('html, body').animate({scrollTop: jQuery('#p$childID').offset().top-10},'slow');}else{window.location.href='getperson.php?personID=$childID&amp;tree=$tree';} return false;\">$name</a> &nbsp;<a href=\"desctracker.php?trail={$childrow['trail']}&amp;tree=$tree\"><img src=\"img/dchart.gif\" width=\"10\" height=\"9\" alt=\"" . _('Descendancy chart to this point') . "\"></a> $vitaldates</li>\n";
                        }
                        echo "</ol>\n</td></tr></table>\n";
                        tng_free_result($result2);
                    }
                }
                echo "</td></tr>";
                echo "</table>";
                echo "<br style=\"clear: both;\"></li>\n";
            }
            $currgen = $nextgen;
            unset($nextgen);
            $nextgen = [];
            $generation++;
            echo "</ol>\n<br>\n";
        }
        ?>

    </div>
    <script src="js/rpt_utils.js"></script>
<?php
tng_footer("");
?>