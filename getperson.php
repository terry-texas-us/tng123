<?php
$textpart = "getperson";
$needMap = true;
include "tng_begin.php";

if (!$personID) {
    header("Location: thispagedoesnotexist.html");
    exit;
}
if (!empty($tngprint)) {
    $tngconfig['istart'] = "";
    $tngconfig['hidemedia'] = "";
}
$defermap = $map['pstartoff'] || $tngconfig['istart'] ? 1 : 0;
include "personlib.php";

$citations = [];
$citedisplay = [];
$citestring = [];
$citationctr = 0;
$citedispctr = 0;
$firstsection = 1;
$firstsectionsave = "";
$tableid = "";
$cellnumber = 0;

$indnotes = getNotes($personID, "I");
$stdex = getStdExtras($personID);

$indexlist = ['BIRT', 'CHR', 'BAPL', 'CONL', 'INIT', 'ENDL', 'DEAT', 'BURI'];
foreach ($indexlist as $myindex)
    if (!isset($stdex[$myindex])) $stdex[$myindex] = '';

$result = getPersonFullPlusDates($tree, $personID);
if (!tng_num_rows($result)) {
    tng_free_result($result);
    header("Location: thispagedoesnotexist.html");
    exit;
}

$flags['imgprev'] = true;

$row = tng_fetch_assoc($result);
$righttree = checktree($tree);
$rightbranch = $righttree ? checkbranch($row['branch']) : false;
$rights = determineLivingPrivateRights($row, $righttree, $rightbranch);
$row['allow_living'] = $rights['living'];
$row['allow_private'] = $rights['private'];
if (!$rightbranch) $tentative_edit = "";

$org_rightbranch = $rightbranch;
$namestr = getName($row);
$nameformap = $namestr;

$treeResult = getTreeSimple($tree);
$treerow = tng_fetch_assoc($treeResult);
$disallowgedcreate = $treerow['disallowgedcreate'];
$allowpdf = !$treerow['disallowpdf'] || ($allow_pdf && $rightbranch);
tng_free_result($treeResult);

$logname = !empty($tngconfig['nnpriv']) && $row['private'] ? _('Private') : ($nonames && $row['living'] ? _('Living') : $namestr);
$treestr = "<a href=\"showtree.php?tree=$tree\">{$treerow['treename']}</a>";
if ($row['branch']) {
    //explode on commas
    $branches = explode(",", $row['branch']);
    $count = 0;
    $branchstr = "";
    foreach ($branches as $branch) {
        $count++;
        $brresult = getBranchesSimple($tree, $branch);
        $brrow = tng_fetch_assoc($brresult);
        $branchstr .= $brrow['description'] ? $brrow['description'] : $branch;
        if ($count < count($branches)) $branchstr .= ", ";

        tng_free_result($brresult);
    }
    if ($branchstr) $treestr = $treestr . " | $branchstr";
}
tng_free_result($result);

writelog("<a href=\"getperson.php?personID=$personID&amp;tree=$tree\">" . _('Individual info for') . " $logname ($personID)</a>");
preparebookmark("<a href=\"getperson.php?personID=$personID&amp;tree=$tree\">" . _('Individual info for') . " $namestr ($personID)</a>");

$flags['scripting'] = "<script>var tnglitbox;</script>\n";
if (empty($tngconfig['hidedna'])) {
    $showdnatest = "show_dnatest(); ";
    $hidednatest = "hide_dnatest(); ";
} else {
    $showdnatest = $hidednatest = "";
}
if ($map['key'] && $isConnected) {
    $flags['scripting'] .= "<script src=\"{$http}://maps.googleapis.com/maps/api/js?language=" . _('&amp;hl=en') . "$mapkeystr\"></script>\n";
}
$headstr = $namestr;
if ($rights['both']) {
    if ($row['birthdate']) {
        $headstr .= " " . _('b.') . " " . displayDate($row['birthdate']);
    }
    if ($row['birthplace']) $headstr .= " " . $row['birthplace'];

    if ($row['deathdate']) {
        $headstr .= " " . _('d.') . " " . displayDate($row['deathdate']);
    }
    if ($row['deathplace']) $headstr .= " " . $row['deathplace'];

}
tng_header($headstr, $flags);

getCitations($personID);

$indmedia = getMedia($row, "I");
$indalbums = getAlbums($row, "I");

$photostr = showSmallPhoto($personID, $namestr, $rights['both'], 0, false, $row['sex']);
if ($rights['both']) {
    $dnanamestr = $namestr;
    $citekey = $personID . "_";
    $cite = reorderCitation($citekey);
    if ($cite) {
        $namestr .= "<sup><span class='normal'>[$cite]</span></sup>";
    }
}
echo "<div class=\"vcard\">\n";
echo tng_DrawHeading($photostr, $namestr, getYears($row));

$persontext = "";
$persontext .= "<ul class='nopad'>\n";

if (!empty($tng_extras)) {
    $media = doMediaSection($personID, $indmedia, $indalbums);
    if ($media) {
        $persontext .= beginSection("media");
        $persontext .= $media . "<br>\n";
        $persontext .= endSection("media");
    }
}

