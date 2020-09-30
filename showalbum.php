<?php
$textpart = "showphoto";
include "tng_begin.php";

include "functions.php";

require_once "albumlib.php";

$albumID = preg_replace("/[^0-9]/", '', $albumID);

$flags['imgprev'] = true;

$noneliving = $noneprivate = 1;
function getAlbumLinkText($albumID) {
    global $noneliving, $noneprivate, $text, $album2entities_table, $people_table, $families_table, $sources_table, $repositories_table, $events_table, $eventtypes_table, $wherestr2, $maxsearchresults;
    global $tngconfig;

    $links = "";

    if ($ioffset) {
        $ioffsetstr = "$ioffset, ";
        $newioffset = $ioffset + 1;
    } else {
        $ioffsetstr = "";
        $newioffset = "";
    }
    $query = "SELECT album2entities.alinkID, album2entities.entityID AS personID, people.living AS living, people.private AS private, people.branch AS branch, album2entities.eventID, families.branch AS fbranch, families.living AS fliving, families.private AS fprivate, people.lastname AS lastname, people.lnprefix AS lnprefix, people.firstname AS firstname, people.prefix AS prefix, people.suffix AS suffix, people.nameorder, album2entities.gedcom, familyID, people.personID AS personID2, wifepeople.personID AS wpersonID, wifepeople.firstname AS wfirstname, wifepeople.lnprefix AS wlnprefix, wifepeople.lastname AS wlastname, wifepeople.prefix AS wprefix, wifepeople.suffix AS wsuffix, husbpeople.personID AS hpersonID, husbpeople.firstname AS hfirstname, husbpeople.lnprefix AS hlnprefix, husbpeople.lastname AS hlastname, husbpeople.prefix AS hprefix, husbpeople.suffix AS hsuffix, sources.title, sources.sourceID, repositories.repoID, reponame ";
    $query .= "FROM $album2entities_table album2entities ";
    $query .= "LEFT JOIN $people_table people ON album2entities.entityID = people.personID AND album2entities.gedcom = people.gedcom ";
    $query .= "LEFT JOIN $families_table families ON album2entities.entityID = families.familyID AND album2entities.gedcom = families.gedcom ";
    $query .= "LEFT JOIN $people_table husbpeople ON families.husband = husbpeople.personID AND families.gedcom = husbpeople.gedcom ";
    $query .= "LEFT JOIN $people_table wifepeople ON families.wife = wifepeople.personID AND families.gedcom = wifepeople.gedcom ";
    $query .= "LEFT JOIN $sources_table sources ON album2entities.entityID = sources.sourceID AND album2entities.gedcom = sources.gedcom ";
    $query .= "LEFT JOIN $repositories_table repositories ON (album2entities.entityID = repositories.repoID AND album2entities.gedcom = repositories.gedcom) ";
    $query .= "WHERE albumID = \"$albumID\"$wherestr2 ";
    $query .= "ORDER BY people.lastname, people.lnprefix, people.firstname, hlastname, hlnprefix, hfirstname ";
    $query .= "LIMIT $ioffsetstr" . ($maxsearchresults + 1);
    $presult = tng_query($query);
    $numrows = tng_num_rows($presult);
    $medialinktext = "";
    $count = 0;
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
        if ($links) {
            $links .= ", ";
        }

        $prights = determineLivingPrivateRights($prow);
        $prow['allow_living'] = $prights['living'];
        $prow['allow_private'] = $prights['private'];

        if (!$prights['both']) {
            if ($prow['private']) {
                $noneprivate = 0;
            }
            if ($prow['living']) {
                $noneliving = 0;
            }
        }

        if ($prow['personID2'] != NULL) {
            $links .= "<a href=\"getperson.php?personID={$prow['personID2']}&amp;tree={$prow['gedcom']}\">";
            $links .= getName($prow) . "</a>";
        } elseif ($prow['sourceID'] != NULL) {
            $sourcetext = $prow['title'] ? $prow['title'] : "{$text['source']}: {$prow['sourceID']}";
            $links .= "<a href=\"showsource.php?sourceID={$prow['sourceID']}&amp;tree={$prow['gedcom']}\">" . $sourcetext . "</a>";
        } elseif ($prow['repoID'] != NULL) {
            $repotext = $prow['reponame'] ? $prow['reponame'] : "{$text['repository']}: {$prow['repoID']}";
            $links .= "<a href=\"showrepo.php?repoID={$prow['repoID']}&amp;tree={$prow['gedcom']}\">" . $repotext . "</a>";
        } elseif ($prow['familyID'] != NULL) {
            $familyname = trim("{$prow['hlnprefix']} {$prow['hlastname']}") . "/" . trim("{$prow['wlnprefix']} {$prow['wlastname']}") . " ({$prow['familyID']})";
            $links .= "<a href=\"familygroup.php?familyID={$prow['familyID']}&amp;tree={$prow['gedcom']}\">{$text['family']}: $familyname</a>";
        } else {
            $treestr = $tngconfig['places1tree'] ? "" : "&amp;tree={$prow['gedcom']}";
            $links .= "<a href=\"placesearch.php?psearch={$prow['personID']}$treestr\">" . $prow['personID'] . "</a>";
        }
        if ($prow['eventID']) {
            $query = "SELECT description FROM $events_table, $eventtypes_table WHERE eventID = \"{$prow['eventID']}\" AND $events_table.eventtypeID = $eventtypes_table.eventtypeID";
            $eresult = tng_query($query);
            $erow = tng_fetch_assoc($eresult);
            $event = $erow['description'] ? $erow['description'] : $prow['eventID'];
            tng_free_result($eresult);
            $links .= " ($event)";
        }
        $count++;
    }
    tng_free_result($presult);
    if ($numrows > $maxsearchresults) {
        $links .= "\n[<a href=\"showalbum.php?albumID=$albumID&amp;ioffset=" . ($newioffset + $maxsearchresults) . "\">{$text['morelinks']}</a>]";
    }

    return $links;
}

