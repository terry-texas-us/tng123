<?php
include "begin.php";
include "adminlib.php";

header("Content-type:text/html; charset=" . $session_charset);
if ($link) {
    $admin_login = 1;
    include "checklogin.php";
    if ($assignedtree) {
        echo _('You are not authorized to view this page. If you have a username and password, please login below.');
        exit;
    }
}

if (@mkdir($folder, 0777)) {
    echo _('Success');
} elseif (file_exists($folder)) {
    echo _('Failed. Folder already exists.');
} else {
    echo _('Failed. Please create using an FTP program or online file manager.');
}

