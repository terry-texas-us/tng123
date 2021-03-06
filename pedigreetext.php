<?php
@set_time_limit(0);
$textpart = "pedigree";
include "tng_begin.php";

include "config/pedconfig.php";
if (!$personID) die("no args");


if (isset($generations)) $generations = intval($generations);

if (isset($parentset)) $parentset = intval($parentset);

/**
 * @param $pedborder
 */
function showBlank($pedborder) {
    echo "<td $pedborder><span class='normal'>&nbsp;</span></td>\n";
    echo "<td class='whitespace-no-wrap'><span class='normal'>&nbsp;</span></td>\n</tr>\n";
    echo "<tr>\n<td $pedborder><span class='normal'>&nbsp;</span></td>\n";
    echo "<td class='whitespace-no-wrap'><span class='normal'>&nbsp;</span></td>\n</tr>\n";
}

/**
 * @param $key
 * @param $generation
 * @param $slot
 */
function displayIndividual($key, $generation, $slot) {
    global $tree, $generations, $marrdate, $marrplace, $pedmax;
    global $parentset, $righttree;

    $nextslot = $slot * 2;
    $name = "";
    $row['birthdate'] = "";
    $row['birthplace'] = "";
    $row['altbirthdate'] = "";
    $row['altbirthplace'] = "";
    $row['deathdate'] = "";
    $row['deathplace'] = "";
    $row['burialdate'] = "";
    $row['burialplace'] = "";

    if ($key) {
        $result = getPersonData($tree, $key);
        if ($result) {
            $row = tng_fetch_assoc($result);
            $rights = determineLivingPrivateRights($row, $righttree);
            $row['allow_living'] = $rights['living'];
            $row['allow_private'] = $rights['private'];
            $name = getName($row);
            tng_free_result($result);
        }
    }

    if ($slot > 1 && $slot % 2 != 0) echo "</tr>\n<tr>\n";


    $rowspan = pow(2, $generations - $generation);
    if ($rowspan == 1) {
        $vertfill = 8;
    } else {
        $vertfill = ($rowspan - 1) * 53 + 1;
    }

    if ($slot > 1 && $slot % 2 != 0) {
        echo "<td class='align-top' rowspan='$rowspan'>\n";
    } elseif ($slot % 2 == 0) {
        echo "<td class='align-bottom' rowspan='$rowspan'>\n";
    } else {
        echo "<td rowspan='$rowspan'>\n";
    }

    if ($slot > 1 && $slot % 2 != 0) {
        echo "<table border='0' cellpadding='0' cellspacing='0'>\n<tr>\n";
        echo "<td width='1'><img src=\"img/black.gif\" alt=\"\" height=\"$vertfill\" width='1' vspace='0' hspace='0' border='0'></td>\n";
        echo "<td></td>\n</tr>\n</table>\n";
    } else {
        echo "<table border='0' cellpadding='0' cellspacing='0'>\n<tr>\n";
        echo "<td colspan='2'><img src=\"img/spacer.gif\" alt=\"\"  height=\"$vertfill\" width='1' vspace='0' hspace='0' border='0'></td>\n</tr>\n</table>\n";
    }

    echo "<table class='w-full' border='0' cellpadding='0' cellspacing='0'>\n";
    echo "<tr>\n";
    $pedborder = $slot % 2 && $slot != 1 ? "class=\"nw pedborderleft\"" : "";
    echo "<td colspan='2' $pedborder><span class='normal'>&nbsp;$slot. <a href=\"getperson.php?personID=$key&amp;tree=$tree\">$name</a>&nbsp;</span></td>\n";

    //arrow goes here in own cell
    if ($nextslot >= $pedmax && $row['famc']) {
        echo "<td><span class='normal'><a href=\"pedigree.php?personID=$key&amp;tree=$tree&amp;display=textonly\" title=\"" . _('New pedigree') . "\">=&gt;</a></span></td>\n";
    }

    echo "</tr>\n";
    echo "<tr>\n<td colspan='2'><img src=\"img/black.gif\" alt=\"\" width='1' height='1' vspace='0' hspace='0' border='0'></td>\n</tr>\n";
    echo "<tr>\n";

    $pedborder = $slot % 2 ? "" : "class=\"pedborderleft\"";

    if ($rights['both']) {
        if ($row['birthdate'] || $row['altbirthdate'] || $row['altbirthplace'] || $row['deathdate'] || $row['burialdate'] || $row['burialplace'] || ($slot % 2 == 0 && ($marrdate[$slot] || $marrplace[$slot]))) {
            $dataflag = 1;
        } else {
            $dataflag = 0;
        }
        if ($row['altbirthdate'] && !$row['birthdate']) {
            echo "<td class='align-top' $pedborder><span class='normal'>&nbsp;" . _('A') . ":</span></td>\n";
            echo "<td class='align-top'><span class='normal'>" . displayDate($row['altbirthdate']) . "&nbsp;</span></td>\n</tr>\n";
            echo "<tr>\n";
            echo "<td class='align-top' $pedborder><span class='normal'>&nbsp;" . _('P') . ":&nbsp;</span></td>\n";
            echo "<td class='align-top'><span class='normal'>{$row['altbirthplace']}&nbsp;</span></td>\n</tr>\n";
        } elseif ($dataflag) {
            echo "<td class='align-top' $pedborder><span class='normal'>&nbsp;" . _('B') . ":</span></td>\n";
            echo "<td class='align-top'><span class='normal'>" . displayDate($row['birthdate']) . "&nbsp;</span></td></tr>\n";
            echo "<tr>\n";
            echo "<td class='align-top' $pedborder><span class='normal'>&nbsp;" . _('P') . ":&nbsp;</span></td>\n";
            echo "<td class='align-top'><span class='normal'>{$row['birthplace']}&nbsp;</span></td>\n</tr>\n";
        } else {
            showBlank($pedborder);
        }
        if ($slot % 2 == 0) {
            if ($dataflag) {
                echo "<tr>\n";
                echo "<td class='pedborderleft align-top'><span class='normal'>&nbsp;" . _('M') . ":</span></td>\n";
                echo "<td class='align-top'><span class='normal'>" . displayDate($marrdate[$slot]) . "&nbsp;</span></td>\n";
                echo "</tr>\n";
                echo "<tr>\n";
                echo "<td class='pedborderleft align-top'><span class='normal'>&nbsp;" . _('P') . ":&nbsp;</span></td>\n";
                echo "<td class='align-top'><span class='normal'>{$marrplace[$slot]}&nbsp;</span></td>\n";
                echo "</tr>\n";
            } else {
                echo "<tr>\n";
                showBlank($pedborder);
            }
        }
        if ($row['burialdate'] && !$row['deathdate']) {
            echo "<tr>\n";
            echo "<td class='align-top' $pedborder><span class='normal'>&nbsp;" . _('B') . ":</span></td>\n";
            echo "<td class='align-top'><span class='normal'>" . displayDate($row['burialdate']) . "&nbsp;</span></td>\n</tr>\n";
            echo "<tr>\n";
            echo "<td class='align-top' $pedborder><span class='normal'>&nbsp;" . _('P') . ":&nbsp;</span></td>\n";
            echo "<td class='align-top'><span class='normal'>{$row['burialplace']}&nbsp;</span></td>\n</tr>\n</table>\n";
        } elseif ($dataflag) {
            echo "<tr>\n";
            echo "<td class='align-top' $pedborder><span class='normal'>&nbsp;" . _('D') . ":</span></td>\n";
            echo "<td class='align-top'><span class='normal'>" . displayDate($row['deathdate']) . "&nbsp;</span></td></tr>\n";
            echo "<tr>\n";
            echo "<td class='align-top' $pedborder><span class='normal'>&nbsp;" . _('P') . ":&nbsp;</span></td>\n";
            echo "<td class='align-top'><span class='normal'>{$row['deathplace']}&nbsp;</span></td>\n</tr>\n</table>\n";
        } else {
            echo "<tr>\n";
            showBlank($pedborder);

            echo "</table>\n";
        }
    } else {
        showBlank($pedborder);
        if ($slot % 2 == 0) {
            echo "<tr>\n";
            showBlank($pedborder);
        }
        echo "<tr>\n";
        showBlank($pedborder);
        echo "</table>\n";
    }

    if ($slot % 2 == 0) {
        echo "<table border='0' cellpadding='0' cellspacing='0'>\n<tr>\n";
        echo "<td width='1'><img src=\"img/black.gif\" alt=\"\"  height=\"$vertfill\" width='1' vspace='0' hspace='0' border='0'></td>\n";
        echo "<td></td>\n</tr>\n</table>\n";
    } else {
        echo "<table border='0' cellpadding='0' cellspacing='0'>\n<tr>\n";
        echo "<td colspan='2'><img src=\"img/spacer.gif\" alt=\"\" height=\"$vertfill\" width='1' vspace='0' hspace='0' border='0'></td>\n</tr>\n</table>\n";
    }
    echo "</td>\n";

    $generation++;
    if ($nextslot < $pedmax) {
        $husband = "";
        $wife = "";
        $marrdate[$nextslot] = "";
        $marrplace[$nextslot] = "";

        if ($key) {
            $parentfamID = "";
            $locparentset = $parentset;
            $parentscount = 0;
            $parentfamIDs = [];
            $parents = getChildFamily($tree, $key, "parentorder");
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

            $result2 = getFamilyData($tree, $parentfamID);
            if ($result2) {
                $newrow = tng_fetch_assoc($result2);
                $husband = $newrow['husband'];
                $wife = $newrow['wife'];
                $nrights = determineLivingPrivateRights($newrow, $righttree);
                if ($nrights['both']) {
                    $marrdate[$nextslot] = $newrow['marrdate'];
                    $marrplace[$nextslot] = $newrow['marrplace'];
                } else {
                    $marrdate[$nextslot] = "";
                    $marrplace[$nextslot] = "";
                }
                tng_free_result($result2);
            }
        }
        displayIndividual($husband, $generation, $nextslot);
        $nextslot++;
        displayIndividual($wife, $generation, $nextslot);
    }
}

