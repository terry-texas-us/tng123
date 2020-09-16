<?php
$textpart = "whatsnew";

include "tng_begin.php";
if ($requirelogin && !$_SESSION['currentuser']) {
    header("Location:$homepage");
    exit;
}

$langstr = isset($_GET['lang']) ? "&amp;lang=$languages_path" . $_GET['lang'] : "";

@ini_set("session.bug_compat_warn", "0");

include "version.php";

$getperson_url = getURL("getperson", 1);
$showmedia_url = getURL("showmedia", 1);
$familygroup_url = getURL("familygroup", 1);

$date = date("r");
$timezone = date("O");

function doMedia($mediatypeID) {
    global $tngdomain, $langstr, $mediatypes_display, $timezone, $session_charset;

    global $media_table, $medialinks_table, $change_limit, $cutoffstr, $text, $families_table, $sources_table, $repositories_table, $citations_table, $nonames;
    global $people_table, $familygroup_url, $showsource_url, $showrepo_url, $placesearch_url, $trees_table;
    global $cemeteries_table;
    global $getperson_url, $livedefault, $wherestr2, $events_table, $eventtypes_table;

    if ($mediatypeID == "headstones") {
        $hsfields = ", $media_table.cemeteryID, cemname";
        $hsjoin = "LEFT JOIN $cemeteries_table cemeteries ON media.cemeteryID = cemeteries.cemeteryID ";
    } else {
        $hsfields = $hsjoin = "";
    }

    $query = "SELECT distinct media.mediaID AS mediaID, description, media.notes, thumbpath, path, form, mediatypeID, media.gedcom AS gedcom, alwayson, usecollfolder, DATE_FORMAT(changedate,'%a, %d %b %Y %T') AS changedatef, status, abspath, newwindow $hsfields ";
    $query .= "FROM $media_table media ";
    $query .= "$hsjoin";
    $query .= "WHERE $cutoffstr $wherestr AND mediatypeID = \"$mediatypeID\" ";
    $query .= "ORDER BY changedate DESC, description ";
    $query .= "LIMIT $change_limit";
    $mediaresult = tng_query($query);

    while ($row = tng_fetch_assoc($mediaresult)) {
        $query = "SELECT medialinkID, medialinks.personID AS personID, medialinks.eventID, people.personID AS personID2, familyID, people.living AS living, people.private AS private, people.branch AS branch, families.branch AS fbranch, families.living AS fliving, families.private AS fprivate, husband, wife, people.lastname AS lastname, people.lnprefix AS lnprefix, people.firstname AS firstname, people.suffix AS suffix, nameorder, medialinks.gedcom AS gedcom, treename, sources.title, sources.sourceID, repositories.repoID,reponame, deathdate, burialdate, linktype ";
        $query .= "FROM ($medialinks_table medialinks, $trees_table trees) ";
        $query .= "LEFT JOIN $people_table people ON (medialinks.personID = people.personID AND medialinks.gedcom = people.gedcom) ";
        $query .= "LEFT JOIN $families_table families ON (medialinks.personID = families.familyID AND medialinks.gedcom = families.gedcom) ";
        $query .= "LEFT JOIN $sources_table sources ON (medialinks.personID = sources.sourceID AND medialinks.gedcom = sources.gedcom) ";
        $query .= "LEFT JOIN $repositories_table repositories ON (medialinks.personID = repositories.repoID AND medialinks.gedcom = repositories.gedcom) ";
        $query .= "WHERE mediaID = \"{$row['mediaID']}\" AND medialinks.gedcom = trees.gedcom$wherestr2 ";
        $query .= "ORDER BY lastname, lnprefix, firstname, medialinks.personID";
        $presult = tng_query($query);
        $foundliving = 0;
        $foundprivate = 0;
        $hstext = "";
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

            $prow['allow_living'] = !$prow['living'] || $livedefault == 2;
            $prow['allow_private'] = !$prow['private'];

            if ($prow['living'] && $livedefault != 2) {
                $foundliving = 1;
            }
            if ($prow['private']) {
                $foundprivate = 1;
            }

            if ($prow['personID2'] != NULL) {
                $medialink = $getperson_url . "personID={$prow['personID2']}&amp;tree={$prow['gedcom']}";
                $mediatext = getName($prow);
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
                $medialink = $familygroup_url . "familyID={$prow['familyID']}&amp;tree={$prow['gedcom']}";
                $mediatext = "{$text['family']}: " . getFamilyName($prow);
            } elseif ($prow['sourceID'] != NULL) {
                $mediatext = $prow['title'] ? "{$text['source']}: {$prow['title']}" : "{$text['source']}: {$prow['sourceID']}";
                $medialink = $showsource_url . "sourceID={$prow['sourceID']}&amp;tree={$prow['gedcom']}";
            } elseif ($prow['repoID'] != NULL) {
                $mediatext = $prow['reponame'] ? $text['repository'] . ": " . $prow['reponame'] : $text['repository'] . ": " . $prow['repoID'];
                $medialink = $showrepo_url . "repoID={$prow['repoID']}&amp;tree={$prow['gedcom']}";
            } else {
                $medialink = $placesearch_url . "psearch={$prow['personID']}&amp;tree={$prow['gedcom']}";
                $mediatext = $prow['personID'];
            }
            if ($prow['eventID']) {
                $query = "SELECT description FROM $events_table, $eventtypes_table WHERE eventID = \"{$prow['eventID']}\" AND $events_table.eventtypeID = $eventtypes_table.eventtypeID";
                $eresult = tng_query($query) or die ("{$text['cannotexecutequery']}: $query");
                $erow = tng_fetch_assoc($eresult);
                $event = $erow['description'] ? $erow['description'] : $prow['eventID'];
                tng_free_result($eresult);
                $mediatext .= " ($event)";
            }
        }
        tng_free_result($presult);

        $href = getMediaHREF($row, 0);
        $href = str_replace("\" target=\"_blank", "", $href);  // fix the string in case someone might have used the "open in a new window" option on the media
        if ((!$foundliving && !$foundprivate) || !$nonames || $row['alwayson']) {
            $description = strip_tags($row['description']);
            $notes = nl2br(strip_tags(getXrefNotes($row['notes'], $row['gedcom'])));
            if (($foundliving || $foundprivate) && !$row['alwayson']) {
                $notes .= " ({$text['livingphoto']})";
            }
        } else {
            $description = $text['living'];
            $notes = "({$text['livingphoto']})";
        }

        if ($row['status']) {
            $notes = "{$text['status']}: {$row['status']}. $notes";
        }

        $item = "\n<item>\n"; // build the $item string so that you can apply string functions more globally instead of piece meal, as required

        $typestr = $text[$mediatypeID] ? $text[$mediatypeID] : $mediatypes_display[$mediatypeID];
        $item .= "<title>" . xmlcharacters($typestr) . ": " . xmlcharacters($description) . "</title>\n";
        $item .= "<link>" . "<![CDATA[" . ($row['abspath'] ? "" : "$tngdomain/") . "$href$langstr" . "]]>" . "</link>\n"; // use CDATA to deal with odd links that include special characters

        if ($mediatypeID == "headstones") {
            $deathdate = $row['deathdate'] ? $row['deathdate'] : $row['burialdate'];
            $item .= "<description>" . xmlcharacters($hstext . " " . htmlspecialchars($notes, ENT_NOQUOTES, $session_charset)) . "</description>\n";
            $item .= "<category>{$text['tree']}: " . xmlcharacters($trow['treename']) . "</category>\n";
        } else {
            $item .= "<description>" . xmlcharacters(htmlspecialchars($notes, ENT_NOQUOTES, $session_charset)) . "</description>\n";
        }
        $changedate = date_format(date_create($row['changedatef']), "D, d M Y H:i:s");
        $item .= "<pubDate>$changedate $timezone</pubDate>\n";

        $item .= "<guid isPermaLink=\"false\">$tngdomain/{$row['mediaID']}-$changedate $timezone</guid>\n"; // using a guid improves the granularity of changes one ca monitor (ie: it allows for a changes minitus appart to be captures by the RSS feed)
        $item .= "</item>\n";
        echo $item;
    }
    tng_free_result($mediaresult);
}

