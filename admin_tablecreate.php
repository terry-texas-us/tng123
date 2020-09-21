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

$flags['tabs'] = $tngconfig['tabs'];
tng_adminheader($admtext['tablecreation'], $flags);
?>
</head>

<body class="admin-body">

<?php
$setuptabs[0] = array(1, "admin_setup.php", $admtext['configuration'], "configuration");
$setuptabs[1] = array(1, "admin_setup.php?sub=diagnostics", $admtext['diagnostics'], "diagnostics");
$setuptabs[2] = array(1, "admin_setup.php?sub=tablecreation", $admtext['tablecreation'], "tablecreation");
$innermenu = "<a href=\"#\" onclick=\"return openHelp('$helplang/setup_help.php#tables');\" class=\"lightlink\">{$admtext['help']}</a>";
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
<?php echo "<div style=\"text-align: center;\"><span class='normal'>$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>