<?php
include "begin.php";
include "adminlib.php";
$textpart = "language";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
if ($assignedtree || !$allow_add) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

require "adminlog.php";

$template = "ssss";
$query = "INSERT INTO $languages_table (display, folder, charset, norels) VALUES (?, ?, ?, ?)";
$params = [&$template, &$display, &$folder, &$langcharset, &$langnorels];
tng_execute($query, $params);
$languageID = tng_insert_id();

adminwritelog("<a href=\"admin_editlanguage.php?languageID=$languageID\">" . _('Add New Language') . ": $display/$folder</a>");

$message = _('Language') . " $display " . _('was successfully added') . ".";
header("Location: admin_languages.php?message=" . urlencode($message));
