<?php
include "begin.php";
include "adminlib.php";
$textpart = "findplace";
include "$mylanguage/admintext.php";

include "checklogin.php";

if ($session_charset != "UTF-8") {
    $place = tng_utf8_decode($place);
}

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

$applyfilter = "applyFilter({form:'findform1', fieldId:'myplace', type:'L', tree:'$tree', destdiv:'placeresults', temple:getTempleCheck()$mediaoption});";

header("Content-type:text/html; charset=" . $session_charset);
?>

<div class="databack ajaxwindow" id="finddiv">
    <form action="" method="post" name="findform1" id="findform1" onsubmit="return <?php echo $applyfilter; ?>">
        <h3 class="subhead"><?php echo _('Find Place'); ?><br>
            <span class="normal">(<?php echo _('Enter part of a place name'); ?>)</span></h3>
        <table cellspacing="0" cellpadding="2" class="normal">
            <tr>
                <td><?php echo _('Place'); ?>:</td>
                <td>
                    <input type="text" name="myplace" id="myplace"
                        onkeyup="filterChanged(event, {form:'findform1',fieldId:'myplace', type:'L', tree:'<?php echo $tree; ?>', destdiv:'placeresults', temple:getTempleCheck()<?php echo $mediaoption; ?>});">
                </td>
                <td>
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
            <?php if ($temple) { ?>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="2">
                        <input type="checkbox" value="1" name="temple" id="temple" checked="checked"
                            onclick="lastFilter = ''; applyFilter({form:'findform1', fieldId:'myplace', type:'L', tree:'<?php echo $tree; ?>', destdiv:'placeresults', temple:getTempleCheck()<?php echo $mediaoption; ?>});"> <?php echo _('Find only LDS temple codes'); ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </form>

    <br>
    <span class="normal"><strong><?php echo _('Search Results'); ?></strong> (<?php echo _('click to select'); ?>)</span>

    <div id="placeresults" style="width:605px;height:385px;overflow:auto;"></div>
</div>