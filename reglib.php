<?php
function getSpouses($personID, $sex) {
    global $tree, $righttree;

    $spouses = [];
    if ($sex == "M") {
        $self = "husband";
        $spouse = "wife";
        $spouseorder = "husborder";
    } else {
        if ($sex == "F") {
            $self = "wife";
            $spouse = "husband";
            $spouseorder = "wifeorder";
        } else {
            $self = $spouse = $spouseorder = "";
        }
    }

    if ($spouse) {
        $result = getSpouseFamilyData($tree, $self, $personID, $spouseorder);
    } else {
        $result = getSpouseFamilyDataUnion($tree, $personID, $spouseorder);
    }
    $marrtot = tng_num_rows($result);
    if (!$marrtot) {
        $result = getSpouseFamilyDataUnion($tree, $personID, $spouseorder);
        $self = $spouse = $spouseorder = "";
    }
    while ($row = tng_fetch_assoc($result)) {
        if (!$spouse) {
            $spouse = $row['husband'] == $personID ? "wife" : "husband";
        }
        $result2 = getPersonData($tree, $row[$spouse]);
        $spouserow = tng_fetch_assoc($result2);
        $spouserow['familyID'] = $row['familyID'];
        $spouserow['marrdate'] = $row['marrdate'];
        $spouserow['marrplace'] = $row['marrplace'];
        $spouserow['marrtype'] = $row['marrtype'];
        $spouserow['divdate'] = $row['divdate'];
        $spouserow['divplace'] = $row['divplace'];
        $spouserow['fliving'] = $row['living'];

        $famrights = determineLivingPrivateRights($row, $righttree);
        $sprights = determineLivingPrivateRights($spouserow, $righttree);
        $spouserow['allow_living'] = $sprights['living'] && $famrights['living'];
        $spouserow['allow_private'] = $sprights['private'] && $famrights['private'];

        $spouserow['name'] = getName($spouserow);
        array_push($spouses, $spouserow);
    }
    tng_free_result($result);

    return $spouses;
}

function getSpouseParents($personID, $sex) {
    global $tree, $righttree, $text, $admtext;

    if ($sex == "M") {
        $childtext = tng_strtolower(_('son of'));
    } else {
        if ($sex == "F") {
            $childtext = tng_strtolower(_('daughter of'));
        } else {
            $childtext = tng_strtolower(_('child of'));
        }
    }

    $allparents = "";
    $parents = getChildFamily($tree, $personID, "ordernum");

    if ($parents && tng_num_rows($parents)) {
        while ($parent = tng_fetch_assoc($parents)) {
            $parentstr = "";
            $gotfather = getParentData($tree, $parent['familyID'], "husband");

            if ($gotfather) {
                $fathrow = tng_fetch_assoc($gotfather);
                if ($fathrow['firstname'] || $fathrow['lastname']) {
                    $frights = determineLivingPrivateRights($fathrow, $righttree);
                    $fathrow['allow_living'] = $frights['living'];
                    $fathrow['allow_private'] = $frights['private'];
                    $fathname = getName($fathrow);
                    if ($fathrow['name'] == _('Living')) {
                        $fathrow['firstname'] = _('Living');
                    }
                    if ($fathrow['name'] == _('Private')) {
                        $fathrow['firstname'] = _('Private');
                    }
                    $parentstr .= "<a href='#' onclick=\"if(jQuery('#p{$fathrow['personID']}').length) {jQuery('html, body').animate({scrollTop: jQuery('#p{$fathrow['personID']}').offset().top-10},'slow');}else{window.location.href='getperson.php?personID={$fathrow['personID']}&amp;tree=$tree';} return false;\">$fathname</a>";
                }
                tng_free_result($gotfather);
            }

            $gotmother = getParentData($tree, $parent['familyID'], "wife");

            if ($gotmother) {
                $mothrow = tng_fetch_assoc($gotmother);
                if ($mothrow['firstname'] || $mothrow['lastname']) {
                    $mrights = determineLivingPrivateRights($mothrow, $righttree);
                    $mothrow['allow_living'] = $mrights['living'];
                    $mothrow['allow_private'] = $mrights['private'];
                    $mothname = getName($mothrow);
                    if ($mothrow['name'] == _('Living')) {
                        $mothrow['firstname'] = _('Living');
                    }
                    if ($mothrow['name'] == _('Private')) {
                        $mothrow['firstname'] = _('Private');
                    }
                    if ($parentstr) $parentstr .= " " . _('AND') . " ";

                    $parentstr .= "<a href='#' onclick=\"if(jQuery('#p{$mothrow['personID']}').length) {jQuery('html, body').animate({scrollTop: jQuery('#p{$mothrow['personID']}').offset().top-10},'slow');}else{window.location.href='getperson.php?personID={$mothrow['personID']}&amp;tree=$tree';} return false;\">$mothname</a>";
                }
                tng_free_result($gotmother);
            }
            if ($parentstr) {
                $parentstr = "$childtext $parentstr";
                $allparents .= $allparents ? ", $parentstr" : $parentstr;
            }
        }
        tng_free_result($parents);
    }
    if ($allparents) $allparents = "($allparents)";


    return $allparents;
}

