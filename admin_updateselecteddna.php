<?php
include "begin.php";
include "adminlib.php";
$textpart = "dna";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
if (!$allow_edit || !$allow_delete) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

require "adminlog.php";

$count = 0;

$xdnaaction = stripslashes($xdnaaction);
if ($xdnaaction == _('Delete Selected')) {
    $query = "DELETE FROM $dna_tests_table WHERE 1=0";

    foreach (array_keys($_POST) as $key) {
        if (substr($key, 0, 3) == "dna") {
            $count++;
            $testID = substr($key, 3);
            $query .= " OR testID=\"$testID\"";

            $aquery = "DELETE FROM $dna_links_table WHERE testID=\"$testID\"";
            $aresult = tng_query($aquery) or die (_('Cannot execute query') . ": $aquery");

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
header("Location: admin_dna_tests.php?message=" . urlencode($message));
