<?php

include "begin.php";
include "adminlib.php";

include "checklogin.php";
if (!$allow_edit) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

$query = "SELECT passocID, relationship, reltype, gedcom ";
$query .= "FROM $assoc_table ";
$query .= "WHERE assocID = \"{$assocID}\"";
$result = tng_query($query);
$row = tng_fetch_assoc($result);
tng_free_result($result);
$row['relationship'] = preg_replace("/\"/", "&#34;", $row['relationship']);

$helplang = findhelp("assoc_help.php");

header("Content-type:text/html; charset=" . $session_charset);
?>

<h3 class="subhead"><?php echo _('Edit Existing Association'); ?> |
    <a href="#"
        onclick="return openHelp('<?php echo $helplang; ?>/assoc_help.php#add', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();"><?php echo _('Help for this area'); ?></a>
</h3>

<form action="" name="findassocform1" onSubmit="return updateAssociation(this);">
    <table class="normal w-full" cellpadding="2">
        <tr>
            <td colspan="2">
                <input type="radio" name="reltype" value="I"<?php if ($row['reltype'] == "I") {
                    echo " checked";
                } ?> onclick="activateAssocType('I');"> <?php echo _('Person'); ?> &nbsp;&nbsp;
                <input type="radio" name="reltype" value="F"<?php if ($row['reltype'] == "F") {
                    echo " checked";
                } ?> onclick="activateAssocType('F');"> <?php echo _('Family'); ?>
            </td>
        </tr>
        <tr>
            <td>
                <span id="person_label"<?php if ($row['reltype'] == "F") {
                    echo " style='display: none;'";
                } ?>><?php echo _('Person ID'); ?></span>
                <span id="family_label"<?php if ($row['reltype'] == "I") {
                    echo " style='display: none;'";
                } ?>><?php echo _('Family ID'); ?></span>:
            </td>
            <td class='align-top'>
                <input type="text" name="passocID" value="<?php echo $row['passocID']; ?>"> &nbsp;<?php echo _('OR'); ?>&nbsp;
                <a href="#" onclick="return findItem(assocType,'passocID','<?php echo $tree; ?>','<?php echo $assignedbranch; ?>');">
                    <img src="img/tng_find.gif" title="<?php echo _('Find...'); ?>" alt="<?php echo _('Find...'); ?>" class="align-middle" width="20" height="20" border="0" vspace="0" hspace="2">
                </a>
            </td>
        </tr>
        <tr>
            <td class='align-top'><span class="normal"><?php echo _('Relationship'); ?>:</span></td>
            <td>
                <input type="text" name="relationship" size="60" value="<?php echo $row['relationship']; ?>">
            </td>
        </tr>
    </table>
    <input type="hidden" name="assocID" value="<?php echo $assocID; ?>">
    <input type="hidden" name="tree" value="<?php echo $row['gedcom']; ?>">
    <input type="submit" name="submit" class="btn" value="<?php echo _('Save'); ?>">
</form>