$persontext .= beginSection("info");
$persontext .= "<table class='w-11/12 mx-auto whiteback tfixed'>\n";
$persontext .= "<col class='labelcol'/><col style=\"width:{$datewidth}px;\"/><col />\n";
resetEvents();
if ($rights['both']) {
    $persontext .= showEvent(["text" => _('Name'), "fact" => getName($row, true), "event" => "NAME", "entity" => $personID, "type" => "I"]);
    if ($row['title']) {
        $persontext .= showEvent(["text" => _('Title'), "fact" => $row['title'], "event" => "TITL", "entity" => $personID, "type" => "I"]);
    }
    if ($row['prefix']) {
        $persontext .= showEvent(["text" => _('Prefix'), "fact" => $row['prefix'], "event" => "NPFX", "entity" => $personID, "type" => "I"]);
    }
    if ($row['suffix']) {
        $persontext .= showEvent(["text" => _('Suffix'), "fact" => $row['suffix'], "event" => "NSFX", "entity" => $personID, "type" => "I"]);
    }
    if ($row['nickname']) {
        $persontext .= showEvent(["text" => _('Nickname'), "fact" => $row['nickname'], "event" => "NICK", "entity" => $personID, "type" => "I"]);
    }
    if ($row['private'] && $allow_edit && $allow_add && $allow_delete && !$assignedtree) {
        $persontext .= showEvent(["text" => _('Private'), "fact" => _('Yes')]);
    }
    setEvent(["text" => _('Born'), "fact" => $stdex['BIRT'], "date" => $row['birthdate'], "place" => $row['birthplace'], "event" => "BIRT", "entity" => $personID, "type" => "I"], $row['birthdatetr']);
    setEvent(["text" => _('Christened'), "fact" => $stdex['CHR'], "date" => $row['altbirthdate'], "place" => $row['altbirthplace'], "event" => "CHR", "entity" => $personID, "type" => "I"], $row['altbirthdatetr']);
}
if ($row['sex'] == "M") {
    $sex = _('Male');
    $spouse = "wife";
    $self = "husband";
    $spouseorder = "husborder";
} else {
    if ($row['sex'] == "F") {
        $sex = _('Female');
        $spouse = "husband";
        $self = "wife";
        $spouseorder = "wifeorder";
    } else {
        $sex = _('Unknown');
        $spouseorder = "";
    }
}
setEvent(["text" => _('Gender'), "fact" => $sex], $nodate);

if ($rights['both']) {
    if ($rights['lds']) {
        setEvent(["text" => _('Baptized (LDS)'), "fact" => $stdex['BAPL'], "date" => $row['baptdate'], "place" => $row['baptplace'], "event" => "BAPL", "entity" => $personID, "type" => "I"], $row['baptdatetr']);
        setEvent(["text" => _('Confirmed (LDS)'), "fact" => $stdex['CONL'], "date" => $row['confdate'], "place" => $row['confplace'], "event" => "CONL", "entity" => $personID, "type" => "I"], $row['confdatetr']);
        setEvent(["text" => _('Initiatory (LDS)'), "fact" => $stdex['INIT'], "date" => $row['initdate'], "place" => $row['initplace'], "event" => "INIT", "entity" => $personID, "type" => "I"], $row['initdatetr']);
        setEvent(["text" => _('Endowed (LDS)'), "fact" => $stdex['ENDL'], "date" => $row['endldate'], "place" => $row['endlplace'], "event" => "ENDL", "entity" => $personID, "type" => "I"], $row['endldatetr']);
    }

    doCustomEvents($personID, "I");

    setEvent(["text" => _('Died'), "fact" => $stdex['DEAT'], "date" => $row['deathdate'], "place" => $row['deathplace'], "event" => "DEAT", "entity" => $personID, "type" => "I"], $row['deathdatetr']);
    $burialmsg = $row['burialtype'] ? _('Cremated') : _('Buried');
    setEvent(["text" => $burialmsg, "fact" => $stdex['BURI'], "date" => $row['burialdate'], "place" => $row['burialplace'], "event" => "BURI", "entity" => $personID, "type" => "I"], $row['burialdatetr']);
}

ksort($events);
foreach ($events as $event)
    $persontext .= showEvent($event);

if ($rights['both']) {
    $assocresult = getAssociations($tree, $personID);
    while ($assoc = tng_fetch_assoc($assocresult)) {
        $persontext .= showEvent(["text" => _('Association'), "fact" => formatAssoc($assoc)]);
    }
    tng_free_result($assocresult);
}

$notes = "";
if ($notestogether == 1) {
    if ($rights['both']) {
        $notes = buildGenNotes($indnotes, $personID, "--x-general-x--");
    } elseif ($row['living']) {
        $notes = _('At least one living or private individual is linked to this note - Details withheld.');
    }

    if ($notes) {
        $persontext .= "<tr>\n";
        $persontext .= "<td class='align-top fieldnameback' id=\"notes1\"><span class='fieldname'>" . _('Notes') . "&nbsp;</span></td>\n";
        $persontext .= "<td class='databack' colspan='2'><div class='notearea'>$notes</div></td>\n";
        $persontext .= "</tr>\n";
        $notes = ""; //wipe it out so we don't get a link at the top
    }
}

$persontext .= showEvent(["text" => _('Person ID'), "date" => $personID, "place" => $treestr, "np" => 1]);
if ($row['changedate'] || ($allow_edit && $rightbranch)) {
    $row['changedate'] = displayDate($row['changedate'], false);
    if ($allow_edit && $rightbranch) {
        if ($row['changedate']) $row['changedate'] .= " | ";

        $row['changedate'] .= "<a href=\"admin_editperson.php?personID=$personID&amp;tree=$tree&amp;cw=1\" target=\"_blank\">" . _('Edit') . "</a>";
    }
    $persontext .= showEvent(["text" => _('Last Modified Date'), "fact" => $row['changedate']]);
}

