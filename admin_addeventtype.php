<?php
include "begin.php";
include "adminlib.php";

include "checklogin.php";
if (!$allow_add) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}
require "adminlog.php";
if ($tag2) {
    $tag = $tag2;
} else {
    $tag = $tag1;
}
if (!$ordernum) $ordernum = 0;
if (!$display) $display = $defdisplay;

$template = "ssssssss";
$query = "INSERT INTO $eventtypes_table (tag,description,display,type,keep,collapse,ordernum,ldsevent) 
	VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$params = [&$template, &$tag, &$description, &$display, &$type, &$keep, &$collapse, &$ordernum, &$ldsevent];
$affected_rows = tng_execute_noerror($query, $params);
if ($affected_rows == 1) {
    $eventtypeID = tng_insert_id();
    $message = _('Event Type') . " $eventtypeID " . _('was successfully added') . ".";

    adminwritelog(_('Add New Event Type') . ": $tag $type - $display");
} else {
    $message = _('Event Type') . " $eventtypeID " . _('could not be added because this ID already exists.') . ".";
}

header("Location: admin_eventtypes.php?message=" . urlencode($message));