$result = getPersonFullPlusDates($tree, $personID);
if ($result) {
    $row = tng_fetch_assoc($result);
    $righttree = checktree($tree);
    $rightbranch = $righttree ? checkbranch($row['branch']) : false;
    $rights = determineLivingPrivateRights($row, $righttree, $rightbranch);
    $row['allow_living'] = $rights['living'];
    $row['allow_private'] = $rights['private'];
    $pedname = getName($row);
    $logname = $tngconfig['nnpriv'] && $row['private'] ? _('Private') : ($nonames && $row['living'] ? _('Living') : $pedname);
    tng_free_result($result);
}

$treeResult = getTreeSimple($tree);
$treerow = tng_fetch_assoc($treeResult);
$disallowgedcreate = $treerow['disallowgedcreate'];
$allowpdf = !$treerow['disallowpdf'] || ($allow_pdf && $rightbranch);
tng_free_result($treeResult);

if (!$pedigree['maxgen']) $pedigree['maxgen'] = 6;

if ($generations > $pedigree['maxgen']) {
    $generations = intval($pedigree['maxgen']);
} elseif (!$generations) {
    $generations = $pedigree['initpedgens'] >= 2 ? intval($pedigree['initpedgens']) : 2;
} else {
    $generations = intval($generations);
}

