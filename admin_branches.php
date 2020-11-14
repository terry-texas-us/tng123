<?php

include "begin.php";
include "adminlib.php";
require_once "admin/pagination.php";
$textpart = "branches";
include "$mylanguage/admintext.php";
$admin_login = 1;
include "checklogin.php";
include "version.php";
if ($assignedbranch) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

function getBranchCount($tree, $branch, $table) {
    $query = "SELECT count(ID) AS count FROM $table WHERE gedcom = '$tree' and branch LIKE \"%$branch%\"";
    $result = tng_query($query);
    $row = tng_fetch_assoc($result);
    $count = $row['count'];
    if (!$count) $count = "0";

    tng_free_result($result);

    return $count;
}

$tng_search_branches = $_SESSION['tng_search_branches'] = 1;
if ($newsearch) {
    $exptime = 05;
    $searchstring = stripslashes(trim($searchstring));
    setcookie("tng_search_branches_post[search]", $searchstring, $exptime);
    setcookie("tng_tree", $tree, $exptime);
    setcookie("tng_search_branches_post[tngpage]", 1, $exptime);
    setcookie("tng_search_branches_post[offset]", 0, $exptime);
} else {
    if (!$searchstring) {
        $searchstring = $_COOKIE['tng_search_branches_post']['search'];
    }
    if (!$tree) $tree = $_COOKIE['tng_tree'];

    if (!isset($offset)) {
        $tngpage = $_COOKIE['tng_search_branches_post']['tngpage'];
        $offset = $_COOKIE['tng_search_branches_post']['offset'];
    } else {
        $exptime = 0;
        setcookie("tng_search_branches_post[tngpage]", $tngpage, $exptime);
        setcookie("tng_search_branches_post[offset]", $offset, $exptime);
    }
}
$searchstring_noquotes = preg_replace("/\"/", "&#34;", $searchstring);
$searchstring = addslashes($searchstring);

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

$wherestr = $searchstring ? "WHERE (branch LIKE \"%$searchstring%\" OR branches.description LIKE \"%$searchstring%\")" : "";
if ($tree) {
    $wherestr .= $wherestr ? " AND branches.gedcom = '$tree'" : "WHERE branches.gedcom = '$tree'";
}
$query = "SELECT branches.gedcom AS gedcom, branch, branches.description AS description, personID, treename ";
$query .= "FROM $branches_table branches ";
$query .= "LEFT JOIN $trees_table trees ON trees.gedcom = branches.gedcom ";
$query .= "$wherestr ";
$query .= "ORDER BY branches.description ";
$query .= "LIMIT $newoffset" . $maxsearchresults;
$result = tng_query($query);

$numrows = tng_num_rows($result);
if ($numrows == $maxsearchresults || $offsetplus > 1) {
    $query = "SELECT count(branch) AS bcount FROM $branches_table branches ";
    $query .= "LEFT JOIN $trees_table trees ON trees.gedcom = branches.gedcom ";
    $query .= "$wherestr";
    $result2 = tng_query($query);
    $row = tng_fetch_assoc($result2);
    $totrows = $row['bcount'];
    tng_free_result($result2);
} else {
    $totrows = $numrows;
}

$helplang = findhelp("branches_help.php");

tng_adminheader(_('Branches'), $flags);
?>
    <script>
        function confirmDelete(ID, tree) {
            if (confirm('<?php echo _('Are you sure you want to delete this branch?'); ?>'))
                deleteIt('branch', ID, tree);
            return false;
        }
    </script>

<?php
echo "</head>\n";
echo tng_adminlayout();

