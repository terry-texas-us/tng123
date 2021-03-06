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

$detail_link = "ahnentafel.php?personID=$personID&tree=$tree&parentset=$parentset&generations=$generations";
if ($pedigree['regnotes']) {
    $detail_link = "<a href=\"{$detail_link}&tngless=1\">" . _('Less detail') . "</a>";
} else {
    $detail_link = "<a href=\"{$detail_link}&tngmore=1\">" . _('More detail') . "</a>";
}

$generation = 1;
$personcount = 1;

$currgen = [];
$nextgen = [];
$numbers = [];
$lastgen = [];
$lastlastgen = [];

$result = getPersonFullPlusDates($tree, $personID);
if (!tng_num_rows($result)) {
    tng_free_result($result);
    header("Location: thispagedoesnotexist.html");
    exit;
}

$row = tng_fetch_assoc($result);
tng_free_result($result);
$righttree = checktree($tree);
$rightbranch = $righttree ? checkbranch($row['branch']) : false;
$rights = determineLivingPrivateRights($row, $righttree, $rightbranch);
$row['allow_living'] = $rights['living'];
$row['allow_private'] = $rights['private'];
$row['name'] = getName($row);

$firstfirstname = getFirstNameOnly($row);
$personsex = $row['sex'];

$logname = $tngconfig['nnpriv'] && $row['private'] ? _('Private') : ($nonames && $row['living'] ? _('Living') : $row['name']);
$row['genlist'] = "";
$row['number'] = 1;
$row['spouses'] = getSpouses($personID, $row['sex']);
$lastlastgen[$personID] = 1;

$treeResult = getTreeSimple($tree);
$treerow = tng_fetch_assoc($treeResult);
$disallowgedcreate = $treerow['disallowgedcreate'];
$allowpdf = !$treerow['disallowpdf'] || ($allow_pdf && $rightbranch);
tng_free_result($treeResult);

writelog("<a href=\"ahnentafel.php?personID=$personID&amp;tree=$tree\">" . xmlcharacters(_('Ahnentafel') . ": $logname ($personID)") . "</a>");
preparebookmark("<a href=\"ahnentafel.php?personID=$personID&amp;tree=$tree\">" . xmlcharacters(_('Ahnentafel') . ": " . $row['name'] . " ($personID)") . "</a>");

$flags['scripting'] = "<script>var tnglitbox;</script>\n";

tng_header($row['name'], $flags);

$photostr = showSmallPhoto($personID, $row['name'], $rights['both'], 0, false, $row['sex']);
echo tng_DrawHeading($photostr, $row['name'], getYears($row));

if (!$pedigree['maxgen']) $pedigree['maxgen'] = 6;

if ($generations > $pedigree['maxgen']) {
    $generations = intval($pedigree['maxgen']);
} elseif (!$generations) {
    $generations = $pedigree['initpedgens'] >= 2 ? intval($pedigree['initpedgens']) : 2;
} else {
    $generations = intval($generations);
}

