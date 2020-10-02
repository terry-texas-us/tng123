<?php
function display_size($file_size) {
    if ($file_size >= 1073741824) {
        $file_size = round($file_size / 1073741824 * 100) / 100 . "g";
    } elseif ($file_size >= 1048576) {
        $file_size = round($file_size / 1048576 * 100) / 100 . "m";
    } elseif ($file_size >= 1024) {
        $file_size = round($file_size / 1024 * 100) / 100 . "k";
    } else {
        $file_size = $file_size . " bytes";
    }

    return $file_size;
} // function display_size()

function output_iptc_data($info) {
    global $text, $session_charset;

    $outputtext = "";
    if (is_array($info)) {
        $iptc = iptcparse($info['APP13']);
        if (is_array($iptc)) {
            $ucharset = strtoupper($session_charset);
            $enc = isset($iptc["1#090"]) && $iptc["1#090"][0] == "\x1B%G" ? "UTF-8" : "ISO-8859-1";
            foreach (array_keys($iptc) as $key) {
                $count = count($iptc[$key]);
                for ($i = 0; $i < $count; $i++) {
                    $tempkey = substr($key, 0);
                    $newkey = substr($key, 2);
                    if (!$i) {
                        $iptc[$key][0] = str_replace("\000", "", $iptc[$key][0]);
                    }
                    if ($newkey != "000") {
                        if ($tempkey == "1#090") {
                            continue;
                        }
                        $newkey = "iptc" . $newkey;
                        $keytext = $text[$newkey] ? $text[$newkey] : $key;
                        $fact = $iptc[$key][$i];

                        if ($enc == "UTF-8" && $ucharset != "UTF-8") {
                            $fact = utf8_decode($fact);
                            $str = ", decoded";
                        } elseif ($enc != "UTF-8" && $ucharset == "UTF-8") {
                            $fact = utf8_encode($fact);
                            $str = ", encoded";
                        } else {
                            $str = ", NONE";
                        }
                        $outputtext .= tableRow($keytext, $fact);
                    }
                }
            }
        }
    }
    return $outputtext;
}

function getMediaInfo($mediatypeID, $mediaID, $personID, $albumID, $albumlinkID, $cemeteryID, $eventID) {
    global $wherestr, $requirelogin, $treerestrict, $assignedtree, $tnggallery, $mediasearch, $tree, $all, $showall, $ordernum;
    global $media_table, $medialinks_table, $albumlinks_table, $allow_media_edit;

    $info = [];

    $wherestr3 = $requirelogin && $treerestrict && $assignedtree ? " AND (media.gedcom = '$tree' || media.gedcom = '')" : "";
    if ($albumlinkID) {
        if ($tnggallery) {
            $wherestr = " AND thumbpath != ''";
        }
        $query = "SELECT media.mediaID, albumlinkID, ordernum, path, map, description, notes, width, height, datetaken, placetaken, owner, alwayson, abspath, usecollfolder, status, plot, cemeteryID, showmap, bodytext, form, newwindow, usenl, latitude, longitude, mediatypeID, gedcom ";
        $query .= "FROM ($albumlinks_table albumlinks, $media_table media) ";
        $query .= "WHERE albumID = '$albumID' AND albumlinks.mediaID = media.mediaID $wherestr $wherestr3 ";
        $query .= "ORDER BY ordernum, description";
        $result = tng_query($query);
        $offsets = get_media_offsets($result, $mediaID);
        $info['page'] = $offsets[0] + 1;
        tng_data_seek($result, $offsets[0]);

        $imgrow = tng_fetch_assoc($result);
        $info['mediaID'] = $imgrow['mediaID'];
        $info['ordernum'] = $imgrow['ordernum'];
        $info['mediadescription'] = $imgrow['description'];
        $info['medianotes'] = $imgrow['notes'];
    } elseif (!$personID) {
        $mediasearch = $_SESSION['tng_mediasearch'];
        $tnggallery = $_SESSION['tng_gallery'];
        if ((!$requirelogin || !$treerestrict || !$assignedtree) && $_SESSION['tng_mediatree']) {
            $tree = $_SESSION['tng_mediatree'];
        }

        if ($all) {
            $wherestr = "WHERE 1=1";
            $showall = "";
        } else {
            $wherestr = "WHERE mediatypeID = '$mediatypeID'";
            $showall = "mediatypeID=$mediatypeID&amp;";
        }
        $join = "LEFT JOIN";
        if ($mediasearch) {
            $wherestr .= " AND (media.description LIKE \"%$mediasearch%\" OR media.notes LIKE \"%$mediasearch%\" OR bodytext LIKE \"%$mediasearch%\")";
        }
        if ($tnggallery) {
            $wherestr .= " AND thumbpath != \"\"";
        }

        $cemwhere = $cemeteryID ? " AND cemeteryID = \"$cemeteryID\"" : "";

        $query = "SELECT DISTINCT media.mediaID, path, map, description, notes, width, height, datetaken, placetaken, owner, alwayson, abspath, usecollfolder, status, plot, cemeteryID, showmap, bodytext, form, newwindow, usenl, latitude, longitude, mediatypeID, gedcom ";
        $query .= "FROM $media_table media ";
        $query .= "$wherestr $cemwhere $wherestr3 ";
        $query .= "ORDER BY description";

        $result = tng_query($query);
        $offsets = get_media_offsets($result, $mediaID);
        $info['page'] = $offsets[0] + 1;
        tng_data_seek($result, $offsets[0]);

        $imgrow = tng_fetch_assoc($result);
        $info['mediadescription'] = $imgrow['description'];
        $info['medianotes'] = $imgrow['notes'];
        $info['mediaID'] = $mediaID;
        $info['ordernum'] = $ordernum;
    } else {
        $query = "SELECT medialinkID, path, map, description, notes, altdescription, altnotes, width, height, datetaken, placetaken, owner, ordernum, alwayson, abspath, media.mediaID AS mediaID, usecollfolder, status, plot, cemeteryID, showmap, bodytext, form, newwindow, usenl, latitude, longitude, mediatypeID, medialinks.gedcom ";
        $query .= "FROM ($media_table media, $medialinks_table medialinks) ";
        $query .= "WHERE personID = '$personID' AND medialinks.gedcom = '$tree' AND mediatypeID = '$mediatypeID' AND eventID = '$eventID' AND media.mediaID = medialinks.mediaID $wherestr3 ";
        $query .= "ORDER by ordernum";
        $result = tng_query($query);
        $offsets = get_media_offsets($result, $mediaID);
        $info['page'] = $offsets[0] + 1;
        if ($result) {
            tng_data_seek($result, $offsets[0]);
        }

        $imgrow = tng_fetch_assoc($result);
        $info['mediaID'] = $imgrow['mediaID'];
        $info['ordernum'] = $imgrow['ordernum'];
        $info['mediadescription'] = $imgrow['altdescription'] ? $imgrow['altdescription'] : $imgrow['description'];
        $info['medianotes'] = $imgrow['altnotes'] ? $imgrow['altnotes'] : $imgrow['notes'];
    }
    if ($imgrow['gedcom'] && $assignedtree && $imgrow['gedcom'] != $assignedtree) {
        $allow_media_edit = false;
    }
    $info['gotmap'] = $imgrow['map'] ? 1 : 0;
    $info['result'] = $result;
    $info['imgrow'] = $imgrow;

    return $info;
}

