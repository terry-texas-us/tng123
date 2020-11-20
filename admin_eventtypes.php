<?php

include "begin.php";
include "adminlib.php";
require_once "admin/pagination.php";
require_once "./core/sql/extractWhereClause.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
$tng_search_eventtypes = $_SESSION['tng_search_eventtypes'] = 1;
if (!empty($newsearch)) {
    $exptime = 05;
    $searchstring = stripslashes(trim($searchstring));
    setcookie("tng_search_eventtypes_post[search]", $searchstring, $exptime);
    setcookie("tng_search_eventtypes_post[etype]", $etype, $exptime);
    setcookie("tng_search_eventtypes_post[stype]", $stype, $exptime);
    setcookie("tng_search_eventtypes_post[onimport]", $onimport, $exptime);
    setcookie("tng_search_eventtypes_post[tngpage]", 1, $exptime);
    setcookie("tng_search_eventtypes_post[offset]", 0, $exptime);
} else {
    if (empty($searchstring)) {
        $searchstring = isset($_COOKIE['tng_search_eventtypes_post']['search']) ? stripslashes($_COOKIE['tng_search_eventtypes_post']['search']) : "";
    }
    if (empty($onimport)) {
        $onimport = isset($_COOKIE['tng_search_eventtypes_post']['onimport']) ? $_COOKIE['tng_search_eventtypes_post']['onimport'] : "";
    }
    if (!isset($offset)) {
        $tngpage = isset($_COOKIE['tng_search_eventtypes_post']['tngpage']) ? $_COOKIE['tng_search_eventtypes_post']['tngpage'] : 1;
        $offset = isset($_COOKIE['tng_search_eventtypes_post']['offset']) ? $_COOKIE['tng_search_eventtypes_post']['offset'] : 0;
    } else {
        $exptime = 0;
        if (!isset($tngpage)) $tngpage = 1;
        if (!isset($offset)) $offset = 0;
        setcookie("tng_search_eventtypes_post[tngpage]", $tngpage, $exptime);
        setcookie("tng_search_eventtypes_post[offset]", $offset, $exptime);
    }
}

if ($order) {
    setcookie("tng_search_eventtypes_post[order]", $order, $exptime);
} else {
    $order = isset($_COOKIE['tng_search_eventtypes_post']['order']) ? $_COOKIE['tng_search_eventtypes_post']['order'] : "tag";
}

if (!isset($offset)) $offset = 0;
if ($offset) {
    $offsetplus = $offset + 1;
    $newoffset = "$offset, ";
} else {
    $offsetplus = 1;
    $newoffset = "";
    $tngpage = 1;
}

$tagsort = "tag";
$typesort = "type";
$dispsort = "disp";
$evsort = "ev";

$iconSortAlphaDown = buildSvgElement("img/sort-alpha-down.svg", ["class" => "w-4 h-4 ml-1 fill-current inline-block"]);
$iconSortAlphaUp = buildSvgElement("img/sort-alpha-up.svg", ["class" => "w-4 h-4 ml-1 fill-current inline-block"]);

if ($order == "tag") {
    $orderstr = "tag, description";
    $tagsort = "<a href='admin_eventtypes.php?order=tagup' class='whitespace-no-wrap lightlink'>" . _('Tag') . "$iconSortAlphaDown</a>";
} else {
    $tagsort = "<a href='admin_eventtypes.php?order=tag' class='whitespace-no-wrap lightlink'>" . _('Tag') . "$iconSortAlphaUp</a>";
    if ($order == "tagup") $orderstr = "tag DESC, description DESC";
}

if ($order == "type") {
    $orderstr = "type, tag, description";
    $typesort = "<a href='admin_eventtypes.php?order=typeup' class='lightlink whitespace-no-wrap'>" . _('Type/Description') . "$iconSortAlphaDown</a>";
} else {
    $typesort = "<a href='admin_eventtypes.php?order=type' class='lightlink whitespace-no-wrap'>" . _('Type/Description') . "$iconSortAlphaUp</a>";
    if ($order == "typeup") $orderstr = "type DESC, tag DESC, description DESC";
}

if ($order == "disp") {
    $orderstr = "description, tag";
    $dispsort = "<a href='admin_eventtypes.php?order=dispup' class='lightlink whitespace-no-wrap'>" . _('Display') . "$iconSortAlphaDown</a>";
} else {
    $dispsort = "<a href='admin_eventtypes.php?order=disp' class='lightlink whitespace-no-wrap'>" . _('Display') . "$iconSortAlphaUp</a>";
    if ($order == "dispup") $orderstr = "description DESC, tag DESC";
}

