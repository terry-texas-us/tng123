<?php

$textpart = "search";
$needMap = true;
include "tng_begin.php";
require_once "./admin/trees.php";
if (!$psearch) exit;
include "personlib.php";
require_once "admin/pagination.php";
@set_time_limit(0);
$psearch = preg_replace("/[<>{};!=]/", '', $psearch);
$psearchns = $psearch;
$psearch = addslashes($psearch);
$querystring = $psearchns;
$cutoffstr = "personID = '$psearch'";
$whatsnew = 0;
if (!empty($order)) {
    $_SESSION['tng_psearch_order'] = $order;
} else {
    $order = $_SESSION['tng_psearch_order'] ?? "name";
}
if ($order != "name" && $order != "nameup" && $order != "date" && $order != "dateup") $order = "";
$datesort = "dateup";
$namesort = "name";
$orderloc = strpos($_SERVER['QUERY_STRING'], "&amp;order=");
$currargs = $orderloc > 0 ? substr($_SERVER['QUERY_STRING'], 0, $orderloc) : $_SERVER['QUERY_STRING'];

$numtrees = getTreesCount($trees_table);

if ($order == "name") {
    $namesort = "<a href='$placesearch_url$currargs&amp;order=nameup' class='lightlink'>xxx <img src='img/tng_sort_desc.gif' alt='' class='inline-block'></a>";
} else {
    $namesort = "<a href='$placesearch_url$currargs&amp;order=name' class='lightlink'>xxx <img src='img/tng_sort_asc.gif' alt='' class='inline-block'></a>";
}

if ($order == "date") {
    $datesort = "<a href='$placesearch_url$currargs&amp;order=dateup' class='lightlink'>yyy <img src='img/tng_sort_desc.gif' alt='' class='inline-block'></a>";
} else {
    $datesort = "<a href='$placesearch_url$currargs&amp;order=date' class='lightlink'>yyy <img src='img/tng_sort_asc.gif' alt='' class='inline-block'></a>";
}
/**
 * @param $prefix
 * @param $stdevents
 * @param $displaymsgs
 * @return int
 */