$innermenu = _('Generations') . ": &nbsp;";
$innermenu .= "<select name=\"generations\" class=\"verysmall\" onchange=\"window.location.href='ahnentafel.php?personID=$personID&amp;tree=$tree&amp;parentset=$parentset&amp;generations=' + this.options[this.selectedIndex].value\">\n";
for ($i = 1; $i <= $pedigree['maxgen']; $i++) {
    $innermenu .= "<option value=\"$i\"";
    if ($i == $generations) $innermenu .= " selected";

    $innermenu .= ">$i</option>\n";
}
$innermenu .= "</select>&nbsp;&nbsp;&nbsp;\n";
$innermenu .= "<a href=\"pedigree.php?personID=$personID&amp;tree=$tree&amp;parentset=$parentset&amp;display=standard&amp;generations=$generations\" class='lightlink' id=\"stdpedlnk\">" . _('Standard') . "</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
$innermenu .= "<a href=\"verticalchart.php?personID=$personID&amp;tree=$tree&amp;parentset=$parentset&amp;display=vertical&amp;generations=$generations\" class='lightlink' id=\"pedchartlnk\">" . _('Vertical') . "</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
$innermenu .= "<a href=\"pedigree.php?personID=$personID&amp;tree=$tree&amp;parentset=$parentset&amp;display=compact&amp;generations=$generations\" class='lightlink' id=\"compedlnk\">" . _('Compact') . "</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
$innermenu .= "<a href=\"pedigree.php?personID=$personID&amp;tree=$tree&amp;parentset=$parentset&amp;display=box&amp;generations=$generations\" class='lightlink' id=\"boxpedlnk\">" . _('Box') . "</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
$innermenu .= "<a href=\"pedigreetext.php?personID=$personID&amp;tree=$tree&amp;parentset=$parentset&amp;generations=$generations\" class='lightlink'>" . _('Text Only') . "</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
$innermenu .= "<a href=\"ahnentafel.php?personID=$personID&amp;tree=$tree&amp;parentset=$parentset&amp;generations=$generations\" class=\"lightlink3\">" . _('Ahnentafel') . "</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
$innermenu .= "<a href=\"fan.php?personID=$personID&amp;tree=$tree&amp;parentset=$parentset&amp;generations=$generations\" class='lightlink'>" . _('Fan Chart') . "</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
$innermenu .= "<a href=\"extrastree.php?personID=$personID&amp;tree=$tree&amp;parentset=$parentset&amp;showall=1&amp;generations=$generations\" class='lightlink'>" . _('Media') . "</a>\n";
if ($generations <= 6 && $allowpdf) {
    $innermenu .= " &nbsp;&nbsp; | &nbsp;&nbsp; <a href='#' class='lightlink' ";
    $innermenu .= "onclick=\"tnglitbox = new LITBox('rpt_pdfform.php?pdftype=ped&amp;personID=$personID&amp;tree=$tree&amp;generations=$generations', {width: 400, height: 480}); return false;\">PDF</a>\n";
}

