<?php
include "begin.php";
include "adminlib.php";
$textpart = "people";
include "$mylanguage/admintext.php";

include "checklogin.php";

require "adminlog.php";

$query = "DELETE FROM $assoc_table WHERE assocID=\"{$assocID}\"";
$result = tng_query($query);

$query = "SELECT count(assocID) AS acount FROM $assoc_table WHERE personID=\"{$personID}\" AND gedcom='$tree'";
$result = tng_query($query);
$row = tng_fetch_assoc($result);
tng_free_result($result);

adminwritelog("" . _('Deleted') . ": " . _('Association') . " $assocID");

echo $row['acount'];
