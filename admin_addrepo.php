<?php
include "begin.php";
include "adminlib.php";

$admin_login = 1;
include "checklogin.php";
$tree = $tree1;
if (!$allow_add || ($assignedtree && $assignedtree != $tree)) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

require "adminlog.php";

$repoID = ucfirst($repoID);
setcookie("tng_tree", $tree, 0);

$newdate = date("Y-m-d H:i:s", time() + (3600 * $time_offset));

if ($address1 || $address2 || $city || $state || $zip || $country || $phone || $email || $www) {
    $template = "ssssssssss";
    $query = "INSERT INTO $address_table (address1, address2, city, state, zip, country, gedcom, phone, email, www) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $params = [&$template, &$address1, &$address2, &$city, &$state, &$zip, &$country, &$tree, &$phone, &$email, &$www];
    tng_execute($query, $params);
    $addressID = tng_insert_id();
} else {
    $addressID = "";
}

if (!$addressID) $addressID = 0;

$template = "ssssss";
$query = "INSERT INTO $repositories_table (repoID,reponame,addressID,changedate,gedcom,changedby) VALUES (?, ?, ?, ?, ?, ?)";
$params = [&$template, &$repoID, &$reponame, &$addressID, &$newdate, &$tree1, &$currentuser];
tng_execute($query, $params);

adminwritelog("<a href=\"admin_editrepo.php?repoID=$repoID&tree=$tree\">" . _('Add New Repository') . ": $tree/$repoID</a>");

header("Location: admin_editrepo.php?repoID=$repoID&tree=$tree&added=1");
