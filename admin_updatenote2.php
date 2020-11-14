<?php
include "begin.php";
include "adminlib.php";
$textpart = "notes";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
if (!$allow_edit || ($assignedtree && $assignedtree != $gedcom)) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}
require "adminlog.php";
$note = addslashes($note);
$query = "UPDATE $xnotes_table SET note=\"{$note}\" WHERE ID=\"{$xID}\"";
$result = tng_query($query);
if (!$private) $private = "0";
$query = "UPDATE $notelinks_table SET secret=\"$private\" WHERE ID='$ID'";
$result = tng_query($query);
adminwritelog(_('Modify Note') . ": $ID");
$message = _('Changes to note') . " $ID " . _('were successfully saved') . ".";
header("Location: admin_notelist.php?message=" . urlencode($message));
