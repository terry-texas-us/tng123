<?php

include "begin.php";
include "adminlib.php";
require_once "admin/pagination.php";
include "personlib.php";
include "tngdblib.php";

$admin_login = true;
include "checklogin.php";
include "version.php";
function get_test_groups($test_type, $test_group) {
    global $admtext, $dna_groups_table;
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

if ($newsearch) {
    $exptime = 0;
    $searchstring = stripslashes(trim($searchstring));
    setcookie("tng_search_dna_post[search]", $searchstring, $exptime);
    setcookie("tng_search_dna_post[test_type]", $test_type, $exptime);
    setcookie("tng_search_dna_post[test_group]", $test_group, $exptime);
    setcookie("tng_search_dna_post[tree]", $tree, $exptime);
    setcookie("tng_search_dna_post[tngpage]", 1, $exptime);
    setcookie("tng_search_dna_post[offset]", 0, $exptime);
} else {
    if (!$searchstring) {
        $searchstring = stripslashes($_COOKIE['tng_search_dna_post']['search']);
    }
    if (!$test_type) {
        $test_type = $_COOKIE['tng_search_dna_post']['test_type'];
    }
    if (!$test_group) {
        $test_group = $_COOKIE['tng_search_dna_post']['test_group'];
    }
    if (!$tree) $tree = $_COOKIE['tng_search_dna_post']['tree'];

    if (!isset($offset)) {
        $tngpage = $_COOKIE['tng_search_dna_post']['tngpage'];
        $offset = $_COOKIE['tng_search_dna_post']['offset'];
    } else {
        $exptime = 0;
        setcookie("tng_search_dna_post[tngpage]", $tngpage, $exptime);
        setcookie("tng_search_dna_post[offset]", $offset, $exptime);
    }
}

if ($offset) {
    $offsetplus = $offset + 1;
    $newoffset = "$offset, ";
} else {
    $offsetplus = 1;
    $newoffset = "";
    $tngpage = 1;
}

if ($assignedtree) {
    $wherestr = "WHERE gedcom = '$assignedtree'";
    $wherestr2 = " AND $dna_links_table.gedcom = '$assignedtree'";
} else {
    $wherestr = "";
    if ($tree) $wherestr2 = " AND $dna_links_table.gedcom = '$tree'";

}
$orgwherestr = $wherestr;
$orgtree = $tree;

$originalstring = preg_replace("/\"/", "&#34;", $searchstring);
$searchstring = addslashes($searchstring);
$wherestr = $searchstring ? "(test_number LIKE \"%$searchstring%\" OR vendor LIKE \"%$searchstring%\" OR urls LIKE \"%$searchstring%\" OR notes LIKE \"%$searchstring%\" OR dna_group LIKE \"%$searchstring%\" OR dna_group_desc LIKE \"%$searchstring%\" OR surnames LIKE \"%$searchstring%\" OR ydna_haplogroup LIKE \"%$searchstring%\" OR mtdna_haplogroup LIKE \"%$searchstring%\")" : "";
if ($assignedtree) {
    $wherestr .= $wherestr ? " AND (dna_tests.gedcom = '$tree' || dna_tests.gedcom = \"\")" : "(dna_tests.gedcom = '$tree' || dna_tests.gedcom = \"\")";
} elseif ($tree) {
    $wherestr .= $wherestr ? " AND dna_tests.gedcom = '$tree'" : "dna_tests.gedcom = '$tree'";
}
if ($test_type) {
    $wherestr .= $wherestr ? " AND test_type = \"$test_type\"" : "test_type = \"$test_type\"";
}
if ($test_group) {
    $wherestr .= $wherestr ? " AND dna_group_desc = \"$test_group\"" : "dna_group_desc = \"$test_group\"";
}
if ($wherestr) $wherestr = "WHERE $wherestr";


$query = "SELECT testID, test_type, test_date, match_date, ydna_haplogroup, mtdna_haplogroup, dna_tests.personID, dna_tests.gedcom, test_number, firstname, lastname, lnprefix, nameorder, suffix, prefix, title, person_name, mtdna_confirmed, ydna_confirmed, markeropt, notesopt, linksopt, surnamesopt, private_dna, private_test, dna_group, dna_group_desc, surnames, MD_ancestorID, MRC_ancestorID ";
$query .= "FROM $dna_tests_table dna_tests ";
$query .= "LEFT JOIN $people_table people ON people.personID = dna_tests.personID AND people.gedcom = dna_tests.gedcom ";
$query .= "$wherestr ";
$query .= "ORDER BY match_date DESC, test_number ASC ";
$query .= "LIMIT $newoffset" . $maxsearchresults;
$result = tng_query($query);

$numrows = tng_num_rows($result);
if ($numrows == $maxsearchresults || $offsetplus > 1) {
    $query = "SELECT count($dna_tests_table.testID) AS tcount FROM $dna_tests_table $wherestr";
    $result2 = tng_query($query);
    $row = tng_fetch_assoc($result2);
    $totrows = $row['tcount'];
    tng_free_result($result2);
} else {
    $totrows = $numrows;
}

$helplang = findhelp("dna_help.php");

tng_adminheader(_('DNA Tests'), $flags);
?>
<script>
    var tnglitbox;
    var allow_edit = <?php echo($allow_edit ? "1" : "0"); ?>;
    var allow_delete = <?php echo($allow_delete ? "1" : "0"); ?>;

    function resetForm() {
        document.form1.searchstring.value = '';
        document.form1.tree.selectedIndex = 0;
        document.form1.test_type.selectedIndex = 0;
        document.form1.test_group.selectedIndex = 0;
    }

    function confirmDelete(testID) {
        if (confirm('<?php echo _("Are you sure you want to delete this test?"); ?>')) {
            deleteIt('dna', testID);
        }
        return false;
    }
</script>

<?php
echo "</head>\n";
echo tng_adminlayout();

$dnatabs[0] = [1, "admin_dna_tests.php", _('Search'), "findtest"];
$dnatabs[1] = [$allow_add, "admin_new_dna_test.php", _('Add New'), "addtest"];
$dnatabs[2] = [$allow_add, "admin_dna_groups.php", _('DNA Groups'), "dnagroups"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/dna_help.php#modify');\" class='lightlink'>" . _('Help for this area') . "</a>";
$menu = doMenu($dnatabs, "findtest", $innermenu);
echo displayHeadline(_('DNA Tests'), "img/dna_icon.gif", $menu, $message);
?>

    <table class="lightback">
        <tr class="databack">
            <td class="tngshadow">
                <div class="normal">

                    <form action="admin_dna_tests.php" name="form1" id="form1">
                    <table class="normal">
                        <tr>
                            <td>
                                <?php
                                $newwherestr = $wherestr;
                                $wherestr = $orgwherestr;
                                $query = "SELECT gedcom, treename FROM $trees_table ORDER BY treename";
                                $treeresult = tng_query($query);
                                $numtrees = tng_num_rows($treeresult);
                                if ($numtrees > 1) {
                                    echo _('Tree') . ": ";
                                    $ret = "";
                                    $ret .= "<select name='tree' id='tree' onchange=\"jQuery('#treespinner').show();document.form1.submit();\">\n";
                                    $ret .= "<option value=\"\" ";
                                    if (!$tree) $ret .= "selected";

                                    $ret .= ">" . _('All Trees') . "</option>\n";

                                    while ($row2 = tng_fetch_assoc($treeresult)) {
                                        $ret .= "<option value=\"{$row2['gedcom']}\"";
                                        if ($tree && $row2['gedcom'] == $tree) {
                                            $ret .= " selected";
                                        }
                                        $ret .= ">{$row2['treename']}</option>\n";
                                    }
                                    $ret .= "</select>\n";
                                    tng_free_result($treeresult);
                                    $ret .= "&nbsp; <img src=\"img/spinner.gif\" style='display: none;' id=\"treespinner\" alt=\"\" class=\"spinner\">\n";
                                    echo $ret;
                                }
                                echo _('Test Type') . ": ";
                                $wherestr = $newwherestr;
                                ?>
                                <select name="test_type" id="test_type"
                                    onchange="jQuery('#treespinner2').show();document.form1.test_group.selectedIndex = 0;document.form1.submit();">
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
                                </select>&nbsp;<img src="img/spinner.gif" style="display:none;" id="treespinner2" alt="" class="spinner">&nbsp;
                                <?php echo _('Test Group'); ?>:
                                <select name="test_group" id="test_group" onchange="jQuery('#treespinner3').show();document.form1.submit();">
                                    <?php echo get_test_groups($test_type, $test_group); ?>
                                </select>&nbsp;<img src="img/spinner.gif" style="display:none;" id="treespinner3" alt="" class="spinner">
                            </td>
                        </tr>
                        <tr>
                            <td><br><?php echo _('Search for'); ?>:
                                <input name="searchstring" type="search" value="<?php echo $originalstring; ?>">&nbsp;
                                <input type="submit" name="submit2" value="<?php echo _('Search'); ?>" class="align-top">&nbsp;&nbsp;
                                <input type="submit" name="reset" value="<?php echo _('Reset'); ?>" class="align-top"
                                    onclick="document.form1.searchstring.value=''; document.form1.tree.selectedIndex=0; document.form1.test_type.selectedIndex = 0; document.form1.test_group.selectedIndex = 0;">
                            </td>
                        </tr>
                    </table>

                        <input type="hidden" name="findtest" value="1">
                        <input type="hidden" name="newsearch" value="1">
                    </form>
                    <?php
                    $numrowsplus = $numrows + $offset;
                if (!$numrowsplus) $offsetplus = 0;
                ?>
                <form action="admin_updateselecteddna.php" method="post" name="form2">
                    <?php if ($allow_media_delete || $allow_media_edit) { ?>
                        <p class="whitespace-no-wrap">
                            <input type="button" name="selectall" value="<?php echo _('Select All'); ?>" onClick="toggleAll(1);">
                            <input type="button" name="clearall" value="<?php echo _('Clear All'); ?>" onClick="toggleAll(0);">&nbsp;&nbsp;
                            <?php if ($allow_delete) { ?>
                                <input type="submit" name="xdnaaction" value="<?php echo _('Delete Selected'); ?>"
                                    onClick="return confirm('<?php echo _('Are you sure you want to delete the selected records?'); ?>');">&nbsp;&nbsp;
                            <?php } ?>
                        </p>
                    <?php } ?>

                    <table class="normal">
                        <tr>
                            <th class="fieldnameback fieldname"><?php echo _('Action'); ?></th>
                            <?php if ($allow_edit || $allow_delete) { ?>
                                <th class="fieldnameback fieldname"><?php echo _('Select'); ?></th>
                            <?php } ?>
                            <th class="fieldnameback fieldname"><?php echo _('Test Type'); ?></th>
                            <th class="fieldnameback fieldname"><?php echo _('Test Number/Name'); ?></th>
                            <th class="fieldnameback fieldname"><?php echo _('Match Date'); ?></th>
                            <th class="fieldnameback fieldname"><?php echo _('Name'); ?></th>
                            <th class="fieldnameback fieldname"><?php echo _('Most distant ancestor'); ?></th>
                            <th class="fieldnameback fieldname"><?php echo _('MRC Ancestor'); ?></th>
                            <th class="fieldnameback fieldname"><?php echo _('Test Privacy'); ?></th>
                            <th class="fieldnameback fieldname"><?php echo _('Name Privacy'); ?></th>
                            <th class="fieldnameback fieldname"><?php echo _('Test Group'); ?></th>
                            <th class="fieldnameback fieldname"><?php echo _('Tree'); ?></th>
                        </tr>
                        <?php
                        if ($numrows) {
                        $actionstr = "";
                        if ($allow_edit) {
                            $actionstr .= "<a href=\"admin_edit_dna_test.php?testID=xxx\" title=\"" . _('Edit') . "\" class='smallicon admin-edit-icon'></a>";
                        }
                        if ($allow_delete) {
                            $actionstr .= "<a href='#' onclick=\"return confirmDelete('xxx');\" title=\"" . _('Delete') . "\" class='smallicon admin-delete-icon'></a>";
                        }
                        $actionstr .= "<a href=\"show_dna_test.php?testID=xxx\" target='_blank' title=\"" . _('Test') . "\" class='smallicon admin-test-icon'></a>";

                        while ($row = tng_fetch_assoc($result)) {
                            $newactionstr = preg_replace("/xxx/", $row['testID'], $actionstr);
                            echo "<tr id=\"row_{$row['testID']}\">\n";
                            echo "<td class='lightback'><div class='action-btns'>$newactionstr</div></td>\n";
                            if ($allow_edit || $allow_delete) {
                                echo "<td class='lightback text-center'><input type='checkbox' name=\"dna{$row['testID']}\" value='1'></td>";
                            }
                            $rights = determineLivingPrivateRights($row);
                            $row['allow_living'] = $rights['living'];
                            $row['allow_private'] = $rights['private'];
                            echo "<td class='lightback'>&nbsp;{$row['test_type']}</td>\n";
                            echo "<td class='lightback'>&nbsp;{$row['test_number']}</td>\n";
                            if ($row['match_date'] && $row['match_date'] != "0000-00-00") {
                                $match_date = formatInternalDate($row['match_date']);
                                echo "<td class='lightback'>&nbsp;$match_date</td>\n";
                            } else {
                                echo "<td class='lightback'>&nbsp;</td>\n";
                            }
                            $dbname = getName($row);
                            if ($dbname) {
                                echo "<td class='lightback'>" . $dbname . "</td>\n";
                            } else {
                                echo "<td class='lightback'>" . $row['person_name'] . "<br>&nbsp;" . _('Person not in database') . "</td>\n";
                            }

                            $mdanc_namestr = "";
                            if ($row['MD_ancestorID']) {
                                $dna_anc_result = getPersonDataPlusDates($row['gedcom'], $row['MD_ancestorID']);
                                $ancrow = tng_fetch_assoc($dna_anc_result);
                                $dna_righttree = checktree($row['gedcom']);
                                $dna_rightbranch = $dna_righttree ? checkbranch($row['branch']) : false;
                                $dprights = determineLivingPrivateRights($ancrow, $dna_righttree, $dna_rightbranch);
                                $ancrow['allow_living'] = $dprights['living'];
                                $ancrow['allow_private'] = $dprights['private'];
                                $vitalinfo = getBirthInfo($ancrow);
                                $mdanc_namestr = getName($ancrow) . "<br>" . str_replace(', ', '  -', trim(ltrim($vitalinfo, ",  ")));

                                tng_free_result($dna_anc_result);
                            }
                            $mrcanc_namestr = "";
                            if ($row['MRC_ancestorID']) {
                                if ($row['MRC_ancestorID'][0] == $tngconfig['personprefix']) {
                                    $dna_anc_result = getPersonDataPlusDates($row['gedcom'], $row['MRC_ancestorID']);
                                    $ancrow = tng_fetch_assoc($dna_anc_result);
                                    $ancrow['allow_living'] = $ancrow['allow_private'] = 1;
                                    $vitalinfo = getBirthInfo($ancrow);
                                    $mrcanc_namestr = getName($ancrow) . "<br>" . str_replace(', ', '  -', trim(ltrim($vitalinfo, ",  ")));

                                    tng_free_result($dna_anc_result);
                                } else {
                                    if ($row['MRC_ancestorID'][0] == $tngconfig['familyprefix']) {
                                        $mrcaquery = "SELECT familyID, husband, wife, living, private, marrdate, gedcom, branch FROM $families_table WHERE familyID = \"{$row['MRC_ancestorID']}\" AND gedcom = \"{$row['gedcom']}\"";
                                        $dna_anc_result = tng_query($mrcaquery);
                                        $ancrow = tng_fetch_assoc($dna_anc_result);
                                        tng_free_result($dna_anc_result);

                                        $ancrow['allow_living'] = $ancrow['allow_private'] = 1;

                                        $famname = getFamilyName($ancrow);
                                        $fammarried = "<br>&nbsp;&nbsp;<strong>" . _('m.') . "</strong>&nbsp;" . $ancrow['marrdate'];
                                        $mrcanc_namestr = $famname . $fammarried;
                                    }
                                }
                            }
                            $privtest = $row['private_test'] ? _('Private') : "&nbsp;";
                            $privacy = $row['private_dna'] ? _('Private') : _('General Settings');
                            $query = "SELECT description FROM $dna_groups_table WHERE dna_group=\"{$row['dna_group']}\"";
                            $descresult = tng_query($query);
                            $descrow = tng_fetch_assoc($descresult);
                            tng_free_result($descresult);
                            $group = $row['dna_group'] ? $descrow['description'] : _('No encryption');
                            echo "<td class='lightback'>" . $mdanc_namestr . "</td>\n";
                            echo "<td class='lightback'>" . $mrcanc_namestr . "</td>\n";
                            echo "<td class='lightback'>" . $privtest . "</td>\n";
                            echo "<td class='lightback'>" . $privacy . "</td>\n";
                            echo "<td class='lightback'>" . $group . "</td>\n";
                            echo "<td class='lightback'>" . $row['gedcom'] . "</td>\n";
                            echo "</tr>\n";
                        }
                        ?>
                    </table>
                <?php
                echo "<div class='w-full class=lg:flex my-6'>";
                echo getPaginationLocationHtml($offsetplus, $numrowsplus, $totrows);
                echo getPaginationControlsHtml($totrows, "admin_dna_tests.php?searchstring=$searchstring&amp;test_type=$test_type&amp;test_group=$test_group&amp;offset", $maxsearchresults, 3);
                echo "</div>";
                }
                else {
                    echo "</table>\n" . _('No records exist.');
                }
                tng_free_result($result);
                ?>
                </form>

            </div>
        </td>
    </tr>
</table>
<?php echo tng_adminfooter(); ?>