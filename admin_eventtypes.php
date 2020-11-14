<?php

include "begin.php";
include "adminlib.php";
require_once "admin/pagination.php";
require_once "./core/sql/extractWhereClause.php";
$textpart = "eventtypes";
include "$mylanguage/admintext.php";
$admin_login = 1;
include "checklogin.php";
include "version.php";
$tng_search_eventtypes = $_SESSION['tng_search_eventtypes'] = 1;
if ($newsearch) {
    $exptime = 05;
    $searchstring = stripslashes(trim($searchstring));
    setcookie("tng_search_eventtypes_post[search]", $searchstring, $exptime);
    setcookie("tng_search_eventtypes_post[etype]", $etype, $exptime);
    setcookie("tng_search_eventtypes_post[stype]", $stype, $exptime);
    setcookie("tng_search_eventtypes_post[onimport]", $onimport, $exptime);
    setcookie("tng_search_eventtypes_post[tngpage]", 1, $exptime);
    setcookie("tng_search_eventtypes_post[offset]", 0, $exptime);
} else {
    if (!$searchstring) {
        $searchstring = stripslashes($_COOKIE['tng_search_eventtypes_post']['search']);
    }
    if (!$etype) {
        $etype = $_COOKIE['tng_search_eventtypes_post']['etype'];
    }
    if (!$stype) {
        $stype = $_COOKIE['tng_search_eventtypes_post']['stype'];
    }
    if (!$onimport) {
        $onimport = $_COOKIE['tng_search_eventtypes_post']['onimport'];
    }
    if (!isset($offset)) {
        $tngpage = $_COOKIE['tng_search_eventtypes_post']['tngpage'];
        $offset = $_COOKIE['tng_search_eventtypes_post']['offset'];
    } else {
        $exptime = 0;
        setcookie("tng_search_eventtypes_post[tngpage]", $tngpage, $exptime);
        setcookie("tng_search_eventtypes_post[offset]", $offset, $exptime);
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

$query = "SELECT eventtypes.eventtypeID, tag, description, display, type, keep, collapse, ordernum, count(eventID) AS total_events ";
$query .= "FROM $eventtypes_table eventtypes ";
$query .= "LEFT JOIN $events_table events ON eventtypes.eventtypeID = events.eventtypeID ";

$restrictions = [];
if ($searchstring) {
    array_push($restrictions, "(tag LIKE '%$searchstring%' OR description LIKE '%$searchstring%' OR display LIKE '%$searchstring%')");
}
if ($etype) array_push($restrictions, "type = '$etype'");

if ($onimport || $onimport === "0") {
    array_push($restrictions, "keep = '$onimport'");
}
if (!empty($restrictions)) {
    $query .= "WHERE " . implode(" AND ", $restrictions) . " ";
}
$query .= "GROUP BY eventtypeID ";
$query .= "ORDER BY ";
if ($stype == "E") $query .= "total_events DESC, ";

$query .= "tag, description ";
$query .= "LIMIT $newoffset" . $maxsearchresults;
$result = tng_query($query);

$numrows = tng_num_rows($result);
if ($numrows == $maxsearchresults || $offsetplus > 1) {
    $query2 = "SELECT count(eventtypeID) AS ecount ";
    $query2 .= "FROM $eventtypes_table ";
    $query2 .= extractWhereClause($query, ["GROUP BY"]);
    $result2 = tng_query($query2);
    $row = tng_fetch_assoc($result2);
    $totrows = $row['ecount'];
    tng_free_result($result2);
} else {
    $totrows = $numrows;
}
$helplang = findhelp("eventtypes_help.php");

tng_adminheader(_('Event Types'), $flags);
?>
    <script>
        function confirmDelete(ID) {
            if (confirm('<?php echo _('Are you sure you want to delete this event type?'); ?>'))
                deleteIt('eventtype', ID);
            return false;
        }
    </script>

<?php
echo "</head>\n";
echo tng_adminlayout();

$evtabs['0'] = [1, "admin_eventtypes.php", _('Search'), "findevent"];
$evtabs['1'] = [$allow_add, "admin_neweventtype.php", _('Add New'), "addevent"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/eventtypes_help.php#modify');\" class='lightlink'>" . _('Help for this area') . "</a>";
$menu = doMenu($evtabs, "findevent", $innermenu);
echo displayHeadline(_('Custom Event Types'), "img/customeventtypes_icon.gif", $menu, $message);
?>
    <table class="lightback">
        <tr class="databack">
            <td class="tngshadow">
                <div class="normal">
                    <form action="admin_eventtypes.php" name="form1">
                        <table class="normal">
                            <tr>
                                <td><?php echo _('Search for'); ?>:</td>
                                <td>
                                    <input class="longfield" name="searchstring" type="search" value="<?php echo $searchstring; ?>">
                                </td>
                                <td>
                                    <input type="submit" name="submit" value="<?php echo _('Search'); ?>" class="align-top">
                                    <input type="submit" name="submit" value="<?php echo _('Reset'); ?>"
                                        onClick="document.form1.searchstring.value=''; document.form1.etype.selectedIndex=0; document.form1.onimport['2'].checked=true;" class="align-top">
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Associated with'); ?>:</td>
                                <td>
                                    <select name="etype">
                                        <option value=""><?php echo _('All'); ?></option>
                                        <option value="I"<?php if ($etype == "I") {
                                            echo " selected";
                                        } ?>><?php echo _('Individual'); ?></option>
                                        <option value="F"<?php if ($etype == "F") {
                                            echo " selected";
                                        } ?>><?php echo _('Family'); ?></option>
                                        <option value="S"<?php if ($etype == "S") {
                                            echo " selected";
                                        } ?>><?php echo _('Source'); ?></option>
                                        <option value="R"<?php if ($etype == "R") {
                                            echo " selected";
                                        } ?>><?php echo _('Repository'); ?></option>
                                    </select> &nbsp;
                                    <?php echo _('Sort by'); ?>:
                                    <select name="stype">
                                        <option value="T"<?php if (!$stype || $stype == "T") {
                                            echo " selected";
                                        } ?>><?php echo _('Tag'); ?></option>
                                        <option value="E"<?php if ($stype == "E") {
                                            echo " selected";
                                        } ?>><?php echo _('Events'); ?></option>
                                    </select>
                                </td>
                                <td>
                                    <input type="radio" name="onimport" value="1"<?php if ($onimport) {
                                        echo " checked";
                                    } ?>> <?php echo _('Accept'); ?>
                                    <input type="radio" name="onimport" value="0"<?php if ($onimport === "0") {
                                        echo " checked";
                                    } ?>> <?php echo _('Ignore'); ?>
                                    <input type="radio" name="onimport" value=""<?php if ($onimport === null || $onimport === "") {
                                        echo " checked";
                                    } ?>> <?php echo _('All'); ?>
                                </td>
                            </tr>
                        </table>

                        <input type="hidden" name="findeventtype" value="1">
                        <input type="hidden" name="newsearch" value="1">
                    </form>
                    <?php
                    $numrowsplus = $numrows + $offset;
                    if (!$numrowsplus) $offsetplus = 0;
                    ?>
                    <form action="admin_updateselectedeventtypes.php" method="post" name="form2">
                        <p>
                            <input type="button" name="selectall" value="<?php echo _('Select All'); ?>" onClick="toggleAll(1);">
                            <input type="button" name="clearall" value="<?php echo _('Clear All'); ?>" onClick="toggleAll(0);">&nbsp;&nbsp;
                            <?php if ($allow_delete) { ?>
                                <input type="submit" name="cetaction" value="<?php echo _('Delete Selected'); ?>" onClick="return confirm('<?php echo _('Are you sure you want to delete the selected records?'); ?>');">
                                <?php
                            }
                            if ($allow_edit) {
                            ?>
                            <input type="submit" name="cetaction" value="<?php echo _('Accept Selected'); ?>">
                            <input type="submit" name="cetaction" value="<?php echo _('Ignore Selected'); ?>">
                            <input type="submit" name="cetaction" value="<?php echo _('Collapse Selected'); ?>">
                            <input type="submit" name="cetaction" value="<?php echo _('Expand Selected'); ?>">
                        </p>
                        <?php } ?>

                        <table class="normal">
                            <tr>
                                <th class="fieldnameback fieldname"><?php echo _('Action'); ?></th>
                                <?php if ($allow_delete || $allow_edit) { ?>
                                    <th class="fieldnameback fieldname"><?php echo _('Select'); ?></th>
                                <?php } ?>
                                <th class="fieldnameback fieldname"><?php echo _('Tag'); ?></th>
                                <th class="fieldnameback fieldname"><?php echo _('Type/Description'); ?></th>
                                <th class="fieldnameback fieldname"><?php echo _('Display'); ?></th>
                                <th class="fieldnameback fieldname"><?php echo _('Order #'); ?></th>
                                <th class="fieldnameback fieldname"><?php echo _('Ind/Fam'); ?></th>
                                <th class="fieldnameback fieldname"><?php echo _('On Import'); ?></th>
                                <th class="fieldnameback fieldname"><?php echo _('Collapse'); ?></th>
                                <th class="fieldnameback fieldname"><?php echo _('Events'); ?></th>
                            </tr>

                            <?php
                            if ($numrows) {
                            $actionstr = "";
                            if ($allow_edit) {
                                $actionstr .= "<a href=\"admin_editeventtype.php?eventtypeID=xxx\" title=\"" . _('Edit') . "\" class='smallicon admin-edit-icon'></a>";
                            }
                            if ($allow_delete) {
                                $actionstr .= "<a href='#' onClick=\"return confirmDelete('xxx');\" title=\"" . _('Delete') . "\" class='smallicon admin-delete-icon'></a>";
                        }
                        while ($row = tng_fetch_assoc($result)) {
                            $keep = $row['keep'] ? _('Accept') : _('Ignore');
                            $collapse = $row['collapse'] ? _('Yes') : _('No');
                            switch ($row['type']) {
                                case "I":
                                    $type = _('Individual');
                                    break;
                                case "F":
                                    $type = _('Family');
                                    break;
                                case "S":
                                    $type = _('Source');
                                    break;
                                case "R":
                                    $type = _('Repository');
                                    break;
                            }
                            $displayval = getEventDisplay($row['display']);
                            $newactionstr = preg_replace("/xxx/", $row['eventtypeID'], $actionstr);
                            echo "<tr id=\"row_{$row['eventtypeID']}\">\n";
                            echo "<td class='lightback'><div class=\"action-btns2\">$newactionstr</div></td>\n";
                            if ($allow_delete || $allow_edit) {
                                echo "<td class='lightback text-center'><input type='checkbox' name=\"et{$row['eventtypeID']}\" value='1'></td>\n";
                            }
                            echo "<td class='lightback'>&nbsp;{$row['tag']}&nbsp;</td>\n";
                            echo "<td class='lightback'>&nbsp;{$row['description']}&nbsp;</td>\n";
                            echo "<td class='lightback'>&nbsp;$displayval&nbsp;</td>\n";
                            echo "<td class='lightback'>{$row['ordernum']}</td>";
                            echo "<td class='lightback'>&nbsp;$type&nbsp;</td>";
                            echo "<td class='lightback'>&nbsp;$keep&nbsp;</td>";
                            echo "<td class='lightback'>&nbsp;$collapse&nbsp;</td>";
                            echo "<td class='lightback' style=\"text-align:right;\">&nbsp;" . number_format($row['total_events']) . "&nbsp;</td>";
                            echo "</tr>\n";
                        }
                        ?>
                    </table>
                <?php
                echo "<div class='w-full class=lg:flex my-6'>";
                echo getPaginationLocationHtml($offsetplus, $numrowsplus, $totrows);
                echo getPaginationControlsHtml($totrows, "admin_eventtypes.php?searchstring=$searchstring&amp;etype=$etype&amp;stype=$stype&amp;onimport=$onimport&amp;offset", $maxsearchresults, 3);
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