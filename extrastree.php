<?php
$textpart = "pedigree";
include "tng_begin.php";

include "config/pedconfig.php";

if (!$generations) {
    $generations = 12;
}

function displayIndividual($key, $generation, $slot, $column) {
    global $columns, $tree, $pedmax, $text, $media_table, $medialinks_table, $col1fam, $col2fam;
    global $showall, $parentset, $righttree;

    $nextslot = $slot * 2;
    $name = "";

    if ($key) {
        $result = getPersonDataPlusDates($tree, $key);
        if ($result) {
            $row = tng_fetch_assoc($result);
            $rights = determineLivingPrivateRights($row, $righttree);
            $row['allow_living'] = $rights['living'];
            $row['allow_private'] = $rights['private'];
            $lastname = trim($row['lnprefix'] . " " . $row['lastname']);

            if ($generation == 2) {
                if ($slot == 2) {
                    $col1fam = $lastname ? $lastname : $text['paternal'];
                } else {
                    $col2fam = $lastname ? $lastname : $text['maternal'];
                }
            }

            $mediaquery = "SELECT count($medialinks_table.medialinkID) AS mediacount FROM ($medialinks_table, $media_table) WHERE $medialinks_table.mediaID = $media_table.mediaID AND personID = \"$key\" AND $medialinks_table.gedcom = '$tree'";
            $mediaresult = tng_query($mediaquery) or die ($text['cannotexecutequery'] . ": $mediaquery");
            if ($mediaresult) {
                $mediarow = tng_fetch_assoc($mediaresult);
                tng_free_result($mediaresult);
            } else {
                $mediarow['mediacount'] = 0;
            }

            if ($mediarow['mediacount'] || $showall) {
                if (!isset($columns[$column][$generation])) {
                    $gentext = "gen$generation";
                    $genmsg = isset($text[$gentext]) ? $text[$gentext] : $text['generation'] . ": $generation";
                    $columns[$column][$generation] = "<span class='normal'>$genmsg<br></span>\n<ul>\n";
                }
                $namestr = getNameRev($row);
                $columns[$column][$generation] .= "<li><span class='normal'><a href=\"getperson.php?tng_extras=1&amp;personID=$key&amp;tree=$tree\">$namestr</a> " . trim(getYears($row));
                if ($mediarow['mediacount']) {
                    $columns[$column][$generation] .= " <a href=\"getperson.php?tng_extras=1&amp;personID=$key&amp;tree=$tree\" title=\"{$text['mediaavail']}\"><img src=\"img/photo.gif\" width=\"14\" height=\"12\" alt=\"{$text['mediaavail']}\"></a>";
                }
                $columns[$column][$generation] .= "</span></li>\n";
            }
            //}
            tng_free_result($result);
        }
    }

    $generation++;
    if ($nextslot < $pedmax) {
        $husband = "";
        $wife = "";

        if ($key) {
            $parentfamID = "";
            $locparentset = $parentset;
            $parentscount = 0;
            $parentfamIDs = [];
            $parents = getChildFamily($tree, $key, "parentorder");
            if ($parents) {
                $parentscount = tng_num_rows($parents);
                if ($parentscount > 0) {
                    if ($locparentset > $parentscount) {
                        $locparentset = $parentscount;
                    }
                    $i = 0;
                    while ($parentrow = tng_fetch_assoc($parents)) {
                        $i++;
                        if ($i == $locparentset) {
                            $parentfamID = $parentrow['familyID'];
                        }
                        $parentfamIDs[$i] = $parentrow['familyID'];
                    }
                    if (!$parentfamID) {
                        $parentfamID = $row['famc'];
                    }
                }
                tng_free_result($parents);
            }
            $result2 = getFamilyMinimal($tree, $parentfamID);
            if ($result2) {
                $newrow = tng_fetch_assoc($result2);
                $husband = $newrow['husband'];
                $wife = $newrow['wife'];
                tng_free_result($result2);
            }
        }
        if (!$column) {
            $leftcolumn = 1;
            $rightcolumn = 2;
        } else {
            $leftcolumn = $rightcolumn = $column;
        }
        displayIndividual($husband, $generation, $nextslot, $leftcolumn);
        $nextslot++;
        displayIndividual($wife, $generation, $nextslot, $rightcolumn);
    }
}

$result = getPersonDataPlusDates($tree, $personID);
if ($result) {
    $row = tng_fetch_assoc($result);
    $righttree = checktree($tree);
    $rightbranch = $righttree ? checkbranch($row['branch']) : false;
    $rights = determineLivingPrivateRights($row, $righttree, $rightbranch);
    $row['allow_living'] = $rights['living'];
    $row['allow_private'] = $rights['private'];
    $pedname = getName($row);
    $logname = $tngconfig['nnpriv'] && $row['private'] ? $admtext['text_private'] : ($nonames && $row['living'] ? $text['living'] : $pedname);
    tng_free_result($result);
}

$treeResult = getTreeSimple($tree);
$treerow = tng_fetch_assoc($treeResult);
$disallowgedcreate = $treerow['disallowgedcreate'];
$allowpdf = !$treerow['disallowpdf'] || ($allow_pdf && $rightbranch);
tng_free_result($treeResult);

$columns = [];

$pedmax = pow(2, intval($generations));
$key = $personID;