header("Content-type: application/rss+xml; charset=\"$charset\"");

$item .= "<rss version=\"2.0\" xmlns:atom=\"{$http}://www.w3.org/2005/Atom\">\n";
$item .= "<channel>\n";
$item .= "<atom:link href=\"" . $tngdomain . "/tngrss.php\" rel=\"self\" type=\"application/rss+xml\" />\n";

$tngscript = basename($_SERVER['SCRIPT_NAME'], ".php");

$item .= "<copyright>$tng_title, v.$tng_version ($tng_date), Written by Darrin Lythgoe, $tng_copyright</copyright>\n";
$item .= "<lastBuildDate>$date</lastBuildDate>\n";

//you will need to define $site_desc and $sitename in your customconfig.php file
//as of 6.0, these will come from config.php, but anything defined in customconfig.php will take precedence
$item .= "<description>" . xmlcharacters($site_desc) . "</description>\n";
if ($personID) {
    $item .= "<title>" . trim($sitename . " " . $text['indinfo']) . ": $personID</title>\n";
} elseif ($familyID) {
    $item .= "<title>" . trim($sitename . " " . $text['family']) . ": $familyID</title>\n";
} else {
    $item .= "<title>$sitename</title>\n";
}
$item .= "<link>$tngdomain</link>\n";
$item .= "<managingEditor>$emailaddr ($dbowner)</managingEditor>\n";
$item .= "<webMaster>$emailaddr ($dbowner)</webMaster>\n";
if ($rssimage) {                            // define $rssimage in your customconfig.php file this will allow you to put a logo on your feed once you have subscribed
    $item .= "<image>\n";
    $item .= "<url>" . $tngdomain . $rssimage . "</url>\n";     // path for the logo
    if ($personID) {
        $item .= "<title>" . trim($sitename . " " . $text['indinfo']) . ": $personID</title>\n";  // images require a title (match it with either the personID)
    } elseif ($familyID) {
        $item .= "<title>" . trim($sitename . " " . $text['family']) . ": $familyID</title>\n";    // the familyID
    } else {
        $item .= "<title>$sitename</title>\n";                      // or just the site name
    }
    $item .= "<link>" . $tngdomain . "</link>\n";                  // images also require the site link so that if you click on the image you go to the site
    $item .= "</image>\n";
}
echo $item;

