<?php
$textpart = "dna";
include "tng_begin.php";

if (!$testID) {
    header("Location: thispagedoesnotexist.html");
    exit;
}

include "personlib.php";

$flags['imgprev'] = true;

$firstsection = 1;
$firstsectionsave = "";
$tableid = "";
$cellnumber = 0;

$query = "SELECT * FROM $dna_tests_table WHERE testID = \"$testID\"";
$result = tng_query($query);
$dnarow = tng_fetch_assoc($result);
if (!tng_num_rows($result)) {
    tng_free_result($result);
    header("Location: thispagedoesnotexist.html");
    exit;
}
tng_free_result($result);

$testnum = ($allow_edit || $showtestnumbers) ? "{$dnarow['test_number']}" : "";
$headline = "{$text['dna_test']}: {$dnarow['test_type']} $testnum";
$logstring = "<a href=\"show_dna_test.php?testID=$testID\">$headline</a>";
writelog($logstring);
preparebookmark($logstring);

echo "<!doctype html>\n";
echo "<html lang='en'>\n";

$flags['tabs'] = $tngconfig['tabs'];

tng_header($headline, $flags);
?>
    <h2 class="header"><span class="headericon" id="dna-hdr-icon"></span><?php echo $headline; ?></h2>
    <br class="clearleft">
<?php
$dnatext = "";
$dnatext .= "<ul class=\"nopad\">\n";
$dnatext .= beginSection("info");
$dnatext .= "<table cellspacing='1' cellpadding=\"4\" class=\"whiteback tfixed normal\">\n";
$dnatext .= "<col class=\"labelcol\"/><col style=\"width:{$datewidth}px;\"/><col/>\n";

if ($dnarow['test_type'] == "atDNA") {
    $test_type = "atDNA (Autosomal)";
} elseif ($dnarow['test_type'] == "mtDNA") {
    $test_type = "mtDNA (Mitochondrial)";
} else {
    $test_type = $dnarow['test_type'];
}

if ($dnarow['personID']) {
    $dna_pers_result = getPersonSimple($dnarow['gedcom'], $dnarow['personID']);
    $dprow = tng_fetch_assoc($dna_pers_result);
    $dna_righttree = checktree($dprow['gedcom']);
    $dna_rightbranch = $dna_righttree ? checkbranch($dprow['branch']) : false;
    $dprights = determineLivingPrivateRights($dprow, $dna_righttree, $dna_rightbranch);
    $dprow['allow_living'] = $dprights['living'];
    $dprow['allow_private'] = $dprights['private'];
    $dna_namestr = getName($dprow);
    $dna_namestr = "<a href=\"getperson.php?personID={$dnarow['personID']}&tree={$dnarow['gedcom']}\">$dna_namestr</a>";
    if ($dnarow['private_dna'] && !$allow_edit) {
        $dna_namestr = $admtext['text_private'];
    }
    tng_free_result($dna_pers_result);
} else {
    $person_name = $dnarow['person_name'];
    $dna_namestr = ($dnarow['private_dna'] && !$allow_edit) ? $admtext['text_private'] : $person_name;
}

$dnatext .= showEvent(["text" => $text['takenby'], "fact" => $dna_namestr]);

if ($dnarow['private_test'] && $allow_private) {
    $dnatext .= showEvent(["text" => $text['keep_test_private'], "fact" => $admtext['yes']]);
}
if ($dnarow['test_date'] && $dnarow['test_date'] != "0000-00-00") {
    $test_date = formatInternalDate($dnarow['test_date']);
    if ($dprights['both']) {
        $dnatext .= showEvent(["text" => $text['test_date'], "fact" => $test_date]);
    }
}
if ($dnarow['match_date'] && $dnarow['match_date'] != "0000-00-00") {
    $match_date = formatInternalDate($dnarow['match_date']);
    if ($dprights['both']) {
        $dnatext .= showEvent(["text" => $admtext['match_date'], "fact" => $match_date]);
    }
}

