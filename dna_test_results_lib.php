<?php
//dna tests
$debug = $_GET['debug'] ?? false;  //get URL debug parameter
//search for dna tests, if any found do the following
$query = "SELECT $dna_tests_table.testID, $dna_tests_table.personID AS tpersonID, $dna_tests_table.gedcom AS tgedcom, test_type, test_number, test_date, match_date, markers, mtdna_haplogroup, ydna_haplogroup, hvr1_results, hvr2_results, y_results, person_name, mtdna_confirmed, ydna_confirmed, notes, markeropt, notesopt, linksopt, surnamesopt, private_dna,urls, surnames, MD_ancestorID, MRC_ancestorID, admin_notes, medialinks, ref_seq, xtra_mut, coding_reg, shared_cMs, shared_segments, chromosome, segment_start, segment_end, centiMorgans, matching_SNPs, x_match, relationship_range, suggested_relationship, actual_relationship, related_side, GEDmatchID, private_test 
			FROM $dna_tests_table, $dna_links_table
			WHERE $dna_links_table.personID = \"$personID\" AND $dna_links_table.gedcom = '$tree' AND $dna_links_table.testID = $dna_tests_table.testID
			ORDER BY match_date DESC, test_type ASC, markers * 1 ASC,  test_number * 1 ASC";
$dna_results = tng_query($query);
$num_tests = tng_num_rows($dna_results);
if ($debug) {
    echo "Allow Private - $allow_private<br>";
    echo "Number of DNA Tests - $num_tests<br>";
}

// following query added to check if this is a Private Test
$pquery = "SELECT $dna_tests_table.testID, $dna_tests_table.personID AS tpersonID, $dna_tests_table.gedcom AS tgedcom,private_test
			FROM $dna_tests_table, $dna_links_table
			WHERE $dna_links_table.personID = \"$personID\" AND $dna_links_table.gedcom = '$tree' AND $dna_links_table.testID = $dna_tests_table.testID AND $dna_tests_table.private_test = '1'
			ORDER BY test_type, markers * 1 ASC, test_date, test_number * 1 ASC";
$priv_results = tng_query($pquery);
$dnarow = tng_fetch_assoc($priv_results);    // added for Private Test check
$num_private = tng_num_rows($priv_results);    // added for Private Test check
if ($debug) echo "Number of Private DNA Tests - $num_private<br>";


$totnum_tests = $num_tests;

if (!$allow_private) $totnum_tests = ($num_tests - $num_private);

if ($debug) echo "Number of total DNA Tests - $totnum_tests<br>";