function findLivingPrivate($mediaID, $tree) {
    global $tree, $medialinks_table, $people_table, $families_table, $citations_table;

    $info = [];
    //select all medialinks for this mediaID, joined with people
    //loop through looking for living
    //if any are living, don't show media
    $query = "SELECT medialinks.medialinkID, medialinks.personID AS personID, medialinks.gedcom AS gedcom, linktype, people.living AS living, people.private AS private, people.branch AS branch, families.branch AS fbranch, families.living AS fliving, families.private AS fprivate ";
    $query .= "FROM $medialinks_table medialinks ";
    $query .= "LEFT JOIN $people_table people ON medialinks.personID = people.personID AND medialinks.gedcom = people.gedcom ";
    $query .= "LEFT JOIN $families_table families ON medialinks.personID = families.familyID AND medialinks.gedcom = families.gedcom ";
    $query .= "WHERE medialinks.mediaID = '$mediaID'";
    if ($tree) {
        $query .= " AND (medialinks.gedcom = '$tree' || medialinks.gedcom = '')";
        $wherestr2 = " AND medialinks.gedcom = '$tree'";
    } else {
        $wherestr2 = "";
    }
    $presult = tng_query($query);
    $noneliving = 1;
    $noneprivate = 1;
    $info['private'] = $info['living'] = "";

    while ($prow = tng_fetch_assoc($presult)) {
        if ($prow['private']) {
            $info['private'] = 1;
        }
        if ($prow['living']) {
            $info['living'] = 1;
        }
        if ($prow['fbranch']) {
            $prow['branch'] = $prow['fbranch'];
        }
        if ($prow['fliving'] == 1) {
            $prow['living'] = $prow['fliving'];
        }
        if ($prow['fprivate'] == 1) {
            $prow['private'] = $prow['fprivate'];
        }
        if (!$prow['living'] && !$prow['private'] && $prow['linktype'] == 'I') {
            $query = "SELECT count(*) AS ccount ";
            $query .= "FROM $citations_table citations, $people_table people ";
            $query .= "WHERE citations.sourceID = '{$prow['personID']}' AND citations.persfamID = people.personID AND citations.gedcom = people.gedcom AND (living = '1' OR private = '1')";
            $presult2 = tng_query($query);
            $prow2 = tng_fetch_assoc($presult2);
            if ($prow2['ccount']) {
                $prow['living'] = 1;
            }
            tng_free_result($presult2);
        }
        $prights = determineLivingPrivateRights($prow);
        if (!$prights['both']) {
            if ($prow['private']) {
                $noneprivate = 0;
            }
            if ($prow['living']) {
                $noneliving = 0;
            }
            break;
        }
    }
    tng_free_result($presult);

    $info['noneliving'] = $noneliving;
    $info['noneprivate'] = $noneprivate;

    return $info;
}

