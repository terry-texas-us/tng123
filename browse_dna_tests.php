<?php
$textpart = "dna";
include "tng_begin.php";

if ($tngconfig['hidedna'] && (!$allow_edit || !$allow_add || $assignedtree)) {
    header("Location: thispagedoesnotexist.html");
    exit;
}
include "functions.php";
include "personlib.php";
require_once "admin/pagination.php";

$maxsearchresults = $maxdnasearchresults ? $maxdnasearchresults : $maxsearchresults;

/**
 * @param $test_type
 * @param $test_group
 * @return string
 */
function get_test_groups($test_type, $test_group) {
    global $dna_groups_table;
    $wherestr2 = $test_type ? " AND test_type = \"$test_type\"" : "";
    $groupquery = "SELECT description, test_type, gedcom FROM $dna_groups_table WHERE description IS NOT NULL $wherestr2 ORDER BY description";
    $groupsel = "	<option value=\"\">" . _('All Groups') . "</option>\n";
    $groupresult = tng_query($groupquery);
    while ($grouprow = tng_fetch_assoc($groupresult)) {
        $groupsel .= "	<option value=\"{$grouprow['description']}\"";
        if ($grouprow['description'] == $test_group) {
            $groupsel .= " selected";
        }
        $groupsel .= ">{$grouprow['description']}</option>\n";
    }
    tng_free_result($groupresult);
    return $groupsel;
}

/**
 * @param $instance
 * @param $pagenav
 * @return string
 */
function doTestSearch($instance, $pagenav) {
    global $testsearch, $tree;

    $str = "<span class='normal'>\n";
    $str .= getFORM("browse_dna_tests", "get", "TestSearch$instance", "");
    $str .= "<input type='text' name=\"testsearch\" value=\"$testsearch\"> <input type='submit' value=\"" . _('Search') . "\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    $str .= $pagenav;
    if ($testsearch) {
        $str .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"browse_dna_tests.php\">" . _('Browse All Tests') . "</a>";
    }
    $str .= "<input type='hidden' name=\"tree\" value='$tree'>\n";
    $str .= "</form></span>\n";

    return $str;
}

$max_browse_test_pages = 5;
if (!empty($offset)) {
    $offsetplus = $offset + 1;
    $newoffset = "$offset, ";
} else {
    $offsetplus = 1;
    $newoffset = "";
    $page = 1;
}

$testsearch = isset($testsearch) ? trim($testsearch) : '';
if ($tree) {
    $wherestr = "WHERE $dna_tests_table.gedcom = '$tree'";
    if ($testsearch) {
        $wherestr .= " AND (test_type LIKE \"%$testsearch%\" OR test_number LIKE \"%$testsearch%\" OR vendor LIKE \"%$testsearch%\" OR notes LIKE \"%$testsearch%\" OR dna_group LIKE \"%$testsearch%\" OR dna_group_desc LIKE \"%$testsearch%\" OR surnames LIKE \"%$testsearch%\")";
    }
    $join = "INNER JOIN";
} else {
    if ($testsearch) {
        $wherestr = "WHERE test_type LIKE \"%$testsearch%\" OR test_number LIKE \"%$testsearch%\" OR vendor LIKE \"%$testsearch%\" OR notes LIKE \"%$testsearch%\" OR dna_group LIKE \"%$testsearch%\" OR dna_group_desc LIKE \"%$testsearch%\" OR surnames LIKE \"%$testsearch%\"";
    } else {
        $wherestr = "";
    }
    $join = "LEFT JOIN";
}

//	only return tests not marked "keep test private" if user does not have "Allow Private" privilege
if (!$allow_private) {
    if ($wherestr) {
        $wherestr .= " AND $dna_tests_table.private_test != '1' ";
    } else {
        $wherestr .= " WHERE $dna_tests_table.private_test != '1' ";
    }
} else {
    $wherestr .= "";
}

$test_hdr = _('DNA Tests');

