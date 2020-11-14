<?php

include "begin.php";
include "adminlib.php";
$textpart = "findpersonform";
include "getlang.php";
include "$mylanguage/admintext.php";

include "checklogin.php";

if (isset($type) && $type == "map") {
    $subtitle = _('enter ID or part of first and/or last name');
} else {
    $subtitle = _('Enter part of father\'s and/or mother\'s name');
}

if (isset($mediaID)) {
    $mediaoption = ",mediaID:'$mediaID'";
} else {
    if (isset($albumID)) {
        $mediaoption = ",albumID:'$albumID'";
    } else {
        $mediaoption = "";
    }
}

$bailtext = $mediaoption ? _('Finish') : _('Cancel');
if (!isset($branch)) $branch = "";

$applyfilter = "applyFilter({form:'findform1', fieldId:'myflastname', myflastname:jQuery('#myflastname').val(), myffirstname:jQuery('#myffirstname').val(), myfpersonID:jQuery('#myfpersonID').val(), type:'I', tree:'$tree', branch:'$branch', destdiv:'findresults'$mediaoption});";

header("Content-type:text/html; charset=" . $session_charset);
?>

<div class="databack ajaxwindow" id="finddiv">
    <form action="" method="post" name="findform1" id="findform1" onsubmit="return <?php echo $applyfilter; ?>">
        <h3 class="subhead"><?php echo _('Find Person ID'); ?><br>
            <span class="normal">(<?php echo $subtitle; ?>)</span></h3>
        <table cellspacing="0" cellpadding="2" class="normal">
            <tr>
                <td><?php echo _('First Name'); ?></td>
                <td><?php echo _('Last Name'); ?></td>
                <td><?php echo _('Person ID'); ?></td>
            </tr>
            <tr>
                <td>
                    <input type="text" name="myffirstname" id="myffirstname" tabindex="1"
                        onkeyup="filterChanged(event, {form:'findform1',fieldId:'myffirstname',myflastname:jQuery('#myflastname').val(),myffirstname:jQuery('#myffirstname').val(),myfpersonID:jQuery('#myfpersonID').val(),type:'I',tree:'<?php echo $tree; ?>',branch:'<?php echo $branch; ?>',destdiv:'findresults'<?php echo $mediaoption; ?>});">
                </td>
                <td>
                    <input type="text" name="myflastname" id="myflastname" tabindex="2"
                        onkeyup="filterChanged(event, {form:'findform1',fieldId:'myflastname',myflastname:jQuery('#myflastname').val(),myffirstname:jQuery('#myffirstname').val(),myfpersonID:jQuery('#myfpersonID').val(),type:'I',tree:'<?php echo $tree; ?>',branch:'<?php echo $branch; ?>',destdiv:'findresults'<?php echo $mediaoption; ?>});">
                </td>
                <td>
                    <input type="text" name="myfpersonID" id="myfpersonID" tabindex="3" class="w-24"
                        onkeyup="filterChanged(event, {form:'findform1',fieldId:'myfpersonID',myflastname:jQuery('#myflastname').val(),myffirstname:jQuery('#myffirstname').val(),myfpersonID:jQuery('#myfpersonID').val(),type:'I',tree:'<?php echo $tree; ?>',branch:'<?php echo $branch; ?>',destdiv:'findresults'<?php echo $mediaoption; ?>});">
                    <input type="submit" value="<?php echo _('Search'); ?>">
                    <input type="button" value="<?php echo $bailtext; ?>" onclick="gotoSection(seclitbox, null);">
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <input type="radio" name="filter" value="s" onclick="<?php echo $applyfilter; ?>"> <?php echo _('starts with'); ?> &nbsp;&nbsp;
                    <input type="radio" name="filter" value="c"
                        checked="checked"
                        onclick="<?php echo $applyfilter; ?>"> <?php echo _('contains'); ?>
                </td>
            </tr>
        </table>
    </form>

    <br>
    <span class="normal"><strong><?php echo _('Search Results'); ?></strong> (<?php echo _('click to select'); ?>)</span>

    <div id="findresults" style="width:605px;height:365px;overflow:auto;"></div>
</div>