function getMediaNavigation($mediaID, $personID, $albumlinkID, $result, $showlinks = true) {
    global $allow_admin, $allow_media_edit, $albumname, $albumID, $offset;
    global $tree, $page, $maxsearchresults, $linktype, $showall, $tnggallery, $text;
    global $tngconfig;
    global $totalpages, $all;

    $mediaperpage = 1;
    $max_showmedia_pages = 5;
    $pagenum = ceil($page / $maxsearchresults);
    $pagenam = "";

    if ($showlinks) {
        if ($allow_admin && $allow_media_edit) {
            $pagenav .= "<a href=\"admin_editmedia.php?mediaID=$mediaID&amp;cw=1\" target='_blank' class=\"snlink\">&raquo; {$text['editmedia']}</a> &nbsp;&nbsp;&nbsp;";
        }

        if ($albumlinkID) {
            $offset = floor($page / $maxsearchresults) * $maxsearchresults;
            $pagenav .= "<a href=\"showalbum.php?albumID=$albumID&amp;offset=$offset&amp;tngpage=$pagenum&amp;tnggallery=$tnggallery\" class=\"snlink\">&raquo; $albumname</a>  &nbsp;&nbsp;&nbsp;";
        } elseif (!$personID) {
            $offset = floor($page / $maxsearchresults) * $maxsearchresults;
            $pagenav .= "<a href=\"browsemedia.php?" . $showall . "offset=$offset&amp;tngpage=$pagenum&amp;tnggallery=$tnggallery\" class=\"snlink\">&raquo; {$text['showall']}</a>  &nbsp;&nbsp;&nbsp;";
        } else {
            if ($linktype == "F") {
                $pagenav .= "<a href=\"familygroup.php?familyID=$personID&amp;tree=$tree\" class=\"snlink\">&raquo; {$text['groupsheet']}</a>  &nbsp;&nbsp;&nbsp;";
            } elseif ($linktype == "S") {
                $pagenav .= "<a href=\"showsource.php?sourceID=$personID&amp;tree=$tree\" class=\"snlink\">&raquo; {$text['source']}</a>  &nbsp;&nbsp;&nbsp;";
            } elseif ($linktype == "R") {
                $pagenav .= "<a href=\"showrepo.php?repoID=$personID&amp;tree=$tree\" class=\"snlink\">&raquo; {$text['repository']}</a>  &nbsp;&nbsp;&nbsp;";
            } elseif ($linktype == "L") {
                $treestr = $tngconfig['places1tree'] ? "" : "&amp;tree=$tree";
                $pagenav .= "<a href=\"placesearch.php?psearch=$personID$treestr\" class=\"snlink\">&raquo; {$text['place']}: $personID</a>  &nbsp;&nbsp;&nbsp;";
            }
        }
    }

    $total = tng_num_rows($result);

    if (!$page) {
        $page = 1;
    }
    if ($total > $mediaperpage) {
        $totalpages = ceil($total / $mediaperpage);
        if ($page > $totalpages) {
            $page = $totalpages;
        }
        $allstr = $all ? "&amp;all=1" : "";

        if ($page > 1) {
            $prevpage = $page - 1;
            $prevlink = get_media_link($result, "showmedia.php?", $prevpage, "jump", $text['text_prev'], "&laquo;" . $text['text_prev'], $allstr, $showlinks);
        }
        if ($page < $totalpages) {
            $nextpage = $page + 1;
            $nextlink = get_media_link($result, "showmedia.php?", $nextpage, "jumpnext", $text['text_next'], $text['text_next'] . "&raquo;", $allstr, $showlinks);
        }
        $curpage = 0;
        $numlinks = "";
        while ($curpage++ < $totalpages) {
            if (($curpage <= $page - $max_showmedia_pages || $curpage >= $page + $max_showmedia_pages) && $max_showmedia_pages != 0) {
                if ($curpage == 1) {
                    $firstlink = get_media_link($result, "showmedia.php?", $curpage, "jump", $text['firstpage'], "&laquo;1", $allstr, $showlinks) . "...";
                }
                if ($curpage == $totalpages) {
                    $lastlink = "..." . get_media_link($result, "showmedia.php?", $curpage, "jump", $text['lastpage'], "$totalpages&raquo;", $allstr, $showlinks);
                }
            } else {
                if ($curpage == $page) {
                    $numlinks .= " <span class=\"snlink snlinkact\">$curpage</span> ";
                } else {
                    $numlinks .= get_media_link($result, "showmedia.php?", $curpage, "jump", $curpage, $curpage, $allstr, $showlinks);
                }
            }
        }
        $pagenav .= "<span class='normal'>$prevlink $firstlink $numlinks $lastlink $nextlink</span>";
    }

    return $pagenav;
}

