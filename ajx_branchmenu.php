<?php
include "begin.php";
include "adminlib.php";

$admin_login = 1;
include "checklogin.php";
if (!$allow_edit || $assignedbranch) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

$query = "SELECT action FROM $branches_table WHERE gedcom = '$tree' and branch = '$branch'";
$result = tng_query($query);
$brow = tng_fetch_assoc($result);
tng_free_result($result);

header("Content-type:text/html; charset=" . $session_charset);
?>

<div style="margin:10px;">
    <h3 class="subhead"><?php echo _('Add labels'); ?></h3>

    <form action="#" method="post" id="form2" name="form2" onsubmit="return addLabels();">
        <table cellpadding="1" class="normal">
            <tr>
                <td colspan="2"><br><strong><?php echo _('Action'); ?>:</strong></td>
            </tr>
            <tr>
                <td colspan="2">
                    &nbsp;&nbsp;<input type="radio" name="branchaction" value="add" checked onClick="toggleAdd();"> <?php echo _('Add labels'); ?><br>
                    &nbsp;&nbsp;<input type="radio" name="branchaction" value="clear" onClick="toggleClear(0);"> <?php echo _('Clear labels'); ?><br>
                    &nbsp;&nbsp;<input type="radio" name="branchaction" value="delete" onClick="toggleClear(1);"> <?php echo _('Delete people and families with this branch label'); ?><br>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div id="allpart" style="display:none;">
                        &nbsp;&nbsp;<input type="radio" name="set" value="all"> <?php echo _('All'); ?>
                        &nbsp;&nbsp;<input type="radio" name="set" value="partial" checked> <?php echo _('Partial'); ?>
                    </div>
                </td>
            </tr>
            <tr id="overwrite1">
                <td>
                    <div><br><strong><?php echo _('Existing labels'); ?>:</strong></div>
                </td>
                <td>
                    <div><br>
                        <select name="overwrite" id="overwrite">
                            <?php $action = $brow['action'] ? $brow['action'] : 2; ?>
                            <option value="2" <?php if ($action == 2) {
                                echo " selected";
                            } ?>>
                                <?php echo _('Append New'); ?>
                            </option>
                            <option value="1" <?php if ($action == 1) {
                                echo " selected";
                            } ?>>
                                <?php echo _('Overwrite'); ?>
                            </option>
                            <option value="0" <?php if ($action == 0) {
                                echo " selected";
                            } ?>>
                                <?php echo _('Leave'); ?></option>
                        </select>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <br>
                    <input type="submit" id="labelsub" value="<?php echo _('Add labels'); ?>">
                    &nbsp; <img src="img/spinner.gif" style="display:none;" id="labelspinner">
                </td>
            </tr>
        </table>

    </form>
    <div class="normal" id="branchresults"></div>
</div>