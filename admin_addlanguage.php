<?php
include "begin.php";
include "adminlib.php";
$textpart = "language";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
if ($assignedtree || !$allow_add) {
  $message = $admtext['norights'];
  header("Location: admin_login.php?message=" . urlencode($message));
  exit;
}

require "adminlog.php";

$template = "ssss";
$query = "INSERT INTO $languages_table (display,folder,charset,norels) VALUES (?,?,?,?)";
$params = array(&$template, &$display, &$folder, &$langcharset, &$langnorels);
tng_execute($query, $params);
$languageID = tng_insert_id();

adminwritelog("<a href=\"admin_editlanguage.php?languageID=$languageID\">{$admtext['addnewlanguage']}: $display/$folder</a>");

$message = $admtext['language'] . " $display {$admtext['succadded']}.";
header("Location: admin_languages.php?message=" . urlencode($message));
