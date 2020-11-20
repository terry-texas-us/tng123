<?php
include "begin.php";
include "adminlib.php";
require_once "./admin/trees.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
if (!$allow_edit) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

$orderedTreesList = new OrderedTreesList($trees_table, $assignedtree);
$tree = $orderedTreesList->getAssignedTree();

$query = "SELECT * FROM $dna_tests_table WHERE testID = \"$testID\"";
$result = tng_query($query);
$row = tng_fetch_assoc($result);
tng_free_result($result);

if ($row['personID']) {
    $query = "SELECT personID, gedcom, firstname, lnprefix, lastname, prefix, suffix, nameorder, living, private, branch ";
    $query .= "FROM $people_table ";
    $query .= "WHERE personID = '{$row['personID']}' AND gedcom = '{$row['gedcom']}'";
    $result = tng_query($query);
    $row2 = tng_fetch_assoc($result);
    $row2['allow_living'] = $row2['allow_private'] = 1;
    $takername = "(" . getName($row2) . ")";
    tng_free_result($result);
} else {
    $takername = "";
}

if ($row['MD_ancestorID']) {
    $query = "SELECT personID, gedcom, firstname, lnprefix, lastname, prefix, suffix, nameorder, living, private, branch ";
    $query .= "FROM $people_table ";
    $query .= "WHERE personID = '{$row['MD_ancestorID']}' AND gedcom = '{$row['gedcom']}'";
    $result = tng_query($query);
    $row3 = tng_fetch_assoc($result);
    $row3['allow_living'] = $row3['allow_private'] = 1;
    $mdancestorname = "(" . getName($row3) . ")";
    tng_free_result($result);
} else {
    $mdancestorname = "";
}
if ($row['MRC_ancestorID']) {
    if ($row['MRC_ancestorID'][0] == $tngconfig['personprefix']) {
        $query = "SELECT personID, gedcom, firstname, lnprefix, lastname, prefix, suffix, nameorder, living, private, branch ";
        $query .= "FROM $people_table ";
        $query .= "WHERE personID = '{$row['MRC_ancestorID']}' AND gedcom = '{$row['gedcom']}'";
        $result = tng_query($query);
        $row3 = tng_fetch_assoc($result);
        $row3['allow_living'] = $row3['allow_private'] = 1;
        $mrcancestorname = "(" . getName($row3) . ")";
        tng_free_result($result);
    } else {
        if ($row['MRC_ancestorID'][0] == $tngconfig['familyprefix']) {
            $query = "SELECT familyID, husband, wife, living, private, marrdate, gedcom, branch ";
            $query .= "FROM $families_table ";
            $query .= "WHERE familyID = '{$row['MRC_ancestorID']}' AND gedcom = '{$row['gedcom']}'";
            $result = tng_query($query);
            $row3 = tng_fetch_assoc($result);
            tng_free_result($result);

            $row3['allow_living'] = $row3['allow_private'] = 1;

            $mrcancestorname = "(" . getFamilyName($row3) . ")";
        }
    }
} else {
    $mrcancestorname = _('If relevant, enter a person ID OR a family ID');
}

$query = "SELECT dna_links.ID AS mlinkID, dna_links.personID AS personID, lastname, lnprefix, firstname, prefix, suffix, nameorder, dna_links.gedcom AS gedcom, branch, treename, living, private ";
$query .= "FROM $dna_links_table dna_links ";
$query .= "LEFT JOIN $trees_table trees ON dna_links.gedcom = trees.gedcom ";
$query .= "LEFT JOIN $people_table people ON dna_links.personID = people.personID AND dna_links.gedcom = people.gedcom ";
$query .= "WHERE testID = \"$testID\" ";
$query .= "ORDER BY dna_links.ID DESC";
$result2 = tng_query($query);
$numlinks = tng_num_rows($result2);

$helplang = findhelp("dna_help.php");

tng_adminheader(_('Edit Existing DNA Test'), $flags);

echo "</head>\n";
echo tng_adminlayout();

