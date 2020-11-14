<?php
include "begin.php";
include "adminlib.php";
$textpart = "photos";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
if (!$allow_edit) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

$query = "SELECT * FROM $mediatypes_table WHERE mediatypeID = \"$mediatypeID\"";
$result = tng_query($query);
$row = tng_fetch_assoc($result);
tng_free_result($result);

$exportas = $row['exportas'];
if (!$exportas) {
    $exportas = strtoupper($mediatypeID);
    if (substr($exportas, -1) == "S") {
        $exportas = substr($exportas, 0, -1);
    }
    if ($exportas == "HISTORIE") $exportas = "HISTORY";
}

$helplang = findhelp("collections_help.php");

initMediaTypes();

header("Content-type:text/html; charset=" . $session_charset);
?>

<div class="databack normal" style="margin:10px;border:0;" id="editcollection">
    <h3 class="subhead"><?php echo _('Edit Collection'); ?> |
        <a href="#" onclick="return openHelp('<?php echo $helplang; ?>/collections_help.php');"><?php echo _('Help for this area'); ?></a></h3>

    <form action="admin_updatecollection.php" method="post" name="collform" id="collform" onsubmit="return updateCollection(this);">
        <table cellpadding="2" class="normal">
            <tr>
                <td><?php echo _('Collection ID'); ?>:</td>
                <td><?php echo $mediatypeID; ?></td>
            </tr>
            <tr>
                <td><?php echo _('Export as'); ?>:</td>
                <td>
                    <input type="text" name="exportas" id="exportas" class="w-24" value="<?php echo $exportas; ?>">
                </td>
            </tr>
            <tr>
                <td><?php echo _('Display Title'); ?>:</td>
                <td>
                    <input type="text" name="display" size="30" value="<?php echo $row['display']; ?>">
                </td>
            </tr>
            <tr>
                <td><?php echo _('Folder Name'); ?>:</td>
                <td>
                    <input type="text" name="path" size="50" value="<?php echo $row['path']; ?>">
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
                    <input type="text" name="icon" size="30" value="<?php echo $row['icon']; ?>">
                </td>
            </tr>
            <tr>
                <td><?php echo _('Thumbnail File'); ?>:</td>
                <td>
                    <input type="text" name="thumb" size="30" value="<?php echo $row['thumb']; ?>">
                </td>
            </tr>
            <tr>
                <td><?php echo _('Display Order'); ?>:</td>
                <td>
                    <input type="text" name="ordernum" size="5" value="<?php echo $row['ordernum']; ?>">
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
        echo "	<option value=\"$msgID\"";
        if ($msgID == $row['liketype']) echo " selected";

        echo ">" . $mediatype['display'] . "</option>\n";
    }
}
?>
			</select>
			</span>
                </td>
            </tr>
        </table>

        <input type="hidden" name="collid" size="30" value="<?php echo $mediatypeID; ?>">
        <input type="hidden" name="field" value="<?php echo $field; ?>">
        <input type="hidden" name="selidx" value="<?php echo $selidx; ?>">
        <input type="submit" value="<?php echo _('Save'); ?>">
        <input type="button" name="cancel" value="<?php echo _('Cancel'); ?>" onclick="tnglitbox.remove();">
    </form>
</div>