if ($totnum_tests) {
    $toggleicon = "<img src='img/tng_sort_desc.gif' alt='' class='toggleicon2 inline-block cursor-pointer float-right pt-1' title=\"" . _('Expand') . "\" onclick=\"togglednaicon(); \">";
    $displaystyle = "display:none";
    $displayclass = "dnatest";

    $uquery = "SELECT $dna_tests_table.testID, $dna_tests_table.personID, $dna_tests_table.gedcom FROM $dna_tests_table, $dna_links_table
				WHERE $dna_links_table.personID = \"$personID\" AND $dna_links_table.gedcom = '$tree' AND $dna_links_table.testID = $dna_tests_table.testID AND $dna_tests_table.personID != \"$personID\"";
    $dna_uresults = tng_query($uquery);
    $num_utests = tng_num_rows($dna_uresults);
    tng_free_result($dna_uresults);

    if ($allow_private) {
        $num_links = $num_tests;
        $num_tests = $num_tests + 2;
    } else {
        $num_links = $totnum_tests;
        $num_tests = $totnum_tests + 2;
    }
    if ($num_utests) {
        $linkedstr = ($num_links > 1) ? _('DNA tests are associated with') : _('DNA test is associated with');
        $linkedstr .= "&nbsp;" . $dnanamestr;
    } else {
        $linkedstr = $num_links > 1 ? _('DNA Tests') : _('DNA Test');
    }
    $persontext .= "<table class='whiteback tfixed' cellspacing='1' cellpadding='4'>\n";
    $persontext .= "<col class='labelcol'/><col style=\"width:{$datewidth}px;\"/><col class=\"takenbycol\"/><col class=\"haplogroupcol\"/><col />\n";
    $persontext .= "<tr>\n";
    $persontext .= "<td class='fieldnameback fieldname align-top' rowspan=\"$num_tests\">" . _('DNA Tests') . "$toggleicon</td>\n";
    $persontext .= "<td colspan='4' class='fieldnameback fieldname'><strong>&nbsp;$num_links&nbsp;$linkedstr</strong>&nbsp;";
    $persontext .= "<a href='#' title=\"" . _('DNA Test Info') . "\"><img src=\"img/info_2.png\" width=\"14\" height=\"14\" alt=\"\" onclick=\"tnglitbox = new LITBox('dna_info.php', {overlay:false, width:620, height:200}); return false\"/></a>";
    $persontext .= "</td>\n";
    $persontext .= "</tr>\n";
    $persontext .= "<tr id=\"dnatest\" class=\"$displayclass\" style=\"$displaystyle\">\n";
    $persontext .= "<th class='fieldnameback fieldname align-top'>" . _('Test Type') . "</th>";
    $persontext .= "<th class='fieldnameback fieldname align-top'>" . _('Taken by') . "</a></th>";
    $persontext .= "<th class='fieldnameback fieldname align-top'>" . _('Haplogroup') . "&nbsp;</th>";
    $persontext .= "<th class='fieldnameback fieldname align-top'>" . _('Test Information') . "</th></tr><tr class=\"$displayclass\" style=\"$displaystyle\">\n";
    //for each test, do a row
    $testnum = 0;
    while ($dna_test = tng_fetch_assoc($dna_results)) {
        if ($dna_test['private_test'] && ($allow_private) || (!$dna_test['private_test'])) {
            $dna_pers_result = getPersonSimple($dna_test['tgedcom'], $dna_test['tpersonID']);
            if ($dna_pers_result) $dprow = tng_fetch_assoc($dna_pers_result);
            $dna_righttree = checktree($dna_test['tgedcom']);
            $dna_rightbranch = $dna_righttree ? checkbranch($dprow['branch']) : false;
            $dprights = determineLivingPrivateRights($dprow, $dna_righttree, $dna_rightbranch);
            $dprow['allow_living'] = $dprights['living'];
            $dprow['allow_private'] = $dprights['private'];
            $dbname = getName($dprow);
            $person_name = $dna_test['person_name'];
            if ($dna_test['private_test']) {
                $privacy = "&nbsp;(" . _('Private Test') . ")";
            } else {
                $privacy = "";
            }
            if ($dbname) {
                $dna_namestr = "<a href=\"getperson.php?personID={$dna_test['tpersonID']}&tree={$dna_test['tgedcom']}\">" . getName($dprow) . "</a> $privacy";
            } else {
                $dna_namestr = $person_name . $privacy;
            }
            if ($dna_test['private_dna'] && !$allow_edit) {
                $dna_namestr = _('Private');
            }
            tng_free_result($dna_pers_result);

            if ($testnum) {
                $persontext .= "</tr>\n<tr class=\"dnatest\" style='display: none;'>\n";
            }
            $markercount = ($dna_test['test_type'] == "Y-DNA") ? "-{$dna_test['markers']}" : "";
            $persontext .= "<td class='databack'><a href=\"show_dna_test.php?testID={$dna_test['testID']}\">{$dna_test['test_type']}$markercount</a></td>\n";
            $persontext .= "<td class='databack'>$dna_namestr";
            $test_type = $dna_test['test_type'];
            if ($dna_test['test_type'] == "Y-DNA") {
                $haplogroup = $dna_test['ydna_haplogroup'] ? $dna_test['ydna_haplogroup'] : " ";
            }
            if ($dna_test['test_type'] == "mtDNA") {
                $haplogroup = $dna_test['mtdna_haplogroup'] ? $dna_test['mtdna_haplogroup'] : " ";
            }
            if ($dna_test['test_type'] == "atDNA") {
                if ($dna_test['ydna_haplogroup']) {
                    $haplogroup = "Y = " . $dna_test['ydna_haplogroup'] . "<br>";
                }
                if ($dna_test['mtdna_haplogroup']) {
                    $haplogroup .= "mt = " . $dna_test['mtdna_haplogroup'];
                }
            }
            $ref_seq = $dna_test['ref_seq'];
            $hvr1_results = $dna_test['hvr1_results'];
            $hvr2_results = $dna_test['hvr2_results'];
            $xtra_mut = $dna_test['xtra_mut'];
            $coding_reg = $dna_test['coding_reg'];
            $shared_cMs = $dna_test['shared_cMs'];
            $shared_segments = $dna_test['shared_segments'];
            $chromosome = $dna_test['chromosome'];
            $segment_start = $dna_test['segment_start'];
            $segment_end = $dna_test['segment_end'];
            $centiMorgans = $dna_test['centiMorgans'];
            $matching_SNPs = $dna_test['matching_SNPs'];
            $x_match = $dna_test['x_match'];
            $relationship_range = $dna_test['relationship_range'];
            $suggested_relationship = $dna_test['suggested_relationship'];
            $actual_relationship = $dna_test['actual_relationship'];
            $related_side = $dna_test['related_side'];
            $GEDmatchID = $dna_test['GEDmatchID'];
            $y_results = $dna_test['y_results'];
            $surnames = isset($ancsurnameupper) ? strtoupper($dna_test['surnames']) : $dna_test['surnames'];
            $dna_notes = $dna_test['notes'];
            $admin_notes = $dna_test['admin_notes'];

            $mdanc_namestr = "";
            if ($dna_test['MD_ancestorID']) {// Get Most Distant Ancestor info
                $dna_anc_result = getPersonData($dna_test['tgedcom'], $dna_test['MD_ancestorID']);
                $ancrow = tng_fetch_assoc($dna_anc_result);
                $anc_righttree = checktree($dna_test['tgedcom']);
                $anc_rightbranch = $anc_righttree ? checkbranch($ancrow['branch']) : false;
                $ancrights = determineLivingPrivateRights($ancrow, $anc_righttree, $anc_rightbranch);
                $ancrow['allow_living'] = $ancrights['living'];
                $ancrow['allow_private'] = $ancrights['private'];
                $vitalinfo = getBirthInfo($ancrow);
                $anc_namestr = getName($ancrow);
                $mdanc_namestr = "<a href=\"getperson.php?personID={$dna_test['MD_ancestorID']}&tree={$dna_test['tgedcom']}\">$anc_namestr</a>" . $vitalinfo;

                tng_free_result($dna_anc_result);
            }
            $mrcanc_namestr = "";
            if ($dna_test['MRC_ancestorID']) {// Get MRCA Individual info
                if ($dna_test['MRC_ancestorID'][0] == "I") {
                    $dna_anc_result = getPersonData($dna_test['tgedcom'], $dna_test['MRC_ancestorID']);
                    $ancrow = tng_fetch_assoc($dna_anc_result);
                    $anc_righttree = checktree($dna_test['tgedcom']);
                    $anc_rightbranch = $anc_righttree ? checkbranch($ancrow['branch']) : false;
                    $ancrights = determineLivingPrivateRights($ancrow, $anc_righttree, $anc_rightbranch);
                    $ancrow['allow_living'] = $ancrights['living'];
                    $ancrow['allow_private'] = $ancrights['private'];
                    $vitalinfo = getBirthInfo($ancrow);
                    $anc_namestr = getName($ancrow);
                    $mrcanc_namestr = "<a href=\"getperson.php?personID={$dna_test['MRC_ancestorID']}&tree={$dna_test['tgedcom']}\">$anc_namestr</a>" . $vitalinfo;

                    tng_free_result($dna_anc_result);
                } else {
                    if ($dna_test['MRC_ancestorID'][0] == $tngconfig['familyprefix']) {  // Get MRCA Family info
                        $mrcquery = "SELECT familyID, husband, wife, living, private, marrdate, gedcom, branch FROM $families_table WHERE familyID = \"{$dna_test['MRC_ancestorID']}\" AND gedcom = \"{$dna_test['tgedcom']}\"";
                        $mrcresult = tng_query($mrcquery);
                        $ancrow = tng_fetch_assoc($mrcresult);
                        tng_free_result($mrcresult);
                        $anc_righttree = checktree($dna_test['tgedcom']);
                        $anc_rightbranch = checkbranch($ancrow['branch']);
                        $ancrights = determineLivingPrivateRights($ancrow, $anc_righttree, $anc_rightbranch);
                        $ancrow['allow_living'] = $ancrights['living'];
                        $ancrow['allow_private'] = $ancrights['private'];
                        $famname = getFamilyName($ancrow);
                        $fammarried = "<br>&nbsp;&nbsp;<strong>" . _('m.') . "</strong>&nbsp;" . $ancrow['marrdate'];
                        $mrcanc_namestr = _('Family') . ": " . "<a href=\"familygroup.php?familyID={$dna_test['MRC_ancestorID']}&tree={$dna_test['tgedcom']}\">$famname</a>" . $fammarried;
                    }
                }
            }
            if ($dna_test['medialinks']) {// Get Media Links
                $medialinks = showMediaLinks($dna_test['medialinks']);
            } else {
                $medialinks = "";
            }
            if ($dna_test['urls']) {// Get Relevant Links
                $urls = showLinks($dna_test['urls'], true);
                if ($urls) $urls = "<ul>$urls</ul>";

            } else {
                $urls = "";
            }
            // Start test results
            if (isset($ydna_haplogroup)) {
                if ($dna_test['ydna_confirmed']) {
                    $haplogroup = "<a class=\"fakelink confirmed_haplogroup\" title=\"" . _('Confirmed') . "\">" . $ydna_haplogroup . "</a>";
                } else {
                    $haplogroup = "<a class=\"fakelink predicted_haplogroup\"  title = \"" . _('Predicted') . "\">" . $ydna_haplogroup . "</a>";
                }
            }
            if (isset($mtdna_haplogroup)) {
                if ($dna_test['mtdna_confirmed']) {
                    $haplogroup = "<a class=\"fakelink confirmed_haplogroup\" title=\"" . _('Confirmed') . "\">" . $mtdna_haplogroup . "</a>";
                } else {
                    $haplogroup = "<a class=\"fakelink predicted_haplogroup\"  title = \"" . _('Predicted') . "\">" . $mtdna_haplogroup . "</a>";
                }
            }
            $persontext .= "<td class='databack'>$haplogroup&nbsp;</td>\n";
            $persontext .= "<td class='databack resultscol'>";
            if ($GEDmatchID) {
                $GEDmatch_str = "<a href=\"https://www.gedmatch.com/\" target='_blank'>$GEDmatchID</a>";
                $persontext .= "<strong>" . _('GEDmatch ID') . "</strong> =  $GEDmatch_str <br><br>";
            }
            if ($mdanc_namestr) {
                $persontext .= "<strong>" . _('Most distant ancestor') . ":</strong><br>" . $mdanc_namestr . "<br><br>";
            }
            if ($mrcanc_namestr) {
                $persontext .= "<strong>" . _('MRC Ancestor') . ":</strong><br>" . $mrcanc_namestr . "<br>";
            }
            if ($dna_test['markeropt']) {
                $persontext .= $y_results ? "<br><strong>" . $dna_test['markers'] . "&nbsp;" . _('Marker values') . ":</strong><br>" . $y_results . "<br>" : "";
                if ($test_type == "mtDNA") {
                    if ($ref_seq) {
                        $persontext .= "<br><strong>" . _('Reference sequence') . ":</strong><br>";
                        if ($ref_seq == "rsrs") $persontext .= "" . _('RSRS (Reconstructed Sapiens Reference Sequence)') . "";

                        if ($ref_seq == "rcrs") $persontext .= "" . _('rCRS (revised Cambridge Reference Sequence)') . "";

                        $persontext .= "<br>";
                    }
                    if ($hvr1_results || $hvr2_results) {
                        $persontext .= "<br><strong>" . _('HVR Differences') . ":</strong><br>";
                        if ($hvr1_results) {
                            $persontext .= "" . _('HVR1') . " = $hvr1_results<br>";
                        }
                        if ($hvr2_results) {
                            $persontext .= "<div>" . nl2br(_('HVR2')) . " = $hvr2_results<br></div>";
                        }
                    }
                    $persontext .= $xtra_mut ? "<div><br><strong>" . nl2br(_('Extra mutations')) . ":</strong><br>$xtra_mut</div>" : "";
                    $persontext .= $allow_admin && $coding_reg ? "<div><br><strong>" . nl2br(_('Coding region differences')) . ":</strong><br>" . $coding_reg . "</div>" : "";
                }
                if ($test_type == "atDNA") {
                    if ($shared_cMs) {
                        $persontext .= "<br><strong>" . _('Shared DNA') . ":</strong><br>";
                        $total_shared = _('Total shared cMs') . " " . $shared_cMs;
                        if ($shared_segments) {
                            $total_shared .= " | $shared_segments " . _('Shared segments') . " ";
                        } else {
                            $total_shared .= " ";
                        }
                        $persontext .= _('Shared DNA') . " =  $total_shared <br>";
                    }
                    if ($chromosome && $centiMorgans) {
                        $segment = "" . _('Chr') . " $chromosome | $centiMorgans " . _('cM') . " ";
                        $persontext .= _('Largest Segment') . " =  $segment <br>";
                    }
                    if ($segment_start) {
                        $persontext .= _('Segment Start') . " =  $segment_start <br>";
                    }
                    if ($segment_end) {
                        $persontext .= _('End') . " =  $segment_end <br>";
                    }
                    if ($matching_SNPs) {
                        $persontext .= _('Matching SNPs') . " =  $matching_SNPs <br>";
                    }
                    if ($x_match) {
                        $persontext .= _('X-Match') . " =  " . _('Yes') . " <br>";
                    }
                    if ($relationship_range || $suggested_relationship || $actual_relationship || $related_side) {
                        $persontext .= "</div><br><strong>" . _('Relationship Section') . ":</strong><br><div>";
                    }
                    if ($relationship_range) {
                        $persontext .= _('Relationship Range') . " =  $relationship_range <br>";
                    }
                    if ($suggested_relationship) {
                        $persontext .= _('Suggested') . " =  $suggested_relationship <br>";
                    }
                    if ($actual_relationship) {
                        $persontext .= _('Actual') . " =  $actual_relationship <br>";
                    }
                    if ($related_side) {
                        $persontext .= _('Related Branch') . " =  $related_side <br>";
                    }
                }
            }
            $persontext .= $dna_test['surnamesopt'] && $surnames ? "<br><strong>" . _('Ancestral surnames') . ":</strong><br>" . $surnames . "<br>" : "";
            $persontext .= $dna_test['linksopt'] && $urls ? "<br><strong>" . _('Relevant links') . ": </strong>" . $urls : "";
            $persontext .= $medialinks ? "<br><strong>" . _('Media Links') . ": </strong>" . $medialinks : "";
            $persontext .= $dna_test['notesopt'] && $dna_notes ? "<br><strong>" . _('Notes') . ":</strong><br>" . $dna_notes . "<br>" : "";
            $persontext .= $allow_admin && $dna_test['admin_notes'] ? "<br><strong>" . _('Administrator notes') . ":</strong><br>" . $admin_notes . "<br>" : "";
            $persontext .= "</td>\n";

            $persontext .= "</td>\n";
            $persontext .= "</tr>\n";
            $testnum++;
        }
    }

    $persontext .= "</table>\n";
    $persontext .= "<br>\n";
}
tng_free_result($dna_results);
