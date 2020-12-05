<?php

$textpart = "familygroup";
include "tng_begin.php";
include "personlib.php";
$icon = buildSvgElement("img/search.svg", ["class" => "w-3 h-3 fill-current inline-block"]);
$placelinkbegin = $tngconfig['places1tree'] ? "<a href=\"placesearch.php?psearch=" : "<a href=\"placesearch.php?tree=$tree&amp;psearch=";
$placelinkend = "\" title=\"" . _('Find all individuals with events at this location') . "\">$icon</a>";
$firstsection = 0;
$tableid = "";
$cellnumber = 0;
$notestogether = 0;
$allow_lds_this = "";

$flags['imgprev'] = true;

$citations = [];
$citedisplay = [];
$citestring = [];
$citedispctr = 0;

$ldsOK = determineLDSRights();

$totcols = $ldsOK ? 6 : 3;
$factcols = $totcols - 1;
/**
 * @param $text
 * @param $fact
 * @return string
 */
function showFact($text, $fact) {
    global $factcols;
    $facttext = "<tr>\n";
    $facttext .= "<td class='fieldnameback align-top'><span class='fieldname'>" . $text . "&nbsp;</span></td>\n";
    $facttext .= "<td colspan=\"$factcols\" class='databack'><span class='normal'>$fact&nbsp;</span></td>\n";
    $facttext .= "</tr>\n";

    return $facttext;
}
/**
 * @param $event
 * @return string
 */
function showDatePlace($event) {
    global $allow_lds_this, $cellnumber, $tentative_edit, $tree, $familyID;
    global $placelinkbegin, $placelinkend;

    $dptext = "";
    if (!$cellnumber) {
        $cellid = " id=\"info1\"";
        $cellnumber++;
    } else {
        $cellid = "";
    }

    $dcitestr = $pcitestr = "";
    if ($event['date'] || $event['place']) {
        $citekey = $familyID . "_" . $event['event'];
        $cite = reorderCitation($citekey);
        if ($cite) {
            $dcitestr = $event['date'] ? "&nbsp; <span class='normal'>[$cite]</span>" : "";
            $pcitestr = $event['place'] ? "&nbsp; <span class='normal'>[$cite]</span>" : "";
        }
    }
    $dptext .= "<tr>\n";
    $editicon = $tentative_edit ? "<img src=\"img/tng_edit.gif\" width=\"16\" height='15' alt=\"" . _('Suggest a change for this event') . "\" align=\"absmiddle\" onclick=\"tnglitbox = new LITBox('ajx_tentedit.php?tree=$tree&amp;persfamID={$event['ID']}&amp;type={$event['type']}&amp;event={$event['event']}&amp;title={$event['text']}', {width:500, height:500});\" class=\"fakelink\" />" : "";
    $dptext .= "<td class='fieldnameback align-top'$cellid><span class='fieldname'>" . $event['text'] . "&nbsp;$editicon</span></td>\n";
    $dptext .= "<td class='databack'><span class='normal'>" . displayDate($event['date']) . "$dcitestr&nbsp;</span></td>\n";
    $dptext .= "<td class='databack'";
    if ($allow_lds_this && $event['ldstext']) {
        if ($event['eventlds'] == "div") $dptext .= " colspan='4'";

    }
    $dptext .= "><span class='normal'>{$event['place']}$pcitestr&nbsp;";
    if ($event['place']) {
        $dptext .= $placelinkbegin . urlencode($event['place']) . $placelinkend;
    }
    $dptext .= "</span></td>\n";
    if ($allow_lds_this && $event['ldstext']) {
        if ($event['type2']) {
            $event['type'] = $event['type2'];
            $event['ID'] = $event['ID2'];
        }
        $editicon = $tentative_edit && $event['eventlds'] ? "<img src=\"img/tng_edit.gif\" width=\"16\" height='15' alt=\"" . _('Suggest a change for this event') . "\" align=\"absmiddle\" onclick=\"tnglitbox = new LITBox('ajx_tentedit.php?tree=$tree&amp;persfamID={$event['ID']}&amp;type={$event['type']}&amp;event={$event['eventlds']}&amp;title={$event['ldstext']}', {width:500, height:500});\" class=\"fakelink\">" : "";
        $dptext .= "<td class='fieldnameback align-top'><span class='fieldname'>" . $event['ldstext'] . "&nbsp;$editicon</span></td>\n";
        $dptext .= "<td class='databack'><span class='normal'>" . displayDate($event['ldsdate']) . "&nbsp;</span></td>\n";
        $dptext .= "<td class='databack'><span class='normal'>{$event['ldsplace']}&nbsp;";
        if ($event['ldsplace'] && $event['ldsplace'] != _('Place')) {
            $dptext .= $placelinkbegin . urlencode($event['ldsplace']) . $placelinkend;
        }
        $dptext .= "</span></td>\n";
    }
    $dptext .= "</tr>\n";

    return $dptext;
}
/**
 * @param $ind
 * @param $label
 * @param $familyID
 * @param $showmarriage
 * @return string
 */
