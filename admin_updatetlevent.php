<?php
include "begin.php";
include "adminlib.php";

$admin_login = 1;
include "checklogin.php";
if (!$allow_edit) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}
require "adminlog.php";
$evdetail = addslashes($evdetail);
$evtitle = addslashes($evtitle);
if (!$evday) $evday = "0";
if (!$evmonth) $evmonth = "0";
if (!$endday) $endday = "0";
if (!$endmonth) $endmonth = "0";
$query = "UPDATE $tlevents_table SET evday=\"$evday\", evmonth=\"$evmonth\", evyear=\"$evyear\",endday=\"$endday\", endmonth=\"$endmonth\", endyear=\"$endyear\",evtitle=\"$evtitle\",evdetail=\"$evdetail\" WHERE tleventID=\"$tleventID\"";
$result = tng_query($query);
adminwritelog(_('Edit Existing Timeline Event') . ": $tleventID");
if ($newscreen == "return") {
    header("Location: admin_edittlevent.php?tleventID=$tleventID");
} else {
    $message = _('Changes to timeline event') . " $tleventID " . _('were successfully saved') . ".";
    header("Location: admin_timelineevents.php?message=" . urlencode($message));
}

