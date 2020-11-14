<?php
include "begin.php";
include "adminlib.php";
$textpart = "branches";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
if ($assignedbranch || !$allow_add) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}
require "adminlog.php";
setcookie("tng_tree", $tree, 0);
if (!$dospouses) $dospouses = 0;
$template = "ssssssss";
$query = "INSERT INTO $branches_table (gedcom,branch,description,personID,agens,dgens,dagens,inclspouses,action) VALUES (?, ?, ?, ?, ?, ?, ?, ?,'2')";
$params = [&$template, &$tree, &$branch, &$description, &$personID, &$agens, &$dgens, &$dagens, &$dospouses];
$affected_rows = tng_execute_noerror($query, $params);
if ($affected_rows == 1) {
    $message = _('Branch') . " $description " . _('was successfully added') . ".";
    adminwritelog(_('Add New Branch') . " : $gedcom/$description");
} else {
    $message = _('Branch') . " $description " . _('could not be added because this ID already exists.') . ".";
}


if ($submitx) {
    header("Location: admin_branches.php?message=" . urlencode($message));
} else {
    header("Location: admin_editbranch.php?branch=$branch&tree=$tree");
}
