<?php
include "begin.php";
include "adminlib.php";
$textpart = "photos";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
if (!$allow_media_add) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

$helplang = findhelp("albums_help.php");

tng_adminheader(_('Add New Album'), $flags);
?>
    <script>
        function validateForm() {
            let rval = true;
            if (document.form1.albumname.value.length == 0) {
                alert("<?php echo _('Please enter an album name.'); ?>");
                rval = false;
            }
            return rval;
        }
    </script>

<?php
echo "</head>\n";
echo tng_adminlayout();

$albumtabs[0] = [1, "admin_albums.php", _('Search'), "findalbum"];
$albumtabs[1] = [$allow_add, "admin_newalbum.php", _('Add New'), "addalbum"];
$albumtabs[2] = [$allow_edit, "admin_orderalbumform.php", _('Sort'), "sortalbums"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/albums_help.php#add');\" class='lightlink'>" . _('Help for this area') . "</a>";
$menu = doMenu($albumtabs, "addalbum", $innermenu);
echo displayHeadline(_('Albums') . " &gt;&gt; " . _('Add New Album'), "img/albums_icon.gif", $menu, $message);
?>

    <form action="admin_addalbum.php" method="post" name="form1" onSubmit="return validateForm();">
        <table class="lightback">
            <tr class="databack">
                <td class="tngshadow">
                    <?php echo displayToggle("plus0", 1, "details", _('Album Information'), _('Edit album name, description and keywords')); ?>

                    <div id="details" class="topbuffer">
                        <table class="normal">
                            <tr>
                                <td><?php echo _('Album Name'); ?>:</td>
                                <td>
                                    <input type="text" name="albumname" size="50">
                                </td>
                            </tr>
                            <tr>
                                <td class='align-top'><?php echo _('Description'); ?>:</td>
                                <td><textarea cols="60" rows="3" name="description"></textarea></td>
                            </tr>
                            <tr>
                                <td class='align-top'><?php echo _('Keywords'); ?>:</td>
                                <td><textarea cols="60" rows="3" name="keywords"></textarea></td>
                            </tr>
                            <tr>
                                <td><?php echo _('Active'); ?>:</td>
                                <td>
                                    <input type="radio" name="active" value="1" checked="checked"> <?php echo _('Yes'); ?> &nbsp;
                                    <input type="radio" name="active" value="0"> <?php echo _('No'); ?></td>
                            </tr>
                            <tr>
                                <td class="align-top" colspan="2">
                                    <input type="checkbox" name="alwayson" value="1"> <?php echo _('Always viewable'); ?></td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
            <tr class="databack">
                <td class="tngshadow">
                    <p class="normal"><strong><?php echo _('Note: Media may be added to this album, and the album linked to individuals or families, on the next screen.'); ?></strong></p>
                    <input type="submit" name="saveit" accesskey="a" class="btn" value="<?php echo _('Save and continue...'); ?>">
                </td>
            </tr>
        </table>
    </form>

<?php echo tng_adminfooter(); ?>