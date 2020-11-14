<?php
// PDF Individual Report
// Author: Bret Rumsey
// Thanks to J. Kraber for his original implementation of this report.
//
$textpart = "getperson";
include "tng_begin.php";
$tngprint = 1;

include "personlib.php";

initMediaTypes();

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
$shading = 220;    // value of shaded lines (255 = white, 0 = black)
$citefontsub = 4;  // number of font pts to take off for superscript

$ldsOK = determineLDSRights(true);

// compute the label width based on the longest string that will be displayed
$labelwidth = getMaxStringWidth([_('Name'), _('Born'), _('Christened'), _('Died'), _('Buried'), _('Cremated'), _('Spouse'), _('Married')], $rptFont, "B", $lblFontSize, ':');
if ($ldsOK) {
    $labelwidth = getMaxStringWidth([_('Baptized (LDS)'), _('Endowed (LDS)'), _('Sealed to Spouse (LDS)')], $rptFont, "B", $lblFontSize, ':', $labelwidth);
}
$labelwidth += 0.1;

// create Header
if ($blankform == 1) {
    $title = _('Individual Report');
} else {
    $result = getPersonData($tree, $personID);
    if ($result) {
        $row = tng_fetch_assoc($result);

        $righttree = checktree($tree);
        $rights = determineLivingPrivateRights($row, $righttree);
        $row['allow_living'] = $rights['living'];
        $row['allow_private'] = $rights['private'];

        $namestr = getName($row);
    }

    $title = _('Individual Report for') . " $namestr ($personID)";
}

