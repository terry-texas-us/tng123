<?php

include "begin.php";
include "config/mapconfig.php";
$mapkeystr = $map['key'] && $map['key'] != "1" ? "&amp;key=" . $map['key'] : "";
include "adminlib.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
if (!$allow_edit) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

$tng_search_cemeteries = $_SESSION['tng_search_cemeteries'];

$query = "SELECT * FROM $cemeteries_table WHERE cemeteryID = '$cemeteryID'";
$result = tng_query($query);
$row = tng_fetch_assoc($result);
tng_free_result($result);
$row['cemname'] = preg_replace("/\"/", "&#34;", $row['cemname']);

$query = "SELECT state FROM $states_table";
$stateresult = tng_query($query);

$query = "SELECT country FROM $countries_table";
$countryresult = tng_query($query);

$helplang = findhelp("cemeteries_help.php");

tng_adminheader(_('Edit Existing Cemetery'), $flags);

if ($map['key'] && $isConnected) {
    echo "<script src=\"{$http}://maps.googleapis.com/maps/api/js?language=" . _('&amp;hl=en') . "$mapkeystr\"></script>\n";
}
?>
    <script src="js/selectutils.js"></script>
    <script src="js/mediautils.js"></script>
    <script>
        const nothingtodelete = '<?php echo _('Nothing to delete'); ?>';
        const confdeleteentity = '<?php echo _('Are you sure you want to delete the selected'); ?>';
        const pleaseenter = '<?php echo _('Please enter a '); ?>';
        const confdeletefile = '<?php echo _('Are you sure you want to delete this file?'); ?>';
        var tnglitbox;
        var tree = "";

        function validateForm() {
            let rval = true;
            if (document.form1.country.value.length === 0) {
                alert("<?php echo _('Please enter a country name.'); ?>");
                rval = false;
            } else if (document.form1.newfile.value.length > 0 && document.form1.maplink.value.length === 0) {
                alert("<?php echo _('Please enter a file name for your map file on the web server.'); ?>");
                rval = false;
            } else
                document.form1.maplink.value = document.form1.maplink.value.replace(/\\/g, "/");
            return rval;
        }

        var loaded = false;

        function populatePath(source, dest) {
            var lastslash, temp;

            dest.value = "";
            temp = source.value.replace(/\\/g, "/");
            lastslash = temp.lastIndexOf("/") + 1;
            if (lastslash)
                dest.value = source.value.slice(lastslash);
        }
    </script>
<?php
if ($map['key']) include "googlemaplib2.php";

echo "</head>\n";
$onload = $map['key'] && !$map['startoff'] ? " onload=\"divbox('mapcontainer');\"" : "";
echo tng_adminlayout($onload);

