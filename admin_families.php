<?php
include "begin.php";
include "adminlib.php";
$textpart = "families";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
if ($newsearch) {
    $exptime = 0;
    setcookie("tng_search_families_post[search]", $searchstring, $exptime);
    setcookie("tng_tree", $tree, $exptime);
    setcookie("tng_search_families_post[living]", $living, $exptime);
    setcookie("tng_search_families_post[exactmatch]", $exactmatch, $exptime);
    setcookie("tng_search_families_post[spousename]", $spousename, $exptime);
    setcookie("tng_search_families_post[tngpage]", 1, $exptime);
    setcookie("tng_search_families_post[offset]", 0, $exptime);
} else {
    if (!$searchstring) {
        $searchstring = stripslashes($_COOKIE['tng_search_families_post']['search']);
    }
    if (!$tree) {
        $tree = $_COOKIE['tng_tree'];
    }
    if (!$living) {
        $living = $_COOKIE['tng_search_families_post']['living'];
    }
    if (!$exactmatch) {
        $exactmatch = $_COOKIE['tng_search_families_post']['exactmatch'];
    }
    if (!$spousename) {
        $spousename = $_COOKIE['tng_search_families_post']['spousename'];
        if (!$spousename) {
            $spousename = "husband";
        }
    }
    if (!isset($offset)) {
        $tngpage = $_COOKIE['tng_search_families_post']['tngpage'];
        $offset = $_COOKIE['tng_search_families_post']['offset'];
    } else {
        $exptime = 0;
        setcookie("tng_search_families_post[tngpage]", $tngpage, $exptime);
        setcookie("tng_search_families_post[offset]", $offset, $exptime);
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

$uquery = "SELECT count(userID) as ucount FROM $users_table WHERE allow_living = \"-1\"";
$uresult = tng_query($uquery) or die ($admtext['cannotexecutequery'] . ": $uquery");
$urow = tng_fetch_assoc($uresult);
$numusers = $urow['ucount'];
tng_free_result($uresult);

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

$familygroup_url = getURL("familygroup", 1);
$allwhere = "$families_table.gedcom = $trees_table.gedcom";
$allwhere2 = "";

if ($searchstring) {
    $allwhere .= " AND (1=0 ";
    if ($exactmatch == "yes") {
        $frontmod = "=";
    } else {
        $frontmod = "LIKE";
    }

    $allwhere .= addCriteria("familyID", $searchstring, $frontmod);
    $allwhere .= addCriteria("husband", $searchstring, $frontmod);
    $allwhere .= addCriteria("wife", $searchstring, $frontmod);

    if ($spousename == "husband") {
        $allwhere .= addCriteria("CONCAT_WS(' ',TRIM(firstname)" . ($lnprefixes ? ",TRIM(lnprefix)" : "") . ",TRIM(lastname))", $searchstring, $frontmod);
    } elseif ($spousename == "wife") {
        $allwhere .= addCriteria("CONCAT_WS(' ',TRIM(firstname)" . ($lnprefixes ? ",TRIM(lnprefix)" : "") . ",TRIM(lastname))", $searchstring, $frontmod);
    }
    $allwhere .= ")";
}
if ($spousename == "husband") {
    $allwhere2 .= "AND $people_table.personID = husband ";
} elseif ($spousename == "wife") {
    $allwhere2 .= "AND $people_table.personID = wife ";
}

if ($allwhere2) {
    $allwhere2 .= "AND $people_table.gedcom = $trees_table.gedcom";
    $allwhere .= " $allwhere2";
    if ($tree) {
        $allwhere .= " AND $people_table.gedcom = \"$tree\"";
    } else {
        $allwhere .= " AND $people_table.gedcom = $families_table.gedcom";
    }
    if ($assignedbranch) {
        $allwhere .= " AND $families_table.branch LIKE \"%$assignedbranch%\"";
    }
    $people_join = ", $people_table";
    $otherfields = ", firstname, lnprefix, lastname, prefix, suffix, nameorder";
    $sortstr = "lastname, lnprefix, firstname,";
} else {
    $people_join = "";
    $otherfields = "";
    $sortstr = "";
}
if ($tree) {
    $allwhere .= " AND $families_table.gedcom = \"$tree\"";
}
if ($living == "yes") {
    $allwhere .= " AND $families_table.living = \"1\"";
}

$query = "SELECT $families_table.ID as ID, familyID, husband, wife, marrdate, $families_table.gedcom as gedcom, treename, $families_table.changedby, DATE_FORMAT($families_table.changedate,\"%d %b %Y\") as changedate $otherfields FROM ($families_table, $trees_table $people_join) WHERE $allwhere ORDER BY $sortstr familyID LIMIT $newoffset" . $maxsearchresults;
$result = tng_query($query);

$numrows = tng_num_rows($result);
if ($numrows == $maxsearchresults || $offsetplus > 1) {
    $query = "SELECT count($families_table.ID) as fcount FROM ($families_table, $trees_table $people_join) WHERE $allwhere";
    $result2 = tng_query($query);
    $row = tng_fetch_assoc($result2);
    $totrows = $row['fcount'];
    tng_free_result($result2);
} else {
    $totrows = $numrows;
}

$helplang = findhelp("families_help.php");

$revstar = checkReview("F");

$flags['tabs'] = $tngconfig['tabs'];
tng_adminheader($admtext['families'], $flags);
?>
<script type="text/javascript">
    function confirmDelete(ID) {
        if (confirm('<?php echo $admtext['confdeletefam']; ?>'))
            deleteIt('family', ID, '<?php echo $tree; ?>');
        return false;
    }
</script>
<script type="text/javascript" src="js/admin.js"></script>
</head>

<body background="img/background.gif">

<?php
$familytabs[0] = array(1, "admin_families.php", $admtext['search'], "findfamily");
$familytabs[1] = array($allow_add, "admin_newfamily.php", $admtext['addnew'], "addfamily");
$familytabs[2] = array($allow_edit, "admin_findreview.php?type=F", $admtext['review'] . $revstar, "review");
$innermenu = "<a href=\"#\" onclick=\"return openHelp('$helplang/families_help.php');\" class=\"lightlink\">{$admtext['help']}</a>";
$menu = doMenu($familytabs, "findfamily", $innermenu);
echo displayHeadline($admtext['families'], "img/families_icon.gif", $menu, $message);
?>

<table width="100%" cellpadding="10" cellspacing="2" class="lightback">
    <tr class="databack">
        <td class="tngshadow">
            <div class="normal">

                <form action="admin_families.php" name="form1" id="form1">
                    <table class="normal">
                        <tr>
                            <td><?php echo $admtext['searchfor']; ?>:</td>
                            <td>
                                <?php
                                include "treequery.php";
                                ?>
                                <input type="text" name="searchstring" value="<?php echo $searchstring_noquotes; ?>" class="longfield">
                            </td>
                            <td>
                                <input type="submit" name="submit" value="<?php echo $admtext['search']; ?>" class="aligntop">
                                <input type="submit" name="submit" value="<?php echo $admtext['reset']; ?>"
                                       onClick="document.form1.searchstring.value=''; document.form1.spousename.selectedIndex=0; document.form1.tree.selectedIndex=0; document.form1.exactmatch.checked=false; document.form1.living.checked=false;"
                                       class="aligntop">
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td colspan="2">
                                <select name="spousename">
                                    <option value="husband"<?php if ($spousename == "husband") {
                                        echo " selected";
                                    } ?>><?php echo $admtext['husbname']; ?></option>
                                    <option value="wife"<?php if ($spousename == "wife") {
                                        echo " selected";
                                    } ?>><?php echo $admtext['wifename']; ?></option>
                                    <option value="none"<?php if ($spousename == "none") {
                                        echo " selected";
                                    } ?>><?php echo $admtext['noname']; ?></option>
                                </select>
                                <input type="checkbox" name="living" value="yes"<?php if ($living == "yes") {
                                    echo " checked";
                                } ?>> <?php echo $admtext['livingonly']; ?>
                                <input type="checkbox" name="exactmatch" value="yes"<?php if ($exactmatch == "yes") {
                                    echo " checked";
                                } ?>> <?php echo $admtext['exactmatch']; ?>
                            </td>
                        </tr>
                    </table>

                    <input type="hidden" name="findfamily" value="1"><input type="hidden" name="newsearch" value="1">
                </form>
                <br>

                <?php
                $numrowsplus = $numrows + $offset;
                if (!$numrowsplus) {
                    $offsetplus = 0;
                }
                echo displayListLocation($offsetplus, $numrowsplus, $totrows);
                $pagenav = get_browseitems_nav($totrows, "admin_families.php?searchstring=$searchstring&amp;spousename=$spousename&amp;living=$living&amp;exactmatch=$exactmatch&amp;offset", $maxsearchresults, 5);
                echo " &nbsp; <span class=\"adminnav\">$pagenav</span></p>";
                ?>
                <form action="admin_deleteselected.php" method="post" name="form2">
                    <?php
                    if ($allow_delete) {
                        ?>
                        <p>
                            <input type="button" name="selectall" value="<?php echo $admtext['selectall']; ?>" onClick="toggleAll(1);">
                            <input type="button" name="clearall" value="<?php echo $admtext['clearall']; ?>" onClick="toggleAll(0);">
                            <input type="submit" name="xfamaction" value="<?php echo $admtext['deleteselected']; ?>" onClick="return confirm('<?php echo $admtext['confdeleterecs']; ?>');">
                        </p>
                        <?php
                    }
                    ?>

                    <table cellpadding="3" cellspacing="1" class="normal">
                        <tr>
                            <td class="fieldnameback"><span class="fieldname">&nbsp;<b><?php echo $admtext['action']; ?></b>&nbsp;</span></td>
                            <?php if ($allow_delete) { ?>
                                <td class="fieldnameback"><span class="fieldname">&nbsp;<b><?php echo $admtext['select']; ?></b>&nbsp;</span></td>
                            <?php } ?>
                            <td class="fieldnameback"><span class="fieldname">&nbsp;<b><?php echo $admtext['id']; ?></b>&nbsp;</span></td>
                            <td class="fieldnameback"><span class="fieldname">&nbsp;<b><?php echo $admtext['husbid']; ?></b>&nbsp;</span></td>
                            <?php
                            if ($spousename == "husband") {
                                echo "<td class=\"fieldnameback\"><span class=\"fieldname\">&nbsp;<b>{$admtext['husbname']}</b>&nbsp;</span></td>\n";
                            }
                            ?>
                            <td class="fieldnameback"><span class="fieldname">&nbsp;<b><?php echo $admtext['wifeid']; ?></b>&nbsp;</span></td>
                            <?php
                            if ($spousename == "wife") {
                                echo "<td class=\"fieldnameback\"><span class=\"fieldname\">&nbsp;<b>{$admtext['wifename']}</b>&nbsp;</span></td>\n";
                            }
                            ?>
                            <td class="fieldnameback"><span class="fieldname">&nbsp;<b><?php echo $admtext['marrdate']; ?></b>&nbsp;</span></td>
                            <?php if ($numtrees > 1) { ?>
                                <td class="fieldnameback"><span class="fieldname">&nbsp;<b><?php echo $admtext['tree']; ?></b>&nbsp;</span></td>
                                <?php
                            }
                            if ($numusers > 1) {
                                ?>
                                <td class="fieldnameback"><span class="fieldname">&nbsp;<b><?php echo $admtext['lastmodified']; ?></b>&nbsp;</span></td>
                            <?php } ?>
                        </tr>

                        <?php
                        if ($numrows) {
                        $actionstr = "";
                        if ($allow_edit) {
                            $actionstr .= "<a href=\"admin_editfamily.php?familyID=xxx&amp;tree=yyy\" title=\"{$admtext['edit']}\" class=\"smallicon admin-edit-icon\"></a>";
                        }
                        if ($allow_delete) {
                            $actionstr .= "<a href=\"#\" onClick=\"return confirmDelete('zzz');\" title=\"{$admtext['text_delete']}\" class=\"smallicon admin-delete-icon\"></a>";
                        }
                        $actionstr .= "<a href=\"" . $familygroup_url . "familyID=xxx&amp;tree=yyy\" target=\"_blank\" title=\"{$admtext['test']}\" class=\"smallicon admin-test-icon\"></a>";

                        while ($row = tng_fetch_assoc($result)) {
                            $newactionstr = preg_replace("/xxx/", $row['familyID'], $actionstr);
                            $newactionstr = preg_replace("/yyy/", $row['gedcom'], $newactionstr);
                            $newactionstr = preg_replace("/zzz/", $row['ID'], $newactionstr);
                            $rights = determineLivingPrivateRights($row);
                            $row['allow_living'] = $rights['living'];
                            $row['allow_private'] = $rights['private'];

                            $editlink = "admin_editfamily.php?familyID={$row['familyID']}&amp;tree={$row['gedcom']}";
                            $id = $allow_edit ? "<a href=\"$editlink\" title=\"{$admtext['edit']}\">" . $row['familyID'] . "</a>" : $row['familyID'];

                            echo "<tr id=\"row_{$row['ID']}\"><td class=\"lightback\"><div class=\"action-btns\">$newactionstr</div></td>\n";
                            if ($allow_delete) {
                                echo "<td class=\"lightback\" align=\"center\"><input type=\"checkbox\" name=\"del{$row['ID']}\" value=\"1\"></td>";
                            }
                            echo "<td class=\"lightback\"><span class=\"normal\">&nbsp;$id&nbsp;</span></td>\n";
                            echo "<td class=\"lightback\"><span class=\"normal\">&nbsp;{$row['husband']}&nbsp;</span></td>\n";
                            if ($spousename == "husband") {
                                echo "<td class=\"lightback\"><span class=\"normal\">&nbsp;" . getName($row) . "&nbsp;</span></td>\n";
                            }
                            echo "<td class=\"lightback\"><span class=\"normal\">&nbsp;{$row['wife']}&nbsp;</span></td>\n";
                            if ($spousename == "wife") {
                                echo "<td class=\"lightback\"><span class=\"normal\">&nbsp;" . getName($row) . "&nbsp;</span></td>\n";
                            }
                            echo "<td class=\"lightback\"><span class=\"normal\">&nbsp;{$row['marrdate']}&nbsp;</span></td>\n";
                            if ($numtrees > 1) {
                                echo "<td class=\"lightback\"><span class=\"normal\">&nbsp;{$row['treename']}&nbsp;</span></td>\n";
                            }
                            if ($numusers > 1) {
                                echo "<td class=\"lightback\"><span class=\"normal\">&nbsp;{$row['changedby']}: {$row['changedate']}&nbsp;</span></td>\n";
                            }
                            echo "</tr>\n";
                        }
                        ?>
                    </table><br>
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
<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>