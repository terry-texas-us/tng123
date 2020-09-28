<?php
function get_item_id($result, $offset, $itemname) {
    if (!tng_data_seek($result, $offset)) {
        return (0);
    }
    $row = tng_fetch_assoc($result);

    return $row[$itemname];
}

function get_item_id_pair($result, $offset, $itemname, $needamp) {
    $item = get_item_id($result, $offset, $itemname);
    if ($item) {
        $str = $itemname . "=" . $item;
        if ($needamp) {
            $str = "&amp;" . $str;
        }
    } else {
        $str = "";
    }

    return $str;
}

function get_media_offsets($result, $mediaID) {
    tng_data_seek($result, 0);
    $found = 0;
    for ($i = 0; $i < tng_num_rows($result); $i++) {
        $row = tng_fetch_assoc($result);
        if ($row['mediaID'] == $mediaID) {
            $found = 1;
            break;
        }
    }
    if (!$found && $i) {
        $i--;
    }
    $nexttolast = tng_num_rows($result) - 1;
    $prev = $i ? $i - 1 : $nexttolast;
    $next = $i < $nexttolast ? $i + 1 : 0;

    return [$i, $prev, $next, $nexttolast];
}

function get_media_link($result, $address, $page, $jumpfunc, $title, $label, $allstr, $showlinks) {
    global $cemeteryID;

    $mediaID = get_item_id($result, $page - 1, "mediaID");
    $medialinkID = get_item_id($result, $page - 1, "medialinkID");
    $albumlinkID = get_item_id($result, $page - 1, "albumlinkID");

    if ($showlinks) {
        $href = $mediaID ? "&amp;mediaID=" . $mediaID : "";
        $href .= $medialinkID ? "&amp;medialinkID=" . $medialinkID : "";
        $href .= $albumlinkID ? "&amp;albumlinkID=" . $albumlinkID : "";
        $href .= $cemeteryID ? "&amp;cemeteryID=" . get_item_id($result, $page - 1, "cemeteryID") : "";
        $href .= $allstr . "&amp;tngpage=$page";
        if (substr($href, 0, 5) == "&amp;") {
            $href = substr($href, 5);
        }
        $link = " <a href=\"$address$href\" class=\"snlink\" title=\"$title\">$label</a> ";
    } else {
        $link = " <a href=\"#\" class=\"snlink\" onclick=\"return $jumpfunc('$mediaID','$medialinkID','$albumlinkID')\" title=\"$title\">$label</a> ";
    }

    return $link;
}

