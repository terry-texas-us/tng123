<?php
include "begin.php";
include "adminlib.php";
$textpart = "branches";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
if ($assignedbranch) {
    $message = $admtext['norights'];
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

function getBranchCount($tree, $branch, $table) {
    $query = "SELECT count(ID) AS count FROM $table WHERE gedcom = '$tree' and branch LIKE \"%$branch%\"";
    $result = tng_query($query);
    $row = tng_fetch_assoc($result);
    $count = $row['count'];
    if (!$count) {
        $count = "0";
    }
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
    if (!$tree) {
        $tree = $_COOKIE['tng_tree'];
    }
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
    $wherestr = "WHERE gedcom = \"$assignedtree\"";
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

$flags['tabs'] = $tngconfig['tabs'];
tng_adminheader($admtext['branches'], $flags);
?>
<script>
    function confirmDelete(ID, tree) {
        if (confirm('<?php echo $admtext['confbranchdelete']; ?>'))
            deleteIt('branch', ID, tree);
        return false;
    }
</script>
<script src="js/admin.js"></script>
</head>

<body class="admin-body">

<?php
$branchtabs['0'] = array(1, "admin_branches.php", $admtext['search'], "findbranch");
$branchtabs['1'] = array($allow_add, "admin_newbranch.php", $admtext['addnew'], "addbranch");
$innermenu = "<a href=\"#\" onclick=\"return openHelp('$helplang/branches_help.php');\" class=\"lightlink\">{$admtext['help']}</a>";
$menu = doMenu($branchtabs, "findbranch", $innermenu);
echo displayHeadline($admtext['branches'], "img/branches_icon.gif", $menu, $message);
?>

<table class="lightback">
    <tr class="databack">
        <td class="tngshadow">
            <div class="normal">

                <form action="admin_branches.php" name="form1" id="form1">
                    <table>
                        <tr>
                            <td><span class="normal"><?php echo $admtext['searchfor']; ?>: </span></td>
                            <td>
                                <select name="tree">
                                    <?php
                                    if (!$assignedtree) {
                                        echo "	<option value=\"\">{$admtext['alltrees']}</option>\n";
                                    }
                                    $treeresult = tng_query($treequery) or die ($admtext['cannotexecutequery'] . ": $treequery");
                                    while ($treerow = tng_fetch_assoc($treeresult)) {
                                        echo "	<option value=\"{$treerow['gedcom']}\"";
                                        if ($treerow['gedcom'] == $tree) {
                                            echo " selected";
                                        }
                                        echo ">{$treerow['treename']}</option>\n";
                                    }
                                    tng_free_result($treeresult);
                                    ?>
                                </select>
                                <input type="text" name="searchstring" value="<?php echo $searchstring_noquotes; ?>" class="longfield">
                            </td>
                            <td>
                                <input type="submit" name="submit" value="<?php echo $admtext['search']; ?>" class="aligntop">
                                <input type="submit" name="submit" value="<?php echo $admtext['reset']; ?>" onClick="document.form1.searchstring.value=''; document.form1.tree.selectedIndex=0;"
                                       class="aligntop">
                            </td>
                        </tr>
                    </table>

                    <input type="hidden" name="findbranch" value="1">
                    <input type="hidden" name="newsearch" value="1">
                </form>
                <br>

                <?php
                $numrowsplus = $numrows + $offset;
                if (!$numrowsplus) {
                    $offsetplus = 0;
                }
                echo displayListLocation($offsetplus, $numrowsplus, $totrows);
                $pagenav = get_browseitems_nav($totrows, "admin_branches.php?searchstring=$searchstring&amp;offset", $maxsearchresults, 5);
                echo " &nbsp; <span class=\"adminnav\">$pagenav</span></p>";
                ?>
                <form action="admin_deleteselected.php" method="post" name="form2">
                    <?php
                    if ($allow_delete) {
                        ?>
                        <p>
                            <input type="button" name="selectall" value="<?php echo $admtext['selectall']; ?>" onClick="toggleAll(1);">
                            <input type="button" name="clearall" value="<?php echo $admtext['clearall']; ?>" onClick="toggleAll(0);">
                            <input type="submit" name="xbranchaction" value="<?php echo $admtext['deleteselected']; ?>" onClick="return confirm('<?php echo $admtext['confdeleterecs']; ?>');">
                        </p>
                        <?php
                    }
                    ?>
                    <table class="normal">
                        <tr class="fieldnameback fieldname nw">
                            <th><?php echo $admtext['action']; ?></th>
                            <?php if ($allow_delete) { ?>
                                <th><span class="fieldname"><?php echo $admtext['select']; ?></span></th>
                            <?php } ?>
                            <th><?php echo $admtext['id']; ?></th>
                            <th><?php echo $admtext['description']; ?></th>
                            <th><?php echo $admtext['tree']; ?></th>
                            <th><?php echo $text['startingind']; ?></th>
                            <th><?php echo $admtext['people']; ?></th>
                            <th><?php echo $admtext['families']; ?></th>
                        </tr>

                        <?php
                        if ($numrows) {
                        $actionstr = "";
                        if ($allow_edit) {
                            $actionstr .= "<a href=\"admin_editbranch.php?branch=xxx&amp;tree=yyy\" title=\"{$admtext['edit']}\" class=\"smallicon admin-edit-icon\"></a>";
                        }
                        if ($allow_delete) {
                            if (!$assignedtree) {
                                $actionstr .= "<a href=\"#\" onClick=\"return confirmDelete('xxx','yyy');\" title=\"{$admtext['text_delete']}\" class=\"smallicon admin-delete-icon\"></a>";
                            }
                        }

                        while ($row = tng_fetch_assoc($result)) {
                            $newactionstr = preg_replace("/xxx/", $row['branch'], $actionstr);
                            $newactionstr = preg_replace("/yyy/", $row['gedcom'], $newactionstr);
                            echo "<tr id=\"row_{$row['branch']}\"><td class='lightback'><div>$newactionstr</div></td>\n";
                            if ($allow_delete) {
                                echo "<td class='lightback text-center'><input type=\"checkbox\" name=\"del{$row['branch']}&{$row['gedcom']}\" value='1'></td>";
                            }
                            $editlink = "admin_editbranch.php?branch={$row['branch']}&tree={$row['gedcom']}";
                            $id = $allow_edit ? "<a href=\"$editlink\" title=\"{$admtext['edit']}\">" . $row['branch'] . "</a>" : $row['branch'];

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
                echo displayListLocation($offsetplus, $numrowsplus, $totrows);
                echo " &nbsp; <span class=\"adminnav\">$pagenav</span></p>";
                }
                else {
                    echo $admtext['notrees'];
                }
                ?>

            </div>
        </td>
    </tr>

</table>
<?php echo "<div style=\"text-align: center;\"><span class='normal'>$tng_title</span></div>"; ?>
</body>
</html>