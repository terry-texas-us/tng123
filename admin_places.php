<?php

include "begin.php";
include "config/mapconfig.php";
include "adminlib.php";
require_once "admin/pagination.php";
$textpart = "findplace";
include "$mylanguage/admintext.php";
$admin_login = 1;
include "checklogin.php";
include "version.php";
$orgtree = $tree;
$exptime = 0;

if ($newsearch) {
    $searchstring = trim($searchstring);
    setcookie("tng_search_places_post[search]", $searchstring, $exptime);
    setcookie("tng_tree", $tree, $exptime);
    setcookie("tng_search_places_post[exactmatch]", $exactmatch, $exptime);
    setcookie("tng_search_places_post[nocoords]", $nocoords, $exptime);
    setcookie("tng_search_places_post[nolevel]", $nolevel, $exptime);
    setcookie("tng_search_places_post[temples]", $temples, $exptime);
    setcookie("tng_search_places_post[tngpage]", 1, $exptime);
    setcookie("tng_search_places_post[offset]", 0, $exptime);
} else {
    if (!$searchstring) {
        $searchstring = stripslashes($_COOKIE['tng_search_places_post']['search']);
    }
    if (!$tree) $tree = $_COOKIE['tng_tree'];

    if (!$exactmatch) {
        $exactmatch = $_COOKIE['tng_search_places_post']['exactmatch'];
    }
    if (!$nocoords) {
        $nocoords = $_COOKIE['tng_search_places_post']['nocoords'];
    }
    if (!$nolevel) {
        $nolevel = $_COOKIE['tng_search_places_post']['nolevel'];
    }
    if (!$temples) {
        $temples = $_COOKIE['tng_search_places_post']['temples'];
    }
    if (!isset($offset)) {
        $tngpage = $_COOKIE['tng_search_places_post']['tngpage'];
        $offset = $_COOKIE['tng_search_places_post']['offset'];
    } else {
        setcookie("tng_search_places_post[tngpage]", $tngpage, $exptime);
        setcookie("tng_search_places_post[offset]", $offset, $exptime);
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

if ($assignedtree && !$tngconfig['places1tree']) {
    $tree = $assignedtree;
    $wherestr = "WHERE gedcom = '$assignedtree'";
} else {
    $wherestr = "";
}

/**
 * @param $field
 * @param $value
 * @param $operator
 * @return string
 */
function addCriteria($field, $value, $operator) {

    if ($operator == "=") {
        $criteria = " OR $field $operator '$value'";
    } else {
        $criteria = " OR $field $operator \"%$value%\"";
    }
    return $criteria;
}

if ($tree) {
    $allwhere = "$places_table.gedcom = '$tree'";
} else {
    $allwhere = "1 = 1";
}

if ($noevents) {
    $allwhere .= " AND place IN (SELECT places.place ";
    $allwhere .= "FROM $places_table places ";
    $allwhere .= "LEFT JOIN ";
    $allwhere .= "(SELECT birthplace AS place FROM $people_table ";
    $allwhere .= "UNION ";
    $allwhere .= "SELECT altbirthplace FROM $people_table ";
    $allwhere .= "UNION ";
    $allwhere .= "SELECT baptplace FROM $people_table ";
    $allwhere .= "UNION ";
    $allwhere .= "SELECT deathplace FROM $people_table ";
    $allwhere .= "UNION ";
    $allwhere .= "SELECT burialplace FROM $people_table ";
    $allwhere .= "UNION ";
    if ($ldsdefault != "1") {
        $allwhere .= "SELECT initplace FROM $people_table ";
        $allwhere .= "UNION ";
        $allwhere .= "SELECT confplace FROM $people_table ";
        $allwhere .= "UNION ";
        $allwhere .= "SELECT endlplace FROM $people_table ";
        $allwhere .= "UNION ";
        $allwhere .= "SELECT sealplace FROM $children_table ";
        $allwhere .= "UNION ";
        $allwhere .= "SELECT sealplace FROM $families_table ";
        $allwhere .= "UNION ";
    }
    $allwhere .= "SELECT marrplace FROM $families_table ";
    $allwhere .= "UNION ";
    $allwhere .= "SELECT divplace FROM $families_table ";
    $allwhere .= "UNION ";
    $allwhere .= "SELECT eventplace FROM $events_table ";
    $allwhere .= "UNION ";
    $allwhere .= "SELECT place FROM $cemeteries_table ";
    $allwhere .= "UNION ";
    $allwhere .= "SELECT personID FROM $medialinks_table ";
    $allwhere .= "WHERE linktype = \"L\") AS p USING (place) ";
    $allwhere .= "WHERE ISNULL(p.place))";
}

if ($nocoords) {
    $allwhere .= " AND (latitude IS NULL OR latitude = \"\" OR longitude IS NULL OR longitude = \"\")";
}
if ($nolevel) {
    $allwhere .= " AND (placelevel IS NULL OR placelevel = \"\" OR placelevel = '0')";
}

if ($temples) $allwhere .= " AND temple = 1";


if ($searchstring) {
    $allwhere .= " AND (1=0";
    if ($exactmatch == "yes") {
        $frontmod = "=";
    } else {
        $frontmod = "LIKE";
    }

    $allwhere .= addCriteria("place", $searchstring, $frontmod);
    $allwhere .= addCriteria("notes", $searchstring, $frontmod);
    $allwhere .= ")";
}
$treename = $tngconfig['places1tree'] ? "" : ", treename";

$query = "SET SQL_BIG_SELECTS=1";
$result = tng_query($query);

$query = "SELECT ID, place, placelevel, longitude, latitude, zoom, places.gedcom AS gedcom $treename ";
$query .= "FROM $places_table places";
if (!$tngconfig['places1tree']) {
    $query .= " LEFT JOIN $trees_table trees ON places.gedcom = trees.gedcom";
}
$query .= " WHERE $allwhere ";
$query .= "ORDER BY place, places.gedcom, ID ";
$query .= "LIMIT $newoffset" . $maxsearchresults;
$result = tng_query($query);
$numrows = tng_num_rows($result);
if ($numrows == $maxsearchresults || $offsetplus > 1) {
    $query = "SELECT count(ID) AS pcount FROM $places_table WHERE $allwhere";
    $result2 = tng_query($query);
    $row = tng_fetch_assoc($result2);
    $totrows = $row['pcount'];
    tng_free_result($result2);
} else {
    $totrows = $numrows;
}

$helplang = findhelp("places_help.php");

tng_adminheader($admtext['places'], $flags);
?>
<script>
    function validateForm() {
        let rval = true;
        if (document.form1.searchstring.value.length == 0) {
            alert("<?php echo $admtext['entersearchvalue']; ?>");
            rval = false;
        }
        return rval;
    }

    function confirmDelete(ID) {
        if (confirm('<?php echo $admtext['confdeleteplace']; ?>'))
            deleteIt('place', ID);
        return false;
    }

    function resetForm() {
        document.form1.searchstring.value = '';
        if (document.form1.tree)
            document.form1.tree.selectedIndex = 0;
        document.form1.exactmatch.checked = false;
        document.form1.nocoords.checked = false;
        document.form1.noevents.checked = false;
        document.form1.nolevel.checked = false;
        document.form1.temples.checked = false;
    }
</script>

<?php
echo "</head>\n";
echo tng_adminlayout();

$placetabs[0] = [1, "admin_places.php", $admtext['search'], "findplace"];
$placetabs[1] = [$allow_add, "admin_newplace.php", $admtext['addnew'], "addplace"];
$placetabs[2] = [$allow_edit && $allow_delete, "admin_mergeplaces.php?place=$searchstring&amp;place2=$place2", $admtext['merge'], "merge"];
$placetabs[3] = [$allow_edit, "admin_geocodeform.php", $admtext['geocode'], "geo"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/places_help.php#modify');\" class='lightlink'>{$admtext['help']}</a>";
$menu = doMenu($placetabs, "findplace", $innermenu);
echo displayHeadline($admtext['places'], "img/places_icon.gif", $menu, $message);
?>

<table class="lightback">
    <tr class="databack">
        <td class="tngshadow">
            <div class="normal">

                <form action="admin_places.php" name="form1" id="form1">
                    <table class="normal">
                        <tr>
                            <td><span class="normal"><?php echo $admtext['searchfor']; ?>: </span></td>
                            <td>
                                <?php if (!$tngconfig['places1tree']) include "treequery.php"; ?>
                                <input class="verylongfield" name="searchstring" type="search" value="<?php echo stripslashes($searchstring_noquotes); ?>">
                            </td>
                            <td>
                                <input type="submit" name="submit" value="<?php echo $admtext['search']; ?>" class="align-top">
                                <input type="submit" name="submit" value="<?php echo $admtext['reset']; ?>" onClick="resetForm();" class="align-top">
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td colspan="2">
                                <input type="checkbox" name="exactmatch" value="yes"<?php if ($exactmatch == "yes") {
                                    echo " checked";
                                } ?>> <?php echo $admtext['exactmatch']; ?>&nbsp;&nbsp;
                                <input type="checkbox" name="nocoords" value="yes"<?php if ($nocoords == "yes") {
                                    echo " checked";
                                } ?>> <?php echo $admtext['nocoords']; ?>&nbsp;&nbsp;
                                <input type="checkbox" name="noevents" value="yes"<?php if ($noevents == "yes") {
                                    echo " checked";
                                } ?>> <?php echo $admtext['noevents']; ?>&nbsp;&nbsp;<br>
                                <input type="checkbox" name="nolevel" value="yes"<?php if ($nolevel == "yes") {
                                    echo " checked";
                                } ?>> <?php echo $admtext['nolevel']; ?>&nbsp;&nbsp;
                                <?php
                                if (determineLDSRights()) {
                                    echo "<input type='checkbox' name=\"temples\" value=\"yes\"";
                                    if ($temples == "yes") echo " checked";
                                    echo "> " . $admtext['findtemples'];
                                }
                                ?>
                            </td>
                        </tr>
                    </table>

                    <input type="hidden" name="findplace" value="1">
                    <input type="hidden" name="newsearch" value="1">
                </form>
                <?php
                $numrowsplus = $numrows + $offset;
                if (!$numrowsplus) $offsetplus = 0;
                ?>
                <form action="admin_deleteselected.php" method="post" name="form2">
                    <?php if ($allow_delete) { ?>
                        <p>
                            <input type="button" name="selectall" value="<?php echo $admtext['selectall']; ?>" onClick="toggleAll(1);">
                            <input type="button" name="clearall" value="<?php echo $admtext['clearall']; ?>" onClick="toggleAll(0);">
                            <input type="submit" name="xplacaction" value="<?php echo $admtext['deleteselected']; ?>" onClick="return confirm('<?php echo $admtext['confdeleterecs']; ?>');">
                        </p>
                    <?php } ?>

                    <table class="normal">
                        <tr>
                            <th class="fieldnameback fieldname"><?php echo $admtext['action']; ?></th>
                            <?php if ($allow_delete) { ?>
                                <th class="fieldnameback fieldname"><?php echo $admtext['select']; ?></th>
                            <?php } ?>
                            <th class="fieldnameback fieldname"><?php echo $admtext['place']; ?></th>
                            <?php if ($map['key']) { ?>
                                <th class="fieldnameback fieldname"><?php echo $admtext['placelevel']; ?></th>
                            <?php } ?>
                            <th class="fieldnameback fieldname"><?php echo $admtext['latitude']; ?></th>
                            <th class="fieldnameback fieldname"><?php echo $admtext['longitude']; ?></th>
                            <?php if ($map['key']) { ?>
                                <th class="fieldnameback fieldname"><?php echo $admtext['zoom']; ?></th>
                                <?php
                            }
                            if (!$tngconfig['places1tree']) {
                                ?>
                                <th class="fieldnameback fieldname"><?php echo $admtext['tree']; ?></th>
                            <?php } ?>
                        </tr>
                        <?php
                        if ($numrows) {
                        $actionstr = "";
                        if ($allow_edit) {
                            $actionstr .= "<a href=\"admin_editplace.php?ID=xxx\" title=\"{$admtext['edit']}\" class='smallicon admin-edit-icon'></a>";
                        }
                        if ($allow_delete) {
                            $actionstr .= "<a href='#' onClick=\"return confirmDelete('xxx');\" title=\"{$admtext['text_delete']}\" class='smallicon admin-delete-icon'></a>";
                        }
                        $actionstr .= "<a href=\"placesearch.php?psearch=zzz";
                        if (!$tngconfig['places1tree']) $actionstr .= "&amp;tree=yyy";

                        $actionstr .= "\" target='_blank' title=\"{$admtext['test']}\" class='smallicon admin-test-icon'></a>";

                        while ($row = tng_fetch_assoc($result)) {
                            $newactionstr = preg_replace("/xxx/", $row['ID'], $actionstr);
                            if (!$tngconfig['places1tree']) {
                                $newactionstr = preg_replace("/yyy/", $row['gedcom'], $newactionstr);
                            }
                            $newactionstr = preg_replace("/zzz/", urlencode($row['place']), $newactionstr);
                            echo "<tr id=\"row_{$row['ID']}\"><td class='lightback'><div class='action-btns'>$newactionstr</div></td>\n";
                            if ($allow_delete) {
                                echo "<td class='lightback text-center'><input type='checkbox' name=\"del{$row['ID']}\" value='1'></td>";
                            }
                            $display = $row['place'];
                            $display = preg_replace("/</", "&lt;", $display);
                            $display = preg_replace("/>/", "&gt;", $display);
                            echo "<td class='lightback'>&nbsp;$display&nbsp;</td>\n";
                            if ($map['key']) {
                                echo "<td class='lightback'>&nbsp;{$row['placelevel']}&nbsp;</td>\n";
                            }
                            echo "<td class='lightback'>&nbsp;{$row['latitude']}&nbsp;</td>\n";
                            echo "<td class='lightback'>&nbsp;{$row['longitude']}&nbsp;</td>\n";
                            if ($map['key']) {
                                echo "<td class='lightback'>&nbsp;{$row['zoom']}&nbsp;</td>\n";
                            }
                            if (!$tngconfig['places1tree']) {
                                echo "<td class='lightback'>&nbsp;{$row['treename']}&nbsp;</td>\n";
                            }
                            echo "</tr>\n";
                        }
                        ?>
                    </table>
                <?php
                echo "<div class='w-full class=lg:flex my-6'>";
                echo getPaginationLocationHtml($offsetplus, $numrowsplus, $totrows);
                echo getPaginationControlsHtml($totrows, "admin_places.php?searchstring=" . stripslashes($searchstring) . "&amp;exactmatch=$exactmatch&amp;noocords=$nocoords&amp;temples=$temples&amp;noevents=$noevents&amp;offset", $maxsearchresults, 3);
                echo "</div>";
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
<?php echo tng_adminfooter(); ?>