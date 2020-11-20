<?php
include "begin.php";
include "adminlib.php";

$admin_login = 1;
include "checklogin.php";
if (!$allow_media_delete) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

require "adminlog.php";

$query = "DELETE FROM $albums_table WHERE albumID=\"$albumID\"";
$result = tng_query($query);

$query = "DELETE FROM $albumlinks_table WHERE albumID=\"$albumID\"";
$result = tng_query($query);

// TODO text ['album'] was not defined in any language. Manually added here.
adminwritelog(_('Deleted') . ": " . _todo_('Album') . " $albumID");
$message = _todo_('Album') . " $albumID " . _('was successfully deleted') . ".";

header("Location: admin_albums.php?message=" . urlencode($message));

