<?php
include "begin.php";
include "adminlib.php";
$textpart = "language";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
if (!$allow_edit) {
    $message = $admtext['norights'];
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

require "adminlog.php";

$display = addslashes($display);
$folder = addslashes($folder);

$query = "UPDATE $languages_table SET display=\"$display\",folder=\"$folder\",charset=\"$langcharset\",norels=\"$langnorels\" WHERE languageID=\"$languageID\"";
$result = tng_query($query);

adminwritelog("<a href=\"editlanguage.php?languageID=$languageID\">{$admtext['modifylanguage']}: $languageID</a>");

$message = $admtext['changestolanguage'] . " $languageID {$admtext['succsaved']}.";
header("Location: admin_languages.php?message=" . urlencode($message));