function displayIndividual($ind, $label, $familyID, $showmarriage) {
    global $tree, $children_table, $righttree;
    global $allow_lds_this, $allow_edit, $families_table, $people_table, $personID;

    $indtext = "";

    $rightbranch = checkbranch($ind['branch']);
    $rights = determineLivingPrivateRights($ind, $righttree, $rightbranch);
    $ind['allow_living'] = $rights['living'];
    $ind['allow_private'] = $rights['private'];

    $allow_lds_this = $rights['lds'];
    $haskids = $ind['haskids'] ? "X" : "&nbsp;";
    $restriction = $familyID ? "AND familyID != '$familyID'" : "";
    if ($ind['sex'] == "M") {
        $sex = _('Male');
    } else {
        if ($ind['sex'] == "F") {
            $sex = _('Female');
        } else {
            $sex = _('Unknown');
        }
    }
    $namestr = getName($ind);
    $personID = $ind['personID'];
    //adjust for same-sex relationships
    if ($ind['sex'] == "M" && $label == _('Mother')) {
        $label = _('Father');
    } elseif ($ind['sex'] == "F" && $label == _('Father')) {
        $label = _('Mother');
    }
    $indtext .= "<div class='titlebox rounded-lg'>\n";
    $indtext .= "<table class='w-full' border='0' cellspacing='2' cellpadding='0'>\n";
    //show photo & name
    $indtext .= "<tr><td>";
    $indtext .= showSmallPhoto($ind['personID'], $namestr, $rights['both'], 0, false, $ind['sex']);
    $indtext .= "<span class='normal'>$label | $sex</span><br><h3 class='subhead'>";
    if ($ind['haskids']) $indtext .= "+ ";
    $indtext .= "<a href=\"getperson.php?personID={$ind['personID']}&amp;tree=$tree\">$namestr</a>";
    if ($allow_edit && $rightbranch) {
        $indtext .= " | <a href=\"admin_editperson.php?personID={$ind['personID']}&amp;tree=$tree&amp;cw=1\" target='_blank'>" . _('Edit') . "</a>";
    }
    $indtext .= "<br></h3>\n";
    $indtext .= "</td></tr>\n</table>\n<br>\n";

    $event = [];

    $indtext .= "<table class='whiteback tfixed' cellspacing='1' cellpadding='4'>\n";
    $indtext .= "<col class='labelcol'/><col class=\"eventdatecol\"><col/>";
    $indtext .= $allow_lds_this ? "<col style=\"width:125px;\"/><col class=\"eventdatecol\"/><col class='labelcol'/>\n" : "\n";

    $event['text'] = _('Born');
    $event['event'] = "BIRT";
    $event['type'] = "I";
    $event['ID'] = $personID;
    $event['ldstext'] = _('LDS Ordinances');
    if ($rights['both']) {
        $event['date'] = $ind['birthdate'];
        $event['place'] = $ind['birthplace'];
        if ($allow_lds_this) {
            $event['ldsdate'] = _('Date');
            $event['ldsplace'] = _('Place');
        }
    }
    $indtext .= showDatePlace($event);

    $event = [];
    $event['event'] = "CHR";
    $event['type'] = "I";
    $event['ID'] = $personID;
    $event['eventlds'] = "BAPL";
    $event['ldstext'] = _('Baptized (LDS)');
    if ($rights['both']) {
        $event['date'] = $ind['altbirthdate'];
        $event['place'] = $ind['altbirthplace'];
        if ($allow_lds_this) {
            $event['ldsdate'] = $ind['baptdate'];
            $event['ldsplace'] = $ind['baptplace'];
        }
    }
    if ((isset($event['date']) && $event['date']) || (isset($event['place']) && $event['place']) || isset($event['ldsdate']) || isset($event['ldsplace'])) {
        $event['text'] = _('Christened');
        $indtext .= showDatePlace($event);
    }

    $event = [];
    $event['text'] = _('Died');
    $event['event'] = "DEAT";
    $event['type'] = "I";
    $event['ID'] = $personID;
    $event['eventlds'] = "ENDL";
    $event['ldstext'] = _('Endowed (LDS)');
    if ($rights['both']) {
        $event['date'] = $ind['deathdate'];
        $event['place'] = $ind['deathplace'];
        if ($allow_lds_this) {
            $event['ldsdate'] = $ind['endldate'];
            $event['ldsplace'] = $ind['endlplace'];
        }
    }
    $indtext .= showDatePlace($event);

    $event = [];
    $event['text'] = $ind['burialtype'] ? _('Cremated') : _('Buried');
    $event['event'] = "BURI";
    $event['type'] = "I";
    $event['ID'] = $personID;
    $event['eventlds'] = "SLGC";
    $event['ldstext'] = _('Sealed to Parents (LDS)');
    if ($rights['both']) {
        $event['date'] = $ind['burialdate'];
        $event['place'] = $ind['burialplace'];
        if ($allow_lds_this) {
            if ($familyID) {
                $query = "SELECT sealdate, sealplace FROM $children_table WHERE familyID = \"{$ind['famc']}\" AND gedcom = '$tree' AND personID = \"{$ind['personID']}\"";
                $cresult = tng_query($query);
                $sealinfo = tng_fetch_assoc($cresult);
                $ind['sealdate'] = $sealinfo['sealdate'];
                $ind['sealplace'] = $sealinfo['sealplace'];
                tng_free_result($cresult);
            }
            $event['type2'] = "C";
            $event['ID2'] = "$personID::{$ind['famc']}";
            $event['ldsdate'] = $ind['sealdate'];
            $event['ldsplace'] = $ind['sealplace'];
        }
    }
    $indtext .= showDatePlace($event);

    //show marriage & sealing if $showmarriage
    $query = "SELECT marrdate, marrplace, divdate, divplace, sealdate, sealplace, living, private, branch, marrtype FROM $families_table WHERE familyID = '$familyID' AND gedcom = '$tree'";
    $result = tng_query($query);
    $fam = tng_fetch_assoc($result);
    if ($familyID || $fam['marrtype']) {
        if ($showmarriage) {
            $famrights = determineLivingPrivateRights($fam, $righttree);
            $fam['allow_living'] = $famrights['living'];
            $fam['allow_private'] = $famrights['private'];

            tng_free_result($result);

            $event = [];
            $eventd = [];
            $event['text'] = _('Married');
            $event['event'] = "MARR";
            $event['type'] = "F";
            $event['ID'] = $familyID;
            $event['eventlds'] = "SLGS";
            $event['ldstext'] = _('Sealed to Spouse (LDS)');
            if ($famrights['both'] && $rights['both']) {
                $event['date'] = $fam['marrdate'];
                $event['place'] = $fam['marrplace'];
                if ($allow_lds_this) {
                    $event['ldsdate'] = $fam['sealdate'];
                    $event['ldsplace'] = $fam['sealplace'];
                }
                $eventd['event'] = "DIV";
                $eventd['text'] = _('Divorced');
                $eventd['date'] = $fam['divdate'];
                $eventd['place'] = $fam['divplace'];
            }
            $indtext .= showDatePlace($event);
            $eventd['ldstext'] = "";
            $eventd['eventlds'] = "div";
            if ($eventd['date'] || $eventd['place']) {
                $indtext .= showDatePlace($eventd);
            }

            if ($fam['marrtype'] && $famrights['both'] && $rights['both']) {
                $indtext .= showFact(_('Type'), $fam['marrtype']);
            }
        }
        $spousetext = _('Other Spouse');
    } else {
        $spousetext = _('Spouse');
    }

    //show other spouses
    $query = "SELECT familyID, personID, firstname, lnprefix, lastname, prefix, suffix, nameorder, families.living AS fliving, families.private AS fprivate, families.branch AS branch, people.living AS living, people.private AS private, marrdate, marrplace, sealdate, sealplace, marrtype ";
    $query .= "FROM $families_table families ";
    if ($ind['sex'] == "M") {
        $query .= "LEFT JOIN $people_table people ON families.wife = people.personID AND families.gedcom = people.gedcom ";
        $query .= "WHERE husband = \"{$ind['personID']}\" AND people.gedcom = '$tree' $restriction ";
        $query .= "ORDER BY husborder";
    } else {
        if ($ind['sex'] = "F") {
            $query .= "LEFT JOIN $people_table people ON families.husband = people.personID AND families.gedcom = people.gedcom ";
            $query .= "WHERE wife = \"{$ind['personID']}\" AND people.gedcom = '$tree' $restriction ";
            $query .= "ORDER BY wifeorder";
        } else {
            $query .= "LEFT JOIN $people_table people ON (families.husband = people.personID OR families.wife = people.personID) AND families.gedcom = people.gedcom ";
            $query .= "WHERE (wife = \"{$ind['personID']}\" && husband = \"{$ind['personID']}\") AND $people_table.gedcom = '$tree'";
        }
    }
    $spresult = tng_query($query);

    while ($fam = tng_fetch_assoc($spresult)) {
        $famrights = determineLivingPrivateRights($fam, $righttree);
        $fam['allow_living'] = $famrights['living'];
        $fam['allow_private'] = $famrights['private'];

        $spousename = getName($fam);
        $spouselink = $spousename ? "<a href=\"getperson.php?personID={$fam['personID']}&amp;tree=$tree\">$spousename</a> | " : "";
        $spouselink .= "<a href=\"familygroup.php?familyID={$fam['familyID']}&amp;tree=$tree\">{$fam['familyID']}</a>";

        $fam['living'] = $fam['fliving'];
        $fam['private'] = $fam['fprivate'];
        $famrights = determineLivingPrivateRights($fam, $righttree);
        $fam['allow_living'] = $famrights['living'];
        $fam['allow_private'] = $famrights['private'];

        if ($famrights['both'] && $rights['both'] && $fam['marrtype']) {
            $spouselink .= " ({$fam['marrtype']})";
        }
        $indtext .= showFact($spousetext, $spouselink);

        $event = [];
        $event['text'] = _('Married');
        $event['event'] = "MARR";
        $event['type'] = "F";
        $event['ID'] = $fam['familyID'];
        $event['eventlds'] = "SLGS";
        $event['ldstext'] = _('Sealed to Spouse (LDS)');
        if ($famrights['both'] && $rights['both']) {
            $event['date'] = $fam['marrdate'];
            $event['place'] = $fam['marrplace'];
            if ($allow_lds_this) {
                $event['ldsdate'] = $fam['sealdate'];
                $event['ldsplace'] = $fam['sealplace'];
            }
        }
        $indtext .= showDatePlace($event);
    }

    //show parents (for hus&wif)
    if ($familyID) {
        $query = "SELECT familyID, personID, firstname, lnprefix, lastname, prefix, suffix, nameorder, people.living, people.private, people.branch ";
        $query .= "FROM $families_table families, $people_table people ";
        $query .= "WHERE families.familyID = \"{$ind['famc']}\" AND families.gedcom = '$tree' AND people.personID = families.husband AND people.gedcom = '$tree'";
        $presult = tng_query($query);
        $parent = tng_fetch_assoc($presult);

        $prights = determineLivingPrivateRights($parent, $righttree);
        $parent['allow_living'] = $prights['living'];
        $parent['allow_private'] = $prights['private'];

        $fathername = getName($parent);
        tng_free_result($presult);
        $fatherlink = $fathername ? "<a href=\"getperson.php?personID={$parent['personID']}&amp;tree=$tree\">$fathername</a> | " : "";
        $fatherlink .= $fathername ? "<a href=\"familygroup.php?familyID={$parent['familyID']}&amp;tree=$tree\">{$parent['familyID']} " . _('Group Sheet') . "</a>" : "";
        $indtext .= showFact(_('Father'), $fatherlink);

        $query = "SELECT familyID, personID, firstname, lnprefix, lastname, prefix, suffix, nameorder, people.living, people.private, people.branch ";
        $query .= "FROM $families_table families, $people_table people ";
        $query .= "WHERE families.familyID = \"{$ind['famc']}\" AND families.gedcom = '$tree' AND people.personID = families.wife AND people.gedcom = '$tree'";
        $presult = tng_query($query);
        $parent = tng_fetch_assoc($presult);

        $prights = determineLivingPrivateRights($parent, $righttree);
        $parent['allow_living'] = $prights['living'];
        $parent['allow_private'] = $prights['private'];

        $mothername = getName($parent);
        tng_free_result($presult);
        $motherlink = $mothername ? "<a href=\"getperson.php?personID={$parent['personID']}&amp;tree=$tree\">$mothername</a> | " : "";
        $motherlink .= $mothername ? "<a href=\"familygroup.php?familyID={$parent['familyID']}&amp;tree=$tree\">{$parent['familyID']} " . _('Group Sheet') . "</a>" : "";
        $indtext .= showFact(_('Mother'), $motherlink);
    }
    $indtext .= "</table>\n</div>\n<br>\n";

    return $indtext;
}

