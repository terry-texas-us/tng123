<?php
include "begin.php";
include "adminlib.php";
$textpart = "events";
include "$mylanguage/admintext.php";

include $cms['tngpath'] . "checklogin.php";

$query = "SELECT eventID, age, agency, cause, $events_table.addressID, address1, address2, city, state, zip, country, info, phone, email, www FROM $events_table LEFT JOIN $address_table on $events_table.addressID = $address_table.addressID WHERE parenttag = \"$eventID\" AND $events_table.persfamID = \"$persfamID\" AND $events_table.gedcom = \"$tree\"";
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

if ($session_charset != "UTF-8") {
}

$helplang = findhelp("more_help.php");

header("Content-type:text/html; charset=" . $session_charset);
?>

<div class="databack ajaxwindow" id="more">
    <form action="" name="editmoreform" onsubmit="return updateMore(this);">
        <div style="float:right"><input type="submit" name="submit" class="btn" value="<?php echo $admtext['save']; ?>"></div>
        <p class="subhead"><strong><?php echo "{$admtext['moreinfo']}: $admtext[$eventID]"; ?></strong> |
            <a href="#" onclick="return openHelp('<?php echo $helplang; ?>/more_help.php');"><?php echo $admtext['help']; ?></a></p>
      <table cellpadding="2">
        <tr>
          <td valign="top"><span class="normal"><?php echo $admtext['age']; ?>:</span></td>
                <td><input type="text" name="age" size="12" maxlength="12" value="<?php echo $row['age']; ?>"></td>
            </tr>
            <tr>
                <td valign="top"><span class="normal"><?php echo $admtext['agency']; ?>:</span></td>
                <td><input type="text" name="agency" size="50" value="<?php echo $row['agency']; ?>"></td>
            </tr>
            <tr>
                <td valign="top"><span class="normal"><?php echo $admtext['cause']; ?>:</span></td>
                <td><input type="text" name="cause" size="50" value="<?php echo $row['cause']; ?>"></td>
            </tr>
            <tr>
                <td valign="top" colspan="2"><span class="normal"><strong><?php echo $admtext['address']; ?></strong></span></td>
            </tr>
            <tr>
                <td valign="top"><span class="normal"><?php echo $admtext['address1']; ?>:</span></td>
                <td><input type="text" name="address1" size="50" value="<?php echo $row['address1']; ?>"></td>
            </tr>
            <tr>
                <td valign="top"><span class="normal"><?php echo $admtext['address2']; ?>:</span></td>
                <td><input type="text" name="address2" size="50" value="<?php echo $row['address2']; ?>"></td>
            </tr>
            <tr>
                <td valign="top"><span class="normal"><?php echo $admtext['city']; ?>:</span></td>
                <td><input type="text" name="city" size="50" value="<?php echo $row['city']; ?>"></td>
            </tr>
            <tr>
                <td valign="top"><span class="normal"><?php echo $admtext['stateprov']; ?>:</span></td>
                <td><input type="text" name="state" size="50" value="<?php echo $row['state']; ?>"></td>
            </tr>
            <tr>
                <td valign="top"><span class="normal"><?php echo $admtext['zip']; ?>:</span></td>
                <td><input type="text" name="zip" size="20" value="<?php echo $row['zip']; ?>"></td>
            </tr>
            <tr>
                <td valign="top"><span class="normal"><?php echo $admtext['countryaddr']; ?>:</span></td>
                <td><input type="text" name="country" size="50" value="<?php echo $row['country']; ?>"></td>
            </tr>
            <tr>
                <td valign="top"><span class="normal"><?php echo $admtext['phone']; ?>:</span></td>
                <td><input type="text" name="phone" size="30" value="<?php echo $row['phone']; ?>"></td>
            </tr>
            <tr>
                <td valign="top"><span class="normal"><?php echo $admtext['email']; ?>:</span></td>
                <td><input type="text" name="email" size="50" value="<?php echo $row['email']; ?>"></td>
            </tr>
            <tr>
                <td valign="top"><span class="normal"><?php echo $admtext['website']; ?>:</span></td>
                <td><input type="text" name="www" size="50" value="<?php echo $row['www']; ?>"></td>
            </tr>
        </table>
        <input type="hidden" name="eventtypeID" value="<?php echo $eventID; ?>">
        <input type="hidden" name="addressID" value="<?php echo $row['addressID']; ?>">
        <input type="hidden" name="eventID" value="<?php echo $row['eventID']; ?>">
        <input type="hidden" name="persfamID" value="<?php echo $persfamID; ?>">
        <input type="hidden" name="tree" value="<?php echo $tree; ?>">
    </form>

</div>