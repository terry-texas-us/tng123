<?php

include "begin.php";
include "adminlib.php";
require_once "admin/pagination.php";
$textpart = "sources";
include "$mylanguage/admintext.php";
$admin_login = 1;
include "checklogin.php";
include "version.php";
require_once "./core/html/addCriteria.php";

if ($newsearch) {
    $exptime = 0;
    setcookie("tng_search_sources_post[search]", $searchstring, $exptime);
    setcookie("tng_tree", $tree, $exptime);
    setcookie("tng_search_sources_post[exactmatch]", $exactmatch, $exptime);
    setcookie("tng_search_sources_post[tngpage]", 1, $exptime);
    setcookie("tng_search_sources_post[offset]", 0, $exptime);
} else {
    if (!$searchstring) {
        $searchstring = stripslashes($_COOKIE['tng_search_sources_post']['search']);
    }
    if (!$tree) $tree = $_COOKIE['tng_tree'];

    if (!$exactmatch) {
        $exactmatch = $_COOKIE['tng_search_sources_post']['exactmatch'];
    }
    if (!isset($offset)) {
        $tngpage = $_COOKIE['tng_search_sources_post']['tngpage'];
        $offset = $_COOKIE['tng_search_sources_post']['offset'];
    } else {
        $exptime = 0;
        setcookie("tng_search_sources_post[tngpage]", $tngpage, $exptime);
        setcookie("tng_search_sources_post[offset]", $offset, $exptime);
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

$uquery = "SELECT count(userID) AS ucount FROM $users_table WHERE allow_living = \"-1\"";
$uresult = tng_query($uquery) or die (_('Cannot execute query') . ": $uquery");
$urow = tng_fetch_assoc($uresult);
$numusers = $urow['ucount'];
tng_free_result($uresult);

if ($tree) {
    $allwhere = "$sources_table.gedcom = '$tree' AND $sources_table.gedcom = $trees_table.gedcom";
} else {
    $allwhere = "$sources_table.gedcom = $trees_table.gedcom";
}

if ($searchstring) {
    $allwhere .= " AND (1=0 ";
    if ($exactmatch == "yes") {
        $frontmod = "=";
    } else {
        $frontmod = "LIKE";
    }

    $allwhere .= addCriteria("sourceID", $searchstring, $frontmod);
    $allwhere .= addCriteria("shorttitle", $searchstring, $frontmod);
    $allwhere .= addCriteria("title", $searchstring, $frontmod);
    $allwhere .= addCriteria("author", $searchstring, $frontmod);
    $allwhere .= addCriteria("callnum", $searchstring, $frontmod);
    $allwhere .= addCriteria("publisher", $searchstring, $frontmod);
    $allwhere .= addCriteria("actualtext", $searchstring, $frontmod);
    $allwhere .= ")";
}

$query = "SELECT sourceID, shorttitle, title, $sources_table.gedcom AS gedcom, treename, ID, changedby, DATE_FORMAT(changedate,\"%d %b %Y\") AS changedate FROM ($sources_table, $trees_table) WHERE $allwhere ORDER BY shorttitle, title LIMIT $newoffset" . $maxsearchresults;
$result = tng_query($query);

$numrows = tng_num_rows($result);
if ($numrows == $maxsearchresults || $offsetplus > 1) {
    $query = "SELECT count(sourceID) AS scount FROM ($sources_table, $trees_table) WHERE $allwhere";
    $result2 = tng_query($query);
    $row = tng_fetch_assoc($result2);
    $totrows = $row['scount'];
    tng_free_result($result2);
} else {
    $totrows = $numrows;
}

$helplang = findhelp("sources_help.php");

tng_adminheader(_('Sources'), $flags);
?>
    <script>
        function confirmDelete(ID) {
            if (confirm('<?php echo _('Are you sure you want to delete this source?'); ?>'))
                deleteIt('source', ID);
            return false;
        }
    </script>

<?php
echo "</head>\n";
echo tng_adminlayout();

$sourcetabs[0] = [1, "admin_sources.php", _('Search'), "findsource"];
$sourcetabs[1] = [$allow_add, "admin_newsource.php", _('Add New'), "addsource"];
$sourcetabs[2] = [$allow_edit && $allow_delete, "admin_mergesources.php", _('Merge'), "merge"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/sources_help.php');\" class='lightlink'>" . _('Help for this area') . "</a>";
$menu = doMenu($sourcetabs, "findsource", $innermenu);
echo displayHeadline(_('Sources'), "img/sources_icon.gif", $menu, $message);
?>

    <table class="lightback">
        <tr class="databack">
            <td class="tngshadow">
                <div class="normal">

                    <form action="admin_sources.php" name="form1" id="form1">
                        <table>
                            <tr>
                                <td><span class="normal"><?php echo _('Search for'); ?>: </span></td>
                                <td>
                                    <?php include "treequery.php"; ?>
                                    <input class="longfield" name="searchstring" type="search" value="<?php echo $searchstring_noquotes; ?>">
                                </td>
                                <td>
                                    <input type="submit" name="submit" value="<?php echo _('Search'); ?>" class="align-top">
                                    <input type="submit" name="submit" value="<?php echo _('Reset'); ?>"
                                        onClick="document.form1.searchstring.value=''; document.form1.tree.selectedIndex=0; document.form1.exactmatch.checked=false;" class="align-top">
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td colspan="2">
				<span class="normal">
				<input type="checkbox" name="exactmatch" value="yes"<?php if ($exactmatch == "yes") {
                    echo " checked";
                } ?>> <?php echo _('Exact match only'); ?>
				</span>
                                </td>
                            </tr>
                        </table>

                        <input type="hidden" name="findsource" value="1">
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
                            <input type="submit" name="xsrcaction" value="<?php echo _('Delete Selected'); ?>" onClick="return confirm('<?php echo _('Are you sure you want to delete the selected records?'); ?>');">
                        </p>
                    <?php } ?>

                    <table class="normal">
                        <tr>
                            <th class="fieldnameback"><span class="fieldname"><?php echo _('Action'); ?></span></th>
                            <?php if ($allow_delete) { ?>
                                <th class="fieldnameback"><span class="fieldname"><?php echo _('Select'); ?></span></th>
                            <?php } ?>
                            <th class="fieldnameback"><span class="fieldname"><?php echo _('Source ID'); ?></span></th>
                            <th class="fieldnameback"><span class="fieldname"><?php echo _('Title'); ?></span></th>
                            <?php if ($numtrees > 1) { ?>
                                <th class="fieldnameback"><span class="fieldname"><?php echo _('Tree'); ?></span></th>
                                <?php
                            }
                            if ($numusers > 1) {
                                ?>
                                <th class="fieldnameback"><span class="fieldname"><?php echo _('Last Modified Date'); ?></span></th>
                            <?php } ?>
                        </tr>
                        <?php
                        if ($numrows) {
                        $actionstr = "";
                        if ($allow_edit) {
                            $actionstr .= "<a href=\"admin_editsource.php?sourceID=xxx&amp;tree=yyy\" title=\"" . _('Edit') . "\" class='smallicon admin-edit-icon'></a>";
                        }
                        if ($allow_delete) {
                            $actionstr .= "<a href='#' onClick=\"return confirmDelete('zzz');\" title=\"" . _('Delete') . "\" class='smallicon admin-delete-icon'></a>";
                        }
                        $actionstr .= "<a href=\"showsource.php?sourceID=xxx&amp;tree=yyy\" target='_blank' title=\"" . _('Test') . "\" class='smallicon admin-test-icon'></a>";

                        while ($row = tng_fetch_assoc($result)) {
                            $newactionstr = preg_replace("/xxx/", $row['sourceID'], $actionstr);
                            $newactionstr = preg_replace("/yyy/", $row['gedcom'], $newactionstr);
                            $newactionstr = preg_replace("/zzz/", $row['ID'], $newactionstr);
                            $title = $row['shorttitle'] ? $row['shorttitle'] : $row['title'];
                            $editlink = "admin_editsource.php?sourceID={$row['sourceID']}&amp;tree={$row['gedcom']}";
                            $id = $allow_edit ? "<a href=\"$editlink\" title=\"" . _('Edit') . "\">" . $row['sourceID'] . "</a>" : $row['sourceID'];

                            echo "<tr id=\"row_{$row['ID']}\"><td class='lightback'><div class='action-btns'>$newactionstr</div></td>\n";
                            if ($allow_delete) {
                                echo "<td class='lightback text-center'><input type='checkbox' name=\"del{$row['ID']}\" value='1'></td>";
                            }
                            echo "<td class='lightback'>&nbsp;$id&nbsp;</td>\n";
                            echo "<td class='lightback'>$title&nbsp;</td>\n";
                            if ($numtrees > 1) {
                                echo "<td class='lightback whitespace-no-wrap'>&nbsp;{$row['treename']}&nbsp;</td>\n";
                            }
                            if ($numusers > 1) {
                                echo "<td class='lightback'><span class='normal'>&nbsp;{$row['changedby']}: {$row['changedate']}&nbsp;</span></td>\n";
                            }
                            echo "</tr>\n";
                        }
                        ?>
                    </table>
                <?php
                echo "<div class='w-full class=lg:flex my-6'>";
                echo getPaginationLocationHtml($offsetplus, $numrowsplus, $totrows);
                echo getPaginationControlsHtml($totrows, "admin_sources.php?searchstring=$searchstring&amp;exactmatch=$exactmatch&amp;offset", $maxsearchresults, 3);
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
    </div>
<?php echo tng_adminfooter(); ?>