//you will need to define $rsslang in your customconfig.php file before you can use this

$text['pastxdays'] = preg_replace("/xx/", "$change_cutoff", $text['pastxdays']);
if (!$change_cutoff) {
    $change_cutoff = 0;
}
if (!$change_limit) {
    $change_limit = 10;
}
$cutoffstr = $change_cutoff ? "TO_DAYS(NOW()) - TO_DAYS(changedate) <= $change_cutoff" : "1=1";

if (!$personID && !$familyID) {             // only feed the changes when not monitoring an person or a family
    initMediaTypes();
    foreach ($mediatypes as $mediatype) {
        $mediatypeID = $mediatype['ID'];
        doMedia($mediatypeID);
    }
}
$cutoffstr .= " AND";

if ($tree) {
    $allwhere = "AND people.gedcom = \"$tree\"";
} else {
    $allwhere = "";
}

$more = getLivingPrivateRestrictions("people", false, false);
if ($more) {
    $allwhere .= " AND " . $more;
}

if (!$familyID) {    // if a family is NOT specified (ie: we are looking for a personID or the What's New
//select from people where date later than cutoff, order by changedate descending, limit = 10
    $query = "SELECT people.personID, lastname, lnprefix, firstname, birthdate, prefix, suffix, nameorder, living, private, branch, DATE_FORMAT(changedate,'%e %b %Y') AS changedatef, changedby, LPAD(SUBSTRING_INDEX(birthdate, ' ', -1),4,'0') AS birthyear, birthplace, altbirthdate, LPAD(SUBSTRING_INDEX(altbirthdate, ' ', -1),4,'0') AS altbirthyear, altbirthplace, people.gedcom AS gedcom, treename ";
    $query .= "FROM $people_table people, $trees_table trees ";
    $query .= "WHERE $cutoffstr people.gedcom = trees.gedcom $allwhere ";
    $query .= "ORDER BY changedate DESC, lastname, firstname, birthyear, altbirthyear ";
    $query .= "LIMIT $change_limit";
    $result = tng_query($query);
    $numrows = tng_num_rows($result);
    if ($numrows) {
        while ($row = tng_fetch_assoc($result)) {
            $rights = determineLivingPrivateRights($row);
            $row['allow_living'] = $rights['living'];
            $row['allow_private'] = $rights['private'];
            $namestr = getNameRev($row);
            $birthplacestr = "";
            if ($rights['both']) {
                if ($row['birthdate']) {
                    $birthdate = $text['birthabbr'] . " " . displayDate($row['birthdate']);
                    $birthplace = $row['birthplace'];
                } else {
                    if ($row['altbirthdate']) {
                        $birthdate = $text['chrabbr'] . " " . displayDate($row['altbirthdate']);
                        $birthplace = $row['altbirthplace'];
                    } else {
                        $birthdate = "";
                        $birthplace = "";
                    }
                }
            } else {
                $birthdate = $birthplace = "";
            }

            $query = "SELECT gedcom, treename FROM $trees_table WHERE gedcom = \"{$row['gedcom']}\"";
            $treeresult = tng_query($query);
            $treerow = tng_fetch_assoc($treeresult);

            $item = "\n<item>\n";
            $item .= "<title>";
            $item .= xmlcharacters($text['indinfo'] . ": " . $namestr . " (" . $row['personID'] . ")");
            $item .= "</title>\n";
            $item .= "<link>" . "$tngdomain/$getperson_url" . "personID=" . $row['personID'] . "&amp;tree=" . $row['gedcom'] . $langstr . "</link>\n";
            $item .= "<description>";
            if ($birthdate || $birthplace) {
                $item .= xmlcharacters("$birthdate, $birthplace") . "</description>\n";
            } else {
                $item .= xmlcharacters($text['birthabbr']) . "</description>\n";
            }
            $item .= "<category>{$text['tree']}: " . xmlcharacters($treerow['treename']) . "</category>\n";
            $changedate = date_format(date_create($row['changedatef']), "D, d M Y H:i:s");
            $item .= "<pubDate>$changedate $timezone </pubDate>\n";
            $item .= "</item>\n";
            echo $item;
        }
        tng_free_result($result);
    }
}