function processEvents($prefix, $stdevents, $displaymsgs) {
    global $eventtypes_table, $text, $tree, $people_table, $families_table, $trees_table, $offset, $page, $psearch, $maxsearchresults, $numtrees;
    global $psearchns, $urlstring, $events_table, $order, $namesort, $datesort;

    if ($prefix === "I") {
        $table = $people_table;
        $alias = "people";
        $idfield = "personID";
        $idtext = "personid";
        $namefield = "lastfirst";
    } elseif ($prefix === "F") {
        $table = $families_table;
        $alias = "families";
        $idfield = "familyID";
        $idtext = "familyid";
        $namefield = "family";
    } else {
        return 0;
    }
    $successcount = 0;

    $allwhere = "$alias.gedcom = trees.gedcom";
    if ($tree) $allwhere .= " AND $alias.gedcom = '$tree'";

    $more = getLivingPrivateRestrictions($alias, false, false);
    if ($more) {
        if ($allwhere) $allwhere .= " AND ";
        $allwhere .= $more;
    }
    if ($offset) {
        $offsetplus = $offset + 1;
        $newoffset = "$offset, ";
    } else {
        $offsetplus = 1;
        $newoffset = "";
        $page = 1;
    }
    $tngevents = $stdevents;
    $custevents = [];
    $query = "SELECT tag, eventtypeID, display FROM $eventtypes_table WHERE keep = '1' AND type = '$prefix' ORDER BY display";
    $result = tng_query($query);
    $eventTypes = tng_fetch_all($result);
    tng_free_result($result);
    foreach ($eventTypes as $eventType) {
        $eventtypeID = $eventType['eventtypeID'];
        array_push($tngevents, $eventtypeID);
        array_push($custevents, $eventtypeID);
        $displaymsgs[$eventtypeID] = getEventDisplay($eventType['display']);
    }
    foreach ($tngevents as $tngevent) {
        $eventsjoin = false;
        $allwhere2 = "";
        $placetxt = $displaymsgs[$tngevent];
        if (in_array($tngevent, $custevents)) {
            $eventsjoin = true;
            $allwhere2 .= " AND $alias.$idfield = events.persfamID AND $alias.gedcom = events.gedcom AND eventtypeID = '$tngevent' AND parenttag = ''";
            $tngevent = "event";
        }
        $datefield = $tngevent . "date";
        $datefieldtr = $tngevent . "datetr";
        $place = $tngevent . "place";
        $allwhere2 .= " AND $place = '$psearch'";
        if ($prefix === "F") {
            if ($order == "name") {
                $orderstr = "p1lastname, p2lastname, $datefieldtr";
            } elseif ($order == "nameup") {
                $orderstr = "p1lastname DESC, p2lastname DESC, $datefieldtr DESC";
            } elseif ($order == "date") {
                $orderstr = "$datefieldtr, p1lastname, p2lastname";
            } else {
                $orderstr = "$datefieldtr DESC, p1lastname DESC, p2lastname DESC";
            }
            $query = "SELECT families.ID, families.familyID, families.living, families.private, families.branch, p1.lastname AS p1lastname, p2.lastname AS p2lastname, $place, $datefield, families.gedcom, treename ";
            $query .= "FROM ($families_table families, $trees_table trees";
            $query .= $eventsjoin ? ", $events_table events) " : ") ";
            $query .= "LEFT JOIN $people_table p1 ON families.gedcom = p1.gedcom AND p1.personID = families.husband ";
            $query .= "LEFT JOIN $people_table p2 ON families.gedcom = p2.gedcom AND p2.personID = families.wife ";
            $query .= "WHERE $allwhere $allwhere2 ";
            $query .= "ORDER BY $orderstr ";
            $query .= "LIMIT $newoffset" . $maxsearchresults;
        } elseif ($prefix === "I") {
            if ($order == "name") {
                $orderstr = "lastname, firstname, $datefieldtr";
            } elseif ($order == "nameup") {
                $orderstr = "lastname DESC, firstname DESC, $datefieldtr DESC";
            } elseif ($order == "date") {
                $orderstr = "$datefieldtr, lastname, firstname";
            } else {
                $orderstr = "$datefieldtr DESC, lastname DESC, firstname DESC";
            }
            $query = "SELECT people.ID, people.personID, lastname, lnprefix, firstname, people.living, people.private, people.branch, prefix, suffix, nameorder, $place, $datefield, people.gedcom, treename ";
            $query .= "FROM ($people_table people, $trees_table trees";
            $query .= $eventsjoin ? ", $events_table events) " : ") ";
            $query .= "WHERE $allwhere $allwhere2 ";
            $query .= "ORDER BY $orderstr ";
            $query .= "LIMIT $newoffset" . $maxsearchresults;
        }
        $result = tng_query($query);
        $numrows = tng_num_rows($result);

        if ($numrows == $maxsearchresults || $offsetplus > 1) {
            $query = "SELECT COUNT($idfield) AS rcount ";
            $query .= "FROM ($table $alias, $trees_table trees";
            $query .= $eventsjoin ? ", $events_table events) " : ") ";
            $query .= "WHERE $allwhere $allwhere2";
            $result2 = tng_query($query);
            $countrow = tng_fetch_assoc($result2);
            $totrows = $countrow['rcount'];
        } else {
            $totrows = $numrows;
        }
        if ($numrows) {
            echo "<br>\n";
            echo "<div class='w-full mb-4 lg:mx-auto lg:max-w-5xl lg:rounded-lg titlebox'>\n";
            echo "<h3 class='subhead mb-4'>" . $placetxt . "</h3>\n";
            $numrowsplus = $numrows + $offset;
            $successcount++;
            $namestr = preg_replace("/xxx/", $text[$namefield], $namesort);
            $datestr = preg_replace("/yyy/", $placetxt, $datesort);
            ?>
            <table class="w-full whiteback">
                <tr>
                    <th class="hidden p-2 fieldnameback md:table-cell"><span class="fieldname"></span></th>
                    <th class="p-2 fieldnameback"><span class="fieldname whitespace-no-wrap"><?php echo $namestr; ?></span></th>
                    <th class="p-2 fieldnameback" colspan="2"><span class="fieldname"><?php echo $datestr; ?></span></th>
                    <th class="hidden p-2 fieldnameback md:table-cell"><span class="fieldname whitespace-no-wrap"><?php echo $text[$idtext]; ?></span></th>
                    <?php if ($numtrees > 1) { ?>
                        <th class="p-2 fieldnameback"><span class="fieldname"><?php echo $text['tree']; ?></span></th>
                    <?php } ?>
                </tr>
                <?php
                $i = $offsetplus;
                while ($row = tng_fetch_assoc($result)) {
                    $rights = determineLivingPrivateRights($row);
                    $row['allow_living'] = $rights['living'];
                    $row['allow_private'] = $rights['private'];
                    if ($rights['both']) {
                        $placetxt = $row[$place] ? $row[$place] : "";
                        $dateval = $row[$datefield];
                    } else {
                        $dateval = $placetxt = "";
                    }
                    echo "<tr>";
                    echo "<td class='hidden p-2 databack md:table-cell'><span class='normal'>$i</span></td>\n";
                    $i++;
                    echo "<td class='p-2 databack'><span class='normal'>";
                    if ($prefix == "F") {
                        echo "<a href=\"familygroup.php?familyID={$row['familyID']}&amp;tree={$row['gedcom']}\">{$row['p1lastname']} / {$row['p2lastname']}</a>";
                    } elseif ($prefix == "I") {
                        $name = getNameRev($row);
                        echo "<a href=\"pedigree.php?personID={$row['personID']}&amp;tree={$row['gedcom']}\">";
                        echo "<img src='img/chart.gif' alt='' class='inline-block'>";
                        echo "</a> <a href=\"getperson.php?personID={$row['personID']}&amp;tree={$row['gedcom']}\">$name</a>";
                    }
                    echo "</span></td>";
                    echo "<td class='p-2 databack'><span class='normal'>" . displayDate($dateval) . "</span></td>";
                    echo "<td class='p-2 databack'><span class='normal'>$placetxt</span></td>";
                    echo "<td class='hidden p-2 databack md:table-cell'><span class='normal'>{$row[$idfield]} </span></td>";
                    if ($numtrees > 1) {
                        echo "<td class='p-2 databack'><span class='normal'><a href=\"showtree.php?tree={$row['gedcom']}\">{$row['treename']}</a></span></td>";
                    }
                    echo "</tr>\n";
                }
                tng_free_result($result);
                ?>
            </table>
            <?php
            echo "<div class='w-full class=lg:flex my-6'>";
            echo getPaginationLocationHtml($offsetplus, $numrowsplus, $totrows);
            echo getPaginationControlsHtml($totrows, "placesearch.php?$urlstring&amp;psearch=" . urlencode($psearchns) . "&amp;order=$order&amp;offset", $maxsearchresults);
            echo "</div>";
            echo "</div>\n";
        }
    }
    return $successcount;
}