//get family
$query = "SELECT familyID, husband, wife, living, private, marrdate, gedcom, branch FROM $families_table WHERE familyID = '$familyID' AND gedcom = '$tree'";
$result = tng_query($query);
$famrow = tng_fetch_assoc($result);
if (!tng_num_rows($result)) {
    tng_free_result($result);
    header("Location: thispagedoesnotexist.html");
    exit;
} else {
    tng_free_result($result);
}

$righttree = checktree($tree);
$rightbranch = checkbranch($famrow['branch']);
$rights = determineLivingPrivateRights($famrow, $righttree, $rightbranch);
$famrow['allow_living'] = $rights['living'];
$famrow['allow_private'] = $rights['private'];

$famname = getFamilyName($famrow);

$logname = $tngconfig['nnpriv'] && $family['private'] ? _('Private') : ($nonames && $famrow['living'] ? _('Living') : $famname);
$logstring = "<a href=\"familygroup.php?familyID=$familyID&amp;tree=$tree\">" . _('Family Group Sheet for') . " $logname ($familyID)</a>";
writelog($logstring);
preparebookmark($logstring);

$famname .= " ($familyID)";
$namestr = _('Family') . ": " . $famname;
if (!$rightbranch) $tentative_edit = "";

$famnotes = getNotes($familyID, "F");