function getAlbumLinkText($mediaID) {
    global $albums_table, $albumlinks_table;

    $albumlinktext = "";
    //get all albumlink records for this mediaID, joined with album tables
    $query = "SELECT albums.albumID, albumname ";
    $query .= "FROM ($albumlinks_table albumlinks, $albums_table albums) ";
    $query .= "WHERE mediaID = '$mediaID' AND albumlinks.albumID = albums.albumID";
    $result = tng_query($query);
    while ($row = tng_fetch_assoc($result)) {
        if ($albumlinktext) {
            $albumlinktext .= ", ";
        }
        $albumlinktext .= "<a href=\"showalbum.php?albumID={$row['albumID']}\">" . $row['albumname'] . "</a>";
    }
    tng_free_result($result);

    return $albumlinktext;
}

function getMediaLinkText($mediaID, $ioffset) {
    global $text, $admtext, $medialinks_table, $people_table, $families_table, $sources_table, $repositories_table, $events_table, $eventtypes_table, $wherestr2, $maxsearchresults;
    global $tngconfig, $citations_table;

    if ($ioffset) {
        $ioffsetstr = "$ioffset, ";
        $newioffset = $ioffset + 1;
    } else {
        $ioffsetstr = "";
        $newioffset = 0;
    }
    $query = "SELECT medialinks.medialinkID, medialinks.personID AS personID, people.burialtype, people.living AS living, people.private AS private, people.branch AS branch, medialinks.eventID, families.branch AS fbranch, families.living AS fliving, families.private AS fprivate, people.lastname AS lastname, people.lnprefix AS lnprefix, people.firstname AS firstname, people.prefix AS prefix, people.suffix AS suffix, people.nameorder, altdescription, altnotes, medialinks.gedcom, familyID, people.personID AS personID2, wifepeople.personID AS wpersonID, wifepeople.firstname AS wfirstname, wifepeople.lnprefix AS wlnprefix, wifepeople.lastname AS wlastname, wifepeople.prefix AS wprefix, wifepeople.suffix AS wsuffix, husbpeople.personID AS hpersonID, husbpeople.firstname AS hfirstname, husbpeople.lnprefix AS hlnprefix, husbpeople.lastname AS hlastname, husbpeople.prefix AS hprefix, husbpeople.suffix AS hsuffix, sources.title, sources.sourceID, repositories.repoID, reponame, linktype ";
    $query .= "FROM $medialinks_table medialinks ";
    $query .= "LEFT JOIN $people_table people ON medialinks.personID = people.personID AND medialinks.gedcom = people.gedcom ";
    $query .= "LEFT JOIN $families_table families ON medialinks.personID = families.familyID AND medialinks.gedcom = families.gedcom ";
    $query .= "LEFT JOIN $people_table husbpeople ON families.husband = husbpeople.personID AND families.gedcom = husbpeople.gedcom ";
    $query .= "LEFT JOIN $people_table wifepeople ON families.wife = wifepeople.personID AND families.gedcom = wifepeople.gedcom ";
    $query .= "LEFT JOIN $sources_table sources ON medialinks.personID = sources.sourceID AND medialinks.gedcom = sources.gedcom ";
    $query .= "LEFT JOIN $repositories_table repositories ON (medialinks.personID = repositories.repoID AND medialinks.gedcom = repositories.gedcom) ";
    $query .= "WHERE mediaID = '$mediaID'";
    $query .= "$wherestr2 ";
    $query .= "ORDER BY people.lastname, people.lnprefix, people.firstname, hlastname, hlnprefix, hfirstname ";
    $query .= "LIMIT $ioffsetstr" . ($maxsearchresults + 1);
    $presult = tng_query($query);
    $numrows = tng_num_rows($presult);
    $medialinktext = "";
    $count = 0;
    $citelinks = [];
    $need_semicolon = false;
    while ($count < $maxsearchresults && $prow = tng_fetch_assoc($presult)) {
        if ($prow['fbranch'] != NULL) {
            $prow['branch'] = $prow['fbranch'];
        }
        if ($prow['fliving'] != NULL) {
            $prow['living'] = $prow['fliving'];
        }
        if ($prow['fprivate'] != NULL) {
            $prow['private'] = $prow['fprivate'];
        }
        if ($need_semicolon) {
            $medialinktext .= "; ";
        }
        $need_semicolon = true;

        $prights = determineLivingPrivateRights($prow);
        $prow['allow_living'] = $prights['living'];
        $prow['allow_private'] = $prights['private'];

        if ($prow['personID2'] != NULL) {
            $medialinktext .= "<a href=\"getperson.php?personID={$prow['personID2']}&amp;tree={$prow['gedcom']}\">";
            $medialinktext .= getName($prow) . "</a>";
        } elseif ($prow['sourceID'] != NULL) {
            $sourcetext = $prow['title'] ? $prow['title'] : $text['source'] . ": " . $prow['sourceID'];
            $medialinktext .= "<a href=\"showsource.php?sourceID={$prow['sourceID']}&amp;tree={$prow['gedcom']}\">" . $sourcetext . "</a>";
        } elseif ($prow['repoID'] != NULL) {
            $repotext = $prow['reponame'] ? $prow['reponame'] : $text['repository'] . ": " . $prow['repoID'];
            $medialinktext .= "<a href=\"showrepo.php?repoID={$prow['repoID']}&amp;tree={$prow['gedcom']}\">" . $repotext . "</a>";
        } elseif ($prow['familyID'] != NULL) {
            $familyname = trim($prow['hlnprefix'] . " " . $prow['hlastname']) . "/" . trim($prow['wlnprefix'] . " " . $prow['wlastname']) . " ({$prow['familyID']})";
            $medialinktext .= "<a href=\"familygroup.php?familyID={$prow['familyID']}&amp;tree={$prow['gedcom']}\">{$text['family']}: $familyname</a>";
        } elseif (!$prow['linktype'] || $prow['linktype'] == "C") {
            $query = "SELECT persfamID, sourceID, gedcom FROM $citations_table WHERE citationID = \"{$prow['personID']}\"";
            $cresult = tng_query($query);
            $need_semicolon = false;
            if ($cresult) {
                $crow = tng_fetch_assoc($cresult);
                if ($crow) {
                    $persfamID = $crow['persfamID'];
                    if (!in_array($persfamID, $citelinks)) {
                        $citelinks[] = $persfamID;
                        if (substr($persfamID, 0, 1) == $tngconfig['personprefix'] || substr($persfamID, -1) == $tngconfig['personsuffix']) {
                            $medialinktext .= "<a href=\"getperson.php?personID=$persfamID&amp;tree={$crow['gedcom']}\">";
                            $presult2 = getPersonSimple($prow['gedcom'], $persfamID);
                            if ($presult2) {
                                $cprow = tng_fetch_assoc($presult2);
                                $cprights = determineLivingPrivateRights($cprow);
                                $cprow['allow_living'] = $cprights['living'];
                                $cprow['allow_private'] = $cprights['private'];
                                $medialinktext .= getName($cprow) . "</a>";
                                $need_semicolon = true;
                                tng_free_result($presult2);
                            }
                        } elseif (substr($persfamID, 0, 1) == $tngconfig['familyprefix'] || substr($persfamID, -1) == $tngconfig['familysuffix']) {
                            $presult2 = getFamilyData($prow['gedcom'], $persfamID);
                            if ($presult2) {
                                $famrow = tng_fetch_assoc($presult);
                                $familyname = getFamilyName($famrow);
                                $medialinktext .= "<a href=\"familygroup.php?familyID=$persfamID&amp;tree={$crow['gedcom']}\">{$text['family']}: $familyname</a>";
                                $need_semicolon = true;
                                tng_free_result($presult2);
                            }
                        }
                    }
                }
            }
            tng_free_result($cresult);
        } else {
            $treestr = $tngconfig['places1tree'] ? "" : "&amp;tree={$prow['gedcom']}";
            $medialinktext .= "<a href=\"placesearch.php?psearch=" . urlencode($prow['personID']) . "$treestr\">" . $prow['personID'] . "</a>";
        }
        if ($prow['eventID']) {
            $query = "SELECT display ";
            $query .= "FROM $events_table events, $eventtypes_table eventtypes ";
            $query .= "WHERE eventID = \"{$prow['eventID']}\" AND events.eventtypeID = eventtypes.eventtypeID";
            $eresult = tng_query($query);
            $erow = tng_fetch_assoc($eresult);
            if ($prow['eventID'] == "BURI" && $prow['burialtype'] == "1") {
                $event = $text["cremated"];
            } else {
                $event = $erow['display'] && is_numeric($prow['eventID']) ? getEventDisplay($erow['display']) : ($admtext[$prow['eventID']] ? $admtext[$prow['eventID']] : $prow['eventID']);
            }
            tng_free_result($eresult);
            if ($event) {
                $medialinktext .= " ($event)";
            }
        }
        $count++;
    }
    tng_free_result($presult);
    if ($numrows > $maxsearchresults) {
        $medialinktext .= "\n['<a href=\"showmedia.php?mediaID=$mediaID&amp;ioffset=" . ($newioffset + $maxsearchresults) . "\">{$text['morelinks']}</a>']";
    }

    return $medialinktext;
}

