<?php

require_once "core/html/buildSvgElement.php";
$nodate_all = "0000-00-00";
$eventctr_all = 1;
$num_collapsed = 0;
/**
 * @param $thisperson
 * @param null $noicon
 * @return string
 */
function getBirthInfo($thisperson, $noicon = null) {
    global $tngconfig, $tree;

    $varlist = ['birthdate', 'birthplace', 'altbirthdate', 'altbirthplace', 'deathdate', 'deathplace', 'burialdate', 'burialplace'];
    foreach ($varlist as $myindex) {
        if (!isset($thisperson[$myindex])) $thisperson[$myindex] = '';
    }
    $birthstring = "";

    if (!$noicon) {
        $icon = buildSvgElement("img/search.svg", ["class" => "w-3 h-3 fill-current inline-block"]);

        $treestr = !empty($tngconfig['places1tree']) ? "" : "tree=$tree&amp;";
        $placelinkbegin = " <a href=\"placesearch.php?{$treestr}psearch=";
        $placelinkend = "\" title=\"" . _('Find all individuals with events at this location') . "\">$icon</a>";
    }
    if ($thisperson['birthdate'] || ($thisperson['birthplace'] && !$thisperson['altbirthdate'])) {
        $birthstring .= ", <strong>" . _('b.') . "</strong> ";
        if ($thisperson['birthdate']) {
            $birthstring .= displayDate($thisperson['birthdate']);
        }
        if ($thisperson['birthplace']) {
            if ($thisperson['birthdate']) $birthstring .= ", ";

            $birthstring .= $thisperson['birthplace'];
            if (!$noicon) {
                $birthstring .= $placelinkbegin . urlencode($thisperson['birthplace']) . $placelinkend;
            }
        }
    } else {
        if ($thisperson['altbirthdate'] || $thisperson['altbirthplace']) {
            $birthstring .= ", <strong>" . _('c.') . "</strong> ";
            if ($thisperson['altbirthdate']) {
                $birthstring .= displayDate($thisperson['altbirthdate']);
            }
            if ($thisperson['altbirthplace']) {
                if ($thisperson['altbirthdate']) $birthstring .= ", ";

                $birthstring .= $thisperson['altbirthplace'];
                if (!$noicon) {
                    $birthstring .= $placelinkbegin . urlencode($thisperson['altbirthplace']) . $placelinkend;
                }
            }
        }
    }
    //the "noicon" flag is only set in the person preview screen. We don't want to see death info there (to keep it short)
    if (!$noicon) {
        if ($thisperson['deathdate'] || ($thisperson['deathplace'] && !$thisperson['burialdate'])) {
            $birthstring .= ", &nbsp; <strong>" . _('d.') . "</strong> ";
            if ($thisperson['deathdate']) {
                $birthstring .= displayDate($thisperson['deathdate']);
            }
            if ($thisperson['deathplace']) {
                if ($thisperson['deathdate']) $birthstring .= ", ";

                $birthstring .= $thisperson['deathplace'];
                $birthstring .= $placelinkbegin . urlencode($thisperson['deathplace']) . $placelinkend;
            }
        } else {
            if ($thisperson['burialdate'] || $thisperson['burialplace']) {
                $birthstring .= ", <strong>" . _('bur.') . "</strong> ";
                if ($thisperson['burialdate']) {
                    $birthstring .= displayDate($thisperson['burialdate']);
                }
                if ($thisperson['burialplace']) {
                    if ($thisperson['burialdate']) $birthstring .= ", ";

                    $birthstring .= $thisperson['burialplace'];
                    $birthstring .= $placelinkbegin . urlencode($thisperson['burialplace']) . $placelinkend;
                }
            }
        }
    }
    return $birthstring;
}
/**
 * @param $persfamID
 * @param int $shortcite
 */
function getCitations($persfamID, $shortcite = 1) {
    global $sources_table, $tree, $citations_table, $citations, $citationsctr, $citedisplay;

    $actualtext = $shortcite ? "" : ", actualtext";
    $citquery = "SELECT citationID, title, shorttitle, author, other, publisher, callnum, page, quay, citedate, citetext, citations.note AS note, citations.sourceID, description, eventID{$actualtext} ";
    $citquery .= "FROM $citations_table citations ";
    $citquery .= "LEFT JOIN $sources_table sources ON citations.sourceID = sources.sourceID AND sources.gedcom = citations.gedcom ";
    $citquery .= "WHERE persfamID = '$persfamID' AND citations.gedcom = '$tree' ";
    $citquery .= "ORDER BY ordernum, citationID";
    $citresult = tng_query($citquery) or die (_('Cannot execute query') . ": $citquery");

    while ($citrow = tng_fetch_assoc($citresult)) {
        $source = $citrow['sourceID'] ? "[<a href=\"showsource.php?sourceID={$citrow['sourceID']}&amp;tree=$tree\">{$citrow['sourceID']}</a>] " : "";
        $newstring = $source ? "" : $citrow['description'];
        $key = $persfamID . "_" . $citrow['eventID'];
        $citationsctr++;
        $citations[$key] = isset($citations[$key]) ? $citations[$key] . ",$citationsctr" : $citationsctr;

        $citmedia = getMedia($citrow, "C");
        $mediaoutput = "";
        if ($citmedia) {
            $mediaoutput .= "<table cellspacing='4'>";
            foreach ($citmedia as $item) {
                $mediaoutput .= "<tr>\n";
                if ($item['imgsrc']) {
                    $mediaoutput .= "<td>{$item['imgsrc']}</td>\n";
                } else {
                    $mediaoutput .= "<td></td>";
                }
                $mediaoutput .= "<td class='align-top'>{$item['name']}<br>" . nl2br($item['description']) . "</td>\n";
                $mediaoutput .= "</tr>\n";
            }
            $mediaoutput .= "</table>";
        }

        if ($citrow['shorttitle']) {
            if ($newstring) $newstring .= ", ";

            $newstring .= $citrow['shorttitle'];
        } else {
            if ($citrow['title']) {
                if ($newstring) $newstring .= ", ";

                $newstring .= $citrow['title'];
            }
        }
        if ($citrow['author']) {
            if ($newstring) $newstring .= ", ";

            $newstring .= $citrow['author'];
        }
        if ($citrow['publisher']) {
            if ($newstring) $newstring .= ", ";

            $newstring .= "({$citrow['publisher']})";
        }
        if ($citrow['callnum']) {
            if ($newstring) $newstring .= ", ";

            $newstring .= $citrow['callnum'] . ".";
        }
        if ($citrow['other']) {
            if ($newstring) $newstring .= ", ";

            $newstring .= $citrow['other'];
        }
        if ($citrow['page']) {
            if ($newstring) $newstring .= ", ";

            $newstring .= nl2br(insertLinks($citrow['page']));
        }
        if ($citrow['quay'] != "") {
            if ($newstring) $newstring .= " ";

            $newstring .= "(" . _('Reliability') . ": {$citrow['quay']})";
        }
        if ($citrow['citedate']) {
            if ($newstring) $newstring .= ", ";

            $newstring .= displayDate($citrow['citedate']);
        }
        $newstring .= substr($newstring, -1) == "." ? "" : ".";
        if ($citrow['citetext']) {
            if ($newstring) $newstring .= "<br>\n";

            $newstring .= nl2br(insertLinks($citrow['citetext']));
        }
        if ($citrow['note']) {
            if ($newstring) $newstring .= "<br>\n";

            $xarr = checkXNote($citrow['note']);
            $citrow['note'] = insertLinks($xarr[0]);
            $newstring .= nl2br($citrow['note']);
        }
        if (!$shortcite && $citrow['actualtext']) {
            if ($newstring) $newstring .= "\n\n";

            $newstring .= insertLinks($citrow['actualtext']);
        }
        $citedisplay[$citationsctr] = "$source $newstring $mediaoutput";
    }
    tng_free_result($citresult);
}
/**
 * @param $citekey
 * @param int $withlink
 * @return string
 */