$albumlinktext = getAlbumLinkText($albumID);
if ($albumlinktext) {
    $altext = $albumlinktext;
    $albumlinktext = "<table cellpadding=\"4\" cellspacing='1' border='0' class=\"whiteback w-100\">\n";
    $albumlinktext .= "<tr>\n";
    $albumlinktext .= "<td class=\"fieldnameback fieldname align-top\" width=\"100\">{$text['indlinked']}</td>\n";
    $albumlinktext .= "<td class='databack' width=\"90%\">$altext</td>\n";
    $albumlinktext .= "</tr>\n";
    $albumlinktext .= "</table>\n<br>";
}

if (!$thumbmaxw) {
    $thumbmaxw = 80;
}

if ($tnggallery) {
    $maxsearchresults *= 2;
    $wherestr .= " AND thumbpath != \"\"";
    $gallerymsg = "<a href=\"showalbum.php?albumID=$albumID\" class=\"snlink\">&raquo; {$text['regphotos']}</a>&nbsp;";
} else {
    $gallerymsg = "<a href=\"showalbum.php?albumID=$albumID&amp;tnggallery=1\" class=\"snlink\">&raquo; {$text['gallery']}</a>&nbsp;";
}

$_SESSION['tng_gallery'] = $tnggallery;

$max_browsemedia_pages = 5;
if ($offset) {
    $offsetplus = $offset + 1;
    $newoffset = "$offset, ";
} else {
    $offsetplus = 1;
    $newoffset = 0;
    $page = 1;
}

$query = "SELECT albumname, description, active FROM $albums_table WHERE albumID = \"$albumID\"";
$result = tng_query($query);
$row = tng_fetch_assoc($result);
if (!tng_num_rows($result) || (!$row['active'] && !$allow_admin)) {
    tng_free_result($result);
    header("Location: thispagedoesnotexist.html");
    exit;
}
$albumname = $row['albumname'];
$description = $row['description'];
tng_free_result($result);

if (!$noneliving && !$noneprivate) {
    echo "<!doctype html>\n";
    echo "<html lang='en'>\n";

    tng_header($text['albums'] . ": " . $albumname, $flags);
    echo tng_DrawHeading("", $text['albums'] . ": " . $albumname, $description);

    echo "<p>{$text['livingphoto']}</p>\n";

    tng_footer("");
    exit;
}

if ($tree) {
    $wherestr = " AND (media.gedcom = '$tree' || media.gedcom = '')";
    $wherestr2 = " AND medialinks.gedcom = '$tree'";
} else {
    $wherestr = $wherestr2 = "";
}

