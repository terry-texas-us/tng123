<?php
include "begin.php";
include "adminlib.php";
$textpart = "branches";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
if (!$allow_media_add) {
    $message = $admtext['norights'];
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
adminwritelog($admtext['addnewalbum'] . ": $albumname");
header("Location: admin_editalbum.php?albumID=$albumID&added=1");