function reorderCitation($citekey, $withlink = 1) {
    global $citedispctr, $citestring, $citations, $citedisplay;

    $newstring = "";
    $newcitearr = [];
    if (!empty($citations[$citekey])) {
        $citationlist = explode(',', $citations[$citekey]);
        foreach ($citationlist as $citation) {
            $newcite = $citedisplay[$citation];
            if (function_exists('array_search')) {
                $newcitecnt = array_search($newcite, $citestring);
            } else {
                $newcitecnt = 0;
            }
            if (!$newcitecnt) {
                $citedispctr++;
                $newcitecnt = $citedispctr;
                $arridx = count($citestring) + 1;
                $citestring[$arridx] = $newcite;
            }
            array_push($newcitearr, $newcitecnt);
        }
        $citations[$citekey] = "";
    }
    $newcitearr = array_unique($newcitearr);
    asort($newcitearr);
    foreach ($newcitearr as $newcite) {
        $newstring .= $newstring ? ", " : "";
        if ($withlink) {
            $newstring .= "<a href=\"#cite$newcite\" onclick=\"$('citations').style.display = '';\">$newcite</a>";
        } else {
            $newstring .= $newcite;
        }
    }
    return $newstring;
}
/**
 * @param $persfamID
 * @param $flag
 * @return array
 */
function getNotes($persfamID, $flag) {
    global $notelinks_table, $xnotes_table, $tree, $eventtypes_table, $events_table, $allow_private;

    $custnotes = [];
    $gennotes = [];
    $precustnotes = [];
    $postcustnotes = [];
    $finalnotesarray = [];

    if ($flag == "I") {
        $precusttitles = ["BIRT" => _('Born'), "CHR" => _('Christened'), "NAME" => _('Name'), "TITL" => _('Title'), "NPFX" => _('Prefix'), "NSFX" => _('Suffix'), "NICK" => _('Nickname'), "BAPL" => _('Baptized (LDS)'), "CONL" => _('Confirmed (LDS)'), "INIT" => _('Initiatory (LDS)'), "ENDL" => _('Endowed (LDS)')];
        $postcusttitles = ["DEAT" => _('Died'), "BURI" => _('Buried'), "SLGC" => _('Sealed to Parents (LDS)')];
    } elseif ($flag == "F") {
        $precusttitles = ["MARR" => _('Married'), "SLGS" => _('Sealed to Spouse (LDS)'), "DIV" => _('Divorced')];
        $postcusttitles = [];
    } else {
        $precusttitles = ["ABBR" => _('Short Title'), "CALN" => _('Call Number'), "AUTH" => _('Author'), "PUBL" => _('Publisher'), "TITL" => _('Title')];
        $postcusttitles = [];
    }

    $secretstr = $allow_private ? "" : " AND secret != '1'";
    $query = "SELECT display, xnotes.note AS note, notelinks.eventID AS eventID, notelinks.xnoteID AS xnoteID, notelinks.ID AS ID, noteID ";
    $query .= "FROM $notelinks_table notelinks ";
    $query .= "LEFT JOIN  $xnotes_table xnotes ON notelinks.xnoteID = xnotes.ID AND notelinks.gedcom = xnotes.gedcom ";
    $query .= "LEFT JOIN $events_table events ON notelinks.eventID = events.eventID ";
    $query .= "LEFT JOIN $eventtypes_table eventtypes ON eventtypes.eventtypeID = events.eventtypeID ";
    $query .= "WHERE notelinks.persfamID='$persfamID' AND notelinks.gedcom = '$tree' $secretstr ";
    $query .= "ORDER BY eventdatetr, eventtypes.ordernum, tag, notelinks.ordernum, ID";
    $notelinks = tng_query($query);

    $currevent = "";
    $currsig = "";
    $type = 0;
    while ($note = tng_fetch_assoc($notelinks)) {
        if ($note['noteID']) getCitations($note['noteID']);

        if (!$note['eventID']) $note['eventID'] = "--x-general-x--";

        $signature = $note['eventID'] . "_" . $note['xnoteID'];
        if ($signature != $currsig) {
            $currsig = $signature;
            $currevent = $note['eventID'];
            $currtitle = "";
        }
        if (!$currtitle) {
            if ($note['display']) {
                $currtitle = getEventDisplay($note['display']);
                $key = "$currsig";

                $custnotes[$key] = ["title" => $currtitle, "text" => "", "cite" => "", "xnote" => ""];

                $type = 2;
            } else {
                if (!empty($postcusttitles[$currevent])) {
                    $currtitle = $postcusttitles[$currevent];
                    $postcustnotes[$currsig] = ["title" => $postcusttitles[$currevent], "text" => "", "cite" => "", "xnote" => ""];
                    $type = 3;
                } else {
                    if (!empty($precusttitles[$currevent])) {
                        $currtitle = $precusttitles[$currevent];
                    } else {
                        $curtitle = " ";
                        $precusttitles[$currevent] = '';
                    }

                    if (substr($note['eventID'], 0, 15) == "--x-general-x--") {
                        $gennotes[$currsig] = ["title" => $precusttitles[$currevent], "text" => "", "cite" => "", "xnote" => ""];
                        $type = 0;
                    } else {
                        $precustnotes[$currsig] = ["title" => $precusttitles[$currevent], "text" => "", "cite" => "", "xnote" => ""];
                        $type = 1;
                    }
                }
            }
        }
        switch ($type) {
            case 0:
                if (!isset($gennotes[$currsig]['text'])) $gennotes[$currsig]['text'] = '';
                if (!isset($gennotes[$currsig]['cite'])) $gennotes[$currsig]['cite'] = '';
                if (!isset($gennotes[$currsig]['xnote'])) $gennotes[$currsig]['xnote'] = '';

                if ($gennotes[$currsig]['text']) {
                    $gennotes[$currsig]['text'] .= "</li>\n";
                }
                $gennotes[$currsig]['text'] .= "<li>" . nl2br($note['note']);
                $gennotes[$currsig]['cite'] .= "N{$note['ID']}";
                $gennotes[$currsig]['xnote'] .= $note['noteID'];
                break;
            case 1:
                if (!isset($precustnotes[$currsig]['text'])) $precustnotes[$currsig]['text'] = '';
                if (!isset($precustnotes[$currsig]['cite'])) $precustnotes[$currsig]['cite'] = '';
                if (!isset($precustnotes[$currsig]['xnote'])) $precustnotes[$currsig]['xnote'] = '';

                if ($precustnotes[$currsig]['text']) {
                    $precustnotes[$currsig]['text'] .= "</li>\n";
                }
                $precustnotes[$currsig]['text'] .= "<li>" . nl2br($note['note']);
                $precustnotes[$currsig]['cite'] .= "N{$note['ID']}";
                $precustnotes[$currsig]['xnote'] .= $note['noteID'];
                break;
            case 2:
                if (!isset($custnotes[$key]['text'])) $custnotes[$key]['text'] = '';
                if (!isset($custnotes[$key]['cite'])) $custnotes[$key]['cite'] = '';
                if (!isset($custnotes[$key]['xnote'])) $custnotes[$key]['xnote'] = '';

                if ($custnotes[$key]['text']) $custnotes[$key]['text'] .= "</li>\n";

                $custnotes[$key]['text'] .= "<li>" . nl2br($note['note']);
                $custnotes[$key]['cite'] .= "N{$note['ID']}";
                $custnotes[$key]['xnote'] .= $note['noteID'];
                break;
            case 3:
                if (!isset($postcustnotes[$currsig]['text'])) $postcustnotes[$currsig]['text'] = '';
                if (!isset($postcustnotes[$currsig]['cite'])) $postcustnotes[$currsig]['cite'] = '';
                if (!isset($postcustnotes[$currsig]['xnote'])) $postcustnotes[$currsig]['xnote'] = '';

                if ($postcustnotes[$currsig]['text']) {
                    $postcustnotes[$currsig]['text'] .= "</li>\n";
                }
                $postcustnotes[$currsig]['text'] .= "<li>" . nl2br($note['note']);
                $postcustnotes[$currsig]['cite'] .= "N{$note['ID']}";
                $postcustnotes[$currsig]['xnote'] .= $note['noteID'];
                break;
        }
    }
    $finalnotesarray = array_merge($gennotes, $precustnotes, $custnotes, $postcustnotes);
    tng_free_result($notelinks);

    return $finalnotesarray;
}
/**
 * @param $notearray
 * @param $entity
 * @return string
 */