$persontext .= "</table>\n";
$persontext .= "<br>\n";

if (empty($tngconfig['hidedna']) && $rights['both']) {
    include "dna_test_results_lib.php";
}

//do parents
$parents = getChildParentsFamily($tree, $personID);

if ($parents && tng_num_rows($parents)) {
    while ($parent = tng_fetch_assoc($parents)) {
        $persontext .= "<table class='whiteback tfixed'>\n";
        $persontext .= "<col class='labelcol'/><col style=\"width:{$datewidth}px;\"/><col />\n";
        $tableid = "fam" . $parent['familyID'] . "_";
        $cellnumber = 0;
        resetEvents();
        getCitations($personID . "::" . $parent['familyID']);
        $gotfather = getParentData($tree, $parent['familyID'], "husband");

        if ($gotfather) {
            $fathrow = tng_fetch_assoc($gotfather);
            $birthinfo = getBirthInfo($fathrow);
            $frights = determineLivingPrivateRights($fathrow, $righttree);
            $fathrow['allow_living'] = $frights['living'];
            $fathrow['allow_private'] = $frights['private'];
            if ($fathrow['firstname'] || $fathrow['lastname']) {
                $fathname = getName($fathrow);
                $fatherlink = "<a href=\"getperson.php?personID={$fathrow['personID']}&amp;tree=$tree\">$fathname</a>";
            } else {
                $fatherlink = "";
            }
            if ($frights['both']) {
                $fatherlink .= $birthinfo;
                if ($fatherlink) {
                    $age = age($fathrow);
                    if ($age) $fatherlink .= " &nbsp;(" . _('Age') . " $age)";

                }
            }
            $label = $fathrow['sex'] == "F" ? _('Mother') : _('Father');
            $persontext .= showEvent(["text" => $label, "fact" => $fatherlink]);
            if ($rights['both'] && $parent['frel']) {
                $rel = $parent['frel'];
                $relstr = $admtext[$rel] ? $admtext[$rel] : $rel;
                $persontext .= showEvent(["text" => _('Relationship'), "fact" => $relstr]);
            }
            tng_free_result($gotfather);
        }

        $gotmother = getParentData($tree, $parent['familyID'], "wife");

        if ($gotmother) {
            $mothrow = tng_fetch_assoc($gotmother);
            $birthinfo = getBirthInfo($mothrow);
            $mrights = determineLivingPrivateRights($mothrow, $righttree);
            $mothrow['allow_living'] = $mrights['living'];
            $mothrow['allow_private'] = $mrights['private'];
            if ($mothrow['firstname'] || $mothrow['lastname']) {
                $mothname = getName($mothrow);
                $motherlink = "<a href=\"getperson.php?personID={$mothrow['personID']}&amp;tree=$tree\">$mothname</a>";
            } else {
                $motherlink = "";
            }
            if ($mrights['both']) {
                $motherlink .= $birthinfo;
                if ($motherlink) {
                    $age = age($mothrow);
                    if ($age) $motherlink .= " &nbsp;(" . _('Age') . " $age)";

                }
            }
            $label = $mothrow['sex'] == "M" ? _('Father') : _('Mother');
            $persontext .= showEvent(["text" => $label, "fact" => $motherlink]);
            if ($rights['both'] && $parent['mrel']) {
                $rel = $parent['mrel'];
                $relstr = $admtext[$rel] ? $admtext[$rel] : $rel;
                $persontext .= showEvent(["text" => _('Relationship'), "fact" => $relstr]);
            }
            tng_free_result($gotmother);
        }

        if ($rights['both'] && $rights['lds'] && (empty($tngconfig['pardata']) || $tngconfig['pardata'] < 2)) {
            setEvent(["text" => _('Sealed to Parents (LDS)'), "date" => $parent['sealdate'], "place" => $parent['sealplace'], "event" => "SLGC", "entity" => "$personID::{$parent['familyID']}", "type" => "C", "nomap" => 1], $parent['sealdatetr']);
        }

        $gotparents = getFamilyData($tree, $parent['familyID']);
        $parentrow = tng_fetch_assoc($gotparents);
        tng_free_result($gotparents);
        $parent['personID'] = "";

        if (empty($tngconfig['pardata']) || $tngconfig['pardata'] < 2) {
            $prights = determineLivingPrivateRights($parentrow, $righttree);
            $parentrow['allow_living'] = $prights['living'];
            $parentrow['allow_private'] = $prights['private'];

            if ($prights['both'] && (!$gotfather || $frights['both']) && (!$gotmother || $mrights['both'])) {
                if (empty($tngconfig['pardata'])) {
                    $famnotes = getNotes($parent['familyID'], "F");
                    getCitations($parent['familyID']);
                    $stdexf = getStdExtras($parent['familyID']);
                    if (!isset($stdexf['MARR'])) $stdexf['MARR'] = '';
                    if (!isset($stdexf['DIV'])) $stdexf['DIV'] = '';
                    if (!empty($parent['marrtype'])) {
                        if (!is_array($stdexf['MARR'])) $stdexf['MARR'] = [];

                        array_unshift($stdexf['MARR'], _('Type') . ": " . $parent['marrtype']);
                    }
                }

                setEvent(["text" => _('Married'), "fact" => $stdexf['MARR'], "date" => $parentrow['marrdate'], "place" => $parentrow['marrplace'], "event" => "MARR", "entity" => $parentrow['familyID'], "type" => "F", "nomap" => 1], $parentrow['marrdatetr']);
                setEvent(["text" => _('Divorced'), "fact" => $stdexf['DIV'], "date" => $parentrow['divdate'], "place" => $parentrow['divplace'], "event" => "DIV", "entity" => $parentrow['familyID'], "type" => "F", "nomap" => 1], $parentrow['divdatetr']);

                if (empty($tngconfig['pardata'])) {
                    doCustomEvents($parent['familyID'], "F", 1);
                    $fammedia = getMedia($parentrow, "F");
                    $famalbums = getAlbums($parentrow, "F");
                }

                ksort($events);
                foreach ($events as $event)
                    $persontext .= showEvent($event);

                $assocresult = getAssociations($tree, $parent['familyID']);
                while ($assoc = tng_fetch_assoc($assocresult)) {
                    $persontext .= showEvent(["text" => _('Association'), "fact" => formatAssoc($assoc)]);
                }
                tng_free_result($assocresult);

                if (empty($tngconfig['pardata'])) {
                    $famnotes2 = "";
                    if (!$notestogether) {
                        $famnotes2 = buildNotes($famnotes, $parent['familyID']);
                    } else {
                        $famnotes2 = buildGenNotes($famnotes, $parent['familyID'], "--x-general-x--");
                    }

                    if ($famnotes2) {
                        $persontext .= "<tr>\n";
                        $persontext .= "<td class='align-top fieldnameback'><span class='fieldname'>" . _('Notes') . "&nbsp;</span></td>\n";
                        $persontext .= "<td class='databack' colspan='2'><span class='normal'><div class=\"notearea\">$famnotes2</div></span></td>\n";
                        $persontext .= "</tr>\n";
                    }

                    foreach ($mediatypes as $mediatype) {
                        $mediatypeID = $mediatype['ID'];
                        $persontext .= writeMedia($fammedia, $mediatypeID, "p" . $parent['familyID']);
                    }
                    $persontext .= writeAlbums($famalbums);
                }
            }
        }

        $persontext .= showEvent(["text" => _('Family ID'), "date" => $parent['familyID'], "place" => "<a href=\"familygroup.php?familyID={$parent['familyID']}&amp;tree=$tree\">" . _('Group Sheet') . "</a>&nbsp; | &nbsp;<a href='familychart.php?familyID={$parent['familyID']}&amp;tree=$tree'>" . _('Family Chart') . "</a>", "np" => 1]);
        $persontext .= "</table>\n";
        $persontext .= "<br>\n";
    }
    tng_free_result($parents);
}