function getVitalDates($row, $needparents = null) {
    global $text;

    $vitalinfo = "";

    if ($row['allow_living'] && $row['allow_private']) {
        if ($row['birthdate'] || $row['birthplace']) {
            $bornmsg = ($row['sex'] == "F") ? _('was born') : _('was born');
            $vitalinfo .= " " . $bornmsg . printDate($row['birthdate'], $row['birthdatetr']);
            if ($row['birthplace']) {
                $vitalinfo .= " " . trim(_(' in ')) . " " . $row['birthplace'];
            }
        }
        if ($row['altbirthdate'] || $row['altbirthplace']) {
            if ($vitalinfo) $vitalinfo .= ";";

            $christenedmsg = ($row['sex'] == "F") ? _('was christened') : _('was christened');
            $vitalinfo .= " " . $christenedmsg . printDate($row['altbirthdate'], $row['altbirthdatetr']);
            if ($row['altbirthplace']) {
                $vitalinfo .= " " . trim(_(' in ')) . " " . $row['altbirthplace'];
            }
        }
        if ($needparents) {
            $spparents = getSpouseParents($row['personID'], $row['sex']);
            if ($spparents) $vitalinfo .= " " . $spparents;

        }

        if ($row['deathdate'] || $row['deathplace']) {
            if ($vitalinfo) $vitalinfo .= ";";

            $diedmsg = ($row['sex'] == "F") ? _('died') : _('died');
            if ($row['deathdate'] == "Y") {
                $vitalinfo .= " " . _('and ') . $diedmsg;
            } else {
                $vitalinfo .= " " . $diedmsg . printDate($row['deathdate'], $row['deathdatetr']);
            }
            if ($row['deathplace']) {
                $vitalinfo .= _(' in ') . $row['deathplace'];
            }
        }
        if ($row['burialdate'] || $row['burialplace']) {
            if ($vitalinfo) $vitalinfo .= ";";

            $buriedmsg = ($row['sex'] == "F") ? _('was buried') : _('was buried');
            $crematedmsg = ($row['sex'] == "F") ? _('was cremated') : _('was cremated');
            $burialmsg = $row['burialtype'] ? $crematedmsg : $buriedmsg;
            if (substr($row['burialdatetr'], 0, 10) == "0000-00-00")  // no date
            {
                $vitalinfo .= " $buriedmsg ";
            } else {
                $vitalinfo .= " " . $buriedmsg . printDate($row['burialdate'], $row['burialdatetr']);
            }
            if ($row['burialplace']) {
                $vitalinfo .= _(' in ') . $row['burialplace'];
            }
        }
    }
    if ($vitalinfo) $vitalinfo .= ". ";

    return $vitalinfo;
}

