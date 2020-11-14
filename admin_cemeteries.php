<?php

include "begin.php";
include "config/mapconfig.php";
include "adminlib.php";
require_once "admin/pagination.php";
$textpart = "cemeteries";
include "$mylanguage/admintext.php";
$admin_login = 1;
include "checklogin.php";
include "version.php";
require_once "admin/cemeteries.php";
require_once "./core/html/addCriteria.php";

$tng_search_cemeteries = $_SESSION['tng_search_cemeteries'] = 1;
if ($newsearch) {
    $exptime = 0;
    setcookie("tng_search_cemeteries_post[search]", $q, $exptime);
    setcookie("tng_search_cemeteries_post[offset]", 0, $exptime);
    setcookie("tng_search_cemeteries_post[tngpage]", 1, $exptime);
    setcookie("tng_search_cemeteries_post[offset]", 0, $exptime);
} else {
    if (!$q) {
        $q = stripslashes($_COOKIE['tng_search_cemeteries_post']['search']);
    }
    if (!isset($offset)) {
        $tngpage = $_COOKIE['tng_search_cemeteries_post']['tngpage'];
        $offset = $_COOKIE['tng_search_cemeteries_post']['offset'];
    } else {
        $exptime = 0;
        setcookie("tng_search_cemeteries_post[tngpage]", $tngpage, $exptime);
        setcookie("tng_search_cemeteries_post[offset]", $offset, $exptime);
    }
}
$searchstring_noquotes = preg_replace("/\"/", "&#34;", $q);
$q = addslashes($q);
if ($offset) {
    $offsetplus = $offset + 1;
    $newoffset = "$offset, ";
} else {
    $offsetplus = 1;
    $newoffset = "";
    $tngpage = 1;
}
$frontmod = "LIKE";
$allwhere = "WHERE 1=0";
$allwhere .= addCriteria("$cemeteries_table.cemeteryID", $q, $frontmod);
$allwhere .= addCriteria("maplink", $q, $frontmod);
$allwhere .= addCriteria("cemname", $q, $frontmod);
$allwhere .= addCriteria("city", $q, $frontmod);
$allwhere .= addCriteria("state", $q, $frontmod);
$allwhere .= addCriteria("county", $q, $frontmod);
$allwhere .= addCriteria("country", $q, $frontmod);
$query = "SELECT cemeteryID, cemname, city, county, state, country, latitude, longitude, zoom ";
$query .= "FROM $cemeteries_table ";
$query .= "$allwhere ";
$query .= "ORDER BY cemname, city, county, state, country ";
$query .= "LIMIT $newoffset" . $maxsearchresults;
$result = tng_query($query);
$cemeteries = tng_fetch_all($result);
tng_free_result($result);
$numrows = count($cemeteries);
if ($numrows == $maxsearchresults || $offsetplus > 1) {
    $query = "SELECT count(cemeteryID) AS ccount FROM $cemeteries_table $allwhere";
    $result2 = tng_query($query);
    $row = tng_fetch_assoc($result2);
    $totrows = $row['ccount'];
    tng_free_result($result2);
} else {
    $totrows = $numrows;
}
$helplang = findhelp("cemeteries_help.php");

tng_adminheader(_('Cemeteries'), $flags);
?>
    <script>
        function confirmDelete(ID) {
            if (confirm('<?php echo _('Are you sure you want to delete this cemetery?'); ?>'))
                deleteIt('cemetery', ID);
            return false;
        }
    </script>

<?php
echo "</head>\n";
echo "<!-- begin tng_adminlayout -->\n";
echo tng_adminlayout();
echo "<!-- end tng_adminlayout -->\n";

