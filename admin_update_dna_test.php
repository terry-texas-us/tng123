<?php
include "begin.php";
include "adminlib.php";
include "datelib.php";
$textpart = "dna";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
if (!$allow_edit && !$allow_add) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

require "adminlog.php";

$test_number = addslashes($test_number);
$notes = addslashes($notes);
$vendor = addslashes($vendor);
$y_results = addslashes($y_results);
$hvr1_results = addslashes($hvr1_results);
$hvr2_results = addslashes($hvr2_results);
$person_name = addslashes($person_name);
$dna_group = addslashes($dna_group);

$surnames = addslashes($surnames);
$MD_ancestorID = addslashes($MD_ancestorID);
$MRC_ancestorID = addslashes($MRC_ancestorID);
$ref_seq = addslashes($ref_seq);
$xtra_mut = addslashes($xtra_mut);
$coding_reg = str_replace(', ', ',', $coding_reg);
$coding_reg = str_replace(',', ', ', $coding_reg);
$coding_reg = addslashes($coding_reg);
$admin_notes = addslashes($admin_notes);
$personID = addslashes($personID);
$urls = addslashes($urls);
$markers = addslashes($markers);
$haplogroup = addslashes($haplogroup);
$signsnp = addslashes($signsnp);
$termsnp = addslashes($termsnp);

$descquery = "SELECT description FROM $dna_groups_table WHERE dna_group=\"$dna_group\"";
$descresult = tng_query($descquery);
$descrow = tng_fetch_assoc($descresult);
tng_free_result($descresult);
$dna_group_desc = $dna_group ? $descrow['description'] : "";


$test_date = convertDate($test_date);
$match_date = convertDate($match_date);
if (!$personID && !$person_name) $mynewgedcom = "";


$query = "UPDATE $dna_tests_table SET test_type=\"$test_type\", test_number=\"$test_number\", notes=\"$notes\", vendor=\"$vendor\", test_date=\"$test_date\", match_date=\"$match_date\",personID='$personID',
	gedcom=\"$mynewgedcom\", urls=\"$urls\", markers=\"$markers\", y_results=\"$y_results\", hvr1_results=\"$hvr1_results\", hvr2_results=\"$hvr2_results\", person_name = \"$person_name\",
	mtdna_confirmed = \"$mtdna_confirmed\", ydna_confirmed = \"$ydna_confirmed\", markeropt = \"$markeropt\", notesopt = \"$notesopt\", linksopt = \"$linksopt\", surnamesopt = \"$surnamesopt\", private_dna = \"$private_dna\", private_test = \"$private_test\",
	dna_group = \"$dna_group\", dna_group_desc = \"$dna_group_desc\", surnames = \"$surnames\", MD_ancestorID = \"$MD_ancestorID\", MRC_ancestorID = \"$MRC_ancestorID\",
	admin_notes = \"$admin_notes\", medialinks = \"$medialinks\", ref_seq = \"$ref_seq\", xtra_mut = \"$xtra_mut\", coding_reg = \"$coding_reg\", mtdna_haplogroup=\"$mtdna_haplogroup\", ydna_haplogroup=\"$ydna_haplogroup\", significant_snp=\"$signsnp\", terminal_snp=\"$termsnp\", shared_cMs = \"$shared_cMs\", shared_segments = \"$shared_segments\", chromosome = \"$chromosome\", segment_start = \"$segment_start\", segment_end = \"$segment_end\", centiMorgans = \"$centiMorgans\", matching_SNPs = \"$matching_SNPs\", x_match = \"$x_match\", relationship_range = \"$relationship_range\", suggested_relationship = \"$suggested_relationship\", actual_relationship = \"$actual_relationship\", related_side = \"$related_side\", GEDmatchID = \"$GEDmatchID\"

	WHERE testID=\"$testID\"";
$result = tng_query($query);

$query = "UPDATE $dna_links_table SET dna_group=\"$dna_group\"  WHERE testID=\"$testID\"";
$result = tng_query($query);

if ($personID && $personID != $personID_org) {
    $query = "INSERT IGNORE INTO $dna_links_table (testID,personID,gedcom,dna_group) VALUES (\"$testID\",\"$personID\",\"$mynewgedcom\",\"$dna_group\")";
    $result = @tng_query($query);
}

adminwritelog("<a href=\"admin_edit_dna_test.php?testID=$testID\">" . _('Edit Existing DNA Test') . ": $testID</a>");

if ($newtest == "return") {
    header("Location: admin_edit_dna_test.php?testID=$testID&cw=$cw");
} else {
    if ($newtest == "close") {
        ?>
        <!doctype html>
        <html lang="en">

        <body>
        <script>
            top.close();
        </script>
        </body>
        </html>
        <?php
    } else {
        $message = _('Changes to test') . " $test_number " . _('were successfully saved') . ".";
        header("Location: admin_dna_tests.php?message=" . urlencode($message));
    }
}
?>