$marriages = getSpouseFamilyFullUnion($tree, $personID);
$marrtot = tng_num_rows($marriages);
$marrcount = 1;

while ($marriagerow = tng_fetch_assoc($marriages)) {
    $persontext .= "<table class='whiteback tfixed'>\n";
    $persontext .= "<col class='labelcol'/><col style=\"width:{$datewidth}px;\"/><col />\n";
    $tableid = "fam" . $marriagerow['familyID'] . "_";
    $cellnumber = 0;
    $famnotes = getNotes($marriagerow['familyID'], "F");
    getCitations($marriagerow['familyID']);
    $stdexf = getStdExtras($marriagerow['familyID']);

    if (!isset($stdexf['MARR'])) $stdexf['MARR'] = '';
    if (!isset($stdexf['DIV'])) $stdexf['DIV'] = '';
    if (!isset($stdexf['SLGS'])) $stdexf['SLGS'] = '';

    if ($marriagerow['marrtype']) {
        if (!is_array($stdexf['MARR'])) $stdexf['MARR'] = [];

        array_unshift($stdexf['MARR'], _('Type') . ": " . $marriagerow['marrtype']);
    }

    $spouse = $marriagerow['husband'] == $personID ? 'wife' : 'husband';
    unset($spouserow);
    unset($birthinfo);
    if ($marriagerow[$spouse]) {
        $spouseresult = getPersonData($tree, $marriagerow[$spouse]);
        $spouserow = tng_fetch_assoc($spouseresult);
        $birthinfo = getBirthInfo($spouserow);
        $srights = determineLivingPrivateRights($spouserow, $righttree);
        $spouserow['allow_living'] = $srights['living'];
        $spouserow['allow_private'] = $srights['private'];
        if ($spouserow['firstname'] || $spouserow['lastname']) {
            $spousename = getName($spouserow);
            $spouselink = "<a href=\"getperson.php?personID={$spouserow['personID']}&amp;tree=$tree\">$spousename</a>";
        }
        if ($srights['both']) {
            $spouselink .= $birthinfo;
            if ($spouselink) {
                $age = age($spouserow);
                if ($age) $spouselink .= " &nbsp;(" . _('Age') . " $age)";

            }
        }
        tng_free_result($spouseresult);
    } else {
        $spouselink = "";
        $srights['both'] = true;
    }
    $marrstr = $marrtot > 1 ? " $marrcount" : "";
    if ($srights['both']) {
        $persontext .= showEvent(["text" => "" . _('Family') . "$marrstr", "fact" => $spouselink, "entity" => $marriagerow['familyID'], "type" => "F"]);
    } else {
        $persontext .= showEvent(["text" => "" . _('Family') . "$marrstr", "fact" => $spouselink]);
    }

    $rightfbranch = checkbranch($marriagerow['branch']) ? 1 : 0;
    $marrights = determineLivingPrivateRights($marriagerow, $righttree);
    $marriagerow['allow_living'] = $marrights['living'];
    $marriagerow['allow_private'] = $marrights['private'];
    $fammedia = getMedia($marriagerow, "F");
    $famalbums = getAlbums($marriagerow, "F");
    if ($marrights['both'] && $srights['both']) {
        resetEvents();

        setEvent(["text" => _('Married'), "fact" => $stdexf['MARR'], "date" => $marriagerow['marrdate'], "place" => $marriagerow['marrplace'], "event" => "MARR", "entity" => $marriagerow['familyID'], "type" => "F"], $marriagerow['marrdatetr']);
        setEvent(["text" => _('Divorced'), "fact" => $stdexf['DIV'], "date" => $marriagerow['divdate'], "place" => $marriagerow['divplace'], "event" => "DIV", "entity" => $marriagerow['familyID'], "type" => "F"], $marriagerow['divdatetr']);

        if ($marrights['lds']) {
            setEvent(["text" => _('Sealed to Spouse (LDS)'), "fact" => $stdexf['SLGS'], "date" => $marriagerow['sealdate'], "place" => $marriagerow['sealplace'], "event" => "SLGS", "entity" => $marriagerow['familyID'], "type" => "F"], $marriagerow['sealdatetr']);
        }

        doCustomEvents($marriagerow['familyID'], "F");
        ksort($events);
        foreach ($events as $event)
            $persontext .= showEvent($event);

        $assocresult = getAssociations($tree, $marriagerow['familyID']);
        while ($assoc = tng_fetch_assoc($assocresult)) {
            $persontext .= showEvent(["text" => _('Association'), "fact" => formatAssoc($assoc)]);
        }
        tng_free_result($assocresult);

        $famnotes2 = "";
        if (!$notestogether) {
            $famnotes2 = buildNotes($famnotes, $marriagerow['familyID']);
        } else {
            $famnotes2 = buildGenNotes($famnotes, $marriagerow['familyID'], "--x-general-x--");
        }

        if ($famnotes2) {
            $persontext .= "<tr>\n";
            $persontext .= "<td class='align-top fieldnameback'><span class='fieldname'>" . _('Notes') . "&nbsp;</span></td>\n";
            $persontext .= "<td class='databack' colspan='2'><span class='normal'><div class=\"notearea\">$famnotes2</div></span></td>\n";
            $persontext .= "</tr>\n";
        }
    }
    $marrcount++;

    //do children
    $children = getChildrenData($tree, $marriagerow['familyID']);

    if ($children && tng_num_rows($children)) {
        $persontext .= "<tr>\n";
        $persontext .= "<td class='align-top fieldnameback'><span class='fieldname'>" . _('Children') . "&nbsp;</span></td>\n";
        $persontext .= "<td class='databack' colspan='2'>\n";

        $kidcount = 1;
        $persontext .= "<table class='w-full'>\n";
        while ($child = tng_fetch_assoc($children)) {
            $childID = $child['personID'];
            $child['gedcom'] = $tree;
            $ifkids = $child['haskids'] ? "<a href=\"descend.php?personID=$childID&amp;tree=$tree\" title='" . _('Descendants') . "' class='text-decoration-none'><strong>+</strong></a>" : "&nbsp;";
            $birthinfo = getBirthInfo($child);
            $crights = determineLivingPrivateRights($child, $righttree);
            $child['allow_living'] = $crights['living'];
            $child['allow_private'] = $crights['private'];
            if ($child['firstname'] || $child['lastname']) {
                $childname = getName($child);
                $persontext .= "<tr>";
                $persontext .= "<td class='w-3 align-top'>$ifkids</td>";
                $persontext .= "<td onmouseover=\"highlightChild(1,'$childID');\" onmouseout=\"highlightChild(0,'$childID');\" class='unhighlightedchild' id=\"child$childID\"><span class='normal'>$kidcount. <a href=\"getperson.php?personID=$childID&amp;tree=$tree\">$childname</a>";
                if ($crights['both']) {
                    $persontext .= $birthinfo;
                    $age = age($child);
                    if ($age) $persontext .= " &nbsp;(" . _('Age') . " $age)";

                    $frel = strtolower($child['frel']);
                    $frelstr = isset($admtext[$frel]) ? $admtext[$frel] : $child['frel'];

                    $mrel = strtolower($child['mrel']);
                    $mrelstr = isset($admtext[$mrel]) ? $admtext[$mrel] : $child['mrel'];

                    if ($child['frel']) $persontext .= " &nbsp;[$frelstr]";

                    if ($child['mrel'] && $child['mrel'] != $child['frel']) {
                        $persontext .= " &nbsp;[$mrelstr]";
                    }
                }
                $persontext .= "</span></td>";
                $persontext .= "</tr>\n";
                $kidcount++;
            }
        }
        $persontext .= "</table>\n";
        $persontext .= "</td>\n";
        $persontext .= "</tr>\n";

        tng_free_result($children);
    }

    foreach ($mediatypes as $mediatype) {
        $mediatypeID = $mediatype['ID'];
        $persontext .= writeMedia($fammedia, $mediatypeID, "s" . $marriagerow['familyID']);
    }
    $persontext .= writeAlbums($famalbums);

    if ($marriagerow['changedate'] || ($allow_edit && $rightfbranch)) {
        $marriagerow['changedate'] = displayDate($marriagerow['changedate']);
        if ($allow_edit && $rightfbranch) {
            if ($marriagerow['changedate']) {
                $marriagerow['changedate'] .= " | ";
            }
            $marriagerow['changedate'] .= "<a href=\"admin_editfamily.php?familyID={$marriagerow['familyID']}&amp;tree=$tree&amp;cw=1\" target=\"_blank\">" . _('Edit') . "</a>";
        }
        $persontext .= showEvent(["text" => _('Last Modified Date'), "fact" => $marriagerow['changedate']]);
    }
    $persontext .= showEvent(["text" => _('Family ID'), "date" => $marriagerow['familyID'], "place" => "<a href=\"familygroup.php?familyID={$marriagerow['familyID']}&amp;tree=$tree\">" . _('Group Sheet') . "</a>&nbsp; | &nbsp;<a href='familychart.php?familyID={$marriagerow['familyID']}&amp;tree=$tree'>" . _('Family Chart') . "</a>", "np" => 1]);
    $persontext .= "</table>\n";
    $persontext .= "<br>\n";
}
tng_free_result($marriages);