$cemtabs[0] = [1, "admin_cemeteries.php", _('Search'), "findcem"];
$cemtabs[1] = [$allow_add, "admin_newcemetery.php", _('Add New'), "addcemetery"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/cemeteries_help.php#modify');\" class='lightlink'>" . _('Help for this area') . "</a>";
$menu = doMenu($cemtabs, "findcem", $innermenu);
echo displayHeadline(_('Cemeteries'), "img/cemeteries_icon.gif", $menu, $message);
$searchIcon = buildSvgElement("img/search.svg", ["class" => "w-4 h-4 fill-current inline-block"]);
?>
    <table class="w-full lightback md:mx-auto md:max-x-3xl">
        <tr class="databack">
            <td class="tngshadow">
                <div class="normal">
                    <form action="admin_cemeteries.php" name="form1">
                        <div class="relative mb-4 md:flex">
                            <div class="container mx-4 normal">
                                <label for="searchstring"><?php echo _('Search for'); ?>:</label>
                                <input id='searchstring' class="relative w-full px-2 py-1 text-sm text-gray-700 placeholder-gray-400 bg-white rounded shadow outline-none focus:outline-none focus:shadow-outline lg:text-md" name="q" type="search"
                                    placeholder="Search..." value="<?php echo $searchstring_noquotes; ?>">
                            </div>
                        </div>
                        <input type="hidden" name="findcemetery" value="1">
                        <input type="hidden" name="newsearch" value="1">
                    </form>
                    <div class="mx-4">
                        <?php
                        $numrowsplus = $numrows + $offset;
                        if (!$numrowsplus) $offsetplus = 0;
                        ?>
                    </div>
                    <form action="admin_deleteselected.php" method="post" name="form2">
                        <?php if ($allow_delete) { ?>
                            <p class="mx-4">
                                <input type="button" name="selectall" value="<?php echo _('Select All'); ?>" onClick="toggleAll(1);">
                                <input type="button" name="clearall" value="<?php echo _('Clear All'); ?>" onClick="toggleAll(0);">
                                <input type="submit" name="xcemaction" value="<?php echo _('Delete Selected'); ?>" onClick="return confirm('<?php echo _('Are you sure you want to delete the selected records?'); ?>');">
                            </p>
                        <?php } ?>
                        <table class="w-full normal md:mx-auto md:max-w-3xl">
                            <tr>
                                <th class="fieldnameback fieldname"><?php echo _('Action'); ?></th>
                                <?php if ($allow_delete) { ?>
                                    <th class="fieldnameback fieldname"><?php echo _('Select'); ?></th>
                                <?php } ?>
                                <th class="fieldnameback fieldname"><?php echo _('Cemetery'); ?></th>
                                <!--                            <th class="fieldnameback fieldname">--><?php //echo _('Location'); ?><!--</th>-->
                                <?php if ($map['key']) { ?>
                                    <th class="fieldnameback fieldname"><?php echo _('Geocode Location'); ?></th>
                                <?php } else { ?>
                                    <th class="fieldnameback fieldname"><?php echo _('Latitude'); ?></th>
                                    <th class="fieldnameback fieldname"><?php echo _('Longitude'); ?></th>
                                <?php } ?>
                            </tr>
                            <?php
                            if ($numrows) {
                            $actionstr = "";
                            if ($allow_edit) {
                                $actionstr .= "<a href=\"admin_editcemetery.php?cemeteryID=xxx\" title=\"" . _('Edit') . "\" class='smallicon admin-edit-icon'></a>";
                            }
                            if ($allow_delete) {
                                $actionstr .= "<a href='#' onClick=\"return confirmDelete('xxx');\" title=\"" . _('Delete') . "\" class='smallicon admin-delete-icon'></a>";
                            }
                            $actionstr .= "<a href='showmap.php?cemeteryID=xxx&amp' target='_blank' title=\"" . _('Test') . "\" class='smallicon admin-test-icon'></a>";
                            foreach ($cemeteries as $row) {
                                $location = cemeteryPlace($row);
                                $newactionstr = preg_replace("/xxx/", $row['cemeteryID'], $actionstr);
                                echo "<tr id=\"row_{$row['cemeteryID']}\"><td class='lightback'><div class='action-btns'>$newactionstr</div></td>\n";
                                if ($allow_delete) {
                                    echo "<td class='text-center lightback'><input type='checkbox' name=\"del{$row['cemeteryID']}\" value='1'></td>";
                                }
                                $editlink = "admin_editcemetery.php?cemeteryID={$row['cemeteryID']}";
                                $cemname = $allow_edit ? "<a href=\"$editlink\" title=\"" . _('Edit') . "\">" . $row['cemname'] . "</a>" : $row['cemname'];
                                echo "<td class='lightback'>$cemname<br>$location</td>\n";
                                //                            echo "<td class='lightback'>$location</td>\n";
                                if ($map['key']) {
                                    echo "<td nowrap class='lightback'>";
                                    $geo = "";
                                    if ($row['latitude']) {
                                        $geo .= "" . _('Latitude') . ": " . number_format($row['latitude'], 3);
                                    }
                                    if ($row['longitude']) {
                                        if ($geo) $geo .= "<br>";
                                        $geo .= "" . _('Longitude') . ": " . number_format($row['longitude'], 3);
                                    }
                                if ($row['zoom']) {
                                    if ($geo) $geo .= "<br>";
                                    $geo .= "" . _('Zoom') . ": " . $row['zoom'];
                                }
                                    echo "$geo</td>\n";
                                } else {
                                    echo "<td class='lightback'>{$row['latitude']}</td>\n";
                                    echo "<td class='lightback'>{$row['longitude']}</td>\n";
                                }
                                echo "</tr>\n";
                            }
                            ?>
                        </table>
                    <?php
                    echo "<div class='w-full class=lg:flex my-6'>";
                    echo getPaginationLocationHtml($offsetplus, $numrowsplus, $totrows);
                    echo getPaginationControlsHtml($totrows, "admin_cemeteries.php?q=$searchstring&amp;exactmatch=$exactmatch&amp;offset", $maxsearchresults, 3);
                    echo "</div>";
                    }
                else {
                    echo _('No records exist.');
                }
                ?>
                </form>
            </div>
        </td>
    </tr>
</table>
<?php echo tng_adminfooter(); ?>