<?php
include "begin.php";
include "adminlib.php";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
if (!$allow_delete) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

$deleted = false;
if (file_exists($filename)) $deleted = unlink($filename);

echo $deleted ? _('Deleted') . "&nbsp;<img src=\"img/tng_check.gif\">" : _('File could not be deleted. Please check file permissions.');

