<?php
include "begin.php";
include "adminlib.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";

if ($assignedtree) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

$file = "$rootpath/whatsnew.txt";

$contents = @file($file);

$helplang = findhelp("misc_help.php");

tng_adminheader(_('What\'s New'), $flags);
?>
    <script>
        //<![CDATA[
        <?php include "niceditmsgs.php"; ?>
        //]]>
    </script>

<?php
echo "</head>\n";
echo tng_adminlayout();

$misctabs[0] = [1, "admin_misc.php", _('Menu'), "misc"];
$misctabs[1] = [1, "admin_whatsnewmsg.php", _('What\'s New'), "whatsnew"];
$misctabs[2] = [1, "admin_mostwanted.php", _('Most Wanted'), "mostwanted"];
$misctabs[3] = [1, "admin_data_validation.php", _('Data Validation'), "validation"];
$innermenu = "<a class='lightlink' href='#' onclick=\"return openHelp('$helplang/misc_help.php#add');\">" . _('Help for this area') . "</a>";
$innermenu .= " &nbsp;|&nbsp; <a class='lightlink' href='whatsnew.php' target='_blank'>" . _('Test') . "</a>";
$menu = doMenu($misctabs, "whatsnew", $innermenu);
echo displayHeadline(_('Miscellaneous') . " &gt;&gt; " . _('What\'s New'), "img/misc_icon.gif", $menu, "");
?>

    <table class="lightback">
        <tr class="databack">
            <td class="tngshadow">
                <form action="admin_savewhatsnewmsg.php" method="post" name="form1">
                    <h3 class="subhead"><?php echo _('Message on \"What\'s New\" Page'); ?>:</h3>
                    <p class="normal" id="savedmsg" style="<?php echo($color ? "color:$color;" : "display:none;") ?>"><em><?php echo $message; ?></em></p>
                    <textarea cols="150" rows="20" name="whatsnewmsg" id="whatsnewmsg">
                    <?php if (is_array($contents)) {
                        foreach ($contents as $line) {
                            echo $line;
                        }
                    } ?>
                </textarea><br>
                    <input type="submit" name="submit" accesskey="s" class="btn" value="<?php echo _('Save'); ?>">
                </form>
            </td>
        </tr>
    </table>

    <script src="js/nicedit.js"></script>
    <script>
        //<![CDATA[
        bkLib.onDomLoaded(function () {
            new nicEditor({fullPanel: true}).panelInstance('whatsnewmsg');
    });
    //]]>
</script>

<?php echo tng_adminfooter(); ?>