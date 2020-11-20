<?php
include "begin.php";
include "adminlib.php";

$admin_login = 1;
include "checklogin.php";

if (!$allow_add) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

require "adminlog.php";

$query = "INSERT INTO $dna_groups_table (dna_group,test_type,gedcom,description,action) VALUES (\"$dna_group\",\"$test_type\",'$tree',\"$description\",'2')";
$result = tng_query($query);
$success = tng_affected_rows();

adminwritelog("<a href=\"admin_dna_groups.php\">" . _('Add Group') . ": $dna_group</a>");

$message = _('DNA Group') . " $dna_group " . _('was successfully added') . ".";
header("Location: admin_dna_groups.php?message=$message&amp;dna_group=$dna_group&amp;test_type=$test_type&amp;tree=$tree");
