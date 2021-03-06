<?php
include "begin.php";
include "adminlib.php";

$admin_login = 1;
include "checklogin.php";
if (!$allow_add) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

require "adminlog.php";
include "geocodelib.php";

$latitude = preg_replace("/,/", ".", $latitude);
$longitude = preg_replace("/,/", ".", $longitude);
if ($latitude && $longitude && $placelevel && !$zoom) $zoom = 13;

if (!$zoom) $zoom = 0;

if (!$placelevel) $placelevel = 0;

if (!$temple) $temple = 0;

if ($tngconfig['places1tree']) {
    $tree = "";
} else {
    setcookie("tng_tree", $tree, 0);
}

$template = "ssssssss";
$query = "INSERT IGNORE INTO $places_table (gedcom,place,placelevel,temple,latitude,longitude,zoom,notes,geoignore) VALUES (?, ?, ?, ?, ?, ?, ?, ?, '0')";
$params = [&$template, &$tree, &$place, &$placelevel, &$temple, &$latitude, &$longitude, &$zoom, &$notes];
$affected_rows = tng_execute_noerror($query, $params);
if ($affected_rows) {
    $placeID = tng_insert_id();
    if ($tngconfig['autogeo']) $message = geocode($place, 0, $placeID);

    adminwritelog("<a href=\"admin_editplace.php?ID=$placeID\">" . _('Add New Place') . ": $placeID - " . stripslashes($place) . "</a>");

    $message = _('Place') . " " . stripslashes($place) . " " . _('was successfully added') . ".";
} else {
    $message = _('Place') . " " . stripslashes($place) . " " . _('could not be added because this ID already exists.') . "";
}

header("Location: admin_places.php?message=" . urlencode($message));