if (!isset($test_type)) $test_type = '';
if ($test_type) {
    switch ($test_type) {
        case "Y-DNA":
            $test_hdr = _('Y-DNA Tests');
            break;
        case "mtDNA":
            $test_hdr = _('mtDNA (Mitochondrial) Tests');
            break;
        case "atDNA":
            $test_hdr = _('atDNA (autosomal) Tests');
            break;
    }
    if ($wherestr) {
        $wherestr .= " AND $dna_tests_table.test_type = \"$test_type\"";
    } else {
        $wherestr = "WHERE $dna_tests_table.test_type = \"$test_type\"";
    }
}
if (!isset($test_group)) $test_group = '';
if ($test_group) {
    _('DNA Tests') .= ": " . $test_group;
    if ($wherestr) {
        $wherestr .= " AND $dna_tests_table.dna_group_desc = \"$test_group\"";
    } else {
        $wherestr = "WHERE $dna_tests_table.dna_group_desc = \"$test_group\"";
    }
}

$query = "SELECT testID, test_type, test_number, vendor, $dna_tests_table.gedcom, $dna_tests_table.personID, treename, ydna_haplogroup, mtdna_haplogroup, markers, ydna_confirmed, mtdna_confirmed, person_name, private_dna, private_test, dna_group, dna_group_desc, surnames, MD_ancestorID, MRC_ancestorID
	FROM $dna_tests_table $join $trees_table on $dna_tests_table.gedcom = $trees_table.gedcom $wherestr
	ORDER BY test_type, dna_group_desc, personID, vendor, test_date LIMIT $newoffset" . $maxsearchresults;
$result = tng_query($query);

$numrows = tng_num_rows($result);

if ($numrows == $maxsearchresults || $offsetplus > 1) {
    if ($tree) {
        $query = "SELECT count(testID) AS tcount ";
        $query .= "FROM $dna_tests_table dna_tests ";
        $query .= "LEFT JOIN $trees_table trees ON dna_tests.gedcom = trees.gedcom ";
        $query .= "$wherestr";
    } else {
        $query = "SELECT count(testID) AS tcount ";
        $query .= "FROM $dna_tests_table ";
        $query .= "$wherestr";
    }
    $result2 = tng_query($query);
    $row = tng_fetch_assoc($result2);
    $totrows = $row['tcount'];
} else {
    $totrows = $numrows;
}

if (!isset($offset)) $offset = 0;
$numrowsplus = $numrows + $offset;

$treestr = $tree ? " (" . _('Tree') . ": $tree)" : "";
$logstring = "<a href=\"browse_dna_tests.php?tree=$tree&amp;offset=$offset&amp;testsearch=$testsearch\">" . xmlcharacters(_('DNA Tests') . $treestr) . "</a>";
writelog($logstring);
preparebookmark($logstring);

tng_header(_('DNA Tests'), $flags);
?>

<h2 class="header"><span class="headericon" id="dna-hdr-icon"></span><?php echo $test_hdr; ?></h2>
<br style="clear: left;">
<?php echo "<div class='normal'>\n"; ?>

