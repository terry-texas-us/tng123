<?php
include "begin.php";
include "adminlib.php";
$textpart = "trees";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
if (!$allow_edit || ($assignedtree && $assignedtree != $tree)) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

require "adminlog.php";

$treenamedisp = stripslashes($treename);

$treename = addslashes($treename);
$description = addslashes($description);
$owner = addslashes($owner);
$email = addslashes($email);
$address = addslashes($address);
$city = addslashes($city);
$state = addslashes($state);
$country = addslashes($country);
$zip = addslashes($zip);
$phone = addslashes($phone);
if (!$disallowgedcreate) $disallowgedcreate = 0;

if (!$disallowpdf) $disallowpdf = 0;

if (!$private) $private = 0;
$query = "UPDATE $trees_table SET treename=\"$treename\",description=\"$description\",owner=\"$owner\",email='$email',address=\"$address\",city=\"$city\",state=\"$state\",country=\"$country\",zip=\"$zip\",phone=\"$phone\",secret=\"$private\",disallowgedcreate=\"$disallowgedcreate\",disallowpdf=\"$disallowpdf\" WHERE gedcom = '$tree'";
$result = tng_query($query);
adminwritelog("<a href=\"admin_edittree.php?tree=$tree\">" . _('Edit Existing Tree') . ": $tree</a>");
$message = _('Changes to tree') . " $treenamedisp " . _('were successfully saved') . ".";
header("Location: admin_trees.php?message=" . urlencode($message));

