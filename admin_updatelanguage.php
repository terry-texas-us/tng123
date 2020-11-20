<?php
include "begin.php";
include "adminlib.php";

$admin_login = 1;
include "checklogin.php";
if (!$allow_edit) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

require "adminlog.php";

$display = addslashes($display);
$folder = addslashes($folder);

$query = "UPDATE $languages_table SET display=\"$display\",folder=\"$folder\",charset=\"$langcharset\",norels=\"$langnorels\" WHERE languageID=\"$languageID\"";
$result = tng_query($query);

adminwritelog("<a href=\"editlanguage.php?languageID=$languageID\">" . _('Edit Existing Language') . ": $languageID</a>");

$message = _('Changes to language') . " $languageID " . _('were successfully saved') . ".";
header("Location: admin_languages.php?message=" . urlencode($message));

