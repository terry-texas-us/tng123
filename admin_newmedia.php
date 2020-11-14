<?php
include "begin.php";
include "adminlib.php";
$textpart = "photos";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
if (!$allow_media_add) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

if (!$tree) {
    if ($assignedtree) {
        $wherestr = "WHERE gedcom = '$assignedtree'";
        $tree = $assignedtree;
    } else {
        $wherestr = "";
        $tree = isset($_COOKIE['tng_tree']) ? $_COOKIE['tng_tree'] : "";
    }
}

$treequery = "SELECT gedcom, treename FROM $trees_table $wherestr ORDER BY treename";
$treeresult = tng_query($treequery) or die (_('Cannot execute query') . ": $treequery");
$treenum = 0;
while ($treerow = tng_fetch_assoc($treeresult)) {
    $treenum++;
    $trees[$treenum] = $treerow['gedcom'];
    $treename[$treenum] = $treerow['treename'];
}
tng_free_result($treeresult);

$helplang = findhelp("media_help.php");

tng_adminheader(_('Add New Media'), $flags);

$lastcoll = isset($_COOKIE['lastcoll']) ? $_COOKIE['lastcoll'] : "";
$standardtypes = [];
$moptions = "";
$likearray = "var like = new Array();\n";
foreach ($mediatypes as $mediatype) {
    if (!$mediatype['type']) {
        $standardtypes[] = "\"" . $mediatype['ID'] . "\"";
    }
    $msgID = $mediatype['ID'];
    $moptions .= "	<option value=\"$msgID\"";
    if ($lastcoll == $msgID) $moptions .= " selected";

    $moptions .= ">" . $mediatype['display'] . "</option>\n";
    $likearray .= "like['$msgID'] = '{$mediatype['liketype']}';\n";
}
$sttypestr = implode(",", $standardtypes);

echo "</head>\n";
echo tng_adminlayout();

