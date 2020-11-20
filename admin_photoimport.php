<?php
include "begin.php";
include "adminlib.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
if (!$allow_media_add || $assignedtree) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

if ($assignedtree) {
    $wherestr = "WHERE gedcom = '$assignedtree'";
} else {
    $wherestr = "";
}
$treequery = "SELECT gedcom, treename FROM $trees_table $wherestr ORDER BY treename";

$helplang = findhelp("data_help.php");

// TODO text ['phimport'] was not defined in any language. Manually added here.
tng_adminheader(_todo_('Photo Import'), $flags);

$standardtypes = [];
$moptions = "";
$likearray = "var like = new Array();\n";
foreach ($mediatypes as $mediatype) {
    if (!$mediatype['type']) {
        $standardtypes[] = "\"" . $mediatype['ID'] . "\"";
    }
    $msgID = $mediatype['ID'];
    $moptions .= "	<option value=\"$msgID\"";
    if ($msgID == $mediatypeID) $moptions .= " selected";

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
$mediatabs[5] = [!$assignedtree, "admin_mediaupload.php", _('Upload'), "upload"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/media_help.php#import');\" class='lightlink'>" . _('Help for this area') . "</a>";
$menu = doMenu($mediatabs, "import", $innermenu);
echo displayHeadline(_('Media') . " &gt;&gt; " . _('Import'), "img/photos_icon.gif", $menu, $message);
?>

    <table class="lightback">
        <tr class="databack">
            <td class="tngshadow">
                <form action="admin_photoimporter.php" method="post" name="form1">
                    <table>
                        <tr>
                            <td><span class="normal"><?php echo _('Collection'); ?>:</span></td>
                            <td>
                                <select name="mediatypeID" onChange="switchOnType(this.options[this.selectedIndex].value)">
                                    <?php
                                    foreach ($mediatypes as $mediatype) {
                                        $msgID = $mediatype['ID'];
                                        echo "	<option value=\"$msgID\">" . $mediatype['display'] . "</option>\n";
                                    }
                                    ?>
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
                            <td><span class="normal"><?php echo _('Tree'); ?>*: </span></td>
                            <td>
                                <select name="tree">
                                    <option value=""></option>
                                    <?php
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
                    </table>
                    <p class="normal">*<?php echo _('Optional. Leave blank to allow photos to be visible in all trees.'); ?></p>
                    <input type="submit" name="submit" class="btn" value="<?php echo _('Import'); ?>">
                </form>
            </td>
        </tr>

    </table>
    <script src="js/mediautils.js"></script>
    <script>
        var tree = "<?php echo $tree; ?>";
        var tnglitbox;
        const entercollid = "<?php echo _('Please enter a collection ID.'); ?>";
        const entercolldisplay = "<?php echo _('Please enter a collection display name.'); ?>";
        const entercollipath = "<?php echo _('Please enter a collection folder name.'); ?>";
        const entercollicon = "<?php echo _('Please enter a collection icon file name.'); ?>";
        const confmtdelete = "<?php echo _('Are you sure you want to delete this media type?'); ?>";
        var stmediatypes = new Array(<?php echo $sttypestr; ?>);
        var allow_edit = <?php echo($allow_edit ? "1" : "0"); ?>;
        var allow_delete = <?php echo($allow_delete ? "1" : "0"); ?>;
        var manage = 1;
        <?php echo $likearray; ?>
    </script>

<?php echo tng_adminfooter(); ?>