$pdf->SetTitle($title);
$titleConfig = ['title' => $title,
    'image' => $blankform ? "" : getPdfSmallPhoto($personID, $rights['living'] && $rights['private'], $row['sex']),
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

$citations = [];
$citedisplay = [];
$citestring = [];

// create a blank form if that's what they asked for
if ($blankform == 1) {
    nameLine(_('Name'), '', _('Gender'), '');
    doubleLine(_('Born'), '', _('Place'), '');
    if (!$tngconfig['hidechr']) {
        doubleLine(_('Christened'), '', _('Place'), '');
    }
    doubleLine(_('Died'), '', _('Place'), '');
    doubleLine(_('Buried'), '', _('Place'), '');
    if ($ldsOK) {
        doubleLine(_('Baptized (LDS)'), '', _('Place'), '');
        doubleLine(_('Endowed (LDS)'), '', _('Place'), '');
    }
    singleLine(_('Spouse'), '', "B");
    doubleLine(_('Married'), '', _('Place'), '');
    if ($ldsOK) doubleLine(_('Sealed to Spouse (LDS)'), '', _('Place'), '');

    childLine(1, '');
    childLine(2, '');
    childLine(3, '');
    childLine(4, '');
    childLine(5, '');
    $pdf->SetFont($rptFont, "B", $lblFontSize);
    pageBox();
    titleLine(_('General'));
} // create a filled in form
else {
    if ($citesources && $rights['both']) getCitations($personID, 0);


    $cite = reorderCitation($personID . "_", 0);
    $cite2 = reorderCitation($personID . "_NAME", 0);
    if ($cite2) $cite .= $cite ? ", $cite2" : $cite2;

    $gender = strtoupper($row['sex']);
    if ($gender == "M") {
        $gender = _('Male');
    } else {
        if ($gender == "F") {
            $gender = _('Female');
        } else {
            if ($gender == "U") {
                $gender = _('Unknown');
            } else {
                $gender = $row['sex'];
            }
        }
    }
    nameLine(_('Name'), $namestr, _('Gender'), $gender, $cite);
    if ($row['nickname']) singleLine(_('Nickname'), $row['nickname']);

    // birth
    if ($rights['both']) {
        $cite = reorderCitation($personID . "_BIRT", 0);
        doubleLine(_('Born'), displayDate($row['birthdate']), _('Place'), $row['birthplace'], $cite);

        if (!$tngconfig['hidechr']) {
            $cite = reorderCitation($personID . "_CHR", 0);
            doubleLine(_('Christened'), displayDate($row['altbirthdate']), _('Place'), $row['altbirthplace'], $cite);
        }

        $custevents = getPersonEventData($tree, $personID);
        while ($custevent = tng_fetch_assoc($custevents)) {
            $displayval = getEventDisplay($custevent['display']);
            $fact = [];
            if ($custevent['info']) {
                $fact = checkXnote($custevent['info']);
                if ($fact[1]) {
                    $xnote = $fact[1];
                    array_pop($fact);
                }
            }
            $done = false;
            if ($custevent['eventdate'] || $custevent['eventplace']) {
                $cite = reorderCitation($personID . "_" . $custevent['eventID'], 0);
                doubleLine($displayval, displayDate($custevent['eventdate']), _('Place'), $custevent['eventplace'], $cite);
                $done = true;
            }
            if ($custevent['info']) {
                if ($done) {
                    $cite = reorderCitation($personID . "_" . $custevent['eventID'], 0);
                    $displayval = _('(cont.)');
                } else {
                    $cite = "";
                }
                singleLine($displayval, $custevent['info'], "", $cite);
            }
        }
        tng_free_result($custevents);

        $cite = reorderCitation($personID . "_DEAT", 0);
        doubleLine(_('Died'), displayDate($row['deathdate']), _('Place'), $row['deathplace'], $cite);

        $cite = reorderCitation($personID . "_BURI", 0);
        $burialmsg = $row['burialtype'] ? _('Cremated') : _('Buried');
        doubleLine($burialmsg, displayDate($row['burialdate']), _('Place'), $row['burialplace'], $cite);
    } else {
        doubleLine(_('Born'), '', _('Place'), '');
        if (!$tngconfig['hidechr']) {
            doubleLine(_('Christened'), '', _('Place'), '');
        }
        doubleLine(_('Died'), '', _('Place'), '');
        doubleLine(_('Buried'), '', _('Place'), '');
    }

    if ($rights['lds']) {
        if ($rights['both']) {
            $cite = reorderCitation($personID . "_BAPL", 0);
            doubleLine(_('Baptized (LDS)'), displayDate($row['baptdate']), _('Place'), $row['baptplace'], $cite);
            $cite = reorderCitation($personID . "_CONF", 0);
            doubleLine(_('Confirmed (LDS)'), displayDate($row['confdate']), _('Place'), $row['confplace'], $cite);
            $cite = reorderCitation($personID . "_INIT", 0);
            doubleLine(_('Initiatory (LDS)'), displayDate($row['initdate']), _('Place'), $row['initplace'], $cite);
            $cite = reorderCitation($personID . "_ENDL", 0);
            doubleLine(_('Endowed (LDS)'), displayDate($row['endldate']), _('Place'), $row['endlplace'], $cite);
        } else {
            doubleLine(_('Baptized (LDS)'), '', _('Place'), '');
            doubleLine(_('Endowed (LDS)'), '', _('Place'), '');
        }
    }

    // do parents
    $parents = getChildParentsFamily($tree, $personID);
    if ($parents && tng_num_rows($parents)) {
        $titleConfig = ['title' => $title,
            'font' => $rptFont,
            'fontSize' => $hdrFontSize,
            'justification' => 'L',
            'lMargin' => $lftmrg,
            'skipFirst' => false,
            'line' => false];
        while ($parent = tng_fetch_assoc($parents)) {
            $gotfather = getParentSimplePlusDates($tree, $parent['familyID'], "husband");
            if ($gotfather) {
                $fathrow = tng_fetch_assoc($gotfather);

                $frights = determineLivingPrivateRights($fathrow, $righttree);
                $fathrow['allow_living'] = $frights['living'];
                $fathrow['allow_private'] = $frights['private'];

                if ($fathrow['firstname'] || $fathrow['lastname']) {
                    $fathname = getName($fathrow);
                }
                $fathtext = generateDates($fathrow);
                if ($citesources && $frights['both']) {
                    getCitations($fathrow['personID'], 0);
                }
                $cite = reorderCitation($fathrow['personID'] . "_", 0);
                $cite2 = reorderCitation($fathrow['personID'] . "_NAME", 0);
                if ($cite2) $cite .= $cite ? ", $cite2" : $cite2;

                singleLine(_('Father'), "$fathname $fathtext", '', $cite);
            } else {
                singleLine(_('Father'), '');
            }

            $gotmother = getParentSimplePlusDates($tree, $parent['familyID'], "wife");
            if ($gotmother) {
                $mothrow = tng_fetch_assoc($gotmother);

                $mrights = determineLivingPrivateRights($mothrow, $righttree);
                $mothrow['allow_living'] = $mrights['living'];
                $mothrow['allow_private'] = $mrights['private'];

                if ($mothrow['firstname'] || $mothrow['lastname']) {
                    $mothname = getName($mothrow);
                }
                $mothtext = generateDates($mothrow);
                if ($citesources && $mrights['both']) {
                    getCitations($mothrow['personID'], 0);
                }
                $cite = reorderCitation($mothrow['personID'] . "_", 0);
                $cite2 = reorderCitation($mothrow['personID'] . "_NAME", 0);
                if ($cite2) $cite .= $cite ? ", $cite2" : $cite2;

                singleLine(_('Mother'), "$mothname $mothtext", '', $cite);
            } else {
                singleLine(_('Mother'), '');
            }

            if ($rights['lds']) {
                if ($rights['both']) {
                    doubleLine(_('Sealed to Parents (LDS)'), displayDate($parent['sealdate']), _('Place'), $row['sealplace']);
                } else {
                    doubleLine(_('Sealed to Parents (LDS)'), '', _('Place'), '');
                }
            }
        }
    } // print two empty fields
    else {
        singleLine(_('Father'), '');
        singleLine(_('Mother'), '');
    }

    if ($row['sex'] == 'M') {
        $spouse = 'wife';
        $spouseorder = 'husborder';
        $self = "husband";
    } else {
        if ($row['sex'] == 'F') {
            $spouse = 'husband';
            $spouseorder = 'wifeorder';
            $self = "wife";
        } else {
            $spouseorder = '';
        }
    }
    if ($spouseorder) {
        $marriages = getSpouseFamilyDataPlusDates($tree, $self, $personID, $spouseorder);
    } else {
        $marriages = getSpouseFamilyDataUnionPlusDates($tree, $personID);
    }
    if (!tng_num_rows($marriages) && $spouseorder) {
        $marriages = getSpouseFamilyDataUnionPlusDates($tree, $personID);
        $spouseorder = 0;
    }
    while ($marriagerow = tng_fetch_assoc($marriages)) {
        $mrights = determineLivingPrivateRights($marriagerow, $righttree);
        $marriagerow['allow_living'] = $mrights['living'];
        $marriagerow['allow_private'] = $mrights['private'];

        if ($citesources && $mrights['both']) {
            getCitations($marriagerow['familyID'], 0);
        }
        if (!$spouseorder) {
            $spouse = $marriagerow['husband'] == $personID ? wife : husband;
        }
        if ($marriagerow[$spouse]) {
            $spouseresult = getPersonSimple($tree, $marriagerow[$spouse]);
            $spouserow = tng_fetch_assoc($spouseresult);

            $srights = determineLivingPrivateRights($spouserow, $righttree);
            $spouserow['allow_living'] = $srights['living'];
            $spouserow['allow_private'] = $srights['private'];

            $namestr = getName($spouserow);
            $spousetext = generateDates($spouserow);
            if ($citesources && $srights['both']) {
                getCitations($marriagerow[$spouse], 0);
            }
            $cite = reorderCitation($marriagerow[$spouse] . "_", 0);
            $cite2 = reorderCitation($marriagerow[$spouse] . "_NAME", 0);
            if ($cite2) $cite .= $cite ? ", $cite2" : $cite2;

            singleLine(_('Spouse'), "$namestr $spousetext", '', $cite);
        }
        if ($mrights['both']) {
            $cite = reorderCitation($marriagerow['familyID'] . "_MARR", 0);
            doubleLine(_('Married'), displayDate($marriagerow['marrdate']), _('Place'), $marriagerow['marrplace'], $cite);
        } else {
            doubleLine(_('Married'), '', _('Place'), '');
        }
        if ($mrights['lds']) {
            if ($mrights['both']) {
                $cite = reorderCitation($marriagerow['familyID'] . "_SLGS", 0);
                doubleLine(_('Sealed to Spouse (LDS)'), displayDate($marriagerow['sealdate']), _('Place'), $marriagerow['sealplace'], $cite);
            } else {
                doubleLine(_('Sealed to Spouse (LDS)'), '', _('Place'), '');
            }
        }

        // get the children from this marriage
        $children = getChildrenDataPlusDates($tree, $marriagerow['familyID']);
        if ($children && tng_num_rows($children)) {
            $childcnt = 1;
            while ($child = tng_fetch_assoc($children)) {
                $crights = determineLivingPrivateRights($child, $righttree);
                $child['allow_living'] = $crights['living'];
                $child['allow_private'] = $crights['private'];

                $namestr = getName($child);
                $childtext = generateDates($child);
                if ($citesources && $crights['both']) getCitations($child['pID'], 0);

                $cite = reorderCitation($child['pID'] . "_NAME", 0);
                childLine($childcnt, "$namestr $childtext", $cite);
                $childcnt++;
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
        $indnotes = getNotes($personID, 'I');
        $notes = '';
        $lasttitle = '---';
        foreach ($indnotes as $key => $note) {
            if ($note['title'] != $lasttitle) {
                if ($notes) $notes .= "\n\n";

                if ($note['title']) $notes .= $note['title'] . "\n";

            }
            $notes .= $note['text'];
        }
        $notes = preg_replace("/&nbsp;/", ' ', $notes);
        $notes = preg_replace("/<li>/", '* ', $notes);
        $notes = preg_replace("/<br\s*\/?>/", "", $notes);
        $allowable_tags = "";
        $notes = strip_tags($notes, $allowable_tags);

        $pdf->Ln(0.05);
        $pdf->SetFont($rptFont, '', $rptFontSize);
        $pdf->MultiCell($paperdim['w'] - $rtmrg - $lftmrg, $pdf->GetFontSize(), $notes, 0, 'L', 0, 0);

        //media goes here
    }

    // create the citations page
    if ($citesources && $citestring) {
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

            $pdf->MultiCell($paperdim['w'] - $rtmrg - ($lftmrg * 1.5), $pdf->GetFontSize(), "$citectr. $cite\n\n", 0, 'L', 0, 0);

            $citectr++;
        }
    }
}

// print it out
$pdf->Output();

// childLine
function childLine($childnum, $data, $cite = '') {
    global $pdf, $paperdim, $lftmrg, $rtmrg, $lineheight;
    global $rptFontSize, $rptFont, $lblFontSize, $citefontsub;
    global $labelwidth, $text;

    $pdf->SetFont($rptFont, "B", $lblFontSize);

    $pdf->Cell($labelwidth, $lineheight, "$childnum", 1, 0, 'R');
    if ($childnum == 1) {
        $pdf->SetX($lftmrg);
        $pdf->Cell($labelwidth, $lineheight, _('Children') . ":", 0, 0, 'L');
    }
    $pdf->SetFont($rptFont, '', $rptFontSize);
    $pdf->Cell($paperdim['w'] - $pdf->GetX() - $rtmrg, $lineheight, $data, 1, 0, 'L');
    if ($cite != '') {
        $pdf->SetX($lftmrg + $labelwidth + $pdf->GetStringWidth($data));
        $pdf->SetFont($rptFont, '', $rptFontSize - $citefontsub);
        $pdf->Cell(0, $lineheight / 2, " $cite");
    }
    $pdf->Ln($lineheight);
}

// singleLine
function singleLine($label, $data, $datastyle = '', $cite = '') {
    global $pdf, $paperdim, $lftmrg, $rtmrg, $lineheight;
    global $rptFontSize, $rptFont, $lblFontSize, $citefontsub;
    global $labelwidth;

    $data = strip_tags($data);

    if ($label) $label .= ":";


    $spaceWidth = $paperdim['w'] - $lftmrg - $rtmrg - $labelwidth;
    $pdf->SetFont($rptFont, $datastyle, $rptFontSize);
    $stringWidth = $pdf->GetStringWidth($data);

    $borderWidth = $stringWidth > $spaceWidth ? 0 : 1;

    $pdf->SetFont($rptFont, "B", $lblFontSize);
    $pdf->Cell($labelwidth, $lineheight, $label, $borderWidth, 0, 'L');
    $pdf->SetFont($rptFont, $datastyle, $rptFontSize);

    if ($stringWidth > $spaceWidth) {
        $topY = $pdf->GetY();
        $pdf->MultiCell($paperdim['w'] - $rtmrg - $lftmrg - $labelwidth, $pdf->GetFontSize(), $data, 1, 'L', 0, 0);
        $lowerY = $pdf->GetY();
        $diff = $lowerY - $topY;
        $pdf->SetY($topY);
        if ($diff > 0) $pdf->Cell($labelwidth, $diff, "", 1, 0, 'L');

        $pdf->SetY($lowerY);
        $lineWidth = $spaceWidth - .2;  //for citations
    } else {
        $pdf->Cell($paperdim['w'] - $pdf->GetX() - $rtmrg, $lineheight, $data, 1, 0, 'L');
        $lineWidth = $pdf->GetStringWidth($data);
    }
    if ($cite != '') {
        $pdf->SetX($lftmrg + $labelwidth + $lineWidth);
        $pdf->SetFont($rptFont, $datastyle, $rptFontSize - $citefontsub);
        $pdf->Cell(0, $lineheight / 2, " $cite");
    }
    if ($stringWidth <= $spaceWidth) $pdf->Ln($lineheight);

}

// nameLine
function nameLine($label1, $data1, $label2, $data2, $cite = '') {
    global $pdf, $paperdim, $lftmrg, $rtmrg, $lineheight;
    global $rptFont, $rptFontSize, $lblFontSize, $citefontsub;
    global $labelwidth;

    $data1 = strip_tags($data1);
    $data2 = strip_tags($data2);
    $genderwidth = 1.0;
    $pdf->SetFont($rptFont, "B", $lblFontSize);
    $label2width = $pdf->GetStringWidth($label2 . ':  ');

    $pdf->SetFont($rptFont, "B", $lblFontSize);
    $pdf->Cell($labelwidth, $lineheight, $label1 . ":", 1, 0, 'L');
    $pdf->SetFont($rptFont, "B", $rptFontSize);
    $pdf->CellFit($paperdim['w'] - $rtmrg - $lftmrg - $genderwidth - $label2width - $labelwidth, $lineheight, $data1, 1, 0, 'L', 0, '', 1, 0);
    if ($cite != '') {
        $x = $pdf->GetX();
        $pdf->SetX($lftmrg + $labelwidth + $pdf->GetStringWidth($data1));
        $pdf->SetFont($rptFont, "B", $rptFontSize - $citefontsub);
        $pdf->Cell(0, $lineheight / 2, " $cite");
        $pdf->SetX($x);
    }
    $pdf->SetFont($rptFont, "B", $lblFontSize);
    $pdf->Cell($label2width, $lineheight, $label2 . ":", 1, 0, 'L');
    $pdf->SetFont($rptFont, '', $rptFontSize);
    $pdf->CellFit($genderwidth, $lineheight, $data2, 1, 0, 'L', 0, '', 1, 0);
    $pdf->Ln($lineheight);
}

// doubleLine
function doubleLine($label1, $data1, $label2, $data2, $cite = '') {
    global $pdf, $paperdim, $lftmrg, $rtmrg, $lineheight;
    global $rptFont, $rptFontSize, $lblFontSize, $citefontsub;
    global $labelwidth;

    $data1 = strip_tags($data1);
    $data2 = strip_tags($data2);
    $datewidth = 2.0;      // width of date box in inches
    $pdf->SetFont($rptFont, "B", $lblFontSize);
    $placewidth = $pdf->GetStringWidth($label2 . ':  ');

    $pdf->SetFont($rptFont, "B", $lblFontSize);
    $pdf->CellFit($labelwidth, $lineheight, $label1 . ":", 1, 0, 'L', 0, '', 1, 0);
    $pdf->SetFont($rptFont, '', $rptFontSize);
    $pdf->CellFit($datewidth, $lineheight, $data1, 1, 0, 'L', 0, '', 1, 0);
    $pdf->SetFont($rptFont, "B", $lblFontSize);
    $pdf->Cell($placewidth, $lineheight, $label2 . ":", 1, 0, 'L');
    $pdf->SetFont($rptFont, '', $rptFontSize);
    $pdf->CellFit($paperdim['w'] - $pdf->GetX() - $rtmrg, $lineheight, $data2, 1, 0, 'L', 0, '', 1, 0);
    if ($cite != '') {
        if ($data2 == '') {
            $x = $labelwidth + $pdf->GetStringWidth($data1) + $lftmrg;
        } else {
            $x = $labelwidth + $datewidth + $placewidth + $pdf->GetStringWidth($data2) + $lftmrg;
        }
        $pdf->SetX($x);
        $pdf->SetFont($rptFont, '', $rptFontSize - $citefontsub);
        $pdf->Cell(0, $lineheight / 2, " $cite");
    }
    $pdf->Ln($lineheight);
}