function buildNotes($notearray, $entity) {
    $notes = "";
    $lasttitle = "---";
    foreach ($notearray as $key => $note) {
        if ($note['title'] != $lasttitle) {
            if ($notes) $notes .= "</ul>\n<br>\n";

            if ($note['title']) {
                $notes .= "<a name=\"$key\"><span class='normal'>{$note['title']}:</span></a><br>\n";
            }
        }
        $cite = reorderCitation($entity . "_" . $note['cite']);
        if ($note['xnote']) {
            $cite2 = reorderCitation($note['xnote'] . "_");
            $cite = $cite && $cite2 ? $cite . "," . $cite2 : $cite . $cite2;
        }
        if ($cite) $cite = " [$cite]";

        if ($note['title'] != $lasttitle) {
            $notes .= "<ul class='normal'>\n";
            $lasttitle = $note['title'];
        }
        $notes .= $note['text'] . "$cite</li>\n";
    }
    if ($notes) $notes .= "</ul>\n";

    return insertLinks($notes);
}
/**
 * @param $notearray
 * @param $entity
 * @param $eventlist
 * @return string
 */
function buildGenNotes($notearray, $entity, $eventlist) {
    $notes = "";
    $lasttitle = "---";
    if (is_array($notearray)) {
        $events = explode(",", $eventlist);
        $eventctr = 0;
        foreach ($events as $event) {
            foreach ($notearray as $key => $note) {
                if (strtok($key, "_") == $event) {
                    if ($note['title'] != $lasttitle && $eventctr) {
                        if ($notes) $notes .= "</ul>\n<br>\n";

                        if ($note['title']) {
                            $notes .= "<a name=\"$key\"><span class='normal'>{$note['title']}:</span></a><br>\n";
                        }
                    }
                    $cite = reorderCitation($entity . "_" . $note['cite']);
                    if ($note['xnote']) {
                        $cite2 = reorderCitation($note['xnote'] . "_");
                        $cite = $cite && $cite2 ? $cite . "," . $cite2 : $cite . $cite2;
                    }
                    if ($cite) $cite = " [$cite]";

                    if ($note['title'] != $lasttitle) {
                        $notes .= "<ul class='normal'>\n";
                        $lasttitle = $note['title'];
                    }
                    $notes .= $note['text'] . "$cite</li>\n";
                }
            }
            $eventctr++;
        }
        if ($notes) $notes .= "</ul>\n";

    }
    return insertLinks($notes);
}
/**
 * @param $fact
 * @return array
 */
function checkXnote($fact) {
    global $xnotes_table, $tree;

    $newfact = [];
    preg_match("/^@(\S+)@/", $fact, $matches);
    if (isset($matches[1])) {
        $query = "SELECT note, ID FROM $xnotes_table WHERE noteID = \"$matches[1]\" AND gedcom='$tree'";
        $xnoteres = @tng_query($query);
        if ($xnoteres) {
            $xnote = tng_fetch_assoc($xnoteres);
            $newfact[0] = trim($xnote['note']);
            $newfact[1] = $matches[1];
            getCitations($matches[1]);
        }
        tng_free_result($xnoteres);
    } else {
        $newfact[0] = $fact;
    }
    return $newfact;
}
/**
 * @param $notes
 * @param $needle
 * @return mixed
 */
function strpos_array($notes, $needle) {
    while (($pos = strpos($haystack, $needle, $pos)) !== FALSE)
        $array[] = $pos++;
    return $array;
}

function resetEvents() {
    global $eventctr, $events, $nodate;

    $events = [];
    $nodate = "0000-00-00";
    $eventctr = 1;
}
/**
 * @param $data
 * @param $datetr
 */
function setEvent($data, $datetr) {
    global $eventctr, $events, $nodate, $map, $eventctr_all, $nodate_all, $tngconfig;

    //make a copy of datetr
    $datetr_all = $datetr;
    if ($datetr_all == "0000-00-00") {
        $datetr_all = $nodate_all;
    } elseif ($datetr_all > $nodate_all) {
        $nodate_all = $datetr_all;
    }
    $index_all = $datetr_all . sprintf("%03d", $eventctr_all);
    $eventctr_all++;

    if ($datetr == "0000-00-00") {
        $datetr = $nodate;
    } elseif ($datetr > $nodate) {
        $nodate = $datetr;
    }
    $index = $datetr . sprintf("%03d", $eventctr);
    $events[$index] = $data;
    $eventctr++;

    if (!empty($map['key']) && !empty($data['place']) && empty($data['nomap'])) {
        global $locations2map, $l2mCount, $places_table, $tree, $pinplacelevel0;

        $treestr = $tngconfig['places1tree'] ? "" : " gedcom = '$tree' AND";
        $safeplace = tng_real_escape_string($data['place']);
        $query = "SELECT place,placelevel,latitude,longitude,zoom,notes
			FROM $places_table WHERE$treestr $places_table.place = '$safeplace' and (latitude is not null and latitude != '') and (longitude is not null and longitude != '')";
        $custevents = tng_query($query);

        $numrows = tng_num_rows($custevents);
        if ($numrows) {
            $fixedplace = htmlspecialchars($safeplace, ENT_QUOTES);
            $custevent = tng_fetch_assoc($custevents);
            $info = $data['fact'];
            $pinplacelevel = !empty($custevent['placelevel']) ? ${"pinplacelevel" . $custevent['placelevel']} : $pinplacelevel0;
            //using $index above will ensure that this array gets sorted in the same order as the events on the page
            $locations2map[$l2mCount] = [$index_all,
                "placelevel" => $custevent['placelevel'],
                "pinplacelevel" => $pinplacelevel,
                "event" => $data['text'],
                "htmlcontent" => "",
                "lat" => $custevent['latitude'],
                "long" => $custevent['longitude'],
                "zoom" => $custevent['zoom'],
                "place" => $custevent['place'],
                "notes" => truncateIt($custevent['notes'], 600),
                "eventdate" => $data['date'],
                "description" => (isset($info[0]) ? $info : ""),
                "fixedplace" => $fixedplace
            ];
            $l2mCount++;
        }
        tng_free_result($custevents);
    }
}

define("UNKNOWN", _('Unknown'));
define("FIND_PLACES", _('Find all individuals with events at this location'));
$datewidth = $thumbmaxw + 20 > 104 ? $thumbmaxw + 20 : 104;
$eventcounter = 0;
/**
 * @param $data
 * @return string
 */