if ($dnarow['vendor']) {
    $dnatext .= showEvent(["text" => $admtext['vendor'], "fact" => $dnarow['vendor']]);
}

$dnatext .= showEvent(["text" => $text['test_type'], "fact" => $test_type]);
if ($dnarow['test_number'] && ($allow_edit || $showtestnumbers)) {
    $dnatext .= showEvent(["text" => $text['test_number'], "fact" => $dnarow['test_number']]);
}
$dnagroup = $dnarow['dna_group'];
$dscquery = "SELECT description FROM $dna_groups_table WHERE dna_group='$dnagroup'";
$dscresult = tng_query($dscquery);
$dscrow = tng_fetch_assoc($dscresult);
tng_free_result($dscresult);
$group = $dnagroup ? $dscrow['description'] : $text['none'];
if ($dnarow['dna_group']) {
    $dnatext .= showEvent(["text" => $text['testgroup'], "fact" => $group]);
}
if ($dnarow['GEDmatchID']) {
    if ($dprights['both']) {
        $GEDmatch_str = "<a href=\"https://www.gedmatch.com/\" target=\"_blank\">{$dnarow['GEDmatchID']}</a>";
        $dnatext .= showEvent(["text" => $admtext['gedmatchID'], "fact" => $GEDmatch_str]);
    }
}
if ($dnarow['MD_ancestorID']) {
    $dna_pers_result = getPersonData($dnarow['gedcom'], $dnarow['MD_ancestorID']);
    $ancrow = tng_fetch_assoc($dna_pers_result);
    $dna_righttree = checktree($ancrow['gedcom']);
    $dna_rightbranch = $dna_righttree ? checkbranch($ancrow['branch']) : false;
    $dprights = determineLivingPrivateRights($ancrow, $dna_righttree, $dna_rightbranch);
    $ancrow['allow_living'] = $dprights['living'];
    $ancrow['allow_private'] = $dprights['private'];
    $vitalinfo = getBirthInfo($ancrow);
    $anc_namestr = getName($ancrow);
    $anc_namestr = "<a href=\"getperson.php?personID={$dnarow['MD_ancestorID']}&tree={$dnarow['gedcom']}\">$anc_namestr</a>" . $vitalinfo;

    tng_free_result($dna_pers_result);

    $ancestor_str = ($dnarow['test_type'] == "atDNA") ? $admtext['mrca'] : $admtext['mda'];
    $dnatext .= showEvent(["text" => $admtext['mda'], "fact" => $anc_namestr]);
}
if ($dnarow['MRC_ancestorID']) {
    if ($dnarow['MRC_ancestorID'][0] == $tngconfig['personprefix']) {
        $dna_mrca_result = getPersonData($dnarow['gedcom'], $dnarow['MRC_ancestorID']);
        $ancrow = tng_fetch_assoc($dna_mrca_result);
        $dna_righttree = checktree($ancrow['gedcom']);
        $dna_rightbranch = $dna_righttree ? checkbranch($ancrow['branch']) : false;
        $dprights = determineLivingPrivateRights($ancrow, $dna_righttree, $dna_rightbranch);
        $ancrow['allow_living'] = $dprights['living'];
        $ancrow['allow_private'] = $dprights['private'];
        $vitalinfo = getBirthInfo($ancrow);
        $anc_namestr = getName($ancrow);
        $anc_namestr = "<a href=\"getperson.php?personID={$dnarow['MRC_ancestorID']}&tree={$dnarow['gedcom']}\">$anc_namestr</a>" . $vitalinfo;

        tng_free_result($dna_mrca_result);

        $dnatext .= showEvent(["text" => $admtext['mrca'], "fact" => $anc_namestr]);
    } else {
        if ($dnarow['MRC_ancestorID'][0] == $tngconfig['familyprefix']) {
            $query = "SELECT familyID, husband, wife, living, private, marrdate, gedcom, branch FROM $families_table WHERE familyID = \"{$dnarow['MRC_ancestorID']}\" AND gedcom = \"{$dnarow['gedcom']}\"";
            $result = tng_query($query);
            $famrow = tng_fetch_assoc($result);
            tng_free_result($result);

            $righttree = checktree($dnarow['gedcom']);
            $rightbranch = checkbranch($famrow['branch']);
            $rights = determineLivingPrivateRights($famrow, $righttree, $rightbranch);
            $famrow['allow_living'] = $rights['living'];
            $famrow['allow_private'] = $rights['private'];

            $famname = getFamilyName($famrow);
            $anc_namestr = "<a href=\"familygroup.php?familyID={$dnarow['MRC_ancestorID']}&tree={$dnarow['gedcom']}\">$famname</a>";
            $anc_namestr = $text['family'] . ": " . "<a href=\"familygroup.php?familyID={$dnarow['MRC_ancestorID']}&tree={$dnarow['gedcom']}\">$famname</a>";
            $dnatext .= showEvent(["text" => $admtext['mrca'], "fact" => $anc_namestr]);
        }
    }
}

