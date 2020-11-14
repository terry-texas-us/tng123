<?php
include "begin.php";
include "adminlib.php";
$textpart = "branches";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
if (!$allow_edit || ($assignedtree && $assignedtree != $tree)) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}
require "adminlog.php";
$description = addslashes($description);
if (!$dospouses) $dospouses = 0;
$query = "UPDATE $branches_table SET description=\"$description\", personID='$personID', agens=\"$agens\", dgens=\"$dgens\", dagens=\"$dagens\", inclspouses=\"$dospouses\" WHERE gedcom = '$tree' AND branch = '$branch'";
$result = tng_query($query);
adminwritelog(_('Edit Existing Branch') . ": $branch");
if ($submitx) {
    $message = _('Changes to branch') . " " . stripslashes($description) . " " . _('were successfully saved') . ".";
    header("Location: admin_branches.php?message=" . urlencode($message));
} else {
    header("Location: admin_editbranch.php?branch=$branch&tree=$tree");
}

