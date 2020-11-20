<?php

include "begin.php";
include "adminlib.php";

$admin_login = 1;
include "checklogin.php";
if (!$allow_add) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

$helplang = findhelp("collections_help.php");

initMediaTypes();

header("Content-type:text/html; charset=" . $session_charset);
?>

<div class="databack normal" style="margin:10px;border:0;" id="newcollection">
    <h3 class="subhead"><?php echo _('Add Collection'); ?> |
        <a href="#" onclick="return openHelp('<?php echo $helplang; ?>/collections_help.php');"><?php echo _('Help for this area'); ?></a></h3>

    <form action="admin_addcollection.php" method="post" name="collform" id="collform" onsubmit="return addCollection(this);">
        <table cellpadding="2" class="normal">
            <tr>
                <td><?php echo _('Collection ID'); ?>:</td>
                <td>
                    <input type="text" name="collid" class="w-24" onblur="if(!$('exportas').value) $('exportas').value = this.value.toUpperCase();">
                </td>
            </tr>
            <tr>
                <td><?php echo _('Export as'); ?>:</td>
                <td>
                    <input type="text" name="exportas" id="exportas" class="w-24" value="PHOTO">
                </td>
            </tr>
            <tr>
                <td><?php echo _('Display Title'); ?>:</td>
                <td>
                    <input type="text" name="display" size="30">
                </td>
            </tr>
            <tr>
                <td><?php echo _('Folder Name'); ?>:</td>
                <td>
                    <input type="text" name="path" size="50">
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <input type="button" value="<?php echo _('Make Folder'); ?>" onclick="if(document.collform.path.value){makeFolder('newcoll',document.collform.path.value);}">
                    <span id="msg_newcoll"></span></td>
            </tr>
            <tr>
                <td><?php echo _('Local path(s)'); ?>:</td>
                <td>
                    <input type="text" name="localpath" size="50" value="<?php echo $row['localpath']; ?>">
                </td>
            </tr>
            <tr>
                <td><?php echo _('Icon File'); ?>:</td>
                <td>
                    <input type="text" name="icon" size="30" value="img/">
                </td>
            </tr>
            <tr>
                <td><?php echo _('Thumbnail File'); ?>:</td>
                <td>
                    <input type="text" name="thumb" size="30" value="img/">
                </td>
            </tr>
            <tr>
                <td><?php echo _('Display Order'); ?>:</td>
                <td>
                    <input type="text" name="ordernum" size="5">
                </td>
            </tr>
            <tr>
                <td><?php echo _('Same setup as'); ?>:</td>
                <td>
			<span class="normal">
			<select name="liketype">
<?php
foreach ($mediatypes as $mediatype) {
    if (!$mediatype['type']) {
        $msgID = $mediatype['ID'];
        echo "	<option value=\"$msgID\">" . $mediatype['display'] . "</option>\n";
    }
}
?>
			</select>
			</span>
                </td>
            </tr>
        </table>

        <input type="hidden" name="field" value="<?php echo "$field"; ?>">
        <input type="submit" value="<?php echo _('Save'); ?>">
        <input type="button" name="cancel" value="<?php echo _('Cancel'); ?>" onclick="tnglitbox.remove();">
        <span id="cerrormsg" style="color:#CC0000;display:none;"><?php echo _('The Collection ID you entered could not be added because it already exists.'); ?></span>
    </form>
</div>