if ($order == "ev") {
    $iconSortNumericUp = buildSvgElement("img/sort-numeric-up.svg", ["class" => "w-4 h-4 ml-1 fill-current inline-block"]);
    $orderstr = "total_events DESC, tag";
    $evsort = "<a href='admin_eventtypes.php?order=evup' class='lightlink whitespace-no-wrap'>" . _('Events') . "$iconSortNumericUp</a>";
} else {
    $iconSortNumericDown = buildSvgElement("img/sort-numeric-down.svg", ["class" => "w-4 h-4 ml-1 fill-current inline-block"]);
    $evsort = "<a href='admin_eventtypes.php?order=ev' class='lightlink whitespace-no-wrap'>" . _('Events') . "$iconSortNumericDown</a>";
    if ($order == "evup") $orderstr = "total_events, tag";
}

$wherestr = $searchstring ? "(tag LIKE '%$searchstring%' OR description LIKE '%$searchstring%' OR display LIKE '%$searchstring%')" : "";
if ($etype) $wherestr .= $wherestr ? " AND type = '$etype'" : "type = '$etype'";
if ($onimport || $onimport === "0") $wherestr .= $wherestr ? " AND keep = '$onimport'" : "keep = '$onimport'";
if ($wherestr) $wherestr = "WHERE $wherestr";

$query = "SELECT eventtypes.eventtypeID, tag, description, display, type, keep, collapse, ordernum, count(eventID) AS total_events ";
$query .= "FROM $eventtypes_table eventtypes ";
$query .= "LEFT JOIN $events_table events ON eventtypes.eventtypeID = events.eventtypeID ";
$query .= "$wherestr ";
$query .= "GROUP BY eventtypeID ";
$query .= "ORDER BY $orderstr, description ";
$query .= "LIMIT $newoffset" . $maxsearchresults;
$result = tng_query($query);
$events = tng_fetch_all($result);
tng_free_result($result);

$numrows = count($events);
if ($numrows == $maxsearchresults || $offsetplus > 1) {
    $query = "SELECT COUNT(eventtypeID) AS ecount FROM $eventtypes_table $wherestr";
    $result2 = tng_query($query);
    $row = tng_fetch_assoc($result2);
    $totrows = $row['ecount'];
    tng_free_result($result2);
} else {
    $totrows = $numrows;
}
$helplang = findhelp("eventtypes_help.php");

$flags['tabs'] = $tngconfig['tabs'];
tng_adminheader(_('Event Types'), $flags);
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
                    <form class="my-4" name="form1" action="admin_eventtypes.php">
                        <table class="normal">
                            <tr>
                                <!--                                <td>--><?php //echo _('Search for'); ?><!--:</td>-->
                                <td>
                                    <label for="searchstring"><?php echo _('Search for'); ?></label>
                                    <input id="searchstring" class="longfield" name="searchstring" type="search" value="<?php echo $searchstring; ?>">
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
                                <th class="p-1 fieldnameback fieldname"><?php echo _('Action'); ?></th>
                                <?php if ($allow_delete || $allow_edit) { ?>
                                    <th class="p-1 fieldnameback fieldname"><?php echo _('Select'); ?></th>
                                <?php } ?>
                                <th class="p-1 fieldnameback fieldname"><?php echo $tagsort; ?></th>
                                <th class="p-1 fieldnameback fieldname"><?php echo $typesort; ?></th>
                                <th class="p-1 fieldnameback fieldname"><?php echo $dispsort; ?></th>
                                <th class="p-1 fieldnameback fieldname"><?php echo _('Order #'); ?></th>
                                <th class="p-1 fieldnameback fieldname"><?php echo _('Ind/Fam'); ?></th>
                                <th class="p-1 fieldnameback fieldname"><?php echo _('On Import'); ?></th>
                                <th class="p-1 fieldnameback fieldname"><?php echo _('Collapse'); ?></th>
                                <th class="p-1 fieldnameback fieldname"><?php echo $evsort; ?></th>
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
                            foreach ($events as $row) {
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
                                echo "<td class='p-1 lightback'><div class='action-btns2'>$newactionstr</div></td>\n";
                                if ($allow_delete || $allow_edit) {
                                    echo "<td class='p-1 text-center lightback'><input type='checkbox' name=\"et{$row['eventtypeID']}\" value='1'></td>\n";
                                }
                                echo "<td class='p-1 lightback'>{$row['tag']}</td>\n";
                                echo "<td class='p-1 lightback'>{$row['description']}</td>\n";
                                echo "<td class='p-1 lightback'>$displayval&nbsp;</td>\n";
                                echo "<td class='p-1 lightback'>{$row['ordernum']}</td>";
                                echo "<td class='p-1 lightback'>$type</td>";
                                echo "<td class='p-1 lightback'>$keep</td>";
                                echo "<td class='p-1 lightback'>$collapse</td>";
                                echo "<td class='p-1 text-right lightback'>" . number_format($row['total_events']) . "</td>";
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
                ?>
                    </form>
                </div>
            </td>
        </tr>
    </table>
    <script>
        function confirmDelete(ID) {
            if (confirm('<?php echo _('Are you sure you want to delete this event type?'); ?>'))
                deleteIt('eventtype', ID);
            return false;
        }
    </script>
<?php echo tng_adminfooter(); ?>