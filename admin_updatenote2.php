<?php
include "begin.php";
include "adminlib.php";
$textpart = "notes";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
if (!$allow_edit || ($assignedtree && $assignedtree != $gedcom)) {
    $message = $admtext['norights'];
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
adminwritelog($admtext['modifynote'] . ": $ID");
$message = $admtext['notechanges'] . " $ID {$admtext['succsaved']}.";
header("Location: admin_notelist.php?message=" . urlencode($message));
