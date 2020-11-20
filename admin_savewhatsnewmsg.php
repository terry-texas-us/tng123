<?php
include "begin.php";
include "adminlib.php";

$admin_login = 1;
include "checklogin.php";
if ($assignedtree) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    $color = "red";
} else {
    $whatsnewmsg = stripslashes($whatsnewmsg);

    $file = "$rootpath/whatsnew.txt";
    //write to file
    $fp = @fopen($file, "w");
    if (!$fp) die (_('Cannot open file') . " $file");


    flock($fp, LOCK_EX);
    fwrite($fp, $whatsnewmsg);
    flock($fp, LOCK_UN);
    fclose($fp);
    $message = _('Message saved');
    $color = "msgapproved";
}

header("Location: admin_whatsnewmsg.php?color=$color&message=" . urlencode($message));