$years = $famrow['marrdate'] && $rights['both'] ? _('m.') . " " . displayDate($famrow['marrdate']) : "";

if ($rights['both']) {
    tng_header(_('Family Group Sheet for') . " $famname $years ", $flags);
} else {
    tng_header(_('Family Group Sheet for') . " $famname", $flags);
}

if ($rights['both']) {
    getCitations($familyID);
    $citekey = $familyID . "_";
    $cite = reorderCitation($citekey);
    if ($cite) {
        $namestr .= "<sup class='normal'>&nbsp; [$cite]&nbsp;</sup>";
    }
}

$photostr = showSmallPhoto($familyID, $famname, $rights['both'], 0);
echo tng_DrawHeading($photostr, $namestr, $years);

$famtext = "";
$personID = $famrow['husband'] ? $famrow['husband'] : $famrow['wife'];
$fammedia = getMedia($famrow, "F", true);
$famalbums = getAlbums($famrow, "F");

$famtext .= "<ul class='nopad'>\n";
$famtext .= beginSection("info");

//get husband & spouses
if ($famrow['husband']) {
    $query = "SELECT * FROM $people_table WHERE personID = \"{$famrow['husband']}\" AND gedcom = '$tree'";
    $result = tng_query($query);
    $husbrow = tng_fetch_assoc($result);
    $label = $husbrow['sex'] != "F" ? _('Father') : _('Mother');
    $famtext .= displayIndividual($husbrow, $label, $familyID, 1);
    tng_free_result($result);
}

