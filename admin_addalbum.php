<?php
include "begin.php";
include "adminlib.php";

$admin_login = 1;
include "checklogin.php";
if (!$allow_media_add) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}
require "adminlog.php";
if (!$alwayson) $alwayson = 0;
$template = "sssss";
$query = "INSERT INTO $albums_table (albumname,description,keywords,active,alwayson) VALUES (?, ?, ?, ?, ?)";
$params = [&$template, &$albumname, &$description, &$keywords, &$active, &$alwayson];
tng_execute($query, $params);
$albumID = tng_insert_id();
adminwritelog(_('Add New Album') . ": $albumname");
header("Location: admin_editalbum.php?albumID=$albumID&added=1");
