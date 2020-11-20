<?php
include "begin.php";
include "adminlib.php";

$admin_login = 1;
include "checklogin.php";
if ($assignedtree || !$allow_edit || !$allow_delete) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

require "adminlog.php";

$query = "";
if ($cetaction == _('Ignore Selected')) {
    $query = "UPDATE $eventtypes_table SET keep='0' WHERE 1=0";
} else {
    if ($cetaction == _('Accept Selected')) {
        $query = "UPDATE $eventtypes_table SET keep='1' WHERE 1=0";
    } else {
        if ($cetaction == _('Collapse Selected')) {
            $query = "UPDATE $eventtypes_table SET collapse='1' WHERE 1=0";
        } else {
            if ($cetaction == _('Expand Selected')) {
                $query = "UPDATE $eventtypes_table SET collapse='0' WHERE 1=0";
            } else {
                if ($cetaction == _('Delete Selected')) {
                    $query = "DELETE FROM $eventtypes_table WHERE 1=0";
                }
            }
        }
    }
}

if ($query) {
    foreach (array_keys($_POST) as $key) {
        if (substr($key, 0, 2) == "et") {
            $query .= " OR eventtypeID=\"" . substr($key, 2) . "\"";
        }
    }
    $result = tng_query($query);
}

adminwritelog(_('Edit Existing Event Type') . ": " . _('All'));

$message = _('Changes to all event types') . " " . _('were successfully saved') . ".";
header("Location: admin_eventtypes.php?message=" . urlencode($message));