//get wife & spouses
if ($famrow['wife']) {
    $query = "SELECT * FROM $people_table WHERE personID = \"{$famrow['wife']}\" AND gedcom = '$tree'";
    $result = tng_query($query);
    $wiferow = tng_fetch_assoc($result);
    $label = $husbrow['sex'] != "M" ? _('Mother') : _('Father');
    $famtext .= displayIndividual($wiferow, $label, $familyID, 0);
    tng_free_result($result);
}

//for each child
$query = "SELECT $people_table.personID AS personID, branch, firstname, lnprefix, lastname, prefix, suffix, nameorder, living, private, famc, sex, birthdate, birthplace, altbirthdate, altbirthplace, haskids, deathdate, deathplace, burialdate, burialplace, burialtype, baptdate, baptplace, endldate, endlplace, sealdate, sealplace FROM $people_table, $children_table WHERE $people_table.personID = $children_table.personID AND $children_table.familyID = \"{$famrow['familyID']}\" AND $people_table.gedcom = '$tree' AND $children_table.gedcom = '$tree' ORDER BY ordernum";
$children = tng_query($query);


if ($children && tng_num_rows($children)) {
    $childcount = 0;
    while ($childrow = tng_fetch_assoc($children)) {
        $childcount++;
        $famtext .= displayIndividual($childrow, _('Child') . " $childcount", "", 1);
    }
}
tng_free_result($children);

