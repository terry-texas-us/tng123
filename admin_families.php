<?php

include "begin.php";
include "adminlib.php";
require_once "admin/pagination.php";
$textpart = "families";
include "$mylanguage/admintext.php";
$admin_login = 1;
include "checklogin.php";
include "version.php";
require_once "./core/html/addCriteria.php";

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
    if (!$tree) $tree = $_COOKIE['tng_tree'];

    if (!$living) {
        $living = $_COOKIE['tng_search_families_post']['living'];
    }
    if (!$exactmatch) {
        $exactmatch = $_COOKIE['tng_search_families_post']['exactmatch'];
    }
    if (!$spousename) {
        $spousename = $_COOKIE['tng_search_families_post']['spousename'];
        if (!$spousename) $spousename = "husband";

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
    $wherestr = "WHERE gedcom = '$assignedtree'";
    $tree = $assignedtree;
} else {
    $wherestr = "";
}
$orgtree = $tree;

$uquery = "SELECT COUNT(userID) AS ucount FROM $users_table WHERE allow_living = '-1'";
$uresult = tng_query($uquery) or die (_('Cannot execute query') . ": $uquery");
$urow = tng_fetch_assoc($uresult);
$numusers = $urow['ucount'];
tng_free_result($uresult);

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
        $allwhere .= " AND $people_table.gedcom = '$tree'";
    } else {
        $allwhere .= " AND $people_table.gedcom = $families_table.gedcom";
    }
    if ($assignedbranch) {
        $allwhere .= " AND $families_table.branch LIKE '%$assignedbranch%'";
    }
    $people_join = ", $people_table";
    $otherfields = ", firstname, lnprefix, lastname, prefix, suffix, nameorder";
    $sortstr = "lastname, lnprefix, firstname,";
} else {
    $people_join = "";
    $otherfields = "";
    $sortstr = "";
}
if ($tree) $allwhere .= " AND $families_table.gedcom = '$tree'";

if ($living == "yes") {
    $allwhere .= " AND $families_table.living = '1'";
}

$query = "SELECT $families_table.ID AS ID, familyID, husband, wife, marrdate, $families_table.gedcom AS gedcom, treename, $families_table.changedby, DATE_FORMAT($families_table.changedate,\"%d %b %Y\") AS changedate $otherfields FROM ($families_table, $trees_table $people_join) WHERE $allwhere ORDER BY $sortstr familyID LIMIT $newoffset" . $maxsearchresults;
$result = tng_query($query);

$numrows = tng_num_rows($result);
if ($numrows == $maxsearchresults || $offsetplus > 1) {
    $query = "SELECT count($families_table.ID) AS fcount FROM ($families_table, $trees_table $people_join) WHERE $allwhere";
    $result2 = tng_query($query);
    $row = tng_fetch_assoc($result2);
    $totrows = $row['fcount'];
    tng_free_result($result2);
} else {
    $totrows = $numrows;
}

$helplang = findhelp("families_help.php");

$revstar = checkReview("F");

tng_adminheader(_('Families'), $flags);
?>
    <script>
        function confirmDelete(ID) {
            if (confirm('<?php echo _('Are you sure you want to delete this family?'); ?>'))
                deleteIt('family', ID, '<?php echo $tree; ?>');
            return false;
        }
    </script>

<?php
echo "</head>\n";
echo tng_adminlayout();