function showEvent($data) {
    global $notestogether, $tree;
    global $tableid, $cellnumber, $tentative_edit;
    global $indnotes, $famnotes, $srcnotes, $reponotes, $indmedia, $fammedia, $srcmedia, $repomedia, $tngconfig;
    global $indalbums, $famalbums, $srcalbums, $repoalbums, $eventcounter, $num_collapsed;
    $myindexlist = ['type', 'event', 'entity', 'date', 'place', 'collapse', 'fact', 'xnote'];
    foreach ($myindexlist as $myindex) {
        if (!isset($data[$myindex])) $data[$myindex] = '';
    }

    switch ($data['type']) {
        case "I":
            $notearray = $indnotes;
            $media = $indmedia;
            $albums = $indalbums;
            break;
        case "F":
            $notearray = $famnotes;
            $media = $fammedia;
            $albums = $famalbums;
            break;
        case "S":
            $notearray = $srcnotes;
            $media = $srcmedia;
            $albums = $srcalbums;
            break;
        case "R":
            $notearray = $reponotes;
            $media = $repomedia;
            $albums = $repoalbums;
            break;
    }
    $dateplace = !empty($data['date']) || !empty($data['place']) ? 1 : 0;
    $eventcounter += 1;
    $toggle = !empty($data['collapse']) ? " style='display: none;'" : "";
    if (!isset($notearray)) $notearray = [];
    $notes = $notestogether && $data['event'] ? buildGenNotes($notearray, $data['entity'], $data['event']) : "";
    $rows = $dateplace;
    if ($tableid && !$cellnumber && ($dateplace || $data['fact'] || $notes)) {
        $cellid = " id=\"$tableid" . "1\"";
        $cellnumber++;
    } else {
        $cellid = "";
    }

    if ($data['fact']) {
        $rows += is_array($data['fact']) ? count($data['fact']) : 1;
    }
    $output = "";

    $cite = $data['entity'] ? reorderCitation($data['entity'] . "_" . $data['event']) : "";
    if ($dateplace) {
        $output .= formatDateAndPlace($data, $cite, $tngconfig['places1tree'], $tree);
        $output .= "</tr>\n";
    } elseif ($data['fact'] == "" && $cite) {
        $data['fact'] = _('Y');

        $rows++;
    }

    if ($data['fact'] != "") {
        $cite .= $data['xnote'] ? reorderCitation($data['xnote'] . "_") : "";

        if (is_array($data['fact'])) {
            for ($i = 0; $i < count($data['fact']); $i++) {
                if ($output) $output .= "<tr class=\"t{$eventcounter}\"$toggle>\n";

                if ($cite) $cite = "&nbsp; [$cite]";

                $output .= "<td class='p-1 databack' colspan='2'>" . nl2br(insertLinks($data['fact'][$i])) . "$cite&nbsp;</td></tr>\n";
                $cite = "";
            }
        } else {
            if ($output) $output .= "<tr class=\"t{$eventcounter}\"$toggle>\n";

            if (strpos($data['fact'], "http") === FALSE && strpos($data['fact'], "www") === FALSE) {
                preg_match("/(.*)\s*\/(.*)\/$/", $data['fact'], $matches);
                $count = count($matches);
                if ($count) {
                    $newfact = "";
                    for ($i = 1; $i <= $count; $i++) {
                        if ($newfact) $newfact .= " ";

                        $newfact .= addslashes($matches[$i]);
                    }
                    $data['fact'] = $newfact;
                }
            }
            if ($cite) $cite = "&nbsp; [$cite]";

            $output .= "<td class='p-1 databack' colspan='2'>" . nl2br(insertLinks($data['fact'])) . "$cite&nbsp;</td></tr>\n";
            $cite = "";
        }
    }
    if ($notestogether) {
        if ($notes) {
            $rows++;
            if ($output) $output .= "<tr class=\"t{$eventcounter}\"$toggle>\n";

            $output .= "<td class='p-1 databack' colspan='2'>$notes</td>\n";
            $output .= "</tr>\n";
        }
    }

    $event = $data['event'];

    if (!isset($media[$event])) $media[$event] = [];
    if (!isset($albums[$event])) $albums[$event] = [];
    $media_array = array_merge($media[$event], $albums[$event]);

    $mediaoutput = $thumbdivs = "";
    $thumbcount = 0;
    $mediacount = count($media_array);
    if ($mediacount) {
        if (!isset($sitever)) $sitever = '';
        $doThumbs = isset($tngconfig['mediathumbs']) && $mediacount > 1 ? $tngconfig['mediathumbs'] == "1" : false;
        foreach ($media_array as $item) {
            if ($doThumbs) {
                $thumbdivs .= "<div class=\"inline-thumb\">{$item['imgsrc']}</div>";
            } else {
                $rows++;
                if ($output) {
                    $mediaoutput .= "<tr class=\"t{$eventcounter}\"$toggle>\n";
                }
                if ($item['imgsrc']) {
                    $mediaoutput .= "<td class='p-1 databack text-center'>{$item['imgsrc']}</td>\n";
                    $thumbcount++;
                } else {
                    $mediaoutput .= "<td class='p-1 databack'>&nbsp;</td>";
                }
                $mediaoutput .= "<td class='p-1 databack'>{$item['name']}<br>" . nl2br($item['description']) . "</td>\n";
                $mediaoutput .= "</tr>\n";
            }
        }
        if (!$thumbcount) {
            $mediaoutput = str_replace("<td class='p-1 databack'>&nbsp;</td><td class='p-1 databack'>", "<td class='p-1 databack' colspan='2'>", $mediaoutput);
        }
        if ($thumbdivs) {
            $mediaoutput .= "<tr class=\"t{$eventcounter}\"$toggle><td class='p-1 databack' colspan='2'>$thumbdivs</td></tr>\n";
            $rows++;
        }
        $output .= $mediaoutput;
    }

    if ($output) {
        $editicon = $tentative_edit && $data['event'] && $data['event'] != "NAME" ? "<img src=\"img/tng_edit.gif\" alt=\"" . _('Suggest a change for this event') . "\" title=\"" . _('Suggest a change for this event') . "\" align=\"absmiddle\" onclick=\"tnglitbox = new LITBox('ajx_tentedit.php?tree=$tree&amp;persfamID={$data['entity']}&amp;type={$data['type']}&amp;event={$data['event']}&amp;title={$data['text']}', {width:500, height:500});\" class=\"fakelink\">" : "";
        if (!empty($data['collapse']) && $rows > 1) {
            $toggleicon = "<img src='img/tng_sort_desc.gif' alt='' class='toggleicon inline-block' id=\"t{$eventcounter}\" title=\"" . _('Expand') . "\">";
            $num_collapsed++;
        } else {
            $toggleicon = "";
        }
        $class = $cellid ? " indleftcol" : "";
        $rowspan = $rows > 1 && !$data['collapse'] ? " rowspan=\"$rows\"" : "";
        $preoutput = "<tr>\n<td class=\"p-1 fieldnameback align-top$class lt{$eventcounter}\" $rowspan$cellid>$toggleicon<span class='fieldname'>{$data['text']}$editicon</span></td>\n";
        $final = $preoutput . $output;
    } else {
        $final = "";
    }

    return $final;
}

/**
 * @param $data
 * @param string $cite
 * @param string $places1Tree
 * @param string $tree
 * @return string
 */
function formatDateAndPlace(&$data, string &$cite, string $places1Tree, string $tree): string {
    $oneColumn = true; // todo doing oneColumn only. placesearch_url is null sometimes.
    $output = "";

    if ($oneColumn) {
        $output .= "<td class='databack' colspan='2'>";
        if ($data['date']) {
            $output .= displayDate($data['date']) . "<br>";
            if (!$data['place'] && $cite) {
                $output .= "&nbsp; [$cite]";
                $cite = "";
            }
        }
        if ($data['place']) {
            if ($cite) $cite = "&nbsp; [$cite]";
            if ($data['place'] == "NN") $data['place'] = UNKNOWN;
            if (isset($data['np'])) {
                $output .= $data['place'];
            } else {
                $treestr = !empty($places1Tree) ? "" : "&amp;tree=$tree";
                $output .= " <a href='placesearch.php?psearch=" . urlencode($data['place']) . $treestr . "' title='" . FIND_PLACES . "'>";
                $output .= "<span class='mr-2'>{$data['place']}</span>";
                $output .= buildSvgElement("img/search.svg", ["class" => "w-3 h-3 fill-current inline-block"]);
                $output .= "</a>";
                $output .= "$cite\n";
            }
            $cite = "";
        }
        $output .= "</td>\n";
    } else {

        if ($data['date']) {
            $output .= "<td class='databack'";
            if (!$data['place']) $output .= " colspan='2'";

            $output .= ">" . displayDate($data['date']);
            if (!$data['place'] && $cite) {
                $output .= "&nbsp; [$cite]";
                $cite = "";
            }
            $output .= "&nbsp;</td>\n";
        }
        if ($data['place']) {
            $output .= "<td class='databack'";
            if ($cite) $cite = "&nbsp; [$cite]";

            if (!$data['date']) $output .= " colspan='2'";

            if ($data['place'] == "NN") $data['place'] = UNKNOWN;

            $output .= ">" . $data['place'];
            if (!isset($data['np'])) {
                $treestr = !empty($places1Tree) ? "" : "&amp;tree=$tree";
                $output .= " <a href='placesearch.php?psearch=" . urlencode($data['place']) . $treestr . "' title='" . FIND_PLACES . "'>";
                $output .= buildSvgElement("img/search.svg", ["class" => "w-3 h-3 fill-current inline-block"]);
                $output .= "</a>";
                $output .= "$cite&nbsp;";
                $output .= "</td>\n";
            } else {
                $output .= "</td>\n";
            }
            $cite = "";
        }
    }
    return $output;
}
/**
 * @param $breaksize
 * @return string
 */
