<?php

include "begin.php";
include "adminlib.php";
require_once "admin/pagination.php";
$textpart = "trees";
include "$mylanguage/admintext.php";
$admin_login = 1;
include "checklogin.php";
include "version.php";
$tng_search_trees = $_SESSION['tng_search_trees'] = 1;
if ($newsearch) {
    $exptime = 0;
    setcookie("tng_search_trees_post[search]", $searchstring, $exptime);
    setcookie("tng_search_trees_post[tngpage]", 1, $exptime);
    setcookie("tng_search_trees_post[offset]", 0, $exptime);
} else {
    if (!$searchstring) {
        $searchstring = $_COOKIE['tng_search_trees_post']['search'];
    }
    if (!isset($offset)) {
        $tngpage = $_COOKIE['tng_search_trees_post']['tngpage'];
        $offset = $_COOKIE['tng_search_trees_post']['offset'];
    } else {
        $exptime = 0;
        setcookie("tng_search_trees_post[tngpage]", $tngpage, $exptime);
        setcookie("tng_search_trees_post[offset]", $offset, $exptime);
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

$wherestr = $searchstring ? "WHERE (gedcom LIKE \"%$searchstring%\" OR treename LIKE \"%$searchstring%\" OR description LIKE \"%$searchstring%\" OR owner LIKE \"%$searchstring%\")" : "";
if ($assignedtree) {
    $wherestr .= $wherestr ? " AND gedcom = '$assignedtree'" : "WHERE gedcom = '$assignedtree'";
}

$query = "SELECT gedcom, treename, description, owner, DATE_FORMAT(lastimportdate,\"%d %b %Y %H:%i:%s\") AS lastimportdate, importfilename FROM $trees_table $wherestr ORDER BY treename LIMIT $newoffset" . $maxsearchresults;
$result = tng_query($query);

$numrows = tng_num_rows($result);
if ($numrows == $maxsearchresults || $offsetplus > 1) {
    $query = "SELECT count(gedcom) AS tcount FROM $trees_table $wherestr";
    $result2 = tng_query($query);
    $row = tng_fetch_assoc($result2);
    $totrows = $row['tcount'];
    tng_free_result($result2);
} else {
    $totrows = $numrows;
}

$helplang = findhelp("trees_help.php");

tng_adminheader($admtext['trees'], $flags);

echo "</head>\n";
echo tng_adminlayout();

$allow_add_tree = $assignedtree ? 0 : $allow_add;
$treetabs[0] = [1, "admin_trees.php", $admtext['search'], "findtree"];
$treetabs[1] = [$allow_add_tree, "admin_newtree.php", $admtext['addnew'], "addtree"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/trees_help.php');\" class='lightlink'>{$admtext['help']}</a>";
$menu = doMenu($treetabs, "findtree", $innermenu);
echo displayHeadline($admtext['trees'], "img/trees_icon.gif", $menu, $message);
?>
    <table class="lightback">
        <tr class="databack">
            <td class="tngshadow">
                <div class="normal">

                    <form action="admin_trees.php" name="form1">
                        <?php echo $admtext['searchfor']; ?>:
                        <input class="longfield" name="searchstring" type="search" value="<?php echo $searchstring; ?>">
                        <input type="hidden" name="findtree" value="1">
                        <input type="hidden" name="newsearch" value="1">
                        <input type="submit" name="submit" value="<?php echo $admtext['search']; ?>" class="align-top">
                        <input type="submit" name="submit" value="<?php echo $admtext['reset']; ?>" onClick="document.form1.searchstring.value='';" class="align-top">
                    </form>
                    <?php
                    $numrowsplus = $numrows + $offset;
                    if (!$numrowsplus) $offsetplus = 0;
                    ?>
                    <table class="normal">
                        <tr>
                            <th class="fieldnameback fieldname whitespace-no-wrap"><?php echo $admtext['action']; ?></th>
                            <th class="fieldnameback fieldname whitespace-no-wrap"><?php echo $admtext['id']; ?></th>
                            <th class="fieldnameback fieldname whitespace-no-wrap"><?php echo $admtext['treename']; ?></th>
                            <th class="fieldnameback fieldname whitespace-no-wrap"><?php echo $admtext['description']; ?></th>
                            <th class="fieldnameback fieldname whitespace-no-wrap"><?php echo $admtext['people']; ?></th>
                            <th class="fieldnameback fieldname whitespace-no-wrap"><?php echo $admtext['owner']; ?></th>
                            <th class="fieldnameback fieldname whitespace-no-wrap"><?php echo $admtext['lastimport']; ?></th>
                            <th class="fieldnameback fieldname whitespace-no-wrap"><?php echo $admtext['importfilename']; ?></th>
                        </tr>
                        <?php
                        if ($numrows) {
                        $actionstr = "";
                        if ($allow_edit && !$assignedbranch) {
                            $actionstr .= "<a href=\"admin_edittree.php?tree=xxx\" title=\"{$admtext['edit']}\" class='smallicon admin-edit-icon'></a>";
                        }
                        if ($allow_delete && !$assignedbranch) {
                            if (!$assignedtree) {
                                $actionstr .= "<a href='#' class='smallicon admin-delete-icon' title=\"{$admtext['text_delete']}\" onClick=\"if(confirm('{$admtext['conftreedelete']}' )){deleteIt('tree','xxx');} return false;\"></a>";
                        }
                        $actionstr .= "<a href=\"admin_cleartree.php?tree=xxx\" onClick=\"return confirm('{$admtext['conftreeclear']}' );\" title=\"{$admtext['clear']}\" class=\"smallicon admin-clear-icon\"></a>";
                    }
                    while ($row = tng_fetch_assoc($result)) {
                        $newactionstr = preg_replace("/xxx/", $row['gedcom'], $actionstr);
                        $editlink = "admin_edittree.php?tree={$row['gedcom']}";
                        $gedcom = $allow_edit ? "<a href=\"$editlink\" title=\"{$admtext['edit']}\">" . $row['gedcom'] . "</a>" : $row['gedcom'];

                        $query = "SELECT count(personID) AS pcount FROM $people_table WHERE gedcom = \"{$row['gedcom']}\"";
                        $result2 = tng_query($query);
                        $prow = tng_fetch_assoc($result2);
                        $pcount = number_format($prow['pcount']);
                        tng_free_result($result2);
                        echo "<tr id=\"row_{$row['gedcom']}\">";
                        echo "<td class='lightback'><div class='action-btns'>$newactionstr</div></td>\n";
                        echo "<td class='lightback whitespace-no-wrap'>$gedcom</td>\n";
                        echo "<td class='lightback'>{$row['treename']}</td>\n";
                        echo "<td class='lightback'>{$row['description']}</td>\n";
                        echo "<td class='lightback whitespace-no-wrap text-right'>$pcount</td>\n";
                        echo "<td class='lightback whitespace-no-wrap'>{$row['owner']}</td>\n";
                        echo "<td class='lightback whitespace-no-wrap'>{$row['lastimportdate']}</td>\n";
                        echo "<td class='lightback whitespace-no-wrap'>{$row['importfilename']}</td>\n";
                        echo "</tr>\n";
                    }
                    tng_free_result($result);
                    ?>
                </table>
                <?php
                echo "<div class='w-full class=lg:flex my-6'>";
                echo getPaginationLocationHtml($offsetplus, $numrowsplus, $totrows);
                echo getPaginationControlsHtml($totrows, "admin_notelist.php?searchstring=$searchstring_noquotes&amp;offset", $maxsearchresults, 3);
                echo "</div>";
                }
            else {
                echo $admtext['notrees'];
            }
            ?>
                </div>
            </td>
        </tr>

    </table>
<?php echo tng_adminfooter(); ?>