function getSpouseDates($row, $personsex) {
    global $text;

    $spouseinfo = "";

    if ($row['allow_living'] && $row['allow_private']) {
        if ($row['marrdate'] || $row['marrplace'] || $row['marrtype']) {
            $spouseinfo .= printDate($row['marrdate'], $row['marrdatetr']);
            if ($row['marrtype']) $spouseinfo .= " ({$row['marrtype']})";

            if (($row['marrdate'] || $row['marrtype']) && $row['marrplace']) {
                $spouseinfo .= _(' in ');
            }
            $spouseinfo .= $row['marrplace'];
        }
        if ($row['divdate'] || $row['divplace']) {
            $divorcemsg = ($personsex == "F") ? _('was divorced') : _('was divorced');
            if ($row['divdate']) {
                if ($row['divdate'] == "Y") {
                    $spouseinfo .= ", " . _('and ') . $divorcemsg;
                } else {
                    $spouseinfo .= ", " . _('and ') . $divorcemsg . "  " . printDate($row['divdate'], $row['divdatetr']);
                }
            }
            if ($row['divplace']) {
                $spouseinfo .= "  " . _(' in ') . $row['divplace'];
            }
        }
    }
    if ($spouseinfo) $spouseinfo .= ".";

    return $spouseinfo;
}

function getOtherEvents($row) {
    global $tree, $eventtypes_table, $events_table, $text, $pedigree;

    $otherEvents = "";
    if ($pedigree['regnotes'] && $row['allow_living'] && $row['allow_private']) {
        $query = "SELECT display, eventdate, eventdatetr, eventplace, age, agency, cause, addressID, info, tag, description, eventID ";
        $query .= "FROM ($events_table events, $eventtypes_table eventtypes) ";
        $query .= "WHERE persfamID = \"{$row['personID']}\" AND events.eventtypeID = eventtypes.eventtypeID AND gedcom = '$tree' AND keep = '1' AND parenttag = '' ";
        $query .= "ORDER BY eventdatetr, ordernum, tag, description, info, eventID";
        $custevents = tng_query($query);
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
            $extras = getFact($custevent);
            $fact = (count($fact) && $fact[0] != "") ? array_merge($fact, $extras) : $extras;
            $thisEvent = $custevent['eventdate'] ? displayDate($custevent['eventdate']) : "";
            if ($custevent['eventplace']) {
                if ($thisEvent) $thisEvent .= ", ";

                $thisEvent .= $custevent['eventplace'];
            }
            if (count($fact)) {
                foreach ($fact as $f) {
                    if ($thisEvent) $thisEvent .= "; ";

                    $thisEvent .= $f;
                }
            }
            if ($thisEvent) {
                $otherEvents .= "<li>$displayval: " . $thisEvent . "</li>\n";
            }
        }
        tng_free_result($custevents);
    }
    if ($otherEvents) {
        $otherEvents = "<p>" . _('Other Events') . ":\n<ul class=\"regevents\">$otherEvents</ul></p>\n";
    }
    return $otherEvents;
}