$query = "SELECT DISTINCT media.mediaID, albumlinkID, media.description, media.notes, thumbpath, alwayson, usecollfolder, mediatypeID, path, form, abspath, newwindow, media.gedcom ";
$query .= "FROM ($albumlinks_table albumlinks, $media_table media) ";
$query .= "LEFT JOIN $medialinks_table medialinks ON media.mediaID = medialinks.mediaID ";
$query .= "WHERE albumID = \"$albumID\" AND albumlinks.mediaID = media.mediaID $wherestr ";
$query .= "ORDER BY albumlinks.ordernum, description ";
$query .= "LIMIT $newoffset" . $maxsearchresults;
$result = tng_query($query);
$numrows = tng_num_rows($result);

if ($numrows == $maxsearchresults || $offsetplus > 1) {
    $query = "SELECT count(distinct media.mediaID) AS mcount ";
    $query .= "FROM ($albumlinks_table albumlinks, $media_table media) ";
    $query .= "LEFT JOIN $medialinks_table medialinks ON media.mediaID = medialinks.mediaID ";
    $query .= "WHERE albumID = \"$albumID\" AND albumlinks.mediaID = media.mediaID $wherestr";
    $result2 = tng_query($query);
    $row = tng_fetch_assoc($result2);
    tng_free_result($result2);
    $totrows = $row['mcount'];
} else {
    $totrows = $numrows;
}

$numrowsplus = $numrows + $offset;

$logstring = "<a href=\"showalbum.php?albumID=$albumID\">$albumname</a>";
writelog($logstring);
preparebookmark($logstring);

echo "<!doctype html>\n";
echo "<html lang='en'>\n";

tng_header($text['albums'] . ": $albumname", $flags);

$imgsrc = getAlbumPhoto($albumID, $albumname);
if (!$imgsrc) {
    ?>
    <h2 class="header"><span class="headericon" id="albums-hdr-icon"></span><?php echo $albumname; ?><br><span
            class="normal"><?php echo $description; ?></span></h2>
    <br style="clear: left;">
    <?php
} else {
    echo tng_DrawHeading($imgsrc, $albumname, $description);
}

$hiddenfields[0] = ['name' => 'albumID', 'value' => $albumID];
echo treeDropdown(['startform' => true, 'endform' => true, 'action' => 'showalbum', 'method' => 'get', 'name' => 'form1', 'id' => 'form1', 'hidden' => $hiddenfields]);

$toplinks = "<p class='normal'>";
$toplinks .= $totrows ? "{$text['matches']} $offsetplus {$text['to']} $numrowsplus {$text['of']} $totrows &nbsp;&nbsp; " : "";
$toplinks .= $gallerymsg;
$toplinks .= $allow_admin && $allow_edit ? "<a href=\"admin_editalbum.php?albumID=$albumID&amp;cw=1\" target='_blank' class=\"snlink\">&raquo; {$text['editalbum']}</a> " : "";

$pagenav = get_browseitems_nav($totrows, "showalbum.php?albumID=$albumID&amp;tnggallery=$tnggallery&amp;offset", $maxsearchresults, $max_browsemedia_pages);
$preheader = $pagenav . "</p>\n";

if ($tnggallery) {
    $preheader .= "<div class=\"titlebox\">\n";
    $firstrow = 1;
    $tablewidth = "";
    $header = "";
} else {
    $header = "<tr><td class='fieldnameback'>&nbsp;</td>\n";
    $header .= "<td class='fieldnameback' width=\"$thumbmaxw\"><span class=\"fieldname\">&nbsp;<strong>{$text['thumb']}</strong>&nbsp;</span></td>\n";
    $header .= "<td class='fieldnameback' width=\"70%\"><span class=\"fieldname\">&nbsp;<strong>{$text['description']}</strong>&nbsp;</span></td>\n";
    $header .= "<td class='fieldnameback'><span class=\"fieldname\">&nbsp;<strong>{$text['indlinked']}</strong>&nbsp;</span></td>\n";
    $header .= "</tr>\n";
    $tablewidth = " width=\"100%\"";
}

$header = "<table cellpadding=\"3\" cellspacing='1' border='0' $tablewidth class=\"whiteback normal\">\n" . $header;

