<?php
$textpart = "showphoto";
include "tng_begin.php";

include "functions.php";
require_once "admin/pagination.php";

require_once "./core/sql/extractWhereClause.php";

if (isset($mediatypeID)) {
    $mediatypeID = cleanIt(preg_replace("/[<>{};!=]/", '', $mediatypeID));
}

$flags['imgprev'] = true;

$orgmediatypeID = $mediatypeID;
initMediaTypes();

if (!in_array($mediatypeID, $mediatypes_like['photos']) && !in_array($mediatypeID, $mediatypes_like['headstones'])) {
    $tngconfig['ssdisabled'] = 1;
}

if ($orgmediatypeID) {
    $titlestr = $text[$mediatypeID] ? $text[$mediatypeID] : $mediatypes_display[$mediatypeID];
} else {
    $titlestr = _('All Media');
}

if ($mediasearch) {
    $mediasearch = trim($mediasearch);
    $_SESSION['tng_mediasearch'] = $mediasearch;
    $mediasearch2 = addslashes(cleanIt($mediasearch));
    $mediasearch = cleanIt(stripslashes($mediasearch));
} else {
    $_SESSION['tng_mediasearch'] = "";
}

if ($tnggallery) {
    $tnggallery = 1;
    $maxsearchresults *= 2;
    $gallerymsg = "<a href=\"browsemedia.php?tree=$tree&amp;mediatypeID=$orgmediatypeID&amp;mediasearch=$mediasearch\" class='snlink rounded'>&raquo; " . _('Descriptive View') . "</a>";
} else {
    $gallerymsg = "<a href=\"browsemedia.php?tnggallery=1&amp;tree=$tree&amp;mediatypeID=$orgmediatypeID&amp;mediasearch=$mediasearch\" class='snlink rounded'>&raquo; " . _('Thumbnails Only') . "</a>";
}

$_SESSION['tng_gallery'] = $tnggallery;
$_SESSION['tng_mediatree'] = $tree;

/**
 * @param $instance
 * @param $pagenav
 * @return string
 */
function doMediaSearch($instance, $pagenav) {
    global $mediasearch, $orgmediatypeID, $tree, $tnggallery;

    $str = getFORM("browsemedia", "get", "MediaSearch$instance", "");
    $str .= "<input type='text' name=\"mediasearch\" value=\"$mediasearch\"> <input type='submit' value=\"" . _('Search') . "\"> <input type='button' value=\"" . _('Reset') . "\" onclick=\"window.location.href='browsemedia.php?mediatypeID=$orgmediatypeID&amp;tree=$tree&amp;tnggallery=$tnggallery';\">&nbsp;&nbsp;&nbsp;";
    $str .= "<input type='hidden' name=\"mediatypeID\" value=\"$orgmediatypeID\">\n";
    $str .= $pagenav;
    $str .= "<input type='hidden' name=\"tree\" value='$tree'>\n";
    $str .= "<input type='hidden' name=\"tnggallery\" value=\"$tnggallery\">\n";
    $str .= "</form>\n";

    return $str;
}

$max_browsemedia_pages = 5;
if ($offset) {
    $offsetplus = $offset + 1;
    $newoffset = "$offset, ";
} else {
    $offsetplus = 1;
    $newoffset = "";
    $page = 1;
}

$query = "SELECT media.mediaID, media.description, media.notes, path, thumbpath, alwayson, usecollfolder, form, mediatypeID, status, plot, newwindow, abspath, media.gedcom";
$query .= $orgmediatypeID == "headstones" ? ", media.cemeteryID, cemname, city " : " ";
$query .= "FROM $media_table media ";
$query .= $orgmediatypeID == "headstones" ? "LEFT JOIN $cemeteries_table cemeteries ON media.cemeteryID = cemeteries.cemeteryID " : " ";
$query .= $orgmediatypeID ? "WHERE mediatypeID = '$mediatypeID' " : "WHERE 1 = 1 ";
if ($tnggallery) $query .= "AND thumbpath != '' ";

if ($tree) {
    $query .= "AND (media.gedcom = '$tree' || media.gedcom = '') ";
}
if ($mediasearch) {
    $query .= "AND (media.description LIKE '%$mediasearch2%' OR media.notes LIKE '%$mediasearch2%' OR bodytext LIKE '%$mediasearch2%' OR owner LIKE '%$mediasearch2%') ";
}
$query .= "ORDER BY description ";
$query .= "LIMIT $newoffset" . $maxsearchresults;
$result = tng_query($query);
$numrows = tng_num_rows($result);

