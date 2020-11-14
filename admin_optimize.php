<?php
include "begin.php";
include "adminlib.php";
$textpart = "setup";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
if ($assignedtree) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

require "adminlog.php";

if ($table == "all") {
    $tablelist = [$cemeteries_table, $people_table, $families_table, $children_table, $languages_table, $places_table, $states_table,
        $countries_table, $sources_table, $repositories_table, $citations_table, $reports_table, $events_table, $eventtypes_table, $trees_table, $notelinks_table,
        $xnotes_table, $users_table, $tlevents_table, $temp_events_table, $templates_table, $branches_table, $branchlinks_table, $dna_groups_table, $dna_links_table, $dna_tests_table,
        $address_table, $albums_table, $albumlinks_table, $album2entities_table, $assoc_table, $media_table, $medialinks_table, $mediatypes_table, $mostwanted_table];
    $tablename = _('Selected Tables');
    $message = "$tablename " . _('successfully optimized') . ".";
} else {
    $tablelist = ["$table"];
    $tablename = $table;
    $message = "" . _('Table') . " $tablename " . _('successfully optimized') . ".";
}

foreach ($tablelist as $thistable) {
    $query = "OPTIMIZE TABLE $thistable";
    $result = tng_query($query);
}

header("Content-type:text/html; charset=" . $session_charset);
adminwritelog(_('Optimize') . ": $tablename");
if ($table == "all") {
    header("Location: admin_utilities.php?message=" . urlencode($message));
} else {
    echo $table . "&" . _('successfully optimized');
}
