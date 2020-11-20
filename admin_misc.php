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

$helplang = findhelp("misc_help.php");

tng_adminheader(_('Miscellaneous'), $flags);

echo "</head>\n";
echo tng_adminlayout();

$misctabs[0] = [1, "admin_misc.php", _('Menu'), "misc"];
$misctabs[1] = [1, "admin_whatsnewmsg.php", _('What\'s New'), "whatsnew"];
$misctabs[2] = [1, "admin_mostwanted.php", _('Most Wanted'), "mostwanted"];
$misctabs[3] = [1, "admin_data_validation.php", _('Data Validation'), "validation"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/misc_help.php');\" class='lightlink'>" . _('Help for this area') . "</a>";
$menu = doMenu($misctabs, "misc", $innermenu);
echo displayHeadline(_('Miscellaneous'), "img/misc_icon.gif", $menu, $message);
?>
    <table class="lightback">
        <tr class="databack">
            <td class="tngshadow">
                <h3 class="subhead"><a href="admin_whatsnewmsg.php"><img src="img/tng_expand.gif" class="inline-block"><?php echo _('What\'s New'); ?></a></h3>
                <p class="normal miscmenu"><?php echo _('Provide your visitors with a general site update or other timely information at the top of your What\'s New page.'); ?></p>
                <hr>
                <h3 class="subhead"><a href="admin_mostwanted.php"><img src="img/tng_expand.gif" class="inline-block"><?php echo _('Most Wanted'); ?></a></h3>
                <p class="normal miscmenu"><?php echo _('Create a list of elusive people and unidentified photos, in hopes of getting more publicity for the items that are giving you the most trouble.'); ?></p>
                <hr>
                <h3 class="subhead"><a href="admin_data_validation.php"><img src="img/tng_expand.gif" class="inline-block"><?php echo _('Data Validation'); ?></a></h3>
                <p class="normal miscmenu"><?php echo _('Find potential problems in your information.'); ?></p>
                <hr>
            </td>
        </tr>
    </table>
    </div>
<?php echo tng_adminfooter(); ?>