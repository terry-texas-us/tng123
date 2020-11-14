<?php

include "begin.php";
include "adminlib.php";
require_once "admin/pagination.php";
$textpart = "dna";
include "$mylanguage/admintext.php";
$admin_login = 1;
include "checklogin.php";
include "version.php";
if (!$allow_delete || ($assignedtree && $assignedtree != $tree)) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

function getGroupCount($tree, $group, $table) {
    $query = "SELECT count(dna_group) AS count FROM $table WHERE gedcom = '$tree' and dna_group = \"$group\"";
    $result = tng_query($query);
    $row = tng_fetch_assoc($result);
    $count = $row['count'];
    if (!$count) $count = "0";

    tng_free_result($result);

    return $count;
}

$tng_search_groups = $_SESSION['tng_search_groups'] = 1;
if ($newsearch) {
    $exptime = 05;
    setcookie("tng_search_groups_post[tree]", $tree, $exptime);
    setcookie("tng_search_groups_post[tngpage]", 1, $exptime);
    setcookie("tng_search_groups_post[offset]", 0, $exptime);
} else {
    if (!$tree) $tree = $_COOKIE['tng_search_groups_post']['tree'];

    if (!isset($offset)) {
        $tngpage = $_COOKIE['tng_search_groups_post']['tngpage'];
        $offset = $_COOKIE['tng_search_groups_post']['offset'];
    } else {
        $exptime = 0;
        setcookie("tng_search_groups_post[tngpage]", $tngpage, $exptime);
        setcookie("tng_search_groups_post[offset]", $offset, $exptime);
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
    $tree = $assignedtree;
} else {
    $wherestr = "";
}
$orgtree = $tree;
$treequery = "SELECT gedcom, treename FROM $trees_table $wherestr ORDER BY treename";

$wherestr = "";
if ($tree) $wherestr .= "WHERE dna_groups.gedcom = '$tree'";

$query = "SELECT dna_groups.gedcom AS gedcom, dna_group, dna_groups.description AS description, test_type, treename ";
$query .= "FROM $dna_groups_table dna_groups ";
$query .= "LEFT JOIN $trees_table trees ON trees.gedcom = dna_groups.gedcom ";
$query .= "$wherestr ";
$query .= "ORDER BY dna_groups.description ";
$query .= "LIMIT $newoffset" . $maxsearchresults;
$result = tng_query($query);

$numrows = tng_num_rows($result);
if ($numrows == $maxsearchresults || $offsetplus > 1) {
    $query = "SELECT count(dna_group) AS gcount ";
    $query .= "FROM $dna_groups_table dna_groups ";
    $query .= "LEFT JOIN $trees_table trees ON trees.gedcom = dna_groups.gedcom ";
    $query .= "$wherestr";
    $result2 = tng_query($query);
    $row = tng_fetch_assoc($result2);
    $totrows = $row['gcount'];
    tng_free_result($result2);
} else {
    $totrows = $numrows;
}

$helplang = findhelp("dna_help.php");

tng_adminheader(_('DNA Groups'), $flags);
?>
    <script>
        function confirmDelete(ID, tree) {
            if (confirm('<?php echo _('Are you sure you want to delete this group?'); ?>'))
                deleteIt('dnagroup', ID, tree);
            return false;
        }
    </script>

<?php
echo "</head>\n";
echo tng_adminlayout();

$dnatabs['0'] = [1, "admin_dna_groups.php", _('Search'), "findgroup"];
$dnatabs['1'] = [$allow_add, "admin_new_dna_group.php", _('Add New'), "addgroup"];
$dnatabs['2'] = [1, "admin_dna_tests.php", _('DNA Tests'), "findtest"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/dna_help.php');\" class='lightlink'>" . _('Help for this area') . "</a>";
$menu = doMenu($dnatabs, "findgroup", $innermenu);
echo displayHeadline(_('DNA Groups'), "img/dna_icon.gif", $menu, $message);
?>

    <table class="lightback">
        <tr class="databack">
            <td class="tngshadow">
                <div class="normal">

                    <form action="admin_dna_groups.php" name="form1" id="form1">
                        <table>
                            <tr>
                                <td><span class="normal"><?php echo _('Tree'); ?>: </span></td>
                                <td>
                                    <select name="tree">
                                        <?php
                                        if (!$assignedtree) echo "<option value=''>" . _('All Trees') . "</option>\n";
                                        $treeresult = tng_query($treequery) or die (_('Cannot execute query') . ": $treequery");
                                        while ($treerow = tng_fetch_assoc($treeresult)) {
                                            echo "	<option value=\"{$treerow['gedcom']}\"";
                                            if ($treerow['gedcom'] == $tree) echo " selected";

                                            echo ">{$treerow['treename']}</option>\n";
                                        }
                                        tng_free_result($treeresult);
                                        ?>
                                    </select>
                                </td>
                                <td>
                                    <input type="submit" name="submit" value="<?php echo _('Search'); ?>" class="align-top">
                                    <input type="submit" name="submit" value="<?php echo _('Reset'); ?>" onClick="document.form1.tree.selectedIndex=0;" class="align-top">
                                </td>
                            </tr>
                        </table>

                        <input type="hidden" name="findgroup" value="1">
                        <input type="hidden" name="newsearch" value="1">
                    </form>

                    <?php
                    $numrowsplus = $numrows + $offset;
                    if (!$numrowsplus) $offsetplus = 0;
                    ?>
                    <form action="admin_updateselectedgroup.php" method="post" name="form2">
                        <p class="whitespace-no-wrap">
                            <input type="button" name="selectall" value="<?php echo _('Select All'); ?>" onClick="toggleAll(1);">
                            <input type="button" name="clearall" value="<?php echo _('Clear All'); ?>" onClick="toggleAll(0);">
                            <input type="submit" name="xdnagroupaction" value="<?php echo _('Delete Selected'); ?>"
                                onClick="return confirm('<?php echo _('Are you sure you want to delete the selected records?'); ?>');">
                        </p>
                        <table class="normal">
                            <tr class="fieldnameback fieldname whitespace-no-wrap">
                                <th><?php echo _('Action'); ?></th>
                                <th><span class="fieldname"><?php echo _('Select'); ?></span></th>
                                <th><?php echo _('Group ID'); ?></th>
                                <th><?php echo _('Description'); ?></th>
                                <th><?php echo _('Tree'); ?></th>
                                <th><?php echo _('Test Type'); ?></th>
                                <th><?php echo _('DNA Tests'); ?></th>
                            </tr>

                            <?php
                            if ($numrows) {
                            $actionstr = "";
                            if ($allow_edit) {
                                $actionstr .= "<a href=\"admin_edit_dna_group.php?dna_group=xxx&amp;tree=yyy&amp;test_type=zzz\" class='smallicon admin-edit-icon' title=\"" . _('Edit') . "\"></a>";
                            }
                            if (!$assignedtree) {
                                $actionstr .= "<a href='#' class='smallicon admin-delete-icon' title=\"" . _('Delete') . "\" onClick=\"return confirmDelete('xxx','yyy');\"></a>";
                        }

                        while ($row = tng_fetch_assoc($result)) {
                            $newactionstr = preg_replace("/xxx/", $row['dna_group'], $actionstr);
                            $newactionstr = preg_replace("/yyy/", $row['gedcom'], $newactionstr);
                            $newactionstr = preg_replace("/zzz/", $row['test_type'], $newactionstr);
                            echo "<tr id=\"row_{$row['dna_group']}\">";
                            echo "<td class='lightback'><div>$newactionstr</div></td>\n";
                            echo "<td class='lightback text-center'><input type='checkbox' name=\"dna{$row['dna_group']}\" value='1'></td>";
                            $editlink = "admin_edit_dna_group.php?dna_group={$row['dna_group']}&tree={$row['gedcom']}";
                            $id = $allow_edit ? "<a href=\"$editlink\" title=\"" . _('Edit') . "\">" . $row['dna_group'] . "</a>" : $row['dna_group'];

                            echo "<td class='lightback' nowrap>&nbsp;{$row['dna_group']}</td>\n";
                            echo "<td class='lightback'>&nbsp;{$row['description']}</td>\n";
                            echo "<td class='lightback'>&nbsp;{$row['treename']}&nbsp;</td>\n";
                            echo "<td class='lightback'>{$row['test_type']}&nbsp;</td>\n";
                            $pcount = getGroupCount($row['gedcom'], $row['dna_group'], $dna_tests_table);
                            echo "<td class='lightback' style=\"text-align:right;\">$pcount&nbsp;</td>\n";
                            echo "</tr>\n";
                        }
                        tng_free_result($result);
                        ?>
                    </table>
                    <?php
                    echo "<div class='w-full class=lg:flex my-6'>";
                    echo getPaginationLocationHtml($offsetplus, $numrowsplus, $totrows);
                    echo getPaginationControlsHtml($totrows, "admin_dna_groups.php?offset", $maxsearchresults, 3);
                    echo "</div>";
                    }
                    else {
                        echo _('No tree records exist');
                    }
                    ?>
            </div>
        </td>
    </tr>

</table>
<?php echo tng_adminfooter(); ?>