function doMedia($mediatypeID) {
    global $media_table, $medialinks_table, $change_limit, $cutoffstr, $wherestr, $text, $admtext, $families_table, $sources_table, $repositories_table, $citations_table, $nonames;
    global $people_table, $trees_table, $currentuser, $userlist;
    global $rootpath, $mediapath, $header, $footer, $cemeteries_table, $mediatypes_assoc, $mediatypes_display;
    global $whatsnew, $wherestr2, $thumbmaxw, $events_table, $eventtypes_table, $altstr, $tngconfig;

    if ($mediatypeID == "headstones") {
        $hsfields = ", media.cemeteryID, cemname, city";
        $hsjoin = "LEFT JOIN $cemeteries_table cemeteries ON media.cemeteryID = cemeteries.cemeteryID";
    } else {
        $hsfields = $hsjoin = "";
    }

    $query = "SELECT distinct media.mediaID AS mediaID, description $altstr, media.notes, thumbpath, path, form, mediatypeID, media.gedcom AS gedcom, alwayson, usecollfolder, DATE_FORMAT(changedate,'%e %b %Y') AS changedatef, changedby, status, plot, abspath, newwindow $hsfields";
    if (strpos($_SERVER['SCRIPT_NAME'], "placesearch") !== FALSE) {
        $query .= ", ordernum";
    } else {
        $query .= ", changedate";
    }

    $query .= " FROM $media_table media ";
    $query .= "$hsjoin";
    if ($wherestr2) {
        $query .= " LEFT JOIN $medialinks_table medialinks ON media.mediaID = medialinks.mediaID";
    }
    $query .= " WHERE $cutoffstr $wherestr mediatypeID = \"$mediatypeID\" ";
    $query .= "ORDER BY ";
    if (strpos($_SERVER['SCRIPT_NAME'], "placesearch") !== FALSE) {
        $query .= "ordernum";
    } else {
        $query .= "changedate DESC, description";
    }
    $query .= " LIMIT $change_limit";
    $mediaresult = tng_query($query);

    $titlemsg = $text[$mediatypeID] ? $text[$mediatypeID] : $mediatypes_display[$mediatypeID];
    $mediaheader = "<div class='titlebox'><h3 class='subhead'>$titlemsg</h3>\n" . $header;

    $mediatext = "";
    $thumbcount = 0;
    $gotImageJpeg = function_exists("imageJpeg");

    while ($row = tng_fetch_assoc($mediaresult)) {
        $mediatypeID = $row['mediatypeID'];
        $usefolder = $row['usecollfolder'] ? $mediatypes_assoc[$mediatypeID] : $mediapath;

        $status = $row['status'];
        if ($status && $text[$status]) {
            $row['status'] = $text[$status];
        }

        $query = "SELECT medialinkID, medialinks.personID AS personID, medialinks.eventID, people.personID AS personID2, familyID, people.living AS living, people.private AS private, people.branch AS branch, families.branch AS fbranch, families.living AS fliving, families.private AS fprivate, husband, wife, people.lastname AS lastname, people.lnprefix AS lnprefix, people.firstname AS firstname, people.prefix AS prefix, people.suffix AS suffix, nameorder, medialinks.gedcom AS gedcom, treename, sources.title, sources.sourceID, repositories.repoID,reponame, deathdate, burialdate, linktype ";
        $query .= "FROM $medialinks_table medialinks ";
        $query .= "LEFT JOIN $people_table people ON (medialinks.personID = people.personID AND medialinks.gedcom = people.gedcom) ";
        $query .= "LEFT JOIN $families_table families ON (medialinks.personID = families.familyID AND medialinks.gedcom = families.gedcom) ";
        $query .= "LEFT JOIN $sources_table sources ON (medialinks.personID = sources.sourceID AND medialinks.gedcom = sources.gedcom) ";
        $query .= "LEFT JOIN $repositories_table repositories ON (medialinks.personID = repositories.repoID AND medialinks.gedcom = repositories.gedcom) ";
        $query .= "LEFT JOIN $trees_table trees ON medialinks.gedcom = trees.gedcom ";
        $query .= "WHERE mediaID = \"{$row['mediaID']}\"$wherestr2 ";
        $query .= "ORDER BY lastname, lnprefix, firstname, medialinks.personID";
        $presult = tng_query($query);
        $foundliving = 0;
        $foundprivate = 0;
        $medialinktext = "";
        while ($prow = tng_fetch_assoc($presult)) {
            if ($prow['fbranch'] != NULL) {
                $prow['branch'] = $prow['fbranch'];
            }
            if ($prow['fliving'] != NULL) {
                $prow['living'] = $prow['fliving'];
            }
            if ($prow['fprivate'] != NULL) {
                $prow['private'] = $prow['fprivate'];
            }
            if ($prow['living'] == NULL && $prow['private'] == NULL && $prow['linktype'] == 'I') {
                $query = "SELECT count(personID) AS ccount FROM $citations_table, $people_table
					WHERE $citations_table.sourceID = '{$prow['personID']}' AND $citations_table.persfamID = $people_table.personID AND $citations_table.gedcom = $people_table.gedcom
					AND (living = '1' OR private = '1')";
                $presult2 = tng_query($query);
                $prow2 = tng_fetch_assoc($presult2);
                if ($prow2['ccount']) {
                    $prow['living'] = 1;
                }
                tng_free_result($presult2);
            }

            $rights = determineLivingPrivateRights($prow);
            $prow['allow_living'] = $rights['living'];
            $prow['allow_private'] = $rights['private'];

            if (!$rights['living']) {
                $foundliving = 1;
            }
            if (!$rights['private']) {
                $foundprivate = 1;
            }

            $hstext = "";
            if ($prow['personID2'] != NULL) {
                $medialinktext .= "<li><a href=\"getperson.php?personID={$prow['personID2']}&amp;tree={$prow['gedcom']}\">";
                $medialinktext .= getName($prow);
                if ($mediatypeID == "headstones") {
                    $deathdate = $prow['deathdate'] ? $prow['deathdate'] : $prow['burialdate'];
                    if ($prow['deathdate']) {
                        $abbrev = $text['deathabbr'];
                    } elseif ($prow['burialdate']) {
                        $abbrev = $text['burialabbr'];
                    }
                    $hstext = $deathdate ? " ($abbrev " . displayDate($deathdate) . ")" : "";
                }
            } elseif ($prow['familyID'] != NULL) {
                $medialinktext .= "<li><a href=\"familygroup.php?familyID={$prow['familyID']}&amp;tree={$prow['gedcom']}\">{$text['family']}: " . getFamilyName($prow);
            } elseif ($prow['sourceID'] != NULL) {
                $sourcetext = $prow['title'] ? $text['source'] . ": " . $prow['title'] : $text['source'] . ": " . $prow['sourceID'];
                $medialinktext .= "<li><a href=\"showsource.php?sourceID={$prow['sourceID']}&amp;tree={$prow['gedcom']}\">$sourcetext";
            } elseif ($prow['repoID'] != NULL) {
                $repotext = $prow['reponame'] ? $text['repository'] . ": " . $prow['reponame'] : $text['repository'] . ": " . $prow['repoID'];
                $medialinktext .= "<li><a href=\"showrepo.php?repoID={$prow['repoID']}&amp;tree={$prow['gedcom']}\">$repotext";
            } else {
                $medialinktext .= "<li><a href=\"placesearch.php?psearch=" . urlencode($prow['personID']);
                if (!$tngconfig['places1tree']) {
                    $medialinktext .= "&amp;tree={$prow['gedcom']}";
                }
                $medialinktext .= "\">" . $prow['personID'];
            }
            if ($prow['eventID']) {
                $query = "SELECT display ";
                $query .= "FROM $events_table events, $eventtypes_table eventtypes WHERE eventID = \"{$prow['eventID']}\" AND events.eventtypeID = eventtypes.eventtypeID";
                $eresult = tng_query($query);
                $erow = tng_fetch_assoc($eresult);
                $event = $erow['display'] && is_numeric($prow['eventID']) ? getEventDisplay($erow['display']) : ($admtext[$prow['eventID']] ? $admtext[$prow['eventID']] : $prow['eventID']);
                tng_free_result($eresult);
                $medialinktext .= " ($event)";
            }
            $medialinktext .= "</a>$hstext\n</li>\n";
        }
        tng_free_result($presult);
        if ($medialinktext) {
            $medialinktext = "<ul>$medialinktext</ul>\n";
        }

        $showPhotoInfo = $row['allow_living'] = $row['alwayson'] || (!$foundprivate && !$foundliving);

        $href = getMediaHREF($row, 0);
        $notes = $wherestr && $row['altnotes'] ? $row['altnotes'] : $row['notes'];
        $notes = nl2br(truncateIt(getXrefNotes($row['notes'], $row['gedcom']), $tngconfig['maxnoteprev']));
        $description = $wherestr && $row['altdescription'] ? $row['altdescription'] : $row['description'];

        if ($row['allow_living']) {
            $description = $showPhotoInfo ? "<a href=\"$href\">$description</a>" : $description;
        } else {
            $nonamesloc = $row['private'] ? $tngconfig['nnpriv'] : $nonames;
            if ($nonamesloc) {
                $description = $text['livingphoto'];
                $notes = "";
            } else {
                $notes = $notes ? $notes . "<br>({$text['livingphoto']})" : "({$text['livingphoto']})";
            }
            $href = "";
        }

        $mediatext .= "<tr>";
        $row['mediatypeID'] = $mediatypeID;
        $imgsrc = getSmallPhoto($row);
        if ($imgsrc) {
            $treestr = $tngconfig['mediatrees'] && $row['gedcom'] ? $row['gedcom'] . "/" : "";
            $mediatext .= "<td class='databack center' style=\"width:$thumbmaxw" . "px\">";
            $mediatext .= "<div class=\"media-img\"><div class=\"media-prev\" id=\"prev{$row['mediaID']}\" style=\"display:none;\"></div></div>\n";
            if ($href && $row['allow_living']) {
                $mediatext .= "<a href=\"$href\"";
                if ($gotImageJpeg && isPhoto($row) && checkMediaFileSize("$rootpath$usefolder/$treestr" . $row['path'])) {
                    $mediatext .= " class=\"media-preview\" id=\"img-{$row['mediaID']}-0-" . urlencode("$usefolder/$treestr{$row['path']}") . "\"";
                }
                $mediatext .= ">$imgsrc</a>";
            } else {
                $mediatext .= $imgsrc;
            }
            $mediatext .= "</td>";
            $mediatext .= "<td class='databack'>";
            $thumbcount++;
        } else {
            $mediatext .= "<td class='databack text-center'>&nbsp;</td>";
            $mediatext .= "<td class='databack'>";
        }

        $mediatext .= "$description<br>$notes&nbsp;</td>";
        if ($mediatypeID == "headstones") {
            if (!$row['cemname']) {
                $row['cemname'] = $row['city'];
            }
            $mediatext .= "<td class='databack'><a href=\"showmap.php?cemeteryID={$row['cemeteryID']}\">{$row['cemname']}</a>";
            if ($row['plot']) {
                $mediatext .= "<br>";
            }
            $mediatext .= nl2br($row['plot']) . "&nbsp;</td>";
            $mediatext .= "<td class='databack'>{$row['status']}&nbsp;</td>";
            $mediatext .= "<td class='databack'>\n";
        } else {
            $mediatext .= "<td class='databack' width=\"175\">\n";
        }
        $mediatext .= $medialinktext;
        $mediatext .= "&nbsp;</td>\n";
        if ($whatsnew) {
            $changedby = $row['changedby'];
            $changedbydesc = isset($userlist[$changedby]) ? $userlist[$changedby] : $changedby;
            $mediatext .= "<td class='databack'>" . displayDate($row['changedatef']) . ($currentuser ? " ({$changedbydesc})" : "") . "</td>";
            $mediatext .= "</tr>\n";
        }
        //ereg if no thumbs
    }
    if (!$thumbcount) {
        $mediaheader = str_replace("<td class=\"fieldnameback\"><span class=\"fieldname\">&nbsp;<strong>{$text['thumb']}</strong>&nbsp;</span></td>", "", $mediaheader);
        $mediatext = str_replace("<td class='databack center'>&nbsp;</td><td class='databack'>", "<td class='databack'>", $mediatext);
    }
    tng_free_result($mediaresult);
    return $mediatext ? $mediaheader . $mediatext . $footer . "</div>\n<br>\n" : "";
}
