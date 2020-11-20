<?php
include "begin.php";
include "adminlib.php";

include "checklogin.php";

header("Content-type:text/html; charset=" . $session_charset);
?>

<div class="databack ajaxwindow" id="finddiv">
    <h3 class="subhead"><?php echo _('Add New Links'); ?></h3><br>
    <form name="find2" id="find2" style="margin-top:0;" onsubmit="return getPotentialLinks('<?php echo $linktype; ?>');">
        <?php if ($linktype == "I") { ?>
            <table cellspacing="2" id="findformI">
                <tr>
                    <td colspan="2" class="normal"><br><strong><?php echo _('Find Person ID'); ?></strong> <span class="smaller">(<?php echo _('enter part of first and/or last name'); ?>)</span></td>
                </tr>
                <tr>
                    <td class="normal"><?php echo _('Last Name'); ?></td>
                    <td class="normal"><?php echo _('First Name'); ?></td>
                </tr>
                <tr>
                    <td>
                        <input type="search" name="mylastname" id="mylastname">
                    </td>
                    <td>
                        <input type="search" name="myfirstname" id="myfirstname">
                        <input type="submit" name="searchbutton" value="<?php echo _('Search'); ?>" class="align-top">
                        <span id="spinnerfind" style="display: none;"><img src="img/spinner.gif"></span>
                    </td>
                </tr>
            </table>
        <?php } elseif ($linktype == "F") { ?>
            <table cellspacing="2" id="findformF">
                <tr>
                    <td colspan="2" class="normal"><br><strong><?php echo _('Find Family ID'); ?></strong> <span class="smaller">(<?php echo _('Enter part of father\'s and/or mother\'s name'); ?>)</span></td>
                </tr>
                <tr>
                    <td class="normal"><?php echo _('Father\'s Name'); ?></td>
                    <td class="normal"><?php echo _('Mother\'s Name'); ?></td>
                </tr>
                <tr>
                    <td>
                        <input type="text" name="myhusbname" id="myhusbname">
                    </td>
                    <td>
                        <input type="text" name="mywifename" id="mywifename">
                        <input type="submit" name="searchbutton" value="<?php echo _('Search'); ?>" class="align-top">
                        <span id="spinnerfind" style="display:none;"><img src="img/spinner.gif"></span>
                    </td>
                </tr>
            </table>
        <?php } elseif ($linktype == "S") { ?>
            <table cellspacing="2" id="findformS">
                <tr>
                    <td colspan="2" class="normal"><br><strong><?php echo _('Find Source ID'); ?></strong> <span class="smaller">(<?php echo _('Enter part of source title'); ?>)</span></td>
                </tr>
                <tr>
                    <td class="normal"><?php echo _('Title'); ?></td>
                </tr>
                <tr>
                    <td>
                        <input type="text" name="mysourcetitle" id="mysourcetitle">
                        <input type="submit" name="searchbutton" value="<?php echo _('Search'); ?>" class="align-top">
                        <span id="spinnerfind" style="display:none;"><img src="img/spinner.gif"></span>
                    </td>
                </tr>
            </table>
        <?php } elseif ($linktype == "R") { ?>
            <table cellspacing="2" id="findformR">
                <tr>
                    <td colspan="2" class="normal"><br><strong><?php echo _('Find Repository ID'); ?></strong> <span class="smaller">(<?php echo _('Enter part of repository title'); ?>)</span></td>
                </tr>
                <tr>
                    <td class="normal"><?php echo _('Title'); ?></td>
                </tr>
                <tr>
                    <td>
                        <input type="text" name="myrepotitle" id="myrepotitle">
                        <input type="submit" name="searchbutton" value="<?php echo _('Search'); ?>" class="align-top">
                        <span id="spinnerfind" style="display:none;"><img src="img/spinner.gif"></span>
                    </td>
                </tr>
            </table>
        <?php } elseif ($linktype == "L") { ?>
            <table cellspacing="2" id="findformL">
                <tr>
                    <td colspan="2" class="normal"><br><strong><?php echo _('Find Place'); ?></strong> <span class="smaller">(<?php echo _('Enter part of a place name'); ?>)</span></td>
                </tr>
                <tr>
                    <td class="normal"><?php echo _('Place'); ?></td>
                </tr>
                <tr>
                    <td>
                        <input type="text" name="myplace" id="myplace">
                        <input type="submit" name="searchbutton" value="<?php echo _('Search'); ?>" class="align-top">
                        <span id="spinnerfind" style="display:none;"><img src="img/spinner.gif" width="16" height="16"></span>
                    </td>
                </tr>
            </table>
        <?php } ?>
    </form>
    <div id="newlines" style="width:605px;height:390px;overflow:auto;"></div>
    <br>
</div>
