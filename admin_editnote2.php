<?php
include "begin.php";
include "adminlib.php";
$textpart = "notes";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
$query = "SELECT xnotes.note AS note, secret, notelinks.gedcom AS gedcom, notelinks.ID AS nID ";
$query .= "FROM ($notelinks_table notelinks, $xnotes_table xnotes) ";
$query .= "WHERE notelinks.xnoteID = xnotes.ID AND notelinks.gedcom = xnotes.gedcom AND xnotes.ID = \"{$ID}\"";
$result = tng_query($query);
$row = tng_fetch_assoc($result);
tng_free_result($result);

if (!$allow_edit || ($assignedtree && $assignedtree != $row['gedcom'])) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

$row['note'] = str_replace("&", "&amp;", $row['note']);
$row['note'] = preg_replace("/\"/", "&#34;", $row['note']);

$helplang = findhelp("misc_help.php");

tng_adminheader(_('Modify Note'), $flags);
?>
<script>
    function validateForm(form) {
        let rval = true;
        if (form.note.value.length == 0) {
            alert("<?php echo _('Please enter the note text.'); ?>");
            rval = false;
        }
        return rval;
    }
</script>

<?php
echo "</head>\n";
echo tng_adminlayout();

$misctabs[0] = [1, "admin_notelist.php", _('Notes'), "notes"];
$misctabs[1] = [$allow_edit, "#", _('Edit'), "edit"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/notes2_help.php#add');\" class='lightlink'>" . _('Help for this area') . "</a>";
$menu = doMenu($misctabs, "edit", $innermenu);
echo displayHeadline(_('Modify Note'), "img/misc_icon.gif", $menu, $message);
?>

<table class="lightback">
    <tr class="databack">
        <td class="tngshadow">
            <form action="admin_updatenote2.php" name="form2" method="post" onSubmit="return validateForm(this);">
                <table cellpadding="2" class="normal">
                    <tr>
                        <td class='align-top'><?php echo _('Note'); ?>:</td>
                        <td><textarea cols="80" rows="30" name="note"><?php echo $row['note']; ?></textarea></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>
                            <?php
                            echo "<input type='checkbox' name=\"private\" value='1'";
                            if ($row['secret']) echo " checked";

                            echo "> " . _('Private');
                            ?>
                        </td>
                    </tr>
                </table>
                <br>
                <input type="hidden" name="ID" value="<?php echo $row['nID']; ?>">
                <input type="hidden" name="xID" value="<?php echo $ID; ?>">
                <input type="hidden" name="gedcom" value="<?php echo $row['gedcom']; ?>">
                <input type="submit" name="submit" value="<?php echo _('Save'); ?>">
                <input type="button" name="cancel" value="<?php echo _('Cancel'); ?>"
                    onClick="window.location.href='admin_notelist.php';">
            </form>
        </td>
    </tr>

</table>
<?php echo tng_adminfooter(); ?>