$persontext .= endSection("info");

if ($map['key'] && $locations2map) {
    $persontext .= beginSection("eventmap");
    $persontext .= "<table class='whiteback tfixed'>\n";
    $persontext .= "<col class='labelcol'/><col class='mapcol'/><col />\n";
    $persontext .= "<tr class='align-top'>\n";
    $persontext .= "<td id='eventmap1' class='p-2 fieldnameback indleftcol'><span class='fieldname'>" . _('Event Map') . "</span></td>\n";
    $persontext .= "<td class='w-full p-2 mx-auto databack'>\n";
    $persontext .= "<div id='map' class='rounded-lg' style=\"width: {$map['indw']}; height: {$map['indh']};\">";
    if ($map['pstartoff']) {
        $persontext .= "<a href='#' onclick=\"ShowTheMap(); return false;\"><div class=\"loadmap\">" . _('Load the map') . "<br><img src=\"img/loadmap.gif\" alt=\"\" width=\"150\" height=\"150\"></div></a>";
    }
    $persontext .= "</div>\n";
    $persontext .= "</td>\n";
    $mapheight = (intval($map['indh']) - 20) . "px";
    $persontext .= "<td class='hidden lg:table-cell databack'>";
    $persontext .= "<div style=\"height:{$mapheight};\" id='mapevents'>";
    $persontext .= "<table class='whiteback'>\n";

    asort($locations2map);
    reset($locations2map);
    $markerIcon = 0;
    $nonzeroplaces = 0;
    $usedplaces = [];
    $savedplaces = [];
    foreach ($locations2map as $key => $val) {
        // RM these next lines are about getting different coloured pins for different levels of place
        $placelevel = $val['placelevel'];
        $pinplacelevel = $val['pinplacelevel'];
        if (!$placelevel) {
            $placelevel = 0;
        } else {
            $nonzeroplaces++;
        }
        if (!$pinplacelevel) $pinplacelevel = $pinplacelevel0;

        $lat = $val['lat'];
        $long = $val['long'];
        $zoom = $val['zoom'] ? $val['zoom'] : 10;
        $event = $val['event'];
        $place = $val['place'];
        $dateforremoteballoon = $dateforeventtable = displayDate($val['eventdate']);
        $dateforlocalballoon = @htmlspecialchars(tng_real_escape_string($dateforremoteballoon), ENT_QUOTES, $session_charset);
        $description = is_array($val['description']) ? implode(",", $val['description']) : $val['description'];
        $balloondesc = str_replace("\n", " ", $description);
        if ($place) {
            $persontext .= "<tr class='align-top'>";
            $persontext .= "<td class='databack'>";
            if ($lat && $long) {
                $directionplace = @htmlspecialchars(stri_replace($banish, $banreplace, $place), ENT_QUOTES, $session_charset);
                $directionballoontext = @htmlspecialchars(stri_replace($banish, $banreplace, $place), ENT_QUOTES, $session_charset);
                $googleMapsUrl = "$http://maps.google.com/maps?f=q" . _('&amp;hl=en') . "&amp;daddr=$lat,$long($directionballoontext)&amp;z=$zoom&amp;om=1&amp;iwloc=addr";
                if ($map['showallpins'] || !in_array($place, $usedplaces)) {
                    $markerIcon++;
                    $usedplaces[] = $place;
                    $savedplaces[] = ["place" => $place, "key" => $key];
                    $locations2map[$key]['htmlcontent'] = "<div class=\"mapballoon normal mt-2\">";
                    $locations2map[$key]['htmlcontent'] .= "<p><span class=\"font-medium\">{$val['fixedplace']}</span><br><a href=\"$googleMapsUrl\" target=\"_blank\">" . _('Click to get directions') . "</a></p>" . addslashes($event) . ": $dateforlocalballoon";
                    $locations2map[$key]['htmlcontent'] .= "</div>";
                    $thismarker = $markerIcon;
                } else {
                    $total = count($usedplaces);
                    for ($i = 0; $i < $total; $i++) {
                        if ($savedplaces[$i]['place'] == $place) {
                            $thismarker = $i + 1;
                            $thiskey = $savedplaces[$i]['key'];
                            $locations2map[$thiskey]['htmlcontent'] = str_replace("</div>", "<br>$event: $dateforlocalballoon</div>", $locations2map[$thiskey]['htmlcontent']);
                            break;
                        }
                    }
                }
                $persontext .= "<a href=\"$googleMapsUrl\" target= \"_blank\"><img src='google_marker.php?image=$pinplacelevel.png&amp;text=$thismarker' alt='" . _('Link to Google Maps') . "' width= '10' height='17'></a>";
                $map['pins']++;
            } else {
                $persontext .= "&nbsp;";
            }
            $persontext .= "</td>";
            $persontext .= "<td class='p-1 text-xs databack'><span class='font-semibold'>$event</span>";
            if ($description) $persontext .= " - $description";
            $persontext .= " $dateforeventtable<br>$place</td>\n";
            $googleEarthUrl = "googleearthbylatlong.php?m=world&amp;n=$directionplace&amp;lon=$long&amp;lat=$lat&amp;z=$zoom";
            $googleEarthLink = "<a href=\"$googleEarthUrl\" title=\"" . _('Download a .kml file to show this location in Google Earth') . "\"><img src='img/earth.gif' alt='" . _('Link to Google Earth') . "' width='15' height='15'></a>";
            $persontext .= "<td class='w-3 align-middle databack'>$googleEarthLink</td>\n";
            $persontext .= "</tr>\n";
            if ($val['notes']) {
                $locations2map[$key]['htmlcontent'] = str_replace("</div>", "<br><br>" . tng_real_escape_string($val['notes']) . "</div>", $locations2map[$key]['htmlcontent']);
            }
        }
    }
    $persontext .= "</table></div>\n";
    $persontext .= "</td>\n";
    $persontext .= "</tr>\n";
    if ($nonzeroplaces) {
        $persontext .= "<tr class='align-top'><td class='fieldnameback'><span class='fieldname'>" . _('Pin Legend') . "</span></td>\n";
        $persontext .= "<td colspan='2' class='databack'><span class='smaller'>";
        for ($i = 1; $i < 7; $i++) {
            $persontext .= "<img src=\"img/" . ${"pinplacelevel" . $i} . ".png\" alt='' height='17' width='10' class='align-middle'>&nbsp;: " . _("Not Set") . " &nbsp;&nbsp;&nbsp;&nbsp;\n";
        }
        $persontext .= "<img src=\"img/$pinplacelevel0.png\" alt='' height='17' width='10' class='align-top'>&nbsp;: {$admtext['level0']}</span></td>\n";
        $persontext .= "</tr>\n";
    }
    $persontext .= "</table>\n";
    $persontext .= "<br>\n";
    $persontext .= endSection("eventmap");
}

