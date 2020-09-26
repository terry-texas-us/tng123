<?php
include "begin.php";
include "adminlib.php";
$textpart = "sources";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";

if ($newsearch) {
    $exptime = 0;
    setcookie("tng_search_repos_post[search]", $searchstring, $exptime);
    setcookie("tng_tree", $tree, $exptime);
    setcookie("tng_search_repos_post[exactmatch]", $exactmatch, $exptime);
    setcookie("tng_search_repos_post[tngpage]", 1, $exptime);
    setcookie("tng_search_repos_post[offset]", 0, $exptime);
} else {
    if (!$searchstring) {
        $searchstring = stripslashes($_COOKIE['tng_search_repos_post']['search']);
    }
    if (!$tree) {
        $tree = $_COOKIE['tng_tree'];
    }
    if (!$exactmatch) {
        $exactmatch = $_COOKIE['tng_search_repos_post']['exactmatch'];
    }
    if (!isset($offset)) {
        $tngpage = $_COOKIE['tng_search_repos_post']['tngpage'];
        $offset = $_COOKIE['tng_search_repos_post']['offset'];
    } else {
        $exptime = 0;
        setcookie("tng_search_repos_post[tngpage]", $tngpage, $exptime);
        setcookie("tng_search_repos_post[offset]", $offset, $exptime);
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
    $wherestr = "WHERE gedcom = \"$assignedtree\"";
    $tree = $assignedtree;
} else {
    $wherestr = "";
}
$orgtree = $tree;

function addCriteria($field, $value, $operator) {
    $criteria = "";

    if ($operator == "=") {
        $criteria = " OR $field $operator \"$value\"";
    } else {
        $innercriteria = "";
        $terms = explode(' ', $value);
        foreach ($terms as $term) {
            if ($innercriteria) {
                $innercriteria .= " AND ";
            }
            $innercriteria .= "$field $operator \"%$term%\"";
        }
        if ($innercriteria) {
            $criteria = " OR ($innercriteria)";
        }
    }

    return $criteria;
}
if ($tree) {
    $allwhere = "$repositories_table.gedcom = \"$tree\" AND $repositories_table.gedcom = $trees_table.gedcom";
} else {
    $allwhere = "$repositories_table.gedcom = $trees_table.gedcom";
}

if ($searchstring) {
    $allwhere .= " AND (1=0 ";
    if ($exactmatch == "yes") {
        $frontmod = "=";
    } else {
        $frontmod = "LIKE";
    }

    $allwhere .= addCriteria("repoID", $searchstring, $frontmod);
    $allwhere .= addCriteria("reponame", $searchstring, $frontmod);
    $allwhere .= ")";
}

$query = "SELECT ID, repoID, reponame, $repositories_table.gedcom AS gedcom, treename FROM ($repositories_table, $trees_table) WHERE $allwhere ORDER BY reponame, repoID LIMIT $newoffset" . $maxsearchresults;
$result = tng_query($query);

$numrows = tng_num_rows($result);
if ($numrows == $maxsearchresults || $offsetplus > 1) {
    $query = "SELECT count(repoID) AS rcount FROM ($repositories_table, $trees_table) WHERE $allwhere";
    $result2 = tng_query($query);
    $row = tng_fetch_assoc($result2);
    $totrows = $row['rcount'];
    tng_free_result($result2);
} else {
    $totrows = $numrows;
}

$helplang = findhelp("repositories_help.php");

$flags['tabs'] = $tngconfig['tabs'];
tng_adminheader($admtext['repositories'], $flags);
?>
<script>
    function confirmDelete(ID) {
        if (confirm('<?php echo $admtext['confdeleterepo']; ?>'))
            deleteIt('repository', ID);
        return false;
    }
</script>
<script src="js/admin.js"></script>
</head>

<body class="admin-body">

<?php
$repotabs[0] = array(1, "admin_repositories.php", $admtext['search'], "findrepo");
$repotabs[1] = array($allow_add, "admin_newrepo.php", $admtext['addnew'], "addrepo");
$repotabs[2] = array($allow_edit && $allow_delete, "admin_mergerepos.php", $admtext['merge'], "merge");
$innermenu = "<a href=\"#\" onclick=\"return openHelp('$helplang/repositories_help.php');\" class=\"lightlink\">{$admtext['help']}</a>";
$menu = doMenu($repotabs, "findrepo", $innermenu);
echo displayHeadline($admtext['repositories'], "img/repos_icon.gif", $menu, $message);
?>

<table class="lightback">
    <tr class="databack">
        <td class="tngshadow">
            <div class="normal">

                <form action="admin_repositories.php" name="form1" id="form1">
                    <table>
                        <tr>
                            <td><span class="normal"><?php echo $admtext['searchfor']; ?>: </span></td>
                            <td>
                                <?php
                                include "treequery.php";
                                ?>
                                <input type="text" name="searchstring" value="<?php echo $searchstring_noquotes; ?>" class="longfield">
                            </td>
                            <td>
                                <input type="submit" name="submit" value="<?php echo $admtext['search']; ?>" class="aligntop">
                                <input type="submit" name="submit" value="<?php echo $admtext['reset']; ?>"
                                       onClick="document.form1.searchstring.value=''; document.form1.tree.selectedIndex=0; document.form1.exactmatch.checked=false;" class="aligntop">
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td colspan="2">
				<span class="normal">
				<input type="checkbox" name="exactmatch" value="yes"<?php if ($exactmatch == "yes") {
                    echo " checked";
                } ?>> <?php echo $admtext['exactmatch']; ?>
				</span>
                            </td>
                        </tr>
                    </table>

                    <input type="hidden" name="findrepo" value="1">
                    <input type="hidden" name="newsearch" value="1">
                </form>
                <br>

                <?php
                $numrowsplus = $numrows + $offset;
                if (!$numrowsplus) {
                    $offsetplus = 0;
                }
                echo displayListLocation($offsetplus, $numrowsplus, $totrows);
                $pagenav = get_browseitems_nav($totrows, "admin_repositories.php?searchstring=$searchstring&amp;exactmatch=$exactmatch&amp;offset", $maxsearchresults, 5);
                echo " &nbsp; <span class=\"adminnav\">$pagenav</span></p>";
                ?>
                <form action="admin_deleteselected.php" method="post" name="form2">
                    <?php
                    if ($allow_delete) {
                        ?>
                        <p>
                            <input type="button" name="selectall" value="<?php echo $admtext['selectall']; ?>" onClick="toggleAll(1);">
                            <input type="button" name="clearall" value="<?php echo $admtext['clearall']; ?>" onClick="toggleAll(0);">
                            <input type="submit" name="xrepoaction" value="<?php echo $admtext['deleteselected']; ?>" onClick="return confirm('<?php echo $admtext['confdeleterecs']; ?>');">
                        </p>
                        <?php
                    }
                    ?>

                    <table class="normal">
                        <tr>
                            <th class="fieldnameback"><span class="fieldname"><?php echo $admtext['action']; ?></span></th>
                            <?php if ($allow_delete) { ?>
                                <th class="fieldnameback"><span class="fieldname"><?php echo $admtext['select']; ?></span></th>
                            <?php } ?>
                            <th class="fieldnameback"><span class="fieldname"><?php echo $admtext['repoid']; ?></span></th>
                            <th class="fieldnameback"><span class="fieldname"><?php echo $admtext['name']; ?></span></th>
                            <?php if ($numtrees > 1) { ?>
                                <th class="fieldnameback"><span class="fieldname"><?php echo $admtext['tree']; ?></span></th>
                            <?php } ?>
                        </tr>
                        <?php
                        if ($numrows) {
                        $actionstr = "";
                        if ($allow_edit) {
                            $actionstr .= "<a href=\"admin_editrepo.php?repoID=xxx&amp;tree=yyy\" title=\"{$admtext['edit']}\" class=\"smallicon admin-edit-icon\"></a>";
                        }
                        if ($allow_delete) {
                            $actionstr .= "<a href=\"#\" onclick=\"return confirmDelete('zzz');\" title=\"{$admtext['text_delete']}\" class=\"smallicon admin-delete-icon\"></a>";
                        }
                        $actionstr .= "<a href=\"showrepo.php?repoID=xxx&amp;tree=yyy\" target=\"_blank\" title=\"{$admtext['test']}\" class=\"smallicon admin-test-icon\"></a>";

                        while ($row = tng_fetch_assoc($result)) {
                            $newactionstr = preg_replace("/xxx/", $row['repoID'], $actionstr);
                            $newactionstr = preg_replace("/yyy/", $row['gedcom'], $newactionstr);
                            $newactionstr = preg_replace("/zzz/", $row['ID'], $newactionstr);
                            $editlink = "admin_editrepo.php?repoID={$row['repoID']}&amp;tree={$row['gedcom']}";
                            $id = $allow_edit ? "<a href=\"$editlink\" title=\"{$admtext['edit']}\">" . $row['repoID'] . "</a>" : $row['repoID'];

                            echo "<tr id=\"row_{$row['ID']}\"><td class='lightback'><div class=\"action-btns\">$newactionstr</div></td>\n";
                            if ($allow_delete) {
                                echo "<td class='lightback text-center'><input type=\"checkbox\" name=\"del{$row['ID']}\" value='1'></td>";
                            }
                            echo "<td class='lightback'>&nbsp;$id&nbsp;</td>\n";
                            echo "<td class='lightback'>&nbsp;{$row['reponame']}&nbsp;</td>\n";
                            if ($numtrees > 1) {
                                echo "<td class=\"lightback nw\">&nbsp;{$row['treename']}&nbsp;</td>\n";
                            }
                            echo "</tr>\n";
                        }
                        ?>
                    </table>
                <?php
                echo displayListLocation($offsetplus, $numrowsplus, $totrows);
                echo " &nbsp; <span class=\"adminnav\">$pagenav</span></p>";
                }
                else {
                    echo "</table>\n" . $admtext['norecords'];
                }
                tng_free_result($result);
                ?>
                </form>

            </div>
        </td>
    </tr>

</table>
</div>
<?php echo "<div style=\"text-align: center;\"><span class='normal'>$tng_title</span></div>"; ?>
</body>
</html>