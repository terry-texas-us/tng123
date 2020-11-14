<?php
include "begin.php";
include "adminlib.php";
$textpart = "eventtypes";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
if (!$allow_edit) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

require "adminlog.php";

$type = addslashes($type);
$tag2 = addslashes($tag2);
$defdisplay = addslashes($defdisplay);

if ($tag2) {
    $tag = $tag2;
} else {
    $tag = $tag1;
}
if (!$display) $display = $defdisplay;

$query = "UPDATE $eventtypes_table SET tag=\"$tag\",type=\"$type\",description=\"$description\",display=\"$display\",keep=\"$keep\",collapse=\"$collapse\",ordernum=\"$ordernum\",ldsevent=\"$ldsevent\" WHERE eventtypeID=\"$eventtypeID\"";
$result = tng_query($query);

adminwritelog(_('Edit Existing Event Type') . ": $eventtypeID");

$message = _('Changes to event type') . " $eventtypeID " . _('were successfully saved') . ".";
header("Location: admin_eventtypes.php?message=" . urlencode($message));