if ($familyID) {
    $whereclause = "WHERE $families_table.familyID = '$familyID'$privacystr ORDER BY changedate LIMIT $change_limit";
} else {
    $whereclause = $change_cutoff ? "WHERE TO_DAYS(NOW()) - TO_DAYS($families_table.changedate) <= $change_cutoff$privacystr" : "WHERE 1=1$privacystr";
    $whereclause .= " ORDER BY changedate DESC LIMIT $change_limit";
}

if (!$personID) {
//select husband, wife from families where date later than cutoff, order by changedate descending, limit = 10
    $query = "SELECT familyID, husband, wife, marrdate, marrplace, gedcom, branch, living, private, DATE_FORMAT(changedate,'%a, %d %b %Y %T') AS changedatef FROM $families_table $whereclause";
    $famresult = tng_query($query);
    $numrows = tng_num_rows($famresult);
    if ($numrows) {
        while ($row = tng_fetch_assoc($famresult)) {
            $row['allow_living'] = $nonames == 2 && $row['living'] ? 0 : 1;
            $row['allow_private'] = $tngconfig['nnpriv'] == 2 && $row['private'] ? 0 : 1;
            $query = "SELECT gedcom, treename FROM $trees_table WHERE gedcom = \"{$row['gedcom']}\"";
            $treeresult = tng_query($query);
            $treerow = tng_fetch_assoc($treeresult);

            $item = "\n<item>\n";
            $item .= "<title>" . xmlcharacters($text['family'] . ": " . getFamilyName($row)) . "</title>\n";
            $item .= "<link>" . "$tngdomain/$familygroup_url" . "familyID={$row['familyID']}&amp;tree={$row['gedcom']}$langstr" . "</link>\n";
            $item .= "<description>";

            $item .= displayDate($row['marrdate']);
            if ($row['marrdate'] && $row['marrplace']) {
                $item .= ", ";
            }
            $item .= xmlcharacters($row['marrplace']);

            $item .= "</description>\n";
            $item .= "<category>{$text['tree']}: " . xmlcharacters($treerow['treename']) . "</category>\n";
            $item .= "<pubDate>" . displayDate($row['changedatef']) . " $timezone </pubDate>\n";
            $item .= "</item>\n";
            echo $item;
        }
        tng_free_result($famresult);
    }
}

echo "</channel>\n";
echo "</rss>\n";