function showBreak($breaksize) {
    return "<tr><td colspan='3' class=\"$breaksize\">&nbsp;</td></tr>\n";
}
/**
 * @param $entityID
 * @param $type
 * @param int $nomap
 */
function doCustomEvents($entityID, $type, $nomap = 0) {
    global $events_table, $eventtypes_table, $tree, $tngprint, $allow_lds;

    $query = "SELECT display, eventdate, eventdatetr, eventplace, age, agency, cause, addressID, info, tag, description, eventID, collapse, ldsevent ";
    $query .= "FROM ($events_table events, $eventtypes_table eventtypes) ";
    $query .= "WHERE persfamID = '$entityID' AND events.eventtypeID = eventtypes.eventtypeID AND gedcom = '$tree' AND keep = '1' AND parenttag = '' ";
    $query .= "ORDER BY ordernum, tag, description, eventdatetr, info, eventID";
    $custevents = tng_query($query);
    while ($custevent = tng_fetch_assoc($custevents)) {
        $xnote = '';
        if (!$custevent['ldsevent'] || $allow_lds) {
            $displayval = getEventDisplay($custevent['display']);
            $eventID = $custevent['eventID'];
            $fact = [];
            if ($custevent['info']) {
                $fact = checkXnote($custevent['info']);
                if (isset($fact[1])) {
                    $xnote = $fact[1];
                    array_pop($fact);
                }
            }
            $extras = getFact($custevent);
            $fact = (count($fact) && $fact[0] != "") ? array_merge($fact, $extras) : $extras;
            setEvent(["text" => $displayval, "date" => $custevent['eventdate'], "place" => $custevent['eventplace'], "fact" => $fact, "xnote" => $xnote, "event" => $eventID, "entity" => $entityID, "type" => $type, "nomap" => $nomap, "collapse" => $custevent['collapse'] && !$tngprint], $custevent['eventdatetr']);
        }
    }
    tng_free_result($custevents);
}
/**
 * @param $entity
 * @param $medialist
 * @param $albums
 * @return string
 */
function doMediaSection($entity, $medialist, $albums) {
    global $mediatypes, $cellnumber, $tableid, $datewidth;

    $media = "";
    $tableid = "media";
    $cellnumber = 0;
    foreach ($mediatypes as $mediatype) {
        $mediatypeID = $mediatype['ID'];
        $newmedia = writeMedia($medialist, $mediatypeID);
        if ($newmedia) {
            if ($media) $media .= "<br>\n";

            $media .= "<table class='whiteback tfixed' cellspacing='1' cellpadding='4'>\n";
            $media .= "<col class='labelcol'/><col style=\"width:{$datewidth}px;\"/><col/>\n";
            $media .= "$newmedia\n</table>\n";
        }
    }
    $albumtext = writeAlbums($albums);
    if ($albumtext) {
        if ($media) $media .= "<br>\n";

        $media .= "<table class='whiteback tfixed' cellspacing='1' cellpadding='4'>\n";
        $media .= "<col class='labelcol'/><col style=\"width:{$datewidth}px;\"/><col/>\n";
        $media .= "$albumtext\n</table>\n";
    }
    return $media;
}
/**
 * @param $entity
 * @param $linktype
 * @return array
 */
function getLinkTypeMisc($entity, $linktype) {
    $misc = [];
    switch ($linktype) {
        case "I":
            $misc['personID'] = $entity['personID'];
            $misc['always'] = $entity['allow_living'] && $entity['allow_private'] ? "" : "AND alwayson = '1'";
            break;
        case "F":
            $misc['personID'] = $entity['familyID'];
            $misc['always'] = $entity['allow_living'] && $entity['allow_private'] ? "" : "AND alwayson = '1'";
            break;
        case "S":
            $misc['personID'] = $entity['sourceID'];
            $misc['always'] = "";
            break;
        case "C":
            $misc['personID'] = $entity['citationID'];
            $misc['always'] = "";
            break;
        case "R":
            $misc['personID'] = $entity['repoID'];
            $misc['always'] = "";
            break;
        case "L":
            $misc['personID'] = $entity;
            $misc['always'] = "";
            break;
    }

    return $misc;
}
/**
 * @param $entity
 * @param $linktype
 * @return array
 */
function getAlbums($entity, $linktype) {
    global $tree, $album2entities_table, $albums_table, $albumlinks_table, $people_table, $families_table, $livedefault;

    $albums = [];

    $misc = getLinkTypeMisc($entity, $linktype);
    $ID = $misc['personID'];
    $always = $misc['always'];

    $query = "SELECT albums.albumID, albumname, description, eventID, alwayson ";
    $query .= "FROM ($albums_table albums, $album2entities_table album2entities) ";
    $query .= "WHERE entityID='$ID' AND gedcom='$tree' AND album2entities.albumID=albums.albumID AND active = '1' ";
    $query .= "ORDER BY ordernum, albumname";
    $albumlinks = tng_query($query);
    if (is_array($entity)) {
        if (!isset($entity['allow_living'])) $entity['allow_living'] = false;
        if (!isset($entity['allow_private'])) $entity['allow_private'] = false;
    }

    while ($albumlink = tng_fetch_assoc($albumlinks)) {
        $thisalbum = [];
        $eventID = $albumlink['eventID'] && $entity['allow_living'] && $entity['allow_private'] ? $albumlink['eventID'] : "-x--general--x-";

        //check to see if we have rights to view this album
        $query = "SELECT album2entities.entityID AS personID, people.living AS living, people.private AS private, people.branch AS branch, families.branch AS fbranch, families.living AS fliving, families.private AS fprivate, album2entities.gedcom, familyID, people.personID AS personID2 ";
        $query .= "FROM $album2entities_table album2entities ";
        $query .= "LEFT JOIN $people_table people ON album2entities.entityID = people.personID AND album2entities.gedcom = people.gedcom ";
        $query .= "LEFT JOIN $families_table families ON album2entities.entityID = families.familyID AND album2entities.gedcom = families.gedcom ";
        $query .= "WHERE albumID = \"{$albumlink['albumID']}\"";
        $presult = tng_query($query);
        $foundliving = 0;
        $foundprivate = 0;
        if (!$albumlink['alwayson'] && $livedefault != 2) {
            while ($prow = tng_fetch_assoc($presult)) {
                if ($prow['fbranch'] != NULL) $prow['branch'] = $prow['fbranch'];

                if ($prow['fliving'] != NULL) $prow['living'] = $prow['fliving'];

                if ($prow['fprivate'] != NULL) {
                    $prow['private'] = $prow['fprivate'];
                }

                $rights = determineLivingPrivateRights($prow);
                $prow['allow_living'] = $rights['living'];
                $prow['allow_private'] = $rights['private'];
                if (!$rights['living']) $foundliving = 1;

                if (!$rights['private']) $foundprivate = 1;

                if ($foundliving || $foundprivate) break;
            }
        }
        tng_free_result($presult);

        //putting this count in the albums table would make this faster
        $query = "SELECT count($albumlinks_table.albumlinkID) AS acount FROM $albumlinks_table WHERE albumID = \"{$albumlink['albumID']}\"";
        $result2 = tng_query($query);
        $arow = tng_fetch_assoc($result2);
        tng_free_result($result2);

        if (!$foundliving && !$foundprivate) {
            $thisalbum['imgsrc'] = getAlbumPhoto($albumlink['albumID'], $albumlink['albumname']);
            $thisalbum['name'] = "<a href=\"showalbum.php?albumID={$albumlink['albumID']}\">{$albumlink['albumname']}</a> ({$arow['acount']})";
            $thisalbum['description'] = $albumlink['description'];
        } else {
            $thisalbum['imgsrc'] = "";
            $thisalbum['name'] = _('Living');
            $thisalbum['description'] = "(" . _('At least one living or private individual is linked to this item - Details withheld.') . ")";
        }

        if (!isset($albums[$eventID])) $albums[$eventID] = [];
        array_push($albums[$eventID], $thisalbum);
    }
    tng_free_result($albumlinks);

    return $albums;
}
/**
 * @param $albums_array
 * @return string
 */
