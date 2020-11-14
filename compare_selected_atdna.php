<?php

$textpart = "dna";
include "tng_begin.php";
include "adminlib.php";
include "personlib.php";
if ($tngconfig['hidedna'] && (!$allow_edit || !$allow_add || $assignedtree)) {
    header("Location: thispagedoesnotexist.html");
    exit;
}
$dnatree = isset($_SESSION["ttree"]) ? $_SESSION["ttree"] : "";
if (empty($_SESSION["ttree"])) {
    $_SESSION["ttree"] = "-x--all--x-";
}
$test_search = isset($_SESSION["tsearch"]) ? $_SESSION["tsearch"] : "";
$test_type = isset($_SESSION["ttype"]) ? $_SESSION["ttype"] : "";
$test_group = isset($_SESSION["tgroup"]) ? $_SESSION["tgroup"] : "";
$browse_dna_tests_url = "browse_dna_tests.php?tree=" . $dnatree . "&amp;testsearch=" . $test_search . "&amp;test_type=" . $test_type . "&amp;test_group=" . $test_group;
$headline = "" . _('Compare Y-DNA Tests') . "";
_('Compare selected atDNA Tests') .= $_SESSION["tgroup"] ? ": " . $_SESSION["tgroup"] : ": " . _('All Groups');
tng_header(_('Compare selected atDNA Tests'), $flags);
$comptabs[0] = [1, $browse_dna_tests_url, _('DNA Tests'), "dnatests"];
$innermenu = "";
$innermenu = "<a href=\"https://tng.lythgoes.net/wiki/index.php?title=Compare DNA Tests Results\" target='_blank' class='lightlink'>" . _('Help for this area') . "</a>";
// Y-DNA Tests
$innermenu .= "&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"browse_dna_tests.php?tree=-x--all--x-&testsearch=&test_type=Y-DNA&test_group=\" class='lightlink'>" . _('Y-DNA Tests') . "</a>";
// mtDNA Tests
$innermenu .= "&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"browse_dna_tests.php?tree=-x--all--x-&testsearch=&test_type=mtDNA&test_group=\" class='lightlink'>" . _('mtDNA (Mitochondrial) Tests') . "</a>";
// atDNA Tests
$innermenu .= "&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"browse_dna_tests.php?tree=-x--all--x-&testsearch=&test_type=atDNA&test_group=\" class='lightlink'>" . _('atDNA (autosomal) Tests') . "</a>";
$menu = doMenu($comptabs, "", $innermenu);
?>
<h2 class="header"><span class="headericon" id="dna-hdr-icon"></span><?php echo _('Compare selected atDNA Tests'); ?></h2>
<br style="clear: left;">
<?php
echo $menu;
if ($_SESSION["ttree"]) {
    $wherestr = "WHERE $dna_tests_table.gedcom = \"{$_SESSION["ttree"]}\"";
    $join = "INNER JOIN";
} else {
    $wherestr = "";
}
$join = "LEFT JOIN";
if (!empty($test_type)) {
    _('DNA Tests') = substr($test_type, 0, -3) . _('DNA Tests');
    if ($wherestr) {
        $wherestr .= " AND $dna_tests_table.test_type = \"{$test_type}\"";
    } else {
        $wherestr = "WHERE $dna_tests_table.test_type = \"{$test_type}\"";
    }
}
if ($_SESSION["tgroup"]) {
    _('DNA Tests') .= ": " . $_SESSION["tgroup"];
    if ($wherestr) {
        $wherestr .= " AND $dna_tests_table.dna_group_desc = \"{$_SESSION["tgroup"]}\"";
    } else {
        $wherestr = "WHERE $dna_tests_table.dna_group_desc = \"{$_SESSION["tgroup"]}\"";
    }
}
$treestr = $tree ? " (" . _('Tree') . ": $tree)" : "";
$logstring = "<a href=\"compare_selected_atdna.php?tree=$tree&amp;&amp;testsearch=$test_search\">" . xmlcharacters(_('Compare selected atDNA Tests') . $treestr) . "</a>";
writelog($logstring);
preparebookmark($logstring);
echo "<div class='normal'>\n";
?>
<table class='whiteback normal' cellpadding='3' cellspacing='1' border='0'>
    <div class="overflowauto">
        <table class="whiteback normal w-full" cellpadding="0" cellspacing="1">
            <thead>
            <tr>
                <?php
                if ($allow_edit || $showtestnumbers) { ?>
                    <th colspan="4" class="fieldnameback fieldname text-center">&nbsp;<?php echo _('DNA Test'); ?>&nbsp;</th>
                    <?php
                } else { ?>
                    <th colspan="3" class="fieldnameback fieldname text-center">&nbsp;<?php echo _('DNA Test'); ?>&nbsp;</th>
                <?php } ?>
                <th colspan="5" class="fieldnameback fieldname text-center">&nbsp;<?php echo _('Largest Segment'); ?>&nbsp;</th>
                <th colspan="2" class="fieldnameback fieldname text-center">&nbsp;<?php echo _('Haplogroup'); ?>&nbsp;</th>
                <th colspan="4" class="fieldnameback fieldname text-center">&nbsp;<?php echo _('Relationship'); ?>&nbsp;</th>
                <th class="fieldnameback fieldname text-center">&nbsp;</th>
            </tr>
            <tr>
                <th class="fieldnameback nbrcol fieldname">&nbsp;#&nbsp;</th>

                <?php
                if ($allow_edit || $showtestnumbers) { ?>
                    <th class="fieldnameback fieldname whitespace-no-wrap">&nbsp;<?php echo _('Test Number/Name'); ?>&nbsp;</th>
                <?php } ?>
                <th class="fieldnameback fieldname whitespace-no-wrap">&nbsp;<?php echo _('Taken by'); ?>&nbsp;</th>
                <th class="fieldnameback fieldname whitespace-no-wrap">&nbsp;<?php echo _('Vendor'); ?>&nbsp;</th>
                <th class="fieldnameback fieldname whitespace-no-wrap">&nbsp;<?php echo _('Chr'); ?>&nbsp;</th>
                <th class="fieldnameback fieldname whitespace-no-wrap">&nbsp;<?php echo _('Segment Start'); ?>&nbsp;</th>
                <th class="fieldnameback fieldname whitespace-no-wrap">&nbsp;<?php echo _('End'); ?>&nbsp;</th>
                <th class="fieldnameback fieldname whitespace-no-wrap">&nbsp;<?php echo _('cM'); ?>&nbsp;</th>
                <th class="fieldnameback fieldname whitespace-no-wrap">&nbsp;<?php echo _('SNPs'); ?>&nbsp;</th>
                <th class="fieldnameback fieldname whitespace-no-wrap">&nbsp;<?php echo _('Y-DNA'); ?>&nbsp;</th>
                <th class="fieldnameback fieldname whitespace-no-wrap">&nbsp;<?php echo _('mtDNA'); ?>&nbsp;</th>
                <th class="fieldnameback fieldname whitespace-no-wrap">&nbsp;<?php echo _('Suggested'); ?>&nbsp;</th>
                <th class="fieldnameback fieldname whitespace-no-wrap">&nbsp;<?php echo _('Actual'); ?>&nbsp;</th>
                <th class="fieldnameback fieldname whitespace-no-wrap">&nbsp;<?php echo _('MRC Ancestor'); ?>&nbsp;</th>
                <th class="fieldnameback fieldname whitespace-no-wrap">&nbsp;<?php echo _('Related Branch'); ?>&nbsp;</th>
                <th class="fieldnameback fieldname whitespace-no-wrap">&nbsp;<?php echo _('Test Group'); ?>&nbsp;</th>
                <?php
                global $numtrees;
                if (!$assignedtree && ($numtrees > 1)) { ?>
                    <th class="fieldnameback fieldname">&nbsp;<?php echo _('Tree'); ?>&nbsp;</th><?php } ?>
            </tr>
            </thead>
            <?php
            $i = 1;
            foreach (array_keys($_POST) as $key) {
                if (substr($key, 0, 3) == "dna") {
                    $testID = substr($key, 3);
                    $orderby = "chromosome,segment_start,segment_end";
                    $query = "SELECT *
	FROM $dna_tests_table WHERE testID=$testID ORDER BY 'chromosome,segment_start,segment_end' ";
                    $result = tng_query($query);
                    $row = tng_fetch_assoc($result);
                    //	add striping every other row
                    if (empty($databack) || $databack == "databack") {
                        $databack = "databackalt";
                    } else {
                        $databack = "databack";
                    }
                    echo "<tr>";
                    echo "<td class=\"$databack\">$i</td>\n";
                    if ($allow_edit || $showtestnumbers) {
                        if ($row['private_test']) {
                            $privtest = "<br>&nbsp;(" . _('Private') . ")";
                        } else {
                            $privtest = "";
                        }
                        echo "<td class=\"$databack\"><a href=\"show_dna_test.php?group=$test_group&amp;testID={$row['testID']}&amp;tree={$row['gedcom']}\">{$row['test_number']}</a>&nbsp;$privtest</td>";
                    }
                    $dna_pers_result = getPersonData($row['gedcom'], $row['personID']);
                    $dprow = tng_fetch_assoc($dna_pers_result);
                    $dna_righttree = checktree($dprow['gedcom']);
                    $dna_rightbranch = $dna_righttree ? checkbranch($dprow['branch']) : false;
                    $dprights = determineLivingPrivateRights($dprow, $dna_righttree, $dna_rightbranch);
                    $dprow['allow_living'] = $dprights['living'];
                    $dprow['allow_private'] = $dprights['private'];
                    $dbname = getName($dprow);
                    $person_name = $row['person_name'];
                    $dna_namestr = getName($dprow);
                    $vitalinfo = getBirthInfo($dprow);
                    if ($row['private_dna'] && $allow_edit) {
                        $privacy = "&nbsp;(" . _('Private') . ")";
                    } else {
                        $privacy = "";
                    }
                    if ($dbname) {
                        $dna_namestr = "<a href=\"getperson.php?personID={$row['personID']}&tree={$row['gedcom']}\">$dna_namestr</a>$privacy $vitalinfo";
                    } else {
                        $dna_namestr = $person_name . $privacy;
                    }
                    if ($row['private_dna'] && !$allow_edit) {
                        $dna_namestr = _('Private');
                    }
                    tng_free_result($dna_pers_result);
                    echo "<td class=\"$databack\">$dna_namestr&nbsp;</td>";
                    echo "<td class=\"$databack\">&nbsp;{$row['vendor']}</td>";
                    echo "<td class=\"$databack\">&nbsp;{$row['chromosome']}</td>";
                    echo "<td class=\"$databack\">&nbsp;{$row['segment_start']}</td>";
                    echo "<td class=\"$databack\">&nbsp;{$row['segment_end']}</td>";
                    echo "<td class=\"$databack\">&nbsp;{$row['centiMorgans']}</td>";
                    echo "<td class=\"$databack\">&nbsp;{$row['matching_SNPs']}</td>";
                    if ($row['ydna_haplogroup']) {
                        if ($row['ydna_confirmed']) {
                            $ydna_haplogroup = "<span class='confirmed_haplogroup'>" . $row['ydna_haplogroup'] . "</span>";
                        } else {
                            $ydna_haplogroup = "<span class='predicted_haplogroup'>" . $row['ydna_haplogroup'] . "</span>";
                        }
                    } else {
                        $ydna_haplogroup = "";
                    }
                    echo "<td class=\"$databack\">&nbsp;$ydna_haplogroup</td>";
                    if ($row['mtdna_haplogroup']) {
                        if ($row['mtdna_confirmed']) {
                            $mtdna_haplogroup = "<span class='confirmed_haplogroup'>" . $row['mtdna_haplogroup'] . "</span>";
                        } else {
                            $mtdna_haplogroup = "<span class='predicted_haplogroup'>" . $row['mtdna_haplogroup'] . "</span>";
                        }
                    } else {
                        $mtdna_haplogroup = "";
                    }
                    echo "<td class=\"$databack\">&nbsp;$mtdna_haplogroup</td>";
                    $anc_namestr = "";
                    $mrcanc_namestr = "";
                    if ($row['MRC_ancestorID']) {
                        if ($row['MRC_ancestorID'][0] == "I") {
                            $dna_anc_result = getPersonDataPlusDates($row['gedcom'], $row['MRC_ancestorID']);
                            $ancrow = tng_fetch_assoc($dna_anc_result);
                            $dna_righttree = checktree($ancrow['gedcom']);
                            $dna_rightbranch = $dna_righttree ? checkbranch($ancrow['branch']) : false;
                            $dprights = determineLivingPrivateRights($ancrow, $dna_righttree, $dna_rightbranch);
                            $ancrow['allow_living'] = $dprights['living'];
                            $ancrow['allow_private'] = $dprights['private'];
                            $anc_namestr = getName($ancrow);
                            $mrcanc_namestr = "<a href=\"getperson.php?personID={$row['MRC_ancestorID']}&tree={$row['gedcom']}\">$anc_namestr</a>";
                            tng_free_result($dna_anc_result);
                        } else {
                            if ($row['MRC_ancestorID'][0] == "F") {
                                $mrcquery = "SELECT familyID, husband, wife, living, private, marrdate, gedcom, branch FROM $families_table WHERE familyID = \"{$row['MRC_ancestorID']}\" AND gedcom = \"{$row['gedcom']}\"";
                                $mrcresult = tng_query($mrcquery);
                                $famrow = tng_fetch_assoc($mrcresult);
                                tng_free_result($mrcresult);
                                $righttree = checktree($row['gedcom']);
                                $rightbranch = checkbranch($famrow['branch']);
                                $rights = determineLivingPrivateRights($famrow, $righttree, $rightbranch);
                                $famrow['allow_living'] = $rights['living'];
                                $famrow['allow_private'] = $rights['private'];
                                $famname = getFamilyName($famrow);
                                $mrcanc_namestr = "<a href=\"familygroup.php?familyID={$row['MRC_ancestorID']}&tree={$row['gedcom']}\">$famname</a>";
                            }
                        }
                    }
                    echo "<td class=\"$databack\">&nbsp;{$row['suggested_relationship']}</td>";
                    echo "<td class=\"$databack\">&nbsp;{$row['actual_relationship']}</td>";
                    echo "<td class=\"$databack\">&nbsp;$mrcanc_namestr</td>";
                    echo "<td class=\"$databack\">&nbsp;{$row['related_side']}</td>";
                    $group = $row['dna_group_desc'] ? $row['dna_group_desc'] : _('No encryption');
                    echo "<td class=\"$databack\">$group</td>";
                    global $numtrees;
                    if (!$assignedtree && ($numtrees > 1)) {
                        echo "<td class='$databack whitespace-no-wrap'><a href=\"showtree.php?tree={$row['gedcom']}\">{$row['treename']}</a>&nbsp;</td>";
                    }
                    echo "</tr>\n";
                    $i++;
                }
            }
            if ($result) {
                tng_free_result($result);
            } else {
                echo "No records found.";
            }
            ?>
        </table>
    </div>
    <br>
    <?php
    tng_footer("");
    ?>
