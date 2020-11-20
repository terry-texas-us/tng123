<?php
// PDF Family Report
// Author: Bret Rumsey
//
include "begin.php";
include "genlib.php";
include "getlang.php";

$tngprint = 1;
include "checklogin.php";
include "personlib.php";

define('FPDF_FONTPATH', $rootpath . $endrootpath . 'font/');
require 'tngpdf.php';
require 'rpt_utils.php';
$pdf = new TNGPDF($orient, 'in', $pagesize);
setcookie("tng_pagesize", $pagesize, time() + 31536000, "/");

$uni = $session_charset == "UTF-8";

// load fonts
$pdf->AddFont($rptFont, '', '', $uni);
$pdf->AddFont($rptFont, "B", '', $uni);

// define formatting defaults
$lineheight = $pdf->GetFontSize($rptFont, $rptFontSize) + 0.1;  // height of each row on the page
$shading = 220;              // value of shaded lines (255 = white, 0 = black)

$ldsOK = determineLDSRights(true);

// compute the label width based on the longest string that will be displayed
$labelwidth = getMaxStringWidth([_('Name'), _('Born'), _('Christened'), _('Died'), _('Buried'), _('Cremated'), _('Spouse'), _('Married')], $rptFont, "B", $lblFontSize, ':');
if ($ldsOK) {
    $labelwidth = getMaxStringWidth([_('Baptized (LDS)'), _('Endowed (LDS)'), _('Sealed to Spouse (LDS)')], $rptFont, "B", $lblFontSize, ':', $labelwidth);
}

// header and footer config
if ($blankform == 1) {
    $title = _('Family Group Sheet for');
} else {
    $query = "SELECT familyID, husband, wife, living, private, marrdate, gedcom, branch FROM $families_table WHERE familyID = '$familyID' AND gedcom = '$tree'";
    $result = tng_query($query);
    if ($result) {
        $famrow = tng_fetch_assoc($result);
        $famname = getFamilyName($famrow);

        $righttree = checktree($tree);
        $rights = determineLivingPrivateRights($famrow, $righttree);
        $famrow['allow_living'] = $rights['living'];
        $famrow['allow_private'] = $rights['private'];

        $title = _('Family Group Sheet for') . " $famname";
    }
}
$pdf->SetTitle($title);
$titleConfig = ['title' => $title,
    'font' => $rptFont,
    'fontSize' => $hdrFontSize,
    'justification' => 'L',
    'lMargin' => $lftmrg,
    'skipFirst' => false,
    'header' => false,
    'line' => false];
$footerConfig = ['font' => $rptFont,
    'fontSizeLarge' => 8,
    'fontSizeSmall' => 6,
    'printWordPage' => true,
    'bMargin' => $botmrg,
    'lMargin' => $lftmrg,
    'skipFirst' => false,
    'line' => false];

// set margins
$pdf->SetTopMargin($topmrg);
$pdf->SetLeftMargin($lftmrg);
$pdf->SetRightMargin($rtmrg);
$pdf->SetAutoPageBreak(1, $botmrg + $pdf->GetFooterHeight() + $lineheight); // this sets the bottom margin for us
$pdf->SetFillColor($shading);

// PDF settings
$pdf->SetAuthor($dbowner);

// let's get started
$pdf->AddPage();
$paperdim = $pdf->GetPageSize();

// citation vars
$citations = [];
$citedisplay = [];
$citestring = [];