function writeAlbums($albums_array) {
    global $tableid, $cellnumber, $datewidth;

    $albumtext = "";
    $albums = !empty($albums_array['-x--general--x-']) ? $albums_array['-x--general--x-'] : '';

    $cellid = $tableid && !$cellnumber ? " id=\"$tableid" . "1\"" : "";

    if (is_array($albums)) {
        $totalalbums = count($albums);
        $albumcount = 0;
        $albumrows = "";

        if ($totalalbums) {
            $cellnumber++;
            $thumbcount = 0;

            foreach ($albums as $item) {
                if ($albumcount) $albumrows .= "<tr>";

                if ($item['imgsrc']) {
                    $albumrows .= "<td class='databack text-center' style=\"width:$datewidth" . "px;\">{$item['imgsrc']}</td>";
                    $albumrows .= "<td class='databack'>";
                    $thumbcount++;
                } else {
                    $albumrows .= "<td class='databack' style=\"width:$datewidth" . "px;\">&nbsp;</td>";
                    $albumrows .= "<td class='databack'>";
                }
                $albumrows .= "<span class='normal'>{$item['name']}<br>" . nl2br($item['description']) . "</span></td></tr>\n";
                $albumcount++;
            }
            $albumtext .= "<tr>\n";
            $albumtext .= "<td class='fieldnameback indleftcol align-top'$cellid rowspan=\"$totalalbums\"><span class='fieldname'>" . _('Albums') . "</span></td>\n";

            if (!$thumbcount) {
                $albumrows = str_replace("/<td class='databack' style=\"width:$datewidth" . "px;\">&nbsp;<\/td><td class='databack'>/", "<td class='databack' colspan='2'>", $albumrows);
            }
            $albumtext .= $albumrows;
        }
    }

    return $albumtext;
}
/**
 * @param $entity
 * @param $linktype
 * @param false $all
 * @return array
 */
function getMedia($entity, $linktype, $all = false) {
    global $medialinks_table, $media_table, $tree, $nonames;
    global $mediapath, $mediatypes_assoc, $tngconfig, $rootpath;

    $media = [];
    //if mediatypeID, do it in media type sections, otherwise, do it all together
    $misc = getLinkTypeMisc($entity, $linktype);
    $personID = $misc['personID'];
    $always = $misc['always'];
    $mlflag = ($linktype == "C" || !$linktype) ? 0 : 1;

    $query = "SELECT medialinkID, description, notes, altdescription, altnotes, usecollfolder, mediatypeID, personID, $medialinks_table.mediaID AS mediaID, thumbpath, status, plot, eventID, alwayson, path, form, abspath, newwindow
		FROM ($medialinks_table, $media_table)
		WHERE $medialinks_table.personID='$personID'
		AND $media_table.mediaID = $medialinks_table.mediaID and dontshow != 1";
    if ($tree) $query .= " AND ($medialinks_table.gedcom = '$tree')";

    $query .= " $always	ORDER BY eventID, mediatypeID, ordernum";
    $medialinks = tng_query($query);
    $gotImageJpeg = function_exists('imageJpeg');

    while ($medialink = tng_fetch_assoc($medialinks)) {
        $imgsrc = "";
        $thismedia = [];
        $eventID = !$all && $medialink['eventID'] && ($linktype == "L" || ($entity['allow_living'] && $entity['allow_private'])) ? $medialink['eventID'] : "-x--general--x-";
        $mediatypeID = $medialink['mediatypeID'];
        $usefolder = $medialink['usecollfolder'] ? $mediatypes_assoc[$mediatypeID] : $mediapath;
        $medialink['allow_living'] = $medialink['alwayson'] || checkLivingLinks($medialink['mediaID']) ? 1 : 0;
        $thismedia['imgsrc'] = getSmallPhoto($medialink);
        $thismedia['thumbexists'] = $medialink['allow_living'] && $medialink['thumbpath'] && file_exists("$rootpath$usefolder/" . $medialink['thumbpath']);
        if (!$medialink['allow_living'] && ($nonames || $tngconfig['nnpriv'])) {
            $thismedia['name'] = _('At least one living or private individual is linked to this item - Details withheld.');
            $thismedia['description'] = "";
        } else {
            $thismedia['name'] = $medialink['altdescription'] ? $medialink['altdescription'] : $medialink['description'];
            $thismedia['description'] = truncateIt(getXrefNotes(($medialink['altnotes'] ? $medialink['altnotes'] : $medialink['notes']), $tree), (!empty($tngconfig['maxnoteprev']) ? $tngconfig['maxnoteprev'] : 0));
            if (!$medialink['allow_living']) {
                $thismedia['description'] .= " (" . _('At least one living or private individual is linked to this item - Details withheld.') . ")";
            } else {
                $thismedia['href'] = getMediaHREF($medialink, $mlflag);
                if ($thismedia['name']) {
                    $thismedia['name'] = "<a href=\"{$thismedia['href']}\">{$thismedia['name']}</a>";
                }
                if ($thismedia['imgsrc']) {
                    $imgsrc = $thismedia['imgsrc'];
                    $medialinkID = $medialink['medialinkID'];
                    $thismedia['imgsrc'] = "<div class='media-img'>";
                    $thismedia['imgsrc'] .= "<div class='media-prev' id=\"prev{$medialink['mediaID']}";
                    if ($linktype != "C") $thismedia['imgsrc'] .= "_$medialinkID";
                    $thismedia['imgsrc'] .= "\" style='display: none;'></div>";
                    $thismedia['imgsrc'] .= "</div>\n";
                    $thismedia['imgsrc'] .= "<a href=\"{$thismedia['href']}\"";
                    if ($gotImageJpeg && isPhoto($medialink) && checkMediaFileSize("$rootpath$usefolder/" . $medialink['path'])) {
                        $thismedia['imgsrc'] .= " class='media-preview' id=\"img-{$medialink['mediaID']}";
                        if ($linktype == "C") {
                            $thismedia['imgsrc'] .= "-0";
                        } else {
                            $thismedia['imgsrc'] .= "-{$medialinkID}";
                        }
                        $thismedia['imgsrc'] .= "-" . urlencode("$usefolder/{$medialink['path']}") . "\"";
                    }
                    $thismedia['imgsrc'] .= ">$imgsrc</a>";
                }
            }
            if ($medialink['plot']) {
                if ($thismedia['description']) {
                    $thismedia['description'] .= "<br>";
                }
                $thismedia['description'] .= "<strong>" . _('Plot') . ": </strong>" . $medialink['plot'];
            }
        }
        if (!$all && $medialink['eventID'] && ($linktype == "L" || ($entity['allow_living'] && $entity['allow_private']))) {
            if (!isset($media[$eventID])) $media[$eventID] = [];
            array_push($media[$eventID], $thismedia);
        } elseif ($linktype == "C") {
            array_push($media, $thismedia);
        } else {
            if (!isset($media[$eventID][$mediatypeID])) $media[$eventID][$mediatypeID] = [];
            array_push($media[$eventID][$mediatypeID], $thismedia);
        }
    }
    tng_free_result($medialinks);

    return $media;
}
/**
 * @param $media_array
 * @param $mediatypeID
 * @param string $prefix
 * @return string
 */
