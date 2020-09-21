<?php

include "begin.php";
include "config/mapconfig.php";
$mapkeystr = $map['key'] && $map['key'] != "1" ? "&amp;key=" . $map['key'] : "";
include "adminlib.php";
$textpart = "cemeteries";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
if (!$allow_edit) {
    $message = $admtext['norights'];
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
$showmap_url = getURL("showmap", 1);

$flags['tabs'] = $tngconfig['tabs'];
tng_adminheader($admtext['modifycemetery'], $flags);

if ($map['key'] && $isConnected) {
    echo "<script type=\"text/javascript\" src=\"{$http}://maps.googleapis.com/maps/api/js?language={$text['glang']}$mapkeystr\"></script>\n";
}
?>
    <script type="text/javascript" src="js/selectutils.js?v<?php echo $tng_version; ?>"></script>
    <script type="text/javascript" src="js/mediautils.js?v<?php echo $tng_version; ?>"></script>
    <script type="text/javascript" src="js/admin.js?v<?php echo $tng_version; ?>"></script>
    <script type="text/javascript">
        const nothingtodelete = '<?php echo $admtext['nothingtodelete']; ?>';
        const confdeleteentity = '<?php echo $admtext['confdeleteentity']; ?>';
        const pleaseenter = '<?php echo $admtext['pleaseenter']; ?>';
        const confdeletefile = '<?php echo $admtext['confdeletefile']; ?>';
        var tnglitbox;
        var tree = "";

        function validateForm() {
            let rval = true;
            if (document.form1.country.value.length == 0) {
                alert("<?php echo $admtext['entercountry']; ?>");
                rval = false;
            } else if (document.form1.newfile.value.length > 0 && document.form1.maplink.value.length == 0) {
                alert("<?php echo $admtext['entermapfile']; ?>");
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
if ($map['key']) {
    include "googlemaplib2.php";
}
?>
    </head>

    <body class="admin-body"<?php if ($map['key']) {
        if (!$map['startoff']) {
            echo " onload=\"divbox('mapcontainer');\"";
        }
    } ?>>

    <?php
    $cemtabs[0] = [1, "admin_cemeteries.php", $admtext['search'], "findcem"];
    $cemtabs[1] = [$allow_add, "admin_newcemetery.php", $admtext['addnew'], "addcemetery"];
    $cemtabs[2] = [$allow_add, "#", $admtext['edit'], "edit"];
    $innermenu = "<a href=\"#\" onclick=\"return openHelp('$helplang/cemeteries_help.php#add');\" class=\"lightlink\">{$admtext['help']}</a>";
    $innermenu .= " &nbsp;|&nbsp; <a href=\"$showmap_url" . "cemeteryID=$cemeteryID&tree=$tree\" target=\"_blank\" class=\"lightlink\">{$admtext['test']}</a>";
    $menu = doMenu($cemtabs, "edit", $innermenu);
    echo displayHeadline($admtext['cemeteries'] . " &gt;&gt; " . $admtext['modifycemetery'], "img/cemeteries_icon.gif", $menu, $message);
    ?>

    <form action="admin_updatecemetery.php" method="post" name="form1" id="form1" ENCTYPE="multipart/form-data" onSubmit="return validateForm();">
        <table class="lightback">
            <tr class="databack">
                <td class="tngshadow">
                    <table class="normal" width="100%">
                        <tr>
                            <td><?php echo $admtext['cemeteryname']; ?>:</td>
                            <td width="80%">
                                <input type="text" value="<?php echo $row['cemname']; ?>" name="cemname" id="cemname" size="40">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $admtext['maptoupload']; ?>*:</td>
                            <td>
                                <input type="file" name="newfile" size="60" onChange="populatePath(document.form1.newfile,document.form1.maplink);">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $admtext['mapfilenamefolder']; ?>**:</td>
                            <td>
                                <input type="text" value="<?php echo $row['maplink']; ?>" name="maplink" id="maplink" size="60">
                                <input type="hidden" id="maplink_org" value="<?php echo $row['maplink']; ?>">
                                <input type="hidden" id="maplink_last">
                                <input type="button" value="<?php echo $admtext['select'] . "..."; ?>" OnClick="FilePicker('maplink','headstones');">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $admtext['city']; ?>:</td>
                            <td>
                                <input type="text" value="<?php echo $row['city']; ?>" name="city" id="city" size="20">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $admtext['countyparish']; ?>:</td>
                            <td>
                                <input type="text" value="<?php echo $row['county']; ?>" name="county" id="county" size="20">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $admtext['stateprovince']; ?>:</td>
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
                                <input type="button" name="addnewstate" value="<?php echo $admtext['addnew']; ?>"
                                       onclick="tnglitbox = new LITBox('admin_newentity.php?entity=state', {width:350, height:120}); $('newitem').focus();">
                                <input type="button" name="deletestate" value="<?php echo $admtext['deleteselected']; ?>"
                                       onclick="attemptDelete(document.form1.state,'state');">
                            </td>
                        </tr>
                        <tr>
                            <td><span class="normal"><?php echo $admtext['cap_country']; ?>:</span></td>
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
                                <input type="button" name="addnewcountry" value="<?php echo $admtext['addnew']; ?>"
                                       onclick="tnglitbox = new LITBox('admin_newentity.php?entity=country', {width:350, height:120}); $('newitem').focus();">
                                <input type="button" name="deletecountry" value="<?php echo $admtext['deleteselected']; ?>"
                                       onclick="attemptDelete(document.form1.country,'country');">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $admtext['linkplace']; ?>:</td>
                            <td>
                                <input type="text" value="<?php echo $row['place']; ?>" name="place" id="place" class="longfield"
                                       onblur="fillCemetery(this.value);">
                                <a href="#" onclick="return openFindPlaceForm('place');">
                                    <img src="img/tng_find.gif" title="<?php echo $admtext['find']; ?>" alt="<?php echo $admtext['find']; ?>"
                                         width="20" height="20" class="alignmiddle">
                                </a>
                                <input type="button" value="<?php echo $admtext['fillplace']; ?>" onclick="fillPlace(document.form1);">
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>
                                <input type="checkbox" name="usecoords" value="1"> <?php echo $admtext['usecemcoords']; ?></td>
                        </tr>
                        <?php
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
                            <?php
                        }
                        ?>
                        <tr>
                            <td><?php echo $admtext['latitude']; ?>:</td>
                            <td>
                                <input id="latbox" name="latitude" type="text" value="<?php echo $row['latitude']; ?>" size="20">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $admtext['longitude']; ?>:</td>
                            <td>
                                <input id="lonbox" name="longitude" type="text" value="<?php echo $row['longitude']; ?>" size="20">
                            </td>
                        </tr>
                        <?php
                        if ($map['key']) {
                            ?>
                            <tr>
                                <td><?php echo $admtext['zoom']; ?>:</td>
                                <td>
                                    <input id="zoombox" name="zoom" type="text" value="<?php echo $row['zoom']; ?>" size="20">
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        <tr>
                            <td valign="top"><?php echo $admtext['notes']; ?>:</td>
                            <td>
                                <textarea wrap cols="60" rows="8" name="notes"><?php echo $row['notes']; ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
		                        <span class="normal">
                                    <?php
                                    echo $admtext['onsave'] . ":<br>";
                                    echo "<input type=\"radio\" name=\"newscreen\" value=\"return\"> {$admtext['savereturn']}<br>\n";
                                    if ($cw) {
                                        echo "<input type=\"radio\" name=\"newscreen\" value=\"close\" checked> {$text['closewindow']}\n";
                                    } else {
                                        echo "<input type=\"radio\" name=\"newscreen\" value=\"none\" checked> {$admtext['saveback']}\n";
                                    }
                                    ?>
		                        </span>
                            </td>
                        </tr>
                    </table>
                    <br>&nbsp;
                    <input type="hidden" name="cemeteryID" value="<?php echo "$cemeteryID"; ?>">
                    <input type="hidden" value="<?php echo "$cw"; ?>" name="cw">
                    <input type="submit" name="submit" accesskey="s" class="btn" value="<?php echo $admtext['save']; ?>">
                    <p class="normal">*<?php echo $admtext['ifmapuploaded']; ?><br>
                        **<?php echo $admtext['requiredmap']; ?></p>
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

    <?php echo "<div align=\"right\"><span class='normal'>$tng_title, v.$tng_version</span></div>"; ?>
    </body>
<?php echo "</html>\n";