// create a blank form if that's what they asked for
if ($blankform == 1) {
    nameLine(_('Father'), '', 1, '');
    dateLine(_('Born'), '', '', '');
    dateLine(_('Christened'), '', '', '');
    dateLine(_('Died'), '', '', '');
    dateLine(_('Buried'), '', '', '');
    if ($ldsOK) {
        dateLine(_('Baptized (LDS)'), '', '', '');
        dateLine(_('Endowed (LDS)'), '', '', '');
    }
    parentLine(_('Father'), '', _('Mother'), '', '', '');
    dateLine(_('Married'), '', '');
    if ($ldsOK) dateLine(_('Sealed to Spouse (LDS)'), '', '');

    nameLine(_('Mother'), '', 1, '');
    dateLine(_('Born'), '', '', '');
    dateLine(_('Christened'), '', '', '');
    dateLine(_('Died'), '', '', '');
    dateLine(_('Buried'), '', '', '');
    if ($ldsOK) {
        dateLine(_('Baptized (LDS)'), '', '', '');
        dateLine(_('Endowed (LDS)'), '', '', '');
    }
    parentLine(_('Father'), '', _('Mother'), '', '', '');
    titleLine(_('Children'));
    for ($i = 1; $i <= 3; $i++) {
        childNameLine($i, '', '', '');
        dateLine(_('Born'), '', '', '');
        dateLine(_('Christened'), '', '', '');
        dateLine(_('Died'), '', '', '');
        dateLine(_('Buried'), '', '', '');
        if ($ldsOK) {
            dateLine(_('Baptized (LDS)'), '', '', '');
            dateLine(_('Endowed (LDS)'), '', '', '');
        }
        spouseLine(_('Spouse'), $spousename, $marrplace, $cite1, $cite2);
    }
} // create a filled in form
else {
    if ($rights['both'] && $citesources) {
        getCitations($familyID, 0);
        $citekey = $familyID . "_";
        $cite = reorderCitation($citekey);
    }

    // husband & spouses
    if ($famrow['husband']) {
        displayIndividual($famrow['husband'], 1, 1);
        titleLine(_('Children'));

        // for each child
        $query = "SELECT $people_table.personID AS personID, branch, firstname, lnprefix, lastname, prefix, suffix, nameorder, living, private, famc, sex, birthdate, birthplace, altbirthdate, altbirthplace, haskids, deathdate, deathplace, burialdate, burialplace, burialtype, baptdate, baptplace, confdate, confplace, initdate, initplace, endldate, endlplace, sealdate, sealplace FROM $people_table, $children_table WHERE $people_table.personID = $children_table.personID AND $children_table.familyID = \"{$famrow['familyID']}\" AND $people_table.gedcom = '$tree' AND $children_table.gedcom = '$tree' ORDER BY ordernum";
        $children = tng_query($query);
        if ($children && tng_num_rows($children)) {
            $childcount = 0;
            while ($childrow = tng_fetch_assoc($children)) {
                $childcount++;
                displayChild($childrow['personID'], $childcount);
            }
        }
    }

    // notes and such
    // draw the box to contain the notes
    pageBox();
    titleLine(_('General'));
    $titleConfig['header'] = _('General') . ' ' . _('(cont.)');
    $titleConfig['headerFont'] = $rptFont;
    $titleConfig['headerFontSize'] = $lblFontSize;
    $titleConfig['outline'] = true;

    if ($rights['both']) {
        $famnotes = getNotes($familyID, 'F');
        $notes = '';
        $lasttitle = '---';
        foreach ($famnotes as $key => $note) {
            if ($note['title'] != $lasttitle) {
                if ($notes) $notes .= "\n\n";

                if ($note['title']) $notes .= $note['title'] . "\n";

            }
            $notes .= $note['text'];
        }
        $notes = preg_replace("/&nbsp;/", ' ', $notes);
        $notes = preg_replace("/<li>/", '* ', $notes);
        $notes = preg_replace("/<br\s*\/?>/", "", $notes);
        if (!isset($allowable_tags)) $allowable_tags = "<a>";
        $notes = strip_tags($notes, $allowable_tags);

        $pdf->Ln(0.05);
        $pdf->SetFont($rptFont, '', $rptFontSize);
        $pdf->MultiCell($paperdim['w'] - $rtmrg - $lftmrg, $pdf->GetFontSize(), $notes, 0, 'L', 0, 0);
    }
    // create the citations page
    if ($citesources) {
        $titleConfig['header'] = _('Sources');
        $titleConfig['headerFont'] = $rptFont;
        $titleConfig['headerFontSize'] = $lblFontSize;
        $titleConfig['outline'] = true;
        $pdf->AddPage();
        $titleConfig['header'] = _('Sources') . ' ' . _('(cont.)');

        // reduce the font
        $pdf->SetFont($rptFont, '', $rptFontSize - 2);

        // push in our left margin a bit
        $pdf->SetLeftMargin($lftmrg * 1.5);
        $citectr = 1;
        foreach ($citestring as $cite) {
            $cite = strip_tags($cite);
            $cite = preg_replace("/\n/", " ", $cite);
            $pdf->MultiCell($paperdim['w'] - $rtmrg - ($lftmrg * 1.5), $pdf->GetFontSize(), "$citectr. $cite\n\n", 0, 'L', 0, 0);
            $citectr++;
        }
    }
}