$cemtabs[0] = [1, "admin_cemeteries.php", _('Search'), "findcem"];
$cemtabs[1] = [$allow_add, "admin_newcemetery.php", _('Add New'), "addcemetery"];
$cemtabs[2] = [$allow_add, "#", _('Edit'), "edit"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/cemeteries_help.php#add');\" class='lightlink'>" . _('Help for this area') . "</a>";
$innermenu .= " &nbsp;|&nbsp; <a href='showmap.php?cemeteryID=$cemeteryID&tree=$tree' target='_blank' class='lightlink'>" . _('Test') . "</a>";
$menu = doMenu($cemtabs, "edit", $innermenu);
echo displayHeadline(_('Cemeteries') . " &gt;&gt; " . _('Edit Existing Cemetery'), "img/cemeteries_icon.gif", $menu, $message);
?>
    <form action="admin_updatecemetery.php" method="post" name="form1" id="form1" enctype="multipart/form-data" onSubmit="return validateForm();">
        <table class="lightback">
            <tr class="databack">
                <td class="tngshadow">
                    <table class="normal w-full">
                        <tr>
                            <td><?php echo _('Cemetery Name'); ?>:</td>
                            <td width="80%">
                                <input type="text" value="<?php echo $row['cemname']; ?>" name="cemname" id="cemname" size="40">
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
                                <input type="text" value="<?php echo $row['maplink']; ?>" name="maplink" id="maplink" size="60">
                                <input type="hidden" id="maplink_org" value="<?php echo $row['maplink']; ?>">
                                <input type="hidden" id="maplink_last">
                                <input type="button" value="<?php echo _('Select') . "..."; ?>" OnClick="FilePicker('maplink','headstones');">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('City'); ?>:</td>
                            <td>
                                <input type="text" value="<?php echo $row['city']; ?>" name="city" id="city" size="20">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('County/Parish'); ?>:</td>
                            <td>
                                <input type="text" value="<?php echo $row['county']; ?>" name="county" id="county" size="20">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('State/Province/Shire'); ?>:</td>
                            <td>
                                <select name="state" id="state">
                                    <option></option>
                                    <?php
                                    while ($staterow = tng_fetch_assoc($stateresult)) {
                                        echo "	<option value=\"{$staterow['state']}\"";
                                        if ($staterow['state'] == $row['state']) {
                                            echo " selected";
                                        }
                                        echo ">{$staterow['state']}</option>\n";
                                    }
                                    ?>
                                </select>
                                <input type="button" name="addnewstate" value="<?php echo _('Add New'); ?>"
                                    onclick="tnglitbox = new LITBox('admin_newentity.php?entity=state', {width:350, height:120}); $('newitem').focus();">
                                <input type="button" name="deletestate" value="<?php echo _('Delete Selected'); ?>"
                                    onclick="attemptDelete(document.form1.state,'state');">
                            </td>
                        </tr>
                        <tr>
                            <td><span class="normal"><?php echo _('Country'); ?>:</span></td>
                            <td>
                                <select name="country" id="country">
                                    <option></option>
                                    <?php
                                    while ($countryrow = tng_fetch_assoc($countryresult)) {
                                        echo "	<option value=\"{$countryrow['country']}\"";
                                        if ($countryrow['country'] == $row['country']) {
                                            echo " selected";
                                        }
                                        echo ">{$countryrow['country']}</option>\n";
                                    }
                                    ?>
                                </select>
                                <input type="button" name="addnewcountry" value="<?php echo _('Add New'); ?>"
                                    onclick="tnglitbox = new LITBox('admin_newentity.php?entity=country', {width:350, height:120}); $('newitem').focus();">
                                <input type="button" name="deletecountry" value="<?php echo _('Delete Selected'); ?>"
                                    onclick="attemptDelete(document.form1.country,'country');">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Associated Place'); ?>:</td>
                            <td>
                                <input type="text" value="<?php echo $row['place']; ?>" name="place" id="place" class="longfield"
                                    onblur="fillCemetery(this.value);">
                                <a href="#" onclick="return openFindPlaceForm('place');">
                                    <img src="img/tng_find.gif" title="<?php echo _('Find...'); ?>" alt="<?php echo _('Find...'); ?>"
                                        width="20" height="20" class="align-middle">
                                </a>
                                <input type="button" value="<?php echo _('Fill Place'); ?>" onclick="fillPlace(document.form1);">
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>
                                <input type="checkbox" name="usecoords" value="1"> <?php echo _('Copy the geocode information below to this place'); ?></td>
                        </tr>
                        <?php if ($map['key']) { ?>
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
                                <input id="latbox" name="latitude" type="text" value="<?php echo $row['latitude']; ?>" size="20">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Longitude'); ?>:</td>
                            <td>
                                <input id="lonbox" name="longitude" type="text" value="<?php echo $row['longitude']; ?>" size="20">
                            </td>
                        </tr>
                        <?php if ($map['key']) { ?>
                            <tr>
                                <td><?php echo _('Zoom'); ?>:</td>
                                <td>
                                    <input id="zoombox" name="zoom" type="text" value="<?php echo $row['zoom']; ?>" size="20">
                                </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td class='align-top'><?php echo _('Notes'); ?>:</td>
                            <td>
                                <textarea cols="60" rows="8" name="notes"><?php echo $row['notes']; ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
		                        <span class="normal">
                                    <?php
                                    echo _('On save') . ":<br>";
                                    echo "<input type='radio' name='newscreen' value='return'> " . _('Return to this page') . "<br>\n";
                                    if ($cw) {
                                        echo "<input type='radio' name='newscreen' value=\"close\" checked> " . _('Close this window') . "\n";
                                    } else {
                                        echo "<input type='radio' name='newscreen' value=\"none\" checked> " . _('Return to menu') . "\n";
                                    }
                                    ?>
		                        </span>
                            </td>
                        </tr>
                    </table>
                    <br>&nbsp;
                    <input type="hidden" name="cemeteryID" value="<?php echo "$cemeteryID"; ?>">
                    <input type="hidden" value="<?php echo "$cw"; ?>" name="cw">
                    <input type="submit" name="submit" accesskey="s" class="btn" value="<?php echo _('Save'); ?>">
                    <p class="normal">*<?php echo _('Leave this field blank if the file has already been uploaded to your headstones folder.'); ?><br>
                        **<?php echo _('Required if you are using a map. This should correspond to the name and location of your file <em>within the headstones folder</em> once the file is uploaded. For example, if your headstones folder is called <em>headstones</em>,	and you want your file to be called <em>map.jpg</em> and go in a subfolder of headstones called <em>mymaps</em>, you would enter <em>mymaps/map.jpg</em> in this field.'); ?>
                    </p>
                    <?php
                    if ($row['maplink']) {
                        $size = @GetImageSize("$rootpath$headstonepath/" . $row['maplink']);
                        echo "<br><br><img src=\"$headstonepath/{$row['maplink']}\" $size[3] alt=\"{$row['cemname']}\">\n";
                    }
                    ?>
                </td>
            </tr>
        </table>
    </form>

<?php echo tng_adminfooter(); ?>