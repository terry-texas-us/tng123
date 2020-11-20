<?php
include "begin.php";
include "adminlib.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";

if (!$allow_media_edit) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

$helplang = findhelp("media_help.php");

tng_adminheader(_('Sort xxx for'), $flags);
?>
<script src="js/mediautils.js"></script>
<script>
    function toggleAll(display) {
        toggleSection('thumbs', 'plus1', display);
        toggleSection('defaults', 'plus2', display);
        return false;
    }
</script>

<?php
echo "</head>\n";
echo tng_adminlayout();

$mediatabs[0] = [1, "admin_media.php", _('Search'), "findmedia"];
$mediatabs[1] = [$allow_add, "admin_newmedia.php", _('Add New'), "addmedia"];
$mediatabs[2] = [$allow_edit, "admin_ordermediaform.php", _('Sort'), "sortmedia"];
$mediatabs[3] = [$allow_edit && !$assignedtree, "admin_thumbnails.php", _('Thumbnails'), "thumbs"];
$mediatabs[4] = [$allow_media_add, "admin_photoimport.php", _('Import'), "import"];
$mediatabs[5] = [$allow_media_add && !$assignedtree, "admin_mediaupload.php", _('Upload'), "upload"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/media_help.php#thumbs');\" class='lightlink'>" . _('Help for this area') . "</a>";
$innermenu .= " &nbsp;|&nbsp; <a href='#' class='lightlink' onClick=\"return toggleAll('on');\">" . _('Expand all') . "</a> &nbsp;|&nbsp; <a href='#' class='lightlink' onClick=\"return toggleAll('off');\">" . _('Collapse all') . "</a>";
$menu = doMenu($mediatabs, "thumbs", $innermenu);
echo displayHeadline(_('Media') . " &gt;&gt; " . _('Thumbnails'), "img/photos_icon.gif", $menu, $message);
?>

<table class="lightback">
    <?php
    if (!$assignedtree) {
        if (function_exists('imageJpeg')) {
            ?>
            <tr class="databack">
                <td class="tngshadow normal">
                    <?php echo displayToggle("plus1", 1, "thumbs", _('Generate Thumbnails'), _('Automatically generate smaller versions of all photos without existing thumbnails.')); ?>

                    <div id="thumbs">
                        <br>
                        <form action="admin_generatethumbs.php" method="post" onsubmit="return generateThumbs(this);">
                            <input type="checkbox" name="regenerate" value="1"> <?php echo _('Regenerate existing thumbnails'); ?><br>
                            <input type="checkbox" name="repath" value="1"> <?php echo _('Regenerate thumbnail path names where file does not exist'); ?><br><br>
                            <input type="submit" name="submit" class="btn" value="<?php echo _('Generate'); ?>">
                            <img src="img/spinner.gif" id="thumbspin" style="display:none;">
                            </span>
                        </form>

                        <div id="thumbresults" style="display:none;">
                        </div>

                    </div>
                </td>
            </tr>
        <?php } ?>

        <tr class="databack">
            <td class="tngshadow normal">
                <?php echo displayToggle("plus2", 1, "defaults", _('Assign Default Photos'), _('Make first photo for each individual, family and source be that entity\'s default photo.')); ?>

                <div id="defaults">
                    <br>
                    <form action="defphotos.php" method="post" onsubmit="return assignDefaults(this);">
                        <input type="checkbox" name="overwritedefs" value="1"> <?php echo _('Overwrite existing defaults'); ?><br><br>
                        <?php echo _('Tree'); ?>: <select name="tree">
                            <?php
                            $query = "SELECT gedcom, treename FROM $trees_table ORDER BY treename";
                            $result = tng_query($query);
                            while ($row = tng_fetch_assoc($result)) {
                                echo "	<option value=\"{$row['gedcom']}\">{$row['treename']}</option>\n";
                            }
                            ?>
                        </select><br><br>
                        <input type="submit" name="submit" class="btn" value="<?php echo _('Assign Defaults'); ?>">
                        <img src="img/spinner.gif" id="defspin" style="display:none;">
                        </span>
                    </form>

                    <div id="defresults" style="display:none;">
                    </div>

                </div>
            </td>
        </tr>
    <?php } ?>
</table>
<?php echo tng_adminfooter(); ?>