// print it out
$pdf->Output();

function displayChild($personID, $childcount) {
    global $tree, $people_table, $families_table, $children_table, $citesources, $righttree;

    $query = "SELECT * FROM $people_table WHERE personID = \"$personID\" AND gedcom = '$tree'";
    $result = tng_query($query);
    $ind = tng_fetch_assoc($result);
    tng_free_result($result);

    $rights = determineLivingPrivateRights($ind, $righttree);
    $ind['allow_living'] = $rights['living'];
    $ind['allow_private'] = $rights['private'];

    $label = $ind['sex'] != "F" ? _('Father') : _('Mother');

    if ($citesources && $rights['both']) getCitations($personID, 0);


    // name
    $cite = reorderCitation($personID . "_NAME", 0);
    childNameLine($childcount, $ind['sex'], getName($ind) . " ({$ind['personID']})", $cite);

    // birth
    if ($rights['both']) {
        $cite = reorderCitation($personID . "_BIRT", 0);
        dateLine(_('Born'), displayDate($ind['birthdate']), $ind['birthplace'], $cite);
    } else {
        dateLine(_('Born'), '', '');
    }
    // christening
    if ($rights['both']) {
        $cite = reorderCitation($personID . "_CHR", 0);
        dateLine(_('Christened'), displayDate($ind['altbirthdate']), $ind['altbirthplace'], $cite);
    } else {
        dateLine(_('Christened'), '', '');
    }
    // death
    if ($rights['both']) {
        $cite = reorderCitation($personID . "_DEAT", 0);
        dateLine(_('Died'), displayDate($ind['deathdate']), $ind['deathplace'], $cite);
    } else {
        dateLine(_('Died'), '', '');
    }
    // buried
    $burialmsg = $ind['burialtype'] ? _('Cremated') : _('Buried');
    if ($rights['both']) {
        $cite = reorderCitation($personID . "_BURI", 0);
        dateLine($burialmsg, displayDate($ind['burialdate']), $ind['burialplace'], $cite);
    } else {
        dateLine($burialmsg, '', '');
    }
    if ($rights['lds']) {
        if ($rights['both']) {
            $cite = reorderCitation($personID . "_BAPL", 0);
            dateLine(_('Baptized (LDS)'), displayDate($ind['baptdate']), $ind['baptplace'], $cite);
            $cite = reorderCitation($personID . "_CONF", 0);
            dateLine(_('Confirmed (LDS)'), displayDate($row['confdate']), $ind['confplace'], $cite);
            $cite = reorderCitation($personID . "_INIT", 0);
            dateLine(_('Initiatory (LDS)'), displayDate($row['initdate']), $ind['initplace'], $cite);
            $cite = reorderCitation($personID . "_ENDL", 0);
            dateLine(_('Endowed (LDS)'), displayDate($ind['endldate']), $ind['endlplace'], $cite);

            $query = "SELECT sealdate, sealplace FROM $children_table WHERE familyID = \"{$ind['famc']}\" AND personID = \"$personID\" AND gedcom = '$tree'";
            $chresult = tng_query($query);
            $child = tng_fetch_assoc($chresult);
            getCitations($personID . "::" . $ind['famc'], 0);
            $cite = reorderCitation($personID . "::" . $ind['famc'] . "_SLGC", 0);
            dateLine(_('Sealed to Parents (LDS)'), displayDate($child['sealdate']), $child['sealplace'], $cite);
            tng_free_result($chresult);
        } else {
            dateLine(_('Baptized (LDS)'), '', '');
            dateLine(_('Endowed (LDS)'), '', '');
        }
    }

    // show spouses
    $query = "SELECT familyID, personID, firstname, lnprefix, lastname, prefix, suffix, nameorder, families.living AS fliving, families.private AS fprivate, families.branch AS fbranch, people.living AS living, people.private AS private, people.branch AS branch, marrdate, marrplace, sealdate, sealplace ";
    $query .= "FROM $families_table families ";
    if ($ind['sex'] == "M") {
        $query .= "LEFT JOIN $people_table people ON families.wife = people.personID AND families.gedcom = people.gedcom WHERE husband = \"{$ind['personID']}\" AND people.gedcom = '$tree' $restriction ORDER BY husborder";
    } else {
        if ($ind['sex'] = "F") {
            $query .= "LEFT JOIN $people_table people ON families.husband = people.personID AND families.gedcom = people.gedcom WHERE wife = \"{$ind['personID']}\" AND people.gedcom = '$tree' $restriction ORDER BY wifeorder";
        } else {
            $query .= "LEFT JOIN $people_table people ON (families.husband = people.personID OR families.wife = people.personID) AND families.gedcom = people.gedcom WHERE (wife = \"{$ind['personID']}\" && husband = \"{$ind['personID']}\") AND people.gedcom = '$tree'";
        }
    }

    $spresult = tng_query($query);

    while ($fam = tng_fetch_assoc($spresult)) {
        $frights = determineLivingPrivateRights($fam, $righttree);
        $fam['allow_living'] = $frights['living'];
        $fam['allow_private'] = $frights['private'];

        $spousename = getName($fam);
        $fam['living'] = $fam['fliving'];
        $fam['private'] = $fam['fprivate'];

        $frights = determineLivingPrivateRights($fam, $righttree);

        $marrplace = "";
        if ($frights['both']) {
            $marrplace = $fam['marrdate'];
            if (!empty($fam['marrplace'])) {
                if ($marrplace != '') $marrplace .= ' - ';

                $marrplace .= $fam['marrplace'];
            }
        }

        if ($citesources && $frights['both']) {
            getCitations($fam['familyID'], 0);
            getCitations($fam['personID'], 0);
            $cite1 = reorderCitation($fam['personID'] . "_NAME", 0);
            $cite2 = reorderCitation($fam['familyID'] . "_MARR", 0);
        }
        spouseLine(_('Spouse'), $spousename . " ({$fam['personID']})", $marrplace, $cite1, $cite2);
        if ($frights['lds']) {
            if ($frights['both']) {
                dateLine(_('Sealed to Spouse (LDS)'), displayDate($fam['sealdate']), $fam['sealplace']);
            } else {
                dateLine(_('Sealed to Spouse (LDS)'), '', '');
            }
        }
    }
    tng_free_result($spresult);
}

