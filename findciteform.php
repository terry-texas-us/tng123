<?php
include "begin.php";
include "adminlib.php";
$textpart = "sources";
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

$applyfilter = "applyFilter({form:'findciteform1', fieldId:'mytitle', type:'C', tree:'$tree', destdiv:'citeresults'$mediaoption});";

header("Content-type:text/html; charset=" . $session_charset);
?>

<div class="databack ajaxwindow" id="findcitediv">
    <form action="" method="post" name="findciteform1" id="findciteform1" onsubmit="return <?php echo $applyfilter; ?>">
        <h3 class="subhead"><?php echo _('Find Citation ID'); ?><br>
            <span class="normal">(<?php echo _('Enter part of source title'); ?>)</span></h3>
        <table cellspacing="0" cellpadding="2" class="normal">
            <tr>
                <td><?php echo _('Title'); ?>:</td>
                <td>
                    <input type="text" name="mytitle" id="mytitle" class="longfield"
                        onkeyup="filterChanged(event, {form:'findciteform1',fieldId:'mytitle',type:'C',tree:'<?php echo $tree; ?>',destdiv:'citeresults'<?php echo $mediaoption; ?>});">
                </td>
                <td>
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

    <div id="citeresults" style="width:605px;height:385px;overflow:auto;"></div>
</div>