if (empty($tng_extras)) {
    $media = doMediaSection($personID, $indmedia, $indalbums);
    if ($media) {
        $persontext .= beginSection("media");
        $persontext .= $media . "<br>\n";
        $persontext .= endSection("media");
    }
}

if ($notestogether != 1) {
    if ($rights['both']) {
        $notes = $notestogether ? buildGenNotes($indnotes, $personID, "--x-general-x--") : buildNotes($indnotes, $personID);
    } else {
        $notes = _('At least one living or private individual is linked to this note - Details withheld.');
    }

    if ($notes) {
        $persontext .= beginSection("notes");
        $persontext .= "<table class='whiteback tfixed'>\n";
        $persontext .= "<col class='labelcol'/><col />\n";
        $persontext .= "<tr>\n";
        $persontext .= "<td class='p-1 align-top fieldnameback indleftcol' id='notes1'><span class='fieldname'>" . _('Notes') . "&nbsp;</span></td>\n";
        $persontext .= "<td class='p-1 databack'>$notes</td>\n";
        $persontext .= "</tr>\n";
        $persontext .= "</table>\n";
        $persontext .= "<br>\n";
        $persontext .= endSection("notes");
    }
}

if ($citedispctr) {
    $persontext .= beginSection("citations");
    $persontext .= "<table class='whiteback tfixed'>\n";
    $persontext .= "<col class='labelcol'/><col />\n";
    $persontext .= "<tr>\n";
    $persontext .= "<td class='p-1 align-top fieldnameback indleftcol' id='citations1'><a name='sources'><span class='fieldname'>" . _('Sources') . "&nbsp;</span></a></td>\n";
    $persontext .= "<td class='p-1 databack'>";
    if (!empty($tngconfig['scrollcite'])) {
        $persontext .= "<div class='notearea'>";
    }
    $persontext .= "<ol class='normal citeblock'>";
    $citectr = 0;
    $count = count($citestring);
    foreach ($citestring as $cite) {
        $persontext .= "<li class='normal'><a name=\"cite" . ++$citectr . "\"></a>$cite<br>";
        if ($citectr < $count) $persontext .= "<br>";

        $persontext .= "</li>\n";
    }
    $persontext .= "</ol>";
    if (!empty($tngconfig['scrollcite'])) $persontext .= "</div>";

    $persontext .= "</td>\n";
    $persontext .= "</tr>\n";
    $persontext .= "</table><br>\n";
    $persontext .= endSection("citations");
}
$persontext .= "</ul>\n";

