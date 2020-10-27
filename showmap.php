<?php

$textpart = "headstones";
$needMap = true;
include "tng_begin.php";
include "config/mapconfig.php";

if (!$cemeteryID || !is_numeric($cemeteryID)) {
    header("Location: thispagedoesnotexist.html");
    exit;
}
include "functions.php";
require_once "admin/trees.php";
require_once "admin/cemeteries.php";
$flags['imgprev'] = true;
$numtrees = getTreesCount($trees_table);
if (!$thumbmaxw) $thumbmaxw = 80;
if (!empty($offset)) {
    $offsetplus = $offset + 1;
    $newoffset = "$offset, ";
} else {
    $offsetplus = 1;
    $newoffset = "";
    $page = 1;
}
if ($cemeteryID) {
    $cemetery = fetchCemetery($cemeteries_table, $cemeteryID);
    $location = cemeteryLocation($cemetery);
} else {
    $location = $text['nocemetery'];
}
$logstring = "<a href='showmap.php?cemeteryID=$cemeteryID&amp;tree=$tree'>$location</a>";
writelog($logstring);
preparebookmark($logstring);
$mcharsetstr = "&amp;oe=$session_charset";
if (!empty($cemetery['maplink'])) {
    $size = GetImageSize("$rootpath$headstonepath/{$cemetery['maplink']}");
} else {
    $size = false;
}
echo "<!doctype html>\n";
echo "<html lang='en'>\n";
if ($map['key'] && $isConnected) {
    if (!isset($flags['scripting'])) $flags['scripting'] = "";
    $flags['scripting'] .= "<script src=\"{$http}://maps.googleapis.com/maps/api/js?language={$text['glang']}$mapkeystr\"></script>\n";
}
tng_header($location, $flags);
?>
<br class="clear-both">
<h2 class="header"><span class="headericon" id="headstones-hdr-icon"></span>&nbsp;<?php echo $location; ?></h2><br>
<?php
$hiddenfields[] = ['name' => 'cemeteryID', 'value' => $cemeteryID];
echo treeDropdown(['startform' => true, 'endform' => true, 'action' => 'showmap', 'method' => 'get', 'name' => 'form1', 'id' => 'form1', 'hidden' => $hiddenfields]);
$infoblock = "";
$body = "";
if ($cemeteryID) {
    if ($cemetery['maplink']) {
        $infoblock .= "<img src=\"$headstonepath/{$cemetery['maplink']}\" $size[3] alt=\"{$cemetery['cemname']}\"><br><br>\n";
    }
    if ($allow_admin && $allow_edit) {
        $infoblock .= "<p><a href=\"admin_editcemetery.php?cemeteryID=$cemeteryID&amp;cw=1\" target='_blank' class='rounded snlink'>{$text['editcem']}</a></p>\n";
    }
    if ($cemetery['notes']) {
        $infoblock .= "<p><strong>{$text['notes']}:</strong><br>\n" . nl2br(insertLinks($cemetery['notes'])) . "</p>";
    }
    if (!$map['key'] && ($cemetery['latitude'] || $cemetery['longitude'])) {
        $infoblock .= "<p><strong>{$text['latitude']}:</strong> {$cemetery['latitude']}, <strong>{$text['longitude']}:</strong> {$cemetery['longitude']}</p>";
    }
    $cemcoords = false;
    if ($map['key']) {
        $lat = $cemetery['latitude'];
        $long = $cemetery['longitude'];
        $zoom = $cemetery['zoom'] ? $cemetery['zoom'] : 10;
        if (!$zoom) $zoom = 10;
        $pinplacelevel = $pinplacelevel2;
        if ($lat && $long) {
            $cemeteryplace = cemeteryPlace($cemetery);
            $localballooncemeteryname = @htmlspecialchars($cemetery['cemname'], ENT_QUOTES, $session_charset);
            $localballooncemeteryplace = @htmlspecialchars($cemeteryplace, ENT_QUOTES, $session_charset);
            $remoteballoontext = @htmlspecialchars(str_replace($banish, $banreplace, "{$cemetery['cemname']}, $cemeteryplace"), ENT_QUOTES, $session_charset);
            $codednotes = $cemetery['notes'] ? "<br><br>" . tng_real_escape_string($text['notes'] . ": " . $cemetery['notes']) : "";
            $codednotes .= "<br><br><a href=\"{$http}://maps.google.com/maps?f=q{$text['glang']}$mcharsetstr&amp;daddr=$lat,$long($remoteballoontext)\" target=\"_blank\">{$text['getdirections']}</a>{$text['directionsto']} $localballooncemeteryname";
            $cempin = ["zoom" => $zoom, "lat" => $lat, "long" => $long, "pinplacelevel" => $pinplacelevel, "htmlcontent" => "<div class=\"mapballoon normal\">$localballooncemeteryname<br>$localballooncemeteryplace$codednotes</div>"];
            $cemcoords = true;
            $body .= "<div class='w-full mb-4 md:mx-auto md:max-w-3xl md:rounded-lg titlebox'>";
            $body .= "<strong>{$text['latitude']}:</strong> $lat<br>";
            $body .= "<strong>{$text['longitude']}:</strong> $long<br>";
            $body .= "<a href=\"{$http}://maps.google.com/maps?f=q{$text['glang']}$mcharsetstr&amp;daddr=$lat,$long($remoteballoontext)\" target=\"_blank\">{$text['getdirections']}</a>{$text['directionsto']} $localballooncemeteryname";
            $body .= "</div>";
        }
    }
}
if ($infoblock) {
    $body .= "<div class='w-full mb-4 md:mx-auto md:max-w-3xl md:rounded-lg titlebox'>$infoblock</div>\n";
}
$query = "SELECT mediaID, thumbpath, description, notes, usecollfolder, mediatypeID, path, form, abspath, newwindow ";
$query .= "FROM $media_table ";
$query .= "WHERE cemeteryID = '$cemeteryID' AND (mediatypeID != 'headstones' OR linktocem = '1') ";
$query .= "ORDER BY description";
$hsresult = tng_query($query);
$headstones = tng_fetch_all($hsresult);
tng_free_result($hsresult);
$gotImageJpeg = function_exists('imageJpeg');
if (!empty($headstones)) {
    $i = 1;
    $body .= "<div class='w-full md:mx-auto md:max-w-3xl md:rounded-lg titlebox'>\n";
    $body .= "<h3 class='subhead'>{$text['cemphotos']}</h3>\n";
    $body .= "<table cellpadding='3' cellspacing='1' border='0' class='w-full whiteback'>\n";
    $body .= "<tr>";
    $body .= "<th class='w-4 fieldnameback hidden md:table-cell'></th>\n";
    $body .= "<th class='fieldnameback fieldname' width='$thumbmaxw'>{$text['thumb']}</th>\n";
    $body .= "<th class='fieldnameback fieldname'>{$text['description']}</th>\n";
    $body .= "</tr>\n";
    foreach ($headstones as $hs) {
        $mediatypeID = $hs['mediatypeID'];
        $usefolder = $hs['usecollfolder'] ? $mediatypes_assoc[$mediatypeID] : $mediapath;
        $description = $hs['description'];
        $notes = nl2br($hs['notes']);
        $hs['allow_living'] = $hs['allow_private'] = 1;
        $imgsrc = getSmallPhoto($hs);
        $href = getMediaHREF($hs, 3);
        $body .= "<tr>";
        $body .= "<td class='databack hidden md:table-cell'><span class='normal'>$i</span></td>";
        $body .= "<td class='databack' width=\"$thumbmaxw\">";
        if ($imgsrc) {
            $body .= "<div class='media-img'><div class='media-prev' id=\"prev{$hs['mediaID']}\" style='display: none;'></div></div>\n";
            $body .= "<a href='$href'";
            if ($gotImageJpeg && checkMediaFileSize("$rootpath$usefolder/{$hs['path']}")) {
                $body .= " class='media-preview' id=\"img-{$hs['mediaID']}-0-" . urlencode("$usefolder/{$hs['path']}") . "\"";
            }
            $body .= ">$imgsrc</a>\n";
        } else {
            $body .= "&nbsp;";
        }
        $body .= "</td>\n";
        $body .= "<td class='databack'><span class='normal'>";
        $body .= "<a href='$href'>$description</a><br>$notes&nbsp;</span></td>";
        $body .= "</tr>\n";
        $i++;
    }
    $body .= "</table>\n";
    $body .= "</div>\n<br/>\n";
}
$query = "SELECT DISTINCT media.mediaID, description, notes, path, thumbpath, status, plot, showmap, usecollfolder, mediatypeID, latitude, longitude, form, abspath, newwindow ";
$query .= "FROM $media_table media ";
$query .= "LEFT JOIN $medialinks_table medialinks ON media.mediaID = medialinks.mediaID ";
$query .= "WHERE cemeteryID = '$cemeteryID' ";
if ($tree) $query .= " AND (media.gedcom = '$tree' || media.gedcom = '') ";
$query .= "AND mediatypeID = 'headstones' AND linktocem != '1' ";
$query .= "ORDER BY description ";
$query .= "LIMIT $newoffset" . $maxsearchresults;
$hsresult = tng_query($query);
$numrows = tng_num_rows($hsresult);
if ($numrows) {
    $body .= "<div class='rounded-lg titlebox'>\n";
    $body .= "<h3 class='subhead'>{$text['headstone']}</h3>\n";
    if ($numrows == $maxsearchresults || $offsetplus > 1) {
        $query = "SELECT count(DISTINCT $media_table.mediaID) AS hscount ";
        $query .= "FROM $media_table ";
        $query .= "LEFT JOIN $medialinks_table ON $media_table.mediaID = $medialinks_table.mediaID ";
        $query .= "WHERE cemeteryID = '$cemeteryID' ";
        if ($tree) $query .= "AND (media.gedcom = '$tree' || media.gedcom = '') ";
        $query .= "AND linktocem != '1'";
        $result2 = tng_query($query);
        $row = tng_fetch_assoc($result2);
        $totrows = $row['hscount'];
    } else {
        $totrows = $numrows;
    }
    $pagenav = get_browseitems_nav($totrows, "showmap.php?cemeteryID=$cemeteryID&amp;tree=$tree&amp;offset", $maxsearchresults, 5);
    if ($pagenav) $body .= "<p>$pagenav</p>";
    $body .= "<table cellpadding='3' cellspacing='1' border='0' class='w-full whiteback'>\n";
    $body .= "<thead><tr>\n";
    $body .= "<th class='fieldnameback'><span class='fieldname'>&nbsp;{$text['thumb']}</span></th>";
    $body .= "<th class='fieldnameback'><span class='fieldname'>&nbsp;{$text['description']}</span></th>";
    $body .= "<th class='fieldnameback'><span class='fieldname'>&nbsp;{$text['status']}</span></th>";
    $body .= "<th class='fieldnameback'><span class='fieldname'>&nbsp;{$text['location']}</span></th>";
    $body .= "<th class='fieldnameback'><span class='fieldname'>&nbsp;{$text['name']} ({$text['diedburied']})</span></th>";
    $body .= "</tr></thead>\n";
    while ($hs = tng_fetch_assoc($hsresult)) {
        $mediatypeID = $hs['mediatypeID'];
        $hs['cemeteryID'] = $cemeteryID;
        $usefolder = $hs['usecollfolder'] ? $mediatypes_assoc[$mediatypeID] : $mediapath;
        $status = $hs['status'];
        if ($status && $text[$status]) $hs['status'] = $text[$status];
        $query = "SELECT medialinkID, medialinks.personID AS personID, people.personID AS personID2, familyID, people.living AS living, people.private AS private, people.branch AS branch, families.branch AS fbranch, families.living AS fliving, families.private AS fprivate, husband, wife, people.lastname AS lastname, people.lnprefix AS lnprefix, people.firstname AS firstname, people.prefix AS prefix, people.suffix AS suffix, nameorder, medialinks.gedcom AS gedcom, treename, sources.title AS stitle, sources.sourceID, repositories.repoID,reponame, deathdate, burialdate, linktype ";
        $query .= "FROM ($medialinks_table medialinks, $trees_table trees) ";
        $query .= "LEFT JOIN $people_table people ON (medialinks.personID = people.personID AND medialinks.gedcom = people.gedcom) ";
        $query .= "LEFT JOIN $families_table families ON (medialinks.personID = families.familyID AND medialinks.gedcom = families.gedcom) ";
        $query .= "LEFT JOIN $sources_table sources ON (medialinks.personID = sources.sourceID AND medialinks.gedcom = sources.gedcom) ";
        $query .= "LEFT JOIN $repositories_table repositories ON (medialinks.personID = repositories.repoID AND medialinks.gedcom = repositories.gedcom) ";
        $query .= "WHERE mediaID = \"{$hs['mediaID']}\" AND medialinks.gedcom = trees.gedcom ";
        if ($tree) $query .= "AND medialinks.gedcom = '$tree' ";
        $query .= "ORDER BY lastname, lnprefix, firstname, medialinks.personID";
        $presult = tng_query($query);
        $hslinktext = "";
        $noneliving = $noneprivate = 1;
        while ($prow = tng_fetch_assoc($presult)) {
            $hstext = "";
            if ($prow['personID2'] != null) {
                $prights = determineLivingPrivateRights($prow);
                $prow['allow_living'] = $prights['living'];
                $prow['allow_private'] = $prights['private'];
                if (!$prow['allow_living']) $noneliving = 0;
                if (!$prow['allow_private']) $noneprivate = 0;
                $hslinktext .= "<a href=\"getperson.php?personID={$prow['personID2']}&amp;tree={$prow['gedcom']}\">";
                $hslinktext .= getName($prow);
                $deathdate = $prow['deathdate'] ? $prow['deathdate'] : $prow['burialdate'];
                if ($prow['deathdate']) {
                    $abbrev = $text['deathabbr'];
                } elseif ($prow['burialdate']) {
                    $abbrev = $text['burialabbr'];
                }
                $hstext = $deathdate ? " ($abbrev " . displayDate($deathdate) . ")" : "";
            } elseif ($prow['familyID'] != null) {
                $prow['living'] = $prow['fliving'];
                $prow['private'] = $prow['fprivate'];
                $prights = determineLivingPrivateRights($prow);
                $prow['allow_living'] = $prights['living'];
                $prow['allow_private'] = $prights['private'];
                if (!$prow['allow_living']) $noneliving = 0;
                if (!$prow['allow_private']) $noneprivate = 0;
                $hslinktext .= "<a href=\"familygroup.php?familyID={$prow['familyID']}&amp;tree={$prow['gedcom']}\">{$text['family']}: " . getFamilyName($prow);
            } elseif ($prow['sourceID'] != null) {
                $sourcetext = $prow['stitle'] ? "{$text['source']}: {$prow['stitle']}" : "{$text['source']}: {$prow['sourceID']}";
                $hslinktext .= "<a href=\"showsource.php?sourceID={$prow['sourceID']}&amp;tree={$prow['gedcom']}\">$sourcetext";
            } elseif ($prow['repoID'] != null) {
                $repotext = $prow['reponame'] ? "{$text['repository']}: {$prow['reponame']}" : "{$text['repository']}: {$prow['repoID']}";
                $hslinktext .= "<a href=\"showrepo.php?repoID={$prow['repoID']}&amp;tree={$prow['gedcom']}\">$repotext";
            } else {
                $treestr = $tngconfig['places1tree'] ? "" : "&amp;tree={$prow['gedcom']}";
                $hslinktext .= "<a href=\"placesearch.php?psearch={$prow['personID']}$treestr\">{$prow['personID']}";
            }
            $hslinktext .= "</a>$hstext\n<br/>\n";
        }
        tng_free_result($presult);
        $description = $hs['description'];
        $notes = nl2br($hs['notes']);
        $body .= "<tr><td class='text-center databack' style=\"width:$thumbmaxw" . "px;\">";
        $hs['allow_living'] = $noneliving;
        $hs['allow_private'] = $noneprivate;
        $imgsrc = getSmallPhoto($hs);
        $href = getMediaHREF($hs, 3);
        if ($imgsrc) {
            $body .= "<div class='media-img'><div class='media-prev' id=\"prev{$hs['mediaID']}\" style='display: none;'></div></div>\n";
            $body .= "<a href='$href'";
            if ($gotImageJpeg && isPhoto($hs) && checkMediaFileSize("$rootpath$usefolder/{$hs['path']}")) {
                $body .= " class='media-preview' id=\"img-{$hs['mediaID']}-0-" . urlencode("$usefolder/{$hs['path']}") . "\"";
            }
            $body .= ">$imgsrc</a>\n";
        } else {
            $body .= "&nbsp;";
        }
        $body .= "</td>\n";
        $body .= "<td class='databack'><span class='normal'><a href='$href'>{$hs['description']}</a><br>$notes&nbsp;</span></td>\n";
        $body .= "<td class='databack'><span class='normal'>{$hs['status']}&nbsp;</span></td>\n";
        $body .= "<td class='databack'><span class='normal'>" . nl2br($hs['plot']);
        if ($hs['latitude'] || $hs['longitude']) {
            $pin_num = $map['pins'] + 1;
            $coords = "$pin_num. {$text['latitude']}: {$hs['latitude']}, {$text['longitude']}: {$hs['longitude']}";
            if ($hs['plot']) {
                $body .= "<br>";
                $hs['plot'] .= " | $coords";
            } else {
                $hs['plot'] = $coords;
            }
            $body .= $coords;
            $balloondesc = @htmlspecialchars($description, ENT_QUOTES, $session_charset);
            //$balloonnotes = @htmlspecialchars($notes, ENT_QUOTES, $session_charset);
            $balloonnotes = tng_real_escape_string($notes);
            $balloonloc = @htmlspecialchars($hs['plot'], ENT_QUOTES, $session_charset);
            $escaped_imgsrc = str_replace("'", "\'", $imgsrc);
            $escaped_imgsrc = str_replace("\n", "", $escaped_imgsrc);
            $locations2map[$l2mCount] = [
                "placelevel" => 2,
                "pinplacelevel" => $pinplacelevel2,
                "event" => $text['headstonefor'],
                "htmlcontent" => "<div class='mapballoon normal'>$escaped_imgsrc<strong><p>$balloondesc</strong></p><p>$balloonnotes</p><p>$balloonloc</p></div>",
                "lat" => $hs['latitude'],
                "long" => $hs['longitude'],
                "zoom" => $hs['zoom'],
                "place" => $description,
                "notes" => truncateIt($notes, 600),
                //"eventdate"=>"date",
                "description" => $description,
                "fixedplace" => $balloondesc
            ];
            $l2mCount++;
            $map['pins']++;
            $index_all++;
        }
        $body .= "&nbsp;</span></td>\n";
        $body .= "<td class='databack'><span class='normal'>$hslinktext&nbsp;</span></td>\n";
        $body .= "</tr>\n";
    }
    $body .= "</table>\n";
    if ($pagenav) $body .= "<p>$pagenav</p>";
    $body .= "</div>\n";
}
tng_free_result($hsresult);
if ($cemetery['place']) {
    $treestr = $tree ? "and $people_table.gedcom = '$tree'" : "";
    $query = "SELECT * FROM ($people_table, $trees_table) WHERE burialplace = \"" . addslashes($cemetery['place']) . "\" and $people_table.gedcom = $trees_table.gedcom $treestr ORDER BY lastname, firstname";
    $result = tng_query($query);
    if (tng_num_rows($result)) {
        $body .= "<br><div class='rounded-lg titlebox'>\n";
        $body .= "<h3 class='subhead'>{$text['allburials']}</h3>\n";
        $body .= "<table class='w-full whiteback normal' cellpadding='3' cellspacing='1' border='0'>\n";
        $body .= "<thead>\n";
        $body .= "<tr>\n";
        $body .= "<th class='fieldnameback nbrcol'><span class='fieldname'>&nbsp;#&nbsp;</span></th>\n";
        $body .= "<th class='fieldnameback'><span class='fieldname text-nowrap'>&nbsp;{$text['lastfirst']}&nbsp;</span></th>\n";
        $body .= "<th colspan='2' class='fieldnameback'><span class='fieldname'>&nbsp;<b>{$text['buried']}</b>&nbsp;</span></th>\n";
        $body .= "<th class='fieldnameback'><span class='fieldname text-nowrap'>&nbsp;{$text['personid']}&nbsp;</span></th>\n";
        if ($numtrees > 1) {
            $body .= "<th class='fieldnameback'><span class='fieldname'>&nbsp;{$text['tree']}&nbsp;</span></th>\n";
        }
        $body .= "</tr>\n";
        $body .= "</thead>\n";
        $i = 1;
        while ($row = tng_fetch_assoc($result)) {
            $row['allow_living'] = 1;
            $rights = determineLivingPrivateRights($row);
            $row['allow_living'] = $rights['living'];
            $row['allow_private'] = $rights['private'];
            $name = getNameRev($row);
            $body .= "<tr>\n";
            $body .= "<td class='databack'>$i.</td>\n";
            $body .= "<td class='databack'>";
            $body .= "<a href=\"pedigree.php?personID={$row['personID']}&amp;tree={$row['gedcom']}\">";
            $body .= "<img src='img/chart.gif' alt='' class='inline-block'>";
            $body .= "</a> <a href=\"getperson.php?personID={$row['personID']}&amp;tree={$row['gedcom']}\">$name</a>&nbsp;</td>\n";
            $icon = buildSvgElement("img/search.svg", ["class" => "w-3 h-3 fill-current inline-block"]);
            $placetxt = $row['burialplace'] . " <a href=\"placesearch.php?tree=$tree&amp;psearch=" . urlencode($row['burialplace']) . "\" title=\"{$text['findplaces']}\">$icon</a>";
            $deathdate = $row['burialdate'] ? $row['burialdate'] : $row['deathdate'];
            if ($row['burialdate']) {
                $abbrev = $text['burialabbr'];
            } elseif ($row['deathdate']) {
                $abbrev = $text['deathabbr'];
            }
            $burialdate = $deathdate ? "$abbrev " . displayDate($deathdate) : "";
            $body .= "<td class='databack'>&nbsp;" . $burialdate . "</span></td>\n";
            $body .= "<td class='databack'><span class='normal'>$placetxt&nbsp;</span></td>";
            $body .= "<td class='databack'>{$row['personID']}</td>\n";
            if ($numtrees > 1) {
                $body .= "<td class='databack'><a href=\"showtree.php?tree={$row['gedcom']}\">{$row['treename']}</a>&nbsp;</td>\n";
            }
            $i++;
        }
        $body .= "</table>\n";
        $body .= "</div>\n";
    }
    tng_free_result($result);
}
if ($map['key'] && ($cemcoords || $map['pins'])) {
    echo "<div id='map' class='w-full mb-4 md:mx-auto md:max-w-3xl md:rounded-lg' style=\"width: {$map['hstw']}; height: {$map['hsth']};\"></div>\n";
    if ($cemcoords && empty($map['pins'])) {
        $locations2map[$l2mCount] = $cempin;
        $map['pins'] = 1;
    }
}
echo $body;
tng_footer($flags);
?>