function showMediaSource($imgrow, $ss = false) {
    global $text, $usefolder, $size, $imagetypes, $htmldocs, $tngconfig, $videotypes, $recordingtypes;
    global $description, $medialinkID, $albumlinkID, $mediatypes_like;

    if (isMobile()) {
        $ss = false;
    }
    if ($imgrow['form']) {
        $imgrow['form'] = strtoupper($imgrow['form']);
    } else {
        preg_match("/\.(.+)$/", $imgrow['path'], $matches);
        $imgrow['form'] = strtoupper($matches[1]);
    }
    if ($ss) {
        echo "<div class='lightback slidepane rounded10'>\n";
    }
    if (!$ss && $imgrow['map']) {
        echo "<map name=\"tngmap_{$imgrow['mediaID']}\" id=\"tngmap_{$imgrow['mediaID']}\">{$imgrow['map']}</map>\n";
        $mapstr = " usemap=\"#tngmap_{$imgrow['mediaID']}\"";
    } else {
        $mapstr = "";
    }
    if ($imgrow['abspath'] || substr($imgrow['path'], 0, 4) == "http" || substr($imgrow['path'], 0, 1) == "/") {
        $mediasrc = $imgrow['path'];
    } else {
        $treestr = $tngconfig['mediatrees'] && $imgrow['gedcom'] ? $imgrow['gedcom'] . "/" : "";
        $mediasrc = "$usefolder/$treestr" . str_replace("%2F", "/", rawurlencode($imgrow['path']));
    }

    $targettext = $imgrow['newwindow'] ? " target='_blank'" : "";
    if ($imgrow['path']) {
        if ($imgrow['abspath']) {
            if ($imgrow['newwindow']) {
                echo "<form><input type='button' value=\"{$text['viewitem']}...\" onClick=\"window.open('$mediasrc');\"></form>\n";
            } else {
                echo "<form><input type='button' value=\"{$text['viewitem']}...\" onClick=\"window.location.href='$mediasrc';\"></form>\n";
            }
        } else {
            if (!$imgrow['form']) {
                preg_match("/\.(.+)$/", $imgrow['path'], $matches);
                $imgrow['form'] = $matches[1];
            }
            if (in_array($imgrow['form'], $imagetypes)) {
                $width = $size[0];
                $height = $size[1];
                if ($ss) {
                    if (!isMobile()) {
                        $maxw = 860;
                        $maxh = 550;
                    } else {
                        $maxw = 600;
                        $maxh = 400;
                    }
                    $medialinkstr = $medialinkID ? "&medialinkID=$medialinkID" : "";
                    $albumlinkstr = $albumlinkID ? "&albumlinkID=$albumlinkID" : "";
                }
                if ($width && $height) {
                    if ($ss) {
                        if ($width > $height) {
                            $height = floor($height * $maxw / $width);
                            $width = $maxw;
                        } else {
                            $width = floor($width * $maxh / $height);
                            $height = $maxh;
                        }
                    } else {
                        $maxw = $tngconfig['imgmaxw'];
                        $maxh = $tngconfig['imgmaxh'];
                    }
                    if ($maxw && ($width > $maxw)) {
                        $width = $maxw;
                        $height = floor($width * $size[1] / $size[0]);
                    }
                    if ($maxh && ($height > $maxh)) {
                        $height = $maxh;
                        $width = floor($height * $size[0] / $size[1]);
                    }
                } elseif ($ss) {
                    $height = $maxh;
                }
                if ($width && $width != "0") {
                    $widthstr = "width=\"$width\"";
                }
                if ($height && $height != "0") {
                    $heightstr = "height=\"$height\"";
                }
                if ($ss) {  //slideshow
                    $img = "<img src=\"$mediasrc\" $mapstr alt=\"$description\">";
                    echo "<div id=\"slidearea\"><a href=\"showmedia.php?mediaID={$imgrow['mediaID']}$medialinkstr$albumlinkstr\" border='0' title=\"{$text['moreinfo']}\">$img</a></div>\n";
                } else {
                    $imgviewer = $tngconfig['imgviewer'];
                    if (!$imgviewer || in_array($imgrow['mediatypeID'], $mediatypes_like[$imgviewer])) {
                        $maxvh = $tngconfig['imgvheight'];
                        $calcHeight = $maxvh ? ($height > $maxvh ? $maxvh : $height) : 1;
                        echo "<div id='loadingdiv2' class='rounded10' style='position:static;'>{$text['loading']}</div>";
                        echo "<iframe name='iframe1' id='iframe1' src=\"img_viewer.php?mediaID={$imgrow['mediaID']}&amp;medialinkID={$imgrow['medialinkID']}\" width='100%' height='1' onload=\"calcHeight($calcHeight)\" frameborder='0' marginheight='0' marginwidth='0' scrolling='no'></iframe>";
                    } else {
                        echo "<div class='titlebox mediaalign' id='imgdiv'><img src='$mediasrc' id='theimage' $mapstr alt='$description'></div>\n";
                    }
                }
            } elseif (in_array($imgrow['form'], $videotypes) || in_array($imgrow['form'], $recordingtypes)) {
                $widthstr = $imgrow['width'] ? " width=\"{$imgrow['width']}\"" : "";
                $heightstr = $imgrow['height'] ? " height=\"{$imgrow['height']}\"" : "";

                if ($imgrow['form'] == 'FLV') {
                    $flvheight = $imgrow['height'] ? $imgrow['height'] : 300;
                    $flvwidth = $imgrow['width'] ? $imgrow['width'] : 400;
                    $preview_img = str_replace('.flv', '.jpg', $mediasrc);
                    echo "<script src=\"flvsupport/flowplayer-3.2.8.min.js\"></script>";
                    echo "<a href=\"$mediasrc\"";
                    echo "style=\"display:block;width:{$flvwidth}px;height:{$flvheight}px;\" id=\"videoplayer\">";
                    if (file_exists(str_replace("%20", " ", $preview_img))) {
                        echo "<img src='$preview_img'style=\"display:block;width:{$flvwidth}px;height:{$flvheight}px;\" alt=\"Click here to play this video...\">";
                    } elseif (file_exists("flvsupport/flvicon.png")) {
                        echo "<img src='flvsupport/flvicon.png' alt='Click here to play this video...'>";
                    }
                    echo "</a>";
                    echo "<script>flowplayer('videoplayer','flvsupport/flowplayer-3.2.9.swf');</script>";
                } elseif (in_array($imgrow['form'], ["MOV", "MP4", "WEBM", "OGG"])) {
                    echo "<video $widthstr$heightstr controls>\n<source src=\"$mediasrc\">\n</video>\n";
                } else {
                    echo "<embed src=\"$mediasrc\"$widthstr$heightstr>\n";
                }
            } elseif (in_array($imgrow['form'], $recordingtypes)) {
                if (in_array($imgrow['form'], ["MP3", "WAV", "OGG"])) {
                    echo "<audio $widthstr$heightstr controls>\n<source src=\"$mediasrc\">\n</audio>\n";
                } else {
                    echo "<embed src=\"$mediasrc\"$widthstr$heightstr>\n";
                }
            } else {
                if ($imgrow['newwindow']) {
                    echo "<form><input type='button' value=\"{$text['viewitem']}...\" onClick=\"window.open('$mediasrc');\"></form>\n";
                } else {
                    echo "<form><input type='button' value=\"{$text['viewitem']}...\" onClick=\"window.location.href='$mediasrc';\"></form>\n";
                }
            }
        }
    }
    if ($imgrow['bodytext']) {
        if ($imgrow['path']) {
            echo "<br><br>\n";
        }
        echo "<div class='normal'>" . ($imgrow['usenl'] ? nl2br($imgrow['bodytext']) : $imgrow['bodytext']) . "</div>";
    }
    if ($ss) {
        echo "</div>\n";
    }
}