$familytabs[0] = [1, "admin_families.php", _('Search'), "findfamily"];
$familytabs[1] = [$allow_add, "admin_newfamily.php", _('Add New'), "addfamily"];
$familytabs[2] = [$allow_edit, "admin_findreview.php?type=F", _('Review') . $revstar, "review"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/families_help.php');\" class='lightlink'>" . _('Help for this area') . "</a>";
$menu = doMenu($familytabs, "findfamily", $innermenu);
echo displayHeadline(_('Families'), "img/families_icon.gif", $menu, $message);
?>

    <table class="lightback">
        <tr class="databack">
            <td class="tngshadow">
                <div class="normal">

                    <form action="admin_families.php" name="form1" id="form1">
                        <table class="normal">
                            <tr>
                                <td><?php echo _('Search for'); ?>:</td>
                                <td>
                                    <?php include "treequery.php"; ?>
                                    <input class="longfield" name="searchstring" type="search" value="<?php echo $searchstring_noquotes; ?>">
                                </td>
                                <td>
                                    <input type="submit" name="submit" value="<?php echo _('Search'); ?>" class="align-top">
                                    <input type="submit" name="submit" value="<?php echo _('Reset'); ?>"
                                        onClick="document.form1.searchstring.value=''; document.form1.spousename.selectedIndex=0; document.form1.tree.selectedIndex=0; document.form1.exactmatch.checked=false; document.form1.living.checked=false;"
                                        class="align-top">
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td colspan="2">
                                    <select name="spousename">
                                        <option value="husband"<?php if ($spousename == "husband") {
                                            echo " selected";
                                        } ?>><?php echo _('Father\'s Name'); ?></option>
                                        <option value="wife"<?php if ($spousename == "wife") {
                                            echo " selected";
                                        } ?>><?php echo _('Mother\'s Name'); ?></option>
                                        <option value="none"<?php if ($spousename == "none") {
                                            echo " selected";
                                        } ?>><?php echo _('No Name'); ?></option>
                                    </select>
                                    <input type="checkbox" name="living" value="yes"<?php if ($living == "yes") {
                                        echo " checked";
                                    } ?>> <?php echo _('Living only'); ?>
                                    <input type="checkbox" name="exactmatch" value="yes"<?php if ($exactmatch == "yes") {
                                        echo " checked";
                                    } ?>> <?php echo _('Exact match only'); ?>
                                </td>
                            </tr>
                        </table>

                        <input type="hidden" name="findfamily" value="1">
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
                            <input type="submit" name="xfamaction" value="<?php echo _('Delete Selected'); ?>" onClick="return confirm('<?php echo _('Are you sure you want to delete the selected records?'); ?>');">
                        </p>
                    <?php } ?>

                    <table class="normal">
                        <tr>
                            <th class="fieldnameback"><span class="fieldname"><?php echo _('Action'); ?></span></th>
                            <?php if ($allow_delete) { ?>
                                <th class="fieldnameback"><span class="fieldname"><?php echo _('Select'); ?></span></th>
                            <?php } ?>
                            <th class="fieldnameback"><span class="fieldname"><?php echo _('ID'); ?></span></th>
                            <th class="fieldnameback"><span class="fieldname"><?php echo _('Father ID'); ?></span></th>
                            <?php
                            if ($spousename == "husband") {
                                echo "<th class='fieldnameback'><span class='fieldname'>{_('Father\'s Name')}</span></th>\n";
                            }
                            ?>
                            <th class="fieldnameback"><span class="fieldname"><?php echo _('Mother ID'); ?></span></th>
                            <?php
                            if ($spousename == "wife") {
                                echo "<th class='fieldnameback'><span class='fieldname'>{_('Mother\'s Name')}</span></th>\n";
                            }
                            ?>
                            <th class="fieldnameback"><span class="fieldname"><?php echo _('Marr Date'); ?></span></th>
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
                            $actionstr .= "<a href=\"admin_editfamily.php?familyID=xxx&amp;tree=yyy\" title=\"" . _('Edit') . "\" class='smallicon admin-edit-icon'></a>";
                        }
                        if ($allow_delete) {
                            $actionstr .= "<a href='#' onClick=\"return confirmDelete('zzz');\" title=\"" . _('Delete') . "\" class='smallicon admin-delete-icon'></a>";
                        }
                        $actionstr .= "<a href=\"familygroup.php?familyID=xxx&amp;tree=yyy\" target='_blank' title=\"" . _('Test') . "\" class='smallicon admin-test-icon'></a>";

                        while ($row = tng_fetch_assoc($result)) {
                            $newactionstr = preg_replace("/xxx/", $row['familyID'], $actionstr);
                            $newactionstr = preg_replace("/yyy/", $row['gedcom'], $newactionstr);
                            $newactionstr = preg_replace("/zzz/", $row['ID'], $newactionstr);
                            $rights = determineLivingPrivateRights($row);
                            $row['allow_living'] = $rights['living'];
                            $row['allow_private'] = $rights['private'];

                            $editlink = "admin_editfamily.php?familyID={$row['familyID']}&amp;tree={$row['gedcom']}";
                            $id = $allow_edit ? "<a href=\"$editlink\" title=\"" . _('Edit') . "\">" . $row['familyID'] . "</a>" : $row['familyID'];

                            echo "<tr id=\"row_{$row['ID']}\"><td class='lightback'><div class='action-btns'>$newactionstr</div></td>\n";
                            if ($allow_delete) {
                                echo "<td class='lightback text-center'><input type='checkbox' name=\"del{$row['ID']}\" value='1'></td>";
                            }
                            echo "<td class='lightback'><span class='normal'>&nbsp;$id&nbsp;</span></td>\n";
                            echo "<td class='lightback'><span class='normal'>&nbsp;{$row['husband']}&nbsp;</span></td>\n";
                            if ($spousename == "husband") {
                                echo "<td class='lightback'><span class='normal'>&nbsp;" . getName($row) . "&nbsp;</span></td>\n";
                            }
                            echo "<td class='lightback'><span class='normal'>&nbsp;{$row['wife']}&nbsp;</span></td>\n";
                            if ($spousename == "wife") {
                                echo "<td class='lightback'><span class='normal'>&nbsp;" . getName($row) . "&nbsp;</span></td>\n";
                            }
                            echo "<td class='lightback'><span class='normal'>&nbsp;{$row['marrdate']}&nbsp;</span></td>\n";
                            if ($numtrees > 1) {
                                echo "<td class='lightback'><span class='normal'>&nbsp;{$row['treename']}&nbsp;</span></td>\n";
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
                echo getPaginationControlsHtml($totrows, "admin_families.php?searchstring=$searchstring&amp;spousename=$spousename&amp;living=$living&amp;exactmatch=$exactmatch&amp;offset", $maxsearchresults, 3);
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