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
      $wherestr = "($media_table.gedcom = \"$tree\" || $media_table.gedcom = \"\") AND ";
      $wherestr2 = " AND $medialinks_table.gedcom = \"$tree\"";
    } else {
      $wherestr = $wherestr2 = "";
    }

    $query = "SELECT distinct $media_table.mediaID as mediaID, description $altstr, $media_table.notes, thumbpath, path, form, mediatypeID, $media_table.gedcom as gedcom, alwayson, usecollfolder, DATE_FORMAT(changedate,'%e %b %Y') as changedatef, changedby, status, plot, abspath, newwindow FROM $media_table";
    if ($wherestr2) {
      $query .= " LEFT JOIN $medialinks_table on $media_table.mediaID = $medialinks_table.mediaID";
    }
    $query .= " WHERE $wherestr mediatypeID = \"$mediatypeID\" ORDER BY ";
    if (strpos($_SERVER['SCRIPT_NAME'], "placesearch") !== FALSE) {
      $query .= "ordernum";
    } else {
      $query .= "changedate DESC, description";
    }
    $query .= " LIMIT $limit";
    $mediaresult = tng_query($query);

    $titlemsg = $text[$mediatypeID] ? $text[$mediatypeID] : $mediatypes_display[$mediatypeID];
    $header = "<div class=\"titlebox tablediv\"><span class=\"subhead\"><b>$titlemsg</b></span><br /><br /><div>\n";

    $content = "";
    $thumbcount = 0;

    while ($row = tng_fetch_assoc($mediaresult)) {
      $mediatypeID = $row['mediatypeID'];

      $query = "SELECT medialinkID, $medialinks_table.personID as personID, familyID, people.living as living, people.private as private, people.branch as branch,
			$families_table.branch as fbranch, $families_table.living as fliving, $families_table.private as fprivate, 
			$medialinks_table.gedcom as gedcom, linktype
			FROM $medialinks_table
			LEFT JOIN $people_table AS people ON ($medialinks_table.personID = people.personID AND $medialinks_table.gedcom = people.gedcom)
			LEFT JOIN $families_table ON ($medialinks_table.personID = $families_table.familyID AND $medialinks_table.gedcom = $families_table.gedcom)
			WHERE mediaID = \"{$row['mediaID']}\"$wherestr2 ORDER BY lastname, lnprefix, firstname, $medialinks_table.personID";
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
          $query = "SELECT count(personID) as ccount FROM $citations_table, $people_table
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
          $notes = $notes ? $notes . "<br />({$text['livingphoto']})" : "({$text['livingphoto']})";
        }
        $href = "";
      }

      $content .= "<div class=\"inner-block\">\n";
      $row['mediatypeID'] = $mediatypeID;
      $imgsrc = getSmallPhoto($row);
      if ($imgsrc) {
        $content .= "<div style=\"float:left;margin-right:10px;width:{$thumbmaxw}px;text-align:center\">\n";
        if ($href && $row['allow_living']) {
          $content .= "<a href=\"$href\">$imgsrc</a>\n";
        } else {
          $content .= $imgsrc;
        }
        $content .= "</div>\n";
        $thumbcount++;
      }
      $content .= "<div>$description<br />$notes&nbsp;</div>\n";
      $content .= "<div style=\"clear:both;\"></div>\n";
      $content .= "</div>\n";
      $content .= "<div style=\"clear:both;\"></div>\n";
    }
    tng_free_result($mediaresult);
    $content .= "</div>\n";
    $content .= "</div>\n";

    return $content ? $header . $content . "<br />\n" : "";
  }
}