$tng_alink = $tng_plink = $tng_mlink = $tng_glink = "lightlink";
if (!empty($media) || $notes || $citedispctr || $map['key']) {
    if ($tngconfig['istart']) {
        if (!empty($tng_extras)) {
            $tng_mlink = "lightlink3";
        } else {
            $tng_plink = "lightlink3";
        }
    } else {
        $tng_alink = "lightlink3";
    }
    $innermenu = $num_collapsed ? "<div style=\"float:right;\"><a href='#' onclick=\"{$showdnatest}return toggleCollapsed(0)\" class='lightlink'>" . _('Expand all') . "</a> &nbsp; | &nbsp; <a href='#' onclick=\"{$hidednatest}return toggleCollapsed(1)\" class='lightlink'>" . _('Collapse all') . "</a> &nbsp;</div>" : "";
    $innermenu .= "<a href='#' class=\"$tng_plink\" onclick=\"return infoToggle('info');\" id=\"tng_plink\">" . _('Personal information only') . "</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
    if (!empty($media)) {
        $innermenu .= "<a href='#' class=\"$tng_mlink\" onclick=\"return infoToggle('media');\" id=\"tng_mlink\">" . _('Media') . "</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
    }
    if ($notes) {
        $innermenu .= "<a href='#' class='lightlink' onclick=\"return infoToggle('notes');\" id=\"tng_nlink\">" . _('Notes') . "</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
    }
    if ($citedispctr) {
        $innermenu .= "<a href='#' class='lightlink' onclick=\"return infoToggle('citations');\" id=\"tng_clink\">" . _('Sources') . "</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
    }
    if ($map['key'] && $locations2map) {
        $innermenu .= "<a href='#' class='lightlink' onclick=\"return infoToggle('eventmap');\" id=\"tng_glink\">" . _('Event Map') . "</a> &nbsp;&nbsp; | &nbsp;&nbsp; \n";
    }
    $innermenu .= "<a href='#' class=\"$tng_alink\" onclick=\"return infoToggle('all');\" id=\"tng_alink\">" . _('All') . "</a>\n";
} else {
    $innermenu = "<span class=\"lightlink3\" id=\"tng_plink\">" . _('Personal information only') . "</span>\n";
}
if ($allowpdf) {
    $innermenu .= " &nbsp;&nbsp; | &nbsp;&nbsp; <a href='#' class='lightlink' ";
    $innermenu .= "onclick=\"tnglitbox = new LITBox('rpt_pdfform.php?pdftype=ind&amp;personID=$personID&amp;tree=$tree', {width: 400, height: 480}); return false;\">PDF</a>\n";
}

