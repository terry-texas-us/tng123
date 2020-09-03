<?php

include "begin.php";
include "adminlib.php";
require "./admin/associations.php";

$textpart = "people";
include "$mylanguage/admintext.php";

include "checklogin.php";
require "datelib.php";

if (!$allow_edit) {
    $message = $admtext['norights'];
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

require "adminlog.php";

$orgrelationship = $relationship;
if ($session_charset != "UTF-8") {
    $relationship = tng_utf8_decode($relationship);
    $orgrelationship = tng_utf8_decode(stripslashes($orgrelationship));
}
$relationship = addslashes($relationship);

$query = "UPDATE $assoc_table ";
$query .= "SET passocID=\"{$passocID}\", relationship=\"{$relationship}\", reltype=\"{$reltype}\" ";
$query .= "WHERE assocID=\"{$assocID}\"";
$result = tng_query($query);

adminwritelog($admtext['modifyassoc'] . ": $assocID/$tree/$personID::$passocID ($relationship)");

$name = getPersonOrFamilyAssociatedName($reltype, $passocID, $tree);
$namestr = cleanIt($name . ": " . $orgrelationship);
$namestr = truncateIt($namestr, 75);
header("Content-type:text/html; charset=" . $session_charset);
echo "{\"display\":\"$namestr\"}";