if ($numrows == $maxsearchresults || $offsetplus > 1) {
    $query2 = "SELECT count(media.mediaID) AS mcount ";
    $query2 .= "FROM $media_table media ";
    if ($tree) {
        $query2 .= $orgmediatypeID == "headstones" ? "LEFT JOIN $cemeteries_table cemeteries ON media.cemeteryID = cemeteries.cemeteryID" : " ";
    }
    $query2 .= extractWhereClause($query);
    $result2 = tng_query($query2);
    $row = tng_fetch_assoc($result2);
    tng_free_result($result2);
    $totrows = $row['mcount'];
} else {
    $totrows = $numrows;
}

$numrowsplus = $numrows + $offset;

$treestr = $tree ? " " . _('Tree') . ": $tree" : "";
$treestr = trim("$mediasearch $treestr");
$treestr = $treestr ? " ($treestr)" : "";
$logstring = "<a href=\"browsemedia.php?tree=$tree&amp;offset=$offset&amp;mediasearch=$mediasearch&amp;mediatypeID=$mediatypeID\">$titlestr$treestr</a>";
writelog($logstring);
preparebookmark($logstring);

tng_header($titlestr, $flags);
if ($orgmediatypeID) {
    if ($mediatypes_icons[$mediatypeID]) {
        $icon = "<img src=\"{$mediatypes_icons[$mediatypeID]}\" width='20' height='20' alt=\"\" class='headericon'>";
    } else {
        $icon = "<span class='headericon' id=\"{$mediatypeID}-hdr-icon\"></span>";
    }
} else {
    $icon = "<span class='headericon' id=\"media-hdr-icon\"></span>";
}
?>
    <h2 class="header"><?php echo $icon . $titlestr; ?></h2>
    <br class="clear-both">
<?php
$hiddenfields[0] = ['name' => 'mediatypeID', 'value' => $orgmediatypeID];
$hiddenfields[1] = ['name' => 'tnggallery', 'value' => $tnggallery];
echo treeDropdown(['startform' => true, 'endform' => true, 'action' => 'browsemedia', 'method' => 'get', 'name' => 'form1', 'id' => 'form1', 'hidden' => $hiddenfields]);

$toplinks = "<p class='normal'>";
if ($totrows) {
    $toplinks .= _('Matches') . " " . number_format($offsetplus) . " " . _('to') . " " . number_format($numrowsplus) . " " . _('of') . " " . number_format($totrows) . " &nbsp;&nbsp;&nbsp; ";
}
$toplinks .= "$gallerymsg";

$pagenav = get_browseitems_nav($totrows, "browsemedia.php?mediasearch=$mediasearch&amp;tnggallery=$tnggallery&amp;mediatypeID=$orgmediatypeID&amp;offset", $maxsearchresults, $max_browsemedia_pages);
$preheader = doMediaSearch(1, $pagenav);
$preheader .= "<br>\n";

if ($tnggallery) {
    $preheader .= "<div class='titlebox rounded-lg'>\n";
    $firstrow = 1;
    $tablewidth = "";
    $header = "";
} else {
    $header = "<thead>\n";
    $header .= "<tr>\n";
    $header .= "<th class='fieldnameback fieldname nbrcol'>#</th>\n";
    $header .= "<th class='fieldnameback fieldname text-center' width=\"$thumbmaxw\">" . _('Thumb') . "</th>\n";
    $width = $mediatypeID == "headstones" ? "50%" : "75%";
    $header .= "<th class='fieldnameback fieldname'>" . _('Description') . "</th>\n";
    if ($mediatypeID == "headstones") {
        $header .= "<th class='fieldnameback fieldname'>" . _('Cemetery') . "</th>\n";
        $header .= "<th class='fieldnameback fieldname'>" . _('Status') . "</th>\n";
    }
    $header .= "<th class='fieldnameback fieldname'>" . _('Linked to') . "</th>\n";
    $header .= "</tr>\n";
    $header .= "</thead>\n";
    $tablewidth = " style='width: 100%;'";
}
$header = "<table %nameclass='whiteback no cellpadding='3' cellspacing='1' border='0'$tablewidth rmal'>\n" . $header;

