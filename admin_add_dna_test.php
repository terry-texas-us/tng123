<?php
include "begin.php";
include "adminlib.php";
include "datelib.php";
$textpart = "dna";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";

if (!$allow_add) {
  $message = $admtext['norights'];
  header("Location: admin_login.php?message=" . urlencode($message));
  exit;
}

require "adminlog.php";

$thumbpath = stripslashes($thumbpath);

$descquery = "SELECT description FROM $dna_groups_table WHERE dna_group=\"$dna_group\"";
$descresult = tng_query($descquery);
$descrow = tng_fetch_assoc($descresult);
tng_free_result($descresult);
$group = $dna_group ? $descrow['description'] : "";
$dna_group_desc = addslashes($group);

$test_date = convertDate($test_date);
$match_date = convertDate($match_date);

if (!$personID && !$person_name) {
  $mynewgedcom = "";
}

$template = "sssssssssssssssssssssssssssss";
$query = "INSERT IGNORE INTO $dna_tests_table (test_type, test_number, notes, vendor, test_date, match_date, personID, gedcom, urls, markers, y_results, hvr1_results, hvr2_results, person_name, ydna_confirmed, mtdna_confirmed,markeropt, notesopt, linksopt, surnamesopt, private_dna, private_test, dna_group, dna_group_desc, surnames, mtdna_haplogroup, ydna_haplogroup, significant_snp, terminal_snp)
		VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$params = array(&$template, &$test_type, &$test_number, &$notes, &$vendor, &$test_date, &$match_date, &$personID, &$mynewgedcom, &$urls, &$markers, &$y_results, &$hvr1_results, &$hvr2_results, &$person_name, &$ydna_confirmed, &$mtdna_confirmed, &$markeropt, &$notesopt, &$linksopt, &$surnamesopt, &$private_dna, &$private_test, &$dna_group, &$dna_group_desc, &$surnames, &$mtdna_haplogroup, &$ydna_haplogroup, &$signsnp, &$termsnp);
tng_execute($query, $params);
$success = tng_affected_rows();
if ($success) {
  $testID = tng_insert_id();

  if ($personID) {
    $template = "ssss";
    $query = "INSERT IGNORE INTO $dna_links_table (testID,personID,gedcom,dna_group) VALUES (?,?,?,?)";
    $params = array(&$template, &$testID, &$personID, &$mynewgedcom, &$dna_group);
    tng_execute($query, $params);
  }

  adminwritelog("<a href=\"admin_edit_dna_test.php?testID=$testID\">{$admtext['addnewtest']}: $testID</a>");

  header("Location: admin_edit_dna_test.php?testID=$testID&newtest=1&added=1");
} else {
  $message = $admtext['testnotadded'] . ".";
  header("Location: admin_dna_tests.php?message=" . urlencode($message));
}