$famtext .= endSection("info");

$firstsection = 1;
$firstsectionsave = "";

$assoctext = "";
if ($rights['both']) {
    $query = "SELECT passocID, relationship, reltype FROM $assoc_table WHERE gedcom = '$tree' AND personID = '$familyID'";
    $assocresult = tng_query($query);
    while ($assoc = tng_fetch_assoc($assocresult)) {
        $assoctext .= showEvent(["text" => _('Association'), "fact" => formatAssoc($assoc)]);
    }
    tng_free_result($assocresult);
    if ($assoctext) {
        $famtext .= beginSection("assoc");
        $famtext .= "<div class='titlebox rounded-lg'>\n";
        $famtext .= "<table class='whiteback w-full' cellpadding='4' cellspacing='1' border='0'>\n";
        $famtext .= "$assoctext\n";
        $famtext .= "</table>\n</div>\n<br>\n";
        $famtext .= endSection("assoc");
    }
}

$media = doMediaSection($familyID, $fammedia, $famalbums);
if ($media) {
    $famtext .= beginSection("media");
    $famtext .= "<div class='titlebox rounded-lg'>\n$media\n</div>\n<br>\n";
    $famtext .= endSection("media");
}

if ($rights['both']) {
    $notes = buildNotes($famnotes, $familyID);

    if ($notes) {
        $famtext .= beginSection("notes");
        $famtext .= "<div class='titlebox rounded-lg'>\n";
        $famtext .= "<table class='whiteback w-full' cellpadding='4' cellspacing='1' border='0'>\n";
        $famtext .= "<tr>\n";
        $famtext .= "<td class='fieldnameback indleftcol align-top' id=\"notes1\" style=\"width:100px;\"><span class='fieldname'>" . _('Notes') . "&nbsp;</span></td>\n";
        $famtext .= "<td class='databack' colspan='2'>$notes</td>\n";
        $famtext .= "</tr>\n";
        $famtext .= "</table>\n</div>\n<br>\n";
        $famtext .= endSection("notes");
    }
    if ($citedispctr) {
        $famtext .= beginSection("citations");
        $famtext .= "<div class='titlebox rounded-lg'>\n";
        $famtext .= "<table class='whiteback w-full' cellpadding='4' cellspacing='1' border='0'>\n";
        $famtext .= "<tr>\n";
        $famtext .= "<td class='fieldnameback indleftcol align-top' name=\"citations1\" id=\"citations1\" style=\"width:100px;\"><a name=\"sources\"><span class='fieldname'>" . _('Sources') . "&nbsp;</span></td>\n";
        $famtext .= "<td class='databack' colspan='2'><ol class=\"normal citeblock\">";
        $citectr = 0;
        $count = count($citestring);
        foreach ($citestring as $cite) {
            $famtext .= "<li class='normal'><a name=\"cite" . ++$citectr . "\"></a>$cite<br>";
            if ($citectr < $count) $famtext .= "<br>";
            $famtext .= "</li>\n";
        }
        $famtext .= "</ol></td>\n";
        $famtext .= "</tr>\n";
        $famtext .= "</table>\n</div>\n<br>\n";
        $famtext .= endSection("citations");
    }
} elseif ($rights['both']) {
    $famtext .= beginSection("notes");
    $famtext .= "<div class='titlebox rounded-lg'>\n";
    $famtext .= "<table class='whiteback w-full' cellpadding='4' cellspacing='1' border='0'>\n";
    $famtext .= "<tr>\n";
    $famtext .= "<td class='fieldnameback indleftcol align-top' id=\"notes1\" style=\"width:100px;\"><span class='fieldname'>" . _('Notes') . "&nbsp;</span></td>\n";
    $famtext .= "<td class='databack' colspan='2'><span class='normal'>" . _('At least one living or private individual is linked to this note - Details withheld.') . "</span></td>\n";
    $famtext .= "</tr>\n";
    $famtext .= "</table>\n</div>\n<br>\n";
    $famtext .= endSection("notes");
    $notes = true;
}
$famtext .= "</ul>\n";

