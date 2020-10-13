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
    $message = $admtext['norights'];
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

$badtables = "";
$collation = "";
include "tabledefs.php";

if (!$badtables) {
    adminwritelog($admtext['createtables']);
}

tng_adminheader($admtext['tablecreation'], $flags);

echo "</head>\n";
echo tng_adminlayout();

$setuptabs[0] = [1, "admin_setup.php", $admtext['configuration'], "configuration"];
$setuptabs[1] = [1, "admin_setup.php?sub=diagnostics", $admtext['diagnostics'], "diagnostics"];
$setuptabs[2] = [1, "admin_setup.php?sub=tablecreation", $admtext['tablecreation'], "tablecreation"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/setup_help.php#tables');\" class='lightlink'>{$admtext['help']}</a>";
$menu = doMenu($setuptabs, "tablecreation", $innermenu);
echo displayHeadline($admtext['setup'] . " &gt;&gt; " . $admtext['tablecreation'], "img/setup_icon.gif", $menu, $message);
?>

<table class="lightback">
    <tr class="databack">
        <td class="tngshadow"><span class="normal"><p>
<?php
if ($badtables) {
    echo "Tables not created: $badtables";
} else {
    echo $admtext['tablesuccess'];
}
?>
</p>
			<p><a href="admin_setup.php"><?php echo $admtext['backtosetup']; ?></a>.</p></span>
        </td>
    </tr>
</table>
<?php echo tng_adminfooter(); ?>