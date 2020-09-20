<?php
include "begin.php";
include "adminlib.php";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
if (!$allow_delete) {
    $message = $admtext['norights'];
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

$deleted = false;
if (file_exists($filename)) {
    $deleted = unlink($filename);
}

echo $deleted ? $admtext['deleted'] . "&nbsp;<img src=\"img/tng_check.gif\">" : $admtext['notdeleted'];