$tng_alink = $tng_plink = $tng_mlink = "lightlink";
if ($media || $notes || $assoctext) {
    if ($tngconfig['istart']) {
        $tng_plink = "lightlink3";
    } else {
        $tng_alink = "lightlink3";
    }
    $innermenu = "<a href='#' class=\"$tng_plink\" onclick=\"return infoToggle('info');\" id=\"tng_plink\">" . _('Family Information') . "</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
    if ($media) {
        $innermenu .= "<a href='#' class='lightlink' onclick=\"return infoToggle('media');\" id=\"tng_mlink\">" . _('Media') . "</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
    }
    if ($assoctext) {
        $innermenu .= "<a href='#' class='lightlink' onclick=\"return infoToggle('assoc');\" id=\"tng_xlink\">" . _('Association') . "</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
    }
    if ($notes) {
        $innermenu .= "<a href='#' class='lightlink' onclick=\"return infoToggle('notes');\" id=\"tng_nlink\">" . _('Notes') . "</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
    }
    if ($citedispctr) {
        $innermenu .= "<a href='#' class='lightlink' onclick=\"return infoToggle('citations');\" id=\"tng_clink\">" . _('Sources') . "</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
    }
    $innermenu .= "<a href='#' class=\"$tng_alink\" onclick=\"return infoToggle('all');\" id=\"tng_alink\">" . _('All') . "</a>\n";
} else {
    $innermenu = "<span class=\"lightlink3\" id=\"tng_plink\">" . _('Family Information') . "</span>\n";
}

