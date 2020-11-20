<?php
include "begin.php";
include "adminlib.php";

if ($link) {
    $admin_login = 1;
    include "checklogin.php";
    if ($assignedtree) {
        $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
        header("Location: admin_login.php?message=" . urlencode($message));
        exit;
    }
}

echo phpinfo();