if ($dnarow['markers']) {
    $dnatext .= showEvent(["text" => $admtext['markers'], "fact" => $dnarow['markers']]);
}
if ($dnarow['y_results']) {
    $dnatext .= "<tr>\n";
    $dnatext .= "<td class=\"fieldnameback fieldname align-top\">" . nl2br($admtext['marker_values']) . "&nbsp;</td>\n";
    $dnatext .= "<td class='databack resultscol' colspan=\"2\">{$dnarow['y_results']}</td>\n";
    $dnatext .= "</tr>\n";
}
if ($dnarow['ydna_haplogroup']) {
    if ($dnarow['ydna_confirmed']) {
        $dnarow['haplogroup'] = "<span class='confirmed_haplogroup'>" . $dnarow['ydna_haplogroup'] . " - " . $text['confirmed'] . "</span>";
    } else {
        $dnarow['ydna_haplogroup'] = "<span class='predicted_haplogroup'>" . $dnarow['ydna_haplogroup'] . " - " . $text['predicted'] . "</span>";
    }
    $dnatext .= showEvent(["text" => $admtext['ydna_haplogroup'], "fact" => $dnarow['ydna_haplogroup']]);
}
if ($dnarow['mtdna_haplogroup']) {
    if ($dnarow['mtdna_confirmed']) {
        $dnarow['haplogroup'] = "<span class='confirmed_haplogroup'>" . $dnarow['mtdna_haplogroup'] . " - " . $text['confirmed'] . "</span>";
    } else {
        $dnarow['mtdna_haplogroup'] = "<span class='predicted_haplogroup'>" . $dnarow['mtdna_haplogroup'] . " - " . $text['predicted'] . "</span>";
    }
    $dnatext .= showEvent(["text" => $admtext['mtdna_haplogroup'], "fact" => $dnarow['mtdna_haplogroup']]);
}
if ($dnarow['significant_snp']) {
    $dnatext .= showEvent(["text" => $admtext['signsnp'], "fact" => $dnarow['significant_snp']]);
}
if ($dnarow['terminal_snp']) {
    $dnatext .= showEvent(["text" => $admtext['termsnp'], "fact" => $dnarow['terminal_snp']]);
}
if ($dnarow['ref_seq']) {
    $fact = $dnarow['ref_seq'] == "rsrs" ? $admtext['rsrs'] : $admtext['rcrs'];
    $dnatext .= showEvent(["text" => $admtext['ref_seq'], "fact" => $fact]);
}
if ($dnarow['hvr1_results']) {
    $dnatext .= showEvent(["text" => $admtext['hvr1_values'], "fact" => $dnarow['hvr1_results']]);
}
if ($dnarow['hvr2_results']) {
    $dnatext .= showEvent(["text" => $admtext['hvr2_values'], "fact" => $dnarow['hvr2_results']]);
}
if ($dnarow['xtra_mut']) {
    $dnatext .= showEvent(["text" => $admtext['xtra_mut'], "fact" => $dnarow['xtra_mut']]);
}
if ($allow_admin && $dnarow['coding_reg']) {
    $dnatext .= showEvent(["text" => $admtext['coding_reg'], "fact" => $dnarow['coding_reg']]);
}
if ($allow_admin) {
    if ($dnarow['shared_cMs']) {
        $total_shared = $admtext['shared centimorgans'] . "  " . $dnarow['shared_cMs'];
        if ($dnarow['shared_segments']) {
            $total_shared .= " | " . $dnarow['shared_segments'] . " " . $admtext['shared_segments'];
        } else {
            $total_shared .= "";
        }
        $dnatext .= showEvent(["text" => $admtext['shared_dna'], "fact" => $total_shared]);
    }
    if ($dnarow['chromosome'] && $dnarow['centiMorgans']) {
        $segment = "{$admtext['chromosome']}  {$dnarow['chromosome']}  | {$dnarow['centiMorgans']}  {$admtext['centiMorgans']} ";
        $dnatext .= showEvent(["text" => $admtext['largest_segment'], "fact" => $segment]);
    }
    if ($dnarow['segment_start']) {
        $dnatext .= showEvent(["text" => $admtext['segment_start'], "fact" => $dnarow['segment_start']]);
    }
    if ($dnarow['segment_end']) {
        $dnatext .= showEvent(["text" => $admtext['segment_end'], "fact" => $dnarow['segment_end']]);
    }
    if ($dnarow['matching_SNPs']) {
        $dnatext .= showEvent(["text" => $admtext['matchingSNPs'], "fact" => $dnarow['matching_SNPs']]);
    }
    if ($dnarow['relationship_range']) {
        $dnatext .= showEvent(["text" => $admtext['relationship_range'], "fact" => $dnarow['relationship_range']]);
    }
    if ($dnarow['suggested_relationship']) {
        $dnatext .= showEvent(["text" => $admtext['suggested_relationship'], "fact" => $dnarow['suggested_relationship']]);
    }
    if ($dnarow['actual_relationship']) {
        $dnatext .= showEvent(["text" => $admtext['actual_relationship'], "fact" => $dnarow['actual_relationship']]);
    }
    if ($dnarow['related_side']) {
        $dnatext .= showEvent(["text" => $admtext['related_side'], "fact" => $dnarow['related_side']]);
    }
    if ($dnarow['x_match']) {
        $dnatext .= showEvent(["text" => $admtext['xmatch'], "fact" => $admtext['yes']]);
    }
}
if ($dnarow['surnames']) {
    $dnarow['surnames'] = $ancsurnameupper ? strtoupper($dnarow['surnames']) : $dnarow['surnames'];
    $dnatext .= showEvent(["text" => $admtext['ancestral_surnames'], "fact" => $dnarow['surnames']]);
}