$pedmax = pow(2, intval($generations));
$key = $personID;

$gentext = xmlcharacters(_('Generations'));
writelog("<a href=\"pedigree.php?personID=$personID&amp;tree=$tree&amp;generations=$generations&amp;display=textonly\">" . xmlcharacters(_('Pedigree Chart for') . " $logname ($personID)") . "</a> $generations " . $gentext);
preparebookmark("<a href=\"pedigree.php?personID=$personID&amp;tree=$tree&amp;generations=$generations&amp;display=textonly\">" . xmlcharacters(_('Pedigree Chart for') . " $pedname ($personID)") . "</a> $generations " . $gentext);

$flags['scripting'] = "<script>var tnglitbox;</script>\n";

tng_header(_('Pedigree Chart for') . " $pedname", $flags);

$photostr = showSmallPhoto($personID, $pedname, $rights['both'], 0, false, $row['sex']);
echo tng_DrawHeading($photostr, $pedname, getYears($row));

$innermenu = _('Generations') . ": &nbsp;";
$innermenu .= "<select name=\"generations\" class=\"verysmall\" onchange=\"window.location.href='pedigreetext.php?personID=$personID&amp;tree=$tree&amp;parentset=$parentset&amp;display=$display&amp;generations=' + this.options[this.selectedIndex].value\">\n";
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
$innermenu .= "<a href=\"pedigreetext.php?personID=$personID&amp;tree=$tree&amp;parentset=$parentset&amp;generations=$generations\" class=\"lightlink3\">" . _('Text Only') . "</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
$innermenu .= "<a href=\"ahnentafel.php?personID=$personID&amp;tree=$tree&amp;parentset=$parentset&amp;generations=$generations\" class='lightlink'>" . _('Ahnentafel') . "</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
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
    <table class="w-full" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <?php
            $slot = 1;
            displayIndividual($personID, 1, $slot);
            ?>
        </tr>
    </table>
    <script src="js/rpt_utils.js"></script>
<?php
tng_footer("");
?>