$treeResult = getTreeSimple($tree);
$treerow = tng_fetch_assoc($treeResult);
$allowpdf = !$treerow['disallowpdf'] || ($allow_pdf && $rightbranch);
tng_free_result($treeResult);

if ($allowpdf) {
    $innermenu .= " &nbsp;&nbsp; | &nbsp;&nbsp; <a href='#' class='lightlink' ";
    $innermenu .= "onclick=\"tnglitbox = new LITBox('rpt_pdfform.php?pdftype=fam&amp;familyID=$familyID&amp;tree=$tree', {width: 400, height: 480}); return false;\">PDF</a>\n";
}

echo tng_menu("F", "family", $familyID, $innermenu);
?>
    <script>
        function innerToggle(part, subpart, subpartlink) {
            if (part == subpart)
                turnOn(subpart, subpartlink);
            else
                turnOff(subpart, subpartlink);
        }

        function turnOn(subpart, subpartlink) {
            jQuery('#' + subpartlink).attr('class', 'lightlink3');
            jQuery('#' + subpart).show();
        }

        function turnOff(subpart, subpartlink) {
            jQuery('#' + subpartlink).attr('class', 'lightlink');
            jQuery('#' + subpart).hide();
        }

        function infoToggle(part) {
            if (part == "all") {
                jQuery('#info').show();
                <?php
                if ($media) {
                    echo "\$('#media').show();\n";
                    echo "\$('#tng_mlink').attr('class','lightlink');\n";
                }
                if ($assoctext) {
                    echo "\$('#assoc').show();\n";
                    echo "\$('#tng_xlink').attr('class','lightlink');\n";
                }
                if ($notes) {
                    echo "\$('#notes').show();\n";
                    echo "\$('#tng_nlink').attr('class','lightlink');\n";
                }
                if ($citedispctr) {
                    echo "\$('#citations').show();\n";
                    echo "\$('#tng_clink').attr('class','lightlink');\n";
                }
                ?>
                jQuery('#tng_alink').attr('class', 'lightlink3');
                jQuery('#tng_plink').attr('class', 'lightlink');
            } else {
                innerToggle(part, "info", "tng_plink");
                <?php
                if ($media) echo "innerToggle(part,\"media\",\"tng_mlink\");\n";

                if ($assoctext) {
                    echo "innerToggle(part,\"assoc\",\"tng_xlink\");\n";
                }
                if ($notes) echo "innerToggle(part,\"notes\",\"tng_nlink\");\n";

                if ($citedispctr) {
                    echo "innerToggle(part,\"citations\",\"tng_clink\");\n";
                }
                ?>
                jQuery('#tng_alink').attr('class', 'lightlink');
            }
            return false;
        }
    </script>

<?php
echo $famtext;
?>
    <br>

<?php
$flags['more'] = "<script src=\"js/rpt_utils.js\"></script>\n";
if ($tentative_edit) {
    $flags['more'] .= "<script>\n";
    $flags['more'] .= "var preferEuro = " . ($tngconfig['preferEuro'] ? $tngconfig['preferEuro'] : "false") . ";\n";
    $flags['more'] .= "var preferDateFormat = '$preferDateFormat';\n";
    $flags['more'] .= "</script>\n";
    $flags['more'] .= "<script src=\"js/tentedit.js\"></script>\n";
    $flags['more'] .= "<script src=\"js/datevalidation.js\"></script>\n";
}
tng_footer($flags);
?>