if ($dnarow['urls']) {
    $urls = showLinks($dnarow['urls']);
    if ($urls) {
        $urls = "<ul>$urls</ul>";
    }
    $dnatext .= "<tr>\n";
    $dnatext .= "<td class=\"fieldnameback fieldname align-top\">{$text['links']}&nbsp;</td>\n";
    $dnatext .= "<td class='databack' colspan=\"2\">$urls</td>\n";
    $dnatext .= "</tr>\n";
}
//urls
if ($dnarow['medialinks']) {
    $medialinks = showMediaLinks($dnarow['medialinks']);
    $dnatext .= "<tr>\n";
    $dnatext .= "<td class=\"fieldnameback fieldname align-top\">{$admtext['medialinks']}&nbsp;</td>\n";
    $dnatext .= "<td class='databack' colspan=\"2\">$medialinks</td>\n";
    $dnatext .= "</tr>\n";
}
if ($dnarow['notes']) {
    $dnatext .= "<tr>\n";
    $dnatext .= "<td class=\"fieldnameback fieldname align-top\">" . nl2br($text['notes']) . "&nbsp;</td>\n";
    $dnatext .= "<td class='databack' colspan=\"2\"><div class=\"notearea\">{$dnarow['notes']}</div></td>\n";
    $dnatext .= "</tr>\n";
}
if ($allow_admin && $dnarow['admin_notes']) {
    $dnatext .= "<tr>\n";
    $dnatext .= "<td class=\"fieldnameback fieldname align-top\">" . nl2br($admtext['admin_notes']) . "&nbsp;</td>\n";
    $dnatext .= "<td class='databack' colspan=\"2\"><div class=\"notearea\">{$dnarow['admin_notes']}</div></td>\n";
    $dnatext .= "</tr>\n";
}