$branchtabs['0'] = [1, "admin_branches.php", _('Search'), "findbranch"];
$branchtabs['1'] = [$allow_add, "admin_newbranch.php", _('Add New'), "addbranch"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/branches_help.php');\" class='lightlink'>" . _('Help for this area') . "</a>";
$menu = doMenu($branchtabs, "findbranch", $innermenu);
echo displayHeadline(_('Branches'), "img/branches_icon.gif", $menu, $message);
?>

    <table class="lightback">
        <tr class="databack">
            <td class="tngshadow">
                <div class="normal">

                    <form action="admin_branches.php" name="form1" id="form1">
                        <table>
                            <tr>
                                <td><span class="normal"><?php echo _('Search for'); ?>: </span></td>
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
                                    <input class="longfield" name="searchstring" type="search" value="<?php echo $searchstring_noquotes; ?>">
                                </td>
                                <td>
                                    <input type="submit" name="submit" value="<?php echo _('Search'); ?>" class="align-top">
                                    <input type="submit" name="submit" value="<?php echo _('Reset'); ?>" onClick="document.form1.searchstring.value=''; document.form1.tree.selectedIndex=0;"
                                        class="align-top">
                                </td>
                            </tr>
                        </table>

                        <input type="hidden" name="findbranch" value="1">
                        <input type="hidden" name="newsearch" value="1">
                    </form>

                    <?php
                $numrowsplus = $numrows + $offset;
                if (!$numrowsplus) $offsetplus = 0;
                ?>
                    <form action="admin_deleteselected.php" method="post" name="form2">
                        <?php if ($allow_delete) { ?>
                            <p>
                                <input type="button" name="selectall" value="<?php echo _('Select All'); ?>" onClick="toggleAll(1);">
                                <input type="button" name="clearall" value="<?php echo _('Clear All'); ?>" onClick="toggleAll(0);">
                                <input type="submit" name="xbranchaction" value="<?php echo _('Delete Selected'); ?>" onClick="return confirm('<?php echo _('Are you sure you want to delete the selected records?'); ?>');">
                            </p>
                        <?php } ?>
                        <table class="normal">
                            <tr class="fieldnameback fieldname whitespace-no-wrap">
                                <th><?php echo _('Action'); ?></th>
                                <?php if ($allow_delete) { ?>
                                    <th><span class="fieldname"><?php echo _('Select'); ?></span></th>
                                <?php } ?>
                                <th><?php echo _('ID'); ?></th>
                                <th><?php echo _('Description'); ?></th>
                                <th><?php echo _('Tree'); ?></th>
                                <th><?php echo _('Starting Individual'); ?></th>
                                <th><?php echo _('People'); ?></th>
                                <th><?php echo _('Families'); ?></th>
                            </tr>

                            <?php
                            if ($numrows) {
                            $actionstr = "";
                            if ($allow_edit) {
                                $actionstr .= "<a href=\"admin_editbranch.php?branch=xxx&amp;tree=yyy\" class='smallicon admin-edit-icon' title=\"" . _('Edit') . "\"></a>";
                            }
                            if ($allow_delete) {
                                if (!$assignedtree) {
                                    $actionstr .= "<a href='#' class='smallicon admin-delete-icon' title=\"" . _('Delete') . "\" onClick=\"return confirmDelete('xxx','yyy');\"></a>";
                            }
                        }

                        while ($row = tng_fetch_assoc($result)) {
                            $newactionstr = preg_replace("/xxx/", $row['branch'], $actionstr);
                            $newactionstr = preg_replace("/yyy/", $row['gedcom'], $newactionstr);
                            echo "<tr id=\"row_{$row['branch']}\"><td class='lightback'><div>$newactionstr</div></td>\n";
                            if ($allow_delete) {
                                echo "<td class='lightback text-center'><input type='checkbox' name=\"del{$row['branch']}&{$row['gedcom']}\" value='1'></td>";
                            }
                            $editlink = "admin_editbranch.php?branch={$row['branch']}&tree={$row['gedcom']}";
                            $id = $allow_edit ? "<a href=\"$editlink\" title=\"" . _('Edit') . "\">" . $row['branch'] . "</a>" : $row['branch'];

                            echo "<td class='lightback' nowrap>&nbsp;$id&nbsp;</td>\n";
                            echo "<td class='lightback'>&nbsp;{$row['description']}</td>\n";
                            echo "<td class='lightback'>&nbsp;{$row['treename']}&nbsp;</td>\n";

                            $pcount = getBranchCount($row['gedcom'], $row['branch'], $people_table);
                            $fcount = getBranchCount($row['gedcom'], $row['branch'], $families_table);
                            echo "<td class='lightback'>{$row['personID']}&nbsp;</td>\n";
                            echo "<td class='lightback' style='text-align: right;'>$pcount&nbsp;</td>\n";
                            echo "<td class='lightback' style='text-align: right;'>$fcount&nbsp;</td>\n";
                            echo "</tr>\n";
                        }
                        tng_free_result($result);
                        ?>
                    </table>
                <?php
                echo "<div class='w-full class=lg:flex my-6'>";
                echo getPaginationLocationHtml($offsetplus, $numrowsplus, $totrows);
                echo getPaginationControlsHtml($totrows, "admin_branches.php?searchstring=$searchstring&amp;offset", $maxsearchresults, 3);
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