$rightbranch = $org_rightbranch;
echo tng_menu("I", "person", $personID, $innermenu);
?>
    <script>
        const collapse = "<?php echo _('Collapse'); ?>";
        const expand = "<?php echo _('Expand'); ?>";
    </script>
    <script src="js/getperson.js"></script>
    <script>
        function infoToggle(part) {
            if (part === "all") {
                jQuery('#info').show();
                <?php
                if (!empty($media)) {
                    echo "\$('#media').show();\n";
                    echo "\$('#tng_mlink').attr('class','lightlink');\n";
                }
                if ($notes) {
                    echo "\$('#notes').show();\n";
                    echo "\$('#tng_nlink').attr('class','lightlink');\n";
                }
                if ($citedispctr) {
                    echo "\$('#citations').show();\n";
                    echo "\$('#tng_clink').attr('class','lightlink');\n";
                }
                if ($map['key'] && $locations2map) {
                    echo "\$('#eventmap').show();\n";
                    echo "\$('#tng_glink').attr('class','lightlink');\n";
                }
                ?>
                jQuery('#tng_alink').attr('class', 'lightlink3');
                jQuery('#tng_plink').attr('class', 'lightlink');
            } else {
                innerToggle(part, "info", "tng_plink");
                <?php
                if (!empty($media)) {
                    echo "innerToggle(part,\"media\",\"tng_mlink\");\n";
                }
                if ($notes) echo "innerToggle(part,\"notes\",\"tng_nlink\");\n";

                if ($citedispctr) {
                    echo "innerToggle(part,\"citations\",\"tng_clink\");\n";
                }
                if ($map['key'] && $locations2map) {
                    echo "innerToggle(part,\"eventmap\",\"tng_glink\");\n";
                }
                ?>
                jQuery('#tng_alink').attr('class', 'lightlink');
            }
            <?php
            if ($map['key'] && $locations2map && $tngconfig['istart']) {
                echo "if((part==\"eventmap\" || part==\"all\") && !maploaded) {\n";
                echo "ShowTheMap();\n}\n";
            }
            ?>
            return false;
        }
    </script>

<?php
echo $persontext;
?>
    </div>
    <br>

<?php
if (!isset($flags['more'])) $flags['more'] = "";
if ($map['key'] && $locations2map && $tngconfig['istart']) {
    $flags['more'] .= "\n<script>";
    $flags['more'] .= "window.onload = function() {\$('#eventmap').hide();};\n";
    $flags['more'] .= "</script>\n";
}

$flags['more'] .= "<script src=\"js/rpt_utils.js\"></script>\n";
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