$dnatabs[0] = [1, "admin_dna_tests.php", _('Search'), "findtest"];
$dnatabs[1] = [$allow_add, "admin_new_dna_test.php", _('Add New'), "addtest"];
$dnatabs[2] = [$allow_edit, "#", _('Edit'), "edit"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/dna_help.php#add');\" class='lightlink'>" . _('Help for this area') . "</a> ";
$innermenu .= "&nbsp;|&nbsp;<a href='#' class='lightlink' onClick=\"return toggleAll('on');\">" . _('Expand all') . "</a> &nbsp;|&nbsp; <a href='#' class='lightlink' onClick=\"return toggleAll('off');\">" . _('Collapse all') . "</a>";
$menu = doMenu($dnatabs, "edit", $innermenu);
echo displayHeadline(_('DNA Tests') . " &gt;&gt; " . _('Edit Existing DNA Test'), "img/dna_icon.gif", $menu, "");

$surnamesarr = [];
$surnamesexc = [];
$surnamesexc = explode(',', $surnameexcl);
$pass1 = true;

function get_ancestor_surnames($personID, $tree, $type) {
    global $people_table, $families_table, $surnamesarr, $surnamesexc, $pass1;

    $select = "SELECT people.lastname, people.famc, family.husband, family.wife ";
    $select .= "FROM $people_table people ";
    $select .= "LEFT JOIN $families_table family ON (people.famc = family.familyID AND people.gedcom = family.gedcom) ";
    $select .= "WHERE people.personID = '" . $personID . "' AND people.gedcom = '" . $tree . "'";
    $result = tng_query($select);
    while ($surrow = tng_fetch_assoc($result)) {
        $father = ($type != "mtDNA") ? $surrow['husband'] : "";
        $mother = ($type != "Y-DNA") ? $surrow['wife'] : "";
        if (!in_array($surrow['lastname'], $surnamesarr) && !in_array($surrow['lastname'], $surnamesexc) && !$pass1) {
            array_push($surnamesarr, $surrow['lastname']);
        }
        $pass1 = false;
        if ($father) get_ancestor_surnames($father, $tree, $type);

        if ($mother) get_ancestor_surnames($mother, $tree, $type);

    }
    tng_free_result($result);
    if ($type == "atDNA") sort($surnamesarr);

    return implode(', ', $surnamesarr);
}

$atsurnamesarr = [];
$atsurnamesexc = [];
$atsurnamesexc = explode(',', $surnameexcl);
$perID = [];
include "tngdblib.php";

function get_atdna_ancestor_surnames($personID, $tree, $type) {
    global $atsurnamesarr, $atsurnamesexc, $perID, $numgens;

    $perID[0] = $personID;

    for ($a = 0; $a <= $numgens; $a++) {
        for ($b = 0; $b < pow(2, $a); $b++) {
            if (isset($perID[pow(2, $a) + $b - 1])) {
                $tID = pow(2, $a) + $b - 1;
                $result = getPersonFullPlusDates($tree, $perID[$tID]);
                $row = tng_fetch_assoc($result);
                $perName[$tID] = $row['lastname'];
                if (!in_array($perName[$tID], $atsurnamesarr) && !in_array($perName[$tID], $atsurnamesexc)) {
                    array_push($atsurnamesarr, $perName[$tID]);
                }
                $result = getFamilyData($tree, $row['famc']);
                $rowM = tng_fetch_assoc($result);
                $h = 2 * ($tID) + 1;
                $w = 2 * ($tID) + 2;
                $perID[$h] = $rowM['husband'];
                $perID[$w] = $rowM['wife'];
            }
        }
    }
    tng_free_result($result);
    return implode(', ', $atsurnamesarr);
}

?>

<form action="admin_update_dna_test.php" method="post" name="form1" id="form1" onsubmit="return validateForm();">
    <table class="lightback">
        <tr class="databack">
            <td class="tngshadow">
                <?php echo displayToggle("plus0", 1, "testinfo", _('Test Information'), _('Upload a new file from your computer, or select from files already on your site')); ?>

                <div id="testinfo">
                    <br>
                    <table class="normal">
                        <tr>
                            <td><?php echo _('Test Type'); ?>:</td>
                            <td>
                                <select name="test_type" id="test_type">
                                    <option value=""></option>
                                    <option value="atDNA"<?php if ($row['test_type'] == "atDNA") {
                                        echo " selected";
                                    } ?>><?php echo _('atDNA (autosomal) Tests'); ?></option>
                                    <option value="Y-DNA"<?php if ($row['test_type'] == "Y-DNA") {
                                        echo " selected";
                                    } ?>><?php echo _('Y-DNA Tests'); ?></option>
                                    <option value="mtDNA"<?php if ($row['test_type'] == "mtDNA") {
                                        echo " selected";
                                    } ?>><?php echo _('mtDNA (Mitochondrial) Tests'); ?></option>
                                    <option value="X-DNA"<?php if ($row['test_type'] == "X-DNA") {
                                        echo " selected";
                                    } ?>><?php echo _('X-DNA'); ?></option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Test Number/Name'); ?>:</td>
                            <td>
                                <input type="text" name="test_number" value="<?php echo $row['test_number']; ?>" class="medfield">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Vendor'); ?>:</td>
                            <td>
                                <input type="text" name="vendor" value="<?php echo $row['vendor']; ?>" class="medfield">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Test Date'); ?>:</td>
                            <td>
                                <input type="text" name="test_date" value="<?php echo formatInternalDate($row['test_date']); ?>" class="w-64"
                                    onblur="checkDate(this);">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Match Date'); ?>:</td>
                            <td>
                                <input type="text" name="match_date" value="<?php echo formatInternalDate($row['match_date']); ?>" class="medfield"
                                    onblur="checkDate(this);">
                            </td>
                        </tr>
                        <?php if ($row['test_type'] == "atDNA") { ?>
                            <tr>
                                <td><?php echo _('GEDmatch ID'); ?>:</td>
                                <td>
                                    <input type="text" name="GEDmatchID" value="<?php echo $row['GEDmatchID']; ?>" id="GEDmatchID" class="medfield">
                                </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td><strong><?php echo _('Keep Test Private'); ?>:</strong>&nbsp;</td>
                            <td>
                                <select name="private_test">
                                    <option value="0"<?php if (!$row['private_test']) {
                                        echo " selected";
                                    } ?>><?php echo _('No'); ?></option>
                                    <option value="1"<?php if ($row['private_test']) {
                                        echo " selected";
                                    } ?>><?php echo _('Yes'); ?></option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><br><strong><?php echo _('Person who took this test'); ?></strong></td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo _('Tree'); ?>:
                            </td>
                            <td>
                                <select name="mynewgedcom">
                                    <option value=""></option>
                                    <?php echo $orderedTreesList->getSelectOptionsHtml($row['gedcom']); ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo "" . _('AND') . " " . _('Person ID') . " "; ?>:</td>
                            <td>
                                <input type="text" name="personID" value="<?php echo $row['personID']; ?>" id="personID" size="20" maxlength="22">
                                &nbsp;<span><?php echo $takername; ?></span>&nbsp;<?php echo _('OR'); ?>&nbsp;
                                <a href="#"
                                    onclick="return findItem('I','personID','',document.form1.mynewgedcom.options[document.form1.mynewgedcom.selectedIndex].value,'<?php echo $assignedbranch; ?>');"
                                    title="<?php echo _('Find...'); ?>">
                                    <img src="img/tng_find.gif" title="<?php echo _('Find...'); ?>" alt="<?php echo _('Find...'); ?>"
                                        class="align-middle" width="20" height="20" style="margin-left:2px; margin-bottom:4px;">
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo "" . _('OR') . " " . _('Person not in database') . " "; ?></td>
                            <td>
                                <input type="text" name="person_name" value="<?php echo $row['person_name']; ?>" id="person_name" size="40" maxlength="100">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong><?php echo _('Keep Name Private'); ?>:</strong>&nbsp;<input type="checkbox" name="private_dna"
                                    value="1"<?php if ($row['private_dna']) {
                                    echo " checked=\"$checked\"";
                                } ?>>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td><strong><?php echo _('Add Test To A Group'); ?>:</strong>&nbsp;</td>
                            <td>
                                <select name="dna_group">
                                    <option value=""><?php echo _('No encryption'); ?></option>
                                    <?php
                                    $groupsquery = "SELECT * FROM $dna_groups_table WHERE `test_type` = \"{$row['test_type']}\" ORDER BY description";
                                    $groupsresult = tng_query($groupsquery);
                                    $numgrouprows = tng_num_rows($groupsresult);
                                    while ($groupsrow = tng_fetch_assoc($groupsresult)) {
                                        if ($row['dna_group'] == $groupsrow['dna_group']) {
                                            $selectgrp = "selected";
                                        } else {
                                            $selectgrp = "";
                                        }
                                        echo "	<option value=\"{$groupsrow['dna_group']}\" $selectgrp>{$groupsrow['description']} </option>\n";
                                    }
                                    tng_free_result($groupsresult);
                                    ?>
                                </select>
                            <td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <?php if ($row['test_type'] == "Y-DNA") { ?>
                            <tr>
                                <td><?php echo _('Number of Markers'); ?>:</td>
                                <td>
                                    <input type="text" name="markers" value="<?php echo $row['markers']; ?>" class="medfield">
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Marker values'); ?>:<br><?php echo _('Separate values with commas'); ?>
                                    :<br><?php echo _('Use dashes between multi-values'); ?></td>
                                <td><textarea cols="90" rows="3" name="y_results"><?php echo $row['y_results']; ?></textarea></td>
                            </tr>
                        <?php } ?>
                        <?php if ($row['test_type'] == "mtDNA" || $row['test_type'] == "atDNA") {
                            $mt_checkedstr = ($row['mtdna_confirmed']) ? "checked" : ""; ?>
                            <tr>
                                <td><?php echo _('mtDNA Haplogroup'); ?>:</td>
                                <td>
                                    <input type="text" name="mtdna_haplogroup" value="<?php echo $row['mtdna_haplogroup']; ?>" class="w-64">&nbsp;&nbsp;<?php echo _('Confirmed'); ?>
                                    :&nbsp;<input type="checkbox" name="mtdna_confirmed"
                                        value="1" <?php echo $mt_checkedstr; ?>>
                                </td>
                            </tr>
                        <?php }
                        if ($row['test_type'] == "Y-DNA" || $row['test_type'] == "atDNA") {
                            $y_checkedstr = ($row['ydna_confirmed']) ? "checked" : ""; ?>
                            <tr>
                                <td><?php echo _('Y-DNA Haplogroup'); ?>:</td>
                                <td>
                                    <input type="text" name="ydna_haplogroup" value="<?php echo $row['ydna_haplogroup']; ?>" class="medfield">&nbsp;&nbsp;<?php echo _('Confirmed'); ?>
                                    :&nbsp;<input type="checkbox" name="ydna_confirmed"
                                        value="1" <?php echo $y_checkedstr; ?>>
                                </td>
                            </tr>
                        <?php } ?>

                        <?php if ($row['test_type'] == "mtDNA") { ?>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>
                            <tr>
                                <td><strong><?php echo _('Reference sequence'); ?>:</strong>&nbsp;</td>
                                <td>
                                    <select name="ref_seq">
                                        <option value=""<?php if ($row['ref_seq'] == "") {
                                            echo " selected";
                                        } ?>></option>
                                        <option value="rsrs"<?php if ($row['ref_seq'] == "rsrs") {
                                            echo " selected";
                                        } ?>><?php echo _('RSRS (Reconstructed Sapiens Reference Sequence)'); ?></option>
                                        <option value="rcrs"<?php if ($row['ref_seq'] == "rcrs") {
                                            echo " selected";
                                        } ?>><?php echo _('rCRS (revised Cambridge Reference Sequence)'); ?></option>
                                    </select></td>
                            </tr>
                            <tr>
                                <td><?php echo _('HVR1 Differences'); ?>:</td>
                                <td>
                                    <input type="text" name="hvr1_results" value="<?php echo $row['hvr1_results']; ?>"
                                        style="width:700px;">&nbsp;<?php echo _('Separate values with commas'); ?></td>
                            </tr>
                            <tr>
                                <td><?php echo _('HVR2 Differences'); ?>:</td>
                                <td>
                                    <input type="text" name="hvr2_results" value="<?php echo $row['hvr2_results']; ?>"
                                        style="width:700px;">&nbsp;<?php echo _('Separate values with commas'); ?></td>
                            </tr>
                            <tr>
                                <td><?php echo _('Extra mutations'); ?>:</td>
                                <td>
                                    <input type="text" name="xtra_mut" value="<?php echo $row['xtra_mut']; ?>"
                                        style="width:700px;">&nbsp;<?php echo _('Separate values with commas'); ?></td>
                            </tr>
                            <tr>
                                <td><?php echo _('Coding region differences'); ?>:</td>
                                <td><textarea cols="69" rows="2"
                                        name="coding_reg"><?php echo $row['coding_reg']; ?></textarea>&nbsp;<?php echo _('Separate values with commas'); ?>
                                </td>
                            </tr>
                        <?php } ?>
                        <?php if ($row['test_type'] == "Y-DNA") { ?>
                            <tr>
                                <td><?php echo _('Significant SNPs'); ?>:</td>
                                <td>
                                    <input type="text" name="signsnp" value="<?php echo $row['significant_snp']; ?>" class="medfield">
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Terminal SNP'); ?>:</td>
                                <td>
                                    <input type="text" name="termsnp" value="<?php echo $row['terminal_snp']; ?>" class="medfield">
                                </td>
                            </tr>
                        <?php } ?>
                        <?php if ($row['test_type'] == "atDNA") { ?>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="2"><br><strong><?php echo _('Shared DNA'); ?></strong></td>
                            </tr>
                            <tr>
                                <td><?php echo _('Total shared cMs'); ?>:</td>
                                <td>
                                    <input type="text" name="shared_cMs" value="<?php echo $row['shared_cMs']; ?>" id="shared_cMs" size="20"
                                        maxlength="22">
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Shared segments'); ?>:</td>
                                <td>
                                    <input type="text" name="shared_segments" value="<?php echo $row['shared_segments']; ?>" id="shared_segments"
                                        size="20" maxlength="22">
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2"><br><strong><?php echo _('Largest Segment'); ?></strong></td>
                            </tr>
                            <tr>
                                <td><?php echo _('Chr'); ?>:</td>
                                <td>
                                    <input type="text" name="chromosome" value="<?php echo $row['chromosome']; ?>" id="chromosome" size="20"
                                        maxlength="22">
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Segment Start'); ?>:</td>
                                <td>
                                    <input type="text" name="segment_start" value="<?php echo $row['segment_start']; ?>" id="segment_start" size="20"
                                        maxlength="22">
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('End'); ?>:</td>
                                <td>
                                    <input type="text" name="segment_end" value="<?php echo $row['segment_end']; ?>" id="segment_end" size="20"
                                        maxlength="22">
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('cM'); ?>:</td>
                                <td>
                                    <input type="text" name="centiMorgans" value="<?php echo $row['centiMorgans']; ?>" id="centiMorgans" size="20"
                                        maxlength="22">
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Matching SNPs'); ?>:</td>
                                <td>
                                    <input type="text" name="matching_SNPs" value="<?php echo $row['matching_SNPs']; ?>" id="matching_SNPs" size="20"
                                        maxlength="22">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="2"><br><strong><?php echo _('Relationship Section'); ?></strong></td>
                            </tr>
                            <tr>
                                <td><?php echo _('Relationship Range'); ?>:</td>
                                <td>
                                    <input type="text" name="relationship_range" value="<?php echo $row['relationship_range']; ?>"
                                        id="relationship_range" size="80" maxlength="80">
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Suggested'); ?>:</td>
                                <td>
                                    <input type="text" name="suggested_relationship" value="<?php echo $row['suggested_relationship']; ?>"
                                        id="suggested_relationship" size="80" maxlength="80">
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Actual'); ?>:</td>
                                <td>
                                    <input type="text" name="actual_relationship" value="<?php echo $row['actual_relationship']; ?>"
                                        id="actual_relationship" size="40" maxlength="40">
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Related Branch'); ?>:</td>
                                <td>
                                    <input type="text" name="related_side" value="<?php echo $row['related_side']; ?>" id="related_side" size="40"
                                        maxlength="40">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>
                            <tr>
                                <td><strong><?php echo _('X-Match'); ?>:</strong>&nbsp;</td>
                                <td>
                                    <select name="x_match">
                                        <option value="0"<?php if (!$row['x_match']) {
                                            echo " selected";
                                        } ?>><?php echo _('No'); ?></option>
                                        <option value="1"<?php if ($row['x_match']) {
                                            echo " selected";
                                        } ?>><?php echo _('Yes'); ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td colspan="2"><br><strong><?php echo _('Most distant ancestor ID'); ?></strong></td>
                        </tr>
                        <tr>
                            <td><?php echo _('Person ID'); ?>:</td>
                            <td>
                                <input type="text" name="MD_ancestorID" value="<?php echo $row['MD_ancestorID']; ?>" id="MD_ancestorID" size="20"
                                    maxlength="22">
                                <span>&nbsp;<?php echo $mdancestorname; ?></span>&nbsp;&nbsp;<?php echo _('OR'); ?>
                                &nbsp;
                                <a href="#"
                                    onclick="return findItem('I','MD_ancestorID','',document.form1.mynewgedcom.options[document.form1.mynewgedcom.selectedIndex].value,'<?php echo $assignedbranch; ?>');"
                                    title="<?php echo _('Find...'); ?>">
                                    <img src="img/tng_find.gif" title="<?php echo _('Find...'); ?>" alt="<?php echo _('Find...'); ?>"
                                        class="align-middle" width="20" height="20" style="margin-left:2px; margin-bottom:4px;">
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2"><br><strong><?php echo _('Most recent common ancestor ID'); ?></strong></td>
                        </tr>
                        <tr>
                            <td><?php echo _('Search for'); ?></td>
                            <td>
                                <input type="radio" name="mrcatype" value="I" checked="checked"
                                    onclick="activateMrcaType('I');"> <?php echo _('Person'); ?> &nbsp;&nbsp;
                                <input type="radio" name="mrcatype" value="F" onclick="activateMrcaType('F');"> <?php echo _('Family'); ?>
                            </td>
                        </tr>

                        <tr>
                            <td><span id="person_label"><?php echo _('Person ID'); ?></span><span id="family_label"
                                    style="display:none;"><?php echo _('Family ID'); ?></span>:
                            </td>
                            <td class='align-top'>
                                <input type="text" name="MRC_ancestorID" value="<?php echo $row['MRC_ancestorID']; ?>" id="MRC_ancestorID">
                                &nbsp;<?php echo $mrcancestorname; ?></span>&nbsp;&nbsp;<?php echo _('OR'); ?>&nbsp;
                                <a href="#"
                                    onclick="return findItem(mrcaType,'MRC_ancestorID','',document.form1.mynewgedcom.options[document.form1.mynewgedcom.selectedIndex].value,'<?php echo $assignedbranch; ?>');"
                                    title="<?php echo _('Find...'); ?>">
                                    <img src="img/tng_find.gif" title="<?php echo _('Find...'); ?>" alt="<?php echo _('Find...'); ?>"
                                        class="align-middle" width="20" height="20" style="margin-left:2px; margin-bottom:4px;">
                                </a>
                            </td>
                        </tr>

                        <?php
                        if ((!$row['surnames'] && $row['test_type'] != "atDNA") && $autofillancsurnames && $row['personID']) {
                            $ancestorstr = get_ancestor_surnames($row['personID'], $row['gedcom'], $row['test_type']);
                        } else {
                            if ((!$row['surnames'] && $row['test_type'] == "atDNA") && $autofillancsurnames && $row['personID']) {
                                $ancestorstr = get_atdna_ancestor_surnames($row['personID'], $row['gedcom'], $row['test_type']);
                            } else {
                                $ancestorstr = $row['surnames'];
                            }
                        }
                        if ($ancsurnameupper) $ancestorstr = strtoupper($ancestorstr);

                        ?>
                        <tr>
                            <td class='align-top'><?php echo _('Ancestral surnames'); ?>:</td>
                            <td><textarea cols="90" rows="10" name="surnames"><?php echo $ancestorstr; ?></textarea></td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class='align-top'><?php echo _('Notes'); ?>:</td>
                            <td><textarea cols="90" rows="10" name="notes"><?php echo $row['notes']; ?></textarea></td>
                        </tr>
                        <tr>
                            <td class='align-top'><?php echo _('Administrator notes'); ?>:</td>
                            <td><textarea cols="90" rows="10" name="admin_notes"><?php echo $row['admin_notes']; ?></textarea></td>
                        </tr>
                        <tr>
                            <td class='align-top'><?php echo _('Relevant Links'); ?>:</td>
                            <td><textarea cols="90" rows="3" name="urls"><?php echo $row['urls']; ?></textarea></td>
                        </tr>
                        <tr>
                            <td class='align-top'><?php echo _('Media Links'); ?>:</td>
                            <td><textarea cols="90" rows="3" name="medialinks"><?php echo $row['medialinks']; ?></textarea></td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td><strong><?php echo _('Test Information To Display'); ?>:</strong>&nbsp;</td>
                            <td>
                                <?php if ($row['test_type'] != "X-DNA") { ?>
                                    <input type="checkbox" name="markeropt" value="1"<?php if ($row['markeropt']) {
                                        echo " checked=\"$checked\"";
                                    } ?>>&nbsp;<?php echo _('Test Results'); ?>&nbsp;&nbsp;
                                <?php } ?>
                                <input type="checkbox" name="notesopt" value="1"<?php if ($row['notesopt']) {
                                    echo " checked=\"$checked\"";
                                } ?>>&nbsp;<?php echo _('Notes'); ?>&nbsp;&nbsp;
                                <input type="checkbox" name="linksopt" value="1"<?php if ($row['linksopt']) {
                                    echo " checked=\"$checked\"";
                                } ?>>&nbsp;<?php echo _('Relevant Links'); ?>&nbsp;&nbsp;
                                <input type="checkbox" name="surnamesopt" value="1"<?php if ($row['surnamesopt']) {
                                    echo " checked=\"$checked\"";
                                } ?>>&nbsp;<?php echo _('Ancestral surnames'); ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>

        <tr class="databack">
            <td class="tngshadow" id="linkstd">
                <?php echo displayToggle("plus2", 1, "links", _('People Linked by this Test') . " (<span id=\"linkcount\">$numlinks</span>)", _('Link this item to People, Families, Sources, Repositories or Places')); ?>

                <?php include "micro_dnalinks.php"; ?>
            </td>
        </tr>

        <tr class="databack">
            <td class="tngshadow normal">
                <input type="hidden" value="<?php echo "$cw"; ?>" name="cw">
                <input type="hidden" value="<?php echo $row['testID']; ?>" name="testID">
                <input type="hidden" value="<?php echo $row['personID']; ?>" name="personID_org">
                <?php
                echo _('On save') . ":<br>";
                echo "<input type='radio' name=\"newtest\" value='return'> " . _('Return to this page') . "<br>\n";
                if ($cw) {
                    echo "<input type='radio' name=\"newtest\" value=\"close\" checked> " . _('Close this window') . "\n";
                } else {
                    echo "<input type='radio' name=\"newtest\" value=\"none\" checked> " . _('Return to menu') . "\n";
                }
                ?>
                <br><br>
                <input type="submit" name="submitbtn" class="btn" accesskey="s" value="<?php echo _('Save'); ?>">
            </td>
        </tr>

    </table>
</form>
<?php echo "<div style=\"text-align: center;\"><span class='normal'>$tng_title</span></div>"; ?>
<script>
    var tree = "<?php echo $tree; ?>";
    var tnglitbox;
    <?php
    echo "var linkcount = $numlinks;\n";
    echo "const confdellink = \"" . _('Are you sure you want to delete this link?') . "\";\n";
    echo "const remove_text = \"" . _('Remove Link') . "\";\n";
    ?>

    function validateForm() {
        let rval = true;
//req: test number, test type
        var frm = document.form1;
        if (!frm.test_type.selectedIndex) {
            alert("<?php echo _('Please select a test type.'); ?>");
            rval = false;
        }
//removed test_number alert
        return rval;
    }

    function toggleAll(display) {
        toggleSection('testinfo', 'plus0', display);
        return false;
    }
</script>
<script src="js/datevalidation.js"></script>
<script src="js/selectutils.js"></script>
<script src="js/dna_tests.js"></script>
<script>
    var preferEuro = <?php echo($tngconfig['preferEuro'] ? $tngconfig['preferEuro'] : "false"); ?>;
    var preferDateFormat = '<?php echo $preferDateFormat; ?>';
    var findform = document.form1;
</script>
</body>
</html>