/**
 * @param $personID
 * @param $showparents
 * @param $showmarriage
 */
function displayIndividual($personID, $showparents, $showmarriage) {
    global $familyID, $tree, $people_table, $families_table, $children_table, $citesources, $righttree;

    $query = "SELECT * FROM $people_table WHERE personID = \"$personID\" AND gedcom = '$tree'";
    $result = tng_query($query);
    $ind = tng_fetch_assoc($result);
    tng_free_result($result);

    $rights = determineLivingPrivateRights($ind, $righttree);
    $ind['allow_living'] = $rights['living'];
    $ind['allow_private'] = $rights['private'];

    $label = $ind['sex'] != "F" ? _('Father') : _('Mother');

    if ($citesources && $rights['both']) getCitations($personID, 0);


    // name
    $cite = reorderCitation($personID . "_NAME", 0);
    nameLine($label, getName($ind) . " ({$ind['personID']})", 1, $cite);
    // birth
    if ($rights['both']) {
        $cite = reorderCitation($personID . "_BIRT", 0);
        dateLine(_('Born'), displayDate($ind['birthdate']), $ind['birthplace'], $cite);
    } else {
        dateLine(_('Born'), '', '', '');
    }
    // christening
    if ($rights['both']) {
        $cite = reorderCitation($personID . "_CHR", 0);
        dateLine(_('Christened'), displayDate($ind['altbirthdate']), $ind['altbirthplace'], $cite);
    } else {
        dateLine(_('Christened'), '', '');
    }
    // death
    if ($rights['both']) {
        $cite = reorderCitation($personID . "_DEAT", 0);
        dateLine(_('Died'), displayDate($ind['deathdate']), $ind['deathplace'], $cite);
    } else {
        dateLine(_('Died'), '', '');
    }
    // buried
    if ($rights['both']) {
        $cite = reorderCitation($personID . "_BURI", 0);
        $burialmsg = $ind['burialtype'] ? _('Cremated') : _('Buried');
        dateLine($burialmsg, displayDate($ind['burialdate']), $ind['burialplace'], $cite);
    } else {
        dateLine(_('Buried'), '', '');
    }
    if ($rights['lds']) {
        if ($rights['both']) {
            $cite = reorderCitation($personID . "_BAPL", 0);
            dateLine(_('Baptized (LDS)'), displayDate($ind['baptdate']), $ind['baptplace'], $cite);
            $cite = reorderCitation($personID . "_CONF", 0);
            dateLine(_('Confirmed (LDS)'), displayDate($row['confdate']), $ind['confplace'], $cite);
            $cite = reorderCitation($personID . "_INIT", 0);
            dateLine(_('Initiatory (LDS)'), displayDate($row['initdate']), $ind['initplace'], $cite);
            $cite = reorderCitation($personID . "_ENDL", 0);
            dateLine(_('Endowed (LDS)'), displayDate($ind['endldate']), $ind['endlplace'], $cite);
        } else {
            dateLine(_('Baptized (LDS)'), '', '');
            dateLine(_('Endowed (LDS)'), '', '');
        }
    }

    if ($showparents) {
        //show parents (for hus&wif)
        $cite1 = $cite2 = "";
        $query = "SELECT YEAR(birthdatetr) AS birthyear, YEAR(deathdatetr) AS deathyear, familyID, personID, firstname, lnprefix, lastname, prefix, suffix, nameorder, people.living, people.private, people.branch ";
        $query .= "FROM $families_table families, $people_table people ";
        $query .= "WHERE families.familyID = \"{$ind['famc']}\" AND families.gedcom = '$tree' AND people.personID = families.husband AND people.gedcom = '$tree'";
        $presult = tng_query($query);
        $parent = tng_fetch_assoc($presult);

        $prights = determineLivingPrivateRights($parent, $righttree);
        $parent['allow_living'] = $prights['living'];
        $parent['allow_private'] = $prights['private'];

        $fathername = getName($parent) . generateYears($parent);
        $fatherID = $parent['personID'];
        tng_free_result($presult);

        if ($citesources && $prights['both']) {
            getCitations($fatherID, 0);
            $cite1 = reorderCitation($fatherID . "_NAME", 0);
        }

        $query = "SELECT YEAR(birthdatetr) AS birthyear, YEAR(deathdatetr) AS deathyear, familyID, personID, firstname, lnprefix, lastname, prefix, suffix, nameorder, people.living, people.private, people.branch ";
        $query .= "FROM $families_table families, $people_table people ";
        $query .= "WHERE families.familyID = \"{$ind['famc']}\" AND families.gedcom = '$tree' AND people.personID = families.wife AND people.gedcom = '$tree'";
        $presult = tng_query($query);
        $parent = tng_fetch_assoc($presult);

        $prights = determineLivingPrivateRights($parent, $righttree);
        $parent['allow_living'] = $prights['living'];
        $parent['allow_private'] = $prights['private'];

        $mothername = getName($parent) . generateYears($parent);
        $motherID = $parent['personID'];
        tng_free_result($presult);

        if ($citesources && $prights['both']) {
            getCitations($motherID, 0);
            $cite2 = reorderCitation($motherID . "_NAME", 0);
        }
        parentLine(_('Father'), $fathername . " ($fatherID)", _('Mother'), $mothername . " ($motherID)", $cite1, $cite2);
        if ($rights['lds'] && $rights['both']) {
            $query = "SELECT sealdate, sealplace FROM $children_table WHERE familyID = \"{$ind['famc']}\" AND personID = \"$personID\" AND gedcom = '$tree'";
            $chresult = tng_query($query);
            $child = tng_fetch_assoc($chresult);
            $cite = reorderCitation($personID . "::" . $ind['famc'] . "_SLGC", 0);
            dateLine(_('Sealed to Parents (LDS)'), displayDate($child['sealdate']), $child['sealplace'], $cite);
            tng_free_result($chresult);
        }
    }

    if ($showmarriage) {
        // marriages
        $query = "SELECT husband, wife, marrdate, marrplace, divdate, divplace, sealdate, sealplace, living, private, branch FROM $families_table WHERE familyID = '$familyID' AND gedcom = '$tree'";
        $result = tng_query($query);
        $fam = tng_fetch_assoc($result);

        $frights = determineLivingPrivateRights($fam, $righttree);
        $fam['allow_living'] = $frights['living'];
        $fam['allow_private'] = $frights['private'];

        tng_free_result($result);

        // married
        if ($frights['both']) {
            $cite = reorderCitation($familyID . "_MARR", 0);
            dateLine(_('Married'), displayDate($fam['marrdate']), $fam['marrplace'], $cite);
        } else {
            dateLine(_('Married'), '', '');
        }
        if ($frights['lds']) {
            if ($frights['both']) {
                dateLine(_('Sealed to Spouse (LDS)'), displayDate($fam['sealdate']), $fam['sealplace']);
            } else {
                dateLine(_('Sealed to Spouse (LDS)'), '', '');
            }
        }
        displayIndividual($fam['wife'], 1, 0);
    }
}

