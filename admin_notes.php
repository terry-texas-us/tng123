<?php
include "begin.php";
include "adminlib.php";
$textpart = "notes";
include "$mylanguage/admintext.php";

include "checklogin.php";

$query = "SELECT eventtypes.eventtypeID, tag, display ";
$query .= "FROM $events_table events ";
$query .= "LEFT JOIN $eventtypes_table eventtypes ON eventtypes.eventtypeID = events.eventtypeID ";
$query .= "WHERE eventID = '$eventID'";
$eventtypes = tng_query($query);
$eventtype = tng_fetch_assoc($eventtypes);

if ($eventtype['display']) {
    $eventtypedesc = getEventDisplay($eventtype['display']);
} elseif ($eventtype['tag']) {
    $eventtypedesc = $eventtype['tag'];
} elseif ($eventID) {
    $eventtypedesc = $admtext[$eventID];
} else {
    $eventtypedesc = _('General');
}
tng_free_result($eventtypes);

$helplang = findhelp("notes_help.php");

header("Content-type:text/html; charset=" . $session_charset);

$query = "SELECT notelinks.ID AS ID, xnotes.note AS note, noteID, secret ";
$query .= "FROM ($notelinks_table notelinks, $xnotes_table xnotes) ";
$query .= "WHERE notelinks.xnoteID = xnotes.ID AND notelinks.gedcom = xnotes.gedcom AND persfamID=\"{$persfamID}\" AND notelinks.gedcom ='$tree' AND eventID = \"{$eventID}\" ";
$query .= "ORDER BY ordernum, ID";
$notelinks = tng_query($query);
$notecount = tng_num_rows($notelinks);
?>

<div class="databack ajaxwindow" id="notelist"<?php if (!$notecount) {
    echo " style='display: none;'";
} ?>>
    <form name="form1">
        <h3 class="subhead"><?php echo "" . _('Notes') . ": $eventtypedesc"; ?> |
            <a href="#" onclick="return openHelp('<?php echo $helplang; ?>/notes_help.php');"><?php echo _('Help for this area'); ?></a></h3>
        <p>
            <?php if ($allow_add) { ?>
                <input type="button" value="  <?php echo _('Add New'); ?>  " onclick="document.form2.reset();gotoSection('notelist','addnote');">&nbsp;
            <?php } ?>
            <input type="button" value="  <?php echo _('Finish'); ?>  " onclick="tnglitbox.remove();">
        </p>
        <table id="notestbl" class="fieldname normal" cellpadding="3" cellspacing="1" border="0"<?php if (!$notecount) {
            echo " style='display: none;'";
        } ?>>
            <tbody id="notestblbody">
            <tr>
                <th class="fieldnameback" width="50"><?php echo _('Sort'); ?></th>
                <th class="fieldnameback" width="80"><?php echo _('Action'); ?></th>
                <th class="fieldnameback" width="435"><?php echo _('Note'); ?></th>
            </tr>
            </tbody>
        </table>
        <div id="notes">
            <?php
            if ($notelinks && $notecount) {
                while ($note = tng_fetch_assoc($notelinks)) {
                    $citquery = "SELECT citationID FROM $citations_table WHERE gedcom = '$tree' AND ";
                    if ($note['noteID']) {
                        $citquery .= "((persfamID = '$persfamID' AND eventID = \"N{$note['ID']}\") OR persfamID = \"{$note['noteID']}\")";
                    } else {
                        $citquery .= "persfamID = '$persfamID' AND eventID = \"N{$note['ID']}\"";
                    }
                    $citresult = tng_query($citquery) or die (_('Cannot execute query') . ": $citquery");
                    $citesicon = tng_num_rows($citresult) ? "admin-cite-on-icon" : "admin-cite-off-icon";
                    tng_free_result($citresult);
                    $note['note'] = cleanIt($note['note']);
                    $truncated = truncateIt($note['note'], 75);
                    $actionstr = $allow_edit ? "<a href='#' onclick=\"return editNote({$note['ID']});\" title=\"" . _('Edit') . "\" class='smallicon admin-edit-icon'></a>" : "";
                    $actionstr .= $allow_delete ? "<a href='#' onclick=\"return deleteNote({$note['ID']},'$persfamID','$tree','$eventID');\" title=\"" . _('Delete') . "\" class='smallicon admin-delete-icon'></a>" : "";
                    $actionstr .= "<a href='#' onclick=\"return showCitationsInside('N{$note['ID']}','{$note['noteID']}', '$persfamID');\" title=\"" . _('Sources') . "\" id=\"citesiconN{$note['ID']}\" class=\"smallicon $citesicon\"></a>";
                    echo "<div class='sortrow' id=\"notes_{$note['ID']}\">";
                    echo "<table class='normal' cellpadding='3' cellspacing='1' border='0'>\n";
                    echo "<tr id=\"row_{$note['ID']}\">";
                    echo "<td class='dragarea rounded-lg'><img src='img/admArrowUp.gif' alt='' class='inline-block'><br><img src='img/admArrowDown.gif' alt='' class='inline-block'></td>";
                    echo "<td class='lightback' width='80'>$actionstr</td>";
                    echo "<td class='lightback' width='435'>$truncated</td>";
                    echo "</tr>";
                    echo "</table>\n";
                    echo "</div>\n";
                }
                tng_free_result($notelinks);
            }
            ?>
        </div>
    </form>
</div>

<div class="databack ajaxwindow"<?php if ($notecount) {
    echo " style='display: none;'";
} ?> id="addnote">
    <form action="" name="form2" onSubmit="return addNote(this);">
        <div style="float:right;text-align:center;">
            <input type="submit" name="submit" class="btn" value="<?php echo _('Save'); ?>">
            <p><a href="#" onclick="gotoSection('addnote','notelist');"><?php echo _('Cancel'); ?></a></p>
        </div>
        <h3 class="subhead"><?php echo _('Add New Note'); ?> |
            <a href="#" onclick="return openHelp('<?php echo $helplang; ?>/notes_help.php');"><?php echo _('Help for this area'); ?></a></h3>

        <table cellpadding="2" class="normal">
            <tr>
                <td class='align-top'><?php echo _('Note'); ?>:</td>
                <td><textarea cols="60" rows="25" name="note"></textarea></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <input type="checkbox" name="private" value="1"> <?php echo _('Private'); ?></td>
            </tr>
        </table>
        <br>
        <input type="hidden" name="persfamID" value="<?php echo $persfamID; ?>">
        <input type="hidden" name="tree" value="<?php echo $tree; ?>">
        <input type="hidden" name="eventID" value="<?php echo $eventID; ?>">
    </form>
</div>

<div class="databack ajaxwindow" style="display:none;" id="editnote">
</div>

<div style="display:none;" id="citationslist">
</div>