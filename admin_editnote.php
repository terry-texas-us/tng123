<?php
include "begin.php";
include "adminlib.php";
$textpart = "notes";
include "$mylanguage/admintext.php";

include "checklogin.php";

$query = "SELECT xnotes.note AS note, xnotes.ID AS xID, secret, notelinks.gedcom AS gedcom, persfamID, eventID ";
$query .= "FROM $notelinks_table notelinks, $xnotes_table xnotes ";
$query .= "WHERE notelinks.xnoteID = xnotes.ID AND notelinks.gedcom = xnotes.gedcom AND notelinks.ID = \"{$noteID}\"";
$result = tng_query($query);
$row = tng_fetch_assoc($result);
tng_free_result($result);

$row['note'] = str_replace("&", "&amp;", $row['note']);
$row['note'] = preg_replace("/\"/", "&#34;", $row['note']);

$helplang = findhelp("notes_help.php");
header("Content-type:text/html; charset=" . $session_charset);
?>
<form action="" name="form3" onSubmit="return updateNote(this);">
    <div style="float:right;text-align:center;">
        <input type="submit" name="submit" class="btn" value="<?php echo $admtext['save']; ?>">
        <p><a href="#" onclick="gotoSection('editnote','notelist');"><?php echo $text['cancel']; ?></a></p>
    </div>
    <h3 class="subhead"><?php echo $admtext['modifynote']; ?> |
        <a href="#" onclick="return openHelp('<?php echo $helplang; ?>/notes_help.php');"><?php echo $admtext['help']; ?></a></h3>

    <table cellpadding="2" class="normal">
        <tr>
            <td class='align-top'><?php echo $admtext['note']; ?>:</td>
            <td><textarea cols="60" rows="25" name="note"><?php echo $row['note']; ?></textarea></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>
                <?php
                echo "<input type=\"checkbox\" name=\"private\" value='1'";
                if ($row['secret']) {
                    echo " checked";
                }
                echo "> " . $admtext['text_private'];
                ?>
            </td>
        </tr>
    </table>
    <br>
    <input type="hidden" name="xID" value="<?php echo $row['xID']; ?>">
    <input type="hidden" name="ID" value="<?php echo $noteID; ?>">
    <input type="hidden" name="tree" value="<?php echo $row['gedcom']; ?>">
    <input type="hidden" name="persfamID" value="<?php echo $row['persfamID']; ?>">
    <input type="hidden" name="eventID" value="<?php echo $row['eventID']; ?>">
</form>