$mediatabs[0] = [1, "admin_media.php", _('Search'), "findmedia"];
$mediatabs[1] = [$allow_media_add, "admin_newmedia.php", _('Add New'), "addmedia"];
$mediatabs[2] = [$allow_media_edit, "admin_ordermediaform.php", _('Sort'), "sortmedia"];
$mediatabs[3] = [$allow_media_edit && !$assignedtree, "admin_thumbnails.php", _('Thumbnails'), "thumbs"];
$mediatabs[4] = [!$assignedtree, "admin_photoimport.php", _('Import'), "import"];
$mediatabs[5] = [$allow_media_add, "admin_mediaupload.php", _('Upload'), "upload"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/media_help.php#add');\" class='lightlink'>" . _('Help for this area') . "</a> ";
$innermenu .= "&nbsp;|&nbsp;<a href='#' class='lightlink' onClick=\"return toggleAll('on');\">" . _('Expand all') . "</a> &nbsp;|&nbsp; <a href='#' class='lightlink' onClick=\"return toggleAll('off');\">" . _('Collapse all') . "</a>";
$menu = doMenu($mediatabs, "addmedia", $innermenu);
echo displayHeadline(_('Media') . " &gt;&gt; " . _('Add New Media'), "img/photos_icon.gif", $menu, "");
?>

    <form action="admin_addmedia.php" method="post" name="form1" id="form1" enctype="multipart/form-data" onSubmit="return validateForm();">
        <input type="hidden" name="link_personID" value="<?php echo $personID; ?>">
        <input type="hidden" name="link_tree" value="<?php echo $tree; ?>">
        <input type="hidden" name="link_linktype" value="<?php echo $linktype; ?>">
        <table class="lightback">
            <tr class="databack">
                <td class="tngshadow">
                    <?php echo displayToggle("plus0", 1, "mediafile", _('Media File'), _('Upload a new file from your computer, or select from files already on your site')); ?>

                    <div id="mediafile">
                        <br>
                        <table>
                            <tr>
                                <td><span class="normal"><?php echo _('Collection'); ?>:</span></td>
                                <td>
                                    <select name="mediatypeID" onChange="switchOnType(this.options[this.selectedIndex].value)">
                                        <?php echo $moptions; ?>
                                    </select>
                                    <?php if (!$assignedtree && $allow_add && $allow_edit && $allow_delete) { ?>
                                        <input type="button" name="addnewmediatype" value="<?php echo _('Add Collection'); ?>" class="align-top"
                                            onclick="tnglitbox = new LITBox('admin_newcollection.php?field=mediatypeID', {width:600, height:340});">
                                        <input type="button" name="editmediatype" id="editmediatype" value="<?php echo _('Edit'); ?>" style="vertical-align:top;display:none;"
                                            onclick="editMediatype(document.form1.mediatypeID);">
                                        <input type="button" name="delmediatype" id="delmediatype" value="<?php echo _('Delete'); ?>" style="vertical-align:top;display:none;"
                                            onclick="confirmDeleteMediatype(document.form1.mediatypeID);">
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="align-top" colspan="2">
                                    <input type="checkbox" name="abspath" value="1" onClick="toggleMediaURL();">
                                    <span class="normal"> <?php echo _('This media comes from an external source (you must supply your own thumbnail)'); ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"><span class="normal"><strong><br><?php echo _('Media File'); ?></strong></span></td>
                            </tr>
                            <tr id="imgrow">
                                <td><span class="normal"><?php echo _('File to upload'); ?>*:</span></td>
                                <td>
                                    <input type="file" name="newfile" size="60" onchange="populatePath(document.form1.newfile,document.form1.path);">
                                </td>
                            </tr>
                            <tr id="pathrow">
                                <td><span class="normal"><?php echo _('File name on site'); ?>**:</span></td>
                                <td>
                                    <input type="text" name="path" id="path" size="60">
                                    <input type="hidden" id="path_org">
                                    <input type="hidden" id="path_last">
                                    <input type="button"
                                        value="<?php echo _('Select') . "..."; ?>"
                                        name="photoselect"
                                        onclick="javascript:var folder = document.form1.usecollfolder[1].checked ? document.form1.mediatypeID.options[document.form1.mediatypeID.selectedIndex].value : 'media';FilePicker('path',folder);">
                                </td>
                            </tr>
                            <tr id="abspathrow" style="display:none;">
                                <td class='align-top'><span class="normal"><?php echo _('Media URL'); ?>:</span></td>
                                <td>
                                    <input type="text" name="mediaurl" size="60">
                                </td>
                            </tr>

                            <!-- history section -->
                            <tr id="bodytextrow">
                                <td class='align-top'><span class="normal"><?php echo _('<strong>OR</strong><br>Body Text'); ?>:</span></td>
                                <td class='align-top'><textarea cols="100" rows="12" name="bodytext" id="bodytext"></textarea></td>
                            </tr>

                            <?php if (function_exists("imageJpeg")) { ?>
                                <tr>
                                    <td class='align-top'><span class="normal"><strong><br><?php echo _('Thumbnail Image File'); ?></strong></span></td>
                                    <td class='align-top'><span class="normal"><br>
			<input type="radio" name="thumbcreate" value="specify" checked
                onClick="document.form1.newthumb.style.visibility='visible'; document.form1.thumbselect.style.visibility='visible';"> <?php echo _('Specify image'); ?> &nbsp;
			<input type="radio" name="thumbcreate" value="auto"
                onClick="document.form1.newthumb.style.visibility='hidden'; document.form1.thumbselect.style.visibility='hidden'; prepopulateThumb(); document.form1.abspath.checked=false;"> <?php echo _('Create from original'); ?></span>
                                    </td>
                                </tr>
                            <?php } else { ?>
                                <tr>
                                    <td colspan="2"><strong><span class="normal"><br><?php echo _('Thumbnail Image File'); ?></strong></span></td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td><span class="normal"><?php echo _('File to upload'); ?>*:</span></td>
                                <td>
                                    <input type="file" name="newthumb" size="60" onChange="populatePath(document.form1.newthumb,document.form1.thumbpath);">
                                </td>
                            </tr>
                            <tr>
                                <td><span class="normal"><?php echo _('File name on site'); ?>**:</span></td>
                                <td>
                                    <input type="text" name="thumbpath" id="thumbpath" size="60">
                                    <input type="hidden" id="thumbpath_org">
                                    <input type="hidden" id="thumbpath_last">
                                    <input type="button"
                                        value="<?php echo _('Select') . "..."; ?>"
                                        name="thumbselect"
                                        OnClick="javascript:var folder = document.form1.usecollfolder[1].checked ? document.form1.mediatypeID.options[document.form1.mediatypeID.selectedIndex].value : 'media';FilePicker('thumbpath',folder);">
                                </td>
                            </tr>
                            <tr>
                                <td class='align-top'><span class="normal"><strong><br><?php echo _('Store files in'); ?></strong></span></td>
                                <td class='align-top'><span class="normal"><br>
			<input type="radio" name="usecollfolder" value="0"> <?php echo _('Multimedia Folder'); ?> &nbsp;
			<input type="radio" name="usecollfolder" value="1" checked> <?php echo _('Collection Folder (e.g., \"photos\")'); ?></span>
                                </td>
                            </tr>
                            <tr id="vidrow1">
                                <td class='align-top'><span class="normal"><?php echo _('Width (pixels)'); ?>:</span></td>
                                <td>
                                    <input type="text" name="width" size="40">
                                </td>
                            </tr>
                            <tr id="vidrow2">
                                <td class='align-top'><span class="normal"><?php echo _('Height (pixels)'); ?>:</span></td>
                                <td>
                                    <input type="text" name="height" size="40">
                                    <span class="normal"> (<?php echo _('Please allow about 16 vertical pixels for the media player controller.'); ?>)</span></td>
                            </tr>
                        </table>
                        <p class="smaller">
                            <?php
                            echo "*" . _('Leave this field blank if the file has already been uploaded.') . "<br>\n";
                            echo "**" . _('Required. This should correspond to the name and location of your file <em>within the collection folder</em> once the file is uploaded. For example, suppose you are uploading a photo and your photos folder is called <em>photos</em>. If you want your file to be called <em>myphoto.jpg</em> and go in a subfolder of photos called <em>newphotos</em>, you would enter <em>newphotos/myphoto.jpg</em> in this field.') . "\n";
                            ?>
                        </p>
                    </div>
                </td>
            </tr>

            <tr class="databack">
                <td class="tngshadow">
                    <?php echo displayToggle("plus1", 1, "details", _('Media Information'), _('Edit media title, description and other basic details')); ?>

                    <div id="details">
                        <br>
                        <table class="normal">
                            <tr>
                                <td class='align-top'><?php echo _('Title'); ?>:</td>
                                <td><textarea cols="70" rows="3" name="description"></textarea></td>
                            </tr>
                            <tr>
                                <td class='align-top'><?php echo _('Description'); ?>:</td>
                                <td><textarea cols="70" rows="5" name="notes"></textarea></td>
                            </tr>
                            <tr>
                                <td><?php echo _('Owner/Source'); ?>:</td>
                                <td>
                                    <input type="text" name="owner" size="40">
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Date Taken/Created'); ?>:</td>
                                <td>
                                    <input type="text" name="datetaken" size="40" onblur="checkDate(this);">
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Tree'); ?>:</td>
                                <td>

                                    <?php
                                    echo "<select name='tree'>";
                                    echo "	<option value=\"\">" . _('All Trees') . "</option>\n";
                                    $treeresult = tng_query($treequery) or die (_('Cannot execute query') . ": $treequery");
                                    while ($treerow = tng_fetch_assoc($treeresult)) {
                                        echo "	<option value=\"{$treerow['gedcom']}\"";
                                        if ($treerow['gedcom'] == $tree) echo " selected";

                                        echo ">{$treerow['treename']}</option>\n";
                                    }
                                    tng_free_result($treeresult);
                                    ?>
                                    </select>
                                </td>
                            </tr>

                            <!-- headstone section -->
                            <tr id="cemrow">
                                <td><?php echo _('Cemetery'); ?>:</td>
                                <td>
                                    <div id="cemchoice"><a href="#" onclick="return toggleCemSelect();"><?php echo _('Select'); ?></a></div>
                                    <div id="cemselect" style="display:none;">
                                        <select name="cemeteryID">
                                            <option selected></option>
                                            <?php
                                            $query = "SELECT cemname, cemeteryID, city, county, state, country FROM $cemeteries_table ORDER BY country, state, county, city, cemname";
                                            $cemresult = tng_query($query);
                                            while ($cemrow = tng_fetch_assoc($cemresult)) {
                                                $cemetery = "{$cemrow['country']}, {$cemrow['state']}, {$cemrow['county']}, {$cemrow['city']}, {$cemrow['cemname']}";
                                                echo "		<option value=\"{$cemrow['cemeteryID']}\">$cemetery</option>\n";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr id="hsplotrow">
                                <td class='align-top'><?php echo _('Plot'); ?>:</td>
                                <td><textarea cols="70" rows="2" name="plot"></textarea></td>
                            </tr>
                            <tr id="hsstatrow">
                                <td><?php echo _('Status'); ?>:</td>
                                <td>
                                    <select name="status">
                                        <option value="">&nbsp;</option>
                                        <option value="notyetlocated"><?php echo _('Not yet located'); ?></option>
                                        <option value="located"><?php echo _('Located'); ?></option>
                                        <option value="unmarked"><?php echo _('Unmarked'); ?></option>
                                        <option value="missing"><?php echo _('Missing'); ?></option>
                                        <option value="cremated"><?php echo _('Cremated'); ?></option>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td class="align-top" colspan="2">
                                    <input type="checkbox" name="alwayson" value="1"> <?php echo _('Always viewable'); ?></td>
                            </tr>

                            <!-- history section -->
                            <tr id="newwinrow">
                                <td class="align-top" colspan="2">
                                    <input type="checkbox" name="newwindow" value="1"> <?php echo _('Open in new window'); ?></td>
                            </tr>

                            <!-- headstone section -->
                            <tr id="linktocemrow">
                                <td class="align-top" colspan="2">
                                    <input type="checkbox" name="linktocem" value="1"> <?php echo _('Link this media directly to the selected cemetery'); ?></td>
                            </tr>
                            <tr id="maprow">
                                <td class="align-top" colspan="2">
                                    <input type="checkbox" name="showmap" value="1"> <?php echo _('Show cemetery map and media whenever this item is displayed'); ?></td>
                            </tr>

                        </table>
                    </div>
                </td>
            </tr>

            <tr class="databack">
                <td class="tngshadow">
                    <p class="normal"><strong><?php echo _('Note: More information may be added, and the item linked to individuals or families, on the next screen.'); ?></strong></p>
                    <input type="hidden" name="usenl" value="0">
                    <input type="hidden" value="<?php echo "$cw"; ?>" name="cw">
                    <input type="hidden" name="numlinks" value="1">
                    <input type="submit" name="submitbtn" class="btn" accesskey="s" value="<?php echo _('Save and continue...'); ?>">
                </td>
            </tr>

        </table>
    </form>

    <script>
        var tree = "<?php echo $tree; ?>";
        var tnglitbox;
        var trees = new Array();
        var treename = new Array();
        const selectmsg = "<?php echo _('Please select/add a tree.'); ?>";
        <?php
        for ($i = 1; $i <= $treenum; $i++) {
            echo "trees[$i] = \"$trees[$i]\";\n";
            echo "treename[$i] = \"$treename[$i]\";\n";
        }
        echo "var thumbprefix = \"$thumbprefix\";\n";
        echo "var thumbsuffix = \"$thumbsuffix\";\n";
        echo "const treemsg = \"" . _('Tree') . "\";\n";
        echo "const personmsg = \"" . _('Person') . "\";\n";
        echo "const idmsg = \"" . _('ID') . "\";";
        echo "const familymsg = \"" . _('Family') . "\";\n";
        echo "const sourcemsg = \"" . _('Source') . "\";\n";
        echo "const repositorymsg = \"" . _('Repository') . "\";\n";
        echo "const placemsg = \"" . _('Place') . "\";\n";
        echo "const findmsg = \"" . _('Find...') . "\";\n";
        echo "const altdescmsg = \"" . _('Alternate Title') . "\";\n";
        echo "const altnotesmsg = \"" . _('Alternate Description') . "\";\n";
        echo "const makedefaultmsg = \"" . _('Make Default') . "\";\n";
        echo "const eventlinkmsg = \"" . _('Link to specific event') . "\";\n";
        echo "const eventmsg = \"" . _('Event(s)') . "\";\n";
        echo "var manage = 0;\n";
        echo $likearray;
        ?>
        var linkcount = 1;
        const entercollid = "<?php echo _('Please enter a collection ID.'); ?>";
        const entercolldisplay = "<?php echo _('Please enter a collection display name.'); ?>";
        const entercollipath = "<?php echo _('Please enter a collection folder name.'); ?>";
        const entercollicon = "<?php echo _('Please enter a collection icon file name.'); ?>";
        const confmtdelete = "<?php echo _('Are you sure you want to delete this media type?'); ?>";
        const confdeletefile = "<?php echo _('Are you sure you want to delete this file?'); ?>";
        var stmediatypes = new Array(<?php echo $sttypestr; ?>);
        var allow_edit = <?php echo($allow_edit ? "1" : "0"); ?>;
        var allow_delete = <?php echo($allow_delete ? "1" : "0"); ?>;

        function validateForm() {
            let rval = true;
            var frm = document.form1;
            var selectedType = frm.mediatypeID.options[frm.mediatypeID.selectedIndex].value;
            if (frm.thumbpath.value.length == 0 && frm.thumbcreate[1].checked == true) {
                alert("<?php echo _('Please enter a destination name for your thumbnail image'); ?>");
                rval = false;
            } else if (frm.thumbpath.value.length > 0 && frm.path.value == frm.thumbpath.value) {
                alert("<?php echo _('The principal image and the thumbnail image may not be the same file. Please select a different thumbnail image, or have one created for you.'); ?>");
                rval = false;
            } else {
                frm.path.value = frm.path.value.replace(/\\/g, "/");
                frm.thumbpath.value = frm.thumbpath.value.replace(/\\/g, "/");
            }
            if (rval && frm.newfile.value) {
                rval = false;
                var usecollfolder = frm.usecollfolder[0].checked ? 0 : 1;
                var mediatypeID = frm.mediatypeID.options[frm.mediatypeID.selectedIndex].value;
                var thumbpath = frm.newthumb.value ? frm.thumbpath.value : "";
            var params = {path: frm.path.value, thumbpath: thumbpath, usecollfolder: usecollfolder, mediatypeID: mediatypeID};
            jQuery.ajax({
                url: 'admin_checkfile.php',
                data: params,
                dataType: 'json',
                success: function (vars) {
                    frm.path.value = vars.path;
                    if (vars.thumbpath)
                        frm.thumbpath.value = vars.thumbpath;
                    document.form1.submit();
                }
            });
        }
        return rval;
    }

    var gsControlName = "";

    function toggleAll(display) {
        toggleSection('mediafile', 'plus0', display);
        toggleSection('details', 'plus1', display);
        return false;
    }
</script>
<script src="js/mediautils.js"></script>
<script src="js/datevalidation.js"></script>
<script>
    var preferEuro = <?php echo($tngconfig['preferEuro'] ? $tngconfig['preferEuro'] : "false"); ?>;
    var preferDateFormat = '<?php echo $preferDateFormat; ?>';
    switchOnType(document.form1.mediatypeID.options[document.form1.mediatypeID.selectedIndex].value);
    <?php
    include "niceditmsgs.php";
    ?>
</script>
<script src="js/nicedit.js"></script>
<script>
    //<![CDATA[
    bkLib.onDomLoaded(function () {
        new nicEditor({fullPanel: true}).panelInstance('bodytext');
    });
    //]]>
</script>

<?php echo tng_adminfooter(); ?>