echo getFORM("pedigree", "", "form1", "form1");
echo tng_menu("I", "pedigree", $personID, $innermenu);
echo "</form>\n";
?>

    <div class="titleboxmedium">
        <div class="float-right"><?php echo $detail_link; ?></div>
        <?php
        //do self
        echo "<h3 class='subhead'>" . _('Generation') . ": 1</h3>\n";
        echo "<ol style=\"list-style-type:none; padding:0; margin:0;\">";
        echo "<li>";
        echo "<table cellpadding='0' cellspacing='0' class='align-top' ><tr><td width=\"40\" class='align-top' align=\"right\">";
        echo "$personcount.&nbsp;&nbsp;</td><td>";
        echo showSmallPhoto($row['personID'], $row['name'], $rights['both'], 0);
        echo "<a href=\"getperson.php?personID={$row['personID']}&amp;tree=$tree\" name=\"p{$row['personID']}\" id=\"p{$row['personID']}\">{$row['name']}</a>";
        echo getVitalDates($row, 1);
        echo getOtherEvents($row);
        if ($rights['both'] && $pedigree['regnotes']) {
            $notes = buildRegNotes(getRegNotes($row['personID'], "I"));
            if ($notes) {
                echo "<p>" . _('Notes') . ":<br>";
                echo "<blockquote class=\"blocknote\">\n$notes</blockquote>\n</p>\n";
            }
        } else {
            $notes = "";
        }

        //do spouse
        while ($spouserow = array_shift($row['spouses'])) {
            $marriagemsg = ($personsex == "F") ? _('married') : _('married');
            if ($spouserow['marrdate'] || $spouserow['marrplace']) {
                echo "<p>$firstfirstname " . $marriagemsg . " <a href=\"getperson.php?personID={$spouserow['personID']}&amp;tree=$tree\">{$spouserow['name']}</a>";
                echo getSpouseDates($spouserow, $personsex);
            } else {
                echo "<p>$firstfirstname " . $marriagemsg . " <a href=\"getperson.php?personID={$spouserow['personID']}&amp;tree=$tree\">{$spouserow['name']}</a>.";
            }
            $spouseinfo = getVitalDates($spouserow);
            if ($spouseinfo) {
                $spfirstfirstname = getFirstNameOnly($spouserow);
                $spparents = getSpouseParents($spouserow['personID'], $spouserow['sex']);
                echo " $spfirstfirstname $spparents $spouseinfo";
            }
            echo " [<a href=\"familygroup.php?familyID={$spouserow['familyID']}&amp;tree=$tree\">" . _('Group Sheet') . "</a>]";
            echo "</p>\n";

            if ($pedigree['regnotes']) {
                $famrights = determineLivingPrivateRights($spouserow, $righttree);
                if ($famrights['both']) {
                    $notes = buildRegNotes(getRegNotes($spouserow['familyID'], "F"));
                    if ($notes) {
                        echo "<p>" . _('Notes') . ":<br>";
                        echo "<blockquote class=\"blocknote\">\n$notes</blockquote>\n</p>\n";
                    }
                }
            }

            $result2 = getChildrenData($tree, $spouserow['familyID']);
            if ($result2 && tng_num_rows($result2)) {
                echo "" . _('Children') . ":\n<ol class=\"ahnblock\">\n";
                while ($childrow = tng_fetch_assoc($result2)) {
                    $childrow['genlist'] = $newlist;
                    $crights = determineLivingPrivateRights($childrow, $righttree);
                    $childrow['allow_living'] = $crights['living'];
                    $childrow['allow_private'] = $crights['private'];
                    $childrow['name'] = getName($childrow);
                    if ($childrow['name'] == _('Living')) {
                        $childrow['firstname'] = _('Living');
                    }

                    echo "<li style=\"list-style-type:lower-roman;\"><a href=\"getperson.php?personID={$childrow['personID']}&amp;tree=$tree\">{$childrow['name']}</a>";
                    echo getVitalDates($childrow);
                    echo "</li>\n";
                }
                echo "</ol>\n";
                tng_free_result($result2);
            }
        }
        echo "</td></tr>";
        echo "</table>";
        echo "<br style=\"clear: both;\"></li>\n</ol>\n";


        //push famc (family of parents) to nextgen
        $parentfamID = "";
        $locparentset = $parentset;
        $parentscount = 0;
        $parentfamIDs = [];
        $parents = getChildFamily($tree, $personID, "parentorder");
        if ($parents) {
            $parentscount = tng_num_rows($parents);
            if ($parentscount > 0) {
                if ($locparentset > $parentscount) $locparentset = $parentscount;

                $i = 0;
                while ($parentrow = tng_fetch_assoc($parents)) {
                    $i++;
                    if ($i == $locparentset) $parentfamID = $parentrow['familyID'];

                    $parentfamIDs[$i] = $parentrow['familyID'];
                }
                if (!$parentfamID) $parentfamID = $row['famc'];

            }
            tng_free_result($parents);
        }

        array_push($currgen, $parentfamID);
        $generation++;
        $personcount = 1;
        $numbers[$parentfamID] = 1;

        //loop through nextgen
        //while there's one to pop and we're less than maxgen
        while (count($currgen) && $generation <= $generations) {
            echo "<h3 class='subhead'>" . _('Generation') . ": $generation</h3>\n";

            echo "<ol style=\"list-style-type:none; padding:0; margin:0;\">";
            while ($nextfamily = array_shift($currgen)) {
                $parents = getFamilyData($tree, $nextfamily);
                if ($parents) {
                    $parentrow = tng_fetch_assoc($parents);

                    $famrights = determineLivingPrivateRights($parentrow, $righttree);
                    $parentrow['allow_living'] = $famrights['living'];
                    $parentrow['allow_private'] = $famrights['private'];

                    if ($parentrow['husband']) {
                        $gotfather = getPersonData($tree, $parentrow['husband']);

                        if ($gotfather) {
                            $fathrow = tng_fetch_assoc($gotfather);
                            if ($fathrow['firstname'] || $fathrow['lastname']) {
                                $personcount = $numbers[$nextfamily] * 2;
                                $lastgen[$fathrow['personID']] = $personcount;
                                $frights = determineLivingPrivateRights($fathrow, $righttree);
                                $fathrow['allow_living'] = $frights['living'];
                                $fathrow['allow_private'] = $frights['private'];
                                $fathrow['name'] = getName($fathrow);
                                if ($fathrow['name'] == _('Living')) {
                                    $fathrow['firstname'] = _('Living');
                                }

                                echo "<li>";

                                echo "<table class='align-top' cellpadding='0' cellspacing='0'>";
                                echo "<tr><td width=\"40\" class='align-top' align=\"right\">";
                                echo "$personcount.&nbsp;&nbsp;</td><td>";
                                echo showSmallPhoto($fathrow['personID'], $fathrow['name'], $frights['both'], 0);
                                echo "<a href=\"getperson.php?personID={$fathrow['personID']}&amp;tree=$tree\" name=\"p{$fathrow['personID']}\" id=\"p{$fathrow['personID']}\">{$fathrow['name']}</a>";
                                echo getVitalDates($fathrow, 1);
                                echo getOtherEvents($fathrow);
                                if ($frights['both'] && $pedigree['regnotes']) {
                                    $notes = buildRegNotes(getRegNotes($fathrow['personID'], "I"));
                                    if ($notes) {
                                        echo "<p>" . _('Notes') . ":<br>";
                                        echo "<blockquote class=\"blocknote\">\n$notes</blockquote>\n</p>\n";
                                    }
                                } else {
                                    $notes = "";
                                }
                                if ($fathrow['famc']) {
                                    if (!in_array($fathrow['famc'], $nextgen)) {
                                        array_push($nextgen, $fathrow['famc']);
                                    }
                                    if (!$numbers[$fathrow['famc']]) {
                                        $numbers[$fathrow['famc']] = $personcount;
                                    }
                                }
                            }
                            tng_free_result($gotfather);
                        }
                    }

                    if ($parentrow['wife']) {
                        $gotmother = getPersonData($tree, $parentrow['wife']);

                        if ($gotmother) {
                            $mothrow = tng_fetch_assoc($gotmother);
                            if ($mothrow['firstname'] || $mothrow['lastname']) {
                                $personcount = $numbers[$nextfamily] * 2 + 1;
                                $lastgen[$mothrow['personID']] = $personcount;
                                $mrights = determineLivingPrivateRights($mothrow, $righttree);
                                $mothrow['allow_living'] = $mrights['living'];
                                $mothrow['allow_private'] = $mrights['private'];
                                $mothrow['name'] = getName($mothrow);
                                if ($mothrow['name'] == _('Living')) {
                                    $mothrow['firstname'] = _('Living');
                                }

                                if ($parentrow['husband']) {
                                    $firstfirstname = getFirstNameOnly($fathrow);
                                    $parentrow['both'] = $mothrow['both'];
                                    $marriagemsg = ($personsex == "F") ? _('married') : _('married');
                                    if ($parentrow['marrdate'] || $parentrow['marrplace']) {
                                        echo "<p>$firstfirstname " . $marriagemsg . " <a href='#' onclick=\"jQuery('html, body').animate({scrollTop: jQuery('#p{$parentrow['wife']}').offset().top-10},'slow'); return false;\">{$mothrow['name']}</a>";
                                        echo getSpouseDates($parentrow, $personsex);
                                    } else {
                                        echo "<p>$firstfirstname " . $marriagemsg . " <a href='#' onclick=\"jQuery('html, body').animate({scrollTop: jQuery('#p{$parentrow['wife']}').offset().top-10},'slow'); return false;\">{$mothrow['name']}</a>.";
                                    }
                                    $spouseinfo = getVitalDates($mothrow);
                                    if ($spouseinfo) {
                                        $spfirstfirstname = getFirstNameOnly($mothrow);
                                        $spparents = getSpouseParents($mothrow['personID'], $mothrow['sex']);
                                        echo " $spfirstfirstname $spparents $spouseinfo";
                                    }
                                    echo " [<a href=\"familygroup.php?familyID=$nextfamily&amp;tree=$tree\">" . _('Group Sheet') . "</a>]</p>\n";

                                    echo "</td></tr>";
                                    echo "</table>";
                                    echo "<br style=\"clear: both;\"></li>\n";
                                }

                                echo "<li>";

                                echo "<table class='align-top' cellpadding='0' cellspacing='0'>";
                                echo "<tr><td width=\"40\" class='align-top' align=\"right\">";
                                echo "$personcount.&nbsp;&nbsp;</td><td>";
                                echo showSmallPhoto($mothrow['personID'], $mothrow['name'], $mrights['both'], 0);
                                echo "<a href=\"getperson.php?personID={$mothrow['personID']}&amp;tree=$tree\" name=\"p{$mothrow['personID']}\" id=\"p{$mothrow['personID']}\">{$mothrow['name']}</a>";
                                echo getVitalDates($mothrow, 1);
                                echo getOtherEvents($mothrow);
                                if ($mrights['both'] && $pedigree['regnotes']) {
                                    $notes = buildRegNotes(getRegNotes($mothrow['personID'], "I"));
                                    if ($notes) {
                                        echo "<p>" . _('Notes') . ":<br>";
                                        echo "<blockquote class=\"blocknote\">\n$notes</blockquote>\n</p>\n";
                                    }
                                } else {
                                    $notes = "";
                                }

                                if ($mothrow['famc']) {
                                    if (!in_array($mothrow['famc'], $nextgen)) {
                                        array_push($nextgen, $mothrow['famc']);
                                    }
                                    if (!$numbers[$mothrow['famc']]) {
                                        $numbers[$mothrow['famc']] = $personcount;
                                    }
                                }
                            }
                            tng_free_result($gotmother);
                        }
                        if ($pedigree['regnotes']) {
                            $prights = determineLivingPrivateRights($parentrow, $righttree);
                            if ($prights['both']) {
                                $notes = buildRegNotes(getRegNotes($nextfamily, "F"));
                                if ($notes) {
                                    echo "<p>" . _('Notes') . ":<br>";
                                    echo "<blockquote class=\"blocknote\">\n$notes</blockquote>\n</p>\n";
                                }
                            }
                        }
                    }

                    //get children
                    $result2 = getChildrenData($tree, $nextfamily);
                    if ($result2 && tng_num_rows($result2)) {
                        echo "<table cellpadding='0' cellspacing='0'>\n";
                        echo "<tr><td>" . _('Children') . ":<br>\n<ol class=\"ahnblock\">\n";
                        while ($childrow = tng_fetch_assoc($result2)) {
                            $crights = determineLivingPrivateRights($childrow, $righttree);
                            $childrow['allow_living'] = $crights['living'];
                            $childrow['allow_private'] = $crights['private'];
                            $childrow['name'] = getName($childrow);

                            echo "<li style=\"list-style-type:lower-roman;\">";
                            if ($lastlastgen[$childrow['personID']]) {
                                echo $lastlastgen[$childrow['personID']] . ". ";
                                echo "<a href='#' onclick=\"jQuery('html, body').animate({scrollTop: jQuery('#p{$childrow['personID']}').offset().top-10},'slow'); return false;\">{$childrow['name']}</a>";
                            } else {
                                echo "<a href=\"getperson.php?personID={$childrow['personID']}&amp;tree=$tree\">{$childrow['name']}</a>";
                            }
                            echo getVitalDates($childrow);
                            echo "</li>\n";
                        }
                        echo "</ol>\n</td></tr></table>\n";
                        tng_free_result($result2);
                    }
                    echo "</td></tr>";
                    echo "</table>";
                    echo "<br style=\"clear: both;\"></li>\n";
                }
            }

            $currgen = $nextgen;
            $lastlastgen = $lastgen;
            unset($nextgen);
            unset($lastgen);
            $nextgen = [];
            $lastgen = [];
            $generation++;
            echo "</ol>\n<br>\n";
        }
        ?>
    </div>

    <script src="js/rpt_utils.js"></script>
<?php tng_footer(""); ?>