$i = $offsetplus;
$maxplus = $maxsearchresults + 1;
$mediatext = "";
$firsthref = "";
$thumbcount = 0;
$gotImageJpeg = function_exists('imageJpeg');
while ($row = tng_fetch_assoc($result)) {
    $mediatypeID = $row['mediatypeID'];
    $usefolder = $row['usecollfolder'] ? $mediatypes_assoc[$mediatypeID] : $mediapath;

    $status = $row['status'];
    if ($status && $text[$status]) $row['status'] = $text[$status];


    $query = "SELECT medialinks.mediaID, medialinks.personID AS personID, people.personID AS personID2, people.living AS living, people.private AS private, people.branch AS branch, medialinks.eventID, families.branch AS fbranch, families.living AS fliving, families.private AS fprivate, familyID, husband, wife, people.lastname AS lastname, people.lnprefix AS lnprefix, people.firstname AS firstname, people.prefix AS prefix, people.suffix AS suffix, nameorder, medialinks.gedcom, sources.title, sources.sourceID, repositories.repoID, reponame, deathdate, burialdate, linktype ";
    $query .= "FROM $medialinks_table medialinks ";
    $query .= "LEFT JOIN $people_table people ON medialinks.personID = people.personID AND medialinks.gedcom = people.gedcom ";
    $query .= "LEFT JOIN $families_table families ON medialinks.personID = families.familyID AND medialinks.gedcom = families.gedcom ";
    $query .= "LEFT JOIN $sources_table sources ON medialinks.personID = sources.sourceID AND medialinks.gedcom = sources.gedcom ";
    $query .= "LEFT JOIN $repositories_table repositories ON (medialinks.personID = repositories.repoID AND medialinks.gedcom = repositories.gedcom) ";
    $query .= "WHERE mediaID = '{$row['mediaID']}' ";
    if ($tree) $query .= "AND medialinks.gedcom = '$tree' ";

    $query .= "ORDER BY lastname, lnprefix, firstname, personID ";
    $query .= "LIMIT $maxplus";
    $presult = tng_query($query);
    $numrows = tng_num_rows($presult);
    $medialinktext = "";
    $foundliving = 0;
    $foundprivate = 0;
    $count = 0;
    $citelinks = [];
    while ($prow = tng_fetch_assoc($presult)) {
        if ($prow['fbranch'] != NULL) $prow['branch'] = $prow['fbranch'];

        if ($prow['fliving'] != NULL) $prow['living'] = $prow['fliving'];

        if ($prow['fprivate'] != NULL) {
            $prow['private'] = $prow['fprivate'];
        }
        //if living still null, must be a source
        if ($prow['living'] == NULL && $prow['private'] == NULL && $prow['linktype'] == 'I') {
            $query = "SELECT COUNT(personID) AS ccount ";
            $query .= "FROM $citations_table citations, $people_table people ";
            $query .= "WHERE citations.sourceID = '{$prow['personID']}' AND citations.persfamID = people.personID AND citations.gedcom = people.gedcom AND (living = '1' OR private = '1')";
            $presult2 = tng_query($query);
            if ($presult2) {
                $prow2 = tng_fetch_assoc($presult2);
                if ($prow2['ccount']) $prow['living'] = 1;

                tng_free_result($presult2);
            }
        }
        if ($prow['living'] == NULL && $prow['private'] == NULL && $prow['linktype'] == 'F') {
            $query = "SELECT count(familyID) AS ccount ";
            $query .= "FROM $citations_table citations, $families_table families ";
            $query .= "WHERE citations.sourceID = '{$prow['personID']}' AND citations.persfamID = families.familyID AND citations.gedcom = families.gedcom AND living = '1'";
            $presult2 = tng_query($query);
            if ($presult2) {
                $prow2 = tng_fetch_assoc($presult2);
                if ($prow2['ccount']) $prow['living'] = 1;

                tng_free_result($presult2);
            }
        }
        $rights = determineLivingPrivateRights($prow);
        $prow['allow_living'] = $rights['living'];
        $prow['allow_private'] = $rights['private'];

        if (!$rights['living']) $foundliving = 1;

        if (!$rights['private']) $foundprivate = 1;


        if (!$tnggallery) {
            $hstext = "";
            if ($prow['personID2'] != NULL) {
                $medialinktext .= "<li><a href=\"getperson.php?personID={$prow['personID2']}&amp;tree={$prow['gedcom']}\">";
                $medialinktext .= getName($prow);
                if ($orgmediatypeID == "headstones") {
                    $deathdate = $prow['deathdate'] ? $prow['deathdate'] : $prow['burialdate'];
                    if ($prow['deathdate']) {
                        $abbrev = _('d.');
                    } elseif ($prow['burialdate']) {
                        $abbrev = _('bur.');
                    }
                    $hstext = $deathdate ? " ($abbrev " . displayDate($deathdate) . ")" : "";
                }
            } elseif ($prow['sourceID'] != NULL) {
                $sourcetext = $prow['title'] ? _('Source') . ": " . $prow['title'] : _('Source') . ": " . $prow['sourceID'];
                $medialinktext .= "<li><a href=\"showsource.php?sourceID={$prow['personID']}&amp;tree={$prow['gedcom']}\">$sourcetext\n";
            } elseif ($prow['repoID'] != NULL) {
                $repotext = $prow['reponame'] ? _('Repository') . ": " . $prow['reponame'] : _('Repository') . ": " . $prow['repoID'];
                $medialinktext .= "<li><a href=\"showrepo.php?repoID={$prow['personID']}&amp;tree={$prow['gedcom']}\">$repotext";
            } elseif ($prow['familyID'] != NULL) {
                $medialinktext .= "<li><a href=\"familygroup.php?familyID={$prow['personID']}&amp;tree={$prow['gedcom']}\">" . _('Family') . ": " . getFamilyName($prow);
            } elseif (!$prow['linktype'] || $prow['linktype'] == "C") {
                $query = "SELECT persfamID, sourceID, gedcom FROM $citations_table WHERE citationID = \"{$prow['personID']}\"";
                $cresult = tng_query($query);
                if ($cresult) {
                    $crow = tng_fetch_assoc($cresult);
                    if ($crow) {
                        $persfamID = $crow['persfamID'];
                        if (!in_array($persfamID, $citelinks)) {
                            $citelinks[] = $persfamID;
                            if (substr($persfamID, 0, 1) == $tngconfig['personprefix'] || substr($persfamID, -1) == $tngconfig['personsuffix']) {
                                $medialinktext .= "<li><a href=\"getperson.php?personID=$persfamID&amp;tree={$crow['gedcom']}\">";
                                $presult2 = getPersonSimple($prow['gedcom'], $persfamID);
                                if ($presult2) {
                                    $cprow = tng_fetch_assoc($presult2);
                                    $cprights = determineLivingPrivateRights($cprow);
                                    $cprow['allow_living'] = $cprights['living'];
                                    $cprow['allow_private'] = $cprights['private'];
                                    $medialinktext .= getName($cprow) . "</a>";
                                    tng_free_result($presult2);
                                }
                            } elseif (substr($persfamID, 0, 1) == $tngconfig['familyprefix'] || substr($persfamID, -1) == $tngconfig['familysuffix']) {
                                $presult2 = getFamilyData($prow['gedcom'], $persfamID);
                                if ($presult2) {
                                    $famrow = tng_fetch_assoc($presult2);
                                    $familyname = getFamilyName($famrow);
                                    $medialinktext .= "<li><a href=\"familygroup.php?familyID=$persfamID&amp;tree={$crow['gedcom']}\">" . _('Family') . ": $familyname</a>";
                                    tng_free_result($presult2);
                                }
                            }
                        }
                    }
                    tng_free_result($cresult);
                }
            } else {
                $treestr = $tngconfig['places1tree'] ? "" : "&amp;tree={$prow['gedcom']}";
                $medialinktext .= "<li><a href=\"placesearch.php?psearch={$prow['personID']}$treestr\">" . $prow['personID'];
            }
            if ($prow['eventID']) {
                $query = "SELECT display FROM $events_table, $eventtypes_table WHERE eventID = \"{$prow['eventID']}\" AND $events_table.eventtypeID = $eventtypes_table.eventtypeID";
                $eresult = tng_query($query);
                $erow = tng_fetch_assoc($eresult);
                $event = $erow['display'] && is_numeric($prow['eventID']) ? getEventDisplay($erow['display']) : ($admtext[$prow['eventID']] ? $admtext[$prow['eventID']] : $prow['eventID']);
                tng_free_result($eresult);
                $medialinktext .= " ($event)";
            }
            if ($medialinktext) $medialinktext .= "</a>$hstext\n</li>\n";

        }
        $count++;
    }

    $showPhotoInfo = $row['allow_living'] = $row['alwayson'] || (!$foundprivate && !$foundliving);

    //if extension is in "showdirect" then link = folder (depends on usecollfolder) + / + path
    //else showmedia
    tng_free_result($presult);
    if ($medialinktext) $medialinktext = "<ul>$medialinktext</ul>\n";


    $row['all'] = $orgmediatypeID ? 0 : 1;
    $uselink = getMediaHREF($row, 0);

    if ($numrows == $maxplus) {
        $medialinktext .= "\n['<a href=\"showmedia.php?mediaID={$row['mediaID']}&amp;ioffset=$maxsearchresults\">" . _('More Links') . "</a>']";
    }

    $imgsrc = getSmallPhoto($row);
    if ($showPhotoInfo) {
        $href = $uselink;
    } else {
        $href = "";
    }
    if ($href && strpos($href, "showmedia.php") !== false && !$firsthref) {
        $firsthref = $href;
    }
    $notes = nl2br(truncateIt(getXrefNotes($row['notes'], $row['gedcom']), $tngconfig['maxnoteprev']));
    if ($row['allow_living']) {
        $description = $showPhotoInfo ? "<a href='$href'>{$row['description']}</a>" : $row['description'];
    } else {
        $nonamesloc = $row['private'] ? $tngconfig['nnpriv'] : $nonames;
        if ($nonamesloc) {
            $description = _('At least one living or private individual is linked to this item - Details withheld.');
            $notes = "";
        } else {
            $description = $row['description'];
            $notes = $notes ? $notes . "<br>(" . _('At least one living or private individual is linked to this item - Details withheld.') . ")" : "(" . _('At least one living or private individual is linked to this item - Details withheld.') . ")";
        }
    }

    if ($row['status'] && ($orgmediatypeID != "headstones")) {
        $notes = _('Status') . ": " . $row['status'] . "; " . $notes;
    }

    if ($tnggallery) {
        if ($imgsrc) {
            $mediatext .= "<div class='databack gallery text-center'>";
            $mediatext .= $href ? "<a href='$href'>$imgsrc</a>\n" : "$imgsrc\n";
            $mediatext .= "</div>";
            $i++;
        }
    } else {
        $mediatext .= "<tr>\n";
        $mediatext .= "<td class='databack'>$i</td>\n";
        if ($imgsrc) {
            $mediatext .= "<td class='databack text-center'>\n";
            $mediatext .= "<div class='media-img' id=\"mi{$row['mediaID']}\">\n";
            $mediatext .= "<div class='media-prev' id=\"prev{$row['mediaID']}\" style='display: none;'>\n";
            $mediatext .= "</div>\n";
            $mediatext .= "</div>\n";
            if ($href && $row['allow_living']) {
                $mediatext .= "<a href='$href'";
                $treestr2 = $tngconfig['mediatrees'] && $row['gedcom'] ? $row['gedcom'] . "/" : "";
                if ($gotImageJpeg && isPhoto($row) && checkMediaFileSize("$rootpath$usefolder/$treestr2{$row['path']}")) {
                    $mediatext .= " class='media-preview' id=\"img-{$row['mediaID']}-0-" . urlencode("$usefolder/$treestr2{$row['path']}") . "\"";
                }
                $mediatext .= ">$imgsrc</a>";
            } else {
                $mediatext .= $imgsrc;
            }
            $mediatext .= "</td><td class='databack'>";
            $thumbcount++;
        } else {
            $mediatext .= "<td class='databack text-center'></td>";
            $mediatext .= "<td class='databack'>";
        }

        $mediatext .= "$description<br>$notes&nbsp;</td>";
        if ($orgmediatypeID == "headstones") {
            if (!$row['cemname']) $row['cemname'] = $row['city'];
            $plotstr = $row['plot'] ? "<br>" . nl2br($row['plot']) : "";
            $mediatext .= "<td class='databack' width='30%'><a href=\"showmap.php?cemeteryID={$row['cemeteryID']}\">{$row['cemname']}</a>$plotstr&nbsp;</td>";
            $mediatext .= "<td class='databack whitespace-no-wrap'>{$row['status']}&nbsp;</td>";
            $mediatext .= "<td class='databack' width='30%'>\n";
        } else {
            $mediatext .= "<td class='databack' width=\"175\">\n";
        }
        $mediatext .= $medialinktext;
        $mediatext .= "&nbsp;</td></tr>\n";
        $i++;
    }
}
tng_free_result($result);
if (!$tnggallery) {
    if (!$thumbcount) {
        $header = str_replace("<td class='fieldnameback fieldname'><strong>" . _('Thumb') . "</strong></td>", "", $header); // todo multiple tag search string has been mangled
        $mediatext = str_replace("<td class='databack text-center'></td><td class='databack'>", "<td class='databack'>", $mediatext);
    }
}

if (!$tngconfig['ssdisabled'] && $firsthref && $totrows > 1) {
    $ss = strpos($firsthref, "?") ? "&amp;ss=1" : "?ss=1";
    $toplinks .= " &nbsp;&nbsp; <a href=\"$firsthref$ss\" class='snlink rounded'>&raquo; " . _('Slide Show') . "</a>";
}
$toplinks .= "</p>";
//print out the whole shootin' match right here, eh
echo $toplinks . $preheader . $header . $mediatext;
echo "</table>\n";

if ($tnggallery) echo "</div>\n";


echo "<br>\n";

if ($totrows && ($pagenav || $mediasearch)) {
    echo doMediaSearch(2, $pagenav);
    echo "<br>";
}
tng_footer($flags);
?>