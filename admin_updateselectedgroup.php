<?php
include "begin.php";
include "adminlib.php";

$admin_login = 1;
include "checklogin.php";
if (!$allow_edit || !$allow_delete) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

require "adminlog.php";

$count = 0;

$xdnaaction = stripslashes($xdnagroupaction);
if ($xdnagroupaction == _('Delete Selected')) {
    $query = "DELETE FROM $dna_groups_table WHERE 1=0";

    foreach (array_keys($_POST) as $key) {
        if (substr($key, 0, 3) == "dna") {
            $count++;
            $dna_group = substr($key, 3);
            $query .= " OR dna_group=\"$dna_group\"";

            $tquery = "UPDATE $dna_tests_table SET dna_group=\"\", dna_group_desc=\"\" WHERE dna_group=\"$dna_group\"";
            $result = tng_query($tquery);
            $lquery = "UPDATE $dna_links_table SET dna_group=\"\" WHERE dna_group=\"$dna_group\"";
            $result = tng_query($lquery);

        }
    }

    $result = tng_query($query);
}

adminwritelog(_('Edit Existing DNA Test') . ": " . _('All'));

if ($count) {
    $message = _('Changes to all tests') . " " . _('were successfully saved') . ".";
} else {
    $message = _('No changes were made.');
}
header("Location: admin_dna_groups.php?message=" . urlencode($message));
