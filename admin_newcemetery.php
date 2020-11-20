<?php
include "begin.php";
include "config/mapconfig.php";
$mapkeystr = $map['key'] && $map['key'] != "1" ? "&amp;key=" . $map['key'] : "";
include "adminlib.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
if (!$allow_add) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

$query = "SELECT state FROM $states_table";
$stateresult = tng_query($query);

$query = "SELECT country FROM $countries_table";
$countryresult = tng_query($query);

$helplang = findhelp("cemeteries_help.php");

tng_adminheader(_('Add New Cemetery'), $flags);

if ($map['key'] && $isConnected) {
    echo "<script src=\"{$http}://maps.googleapis.com/maps/api/js?language=" . _('&amp;hl=en') . "$mapkeystr\"></script>\n";
}
?>
    <script src="js/selectutils.js"></script>
    <script src="js/mediautils.js"></script>
    <script>
        const nothingtodelete = "<?php echo _('Nothing to delete'); ?>";
        const confdeleteentity = "<?php echo _('Are you sure you want to delete the selected'); ?>";
        const pleaseenter = "<?php echo _('Please enter a '); ?>";
        const confdeletefile = "<?php echo _('Are you sure you want to delete this file?'); ?>";
        var tnglitbox;
        var tree = "";

        function validateForm() {
            let rval = true;
            if (document.form1.country.value.length == 0) {
                alert("<?php echo _('Please enter a country name.'); ?>");
                rval = false;
            } else if (document.form1.newfile.value.length > 0 && document.form1.maplink.value.length == 0) {
                alert("<?php echo _('Please enter a file name for your map file on the web server.'); ?>");
                rval = false;
            } else
                document.form1.maplink.value = document.form1.maplink.value.replace(/\\/g, "/");
            return rval;
        }

        function populatePath(source, dest) {
            var lastslash, temp;
            dest.value = "";
        temp = source.value.replace(/\\/g, "/");
        lastslash = temp.lastIndexOf("/") + 1;
        if (lastslash)
            dest.value = source.value.slice(lastslash);
        }
    </script>
<?php if ($map['key']) include "googlemaplib2.php"; ?>
    </head>

<?php
$onload = $map['key'] && !$map['startoff'] ? " onload=\"divbox('mapcontainer');\"" : "";
echo tng_adminlayout($onload);

$cemtabs[0] = [1, "admin_cemeteries.php", _('Search'), "findcem"];
$cemtabs[1] = [$allow_add, "admin_newcemetery.php", _('Add New'), "addcemetery"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/cemeteries_help.php#add');\" class='lightlink'>" . _('Help for this area') . "</a>";
$menu = doMenu($cemtabs, "addcemetery", $innermenu);
echo displayHeadline(_('Cemeteries') . " &gt;&gt; " . _('Add New Cemetery'), "img/cemeteries_icon.gif", $menu, $message);
?>

    <form action="admin_addcemetery.php" method="post" name="form1" id="form1" enctype="multipart/form-data" onsubmit="return validateForm();">
        <table class="lightback">
            <tr class="databack">
                <td class="tngshadow">
                    <table class="normal w-full">
                        <tr>
                            <td><?php echo _('Cemetery Name'); ?>:</td>
                            <td width="80%">
                                <input type="text" name="cemname" id="cemname" size="40">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Map image to upload'); ?>*:</td>
                            <td>
                                <input type="file" name="newfile" size="60" onChange="populatePath(document.form1.newfile,document.form1.maplink);">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Map File Name<br>within Headstones folder'); ?>**:</td>
                            <td>
                                <input type="text" name="maplink" id="maplink" size="60">
                                <input type="hidden" id="maplink_org">
                                <input type="hidden" id="maplink_last">
                                <input type="button"
                                    value="<?php echo _('Select') . "..."; ?>"
                                    onclick="javascript:FilePicker('maplink','headstones');">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('City'); ?>:</td>
                            <td>
                                <input type="text" name="city" id="city" size="20">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('County/Parish'); ?>:</td>
                            <td>
                                <input type="text" name="county" id="county" size="20">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('State/Province/Shire'); ?>:</td>
                            <td>
                                <select name="state" id="state">
                                    <option></option>
                                    <?php
                                    while ($staterow = tng_fetch_assoc($stateresult)) {
                                        echo "	<option value=\"{$staterow['state']}\">{$staterow['state']}</option>\n";
                                    }
                                    ?>
                                </select>
                                <input type="button" name="addnewstate" value="<?php echo _('Add New'); ?>"
                                    onclick="tnglitbox = new LITBox('admin_newentity.php?entity=state', {width:350, height:120}); $('#newitem').focus();">
                                <input type="button" name="deletestate" value="<?php echo _('Delete Selected'); ?>"
                                    onclick="attemptDelete(document.form1.state,'state'); $('newitem').focus();">
                            </td>
                        </tr>
                        <tr>
                            <td><span class="normal"><?php echo _('Country'); ?>:</span></td>
                            <td>
                                <select name="country" id="country">
                                    <option></option>
                                    <?php
                                    while ($countryrow = tng_fetch_assoc($countryresult)) {
                                        echo "	<option value=\"{$countryrow['country']}\">{$countryrow['country']}</option>\n";
                                    }
                                    ?>
                                </select>
                                <input type="button" name="addnewcountry" value="<?php echo _('Add New'); ?>"
                                    onclick="tnglitbox = new LITBox('admin_newentity.php?entity=country', {width:350, height:120}); $('#newitem').focus();">
                                <input type="button" name="deletecountry" value="<?php echo _('Delete Selected'); ?>"
                                    onclick="attemptDelete(document.form1.country,'country');">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Associated Place'); ?>:</td>
                            <td>
                                <input type="text" name="place" id="place" class="longfield" onblur="fillCemetery(this.value);">
                                <a href="#" onclick="return openFindPlaceForm('place');">
                                    <img src="img/tng_find.gif" title="<?php echo _('Find...'); ?>" alt="<?php echo _('Find...'); ?>" width="20" height="20" class="align-middle"></a>
                                <input type="button" value="<?php echo _('Fill Place'); ?>" onclick="fillPlace(document.form1);">
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>
                                <input type="checkbox" name="usecoords" value="1" checked="checked"> <?php echo _('Copy the geocode information below to this place'); ?></td>
                        </tr>
                        <?php if ($map['key']) { ?>
                            <tr>
                                <td colspan="2">
                                    <div style="padding:10px;">
                                        <?php include "googlemapdrawthemap.php"; ?>
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
                        <?php } ?>
                        <tr>
                            <td class='align-top'><?php echo _('Notes'); ?>:</td>
                            <td><textarea cols="60" rows="8" name="notes"></textarea></td>
                        </tr>
                    </table>
                    <br>&nbsp;
                    <input type="submit" name="submit" accesskey="s" class="btn" value="<?php echo _('Save'); ?>">
                    <p class="normal">*<?php echo _('Leave this field blank if the file has already been uploaded to your headstones folder.'); ?><br>
                        **<?php echo _('Required if you are using a map. This should correspond to the name and location of your file <em>within the headstones folder</em> once the file is uploaded. For example, if your headstones folder is called <em>headstones</em>,	and you want your file to be called <em>map.jpg</em> and go in a subfolder of headstones called <em>mymaps</em>, you would enter <em>mymaps/map.jpg</em> in this field.'); ?>
                    </p>
                </td>
            </tr>
        </table>
    </form>
<?php echo tng_adminfooter(); ?>