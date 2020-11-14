<?php
include "begin.php";
include "adminlib.php";
$textpart = "findplace";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
include "geocodelib.php";
require "adminlog.php";

$orgtree = $tree;
$helplang = findhelp("places_help.php");

if ($resetignore) {
    $query = "UPDATE $places_table SET geoignore='0'";
    $result = tng_query($query);
}

tng_adminheader(_('Places'), $flags);

echo "</head>\n";
echo tng_adminlayout();

$placetabs[0] = [1, "admin_places.php", _('Search'), "findplace"];
$placetabs[1] = [$allow_add, "admin_newplace.php", _('Add New'), "addplace"];
$placetabs[2] = [$allow_edit && $allow_delete, "admin_mergeplaces.php", _('Merge'), "merge"];
$placetabs[3] = [$allow_edit, "admin_geocodeform.php", _('Geocode'), "geo"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/places_help.php#modify');\" class='lightlink'>" . _('Help for this area') . "</a>";
$menu = doMenu($placetabs, "geo", $innermenu);
echo displayHeadline(_('Places') . " &gt;&gt; " . _('Geocode'), "img/places_icon.gif", $menu, $message);
?>

    <table class="lightback">
        <tr class="databack">
            <td class="tngshadow">
                <h3 class="subhead"><?php echo _('Geocoding...'); ?></h3>

                <div class="normal">
                    <?php
                    $treestr = $tree1 ? " AND gedcom = \"$tree1\"" : "";
                    $limitstr = $limit ? "LIMIT $limit" : "";

                    $query = "SELECT ID, place FROM $places_table WHERE (latitude = \"\" OR latitude IS NULL) AND (longitude = \"\" OR longitude IS NULL) AND temple != '1' AND geoignore != '1'$treestr ORDER BY place $limitstr";
                    $result = tng_query($query);

                    $delay = 0;
                $count = 0;

                    adminwritelog("<a href=\"admin_geocode.php\">" . _('Geocode all Places without latitude and longitude coordinates') . " ($limit)</a>");

                while ($row = tng_fetch_assoc($result)) {
                    $count++;
                    $address = trim($row["place"]);
                    if ($address) {
                        $id = $row["ID"];
                        $display = $address;
                        $display = preg_replace("/</", "&lt;", $display);
                        $display = preg_replace("/>/", "&gt;", $display);
                        echo "<br>\n$count. $display ... &nbsp; ";
                        echo geocode($address, $multiples, $id);
                    } else {
                        echo "<br>\n$count. " . _('Blank place name') . " &nbsp; <strong>" . _('Could not be geocoded') . "</strong>";
                    }
                }
                    tng_free_result($result);
                    ?>
                </div>
                <p><a href="admin_geocodeform.php"><?php echo _('Return to Geocode menu'); ?></a></p>
            </td>
        </tr>
    </table>
<?php echo tng_adminfooter(); ?>