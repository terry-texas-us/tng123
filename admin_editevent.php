<?php

include "begin.php";
include "adminlib.php";

include "checklogin.php";

$query = "SELECT display, events.eventtypeID AS eventtypeID, eventdate, eventplace, age, agency, cause, events.gedcom AS gedcom, events.addressID, address1, address2, city, state, zip, country, info, phone, email, www, type ";
$query .= "FROM ($events_table events, $eventtypes_table eventtypes) ";
$query .= "LEFT JOIN $address_table address ON events.addressID = address.addressID ";
$query .= "WHERE eventID = \"$eventID\" AND events.eventtypeID = eventtypes.eventtypeID";
$result = tng_query($query);
$row = tng_fetch_assoc($result);
tng_free_result($result);
$row['eventplace'] = preg_replace("/\"/", "&#34;", $row['eventplace']);
$row['info'] = preg_replace("/\"/", "&#34;", $row['info']);
$row['age'] = preg_replace("/\"/", "&#34;", $row['age']);
$row['agency'] = preg_replace("/\"/", "&#34;", $row['agency']);
$row['cause'] = preg_replace("/\"/", "&#34;", $row['cause']);
$row['address1'] = preg_replace("/\"/", "&#34;", $row['address1']);
$row['address1'] = preg_replace("/\"/", "&#34;", $row['address1']);
$row['city'] = preg_replace("/\"/", "&#34;", $row['city']);
$row['state'] = preg_replace("/\"/", "&#34;", $row['state']);
$row['zip'] = preg_replace("/\"/", "&#34;", $row['zip']);
$row['country'] = preg_replace("/\"/", "&#34;", $row['country']);

$display = getEventDisplay($row['display']);

$helplang = findhelp("events_help.php");

header("Content-type:text/html; charset=" . $session_charset);
?>

<div class="databack ajaxwindow">
    <h3 class="subhead"><?php echo _('Modify Event'); ?> |
        <a href="#" onclick="return openHelp('<?php echo $helplang; ?>/events_help.php');"><?php echo _('Help for this area'); ?></a></h3>
    <form action="" method="post" name="form1" id="form1" onSubmit="return updateEvent(this);">
        <table cellpadding="2" class="normal">
            <tr>
                <td><?php echo _('Event Type'); ?>:</td>
                <td><?php echo "{$row['tag']} $display"; ?></td>
            </tr>
            <tr>
                <td><?php echo _('Event Date'); ?>:</td>
                <td>
                    <input type="text" name="eventdate" id="eventdate" value="<?php echo $row['eventdate']; ?>" onBlur="checkDate(this);">
                    <span
                        class="normal"><?php echo _('(DD MMM YYYY)'); ?>:</span></td>
            </tr>
            <tr>
                <td><?php echo _('Event Place'); ?>:</td>
                <td class='align-top'>
                    <input type="text" name="eventplace" id="eventplace" size="40" value="<?php echo $row['eventplace']; ?>"> &nbsp;<?php echo _('OR'); ?>&nbsp;
                    <a href="#" onclick="return openFindPlaceForm('eventplace');">
                        <img src="img/tng_find.gif" class="align-middle" title="<?php echo _('Find...'); ?>" alt="<?php echo _('Find...'); ?>" width="20" height="20">
                    </a>
                </td>
            </tr>
            <tr>
                <td class='align-top'><?php echo _('Detail'); ?>:</td>
                <td><textarea name="info" rows="4" cols="40"><?php echo $row['info']; ?></textarea></td>
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
                                <input type="text" name="dupIDs" id="dupIDs" value="<?php echo $row['personID']; ?>" class="w-64"> &nbsp;<?php echo _('OR'); ?>&nbsp;
                            </td>
                            <td><a href="#" onclick="return findItem('<?php echo $row['type']; ?>','dupIDs','','<?php echo $row['gedcom']; ?>','<?php echo $assignedbranch; ?>');"
                                    title="<?php echo _('Find...'); ?>"
                                    class="smallicon admin-find-icon"></a></td>
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
                        <input type="text" name="age" size="12" maxlength="12" value="<?php echo $row['age']; ?>">
                    </td>
                </tr>
                <tr>
                    <td><?php echo _('Agency'); ?>:</td>
                    <td>
                        <input type="text" name="agency" size="40" value="<?php echo $row['agency']; ?>">
                    </td>
                </tr>
                <tr>
                    <td><?php echo _('Cause'); ?>:</td>
                    <td>
                        <input type="text" name="cause" size="40" value="<?php echo $row['cause']; ?>">
                    </td>
                </tr>
                <tr>
                    <td><?php echo _('Address 1'); ?>:</td>
                    <td>
                        <input type="text" name="address1" size="40" value="<?php echo $row['address1']; ?>">
                    </td>
                </tr>
                <tr>
                    <td><?php echo _('Address 2'); ?>:</td>
                    <td>
                        <input type="text" name="address2" size="40" value="<?php echo $row['address2']; ?>">
                    </td>
                </tr>
                <tr>
                    <td><?php echo _('City'); ?>:</td>
                    <td>
                        <input type="text" name="city" size="40" value="<?php echo $row['city']; ?>">
                    </td>
                </tr>
                <tr>
                    <td><?php echo _('State/Province'); ?>:</td>
                    <td>
                        <input type="text" name="state" size="40" value="<?php echo $row['state']; ?>">
                    </td>
                </tr>
                <tr>
                    <td><?php echo _('Zip/Postal Code'); ?>:</td>
                    <td>
                        <input type="text" name="zip" size="20" value="<?php echo $row['zip']; ?>">
                    </td>
                </tr>
                <tr>
                    <td><?php echo _('Country'); ?>:</td>
                    <td>
                        <input type="text" name="country" size="40" value="<?php echo $row['country']; ?>">
                    </td>
                </tr>
                <tr>
                    <td><?php echo _('Phone'); ?>:</td>
                    <td>
                        <input type="text" name="phone" size="30" value="<?php echo $row['phone']; ?>">
                    </td>
                </tr>
                <tr>
                    <td><?php echo _('E-mail'); ?>:</td>
                    <td>
                        <input type="text" name="email" size="50" value="<?php echo $row['email']; ?>">
                    </td>
                </tr>
                <tr>
                    <td><?php echo _('Web Site'); ?>:</td>
                    <td>
                        <input type="text" name="www" size="50" value="<?php echo $row['www']; ?>">
                    </td>
                </tr>
            </table>
            <br>
        </div>
        <input type="hidden" name="addressID" value="<?php echo $row['addressID']; ?>">
        <input type="hidden" name="eventID" value="<?php echo $eventID; ?>">
        <input type="hidden" name="tree" value="<?php echo $row['gedcom']; ?>">
        <input type="submit" class="btn" name="submit" value="<?php echo _('Save'); ?>">
        <input type="button" class="btn" name="cancel" value="<?php echo _('Cancel'); ?>" onclick="tnglitbox.remove();">
    </form>
    <br>
</div>
