<?php
include "begin.php";
include "adminlib.php";
$textpart = "setup";
include "$mylanguage/admintext.php";

if (!count($_POST)) {
    header("Location: admin_main.php");
    exit;
}

if ($link) {
    $admin_login = 1;
    include "checklogin.php";
    include "version.php";

    if ($assignedtree || !$allow_edit) {
        $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
        header("Location: admin_login.php?message=" . urlencode($message));
        exit;
    }
}

require "adminlog.php";

$fp = @fopen("config/logconfig.php", "w", 1);
if (!$fp) die (_('Cannot open file') . " logconfig.php");


flock($fp, LOCK_EX);

fwrite($fp, "<?php\n");
fwrite($fp, "\$logname = \"$logname\";\n");
fwrite($fp, "\$logfile = \$rootpath . \$logname;\n");
fwrite($fp, "\$maxloglines = \"$maxloglines\";\n");
fwrite($fp, "\$badhosts = \"$badhosts\";\n");
fwrite($fp, "\$exusers = \"$exusers\";\n");
fwrite($fp, "\$adminlogfile = \"$adminlogfile\";\n");
fwrite($fp, "\$adminmaxloglines = \"$adminmaxloglines\";\n");
fwrite($fp, "\$addr_exclude = \"$addr_exclude\";\n");
fwrite($fp, "\$msg_exclude = \"$msg_exclude\";\n");
fwrite($fp, "?>\n");

flock($fp, LOCK_UN);
fclose($fp);

$fp = fopen($rootpath . $logname, "c");
if (!$fp) die ("" . _('Cannot open file') . " $logname");

fclose($fp);

$fp = fopen($rootpath . $adminlogfile, "c");
if (!$fp) die ("" . _('Cannot open file') . " $adminlogfile");

fclose($fp);

adminwritelog(_('Modify Log Configuration Settings'));

header("Location: admin_setup.php");