// childNameLine
function childNameLine($label1, $data1, $data2, $cite = '') {
    global $pdf, $paperdim, $rtmrg, $lineheight;
    global $rptFont, $rptFontSize, $lblFontSize;
    global $labelwidth;

    $numwidth = 0.3;      // width of column for child number

    $pdf->SetFont($rptFont, "B", $lblFontSize);

    $pdf->CellFit($numwidth, $lineheight, "$label1", 1, 0, 'C', 1, '', 1, 0);
    $pdf->CellFit($labelwidth - $numwidth, $lineheight, $data1, 1, 0, 'C', 0, '', 1, 0);
    $pdf->SetFont($rptFont, "B", $rptFontSize);
    $origx = $pdf->GetX();
    $pdf->CellFit($paperdim['w'] - $pdf->GetX() - $rtmrg, $lineheight, $data2, 1, 0, 'L', 0, '', 1, 0);
    if ($cite != '') {
        $pdf->SetX($origx + $pdf->GetStringWidth($data2));
        $pdf->SetFont($rptFont, "B", $rptFontSize - 4);
        $pdf->Cell(0, $lineheight / 2, " $cite");
    }
    $pdf->Ln($lineheight);
}

// nameLine
function nameLine($label1, $data1, $shade = 0, $cite = '') {
    global $pdf, $paperdim, $rtmrg, $lineheight;
    global $rptFont, $rptFontSize, $lblFontSize;
    global $labelwidth;

    if ($shade) {
        $bold = "B";
    } else {
        $bold = '';
    }
    $pdf->SetFont($rptFont, $bold, $lblFontSize);
    $pdf->Cell($labelwidth, $lineheight, $label1, 1, 0, 'L', $shade);
    $pdf->SetFont($rptFont, $bold, $rptFontSize);
    $origx = $pdf->GetX();
    $pdf->CellFit($paperdim['w'] - $pdf->GetX() - $rtmrg, $lineheight, $data1, 1, 0, 'L', $shade, '', 1, 0);
    if ($cite != '') {
        $pdf->SetX($origx + $pdf->GetStringWidth($data1));
        $pdf->SetFont($rptFont, $bold, $rptFontSize - 4);
        $pdf->Cell(0, $lineheight / 2, " $cite");
    }
    $pdf->Ln($lineheight);
}