<form action="browse_dna_tests.php" method="post" name="form1" id="form1">
    <table class="normal">
        <tr>
            <td>
                <?php
                if (!$requirelogin || !$treerestrict || !$assignedtree) {
                    $wherestr = $allow_admin ? "" : "WHERE secret != 2";
                    $query = "SELECT gedcom, treename FROM $trees_table $wherestr ORDER BY treename";
                    $treeresult = tng_query($query);
                    $numtrees = tng_num_rows($treeresult);
                    if ($numtrees > 1) {
                        $ret = "";
                        $ret .= "<span class='normal'>" . _('Tree') . ": </span>";
                        $ret .= "<select name=\"tree\" id=\"treeselect\" onchange=\"jQuery('#treespinner').show();document.form1.submit();\">\n";
                        $ret .= "<option value=\"-x--all--x-\" ";
                        if (!$tree) $ret .= "selected";

                        $ret .= ">" . _('All Trees') . "</option>\n";

                        while ($row = tng_fetch_assoc($treeresult)) {
                            $ret .= "<option value=\"{$row['gedcom']}\"";
                            if ($tree && $row['gedcom'] == $tree) $ret .= " selected";

                            $ret .= ">{$row['treename']}</option>\n";
                        }
                        $ret .= "</select>\n";
                        tng_free_result($treeresult);
                        $ret .= "&nbsp; <img src=\"img/spinner.gif\" style='display: none;' id=\"treespinner\" alt=\"\" class=\"spinner\">\n";
                        echo $ret;
                    }
                }
                ?>
            </td>
            <td>
                <?php echo _('Test Type'); ?>:
                <select name="test_type" id="test_type" onchange="jQuery('#treespinner2').show();document.form1.test_group.selectedIndex = 0;document.form1.submit();">
                    <option value=""><?php echo _('All Types'); ?></option>
                    <option value="atDNA"<?php if ($test_type == "atDNA") {
                        echo " selected";
                    } ?>><?php echo _('atDNA (autosomal) Tests'); ?></option>
                    <option value="Y-DNA"<?php if ($test_type == "Y-DNA") {
                        echo " selected";
                    } ?>><?php echo _('Y-DNA Tests'); ?></option>
                    <option value="mtDNA"<?php if ($test_type == "mtDNA") {
                        echo " selected";
                    } ?>><?php echo _('mtDNA (Mitochondrial) Tests'); ?></option>
                    <option value="X-DNA"<?php if ($test_type == "X-DNA") {
                        echo " selected";
                    } ?>><?php echo _('X-DNA'); ?></option>
                </select>&nbsp;<img src="img/spinner.gif" style="display:none;" id="treespinner2" alt="" class="spinner">&nbsp;&nbsp;&nbsp;
            </td>
            <td>
                <?php echo _('Test Group'); ?>:
                <select name="test_group" id="test_group" onchange="jQuery('#treespinner3').show();document.form1.submit();">
                    <?php echo get_test_groups($test_type, $test_group); ?>
                </select>&nbsp;<img src="img/spinner.gif" style="display:none;" id="treespinner3" alt="" class="spinner">&nbsp;&nbsp;&nbsp;
                <input type="submit" name="reset" value="<?php echo _('Reset'); ?>" onclick="document.form1.test_type.selectedIndex = 0;document.form1.test_group.selectedIndex = 0;">
                <br>
            </td>
        </tr>
    </table>
</form>
<?php
$_SESSION["ttree"] = $tree;
$_SESSION["ttype"] = $test_type;
$_SESSION["tgroup"] = $test_group;
$_SESSION["tsearch"] = $testsearch;

if ($totrows) {
    echo "<p><span class='normal'>" . _('Matches') . " $offsetplus " . _('to') . " $numrowsplus " . _('of') . " $totrows</span></p>";
}
$pagenav = get_browseitems_nav($totrows, "browse_dna_tests.php?testsearch=$testsearch&amp;offset", $maxsearchresults, $max_browse_test_pages);
if ($pagenav || $testsearch) {
    echo doTestSearch(1, $pagenav);
    echo "<br>\n";
}
echo "<table class='whiteback normal' cellpadding='3' cellspacing='1' border='0'>";
?>
<script>
    function toggleAll(flag) {
        for (var i = 0; i < document.form2.elements.length; i++) {
            if (document.form2.elements[i].type == "checkbox") {
                if (flag)
                    document.form2.elements[i].checked = true;
                else
                    document.form2.elements[i].checked = false;
            }
        }
    }
