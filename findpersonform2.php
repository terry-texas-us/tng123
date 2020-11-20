<?php
include "begin.php";
include "adminlib.php";

include "checklogin.php";

if ($type == "map") {
    $firstfield = "personID";
    $subtitle = _('enter ID or part of first and/or last name');
} else {
    $firstfield = "mylastname";
    $subtitle = _('Enter part of father\'s and/or mother\'s name');
}

header("Content-type:text/html; charset=" . $session_charset);
?>

<div class="databack ajaxwindow" id="finddiv">
    <h3 class="subhead"><?php echo _('Find Person ID'); ?></h3>

    <form action="" name="findform1" id="findform1" onsubmit="return openFind(this,'findperson2.php');">
        <span class="normal">(<?php echo $subtitle; ?>)</span><br>

        <input type="hidden" name="tree" value="<?php echo $tree; ?>">
        <?php if ($formname == "") {
            $formname = "form1";
        } ?>
        <input type="hidden" name="formname" value="<?php echo $formname; ?>">
        <?php if ($field == "") {
            $field = "personID";
        } ?>
        <input type="hidden" name="field" value="<?php echo $field; ?>">
        <?php if ($type == "") {
            $type = "text";
        } ?>
        <input type="hidden" name="type" value="<?php echo $type; ?>">
        <?php
        if ($nameplusid) {
            echo "<input type='hidden' name='nameplusid' value='$nameplusid'>";
        }
        ?>
        <table cellspacing="0" cellpadding="2">
            <tr>
                <td><span class="normal"><?php echo _('First Name'); ?>: </span></td>
                <td>
                    <input type="search" name="myfirstname" id="myfirstname">
                </td>
            </tr>
            <tr>
                <td><span class="normal"><?php echo _('Last Name'); ?>: </span></td>
                <td>
                    <input type="search" name="mylastname" id="mylastname">
                </td>
            </tr>
            <tr>
                <td><span class="normal"><?php echo _('Person ID'); ?>: </span></td>
                <td>
                    <input type="text" name="personID">
                </td>
            </tr>
        </table>
        <br>
        <input type="submit" value="<?php echo _('Search'); ?>">
        <img src="img/spinner.gif" id="findspin" style="display:none;">
    </form>

</div>

<div class="databack" style="display:none;border:0;" id="findresults">
</div>