// spouseLine
function spouseLine($label1, $data1, $data2, $cite1 = '', $cite2 = '') {
    global $pdf, $paperdim, $lftmrg, $rtmrg, $lineheight;
    global $rptFont, $rptFontSize, $lblFontSize;
    global $labelwidth;

    $pdf->SetFont($rptFont, '', $rptFontSize);
    $width = $pdf->GetStringWidth($data1);
    if ($cite1 != '') {
        $pdf->SetFont($rptFont, '', $rptFontSize - 4);
        $width += $pdf->GetStringWidth("    $cite1");
    } else {
        $citewidth = 0;
    }

    $pdf->SetFont($rptFont, "B", $lblFontSize);
    $pdf->CellFit($labelwidth, $lineheight, $label1, 1, 0, 'L', 0, '', 1, 0);
    $pdf->SetFont($rptFont, '', $rptFontSize);
    $pdf->CellFit($width, $lineheight, $data1, 1, 0, 'L', 0, '', 1, 0);
    if ($cite1 != '') {
        $pdf->SetX($lftmrg + $labelwidth + $pdf->GetStringWidth($data1));
        $pdf->SetFont($rptFont, '', $rptFontSize - 4);
        $pdf->Cell(0, $lineheight / 2, " $cite1");
        $pdf->SetX($lftmrg + $labelwidth + $width);
        $pdf->SetFont($rptFont, '', $rptFontSize);
    }
    $pdf->CellFit($paperdim['w'] - $pdf->GetX() - $rtmrg, $lineheight, $data2, 1, 0, 'L', 0, '', 1, 0);
    if ($cite2 != '') {
        $pdf->SetX($lftmrg + $labelwidth + $width + $pdf->GetStringWidth($data2));
        $pdf->SetFont($rptFont, '', $rptFontSize - 4);
        $pdf->Cell(0, $lineheight / 2, " $cite2");
    }
    $pdf->Ln($lineheight);
}

