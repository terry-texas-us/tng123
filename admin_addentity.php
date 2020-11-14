<?php
include "begin.php";
include "adminlib.php";
$textpart = "entities";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
if (!$allow_add) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

require "adminlog.php";

$original_name = $newitem;
if ($session_charset != "UTF-8") {
    $newitem = tng_utf8_decode($newitem);
}

$newname = $newitem;

$template = "s";
if ($entity == "state") {
    $query = "INSERT INTO $states_table (state) VALUES (?)";
} elseif ($entity == "country") {
    $query = "INSERT INTO $countries_table (country) VALUES (?)";
}
$params = [&$template, &$newname];
$affected_rows = tng_execute_noerror($query, $params);

adminwritelog(_('Enter new') . " $entity: $original_name");

if ($affected_rows == 1) {
    echo "$original_name " . _('Added');
} else {
    echo "$original_name " . _('already exists');
}