function writeMedia($media_array, $mediatypeID, $prefix = "") {
    global $tableid, $cellnumber, $text, $datewidth, $mediatypes_display, $mediatypes_like, $tngconfig, $num_collapsed;

    $mediatext = "";

    $media = isset($media_array['-x--general--x-'][$mediatypeID]) ? $media_array['-x--general--x-'][$mediatypeID] : "";
    $cellid = $tableid && !$cellnumber ? " id=\"$tableid" . "1\"" : "";
    $doThumbs = isset($tngconfig['mediathumbs']) ? $tngconfig['mediathumbs'] == "1" : false;

    if (is_array($media)) {
        $totalmedia = count($media);
        $rows = $totalmedia;
        $mediacount = 0;
        $slidelink = "";
        $mediarows = "";
        $countrow = "";
        $thumbdivs = "";
        $gotHref = false;

        if ($totalmedia) {
            $cellnumber++;
            $thumbcount = 0;

            $titlemsg = $text[$mediatypeID] ? $text[$mediatypeID] : $mediatypes_display[$mediatypeID];
            $hidemedia = !empty($tngconfig['hidemedia']) && $totalmedia > 1;
            if ($hidemedia) {
                $mediacount = 1;
                $countrow = "<td colspan='2' class='databack' id=\"drm{$prefix}{$mediatypeID}\">$totalmedia $titlemsg</td></tr>\n";
                $rows += 1;
                $num_collapsed++;
            }
            //don't do the thumbnail arrangement if there's only one or if the media type isn't photos (or like photos)
            if ($doThumbs) {
                if (count($media) > 1 && ($mediatypeID == "photos" || in_array($mediatypeID, $mediatypes_like['photos']))) {
                    $thumbCount = 0;
                    foreach ($media as $item) {
                        if ($item['thumbexists']) $thumbcount++;

                    }
                    if ($thumbcount <= 1) $doThumbs = false;

                } else {
                    $doThumbs = false;
                }
            }
            foreach ($media as $item) {
                if ($item['href'] && !$gotHref) {
                    $goodone = strpos($item['href'], "showmedia.php");
                    if ($goodone !== FALSE) {
                        $slidelink = $item['href'];
                        $gotHref = true;
                    }
                }
                //if we're doing thumbrows and this one has a thumbnail
                if ($doThumbs && $item['thumbexists']) {
                    $thumbdivs .= "<div class=\"inline-thumb\">{$item['imgsrc']}</div>";
                    $rows--;
                } else {
                    if ($mediacount) {
                        //only do this next line for mediarows
                        $mediarows .= "<tr class=\"m{$prefix}{$mediatypeID}\"";
                        if ($hidemedia) $mediarows .= " style='display: none;'";

                        $mediarows .= ">";
                    }
                    if ($item['imgsrc']) {
                        $mediarows .= "<td class='databack text-center' style=\"width:$datewidth" . "px;\">{$item['imgsrc']}</td>";
                        $mediarows .= "<td class='databack'>";
                        $thumbcount++;
                    } else {
                        $mediarows .= "<td class='databack' style=\"width:$datewidth" . "px;\">&nbsp;</td>";
                        $mediarows .= "<td class='databack'>";
                    }
                    $mediarows .= "<span class='normal'>{$item['name']}<br>" . nl2br($item['description']) . "</span></td></tr>\n";
                }
                $mediacount++;
            }
            if (empty($tngconfig['ssdisabled']) && $mediacount >= 3 && $slidelink) {
                $titlemsg .= "<div id=\"ssm{$prefix}{$mediatypeID}\"";
                if ($hidemedia) $titlemsg .= " style='display: none;'";
                $titlemsg .= "><br><a href=\"$slidelink&amp;ss=1\" class=\"smaller lightlink\">&raquo; " . _('Slide Show') . "</a></div>\n";
            }
            $mediatext .= "<tr>\n";
            $toggleicon = $hidemedia ? "<img src='img/tng_sort_desc.gif' alt='' id=\"m{$prefix}{$mediatypeID}\" class='toggleicon inline-block' title=\"" . _('Expand') . "\"/>" : "";
            $mediatext .= "<td class=\"fieldnameback indleftcol align-top lm{$prefix}{$mediatypeID}\"$cellid";
            if ($thumbdivs) $rows++;
            if (!$hidemedia && $rows != 1) {
                $mediatext .= " rowspan=\"$rows\"";
            }
            $mediatext .= ">$toggleicon";
            $mediatext .= "<span class='fieldname'>$titlemsg</span></td>\n";
            if (!$thumbcount) {
                $mediarows = str_replace("<td class='databack' style=\"width:$datewidth" . "px;\">&nbsp;</td><td class='databack'>", "<td class='databack' colspan='2'>", $mediarows);
            }

            $mediatext .= $countrow;

            //throw in the $thumbdivs
            if ($thumbdivs) {
                if ($hidemedia) {
                    $mediatext .= "</tr><tr class=\"m{$prefix}{$mediatypeID}\" style='display: none;'>";
                }
                $mediatext .= "<td class='databack' colspan='2'>$thumbdivs</td></tr>\n";
            }

            $mediatext .= $mediarows;
        }
    }

    return $mediatext;
}
/**
 * @param $albumID
 * @param $albumname
 * @return string
 */
function getAlbumPhoto($albumID, $albumname) {
    global $livedefault, $rootpath, $media_table, $albumlinks_table, $people_table, $families_table, $citations_table, $medialinks_table;
    global $mediatypes_assoc, $mediapath, $tree;

    $query2 = "SELECT path, thumbpath, usecollfolder, mediatypeID, albumlinks.mediaID AS mediaID, alwayson ";
    $query2 .= "FROM ($media_table media, $albumlinks_table albumlinks) ";
    $query2 .= "WHERE albumID = '$albumID' AND media.mediaID = albumlinks.mediaID AND defphoto = '1'";
    $result2 = tng_query($query2) or die (_('Cannot execute query') . ": $query2");
    $trow = tng_fetch_assoc($result2);
    $mediaID = $trow['mediaID'];
    $tmediatypeID = $trow['mediatypeID'];
    $tusefolder = $trow['usecollfolder'] ? $mediatypes_assoc[$tmediatypeID] : $mediapath;
    tng_free_result($result2);

    $imgsrc = "";
    if ($trow['thumbpath'] && file_exists("$rootpath$tusefolder/{$trow['thumbpath']}")) {
        $foundliving = 0;
        $foundprivate = 0;
        if (!$trow['alwayson'] && $livedefault != 2) {
            $query = "SELECT people.living AS living, people.private AS private, people.branch AS branch, families.branch AS fbranch, families.living AS fliving, families.private AS fprivate, linktype, medialinks.gedcom AS gedcom ";
            $query .= "FROM $medialinks_table medialinks ";
            $query .= "LEFT JOIN $people_table people ON medialinks.personID = people.personID AND medialinks.gedcom = people.gedcom ";
            $query .= "LEFT JOIN $families_table families ON medialinks.personID = families.familyID AND medialinks.gedcom = families.gedcom ";
            $query .= "WHERE mediaID = '$mediaID'";
            if ($tree) $query .= " AND medialinks.gedcom = '$tree'";

            $presult = tng_query($query);
            while ($prow = tng_fetch_assoc($presult)) {
                if ($prow['fbranch'] != NULL) $prow['branch'] = $prow['fbranch'];

                if ($prow['fliving'] != NULL) $prow['living'] = $prow['fliving'];

                if ($prow['fprivate'] != NULL) {
                    $prow['private'] = $prow['fprivate'];
                }

                $rights = determineLivingPrivateRights($prow);
                // TODO are allow_living allow_private used
                $prow['allow_living'] == $rights['living'];
                $prow['allow_private'] == $rights['private'];

                //if living still null, must be a source
                if ($prow['living'] == NULL && $prow['private'] == NULL && $prow['linktype'] == 'I') {
                    $query = "SELECT COUNT(personID) AS ccount ";
                    $query .= "FROM $citations_table citations, $people_table people ";
                    $query .= "WHERE citations.sourceID = '{$prow['personID']}' AND citations.persfamID = people.personID AND citations.gedcom = people.gedcom AND living = '1'";
                    $presult2 = tng_query($query);
                    $prow2 = tng_fetch_assoc($presult2);
                    if ($prow2['ccount']) $prow['living'] = 1;

                    tng_free_result($presult2);
                } elseif ($prow['living'] == NULL && $prow['private'] == NULL && $prow['linktype'] == 'F') {
                    $query = "SELECT COUNT(familyID) AS ccount ";
                    $query .= "FROM $citations_table citations, $families_table families ";
                    $query .= "WHERE citations.sourceID = '{$prow['personID']}' AND citations.persfamID = families.familyID AND citations.gedcom = families.gedcom AND living = '1'";
                    $presult2 = tng_query($query);
                    $prow2 = tng_fetch_assoc($presult2);
                    if ($prow2['ccount']) $prow['living'] = 1;

                    tng_free_result($presult2);
                }
                if ($prow['living'] && !$rights['living']) {
                    $foundliving = 1;
                }
                if ($prow['private'] && !$rights['private']) {
                    $foundprivate = 1;
                }
            }
        }
        if (!$foundliving && !$foundprivate) {
            $size = @GetImageSize("$rootpath$tusefolder/{$trow['thumbpath']}");
            $imgsrc = "<div class='media-img'>";
            $imgsrc .= "<div class='media-prev' id=\"prev{$trow['mediaID']}\" style='display: none;'></div>";
            $imgsrc .= "</div>\n";
            $imgsrc .= "<a href=\"showalbum.php?albumID=$albumID\" title=\"" . _('Click to see all the items in this album') . "\"";
            if (function_exists('imageJpeg')) {
                $imgsrc .= " class='media-preview' id=\"img-{$trow['mediaID']}-0-" . urlencode("$tusefolder/{$trow['path']}") . "\"";
            }
            $imgsrc .= "><img src=\"$tusefolder/" . str_replace("%2F", "/", rawurlencode($trow['thumbpath'])) . "\" class=\"thumb\" $size[3] alt=\"$albumname\"></a>";
        }
    }
    return $imgsrc;
}
/**
 * @param $row
 * @return array
 */