//don't allow default tree here
$tree = $orgtree;
$tngconfig['istart'] = 0;

$ldsOK = determineLDSRights();

if ($tree && !$tngconfig['places1tree']) {
    $urlstring = "&amp;tree=$tree";
    $logurlstring = "&tree=$tree";

    $treerow = getTree($trees_table, $tree);
} else {
    $urlstring = $logurlstring = "";
}

if (!$tngconfig['places1tree']) {
    $querystring .= " {$text['and']} tree {$text['equals']} {$treerow['treename']} ";
    $treename = ", treename";
} else {
    $treename = "";
}

$logstring = "<a href=\"placesearch.php?psearch=$psearchns$logurlstring\">{$text['searchresults']} $querystring</a>";
writelog($logstring);
preparebookmark($logstring);

if ($map['key'] && $isConnected) {
    if (!isset($flags['scripting'])) $flags['scripting'] = "";
    $flags['scripting'] .= "<script src=\"{$http}://maps.googleapis.com/maps/api/js?language={$text['glang']}$mapkeystr\"></script>\n";
}

tng_header($psearchns, $flags);

$photostr = showSmallPhoto($psearch, $psearch, 1, 0);

echo tng_DrawHeading($photostr, $psearchns, "");

//show the notes and media for each tree (if none specified)

