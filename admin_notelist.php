<?php

include "begin.php";
include "config/mapconfig.php";
include "adminlib.php";
require_once "./core/sql/extractWhereClause.php";
require_once "admin/pagination.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
$orgtree = $tree;
$exptime = 0;

$searchstring_noquotes = stripslashes(preg_replace("/\"/", "&#34;", $searchstring));
$searchstring = addslashes($searchstring);

if ($newsearch) {
    setcookie("tng_search_notes_post[search]", $searchstring_noquotes, $exptime);
    setcookie("tng_tree", $tree, $exptime);
    setcookie("tng_search_notes_post[tngpage]", 1, $exptime);
    setcookie("tng_search_notes_post[offset]", 0, $exptime);
    setcookie("tng_search_notes_post[private]", $private, $exptime);
} else {
    if (!$searchstring) {
        $searchstring_noquotes = $_COOKIE['tng_search_notes_post']['search'];
        $searchstring = preg_replace("/&#34;/", "\\\"", $searchstring_noquotes);
    }
    if (!$private) {
        $private = $_COOKIE['tng_search_notes_post']['private'];
    }
    if (!$tree) $tree = $_COOKIE['tng_tree'];

    if (!isset($offset)) {
        $tngpage = $_COOKIE['tng_search_notes_post']['tngpage'];
        $offset = $_COOKIE['tng_search_notes_post']['offset'];
    } else {
        setcookie("tng_search_notes_post[tngpage]", $tngpage, $exptime);
        setcookie("tng_search_notes_post[offset]", $offset, $exptime);
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
$treequery = "SELECT gedcom, treename ";
$treequery .= "FROM $trees_table ";
if ($assignedtree) $treequery .= "WHERE gedcom = '$assignedtree' ";

$treequery .= "ORDER BY treename";

$query = "SELECT xnotes.ID AS ID, xnotes.note AS note, xnotes.gedcom AS gedcom ";
$query .= "FROM $xnotes_table xnotes, $notelinks_table notelinks ";
$query .= "WHERE xnotes.ID = notelinks.xnoteID ";
if ($tree) $query .= "AND xnotes.gedcom = '$tree' ";

if ($private) $query .= "AND notelinks.secret != 0 ";

if ($searchstring) {
    $query .= "AND (xnotes.note LIKE '%$searchstring%') ";
}
$query .= "ORDER BY note ";
$query .= "LIMIT $newoffset" . $maxsearchresults;

$result = tng_query($query);

$numrows = tng_num_rows($result);
if ($numrows == $maxsearchresults || $offsetplus > 1) {
    $query2 = "SELECT count(xnotes.ID) AS scount ";
    $query2 .= "FROM ($xnotes_table xnotes, $notelinks_table notelinks) ";
    $query2 .= extractWhereClause($query);
    $result2 = tng_query($query2);
    $row = tng_fetch_assoc($result2);
    $totrows = $row['scount'];
    tng_free_result($result2);
} else {
    $totrows = $numrows;
}
$helplang = findhelp("notes_help.php");

tng_adminheader(_('Notes'), $flags);
?>

<?php
echo "</head>\n";
echo tng_adminlayout();

$misctabs[0] = [1, "admin_notelist.php", _('Notes'), "notes"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/notes2_help.php');\" class='lightlink'>" . _('Help for this area') . "</a>";
$menu = doMenu($misctabs, "notes", $innermenu);
echo displayHeadline(_('Notes'), "img/misc_icon.gif", $menu, $message);
?>
    <table class="lightback">
        <tr class="databack">
            <td class="tngshadow">
                <div class="normal">
                    <form action="admin_notelist.php" name="form1" id="form1">
                        <table class="normal">
                            <tr>
                                <td><?php echo _('Search for'); ?>:</td>
                                <td>
                                    <select name="tree">
                                        <?php
                                        if (!$assignedtree) echo "<option value=''>" . _('All Trees') . "</option>\n";
                                        $treeresult = tng_query($treequery) or die (_('Cannot execute query') . ": $treequery");
                                        $trees = tng_fetch_all($treeresult);
                                        tng_free_result($treeresult);
                                        foreach ($trees as $treerow) {
                                            echo "	<option value=\"{$treerow['gedcom']}\"";
                                            if ($treerow['gedcom'] == $tree) echo " selected";
                                            echo ">{$treerow['treename']}</option>\n";
                                        }
                                        ?>
                                    </select>
                                    <input class="longfield" name="searchstring" type="search" value="<?php echo $searchstring_noquotes; ?>">
                                </td>
                                <td>
                                    <input type="submit" name="submit" value="<?php echo _('Search'); ?>" class="align-top">
                                    <input type="submit" name="submit" value="<?php echo _('Reset'); ?>" onClick="resetForm();" class="align-top">
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td colspan="2">
                                    <input type="checkbox" name="private" value="yes"<?php if ($private == "yes") {
                                        echo " checked";
                                    } ?>> <?php echo _('Private'); ?></td>
                            </tr>
                        </table>

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
                                <input type="submit" name="xnoteaction" value="<?php echo _('Delete Selected'); ?>" onClick="return confirm('<?php echo _('Are you sure you want to delete the selected records?'); ?>');">
                            </p>
                        <?php } ?>

                        <table class="normal">
                            <tr>
                                <th class="fieldnameback fieldname"><?php echo _('Action'); ?></th>
                                <?php if ($allow_delete) { ?>
                                    <th class="fieldnameback fieldname"><?php echo _('Select'); ?></th>
                                <?php } ?>
                                <th class="fieldnameback fieldname"><?php echo _('Note'); ?></th>
                                <?php if (!$tree) { ?>
                                    <th class="fieldnameback fieldname"><?php echo _('Tree'); ?></th>
                                <?php } ?>
                                <th class="fieldnameback fieldname"><?php echo _('Linked to'); ?></th>
                            </tr>
                            <?php
                            if ($numrows) {
                            $actionstr = "";
                            if ($allow_edit) {
                                $actionstr .= "<a href=\"admin_editnote2.php?ID=xxx\" title=\"" . _('Edit') . "\" class='smallicon admin-edit-icon'></a>";
                            }
                            if ($allow_delete) {
                                $actionstr .= "<a href='#' onClick=\"return confirmDelete('xxx');\" title=\"" . _('Delete') . "\" class='smallicon admin-delete-icon'></a>";
                            }

                        while ($row = tng_fetch_assoc($result)) {
                            $newactionstr = preg_replace("/xxx/", $row['ID'], $actionstr);
                            echo "<tr id=\"row_{$row['ID']}\"><td class='lightback'><div class=\"action-btns2\">$newactionstr</div></td>\n";
                            if ($allow_delete) {
                                echo "<td class='lightback text-center'><input type='checkbox' name=\"del{$row['ID']}\" value='1'></td>";
                            }
                            $query = "SELECT $notelinks_table.ID, $notelinks_table.persfamID AS personID, $notelinks_table.gedcom, secret ";
                            $query .= "FROM $notelinks_table ";
                            $query .= "WHERE $notelinks_table.xnoteID = \"{$row['ID']}\" ";
                            $nresult = tng_query($query);
                            $notelinktext = "";
                            while ($nrow = tng_fetch_assoc($nresult)) {
                                $treetext = "";
                                if (!$tree) {
                                    $query = "SELECT treename FROM " . $trees_table . " WHERE gedcom = \"{$nrow['gedcom']}\"";
                                    $result2 = tng_query($query);
                                    $row2 = tng_fetch_assoc($result2);
                                    $treetext = "<td class='lightback'>" . $row2['treename'] . "</td>";
                                    tng_free_result($result2);
                                }

                                if (!$notelinktext) {
                                    $query = "SELECT * FROM $people_table WHERE personID = \"{$nrow['personID']}\" AND gedcom = \"{$nrow['gedcom']}\"";
                                    $result2 = tng_query($query);
                                    if (tng_num_rows($result2) == 1) {
                                        $row2 = tng_fetch_assoc($result2);
                                        $nrights = determineLivingPrivateRights($row2);
                                        $row2['allow_living'] = $nrights['living'];
                                        $row2['allow_private'] = $nrights['private'];
                                        $notelinktext .= "<li><a href=\"getperson.php?personID={$row2['personID']}&tree={$row2['gedcom']}\" target='_blank'>" . getNameRev($row2) . " ({$row2['personID']})</a></li>\n";
                                        tng_free_result($result2);
                                    }
                                }
                                if (!$notelinktext) {
                                    $query = "SELECT * FROM $families_table WHERE familyID = \"{$nrow['personID']}\" AND gedcom = \"{$nrow['gedcom']}\"";
                                    $result2 = tng_query($query);
                                    if (tng_num_rows($result2) == 1) {
                                        $row2 = tng_fetch_assoc($result2);
                                        $nrights = determineLivingPrivateRights($row2);
                                        $row2['allow_living'] = $nrights['living'];
                                        $row2['allow_private'] = $nrights['private'];
                                        $notelinktext .= "<li><a href=\"familygroup.php?familyID={$row2['familyID']}&tree={$nrow['gedcom']}\" target='_blank'>" . _('Family') . " {$row2['familyID']}</a></li>\n";
                                        tng_free_result($result2);
                                    }
                                }
                                if (!$notelinktext) {
                                    $query = "SELECT * FROM $sources_table WHERE sourceID = \"{$nrow['personID']}\" AND gedcom = \"{$nrow['gedcom']}\"";
                                    $result2 = tng_query($query);
                                    if (tng_num_rows($result2) == 1) {
                                        $row2 = tng_fetch_assoc($result2);
                                        $notelinktext .= "<li><a href=\"showsource.php?sourceID={$row2['sourceID']}&tree={$row2['gedcom']}\" target='_blank'>" . _('Source') . " $sourcetext ({$row2['sourceID']})</a></li>\n";
                                        tng_free_result($result2);
                                    }
                                }
                                if (!$notelinktext) {
                                    $query = "SELECT * FROM $repositories_table WHERE repoID = \"{$nrow['personID']}\" AND gedcom = \"{$nrow['gedcom']}\"";
                                    $result2 = tng_query($query);
                                    if (tng_num_rows($result2) == 1) {
                                        $row2 = tng_fetch_assoc($result2);
                                        $notelinktext .= "<li><a href=\"showrepo.php?repoID={$row2['repoID']}&tree={$row2['gedcom']}\" target='_blank'>" . _('Repository') . " $sourcetext ({$row2['repoID']})</a></li>\n";
                                        tng_free_result($result2);
                                    }
                                }
                            }
                            tng_free_result($nresult);
                            if (($allow_edit && !$assignedtree) || !$row['secret']) {
                                $notetext = cleanIt($row['note']);
                                $notetext = truncateIt($notetext, 500);
                                if (!$notetext) $notetext = "&nbsp;";
                            } else {
                                $notetext = _('Private');
                            }
                            echo "<td class='lightback'>$notetext</td>\n";
                            echo $treetext;
                            echo "<td class='lightback whitespace-no-wrap'>\n";
                            echo "<ul>\n$notelinktext\n</ul>\n";
                            echo "</td>\n";
                            echo "</tr>\n";
                        }
                        ?>
                    </table>
                <?php
                echo "<div class='w-full class=lg:flex my-6'>";
                echo getPaginationLocationHtml($offsetplus, $numrowsplus, $totrows);
                echo getToPageHtml("admin_notelist.php?searchstring=$searchstring_noquotes&amp;offset", 3);
                echo getPaginationControlsHtml($totrows, "admin_notelist.php?searchstring=$searchstring_noquotes&amp;offset", $maxsearchresults, 3);
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
    <script>
        function validateForm() {
            let rval = true;
            if (document.form1.searchstring.value.length === 0) {
                alert("<?php echo _('Please enter a search value.'); ?>");
                rval = false;
            }
            return rval;
        }

        function confirmDelete(ID) {
            if (confirm('<?php echo _('Are you sure you want to delete this note?'); ?>'))
                deleteIt('note', ID);
            return false;
        }

        function resetForm() {
            document.form1.searchstring.value = '';
            document.form1.tree.selectedIndex = 0;
        }
    </script>
<?php echo tng_adminfooter(); ?>