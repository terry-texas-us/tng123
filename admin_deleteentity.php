<?php
include "begin.php";
include "adminlib.php";

$admin_login = 1;
include "checklogin.php";

if (!$allow_delete) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

require "adminlog.php";

$original_name = $delitem;
if ($session_charset != "UTF-8") {
    $delitem = tng_utf8_decode($delitem);
}

$newname = addslashes($delitem);
if ($entity == "state") {
    $query = "DELETE FROM $states_table WHERE state = \"$newname\"";
} elseif ($entity == "country") {
    $query = "DELETE FROM $countries_table WHERE country = \"$newname\"";
}
$result = tng_query($query);

adminwritelog(_('Deleted') . ": $entity: $original_name");
echo "1";

 