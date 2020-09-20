<?php
include "begin.php";
include "adminlib.php";
$textpart = "branches";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
if (!$allow_edit || ($assignedtree && $assignedtree != $tree)) {
    $message = $admtext['norights'];
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

require "adminlog.php";

$description = addslashes($description);

if (!$dospouses) {
    $dospouses = 0;
}
$query = "UPDATE $branches_table SET description=\"$description\", personID=\"$personID\", agens=\"$agens\", dgens=\"$dgens\", dagens=\"$dagens\", inclspouses=\"$dospouses\" WHERE gedcom=\"$tree\" AND branch = '$branch'";
$result = tng_query($query);

adminwritelog($admtext['modifybranch'] . ": $branch");

if ($submitx) {
    $message = $admtext['changestobranch'] . " " . stripslashes($description) . " {$admtext['succsaved']}.";
    header("Location: admin_branches.php?message=" . urlencode($message));
} else {
    header("Location: admin_editbranch.php?branch=$branch&tree=$tree");
}