writelog("<a href=\"extrastree.php?personID=$personID&amp;tree=$tree\">{$text['familyof']} $logname ($personID)</a>");
preparebookmark("<a href=\"extrastree.php?personID=$personID&amp;tree=$tree\">{$text['familyof']} $pedname ($personID)</a>");

echo "<!doctype html>\n";
echo "<html lang='en'>\n";

$flags['tabs'] = $tngconfig['tabs'];
$flags['scripting'] = "<script>var tnglitbox;</script>\n";

tng_header($text['media'] . ": {$text['familyof']} $pedname", $flags);

$photostr = showSmallPhoto($personID, $pedname, $rights['both'], 0, false, $row['sex']);
echo tng_DrawHeading($photostr, $pedname, getYears($row));

$innermenu = $text['generations'] . ": &nbsp;";
if (!$pedigree['maxgen']) {
    $pedigree['maxgen'] = 6;
}
if ($generations > $pedigree['maxgen']) {
    $generations = $pedigree['maxgen'];
}
$innermenu .= "<select name=\"generations\" class=\"verysmall\" onchange=\"window.location.href='extrastree.php?personID=$personID&amp;tree=$tree&amp;showall=$showall&amp;generations=' + this.options[this.selectedIndex].value\">\n";
for ($i = 1; $i <= $pedigree['maxgen']; $i++) {
    $innermenu .= "<option value=\"$i\"";
    if ($i == $generations) {
        $innermenu .= " selected";
    }
    $innermenu .= ">$i</option>\n";
}
$innermenu .= "</select>&nbsp;&nbsp;&nbsp;\n";
$innermenu .= "<a href=\"pedigree.php?personID=$personID&amp;tree=$tree&amp;parentset=$parentset&amp;display=standard&amp;generations=$generations\" class='lightlink' id=\"stdpedlnk\">{$text['pedstandard']}</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
$innermenu .= "<a href=\"verticalchart.php?personID=$personID&amp;tree=$tree&amp;parentset=$parentset&amp;display=vertical&amp;generations=$generations\" class='lightlink' id=\"pedchartlnk\">{$text['pedvertical']}</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
$innermenu .= "<a href=\"pedigree.php?personID=$personID&amp;tree=$tree&amp;parentset=$parentset&amp;display=compact&amp;generations=$generations\" class='lightlink' id=\"compedlnk\">{$text['pedcompact']}</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
$innermenu .= "<a href=\"pedigree.php?personID=$personID&amp;tree=$tree&amp;parentset=$parentset&amp;display=box&amp;generations=$generations\" class='lightlink' id=\"boxpedlnk\">{$text['pedbox']}</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
$innermenu .= "<a href=\"pedigreetext.php?personID=$personID&amp;tree=$tree&amp;parentset=$parentset&amp;generations=$generations\" class='lightlink'>{$text['pedtextonly']}</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
$innermenu .= "<a href=\"ahnentafel.php?personID=$personID&amp;tree=$tree&amp;parentset=$parentset&amp;generations=$generations\" class='lightlink'>{$text['ahnentafel']}</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
$innermenu .= "<a href=\"fan.php?personID=$personID&amp;tree=$tree&amp;parentset=$parentset&amp;generations=$generations\" class='lightlink'>{$text['fanchart']}</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
$innermenu .= "<a href=\"extrastree.php?personID=$personID&amp;tree=$tree&amp;parentset=$parentset&amp;showall=1&amp;generations=$generations\" class=\"lightlink3\">{$text['media']}</a>\n";
if ($generations <= 6 && $allowpdf) {
    $innermenu .= " &nbsp;&nbsp; | &nbsp;&nbsp; <a href='#' class='lightlink' ";
    $innermenu .= "onclick=\"tnglitbox = new LITBox('rpt_pdfform.php?pdftype=ped&amp;personID=$personID&amp;tree=$tree&amp;generations=$generations', {width: 400, height: 480}); return false;\">PDF</a>\n";
}

echo getFORM("pedigree", "", "form1", "form1");
echo tng_menu("I", "pedigree", $personID, $innermenu);
echo "</form>\n";

echo "<h3 class='subhead'>{$text['media']}: {$text['familyof']} $pedname</h3>";

if ($showall) {
    echo "<p><img src=\"img/photo.gif\" width=\"14\" height=\"12\" alt=\"{$text['mediaavail']}\"> {$text['extrasexpl']}</p>";
}
$slot = 1;
displayIndividual($personID, 1, $slot, 0);
?>
    <table cellspacing="0" cellpadding="0">
        <tr>
            <td class='align-top'>
                <h3 class="subhead"><?php echo "$col1fam {$text['side']}"; ?></h3>
                <?php
                for ($nextgen = 2; $nextgen <= $generations; $nextgen++) {
                    if ($columns[1][$nextgen]) {
                        echo $columns[1][$nextgen];
                        echo "</ul>\n<br>\n";
                    }
                }
                ?>
            </td>
            <td>&nbsp;&nbsp;&nbsp;</td>
            <td class='align-top'>
                <h3 class="subhead"><?php echo "$col2fam " . $text['side']; ?></h3>
                <?php
                for ($nextgen = 2; $nextgen <= $generations; $nextgen++) {
                    if ($columns[2][$nextgen]) {
                        echo $columns[2][$nextgen];
                        echo "</ul>\n<br>\n";
                    }
                }
                ?>
            </td>
        </tr>
    </table>
    <script src="js/rpt_utils.js"></script>

<?php
tng_footer("");
?>