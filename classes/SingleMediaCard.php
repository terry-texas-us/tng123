<?php

declare (strict_types=1);

class SingleMediaCard
{
    public function __construct() {
    }

    /**
     * @param $tree
     * @param string $mediatypeID one of the media types
     * @param int $limit maximum number of items
     * @return string fully formed div block containing html
     */
    function buildHtmlContent($tree, $mediatypeID = 'photos', $limit = 5) {
        global $media_table, $medialinks_table, $text, $families_table, $citations_table, $nonames;
        global $people_table;
        global $mediatypes_display;
        global $thumbmaxw, $altstr, $tngconfig;

        if ($tree) {
            $wherestr = "(media.gedcom = '$tree' || media.gedcom = \"\") AND ";
            $wherestr2 = " AND medialinks.gedcom = '$tree'";
        } else {
            $wherestr = $wherestr2 = "";
        }

        $query = "SELECT distinct media.mediaID AS mediaID, description $altstr, media.notes, thumbpath, path, form, mediatypeID, media.gedcom AS gedcom, alwayson, usecollfolder, DATE_FORMAT(changedate,'%e %b %Y') AS changedatef, changedby, status, plot, abspath, newwindow ";
        $query .= "FROM $media_table media";
        if ($wherestr2) {
            $query .= " LEFT JOIN $medialinks_table medialinks ON media.mediaID = medialinks.mediaID";
        }
        $query .= " WHERE $wherestr mediatypeID = \"{$mediatypeID}\" ORDER BY ";
        if (strpos($_SERVER['SCRIPT_NAME'], "placesearch") !== FALSE) {
            $query .= "ordernum";
        } else {
            $query .= "changedate DESC, description";
        }
        $query .= " LIMIT $limit";
        $mediaresult = tng_query($query);

        $titlemsg = $text[$mediatypeID] ? $text[$mediatypeID] : $mediatypes_display[$mediatypeID];
        $header = "<div class=\"titlebox tablediv\">";
        $header .= "<h3 class='subhead'>$titlemsg</h3>";
        $header .= "<div>\n";

        $content = "";
        $thumbcount = 0;

        while ($row = tng_fetch_assoc($mediaresult)) {
            $mediatypeID = $row['mediatypeID'];

            $query = "SELECT medialinkID, medialinks.personID AS personID, familyID, people.living AS living, people.private AS private, people.branch AS branch, families.branch AS fbranch, families.living AS fliving, families.private AS fprivate, medialinks.gedcom AS gedcom, linktype ";
            $query .= "FROM $medialinks_table medialinks ";
            $query .= "LEFT JOIN $people_table people ON (medialinks.personID = people.personID AND medialinks.gedcom = people.gedcom) ";
            $query .= "LEFT JOIN $families_table families ON (medialinks.personID = families.familyID AND medialinks.gedcom = families.gedcom) ";
            $query .= "WHERE mediaID = \"{$row['mediaID']}\"$wherestr2 ORDER BY lastname, lnprefix, firstname, medialinks.personID";
            $presult = tng_query($query);
            $foundliving = 0;
            $foundprivate = 0;
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

                $rights = determineLivingPrivateRights($prow);
                $prow['allow_living'] = $rights['living'];
                $prow['allow_private'] = $rights['private'];

                if (!$rights['living']) {
                    $foundliving = 1;
                }
                if (!$rights['private']) {
                    $foundprivate = 1;
                }
            }
            tng_free_result($presult);

            $showPhotoInfo = $row['allow_living'] = $row['alwayson'] || (!$foundprivate && !$foundliving);

            $href = getMediaHREF($row, 0);
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

            $content .= "<div class=\"inner-block\">\n";
            $row['mediatypeID'] = $mediatypeID;
            $imgsrc = getSmallPhoto($row);
            if ($imgsrc) {
                $content .= "<div style=\"float:left;margin-right:10px;width:{$thumbmaxw}px;text-align:center;\">\n";
                if ($href && $row['allow_living']) {
                    $content .= "<a href=\"$href\">$imgsrc</a>\n";
                } else {
                    $content .= $imgsrc;
                }
                $content .= "</div>\n";
                $thumbcount++;
            }
            $content .= "<div>$description<br>$notes&nbsp;</div>\n";
            $content .= "<div style=\"clear:both;\"></div>\n";
            $content .= "</div>\n";
            $content .= "<div style=\"clear:both;\"></div>\n";
        }
        tng_free_result($mediaresult);
        $content .= "</div>\n";
        $content .= "</div>\n";

        return $content ? $header . $content . "<br>\n" : "";
    }
}