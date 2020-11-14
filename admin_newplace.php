<?php
include "begin.php";
include "config/mapconfig.php";
$mapkeystr = $map['key'] && $map['key'] != "1" ? "&amp;key=" . $map['key'] : "";
include "adminlib.php";
$textpart = "findplace";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
if (!$allow_add) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

if (!$tngconfig['places1tree']) {
    if ($assignedtree) {
        $wherestr = "WHERE gedcom = '$assignedtree'";
        $firsttree = $assignedtree;
    } else {
        $wherestr = "";
        $firsttree = isset($_COOKIE['tng_tree']) ? $_COOKIE['tng_tree'] : "";
    }
    $query = "SELECT gedcom, treename FROM $trees_table $wherestr ORDER BY treename";
    $result = tng_query($query);
}

$helplang = findhelp("places_help.php");

tng_adminheader(_('Add New Place'), $flags);

if ($map['key'] && $isConnected) {
    echo "<script src=\"{$http}://maps.googleapis.com/maps/api/js?language=" . _('&amp;hl=en') . "$mapkeystr\"></script>\n";
}
?>
    <script>
        function validateForm() {
            let rval = true;
            if (document.form1.place.value.length == 0) {
                alert("<?php echo _('Please enter a place.'); ?>");
                rval = false;
            }
            return rval;
        }
    </script>
<?php if ($map['key']) include "googlemaplib2.php"; ?>
    </head>

<?php
$onload = $map['key'] && !$map['startoff'] ? " onload=\"divbox('mapcontainer');\"" : "";
echo tng_adminlayout($onload);

$placetabs[0] = [1, "admin_places.php", _('Search'), "findplace"];
$placetabs[1] = [$allow_add, "admin_newplace.php", _('Add New'), "addplace"];
$placetabs[2] = [$allow_edit && $allow_delete, "admin_mergeplaces.php", _('Merge'), "merge"];
$placetabs[3] = [$allow_edit, "admin_geocodeform.php", _('Geocode'), "geo"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/places_help.php#add');\" class='lightlink'>" . _('Help for this area') . "</a>";
$menu = doMenu($placetabs, "addplace", $innermenu);
echo displayHeadline(_('Places') . " &gt;&gt; " . _('Add New Place'), "img/places_icon.gif", $menu, $message);
?>

    <table class="lightback">
        <tr class="databack">
            <td class="tngshadow">
                <form action="admin_addplace.php" method="post" name="form1" onSubmit="return validateForm();">
                    <table class="normal w-full">
                        <?php if (!$tngconfig['places1tree']) { ?>
                            <tr>
                                <td><?php echo _('Tree'); ?>:</td>
                                <td width="90%">
                                    <select name="tree">
                                        <?php
                                        while ($row = tng_fetch_assoc($result)) {
                                            echo "		<option value=\"{$row['gedcom']}\"";
                                            if ($firsttree == $row['gedcom']) echo " selected";

                                            echo ">{$row['treename']}</option>\n";
                                        }
                                        tng_free_result($result);
                                        ?>
                                    </select>
                                </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td><?php echo _('Place'); ?>:</td>
                            <td>
                                <input type="text" name="place" id="place" size="50">
                            </td>
                        </tr>
                        <?php if (determineLDSRights()) { ?>
                            <tr>
                                <td>&nbsp;</td>
                                <td>
                                    <input type="checkbox" name="temple" value="1"> <?php echo _('This place name is an LDS temple code'); ?></td>
                            </tr>
                            <?php
                        }
                    if ($map['key']) {
                        ?>
                        <tr>
                            <td colspan="2">
                                <div style="padding:10px;">
                                    <?php
                                    // draw the map here
                                    include "googlemapdrawthemap.php";
                                    ?>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                        <tr>
                            <td><?php echo _('Latitude'); ?>:</td>
                            <td>
                                <input type="text" name="latitude" size="20" id="latbox">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Longitude'); ?>:</td>
                            <td>
                                <input type="text" name="longitude" size="20" id="lonbox">
                            </td>
                        </tr>
                        <?php if ($map['key']) { ?>
                            <tr>
                                <td><?php echo _('Zoom'); ?>:</td>
                                <td>
                                    <input type="text" name="zoom" size="20" id="zoombox">
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Place Level'); ?>:</td>
                                <td>
                                    <select name="placelevel">
                                        <option value=""></option>
                                        <?php
                                        for ($i = 1; $i < 7; $i++) {
                                            echo "<option value=\"$i\">" . $admtext['level' . $i] . "</option>\n";
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td class='align-top'><?php echo _('Notes'); ?>:</td>
                            <td><textarea cols="50" rows="5" name="notes"></textarea></td>
                        </tr>
                    </table>
                    <br>&nbsp;
                    <input type="submit" name="submit" accesskey="s" class="btn" value="<?php echo _('Save'); ?>">
                </form>
            </td>
        </tr>

    </table>
<?php echo tng_adminfooter(); ?>