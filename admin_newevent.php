<?php

include "begin.php";
include "adminlib.php";

$admin_login = 1;
include "checklogin.php";
$helplang = findhelp("events_help.php");

header("Content-type:text/html; charset=" . $session_charset);
?>

<div class="databack ajaxwindow">
    <h3 class="subhead"><?php echo _('Add New Event'); ?> |
        <a href="#" onclick="return openHelp('<?php echo $helplang; ?>/events_help.php');"><?php echo _('Help for this area'); ?></a></h3>
    <?php
    if ($message) {
        ?>
        <span class="normal red"><em><?php echo urldecode($message); ?></em>
	</span>
    <?php } ?>
    <form action="" method="post" name="form1" id="form1" onSubmit="return addEvent(this);">
        <table cellpadding="2" class="normal">
            <tr>
                <td class='align-top'><span class="normal"><?php echo _('Event Type'); ?>:</span></td>
                <td>
			<span class="normal">
			<select name="eventtypeID" id="eventtypeID">
				<option value=""></option>
<?php
$query = "SELECT * FROM $eventtypes_table WHERE type = \"$prefix\" ORDER BY tag";
$evresult = tng_query($query);

$events = [];
while ($eventtype = tng_fetch_assoc($evresult)) {
    $display = getEventDisplay($eventtype['display']);
    $option = $display . ($eventtype['tag'] != "EVEN" ? " ({$eventtype['tag']})" : "");
    $optionlen = strlen($option);
    $option = substr($option, 0, 40);
    if ($optionlen > strlen($option)) $option .= "&hellip;";

    $events[$display] = "<option value=\"{$eventtype['eventtypeID']}\">$option</option>\n";
}
tng_free_result($evresult);

ksort($events);
foreach ($events as $event)
    echo $event;
?>
			</select>
			</span>
                </td>
            </tr>
            <tr>
                <td><?php echo _('Event Date'); ?>:</td>
                <td>
                    <input type="text" name="eventdate" onBlur="checkDate(this);">
                    <span class="normal"><?php echo _('(DD MMM YYYY)'); ?>:</span></td>
            </tr>
            <tr>
                <td><?php echo _('Event Place'); ?>:</td>
                <td class='align-top'>
                    <input type="text" name="eventplace" id="eventplace" size="40"> &nbsp;<?php echo _('OR'); ?>&nbsp;
                    <a href="#" onclick="return openFindPlaceForm('eventplace');">
                        <img src="img/tng_find.gif" class="align-middle" title="<?php echo _('Find...'); ?>" alt="<?php echo _('Find...'); ?>" width="20" height="20">
                    </a>
                </td>
            </tr>
            <tr>
                <td class='align-top'><?php echo _('Detail'); ?>:</td>
                <td><textarea name="info" rows="4" cols="40"></textarea></td>
            </tr>
            <tr>
                <td colspan="2"><strong><?php echo _('Duplicate for'); ?>:</strong></td>
            </tr>
            <tr>
                <td><?php echo _('ID'); ?>:</td>
                <td>
                    <table class="normal" cellpadding="0">
                        <tr>
                            <td>
                                <input type="text" name="dupIDs" id="dupIDs" class="medfield"> &nbsp;<?php echo _('OR'); ?>&nbsp;
                            </td>
                            <td><a href="#" onclick="return findItem('<?php echo $prefix; ?>','dupIDs','','<?php echo $tree; ?>','<?php echo $assignedbranch; ?>');"
                                    title="<?php echo _('Find...'); ?>" class="smallicon admin-find-icon"></a></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>(<?php echo _('Separate multiple entries with commas'); ?>)</td>
            </tr>
        </table>
        <?php echo displayToggle("plus9", 0, "more", _('More'), ""); ?>
        <br>
        <div id="more" style="display:none;">
            <table cellpadding="2" class="normal">
                <tr>
                    <td><?php echo _('Age'); ?>:</td>
                    <td>
                        <input type="text" name="age" size="12" maxlength="12">
                    </td>
                </tr>
                <tr>
                    <td><?php echo _('Agency'); ?>:</td>
                    <td>
                        <input type="text" name="agency" size="40">
                    </td>
                </tr>
                <tr>
                    <td><?php echo _('Cause'); ?>:</td>
                    <td>
                        <input type="text" name="cause" size="40">
                    </td>
                </tr>
                <tr>
                    <td><?php echo _('Address 1'); ?>:</td>
                    <td>
                        <input type="text" name="address1" size="40">
                    </td>
                </tr>
                <tr>
                    <td><?php echo _('Address 2'); ?>:</td>
                    <td>
                        <input type="text" name="address2" size="40">
                    </td>
                </tr>
                <tr>
                    <td><?php echo _('City'); ?>:</td>
                    <td>
                        <input type="text" name="city" size="40">
                    </td>
                </tr>
                <tr>
                    <td><?php echo _('State/Province'); ?>:</td>
                    <td>
                        <input type="text" name="state" size="40">
                    </td>
                </tr>
                <tr>
                    <td><?php echo _('Zip/Postal Code'); ?>:</td>
                    <td>
                        <input type="text" name="zip" size="20">
                    </td>
                </tr>
                <tr>
                    <td><?php echo _('Country'); ?>:</td>
                    <td>
                        <input type="text" name="country" size="40">
                    </td>
                </tr>
                <tr>
                    <td><?php echo _('Phone'); ?>:</td>
                    <td>
                        <input type="text" name="phone" size="30">
                    </td>
                </tr>
                <tr>
                    <td><?php echo _('E-mail'); ?>:</td>
                    <td>
                        <input type="text" name="email" size="50">
                    </td>
                </tr>
                <tr>
                    <td><?php echo _('Web Site'); ?>:</td>
                    <td>
                        <input type="text" name="www" size="50">
                    </td>
                </tr>
            </table>
            <br>
        </div>
        <input type="hidden" name="persfamID" value="<?php echo $persfamID; ?>">
        <input type="hidden" name="tree" value="<?php echo $tree; ?>">
        <input type="submit" class="btn" name="submit" value="<?php echo _('Save'); ?>">
        <input type="button" class="btn" name="cancel" value="<?php echo _('Cancel'); ?>" onclick="tnglitbox.remove();">
    </form>
    <br>
</div>