function getRegNotes($persfamID, $flag) {
    global $notelinks_table, $xnotes_table, $tree, $eventtypes_table, $events_table, $text;

    $custnotes = [];
    $gennotes = [];
    $precustnotes = [];
    $postcustnotes = [];
    $finalnotesarray = [];

    if ($flag == "I") {
        $precusttitles = ["BIRT" => _('Birth'), "CHR" => _('Christened'), "NAME" => _('Name'), "TITL" => _('Title'), "NSFX" => _('Suffix'), "NICK" => _('Nickname'), "BAPL" => _('Baptized (LDS)'), "CONL" => _('Confirmed (LDS)'), "INIT" => _('Initiatory (LDS)'), "ENDL" => _('Endowed (LDS)')];
        $postcusttitles = ["DEAT" => _('Died'), "BURI" => _('Buried'), "SLGC" => _('Sealed to Parents (LDS)')];
    } elseif ($flag == "F") {
        $precusttitles = ["MARR" => _('Married'), "SLGS" => _('Sealed to Spouse (LDS)'), "DIV" => _('Divorced')];
        $postcusttitles = [];
    } else {
        $precusttitles = ["ABBR" => _('Short Title'), "CALN" => _('Call Number'), "AUTH" => _('Author'), "PUBL" => _('Publisher'), "TITL" => _('Title')];
        $postcusttitles = [];
    }

    $query = "SELECT display, xnotes.note AS note, notelinks.eventID AS eventID, notelinks.ID AS ID ";
    $query .= "FROM $notelinks_table notelinks ";
    $query .= "LEFT JOIN  $xnotes_table xnotes ON notelinks.xnoteID = xnotes.ID AND notelinks.gedcom = xnotes.gedcom ";
    $query .= "LEFT JOIN $events_table events ON notelinks.eventID = events.eventID ";
    $query .= "LEFT JOIN $eventtypes_table eventtypes ON eventtypes.eventtypeID = events.eventtypeID ";
    $query .= "WHERE notelinks.persfamID='$persfamID' AND notelinks.gedcom = '$tree' AND secret!='1' ";
    $query .= "ORDER BY eventdatetr, eventtypes.ordernum, tag, notelinks.ordernum, ID";
    $notelinks = tng_query($query);

    $currevent = "";
    $type = 0;
    while ($note = tng_fetch_assoc($notelinks)) {
        if (!$note['eventID']) $note['eventID'] = "--x-general-x--";

        if ($note['eventID'] != $currevent) {
            $currevent = $note['eventID'];
            $currtitle = "";
        }
        if (!$currtitle) {
            if ($note['display']) {
                $currtitle = getEventDisplay($note['display']);
                $key = "cust$currevent";
                $custnotes[$key] = ["title" => $currtitle, "text" => ""];
                $type = 2;
            } else {
                if ($postcusttitles[$currevent]) {
                    $currtitle = $postcusttitles[$currevent];
                    $postcustnotes[$currevent] = ["title" => $postcusttitles[$currevent], "text" => ""];
                    $type = 3;
                } else {
                    $currtitle = $precusttitles[$currevent] ? $precusttitles[$currevent] : " ";
                    if ($note['eventID'] == "--x-general-x--") {
                        $gennotes[$currevent] = ["title" => $precusttitles[$currevent], "text" => ""];
                        $type = 0;
                    } else {
                        $precustnotes[$currevent] = ["title" => $precusttitles[$currevent], "text" => ""];
                        $type = 1;
                    }
                }
            }
        }
        switch ($type) {
            case 0:
                if ($gennotes[$currevent]['text']) {
                    $gennotes[$currevent]['text'] .= "<br><br>";
                }
                $gennotes[$currevent]['text'] .= nl2br($note['note']) . "\n";
                break;
            case 1:
                if ($precustnotes[$currevent]['text']) {
                    $precustnotes[$currevent]['text'] .= "<br><br>";
                }
                $precustnotes[$currevent]['text'] .= nl2br($note['note']) . "\n";
                break;
            case 2:
                if ($custnotes[$key]['text']) $custnotes[$key]['text'] .= "<br><br>";

                $custnotes[$key]['text'] .= nl2br($note['note']) . "\n";
                break;
            case 3:
                if ($postcustnotes[$currevent]['text']) {
                    $postcustnotes[$currevent]['text'] .= "<br><br>";
                }
                $postcustnotes[$currevent]['text'] .= nl2br($note['note']) . "\n";
                break;
        }
    }
    $finalnotesarray = array_merge($gennotes, $precustnotes, $custnotes, $postcustnotes);
    tng_free_result($notelinks);

    return $finalnotesarray;
}

function buildRegNotes($notearray) {
    $notes = "";
    foreach ($notearray as $key => $note) {
        if ($notes) $notes .= "<br><br>\n";

        if ($note['title']) $notes .= $note['title'] . ":<br>\n";

        $notes .= $note['text'] . "\n";
    }
    return $notes;
}
