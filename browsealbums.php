<?php
$textpart = "showphoto";
include "tng_begin.php";

include "functions.php";
include "personlib.php";

function doMediaSearch($instance, $pagenav) {
    global $text, $mediasearch, $tree;

    $str = getFORM("browsealbums", "get", "MediaSearch$instance", "");
    $str .= "<input type='text' name=\"mediasearch\" value=\"$mediasearch\">\n";
    $str .= "<input type='hidden' name=\"tree\" value='$tree'>\n";
    $str .= "<input type='submit' value=\"{$text['search']}\">\n";
    $str .= "<input type='button' value=\"{$text['tng_reset']}\" onclick=\"window.location.href='browsealbums.php';\">&nbsp;&nbsp;&nbsp;";
    $str .= $pagenav;
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

$query = "SELECT albumID, albumname, description, alwayson ";
$query .= "FROM $albums_table albums ";
$query .= "WHERE active = '1' ";
if ($mediasearch) {
    $query .= "AND (albums.albumname LIKE '%$mediasearch%' OR albums.description LIKE '%$mediasearch%' OR albums.keywords LIKE '%$mediasearch%')";
}
$query .= "ORDER BY albumname ";
$query .= "LIMIT $newoffset" . $maxsearchresults;
$result = tng_query($query);
$numrows = tng_num_rows($result);

if ($numrows == $maxsearchresults || $offsetplus > 1) {
    $query = "SELECT count($albums_table.albumID) AS acount FROM $albums_table";
    $result2 = tng_query($query);
    $row = tng_fetch_assoc($result2);
    tng_free_result($result2);
    $totrows = $row['acount'];
} else {
    $totrows = $numrows;
}

$numrowsplus = $numrows + $offset;

$treestr = $tree ? " {$text['tree']}: $tree" : "";
$treestr = trim("$mediasearch $treestr");
$treestr = $treestr ? " ($treestr)" : "";

$logstring = "<a href=\"browsealbums.php?tree=$tree&amp;offset=$offset&amp;mediasearch=$mediasearch\">{$text['allalbums']}$treestr</a>";
writelog($logstring);
preparebookmark($logstring);

echo "<!doctype html>\n";
echo "<html lang='en'>\n";

tng_header($text['albums'], $flags);
?>
    <h2 class="header"><span class="headericon" id="albums-hdr-icon"></span><?php echo $text['albums']; ?></h2>
    <br style="clear: both;">
<?php
echo treeDropdown(['startform' => true, 'endform' => true, 'action' => 'browsealbums', 'method' => 'get', 'name' => 'form1', 'id' => 'form1']);

if ($totrows) {
    echo "<p class='normal'>{$text['matches']} $offsetplus {$text['to']} $numrowsplus {$text['of']} $totrows</p>";
}

$pagenav = get_browseitems_nav($totrows, "browsealbums.php?mediasearch=$mediasearch&amp;offset", $maxsearchresults, $max_browsemedia_pages);
echo doMediaSearch(1, $pagenav);
echo "<br>\n";

$header = "";
$headerr = $enableminimap ? " data-tablesaw-minimap" : "";
$headerr .= $enablemodeswitch ? " data-tablesaw-mode-switch" : "";

if (isMobile()) {
    if ($tabletype == "toggle") {
        $tabletype = "columntoggle";
    }
    $header = "<table cellpadding=\"3\" cellspacing='1' border=\"0\" width=\"100%\" class=\"tablesaw whiteback normal\" data-tablesaw-mode=\"$tabletype\"{$headerr}>\n";
} else {
    $header = "<table cellpadding=\"3\" cellspacing='1' border=\"0\" class=\"whiteback normal\">";
}
echo $header;

$albumtext = $header = "";
$header .= "<thead><tr><th data-tablesaw-priority=\"persist\" class=\"fieldnameback fieldname nbrcol\">&nbsp;#&nbsp;</th>\n";
$header .= "<th data-tablesaw-priority='1' class=\"fieldnameback fieldname\">&nbsp;{$text['thumb']}&nbsp;</th>\n";
$header .= "<th data-tablesaw-priority=\"2\" class=\"fieldnameback fieldname\">&nbsp;{$text['description']}&nbsp;</th>\n";
$header .= "<th data-tablesaw-priority=\"3\" class=\"fieldnameback fieldname\">&nbsp;{$text['numitems']}&nbsp;</th>\n";
$header .= "<th data-tablesaw-priority=\"4\" class=\"fieldnameback fieldname\">&nbsp;{$text['indlinked']}&nbsp;</th>\n";
$header .= "</tr></thead>\n";

$i = $offsetplus;
$maxplus = $maxsearchresults + 1;
$thumbcount = 0;
while ($row = tng_fetch_assoc($result)) {
    if ($tree) {
        $query2 = "SELECT count(albumlinks.albumlinkID) AS acount ";
        $query2 .= "FROM $albumlinks_table albumlinks, $media_table media ";
        $query2 .= "WHERE albumID = '{$row['albumID']}' AND albumlinks.mediaID = media.mediaID AND (media.gedcom = '$tree' OR media.gedcom = '')";
    } else {
        $query2 = "SELECT count($albumlinks_table.albumlinkID) AS acount FROM $albumlinks_table WHERE albumID = '{$row['albumID']}'";
    }
    $result2 = tng_query($query2) or die ($text['cannotexecutequery'] . ": $query2");
    $arow = tng_fetch_assoc($result2);
    tng_free_result($result2);

    $query = "SELECT album2entities.entityID AS personID, people.personID AS personID2, people.living AS living, people.private AS private, people.branch AS branch, families.branch AS fbranch, families.living AS fliving, families.private AS fprivate, familyID, husband, wife, people.lastname AS lastname, people.lnprefix AS lnprefix, people.firstname AS firstname, people.prefix AS prefix, people.suffix AS suffix, nameorder, album2entities.gedcom, sources.title, sources.sourceID, repositories.repoID, reponame, deathdate, burialdate, linktype ";
    $query .= "FROM $album2entities_table album2entities ";
    $query .= "LEFT JOIN $people_table people ON album2entities.entityID = people.personID AND album2entities.gedcom = people.gedcom ";
    $query .= "LEFT JOIN $families_table families ON album2entities.entityID = families.familyID AND album2entities.gedcom = families.gedcom ";
    $query .= "LEFT JOIN $sources_table sources ON album2entities.entityID = sources.sourceID AND album2entities.gedcom = sources.gedcom ";
    $query .= "LEFT JOIN $repositories_table repositories ON (album2entities.entityID = repositories.repoID AND album2entities.gedcom = repositories.gedcom) ";
    $query .= "WHERE albumID = '{$row['albumID']}'";
    if ($tree) {
        $query .= " AND album2entities.gedcom = '$tree'";
    }
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
        if ($prow['living'] == NULL && $prow['private'] == NULL && $prow['linktype'] == 'I') {
            $query = "SELECT count(personID) AS ccount ";
            $query .= "FROM $citations_table citations, $people_table people ";
            $query .= "WHERE citations.sourceID = '{$prow['personID']}' AND citations.persfamID = people.personID AND citations.gedcom = people.gedcom AND (living = '1' OR private = '1')";
            $presult2 = tng_query($query);
            $prow2 = tng_fetch_assoc($presult2);
            if ($prow2['ccount']) {
                $prow['living'] = 1;
            }
            tng_free_result($presult2);
        }
        if ($prow['living'] == NULL && $prow['private'] == NULL && $prow['linktype'] == 'F') {
            $query = "SELECT count(familyID) AS ccount ";
            $query .= "FROM $citations_table citations, $families_table families ";
            $query .= "WHERE citations.sourceID = '{$prow['personID']}' AND citations.persfamID = families.familyID AND citations.gedcom = families.gedcom AND living = '1'";
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

        if ($prow['personID2'] != NULL) {
            $medialinktext .= "<li><a href=\"getperson.php?personID={$prow['personID2']}&amp;tree={$prow['gedcom']}\">";
            $medialinktext .= getName($prow) . "</a></li>\n";
        } elseif ($prow['sourceID'] != NULL) {
            $sourcetext = $prow['title'] ? "{$text['source']}: {$prow['title']}" : "{$text['source']}: {$prow['sourceID']}";
            $medialinktext .= "<li><a href=\"showsource.php?sourceID={$prow['personID']}&amp;tree={$prow['gedcom']}\">$sourcetext</a></li>\n";
        } elseif ($prow['repoID'] != NULL) {
            $repotext = $prow['reponame'] ? "{$text['repository']}: {$prow['reponame']}" : "{$text['repository']}: {$prow['repoID']}";
            $medialinktext .= "<li><a href=\"showrepo.php?repoID={$prow['personID']}&amp;tree={$prow['gedcom']}\">$repotext</a></li>\n";
        } elseif ($prow['familyID'] != NULL) {
            $medialinktext .= "<li><a href=\"familygroup.php?familyID={$prow['personID']}&amp;tree={$prow['gedcom']}\">{$text['family']}: " . getFamilyName($prow) . "</a></li>\n";
        } else {
            $treestr = $tngconfig['places1tree'] ? "" : "&amp;tree={$prow['gedcom']}";
            $medialinktext .= "<li><a href=\"placesearch.php?psearch={$prow['personID']}$treestr\">{$prow['personID']}</a></li>\n";
        }
        $count++;
    }
    if ($medialinktext) {
        $medialinktext = "<ul>$medialinktext</ul>\n";
    }
    tng_free_result($presult);

    $showAlbumInfo = $row['allow_living'] = $row['alwayson'] || (!$foundprivate && !$foundliving);

    $albumtext .= "<tr><td class='databack'><span class='normal'>$i</span></td>";

    $description = $row['description'];
    if ($showAlbumInfo) {
        $imgsrc = getAlbumPhoto($row['albumID'], $row['albumname']);
        $alblink = "<a href=\"showalbum.php?albumID={$row['albumID']}\">{$row['albumname']}</a>";
    } else {
        $imgsrc = "";
        $alblink = $text['living'];
        $nonamesloc = $foundprivate ? $tngconfig['nnpriv'] : $nonames;
        if ($nonamesloc) {
            $description = $text['livingphoto'];
        } else {
            $description .= "({$text['livingphoto']})";
        }
    }

    if ($imgsrc) {
        $albumtext .= "<td class='databack text-center' style=\"width:{$thumbmaxw}px;\">$imgsrc</td>";
        $thumbcount++;
    } else {
        $albumtext .= "<td class='databack text-center'>&nbsp;</td>";
    }

    $albumtext .= "<td class='databack'><span class='normal'>$alblink<br>$description&nbsp;</span></td>\n";
    $albumtext .= "<td class='databack text-center'><span class='normal'>{$arow['acount']}&nbsp;</span></td>\n";
    $albumtext .= "<td class='databack'><span class='normal'>\n$medialinktext&nbsp;</span></td>\n";
    $albumtext .= "</tr>\n";
    $i++;
}
tng_free_result($result);

if (!$thumbcount) {
    $header = str_replace("<td class=\"fieldnameback\"><span class=\"fieldname\">&nbsp;<strong>{$text['thumb']}</strong>&nbsp;</span></td>", "", $header);
    $albumtext = str_replace("<td class='databack center'>&nbsp;</td><td class='databack'>", "<td class='databack'>", $albumtext);
}
echo $header . $albumtext;
?>
    </table><br>
<?php
if ($totrows && ($pagenav || $mediasearch)) {
    echo doMediaSearch(2, $pagenav);
    echo "<br>";
}
tng_footer("");
?>