function tableRow($label, $fact) {
    return "<tr><td style=\"width:100px;\" class=\"fieldnameback fieldname\">$label</td><td class='databack'>" . insertLinks($fact) . "</td></tr>\n";
}

function showTable($imgrow, $medialinktext, $albumlinktext) {
    global $text, $rootpath, $usefolder, $showextended, $imagetypes, $size, $info;

    $tabletext = "";
    $filename = $imgrow['abspath'] ? $imgrow['path'] : basename($imgrow['path']);
    $tabletext .= "<table class='whiteback w-100' border='0' cellspacing='1' cellpadding='4'>\n";

    if ($imgrow['owner']) {
        $tabletext .= tableRow($text['photoowner'], $imgrow['owner']);
    }
    if ($imgrow['datetaken']) {
        $tabletext .= tableRow($text['date'], displayDate($imgrow['datetaken']));
    }
    if ($imgrow['placetaken']) {
        $tabletext .= tableRow($text['place'], $imgrow['placetaken']);
    }
    if ($imgrow['latitude']) {
        $tabletext .= tableRow($text['latitude'], $imgrow['latitude']);
    }
    if ($imgrow['longitude']) {
        $tabletext .= tableRow($text['longitude'], $imgrow['longitude']);
    }

    if ($showextended) {
        if ($filename) {
            $tabletext .= tableRow($text['filename'], $filename);
            $filesize = $imgrow['path'] && file_exists("$rootpath$usefolder/" . $imgrow['path']) ? display_size(filesize("$rootpath$usefolder/" . $imgrow['path'])) : "";
            $tabletext .= tableRow($text['filesize'], $filesize);
        }
        if (in_array($imgrow['form'], $imagetypes)) {
            $tabletext .= tableRow($text['photosize'], "$size[0] x $size[1]");
        }
        $tabletext .= output_iptc_data($info);
    }

    if ($medialinktext) {
        $tabletext .= tableRow($text['indlinked'], $medialinktext);
    }
    if ($albumlinktext) {
        $tabletext .= tableRow($text['albums'], $albumlinktext);
    }
    $tabletext .= "</table>\n";

    return $tabletext;
}

