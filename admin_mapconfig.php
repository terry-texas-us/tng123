<?php
include "begin.php";
include "config/mapconfig.php";
include "adminlib.php";

if ($link) {
    $admin_login = 1;
    include "checklogin.php";
    include "version.php";
    if ($assignedtree || !$allow_edit) {
        $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
        header("Location: admin_login.php?message=" . urlencode($message));
        exit;
    }
}

$helplang = findhelp("mapconfig_help.php");

tng_adminheader(_('Modify Map Configuration Settings'), $flags);
?>
<script>
    function validateWidth(width) {
        if (width.indexOf('%') >= 0)
            return Math.min(parseInt(width), 100) + '%';
        else
            return parseInt(width) + 'px';
    }

    function validateHeight(height) {
        return parseInt(height) + 'px';
    }

    function validateLatLong(coord) {
        var keep = "1234567890.-";     // Characters stripped out
        var i;
        var returnString = "";
        for (i = 0; i < coord.length; i++) {  // Search through string and append to unfiltered values to returnString.
            var c = coord.charAt(i);
            if (keep.indexOf(c) != -1)
                returnString += c;
            else
                break;
        }
        return returnString
    }
</script>

<?php
echo "</head>\n";
echo tng_adminlayout();

$setuptabs[0] = [1, "admin_setup.php", _('Configuration'), "configuration"];
$setuptabs[1] = [1, "admin_diagnostics.php", _('Diagnostics'), "diagnostics"];
$setuptabs[2] = [1, "admin_setup.php?sub=tablecreation", _('Table Creation'), "tablecreation"];
$setuptabs[3] = [1, "#", _('Map Settings'), "map"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/mapconfig_help.php');\" class='lightlink'>" . _('Help for this area') . "</a>";
$menu = doMenu($setuptabs, "map", $innermenu);
echo displayHeadline(_('Setup') . " &gt;&gt; " . _('Configuration') . " &gt;&gt; " . _('Map Settings'), "img/setup_icon.gif", $menu, "");
?>

<table class="normal lightback w-full" cellpadding="10" cellspacing="2">
    <tr class="databack">
        <td class="tngshadow">
            <form action="admin_updatemapconfig.php" method="post" name="form1">
                <table class="normal">
                    <tr>
                        <td><?php echo _('Map Key'); ?>:</td>
                        <td>
                            <input type="text" value="<?php echo $map['key']; ?>" name="mapkey" size="80">
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo _('Map Type'); ?>:</td>
                        <td>
                            <select name="maptype">
                                <option value="TERRAIN"<?php if ($map['displaytype'] == "TERRAIN") {
                                    echo " selected";
                                } ?>><?php echo _('Terrain'); ?></option>
                                <option value="ROADMAP"<?php if ($map['displaytype'] == "ROADMAP") {
                                    echo " selected";
                                } ?>><?php echo _('Road Map'); ?></option>
                                <option value="HYBRID"<?php if ($map['displaytype'] == "HYBRID") {
                                    echo " selected";
                                } ?>><?php echo _('Hybrid'); ?></option>
                                <option value="SATELLITE"<?php if ($map['displaytype'] == "SATELLITE") {
                                    echo " selected";
                                } ?>><?php echo _('Satellite'); ?></option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo _('Starting Latitude'); ?>:</td>
                        <td>
                            <input type="text" value="<?php echo $map['stlat']; ?>" name="mapstlat" onblur="this.value = validateLatLong(this.value)">
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo _('Starting Longitude'); ?>:</td>
                        <td>
                            <input type="text" value="<?php echo $map['stlong']; ?>" name="mapstlong" onblur="this.value = validateLatLong(this.value)">
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo _('Starting Zoom'); ?>:</td>
                        <td>
                            <select name="mapstzoom">
                                <?php
                                for ($i = 0; $i <= 17; $i++) {
                                    echo "<option value=\"$i\"";
                                    if ($map['stzoom'] == $i) echo " selected";

                                    echo ">$i</option>\n";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo _('Location Zoom'); ?>:</td>
                        <td>
                            <select name="mapfoundzoom">
                                <?php
                                for ($i = 0; $i <= 17; $i++) {
                                    echo "<option value=\"$i\"";
                                    if ($map['foundzoom'] == $i) echo " selected";

                                    echo ">$i</option>\n";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td class="align-top" colspan="2"><br><?php echo _('Dimensions, Individual Page'); ?>:</td>
                    </tr>
                    <tr>
                        <td><?php echo _('Width (% or px)'); ?>:</td>
                        <td>
                            <input type="text" value="<?php echo $map['indw']; ?>" name="mapindw" onblur="this.value = validateWidth(this.value)">
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo _('Height (px)'); ?>:</td>
                        <td>
                            <input type="text" value="<?php echo $map['indh']; ?>" name="mapindh" onblur="this.value = validateHeight(this.value)">
                        </td>
                    </tr>

                    <tr>
                        <td class="align-top" colspan="2"><br><?php echo _('Dimensions, Headstones Pages'); ?>:</td>
                    </tr>
                    <tr>
                        <td><?php echo _('Width (% or px)'); ?>:</td>
                        <td>
                            <input type="text" value="<?php echo $map['hstw']; ?>" name="maphstw" onblur="this.value = validateWidth(this.value)">
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo _('Height (px)'); ?>:</td>
                        <td>
                            <input type="text" value="<?php echo $map['hsth']; ?>" name="maphsth" onblur="this.value = validateHeight(this.value)">
                        </td>
                    </tr>

                    <tr>
                        <td class="align-top" colspan="2"><br><?php echo _('Dimensions, Admin Pages'); ?>:</td>
                    </tr>
                    <tr>
                        <td><?php echo _('Width (% or px)'); ?>:</td>
                        <td>
                            <input type="text" value="<?php echo $map['admw']; ?>" name="mapadmw" onblur="this.value = validateWidth(this.value)">
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo _('Height (px)'); ?>:</td>
                        <td>
                            <input type="text" value="<?php echo $map['admh']; ?>" name="mapadmh" onblur="this.value = validateHeight(this.value)">
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo _('Hide Admin Maps to Start'); ?>:</td>
                        <td>
                            <select name="startoff">
                                <option value="1"<?php if ($map['startoff']) {
                                    echo " selected";
                                } ?>><?php echo _('Yes'); ?></option>
                                <option value="0"<?php if (!$map['startoff']) {
                                    echo " selected";
                                } ?>><?php echo _('No'); ?></option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo _('Hide Public Maps to Start'); ?>:</td>
                        <td>
                            <select name="pstartoff">
                                <option value="1"<?php if ($map['pstartoff']) {
                                    echo " selected";
                                } ?>><?php echo _('Yes'); ?></option>
                                <option value="0"<?php if (!$map['pstartoff']) {
                                    echo " selected";
                                } ?>><?php echo _('No'); ?></option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td class="align-top" colspan="2"><br></td>
                    </tr>
                    <tr>
                        <td><?php echo _('Consolidate Duplicate Pins'); ?>:</td>
                        <td>
                            <select name="showallpins">
                                <option value="0"<?php if (!$map['showallpins']) {
                                    echo " selected";
                                } ?>><?php echo _('Yes'); ?></option>
                                <option value="1"<?php if ($map['showallpins']) {
                                    echo " selected";
                                } ?>><?php echo _('No'); ?></option>
                            </select>
                        </td>
                    </tr>
                </table>
                <br>
                <input type="hidden" name="pinplacelevel0" value="<?php echo $pinplacelevel0; ?>">
                <input type="hidden" name="pinplacelevel1" value="<?php echo $pinplacelevel1; ?>">
                <input type="hidden" name="pinplacelevel2" value="<?php echo $pinplacelevel2; ?>">
                <input type="hidden" name="pinplacelevel3" value="<?php echo $pinplacelevel3; ?>">
                <input type="hidden" name="pinplacelevel4" value="<?php echo $pinplacelevel4; ?>">
                <input type="hidden" name="pinplacelevel5" value="<?php echo $pinplacelevel5; ?>">
                <input type="hidden" name="pinplacelevel6" value="<?php echo $pinplacelevel6; ?>">
                <input type="submit" name="submit" accesskey="s" class="btn" value="<?php echo _('Save'); ?>">
            </form>
        </td>
    </tr>

</table>
<?php echo tng_adminfooter(); ?>