</script>
<?php if ($test_type && $test_type != "X-DNA") {
if ($test_type == "Y-DNA") {
    $compare_url = "compare_selected_ydna.php";
}
if ($test_type == "atDNA") {
    $compare_url = "compare_selected_atdna.php";
}
if ($test_type == "mtDNA") {
    $compare_url = "compare_selected_mtdna.php";
}
?>
<form action="<?php echo $compare_url; ?>" method="post" name="form2">
    <p class="whitespace-no-wrap">
        <input type="button" name="selectall" value="<?php echo _('Select All'); ?>" onClick="toggleAll(1);">
        <input type="button" name="clearall" value="<?php echo _('Clear All'); ?>" onClick="toggleAll(0);">&nbsp;&nbsp;
        <input type="submit" name="cdnaaction" value="<?php echo _('Compare Selected'); ?>">&nbsp;&nbsp;
    </p>
    <?php } ?>
    <thead>
    <tr>
        <th class="fieldnameback nbrcol fieldname">&nbsp;#&nbsp;</th>
        <?php if ($test_type && $test_type != "X-DNA") { ?>
            <th class="fieldnameback fieldname">&nbsp;<?php echo _('Select'); ?>&nbsp;</th>
        <?php } ?>
        <th class="fieldnameback fieldname whitespace-no-wrap">&nbsp;<?php echo _('Test Type'); ?>&nbsp;</th>
        <?php
        if ($allow_edit || $showtestnumbers) { ?>
            <th class="fieldnameback fieldname whitespace-no-wrap">&nbsp;<?php echo _('Test Number/Name'); ?>&nbsp;</th>
        <?php } ?>
        <th class="fieldnameback fieldname whitespace-no-wrap">&nbsp;<?php echo _('Haplogroup'); ?>&nbsp;</th>
        <th class="fieldnameback fieldname whitespace-no-wrap">&nbsp;<?php echo _('Taken by'); ?>&nbsp;</th>
        <th class="fieldnameback fieldname whitespace-no-wrap">&nbsp;<?php echo _('Most distant ancestor'); ?>&nbsp;</th>
        <th class="fieldnameback fieldname whitespace-no-wrap">&nbsp;<?php echo _('MRC Ancestor'); ?>&nbsp;</th>
        <th class="fieldnameback fieldname whitespace-no-wrap">&nbsp;<?php echo _('Test Group'); ?>&nbsp;</th>
        <?php if ($numtrees > 1) { ?>
            <th class="fieldnameback fieldname">&nbsp;<?php echo _('Tree'); ?>&nbsp;</th><?php } ?>
    </tr>
    </thead>
    <?php
    $i = $offsetplus;
    while ($row = tng_fetch_assoc($result)) {
        if ($row['private_test'] && ($allow_private) || (!$row['private_test'])) {
            $query = "SELECT description FROM $dna_groups_table WHERE dna_group=\"{$row['dna_group']}\"";
            $descresult = tng_query($query);
            $descrow = tng_fetch_assoc($descresult);
            tng_free_result($descresult);
            $group = $row['dna_group'] ? $descrow['description'] : _('No encryption');

            echo "<tr><td class='databack'>$i</td>\n";
            if ($test_type && $test_type != "X-DNA") {
                echo "<td class='databack text-center'><input type='checkbox' name=\"dna{$row['testID']}\" value='1'></td>";
            }
            $dash = ($row['test_type'] == "Y-DNA") ? "-" : "";
            echo "<td class='databack'><a href=\"show_dna_test.php?group=$group&amp;testID={$row['testID']}&amp;tree={$row['gedcom']}\">{$row['test_type']}$dash{$row['markers']}</a>&nbsp;</td>";
            if ($allow_edit || $showtestnumbers) {
                if ($row['private_test']) {
                    $privtest = "<br>&nbsp;(" . _('Private') . ")";
                } else {
                    $privtest = "";
                }
                echo "<td class='databack'><a href=\"show_dna_test.php?group=$group&amp;testID={$row['testID']}&amp;tree={$row['gedcom']}\">{$row['test_number']}</a>&nbsp;$privtest</td>";
            }
            $haplogroup = "&nbsp;";
            if ($row['ydna_haplogroup'] && $row['test_type'] == "Y-DNA") {
                if ($row['ydna_confirmed']) {
                    $haplogroup = "<span class='confirmed_haplogroup'>" . $row['ydna_haplogroup'] . "</span>";
                } else {
                    $haplogroup = "<span class='predicted_haplogroup'>" . $row['ydna_haplogroup'] . "</span>";
                }
            }
            if ($row['mtdna_haplogroup'] && $row['test_type'] == "mtDNA") {
                if ($row['mtdna_confirmed']) {
                    $haplogroup = "<span class='confirmed_haplogroup'>" . $row['mtdna_haplogroup'] . "</span>";
                } else {
                    $haplogroup = "<span class='predicted_haplogroup'>" . $row['mtdna_haplogroup'] . "</span>";
                }
            }
            if ($row['test_type'] == "atDNA") {
                if ($row['ydna_haplogroup']) {
                    $haplogroup = "Y = " . $row['ydna_haplogroup'] . "<br>";
                }
                if ($row['mtdna_haplogroup']) {
                    $haplogroup .= "mt = " . $row['mtdna_haplogroup'];
                }
            }
            echo "<td class='databack whitespace-no-wrap'>&nbsp;$haplogroup</td>";

            $dna_pers_result = getPersonDataPlusDates($row['gedcom'], $row['personID']);
            $dprow = tng_fetch_assoc($dna_pers_result);
            $dna_righttree = checktree($dprow['gedcom']);
            $dna_rightbranch = $dna_righttree ? checkbranch($dprow['branch']) : false;
            $dprights = determineLivingPrivateRights($dprow, $dna_righttree, $dna_rightbranch);
            $dprow['allow_living'] = $dprights['living'];
            $dprow['allow_private'] = $dprights['private'];
            $dbname = getName($dprow);
            $person_name = $row['person_name'];
            $dna_namestr = getName($dprow);
            if ($row['private_dna'] && $allow_edit) {
                $privacy = "&nbsp;(" . _('Private') . ")";
            } else {
                $privacy = "";
            }
            if ($dbname) {
                //$dna_namestr .= " ({$row['personID']})";
                $vitalinfo = $dprights['both'] ? getBirthInfo($dprow) : "";
                $dna_namestr = "<a href=\"getperson.php?personID={$row['personID']}&tree={$row['gedcom']}\">$dna_namestr</a>$privacy<br>" . str_replace(', ', '  -', trim(ltrim($vitalinfo, ",  ")));
            } else {
                $dna_namestr = $person_name . $privacy;
            }
            if ($row['private_dna'] && !$allow_edit) {
                $dna_namestr = _('Private');
            }
            tng_free_result($dna_pers_result);

            //query the links table
            $query = "SELECT $dna_links_table.personID, lastname, lnprefix, firstname, birthdate, birthdatetr, altbirthdate, altbirthdatetr, altbirthplace,
		deathdate, deathdatetr,
		IF(birthdatetr !='0000-00-00',birthdatetr,altbirthdatetr) as birth,
		IF(deathdatetr !='0000-00-00',deathdatetr,burialdatetr) as death,
		prefix, suffix, nameorder, $dna_links_table.gedcom, branch, living, private
		FROM $dna_links_table, $people_table
		WHERE testID = \"{$row['testID']}\" AND $dna_links_table.personID = $people_table.personID AND $dna_links_table.gedcom = $people_table.gedcom
		ORDER BY birth DESC, lastname, firstname LIMIT $maxsearchresults";
            $presult = tng_query($query);
            $numrows = tng_num_rows($presult);
            $dnalinktext = "";
            $counter = 1;
            while ($prow = tng_fetch_assoc($presult)) {
                if ($prow['personID'] != $row['personID'] || $prow['gedcom'] != $row['gedcom']) {
                    if ($dnalinktext) $dnalinktext .= "<br>\n";

                    $righttree = checktree($prow['gedcom']);
                    $rightbranch = $righttree ? checkbranch($prow['branch']) : false;
                    $rights = determineLivingPrivateRights($prow, $righttree, $rightbranch);
                    $name = "$counter. ";
                    if (!$rights['living']) {
                        $name .= _('Living');
                    } elseif (!$rights['private']) {
                        $name .= _('Private');
                    } else {
                        $prow['allow_living'] = $rights['living'];
                        $prow['allow_private'] = $rights['private'];
                        $vitalinfo = $rights['both'] ? getBirthInfo($prow) : "";
                        $name .= "<a href=\"getperson.php?personID={$prow['personID']}&amp;tree={$prow['gedcom']}\">" . getName($prow) . "</a><br>" . str_replace(', ', '  -', trim(ltrim($vitalinfo, ",  ")));
                    }
                    $counter++;
                    $dnalinktext .= $name;
                }
            }
            tng_free_result($presult);

            if ($dnalinktext) {
                $more = "<a href='#' onclick=\"\$('#more_{$row['testID']}').slideToggle();return false;\" title=\"" . _('More individuals') . "\">";
                $more .= buildSvgElement("img/chevron-down.svg", ["class" => "w-3 h-3 ml-2 fill-current inline-block"]);
                $more .= "</a> ";
                $morediv = "<div style='display: none;' id=\"more_{$row['testID']}\"><hr class=\"mtitlehr\"><strong>" . _('Linked to') . ":</strong><br>$dnalinktext</div>";
            } else {
                $more = $morediv = "";
            }

            echo "<td class='databack'>$more$dna_namestr&nbsp;$morediv</td>";
            $mdanc_namestr = "";
            if ($row['MD_ancestorID']) {
                $dna_anc_result = getPersonDataPlusDates($row['gedcom'], $row['MD_ancestorID']);
                $ancrow = tng_fetch_assoc($dna_anc_result);
                $dna_righttree = checktree($ancrow['gedcom']);
                $dna_rightbranch = $dna_righttree ? checkbranch($ancrow['branch']) : false;
                $dprights = determineLivingPrivateRights($ancrow, $dna_righttree, $dna_rightbranch);
                $ancrow['allow_living'] = $dprights['living'];
                $ancrow['allow_private'] = $dprights['private'];
                $vitalinfo = getBirthInfo($ancrow);
                $anc_namestr = getName($ancrow);
                $mdanc_namestr = "<a href=\"getperson.php?personID={$row['MD_ancestorID']}&tree={$row['gedcom']}\">$anc_namestr</a>" . "<br>" . str_replace(', ', '  -', trim(ltrim($vitalinfo, ",  ")));

                tng_free_result($dna_anc_result);
            }
            $mrcanc_namestr = "";
            if ($row['MRC_ancestorID']) {
                if ($row['MRC_ancestorID'][0] == "I") {
                    $dna_anc_result = getPersonDataPlusDates($row['gedcom'], $row['MRC_ancestorID']);
                    $ancrow = tng_fetch_assoc($dna_anc_result);
                    $dna_righttree = checktree($ancrow['gedcom']);
                    $dna_rightbranch = $dna_righttree ? checkbranch($ancrow['branch']) : false;
                    $dprights = determineLivingPrivateRights($ancrow, $dna_righttree, $dna_rightbranch);
                    $ancrow['allow_living'] = $dprights['living'];
                    $ancrow['allow_private'] = $dprights['private'];
                    $vitalinfo = getBirthInfo($ancrow);
                    $anc_namestr = getName($ancrow);
                    $mrcanc_namestr = "<a href=\"getperson.php?personID={$row['MRC_ancestorID']}&tree={$row['gedcom']}\">$anc_namestr</a>" . "<br>" . str_replace(', ', '  -', trim(ltrim($vitalinfo, ",  ")));
                    tng_free_result($dna_anc_result);
                } else {
                    if ($row['MRC_ancestorID'][0] == "F") {
                        $mrcquery = "SELECT familyID, husband, wife, living, private, marrdate, gedcom, branch FROM $families_table WHERE familyID = \"{$row['MRC_ancestorID']}\" AND gedcom = \"{$row['gedcom']}\"";
                        $mrcresult = tng_query($mrcquery);
                        $famrow = tng_fetch_assoc($mrcresult);
                        tng_free_result($mrcresult);

                        $righttree = checktree($row['gedcom']);
                        $rightbranch = checkbranch($famrow['branch']);
                        $rights = determineLivingPrivateRights($famrow, $righttree, $rightbranch);
                        $famrow['allow_living'] = $rights['living'];
                        $famrow['allow_private'] = $rights['private'];

                        $famname = getFamilyName($famrow);
                        $fammarried = "<br>&nbsp;&nbsp;<strong>" . _('m.') . "</strong>&nbsp;" . $famrow['marrdate'];
                        $mrcanc_namestr = "<a href=\"familygroup.php?familyID={$row['MRC_ancestorID']}&tree={$row['gedcom']}\">$famname</a>" . $fammarried;
                    }
                }
            }
            echo "<td class='databack'>&nbsp;$mdanc_namestr</td>";
            echo "<td class='databack'>&nbsp;$mrcanc_namestr</td>";
            echo "<td class='databack'>$group</td>";
            if ($numtrees > 1) {
                echo "<td class='databack whitespace-no-wrap'><a href=\"showtree.php?tree={$row['gedcom']}\">{$row['treename']}</a>&nbsp;</td>";
            }
            echo "</tr>\n";
            $i++;
        }
    }
    tng_free_result($result);
    ?>
</form>
</table>
<br>
</div>
<?php
if ($pagenav || $testsearch) {
    echo doTestSearch(2, $pagenav) . "<br>\n";
}

tng_footer("");
?>