function doCemPlusMap($imgrow, $tree) {
    global $cemeteries_table, $media_table, $text, $rootpath, $headstonepath, $mediatypes_assoc, $mediapath, $thumbmaxw;

    $query = "SELECT cemname, city, county, state, country, maplink, notes FROM $cemeteries_table WHERE cemeteryID = \"{$imgrow['cemeteryID']}\"";
    $cemresult = tng_query($query);
    $cemetery = tng_fetch_assoc($cemresult);
    tng_free_result($cemresult);

    echo "<h3 class='subhead'>\n";
    $location = $cemetery['cemname'];
    if ($cemetery['city']) {
        if ($location) {
            $location .= ", ";
        }
        $location .= $cemetery['city'];
    }
    if ($cemetery['county']) {
        if ($location) {
            $location .= ", ";
        }
        $location .= $cemetery['county'];
    }
    if ($cemetery['state']) {
        if ($location) {
            $location .= ", ";
        }
        $location .= $cemetery['state'];
    }
    if ($cemetery['country']) {
        if ($location) {
            $location .= ", ";
        }
        $location .= $cemetery['country'];
    }
    echo "<a href=\"showmap.php?cemeteryID={$imgrow['cemeteryID']}&amp;tree=$tree\">$location</a>";
    echo "</h3>\n";
    if ($cemetery['notes']) {
        echo "<p><strong>{$text['notes']}:</strong> " . nl2br($cemetery['notes']) . "</p>";
    }

    if ($imgrow['showmap']) {
        if ($cemetery['maplink'] && file_exists("$rootpath$headstonepath/" . $cemetery['maplink'])) {
            $mapsize = @GetImageSize("$rootpath$headstonepath/" . $cemetery['maplink']);
            echo "<img src=\"$headstonepath/{$cemetery['maplink']}\" $mapsize[3] alt=\"{$cemetery['cemname']}\"><br><br>\n";
        }
    }

    $query = "SELECT mediaID, mediatypeID, path, thumbpath, description, notes, usecollfolder, abspath, newwindow, gedcom ";
    $query .= "FROM $media_table ";
    $query .= "WHERE cemeteryID = \"{$imgrow['cemeteryID']}\" AND linktocem = '1' ORDER BY mediatypeID, description";
    $hsresult = tng_query($query);
    if (tng_num_rows($hsresult)) {
        $i = 1;
        echo "<div class=\"titlebox\">\n";
        echo "<h3 class='subhead'>{$text['cemphotos']}</h3>";

        echo "<table class='whiteback w-100' cellpadding='3' cellspacing='1' border='0'>\n";
        echo "<tr><td class='fieldnameback' width=\"10\">&nbsp;</td>\n";
        echo "<td class='fieldnameback' width=\"$thumbmaxw\"><span class='fieldname'>&nbsp;<strong>{$text['thumb']}</strong>&nbsp;</span></td>\n";
        echo "<td class='fieldnameback'><span class='fieldname'>&nbsp;<strong>{$text['description']}</strong>&nbsp;</span></td></tr>\n";

        while ($hs = tng_fetch_assoc($hsresult)) {
            $description = $hs['description'];
            $notes = nl2br($hs['notes']);
            $hsmediatypeID = $hs['mediatypeID'];
            $usehsfolder = $hs['usecollfolder'] ? $mediatypes_assoc[$hsmediatypeID] : $mediapath;
            $hs['allow_living'] = 1;

            $imgsrc = getSmallPhoto($hs);
            if ($hs['abspath'] || substr($hs['path'], 0, 4) == "http" || substr($hs['path'], 0, 1) == "/") {
                $href = $hs['path'];
            } else {
                $href = "showmedia.php?mediaID=" . $hs['mediaID'];
            }

            $targettext = $hs['newwindow'] ? " target='_blank'" : "";
            echo "<tr>";
            echo "<td class='databack'><span class='normal'>$i</span></td>";
            echo "<td class='databack' width=\"$thumbmaxw\">";
            echo $imgsrc ? "<a href=\"$href\"$targettext>$imgsrc</a>" : "&nbsp;";
            echo "</td>\n";
            echo "<td class='databack'><span class='normal'>";
            echo "<a href=\"$href\">$description</a><br>$notes&nbsp;</span></td></tr>\n";
            $i++;
        }
        echo "</table>\n</div>\n";
    }
    tng_free_result($hsresult);
}
