<?php

$textpart = "showphoto";
include "tng_begin.php";
include "functions.php";
include "personlib.php";
require_once "admin/pagination.php";
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
$albums = tng_fetch_all($result);
tng_free_result($result);
$numrows = count($albums);
if ($numrows == $maxsearchresults || $offsetplus > 1) {
    $query = "SELECT COUNT($albums_table.albumID) AS acount FROM $albums_table";
    $result = tng_query($query);
    $row = tng_fetch_assoc($result);
    tng_free_result($result);
    $totrows = $row['acount'];
} else {
    $totrows = $numrows;
}
$numrowsplus = $numrows + $offset;
$treestr = $tree ? " " . _('Tree') . ": $tree" : "";
$treestr = trim("$mediasearch $treestr");
$treestr = $treestr ? " ($treestr)" : "";
$logstring = "<a href=\"browsealbums.php?tree=$tree&amp;offset=$offset&amp;mediasearch=$mediasearch\">" . _('All Albums') . "$treestr</a>";
writelog($logstring);
preparebookmark($logstring);
tng_header(_('Albums'), $flags);
?>
    <h2 class="mb-4 header"><span class="headericon" id="albums-hdr-icon"></span><?php echo _('Albums'); ?></h2>
<?php echo treeDropdown(['startform' => true, 'endform' => true, 'action' => 'browsealbums', 'method' => 'get', 'name' => 'form1', 'id' => 'form1']); ?>
    <div class='mb-4 normal'>
        <form name="mediasearch1" action="browsealbums.php" method="get">
            <label for="mediasearch" hidden><?php echo _('Search'); ?></label>
            <input id="mediasearch" class="p-1 ml-1" name="mediasearch" type="search" value="<?php echo $mediasearch; ?>">
            <input class="p-1 px-2" type="submit" value="<?php echo _('Search'); ?>">
            <input name='tree' type='hidden' value="<?php echo $tree; ?>">
        </form>
    </div>
    <table class='whiteback normal'>
        <thead>
        <tr>
            <th class='p-2 fieldnameback fieldname nbrcol'>#</th>
            <th class='p-2 fieldnameback fieldname'><?php echo _('Thumb'); ?></th>
            <th class='p-2 fieldnameback fieldname'><?php echo _('Description'); ?></th>
            <th class='p-2 fieldnameback fieldname'><?php echo _('# Items'); ?></th>
            <th class='p-2 fieldnameback fieldname'><?php echo _('Linked to'); ?></th>
        </tr>
        </thead>
        <?php
        $albumtext = "";
        $i = $offsetplus;
        $maxplus = $maxsearchresults + 1;
        $thumbcount = 0;
        foreach ($albums as $row) {
            if ($tree) {
                $query2 = "SELECT count(albumlinks.albumlinkID) AS acount ";
                $query2 .= "FROM $albumlinks_table albumlinks, $media_table media ";
                $query2 .= "WHERE albumID = '{$row['albumID']}' AND albumlinks.mediaID = media.mediaID AND (media.gedcom = '$tree' OR media.gedcom = '')";
            } else {
                $query2 = "SELECT count($albumlinks_table.albumlinkID) AS acount FROM $albumlinks_table WHERE albumID = '{$row['albumID']}'";
            }
            $result2 = tng_query($query2) or die (_('Cannot execute query') . ": $query2");
            $arow = tng_fetch_assoc($result2);
            tng_free_result($result2);
            $query = "SELECT album2entities.entityID AS personID, people.personID AS personID2, people.living AS living, people.private AS private, people.branch AS branch, families.branch AS fbranch, families.living AS fliving, families.private AS fprivate, familyID, husband, wife, people.lastname AS lastname, people.lnprefix AS lnprefix, people.firstname AS firstname, people.prefix AS prefix, people.suffix AS suffix, nameorder, album2entities.gedcom, sources.title, sources.sourceID, repositories.repoID, reponame, deathdate, burialdate, linktype ";
            $query .= "FROM $album2entities_table album2entities ";
            $query .= "LEFT JOIN $people_table people ON album2entities.entityID = people.personID AND album2entities.gedcom = people.gedcom ";
            $query .= "LEFT JOIN $families_table families ON album2entities.entityID = families.familyID AND album2entities.gedcom = families.gedcom ";
            $query .= "LEFT JOIN $sources_table sources ON album2entities.entityID = sources.sourceID AND album2entities.gedcom = sources.gedcom ";
            $query .= "LEFT JOIN $repositories_table repositories ON (album2entities.entityID = repositories.repoID AND album2entities.gedcom = repositories.gedcom) ";
            $query .= "WHERE albumID = '{$row['albumID']}'";
            if ($tree) $query .= " AND album2entities.gedcom = '$tree'";
            $query .= "ORDER BY lastname, lnprefix, firstname, personID ";
            $query .= "LIMIT $maxplus";
            $result = tng_query($query);
            $entities = tng_fetch_all($result);
            tng_free_result($result);
            $numrows = count($entities);
            $medialinktext = "";
            $foundliving = 0;
            $foundprivate = 0;
            $count = 0;
            foreach ($entities as $prow) {
                if ($prow['fbranch'] != null) $prow['branch'] = $prow['fbranch'];
                if ($prow['fliving'] != null) $prow['living'] = $prow['fliving'];
                if ($prow['fprivate'] != null) {
                    $prow['private'] = $prow['fprivate'];
                }
                //if living still null, must be a source
                if ($prow['living'] == null && $prow['private'] == null && $prow['linktype'] == 'I') {
                    $query = "SELECT COUNT(personID) AS ccount ";
                    $query .= "FROM $citations_table citations, $people_table people ";
                    $query .= "WHERE citations.sourceID = '{$prow['personID']}' AND citations.persfamID = people.personID AND citations.gedcom = people.gedcom AND (living = '1' OR private = '1')";
                    $result = tng_query($query);
                    $prow2 = tng_fetch_assoc($result);
                    if ($prow2['ccount']) $prow['living'] = 1;
                    tng_free_result($result);
                }
                if ($prow['living'] == null && $prow['private'] == null && $prow['linktype'] == 'F') {
                    $query = "SELECT COUNT(familyID) AS ccount ";
                    $query .= "FROM $citations_table citations, $families_table families ";
                    $query .= "WHERE citations.sourceID = '{$prow['personID']}' AND citations.persfamID = families.familyID AND citations.gedcom = families.gedcom AND living = '1'";
                    $result = tng_query($query);
                    $prow2 = tng_fetch_assoc($result);
                    if ($prow2['ccount']) $prow['living'] = 1;
                    tng_free_result($result);
                }
                $rights = determineLivingPrivateRights($prow);
                $prow['allow_living'] = $rights['living'];
                $prow['allow_private'] = $rights['private'];
                if (!$rights['living']) $foundliving = 1;
                if (!$rights['private']) $foundprivate = 1;
                if ($prow['personID2'] != null) {
                    $medialinktext .= "<li><a href=\"getperson.php?personID={$prow['personID2']}&amp;tree={$prow['gedcom']}\">";
                    $medialinktext .= getName($prow) . "</a></li>\n";
                } elseif ($prow['sourceID'] != null) {
                    $sourcetext = $prow['title'] ? "" . _('Source') . ": {$prow['title']}" : "" . _('Source') . ": {$prow['sourceID']}";
                    $medialinktext .= "<li><a href=\"showsource.php?sourceID={$prow['personID']}&amp;tree={$prow['gedcom']}\">$sourcetext</a></li>\n";
                } elseif ($prow['repoID'] != null) {
                    $repotext = $prow['reponame'] ? "" . _('Repository') . ": {$prow['reponame']}" : "" . _('Repository') . ": {$prow['repoID']}";
                    $medialinktext .= "<li><a href=\"showrepo.php?repoID={$prow['personID']}&amp;tree={$prow['gedcom']}\">$repotext</a></li>\n";
                } elseif ($prow['familyID'] != null) {
                    $medialinktext .= "<li><a href=\"familygroup.php?familyID={$prow['personID']}&amp;tree={$prow['gedcom']}\">" . _('Family') . ": " . getFamilyName($prow) . "</a></li>\n";
                } else {
                    $treestr = $tngconfig['places1tree'] ? "" : "&amp;tree={$prow['gedcom']}";
                    $encodedPlace = urlencode($prow['personID']);
                    $medialinktext .= "<li><a href=\"placesearch.php?psearch={$encodedPlace}$treestr\">{$prow['personID']}</a></li>\n";
                }
                $count++;
            }
            if ($medialinktext) $medialinktext = "<ul class='px-0 mx-0'>$medialinktext</ul>\n";
            $showAlbumInfo = $row['allow_living'] = $row['alwayson'] || (!$foundprivate && !$foundliving);
            $description = $row['description'];
            if ($showAlbumInfo) {
                $imgsrc = getAlbumPhoto($row['albumID'], $row['albumname']);
                $alblink = "<a href=\"showalbum.php?albumID={$row['albumID']}\">{$row['albumname']}</a>";
            } else {
                $imgsrc = "";
                $alblink = _('Living');
                $nonamesloc = $foundprivate ? $tngconfig['nnpriv'] : $nonames;
                if ($nonamesloc) {
                    $description = _('At least one living or private individual is linked to this item - Details withheld.');
                } else {
                    $description .= "(" . _('At least one living or private individual is linked to this item - Details withheld.') . ")";
                }
            }
            $albumtext .= "<tr>\n";
            $albumtext .= "<td class='p-2 databack'><span class='normal'>$i</span></td>\n";
            if ($imgsrc) {
                $albumtext .= "<td class='p-2 text-center databack' style=\"width:{$thumbmaxw}px;\">$imgsrc</td>\n";
                $thumbcount++;
            } else {
                $albumtext .= "<td class='p-2 text-center databack'></td>\n";
            }
            $albumtext .= "<td class='p-2 databack'><span class='normal'>$alblink<br>$description</span></td>\n";
            $albumtext .= "<td class='p-2 text-center databack'><span class='normal'>{$arow['acount']}</span></td>\n";
            $albumtext .= "<td class='p-2 databack'><div class='inline normal'>\n$medialinktext</div></td>\n";
            $albumtext .= "</tr>\n";
            $i++;
        }
        echo $albumtext;
        ?>
    </table>
<?php
echo "<div class='w-full class=lg:flex my-6'>";
echo getPaginationLocationHtml($offsetplus, $numrowsplus, $totrows);
echo getPaginationControlsHtml($totrows, "browsealbums.php?mediasearch=$mediasearch&amp;offset", $maxsearchresults);
echo "</div>";
tng_footer("");
?>