//first do media
$pquery = "SELECT placelevel, latitude, longitude, zoom, notes, places.gedcom$treename ";
$pquery .= "FROM $places_table places ";
if (!$tngconfig['places1tree']) {
    $pquery .= " LEFT JOIN $trees_table trees ON places.gedcom = trees.gedcom ";
}
$pquery .= "WHERE place = '$psearch'";
if ($tree && !$tngconfig['places1tree']) {
    $pquery .= " AND places.gedcom = '$tree' ";
}
$presult = tng_query($pquery) or die ($text['cannotexecutequery'] . ": $pquery");

$rightbranch = 1;
$innermenu = "&nbsp;\n";
echo tng_menu("L", "place", $psearch, $innermenu);

$altstr = ", altdescription, altnotes";
$mapdrawn = false;
$foundtree = "";
while ($prow = tng_fetch_assoc($presult)) {
    $foundtree = $prow['gedcom'];
    if ($prow['notes'] || $prow['latitude'] || $prow['longitude']) {
        if (($prow['latitude'] || $prow['longitude']) && $map['key'] && !$mapdrawn) {
            echo "<br><div id='map' class='w-full mb-4 lg:mx-auto lg:max-w-5xl lg:rounded-lg' style=\"width: {$map['indw']}; height: {$map['indh']}; margin-bottom:20px;\"></div>\n";
            $usedplaces = [];
            $mapdrawn = true;
        }
        if (!$tngconfig['places1tree'] && $numtrees > 1) {
            echo "<br><span><strong>{$text['tree']}:</strong> {$prow['treename']}</span><br>\n";
        }
        if ($prow['notes']) {
            $notes = nl2br(getXrefNotes($prow['notes'], $prow['gedcom']));
            echo "<span><strong>{$text['notes']}:</strong> $notes</span><br>";
        }
        if ($map['key']) {
            $lat = $prow['latitude'];
            $long = $prow['longitude'];
            $zoom = $prow['zoom'] ? $prow['zoom'] : 10;
            $placelevel = $prow['placelevel'] ? $prow['placelevel'] : "0";
            $pinplacelevel = ${"pinplacelevel" . $placelevel};
            $placeleveltext = $placelevel > 0 ? $admtext['level' . $placelevel] . "&nbsp;:&nbsp;" : "";
            $codedplace = @htmlspecialchars(str_replace($banish, $banreplace, $psearchns), ENT_QUOTES, $session_charset);
            $codednotes = $prow['notes'] ? "<br><br>" . tng_real_escape_string($text['notes'] . ": " . $prow['notes']) : "";
            $codednotes .= "<br><br><a href=\"{$http}://maps.google.com/maps?f=q{$text['glang']}$mcharsetstr&amp;daddr=$lat,$long($codedplace)&amp;z=$zoom&amp;om=1&amp;iwloc=addr\" target=\"_blank\">{$text['getdirections']}</a>{$text['directionsto']} $codedplace";
            if ($lat && $long) {
                $uniqueplace = $psearch . $lat . $long;
                if ($map['showallpins'] || !in_array($uniqueplace, $usedplaces)) {
                    $usedplaces[] = $uniqueplace;
                    $locations2map[$l2mCount] = ["place" => $codedplace, "pinplacelevel" => $pinplacelevel, "lat" => $lat, "long" => $long, "zoom" => $zoom, "htmlcontent" => "<div class=\"mapballoon normal\">$placeleveltext<br>$codedplace$codednotes</div>"];
                    $l2mCount++;
                }
            }
            echo "<a href=\"{$http}://maps.google.com/maps?f=q{$text['glang']}$mcharsetstr&amp;daddr=$lat,$long($codedplace)&amp;z=12&amp;om=1&amp;iwloc=addr\" target=\"_blank\"><img src=\"google_marker.php?image=$pinplacelevel.png&amp;text=$l2mCount\" alt=\"\"></a><strong>$placeleveltext</strong><span class=\"normal\"><strong>{$text['latitude']}:</strong> {$prow['latitude']}, <strong>{$text['longitude']}:</strong> {$prow['longitude']}</span><br><br>";
            $map['pins']++;
        } elseif ($prow['latitude'] || $prow['longitude']) {
            echo "<span><strong>{$text['latitude']}:</strong> {$prow['latitude']}, <strong>{$text['longitude']}:</strong> {$prow['longitude']}</span><br><br>";
        }
    }
}
if (!$tree && tng_num_rows($presult) == 1) {
    $tree = $foundtree;
}
tng_free_result($presult);

