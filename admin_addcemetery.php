<?php
include "begin.php";
include "adminlib.php";
$textpart = "cemeteries";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
if (!$allow_add) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

require "adminlog.php";

if ($newfile && $newfile != "none") {
    if (substr($maplink, 0, 1) == "/") $maplink = substr($maplink, 1);

    $newpath = "$rootpath$headstonepath/$maplink";

    if (@move_uploaded_file($newfile, $newpath)) {
        @chmod($newpath, 0644);
    } else {
        $message = _('The map image file could not be copied to') . " $newpath " . _('because the folder does not exist (check the Root Path) or does not have proper permissions (try chmod(777)).') . ".";
        header("Location: admin_cemeteries.php?message=" . urlencode($message));
        exit;
    }
}

$latitude = preg_replace("/,/", ".", $latitude);
$longitude = preg_replace("/,/", ".", $longitude);
if ($latitude && $longitude && !$zoom) $zoom = 13;

if (!$zoom) $zoom = 0;

$template = "sssssssssss";
$query = "INSERT INTO $cemeteries_table (cemname,maplink,city,county,state,country,latitude,longitude,zoom,notes,place) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$params = [&$template, &$cemname, &$maplink, &$city, &$county, &$state, &$country, &$latitude, &$longitude, &$zoom, &$notes, &$place];
tng_execute($query, $params);
$cemeteryID = tng_insert_id();

$tree = $assignedtree;
if (!$tree) {
    $query = "SELECT gedcom FROM $trees_table LIMIT 2";
    $result2 = tng_query($query);
    if (tng_num_rows($result2) == 1) {
        $row = tng_fetch_assoc($result2);
        $tree = $row['gedcom'];
    }
    tng_free_result($result2);
}

$place = trim($place);
if ($place) {
    //first check to see if any place exists in any tree with new place name
    $query = "SELECT * FROM $places_table WHERE place = \"$place\"";
    $result = tng_query($query);

    if (!tng_num_rows($result)) {
        if (!isset($usecoords)) {
            $latitude = $longitude = "";
            $zoom = 0;
        }
        $placetree = $tngconfig['places1tree'] ? "" : $tree;
        $template = "ssssss";
        $query = "INSERT IGNORE INTO $places_table (gedcom,place,placelevel,latitude,longitude,zoom,notes) VALUES (?, ?, '0', ?, ?, ?, ?)";
        $params = [&$template, &$placetree, &$place, &$latitude, &$longitude, &$zoom, &$notes];
        tng_execute($query, $params);
    } elseif (isset($usecoords)) {
        $treestr = $tree && $tngconfig['places1tree'] ? "gedcom='$tree' AND " : "";
        $query = "UPDATE $places_table SET latitude=\"$latitude\",longitude=\"$longitude\",zoom=\"$zoom\" WHERE {$treestr}place=\"$place\"";
        $result3 = tng_query($query);
    }
    tng_free_result($result);
}

adminwritelog("<a href=\"admin_editcemetery.php?cemeteryID=$cemeteryID\">" . _('Add New Cemetery') . ": $cemeteryID - $cemname</a>");

$message = _('Cemetery') . " $cemeteryID " . _('was successfully added') . ".";
header("Location: admin_cemeteries.php?message=" . urlencode($message));