// dateLine
function dateLine($label1, $data1, $data2, $cite = '') {
    global $pdf, $paperdim, $lftmrg, $rtmrg, $lineheight;
    global $rptFont, $rptFontSize, $lblFontSize;
    global $labelwidth;

    $datewidth = 1.5;  // width of date field, in inches

    $pdf->SetFont($rptFont, "B", $lblFontSize);
    $pdf->CellFit($labelwidth, $lineheight, $label1, 1, 0, 'L', 0, '', 1, 0);
    $pdf->SetFont($rptFont, '', $rptFontSize);
    $pdf->CellFit($datewidth, $lineheight, $data1, 1, 0, 'L', 0, '', 1, 0);
    $pdf->CellFit($paperdim['w'] - $pdf->GetX() - $rtmrg, $lineheight, $data2, 1, 0, 'L', 0, '', 1, 0);
    if ($cite != '') {
        if ($data2 == '') {
            $x = $labelwidth + $pdf->GetStringWidth($data1) + $lftmrg;
        } else {
            $x = $labelwidth + $datewidth + $pdf->GetStringWidth($data2) + $lftmrg;
        }
        $pdf->SetX($x);
        $pdf->SetFont($rptFont, '', $rptFontSize - 4);
        $pdf->Cell(0, $lineheight / 2, " $cite");
    }
    $pdf->Ln($lineheight);
}

// parentLine
function parentLine($label1, $data1, $label2, $data2, $cite1 = '', $cite2 = '') {
    global $pdf, $paperdim, $lftmrg, $rtmrg, $lineheight;
    global $rptFont, $rptFontSize, $lblFontSize;
    global $labelwidth;

    // set the width of the field for parent name to be half of whatever is left over
    $datawidth = ($paperdim['w'] - $lftmrg - $rtmrg - ($labelwidth * 2)) / 2;

    // determine if we can fit both mother and father on the same line
    $pdf->SetFont($rptFont, '', $rptFontSize);
    $fwidth = $pdf->GetStringWidth($data1);
    $mwidth = $pdf->GetStringWidth($data2);
    $pdf->SetFont($rptFont, '', $rptFontSize - 4);
    $fwidth += $pdf->GetStringWidth(" $cite1");
    $mwidth += $pdf->GetStringWidth(" $cite2");
    if ($fwidth > $datawidth || $mwidth > $datawidth) {
        nameLine($label1, $data1, 0, $cite1);
        nameLine($label2, $data2, 0, $cite2);
    } else {
        $pdf->SetFont($rptFont, "B", $lblFontSize);
        $pdf->CellFit($labelwidth, $lineheight, $label1, 1, 0, 'L', 0, '', 1, 0);
        $pdf->SetFont($rptFont, '', $rptFontSize);
        $origx = $pdf->GetX();
        $pdf->CellFit($datawidth, $lineheight, $data1, 1, 0, 'L', 0, '', 1, 0);
        $origend = $pdf->GetX();
        if ($cite1 != '') {
            $pdf->SetX($origx + $pdf->GetStringWidth($data1));
            $pdf->SetFont($rptFont, '', $rptFontSize - 4);
            $pdf->Cell(0, $lineheight / 2, " $cite1");
            $pdf->Setx($origend);
        }

        $pdf->SetFont($rptFont, "B", $lblFontSize);
        $pdf->CellFit($labelwidth, $lineheight, $label2, 1, 0, 'L', 0, '', 1, 0);
        $pdf->SetFont($rptFont, '', $rptFontSize);
        $origx = $pdf->GetX();
        $pdf->CellFit($datawidth, $lineheight, $data2, 1, 0, 'L', 0, '', 1, 0);
        if ($cite2 != '') {
            $pdf->SetX($origx + $pdf->GetStringWidth($data2));
            $pdf->SetFont($rptFont, '', $rptFontSize - 4);
            $pdf->Cell(0, $lineheight / 2, " $cite2");
        }
        $pdf->Ln($lineheight);
    }
}