$placemedia = getMedia($psearch, "L");
$placealbums = getAlbums($psearch, "L");
$media = doMediaSection($psearch, $placemedia, $placealbums);
if ($media) {
    echo "<br>\n<div class='rounded-lg titlebox'>\n";
    echo "<h3 class='subhead'>{$text['media']}</h3>";
    echo "$media\n";
    echo "</div>\n";
}

$pquery = "SELECT cemname, city, county, state, country, cemeteryID FROM $cemeteries_table WHERE place = '$psearch'";
$presult = tng_query($pquery) or die ($text['cannotexecutequery'] . ": $pquery");
$cemeteries = tng_fetch_all($presult);
$cemdata = "";
$i = 1;
foreach ($cemeteries as $prow) {
    $country = stripslashes($prow['country']);
    $state = stripslashes($prow['state']);
    $county = stripslashes($prow['county']);
    $city = stripslashes($prow['city']);
    $location = $city;
    if ($location && $county) {
        $location .= ", $county";
    } else {
        $location = $county;
    }
    if ($location && $state) {
        $location .= ", $state";
    } else {
        $location = $state;
    }
    if ($location && $country) {
        $location .= ", $country";
    } else {
        $location = $country;
    }
    $cemdata .= "<tr>\n";
    $cemdata .= "<td class='p-2 databack'>$i.</td>\n";
    $cemdata .= "<td class='p-2 databack'><a href=\"showmap.php?cemeteryID={$prow['cemeteryID']}\">{$prow['cemname']}</a></td>\n";
    $cemdata .= "<td class='p-2 databack'>$location</td>\n";
    $cemdata .= "</tr>\n";
    $i++;
}

if ($cemdata) {
    echo "<br>\n<div class='rounded-lg titlebox'>\n";
    echo "<h3 class='subhead'>{$text['cemeteries']}</h3>";
    echo "<table class='w-full whiteback'>\n";
    echo "<tr>\n";
    echo "<td class='p-2 fieldnameback'><span class='fieldname'></span></td>\n";
    echo "<td class='p-2 fieldnameback'><span class='fieldname font-semibold'>{$text['name']}</span></td>\n";
    echo "<td class='p-2 fieldnameback'><span class='fieldname font-semibold'>{$text['location']}</span></td>\n";
    echo "</tr>\n";
    echo "$cemdata</table>\n";
    echo "</div>\n";
}

$successcount = 0;

//then loop over events like anniversaries
$stdevents = ["birth", "altbirth", "death", "burial"];
$displaymsgs = ["birth" => $text['birth'], "altbirth" => $text['christened'], "death" => $text['died'], "burial" => $text['buried']];
if ($ldsOK) {
    array_push($stdevents, "endl", "init", "conf", "bapt");
    $displaymsgs['endl'] = $text['endowedlds'];
    $displaymsgs['init'] = $text['initlds'];
    $displaymsgs['conf'] = $text['conflds'];
    $displaymsgs['bapt'] = $text['baptizedlds'];
}
$successcount += processEvents("I", $stdevents, $displaymsgs);

$stdevents = ["marr", "div"];
$displaymsgs = ["marr" => $text['married'], "div" => $text['divorced']];
if ($ldsOK) {
    array_push($stdevents, "seal");
    $displaymsgs['seal'] = $text['sealedslds'];
}
$successcount += processEvents("F", $stdevents, $displaymsgs);

if (!$successcount) echo "<p>{$text['noresults']}.</p>";

tng_footer("");
?>