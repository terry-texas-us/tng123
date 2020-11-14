<?php
include "begin.php";
include "adminlib.php";
$textpart = "events";
include "$mylanguage/admintext.php";

include "checklogin.php";

$query = "SELECT eventID, age, agency, cause, events.addressID, address1, address2, city, state, zip, country, info, phone, email, www ";
$query .= "FROM $events_table events ";
$query .= "LEFT JOIN $address_table address ON events.addressID = address.addressID ";
$query .= "WHERE parenttag = \"$eventID\" AND events.persfamID = '$persfamID' AND events.gedcom = '$tree'";
$result = tng_query($query);
$row = tng_fetch_assoc($result);
tng_free_result($result);
$row['age'] = preg_replace("/\"/", "&#34;", $row['age']);
$row['agency'] = preg_replace("/\"/", "&#34;", $row['agency']);
$row['cause'] = preg_replace("/\"/", "&#34;", $row['cause']);
$row['address1'] = preg_replace("/\"/", "&#34;", $row['address1']);
$row['address2'] = preg_replace("/\"/", "&#34;", $row['address2']);
$row['city'] = preg_replace("/\"/", "&#34;", $row['city']);
$row['state'] = preg_replace("/\"/", "&#34;", $row['state']);
$row['zip'] = preg_replace("/\"/", "&#34;", $row['zip']);
$row['country'] = preg_replace("/\"/", "&#34;", $row['country']);

$helplang = findhelp("more_help.php");

header("Content-type:text/html; charset=" . $session_charset);
?>

<div class="databack ajaxwindow" id="more">
    <form action="" name="editmoreform" onsubmit="return updateMore(this);">
        <div style="float:right;">
            <input type="submit" name="submit" class="btn" value="<?php echo _('Save'); ?>">
        </div>
        <h3 class="subhead"><?php echo "" . _('More Information') . ": $admtext[$eventID]"; ?> |
            <a href="#" onclick="return openHelp('<?php echo $helplang; ?>/more_help.php');"><?php echo _('Help for this area'); ?></a></h3>
        <table cellpadding="2">
            <tr>
                <td class='align-top'><span class="normal"><?php echo _('Age'); ?>:</span></td>
                <td>
                    <input type="text" name="age" size="12" maxlength="12" value="<?php echo $row['age']; ?>">
                </td>
            </tr>
            <tr>
                <td class='align-top'><span class="normal"><?php echo _('Agency'); ?>:</span></td>
                <td>
                    <input type="text" name="agency" size="50" value="<?php echo $row['agency']; ?>">
                </td>
            </tr>
            <tr>
                <td class='align-top'><span class="normal"><?php echo _('Cause'); ?>:</span></td>
                <td>
                    <input type="text" name="cause" size="50" value="<?php echo $row['cause']; ?>">
                </td>
            </tr>
            <tr>
                <td class="align-top" colspan="2"><span class="normal"><strong><?php echo _('Address'); ?></strong></span></td>
            </tr>
            <tr>
                <td class='align-top'><span class="normal"><?php echo _('Address 1'); ?>:</span></td>
                <td>
                    <input type="text" name="address1" size="50" value="<?php echo $row['address1']; ?>">
                </td>
            </tr>
            <tr>
                <td class='align-top'><span class="normal"><?php echo _('Address 2'); ?>:</span></td>
                <td>
                    <input type="text" name="address2" size="50" value="<?php echo $row['address2']; ?>">
                </td>
            </tr>
            <tr>
                <td class='align-top'><span class="normal"><?php echo _('City'); ?>:</span></td>
                <td>
                    <input type="text" name="city" size="50" value="<?php echo $row['city']; ?>">
                </td>
            </tr>
            <tr>
                <td class='align-top'><span class="normal"><?php echo _('State/Province'); ?>:</span></td>
                <td>
                    <input type="text" name="state" size="50" value="<?php echo $row['state']; ?>">
                </td>
            </tr>
            <tr>
                <td class='align-top'><span class="normal"><?php echo _('Zip/Postal Code'); ?>:</span></td>
                <td>
                    <input type="text" name="zip" size="20" value="<?php echo $row['zip']; ?>">
                </td>
            </tr>
            <tr>
                <td class='align-top'><span class="normal"><?php echo _('Country'); ?>:</span></td>
                <td>
                    <input type="text" name="country" size="50" value="<?php echo $row['country']; ?>">
                </td>
            </tr>
            <tr>
                <td class='align-top'><span class="normal"><?php echo _('Phone'); ?>:</span></td>
                <td>
                    <input type="text" name="phone" size="30" value="<?php echo $row['phone']; ?>">
                </td>
            </tr>
            <tr>
                <td class='align-top'><span class="normal"><?php echo _('E-mail'); ?>:</span></td>
                <td>
                    <input type="text" name="email" size="50" value="<?php echo $row['email']; ?>">
                </td>
            </tr>
            <tr>
                <td class='align-top'><span class="normal"><?php echo _('Web Site'); ?>:</span></td>
                <td>
                    <input type="text" name="www" size="50" value="<?php echo $row['www']; ?>">
                </td>
            </tr>
        </table>
        <input type="hidden" name="eventtypeID" value="<?php echo $eventID; ?>">
        <input type="hidden" name="addressID" value="<?php echo $row['addressID']; ?>">
        <input type="hidden" name="eventID" value="<?php echo $row['eventID']; ?>">
        <input type="hidden" name="persfamID" value="<?php echo $persfamID; ?>">
        <input type="hidden" name="tree" value="<?php echo $tree; ?>">
    </form>

</div>