<?php
include "begin.php";
include "adminlib.php";
$textpart = "setup";
include "$mylanguage/admintext.php";

if ($link) {
    $admin_login = 1;
    include "checklogin.php";
    include "version.php";
}

require "adminlog.php";

if ($assignedtree) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

$badtables = "";
$collation = "";
include "tabledefs.php";

if (!$badtables) adminwritelog(_('Create Tables'));

tng_adminheader(_('Table Creation'), $flags);

echo "</head>\n";
echo tng_adminlayout();

$setuptabs[0] = [1, "admin_setup.php", _('Configuration'), "configuration"];
$setuptabs[1] = [1, "admin_setup.php?sub=diagnostics", _('Diagnostics'), "diagnostics"];
$setuptabs[2] = [1, "admin_setup.php?sub=tablecreation", _('Table Creation'), "tablecreation"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/setup_help.php#tables');\" class='lightlink'>" . _('Help for this area') . "</a>";
$menu = doMenu($setuptabs, "tablecreation", $innermenu);
echo displayHeadline(_('Setup') . " &gt;&gt; " . _('Table Creation'), "img/setup_icon.gif", $menu, $message);
?>
    <table class="lightback">
        <tr class="databack">
            <td class="tngshadow"><span class="normal">
            <p>
            <?php
            if ($badtables) {
                echo "Tables not created: $badtables";
            } else {
                echo _('Tables created successfully.');
            }
            ?>
            </p>
			<p><a href="admin_setup.php"><?php echo _('Back to the Setup Menu'); ?></a>.</p></span>
            </td>
        </tr>
    </table>
<?php echo tng_adminfooter(); ?>