function getFact($row) {
    global $address_table;

    $fact = [];
    $i = 0;
    if ($row['age']) $fact[$i++] = _('Age') . ": " . $row['age'];

    if ($row['agency']) {
        $fact[$i++] = _('Agency') . ": " . $row['agency'];
    }
    if ($row['cause']) {
        $fact[$i++] = _('Cause') . ": " . $row['cause'];
    }
    if ($row['addressID']) {
        $fact[$i] = !empty($row['isrepo']) ? "" : _('Address') . ":";
        $query = "SELECT address1, address2, city, state, zip, country, www, email, phone FROM $address_table WHERE addressID = \"{$row['addressID']}\"";
        $addrresults = tng_query($query);
        $addr = tng_fetch_assoc($addrresults);
        if ($addr['address1']) {
            $fact[$i] .= ($fact[$i] ? "<br>" : "") . $addr['address1'];
        }
        if ($addr['address2']) {
            $fact[$i] .= ($fact[$i] ? "<br>" : "") . $addr['address2'];
        }
        if ($addr['city']) {
            $fact[$i] .= ($fact[$i] ? "<br>" : "") . $addr['city'];
        }
        if ($addr['state']) {
            if ($addr['city']) {
                $fact[$i] .= ", " . $addr['state'];
            } else {
                $fact[$i] .= ($fact[$i] ? "<br>" : "") . $addr['state'];
            }
        }
        if ($addr['zip']) {
            if ($addr['city'] || $addr['state']) {
                $fact[$i] .= " " . $addr['zip'];
            } else {
                $fact[$i] .= ($fact[$i] ? "<br>" : "") . $addr['zip'];
            }
        }
        if ($addr['country']) {
            $fact[$i] .= ($fact[$i] ? "<br>" : "") . $addr['country'];
        }
        if ($addr['phone']) {
            $fact[$i] .= ($fact[$i] ? "<br>" : "") . $addr['phone'];
        }
        if ($addr['email']) {
            $fact[$i] .= ($fact[$i] ? "<br>" : "") . "<a href=\"mailto:{$addr['email']}\">{$addr['email']}</a>";
        }
        if ($addr['www']) {
            $link = strpos($addr['www'], "http") !== 0 ? "http://" . $addr['www'] : $addr['www'];
            $fact[$i] .= ($fact[$i] ? "<br>" : "") . "<a href=\"$link\">{$addr['www']}</a>";
        }
    }
    return $fact;
}
/**
 * @param $persfamID
 * @return array
 */
function getStdExtras($persfamID) {
    global $tree, $events_table;

    $stdex = [];
    $query = "SELECT age, agency, cause, addressID, parenttag FROM $events_table WHERE persfamID = '$persfamID' AND gedcom = '$tree' AND parenttag != \"\" ORDER BY parenttag";
    $stdextras = tng_query($query);
    while ($stdextra = tng_fetch_assoc($stdextras)) {
        $stdex[$stdextra['parenttag']] = getFact($stdextra);
    }
    return $stdex;
}
/**
 * @param $assoc
 * @return string
 */
function formatAssoc($assoc) {
    global $tree, $people_table, $families_table;

    $assocstr = $namestr = "";

    if ($assoc['reltype'] == "I" || $assoc['reltype'] == "") {
        $query = "SELECT firstname, lastname, lnprefix, prefix, suffix, nameorder, living, private, branch, gedcom FROM $people_table WHERE personID = \"{$assoc['passocID']}\" AND gedcom = '$tree'";
        $result = tng_query($query);

        $row = tng_fetch_assoc($result);
        $rights = determineLivingPrivateRights($row);
        $row['allow_living'] = $rights['living'];
        $row['allow_private'] = $rights['private'];
        $assocstr = getName($row);
        tng_free_result($result);

        if (!$assocstr) $assocstr = $assoc['passocID'];

        $assocstr = "<a href=\"getperson.php?personID={$assoc['passocID']}&amp;tree=$tree\">$assocstr</a>";
    } elseif ($assoc['reltype'] == "F") {
        $query = "SELECT familyID, husband, wife, living, private, marrdate, gedcom, branch, gedcom FROM $families_table WHERE familyID = \"{$assoc['passocID']}\" AND gedcom = '$tree'";
        $result = tng_query($query);

        $row = tng_fetch_assoc($result);
        $rights = determineLivingPrivateRights($row);
        $row['allow_living'] = $rights['living'];
        $row['allow_private'] = $rights['private'];
        $assocstr = getFamilyName($row);
        tng_free_result($result);

        if (!$assocstr) $assocstr = $assoc['passocID'];

        $assocstr = "<a href=\"familygroup.php?familyID={$assoc['passocID']}&amp;tree=$tree\">" . _('Family') . ": $assocstr</a>";
    }
    $assocstr .= $assoc['relationship'] ? " (" . _('Relationship') . ": {$assoc['relationship']})" : "";

    return $assocstr;
}
/**
 * @param $section
 * @return string
 */
function beginSection($section) {
    global $tableid, $cellnumber, $firstsection, $firstsectionsave, $tngconfig;

    $sectext = "";
    $tableid = $section;
    $cellnumber = 0;
    if ($firstsection) {
        $firstsection = 0;
        $firstsectionsave = $section;
    }
    $sectext .= "<li id=\"$section\" style=\"list-style-type: none; ";
    if ($tngconfig['istart'] && $section != "info") {
        $sectext .= "display:none;";
    }
    $sectext .= "\">\n";

    return $sectext;
}
/**
 * @param $section
 * @return string
 */
function endSection($section) {
    return "</li> <!-- end $section -->\n";
}
