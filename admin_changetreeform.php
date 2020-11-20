<?php
include "begin.php";
include "adminlib.php";
require "./admin/trees.php";

include "checklogin.php";
//permissions
if ($assignedtree || !$allow_edit) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

switch ($entity) {
    case "person":
        $IDlabel = _('Person ID');
        break;
    case "source":
        $IDlabel = _('Source ID');
        break;
    case "repo":
        $IDlabel = _('Repository ID');
        break;
}

list($treelist, $currenttree) = getTreesSelectOptionsHtml($trees_table, $oldtree);

header("Content-type:text/html; charset=" . $session_charset);
?>

<div class="databack ajaxwindow" id="changetree">
    <h3 class="subhead"><?php echo _('Change Tree'); ?></h3>
    <form id="changetree" name="changetree" action="admin_changetree.php" onsubmit="return onChangeTree(this);">
        <table class="normal" border="0" cellpadding="2">
            <tr>
                <td><?php echo _('Current Tree'); ?>:</td>
                <td><?php echo $currenttree; ?></td>
            <tr>
                <td><?php echo _('New Tree'); ?>:</td>
                <td>
                    <select name="newtree"
                        onchange="if(document.changetree.newtree.selectedIndex > 0) generateID('<?php echo $entity; ?>',document.changetree.newID,document.changetree.newtree);">
                        <?php echo $treelist; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><?php echo $IDlabel; ?>:</td>
                <td>
                    <input type="text" name="newID" id="newID" size="10" onblur="this.value=this.value.toUpperCase()">
                    <input type="button" value="<?php echo _('Generate'); ?>"
                        onclick="if(document.changetree.newtree.selectedIndex > 0) generateID('person',document.changetree.newID,document.changetree.newtree);">
                    <input type="button" value="<?php echo _('Check'); ?>"
                        onclick="if(document.changetree.newtree.selectedIndex > 0) checkID(document.changetree.newID.value,'person','checkmsg',document.changetree.newtree);">
                </td>
            </tr>
            <tr>
                <td colspan="2"><span id="checkmsg" class="normal"></span></td>
            </tr>
        </table>
        <p><small><?php echo _('WARNING: This operation will remove all family links, citations and other references to this entity within the current tree.'); ?></small></p>
        <input type="hidden" name="entity" value="<?php echo $entity; ?>">
        <input type="hidden" name="oldtree" value="<?php echo $oldtree; ?>">
        <input type="hidden" name="entityID" value="<?php echo $entityID; ?>">
        <input type="submit" name="submit" value="<?php echo _('Save'); ?>">
        <input type="button" name="cancel" value="<?php echo _('Cancel'); ?>" onclick="tnglitbox.remove();">
    </form>
</div>