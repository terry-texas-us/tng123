<?php
include "begin.php";
include "adminlib.php";
$textpart = "photos";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
if ($type == "album") {
    $query = "SELECT eventID, linktype, entityID, gedcom
		FROM $album2entities_table
		WHERE alinkID = \"$linkID\"";
} else {
    $query = "SELECT eventID, altdescription, altnotes, defphoto, linktype, personID, gedcom, dontshow
		FROM $medialinks_table
		WHERE medialinkID = \"$linkID\"";
}
$result = tng_query($query);
$row = tng_fetch_assoc($result);
tng_free_result($result);
$meventID = $row['eventID'];
$entityID = $type == "album" ? $row['entityID'] : $row['personID'];

$ldsOK = determineLDSRights();

/**
 * @param $eventID
 * @param $displayval
 * @param $info
 * @return string
 */
function doEvent($eventID, $displayval, $info) {
    global $meventID;
    return "<option value=\"$eventID\"" . ($eventID == $meventID ? " selected" : "") . ">$displayval" . ($info ? ": $info" : "") . "</option>\n";
}

$options = "<option value=\"\">{$text['none']}</option>";
if ($row['linktype'] == "I") {
    //standard people events
    $list = ["NAME", "BIRT", "CHR", "DEAT", "BURI"];
    foreach ($list as $eventtype)
        $options .= doEvent($eventtype, $admtext[$eventtype], '');
    if ($ldsOK) {
        $ldslist = ["BAPL", "CONL", "INIT", "ENDL", "SLGC"];
        foreach ($ldslist as $eventtype)
            $options .= doEvent($eventtype, $admtext[$eventtype], '');
    }
} elseif ($row['linktype'] == "F") {
    //standard family events
    $list = ["MARR", "DIV"];
    foreach ($list as $eventtype)
        $options .= doEvent($eventtype, $admtext[$eventtype], '');
    if ($ldsOK) {
        $ldslist = ["SLGS"];
        foreach ($ldslist as $eventtype)
            $options .= doEvent($eventtype, $admtext[$eventtype], '');
    }
}

//now call up custom events linked to passed in entity
$query = "SELECT display, eventdate, eventplace, info, eventID ";
$query .= "FROM $events_table events, $eventtypes_table eventtypes ";
$query .= "WHERE persfamID = \"{$entityID}\" AND events.eventtypeID = eventtypes.eventtypeID AND gedcom = \"{$row['gedcom']}\" AND keep = '1' AND parenttag = \"\" ";
$query .= "ORDER BY ordernum, tag, description, eventdatetr, info, eventID";
$custevents = tng_query($query);
while ($custevent = tng_fetch_assoc($custevents)) {
    $displayval = getEventDisplay($custevent['display']);
    $info = "";
    if ($custevent['eventdate']) {
        $info = displayDate($custevent['eventdate']);
    } elseif ($custevent['eventplace']) {
        $info = truncateIt($custevent['eventplace'], 20);
    } elseif ($custevent['info']) {
        $info = truncateIt($custevent['info'], 20);
    }
    $options .= doEvent($custevent['eventID'], $displayval, $info);
}
tng_free_result($custevents);

header("Content-type:text/html; charset=" . $session_charset);
?>

<div class="databack ajaxwindow">
    <h3 class="subhead"><?php echo $headline; ?></h3>
    <form action="" method="post" name="editlinkform" id="editlinkform" onsubmit="return updateMedia2EntityLink(this);">
        <table cellpadding="2" class="normal">
            <tr>
                <td class='align-top'><?php echo $admtext['event']; ?>:</td>
                <td>
                    <select name="eventID" id="eventID">
                        <?php echo $options; ?>
                    </select>
                </td>
            </tr>
            <?php if ($type != "album") { ?>
                <tr>
                    <td class='align-top'><?php echo $admtext['alttitle']; ?>:</td>
                    <td><textarea name="altdescription" rows="3" cols="40"><?php echo $row['altdescription']; ?></textarea></td>
                </tr>
                <tr>
                    <td class='align-top'><?php echo $admtext['altdesc']; ?>:</td>
                    <td><textarea name="altnotes" rows="4" cols="40"><?php echo $row['altnotes']; ?></textarea></td>
                </tr>
                <tr>
                    <td class="align-top" colspan="2">
                        <?php if ($row['linktype'] != "C") { ?>
                            <input type="checkbox" name="defphoto" value="1"<?php if ($row['defphoto']) {
                                echo " checked";
                            } ?>> <?php echo $admtext['makedefault']; ?>*
                        <?php } ?>
                        <input type="checkbox" name="show" value="1"<?php if (!$row['dontshow']) {
                            echo " checked";
                        } ?>> <?php echo $admtext['show']; ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <br>
        <?php if ($type != "album") { ?>
            <input type="hidden" name="personID" value="<?php echo $entityID; ?>">
            <input type="hidden" name="tree" value="<?php echo $row['gedcom']; ?>">
        <?php } ?>
        <input type="hidden" name="linkID" value="<?php echo $linkID; ?>">
        <input type="hidden" name="type" value="<?php echo $type; ?>">
        <input type="submit" name="submit" value="<?php echo $admtext['save']; ?>">
        <input type="button" name="cancel" value="<?php echo $text['cancel']; ?>" onclick="tnglitbox.remove();">
        <p class="normal">
            <?php
            if ($type != "album") {
                echo "*{$admtext['defphotonote']}\n";
            }
            ?>
        </p>
    </form>
</div>