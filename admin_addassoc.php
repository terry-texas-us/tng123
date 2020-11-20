<?php

include "begin.php";
include "adminlib.php";
require "./admin/associations.php";

include "checklogin.php";
require "adminlog.php";

if (!$allow_add) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    exit;
}

if ($session_charset != "UTF-8") {
    $relationship = tng_utf8_decode($relationship);
}

$template = "sssss";
$query = "INSERT INTO $assoc_table (gedcom, personID, passocID, relationship, reltype)  VALUES(?, ?, ?, ?, ?)";
$params = [&$template, &$tree, &$personID, &$passocID, &$relationship, &$reltype];
tng_execute($query, $params);
$assocID = tng_insert_id();

if ($revassoc) {
    $params = [&$template, &$tree, &$passocID, &$personID, &$relationship, &$orgreltype];
    tng_execute($query, $params);
}

adminwritelog(_('Add New Association') . ": $assocID/$tree/$personID::$passocID ($relationship)");

//get name

$name = getPersonOrFamilyAssociatedName($reltype, $passocID, $tree);
$namestr = cleanIt($name . ": " . stripslashes($relationship));
$namestr = truncateIt($namestr, 75);
header("Content-type:text/html; charset=" . $session_charset);
echo "{\"id\":\"$assocID\",\"persfamID\":\"$personID\",\"tree\":\"$tree\",\"display\":\"$namestr\",\"allow_edit\":$allow_edit,\"allow_delete\":$allow_delete}";
