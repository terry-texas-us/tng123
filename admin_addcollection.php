<?php
include "begin.php";
include "adminlib.php";

include "checklogin.php";
if (!$allow_add) exit;

require "adminlog.php";

$display_org = stripslashes($display);

if ($session_charset != "UTF-8") {
    $display = tng_utf8_decode($display);
}

$stdcolls = ["photos", "histories", "headstones", "documents", "recordings", "videos"];
$collid = cleanID($collid);
$newcollid = 0;
if (!in_array($collid, $stdcolls)) {
    $template = "sssssssss";
    $query = "INSERT IGNORE INTO $mediatypes_table (mediatypeID,display,path,liketype,icon,thumb,exportas,ordernum,localpath) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $params = [&$template, &$collid, &$display, &$path, &$liketype, &$icon, &$thumb, &$exportas, &$ordernum, &$localpath];
    $affected_rows = tng_execute($query, $params);

    if ($affected_rows > 0) {
        adminwritelog(_('Add Collection') . ": $display_org");
        $newcollid = $collid;
    }
}
echo $newcollid;
