<?php

function getAlbumPhoto($albumID, $albumname) {
    global $rootpath, $media_table, $albumlinks_table, $people_table, $families_table, $citations_table, $text, $medialinks_table;
    global $mediatypes_assoc, $mediapath, $tngconfig, $sitever, $livedefault, $tree;


    $query2 = "SELECT gedcom, path, thumbpath, usecollfolder, mediatypeID, albumlinks.mediaID AS mediaID, alwayson, media.gedcom ";
    $query2 .= "FROM ($media_table media, $albumlinks_table albumlinks) ";
    $query2 .= "WHERE albumID = '$albumID' AND media.mediaID = albumlinks.mediaID AND defphoto='1'";
    $result2 = tng_query($query2) or die ($text['cannotexecutequery'] . ": $query2");
    $trow = tng_fetch_assoc($result2);
    $mediaID = $trow['mediaID'];
    $tmediatypeID = $trow['mediatypeID'];
    $tusefolder = $trow['usecollfolder'] ? $mediatypes_assoc[$tmediatypeID] : $mediapath;
    tng_free_result($result2);

    $imgsrc = "";
    $treestr = $tngconfig['mediatrees'] && $trow['gedcom'] ? $trow['gedcom'] . "/" : "";
    if ($trow['thumbpath'] && file_exists("$rootpath$tusefolder/$treestr" . $trow['thumbpath'])) {
        $foundliving = 0;
        $foundprivate = 0;
        if (!$trow['alwayson'] && $livedefault != 2) {
            $query = "SELECT people.living AS living, people.private AS private, people.branch AS branch, families.branch AS fbranch, families.living AS fliving, families.private AS fprivate, linktype, medialinks.gedcom AS gedcom ";
            $query .= "FROM $medialinks_table medialinks ";
            $query .= "LEFT JOIN $people_table people ON medialinks.personID = people.personID AND medialinks.gedcom = people.gedcom ";
            $query .= "LEFT JOIN $families_table families ON medialinks.personID = families.familyID AND medialinks.gedcom = families.gedcom ";
            $query .= "WHERE mediaID = '$mediaID'";
            if ($tree) {
                $query .= " AND medialinks.gedcom = '$tree'";
            }
            $presult = tng_query($query);
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

                $rights = determineLivingPrivateRights($prow);
                // TODO are allow_living allow_private used
                $prow['allow_living'] == $rights['living'];
                $prow['allow_private'] == $rights['private'];

                if ($prow['living'] == NULL && $prow['private'] == NULL && $prow['linktype'] == 'I') {
                    $query = "SELECT count(personID) as ccount ";
                    $query .= "FROM $citations_table citations, $people_table people ";
                    $query .= "WHERE citations.sourceID = '{$prow['personID']}' AND citations.persfamID = people.personID AND citations.gedcom = people.gedcom AND living = '1'";
                    $presult2 = tng_query($query);
                    $prow2 = tng_fetch_assoc($presult2);
                    if ($prow2['ccount']) {
                        $prow['living'] = 1;
                    }
                    tng_free_result($presult2);
                } elseif ($prow['living'] == NULL && $prow['private'] == NULL && $prow['linktype'] == 'F') {
                    $query = "SELECT count(familyID) as ccount ";
                    $query .= "FROM $citations_table citations, $families_table families ";
                    $query .= "WHERE citations.sourceID = '{$prow['personID']}' AND citations.persfamID = families.familyID AND citations.gedcom = families.gedcom AND living = '1'";
                    $presult2 = tng_query($query);
                    $prow2 = tng_fetch_assoc($presult2);
                    if ($prow2['ccount']) {
                        $prow['living'] = 1;
                    }
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
            $size = @GetImageSize("$rootpath$tusefolder / $treestr{$trow['thumbpath']}");
            $imgsrc = "<div class=\"media-img\">\n";
            $imgsrc .= "<div class=\"media-prev\" id=\"prev$albumID\" style=\"display:none;\"></div>\n";
            $imgsrc .= "</div>\n";
            $imgsrc .= "<a href=\"showalbum.php?albumID=$albumID\" title=\"{$text['albclicksee']}\"";
            if (function_exists('imageJpeg')) {
                $imgsrc .= " onmouseover=\"showPreview('{$trow['mediaID']}','','" . urlencode("$tusefolder/$treestr{$trow['path']}") . "','');\" onmouseout=\"closePreview('$albumID','','$sitever');\" onclick=\"closePreview('$albumID','');\"";
            }
            $imgsrc .= "><img src=\"$tusefolder/$treestr" . str_replace("%2F", "/", rawurlencode($trow['thumbpath'])) . "\" class=\"thumb\" $size[3] alt=\"$albumname\"></a>";
        }
    }
    return $imgsrc;
}