if (isset($soffset)) {
    $soffsetstr = "$soffset, ";
    $newsoffset = $soffset + 1;
} else {
    $soffsetstr = "";
    $newsoffset = 0;
}

$query = "SELECT $dna_links_table.personID, lastname, lnprefix, firstname, birthdate, birthdatetr, birthplace, altbirthdate, altbirthdatetr, altbirthplace,
		deathdate, deathdatetr, deathplace, burialdate, burialdatetr, burialplace,
		IF(birthdatetr !='0000-00-00',birthdatetr,altbirthdatetr) as birth,
		IF(deathdatetr !='0000-00-00',deathdatetr,burialdatetr) as death,
		prefix, suffix, nameorder, $dna_links_table.gedcom, branch, living, private
	FROM $dna_links_table, $people_table
	WHERE testID = \"$testID\" AND $dna_links_table.personID = $people_table.personID AND $dna_links_table.gedcom = $people_table.gedcom
	ORDER BY birth DESC, lastname, firstname LIMIT $soffsetstr" . ($maxsearchresults + 1);
$presult = tng_query($query);
$numrows = tng_num_rows($presult);
if (!$numrows) {
    $rightbranch = true;
}

$dnalinktext = "";
while ($prow = tng_fetch_assoc($presult)) {
    if ($dnalinktext) {
        $dnalinktext .= "\n";
    }
    $righttree = checktree($prow['gedcom']);
    $rightbranch = $righttree ? checkbranch($prow['branch']) : false;
    $rights = determineLivingPrivateRights($prow, $righttree, $rightbranch);
    $prow['allow_living'] = $rights['living'];
    $prow['allow_private'] = $rights['private'];
    $vitalinfo = $rights['both'] ? getBirthInfo($prow) : "";
    $name = "<a href=\"getperson.php?personID={$prow['personID']}&amp;tree={$prow['gedcom']}\">" . getName($prow) . "</a>" . $vitalinfo;
    if ($dnarow['private_dna'] && !$allow_edit && ($prow['personID'] == $dnarow['personID'])) {
        $name = $admtext['text_private'];
    }
    $dnalinktext .= $name;
}
if ($numrows >= $maxsearchresults) {
    $dnalinktext .= "\n[<a href=\"show_dna_test.php?testID=$testID&amp;foffset=$foffset&amp;soffset=" . ($newsoffset + $maxsearchresults) . "\">{$text['morelinks']}</a>]";
}
tng_free_result($presult);

if ($dnalinktext) {
    $dnatext .= showEvent(["text" => $text['indlinked'], "fact" => $dnalinktext]);
}

$dnatext .= "</table>\n";
$dnatext .= "<br>\n";
$dnatext .= endSection("info");

$dnatext .= "</ul>\n";

$innermenu = "<span class=\"lightlink3\" id=\"tng_plink\">{$text['test_info']}</span>\n";

$emailaddr = "";
echo tng_menu("D", "dna", $testID, $innermenu);
?>

<?php
echo $dnatext;
?>
    <br>

<?php
tng_footer($flags);
?>