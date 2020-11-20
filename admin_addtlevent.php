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

if (!$evday) $evday = "0";

if (!$evmonth) $evmonth = "0";

if (!$endday) $endday = "0";

if (!$endmonth) $endmonth = "0";

$template = "ssssssss";
$query = "INSERT INTO $tlevents_table (evday,evmonth,evyear,endday,endmonth,endyear,evtitle,evdetail) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$params = [&$template, &$evday, &$evmonth, &$evyear, &$endday, &$endmonth, &$endyear, &$evtitle, &$evdetail];
tng_execute($query, $params);
$tleventID = tng_insert_id();

adminwritelog(_('Add New Event') . ": $tleventID - $evdetail");

// TODO text ['tlevent'] was not defined in any language. Manually added here.
$message = _todo_('Timeline Event') . " $tleventID " . _('was successfully added') . ".";
header("Location: admin_timelineevents.php?message=" . urlencode($message));