$i = $offsetplus;
$maxplus = $maxsearchresults + 1;
$mediatext = "";
$firsthref = "";
$thumbcount = 0;
$gotImageJpeg = function_exists('imageJpeg');
while ($row = tng_fetch_assoc($result)) {
    $mediatypeID = $row['mediatypeID'];
    $usefolder = $row['usecollfolder'] ? $mediatypes_assoc[$mediatypeID] : $mediapath;
    $query = "SELECT medialinks.mediaID, medialinks.personID AS personID, people.personID AS personID2, people.living AS living, people.private, people.branch AS branch, families.branch AS fbranch, families.living AS fliving, familyID, husband, wife, people.lastname AS lastname, people.lnprefix AS lnprefix, people.firstname AS firstname, people.prefix AS prefix, people.suffix AS suffix, nameorder, medialinks.gedcom, sources.title, sources.sourceID, repositories.repoID, reponame, deathdate, burialdate, linktype ";
    $query .= "FROM $medialinks_table medialinks ";
    $query .= "LEFT JOIN $people_table people ON medialinks.personID = people.personID AND medialinks.gedcom = people.gedcom ";
    $query .= "LEFT JOIN $families_table families ON medialinks.personID = families.familyID AND medialinks.gedcom = families.gedcom ";
    $query .= "LEFT JOIN $sources_table sources ON medialinks.personID = sources.sourceID AND medialinks.gedcom = sources.gedcom ";
    $query .= "LEFT JOIN $repositories_table repositories ON (medialinks.personID = repositories.repoID AND medialinks.gedcom = repositories.gedcom) ";
    $query .= "WHERE mediaID = \"{$row['mediaID']}\" $wherestr2 ";
    $query .= "ORDER BY lastname, lnprefix, firstname, personID ";
    $query .= "LIMIT $maxplus";
    $presult = tng_query($query);
    $numrows = tng_num_rows($presult);
    $medialinktext = "";
    $foundliving = 0;
    $foundprivate = 0;
    $count = 0;
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
        //if living still null, must be a source
        if ($prow['living'] == NULL && $prow['private'] == NULL && $prow['linktype'] == "I") {
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
        if ($prow['living'] == NULL && $prow['private'] == NULL && $prow['linktype'] == "F") {
            $query = "SELECT count(familyID) AS ccount FROM $citations_table, $families_table
				WHERE $citations_table.sourceID = '{$prow['personID']}' AND $citations_table.persfamID = $families_table.familyID AND $citations_table.gedcom = $families_table.gedcom
				AND living = '1'";
            $presult2 = tng_query($query);
            $prow2 = tng_fetch_assoc($presult2);
            if ($prow2['ccount']) {
                $prow['living'] = 1;
            }
            tng_free_result($presult2);
        }

        $prights = determineLivingPrivateRights($prow);
        $prow['allow_living'] = $prights['living'];
        $prow['allow_private'] = $prights['private'];

        if (!$prights['living']) {
            $foundliving = 1;
        }
        if (!$prights['private']) {
            $foundprivate = 1;
        }

        if (!$tnggallery) {
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
            } elseif ($prow['sourceID'] != NULL) {
                $sourcetext = $prow['title'] ? $prow['title'] : $text['source'] . ": " . $prow['sourceID'];
                $medialinktext .= "<li><a href=\"showsource.php?sourceID={$prow['sourceID']}&amp;tree={$prow['gedcom']}\">$sourcetext";
            } elseif ($prow['repoID'] != NULL) {
                $repotext = $prow['reponame'] ? $prow['reponame'] : $text['repository'] . ": " . $prow['repoID'];
                $medialinktext .= "<li><a href=\"showrepo.php?repoID={$prow['repoID']}&amp;tree={$prow['gedcom']}\">$repotext";
            } elseif ($prow['familyID'] != NULL) {
                $medialinktext .= "<li><a href=\"familygroup.php?familyID={$prow['personID']}&amp;tree={$prow['gedcom']}\">{$text['family']}: " . getFamilyName($prow);
            } else {
                $treestr = $tngconfig['places1tree'] ? "" : "&amp;tree={$prow['gedcom']}";
                $medialinktext .= "<li><a href=\"placesearch.php?psearch={$prow['personID']}$treestr\">" . $prow['personID'];
            }
            $medialinktext .= "</a>$hstext\n</li>\n";
        }
        $count++;
    }
    tng_free_result($presult);
    if ($medialinktext) {
        $medialinktext = "<ul>$medialinktext</ul>\n";
    }

    if ($numrows == $maxplus) {
        $medialinktext .= "\n['<a href=\"showmedia.php?mediaID={$row['mediaID']}&amp;albumID=$albumID&amp;ioffset=$maxsearchresults\">{$text['morelinks']}</a>']";
    }

    $uselink = getMediaHREF($row, 2);
    if (!$noneliving && $row['alwayson']) {
        $noneliving = 1;
    }

    $showAlbumInfo = $row['allow_living'] = $row['alwayson'] || (!$foundprivate && !$foundliving);
    $nonamesloc = $foundprivate ? $tngconfig['nnpriv'] : $nonames;

    $imgsrc = getSmallPhoto($row);
    if ($showAlbumInfo) {
        $href = $uselink;
    } else {
        $href = "";
    }
    if ($href && !$firsthref) {
        $firsthref = $href;
    }

    if ($row['allow_living'] || !$nonamesloc) {
        $description = $showAlbumInfo ? "<a href=\"$href\">{$row['description']}</a>" : $row['description'];
        $notes = nl2br(truncateIt(getXrefNotes($row['notes']), $tngconfig['maxnoteprev']));
        if (!$showAlbumInfo) {
            $notes .= "<br>({$text['livingphoto']})";
        }
    } else {
        $description = $text['living'];
        $notes = $text['livingphoto'];
    }
    if ($row['status']) {
        $notes = $text['status'] . ": " . $row['status'] . $notes;
    }

    if (!$row['allow_living']) {
        $row['description'] = $text['livingphoto'];
    }

    if ($tnggallery) {
        if ($imgsrc) {
            $mediatext .= "<div class='databack gallery text-center'>";
            $mediatext .= $href ? "<a href=\"$href\">$imgsrc</a>\n" : "$imgsrc\n";
            $mediatext .= "</div>";
            $i++;
        }
    } else {
        $mediatext .= "<tr><td class='databack'><span class='normal'>$i</span></td>";
        if ($imgsrc) {
            $mediatext .= "<td class='databack text-center'>";
            $mediatext .= "<div class=\"media-img\"><div class=\"media-prev\" id=\"prev{$row['mediaID']}\" style='display: none;'></div></div>\n";
            if ($href) {
                $mediatext .= "<a href=\"$href\"";
                $treestr = $tngconfig['mediatrees'] && $row['gedcom'] ? $row['gedcom'] . "/" : "";
                if ($gotImageJpeg && isPhoto($row) && checkMediaFileSize("$rootpath$usefolder/$treestr{$row['path']}")) {
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

        $mediatext .= "<span class='normal'>$description<br>$notes&nbsp;</span></td>";
        $mediatext .= "<td class='databack'>\n";
        $mediatext .= $medialinktext;
        $mediatext .= "&nbsp;</td></tr>\n";
        $i++;
    }
}
tng_free_result($result);
if ($tnggallery) {
    if (!$firstrow) {
        $mediatext .= "</tr>\n";
    }
} else {
    if (!$thumbcount) {
        $header = str_replace("<td class='fieldnameback'><span class=\"fieldname\">&nbsp;<strong>{$text['thumb']}</strong>&nbsp;</span></td>", "", $header);
        $mediatext = str_replace("<td class='databack text-center'>&nbsp;</td><td class='databack'>", "<td class='databack'>", $mediatext);
    }
}

if ($firsthref && !isMobile()) {
    $toplinks .= " &nbsp;&nbsp; <a href=\"$firsthref&amp;ss=1\" class=\"snlink\">&raquo; {$text['slidestart']}</a>";
}
$toplinks .= "</p>";
//print out the whole shootin' match right here, eh
echo $toplinks . $preheader . $header . $mediatext;
echo "</table>\n";

if ($tnggallery) {
    echo "</div>\n";
}

echo "<br>\n";
if ($pagenav) {
    echo $pagenav;
    echo "<br>";
}
echo "<br>";
echo $albumlinktext;

tng_footer($flags);
?>