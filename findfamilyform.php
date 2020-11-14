<?php
include "begin.php";
include "adminlib.php";
$textpart = "families";
include "$mylanguage/admintext.php";

include "checklogin.php";

if ($mediaID) {
    $mediaoption = ", mediaID:'$mediaID'";
} else {
    if ($albumID) {
        $mediaoption = ", albumID:'$albumID'";
    } else {
        $mediaoption = "";
    }
}

$bailtext = $mediaoption ? _('Finish') : _('Cancel');

$applyfilter = "applyFilter({form:'findform1', fieldId:'myhusbname', myhusbname:jQuery('#myhusbname').val(), mywifename:jQuery('#mywifename').val(), myfamilyID:jQuery('#myfamilyID').val(), type:'F', tree:'$tree', branch:'branch', destdiv:'findresults'$mediaoption});";

header("Content-type:text/html; charset=" . $session_charset);
?>

<div class="databack ajaxwindow" id="finddiv">
    <form action="" method="post" name="findform1" id="findform1" onsubmit="return <?php echo $applyfilter; ?>">
        <h3 class="subhead"><?php echo _('Find Family ID'); ?><br>
            <span class="normal">(<?php echo _('Enter part of father\'s and/or mother\'s name'); ?>)</span></h3>
        <table cellspacing="0" cellpadding="2" class="normal">
            <tr>
                <td><?php echo _('Father\'s Name'); ?></td>
                <td><?php echo _('Mother\'s Name'); ?></td>
                <td><?php echo _('Family ID'); ?></td>
            </tr>
            <tr>
                <td>
                    <input type="text" name="myhusbname" id="myhusbname"
                        onkeyup="filterChanged(event, {form:'findform1',fieldId:'myhusbname',myhusbname:jQuery('#myhusbname').val(),mywifename:jQuery('#mywifename').val(),myfamilyID:jQuery('#myfamilyID').val(),type:'F',tree:'<?php echo $tree; ?>',branch:'<?php echo $branch; ?>',destdiv:'findresults'<?php echo $mediaoption; ?>});">
                </td>
                <td>
                    <input type="text" name="mywifename" id="mywifename"
                        onkeyup="filterChanged(event, {form:'findform1',fieldId:'mywifename',myhusbname:jQuery('#myhusbname').val(),mywifename:jQuery('#mywifename').val(),myfamilyID:jQuery('#myfamilyID').val(),type:'F',tree:'<?php echo $tree; ?>',branch:'<?php echo $branch; ?>',destdiv:'findresults'<?php echo $mediaoption; ?>});">
                </td>
                <td>
                    <input type="text" name="myfamilyID" id="myfamilyID"
                        onkeyup="filterChanged(event, {form:'findform1',fieldId:'myfamilyID',myhusbname:jQuery('#myhusbname').val(),mywifename:jQuery('#mywifename').val(),myfamilyID:jQuery('#myfamilyID').val(),type:'F',tree:'<?php echo $tree; ?>',branch:'<?php echo $branch; ?>',destdiv:'findresults'<?php echo $mediaoption; ?>});">
                    <input type="submit" value="<?php echo _('Search'); ?>">
                    <input type="button" value="<?php echo $bailtext; ?>" onclick="gotoSection(seclitbox, null);">
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <input type="radio" name="filter" value="s" onclick="<?php echo $applyfilter; ?>"> <?php echo _('starts with'); ?> &nbsp;&nbsp;
                    <input type="radio" name="filter" value="c" checked="checked"
                        onclick="<?php echo $applyfilter; ?>"> <?php echo _('contains'); ?>
                </td>
            </tr>
        </table>
    </form>

    <br>
    <span class="normal"><strong><?php echo _('Search Results'); ?></strong> (<?php echo _('click to select'); ?>)</span>

    <div id="findresults" style="width:605px;height:365px;overflow:auto;"></div>
</div>