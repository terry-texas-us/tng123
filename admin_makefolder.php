<?php
include "begin.php";
include "adminlib.php";
$textpart = "setup";
include "$mylanguage/admintext.php";

header("Content-type:text/html; charset=" . $session_charset);
if ($link) {
    $admin_login = 1;
    include "checklogin.php";
    if ($assignedtree) {
        echo $admtext['norights'];
        exit;
    }
}

if (@mkdir($folder, 0777)) {
    echo $admtext['success'];
} elseif (file_exists($folder)) {
    echo $admtext['fexists'];
} else {
    echo $admtext['fmanual'];
}

