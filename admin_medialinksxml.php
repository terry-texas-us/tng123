<?php

include "begin.php";
include "adminlib.php";
$textpart = "photos";
include "$mylanguage/admintext.php";

$admin_login = true;
include "checklogin.php";
if ($albumID) {
    $query2 = "SELECT entityID, gedcom FROM $album2entities_table WHERE gedcom = '$tree' AND albumID = \"$albumID\" AND linktype = \"$linktype\"";
} else {
    $query2 = "SELECT personID AS entityID, gedcom FROM $medialinks_table WHERE gedcom = '$tree' AND mediaID = \"$mediaID\" AND linktype = \"$linktype\"";
}
$result2 = tng_query($query2) or die ($admtext['cannotexecutequery'] . ": $query2");
$alreadygot = [];
while ($row2 = tng_fetch_assoc($result2))
    $alreadygot[] = $row2['entityID'];
tng_free_result($result2);

function showAction($entityID, $num = null) {
    global $alreadygot, $admtext, $albumID, $mediaID;

    $id = $num ? $num : $entityID;
    $lines = "<tr id=\"linkrow_$id\"><td class='lightback'>";
    $lines .= "<div id=\"link_$id\" class='normal' style=\"text-align:center;width:50px;";
    if ($albumID || $mediaID) {
        $gotit = in_array($entityID, $alreadygot);
        if ($gotit) {
            $lines .= "display:none";
        }
        $lines .= "\"><a href=\"#\" onclick=\"return addMedia2EntityLink(findform, '" . urlencode($entityID) . "', '$num');\">" . $admtext['add'] . "</a></div>";
        $lines .= "<div id=\"linked_$id\" style=\"text-align:center;width:50px;";
        if (!$gotit) {
            $lines .= "display:none";
        }
        $lines .= "\"><img src=\"img/tng_test.gif\" alt=\"\" width='20' height='20'>";
        $lines .= "<div id=\"sdef_" . urlencode($entityID) . "\"></div>";
    } else {
        $lines .= "\"><a href=\"#\" onclick=\"selectEntity(document.find.newlink1, '$id');\">" . $admtext['select'] . "</a>";
    }
    $lines .= "</div>";
    $lines .= "</td>";

    return $lines;
}

function doPeople($firstname, $lastname) {
    global $tree, $assignedbranch, $lnprefixes, $maxsearchresults, $admtext, $people_table;

    $lines = "<tr>\n";
    $lines .= "<td class=\"fieldnameback fieldname nw\" width=\"50\">&nbsp;<b>" . $admtext['select'] . "</b>&nbsp;</td>\n";
    $lines .= "<td class=\"fieldnameback fieldname nw\">&nbsp;<b>" . $admtext['personid'] . "</b>&nbsp;</td>\n";
    $lines .= "<td class=\"fieldnameback fieldname nw\">&nbsp;<b>" . $admtext['name'] . "</b>&nbsp;</td>\n";
    $lines .= "<td class=\"fieldnameback fieldname nw\">&nbsp;<b>" . $admtext['birthdate'] . "</b>&nbsp;</td>\n";
    $lines .= "<td class=\"fieldnameback fieldname nw\">&nbsp;<b>" . $admtext['deathdate'] . "</b>&nbsp;</td>\n";
    $lines .= "</tr>\n";

    $allwhere = "gedcom = \"$tree\"";
    if ($assignedbranch) {
        $allwhere .= " AND branch LIKE \"%$assignedbranch%\"";
    }
    if ($firstname) {
        $allwhere .= " AND firstname LIKE \"%$firstname%\"";
    }
    if ($lastname) {
        if ($lnprefixes) {
            $allwhere .= " AND CONCAT_WS(' ',lnprefix,lastname) LIKE \"%$lastname%\"";
        } else {
            $allwhere .= " AND lastname LIKE \"%$lastname%\"";
        }
    }

    $query = "SELECT personID, lastname, firstname, lnprefix, birthdate, altbirthdate, deathdate, burialdate, prefix, suffix, nameorder ";
    $query .= "FROM $people_table ";
    $query .= "WHERE {$allwhere} ";
    $query .= "ORDER BY lastname, lnprefix, firstname LIMIT {$maxsearchresults}";
    $result = tng_query($query);

    while ($row = tng_fetch_assoc($result)) {
        if ($row['birthdate']) {
            $birthdate = $admtext['birthabbr'] . " " . $row['birthdate'];
        } elseif ($row['altbirthdate']) {
            $birthdate = $admtext['chrabbr'] . " " . $row['altbirthdate'];
        } else {
            $birthdate = "";
        }

        if ($row['deathdate']) {
            $deathdate = $admtext['deathabbr'] . " " . $row['deathdate'];
        } elseif ($row['burialdate']) {
            $deathdate = $admtext['burialabbr'] . " " . $row['burial'];
        } else {
            $deathdate = "";
        }

        if (!$birthdate && $deathdate) {
            $birthdate = $admtext['nobirthinfo'];
        }
        $row['allow_living'] = 1;
        $name = getName($row);
        $jsnamestr = preg_replace("/&#34;/", "&lsquo;", addslashes("$name"));
        $lines .= showAction($row['personID']);
        $lines .= "<td class='lightback normal'>" . $row['personID'] . "&nbsp;</td>\n";
        $lines .= "<td class='lightback normal'>$name&nbsp;</td>\n";
        $lines .= "<td class='lightback normal'>$birthdate&nbsp;</td>\n";
        $lines .= "<td class='lightback normal'>$deathdate&nbsp;</td></tr>\n";
    }
    tng_free_result($result);

    return $lines;
}

function doFamilies($husbname, $wifename) {
    global $tree, $assignedbranch, $maxsearchresults, $admtext, $families_table, $people_table;

    $lines = "<tr>\n";
    $lines .= "<td class=\"fieldnameback fieldname nw\" width=\"50\">&nbsp;<b>" . $admtext['select'] . "</b>&nbsp;</td>\n";
    $lines .= "<td class=\"fieldnameback fieldname nw\">&nbsp;<b>" . $admtext['familyid'] . "</b>&nbsp;</td>\n";
    $lines .= "<td class=\"fieldnameback fieldname nw\">&nbsp;<b>" . $admtext['husbname'] . "</b>&nbsp;</td>\n";
    $lines .= "<td class=\"fieldnameback fieldname nw\">&nbsp;<b>" . $admtext['wifename'] . "</b>&nbsp;</td>\n";
    $lines .= "</tr>\n";

    $allwhere = "families.gedcom = \"$tree\"";
    $joinon = "";
    if ($assignedbranch) {
        $allwhere .= " AND families.branch LIKE \"%$assignedbranch%\"";
    }

    $allwhere2 = "";

    if ($wifename) {
        $terms = explode(' ', $wifename);
        foreach ($terms as $term) {
            if ($allwhere2) {
                $allwhere2 .= " AND ";
            }
            $allwhere2 .= "CONCAT_WS(' ',wifepeople.firstname,TRIM(CONCAT_WS(' ',wifepeople.lnprefix,wifepeople.lastname))) LIKE \"%$term%\"";
        }
    }

    if ($husbname) {
        $terms = explode(' ', $husbname);
        foreach ($terms as $term) {
            if ($allwhere2) {
                $allwhere2 .= " AND ";
            }
            $allwhere2 .= "CONCAT_WS(' ',husbpeople.firstname,TRIM(CONCAT_WS(' ',husbpeople.lnprefix,husbpeople.lastname))) LIKE \"%$term%\"";
        }
    }
    if ($allwhere2) {
        $allwhere2 = "AND $allwhere2";
    }

    $query = "SELECT familyID, wifepeople.personID AS wpersonID, wifepeople.firstname AS wfirstname, wifepeople.lnprefix AS wlnprefix, wifepeople.lastname AS wlastname, wifepeople.prefix AS wprefix, wifepeople.suffix AS wsuffix, wifepeople.nameorder AS wnameorder, husbpeople.personID AS hpersonID, husbpeople.firstname AS hfirstname, husbpeople.lnprefix AS hlnprefix, husbpeople.lastname AS hlastname, husbpeople.prefix AS hprefix, husbpeople.suffix AS hsuffix, husbpeople.nameorder AS hnameorder ";
    $query .= "FROM $families_table families ";
    $query .= "LEFT JOIN $people_table wifepeople ON families.wife = wifepeople.personID AND families.gedcom = wifepeople.gedcom ";
    $query .= "LEFT JOIN $people_table husbpeople ON families.husband = husbpeople.personID AND families.gedcom = husbpeople.gedcom ";
    $query .= "WHERE $allwhere $allwhere2 ";
    $query .= "ORDER BY hlastname, hlnprefix, hfirstname ";
    $query .= "LIMIT $maxsearchresults";
    $result = tng_query($query);

    while ($row = tng_fetch_assoc($result)) {
        $thishusb = $thiswife = "";
        $person['allow_living'] = 1;
        if ($row['hpersonID']) {
            $person['firstname'] = $row['hfirstname'];
            $person['lnprefix'] = $row['hlnprefix'];
            $person['lastname'] = $row['hlastname'];
            $person['prefix'] = $row['hprefix'];
            $person['suffix'] = $row['hsuffix'];
            $person['nameorder'] = $row['hnameorder'];
            $thishusb .= getName($person);
        }
        if ($row['wpersonID']) {
            $person['firstname'] = $row['wfirstname'];
            $person['lnprefix'] = $row['wlnprefix'];
            $person['lastname'] = $row['wlastname'];
            $person['prefix'] = $row['wprefix'];
            $person['suffix'] = $row['wsuffix'];
            $person['nameorder'] = $row['wnameorder'];
            $thiswife = getName($person);
        }
        $lines .= showAction($row['familyID']);
        $lines .= "<td class='lightback normal'>" . $row['familyID'] . "&nbsp;</td>\n";
        $lines .= "<td class='lightback normal'>$thishusb&nbsp;</td>\n";
        $lines .= "<td class='lightback normal'>$thiswife&nbsp;</td></tr>\n";
    }
    tng_free_result($result);

    return $lines;
}

function doSources($title) {
    global $tree, $sources_table, $maxsearchresults, $admtext;

    $lines = "<tr>\n";
    $lines .= "<td class=\"fieldnameback fieldname nw\" width=\"50\">&nbsp;<b>" . $admtext['select'] . "</b>&nbsp;</td>\n";
    $lines .= "<td class=\"fieldnameback fieldname nw\">&nbsp;<b>" . $admtext['sourceid'] . "</b>&nbsp;</td>\n";
    $lines .= "<td class=\"fieldnameback fieldname nw\">&nbsp;<b>" . $admtext['title'] . "</b>&nbsp;</td>\n";
    $lines .= "</tr>\n";

    $query = "SELECT sourceID, title FROM $sources_table WHERE gedcom = '$tree' AND title LIKE \"%$title%\" ORDER BY title LIMIT $maxsearchresults";
    $result = tng_query($query);

    while ($row = tng_fetch_assoc($result)) {
        $fixedtitle = addslashes($row['title']);
        $lines .= showAction($row['sourceID']);
        $lines .= "<td class='lightback normal'>" . $row['sourceID'] . "&nbsp;</td>\n";
        $lines .= "<td class='lightback normal'>" . $row['title'] . "&nbsp;</td></tr>\n";
    }
    tng_free_result($result);

    return $lines;
}

function doRepos($title) {
    global $tree, $repositories_table, $maxsearchresults, $admtext;

    $lines = "<tr>\n";
    $lines .= "<td class=\"fieldnameback fieldname nw\" width=\"50\">&nbsp;<b>" . $admtext['select'] . "</b>&nbsp;</td>\n";
    $lines .= "<td class=\"fieldnameback fieldname nw\">&nbsp;<b>" . $admtext['repoid'] . "</b>&nbsp;</td>\n";
    $lines .= "<td class=\"fieldnameback fieldname nw\">&nbsp;<b>" . $admtext['title'] . "</b>&nbsp;</td>\n";
    $lines .= "</tr>\n";

    $query = "SELECT repoID, reponame FROM $repositories_table WHERE gedcom = '$tree' AND reponame LIKE \"%$title%\" ORDER BY reponame LIMIT $maxsearchresults";
    $result = tng_query($query);

    while ($row = tng_fetch_assoc($result)) {
        $fixedtitle = addslashes($row['reponame']);
        $lines .= showAction($row['repoID']);
        $lines .= "<td class='lightback normal'>" . $row['repoID'] . "&nbsp;</td>\n";
        $lines .= "<td class='lightback normal'>" . $row['reponame'] . "&nbsp;</td></tr>\n";
    }
    tng_free_result($result);

    return $lines;
}

function doPlaces($place) {
    global $tree, $maxsearchresults, $admtext, $places_table;

    $lines = "<tr>\n";
    $lines .= "<td class=\"fieldnameback fieldname nw\" width=\"50\">&nbsp;<b>" . $admtext['select'] . "</b>&nbsp;</td>\n";
    $lines .= "<td class=\"fieldnameback fieldname nw\">&nbsp;<b>" . $admtext['place'] . "</b>&nbsp;</td>\n";
    $lines .= "</tr>\n";

    $allwhere = "gedcom = \"$tree\"";
    if ($place) {
        $allwhere .= " AND place LIKE \"%$place%\"";
    }
    $query = "SELECT ID, place FROM $places_table WHERE $allwhere ORDER BY place LIMIT $maxsearchresults";
    $result = tng_query($query);

    $num = 1;
    while ($row = tng_fetch_assoc($result)) {
        $lines .= showAction($row['place'], $num);
        $lines .= "<td class='lightback normal'>" . $row['place'] . "&nbsp;</td></tr>\n";
        $num++;
    }
    tng_free_result($result);

    return $lines;
}

$lines = "";
switch ($linktype) {
    case "I":
        if ($session_charset != "UTF-8") {
            $firstname = tng_utf8_decode($firstname);
            $lastname = tng_utf8_decode($lastname);
        }
        $lines = doPeople($firstname, $lastname);
        break;
    case "F":
        if ($session_charset != "UTF-8") {
            $husbname = tng_utf8_decode($husbname);
            $wifename = tng_utf8_decode($wifename);
        }
        $lines = doFamilies($husbname, $wifename);
        break;
    case "S":
        if ($session_charset != "UTF-8") {
            $title = tng_utf8_decode($title);
        }
        $lines = doSources($title);
        break;
    case "R":
        if ($session_charset != "UTF-8") {
            $title = tng_utf8_decode($title);
        }
        $lines = doRepos($title);
        break;
    case "L":
        if ($session_charset != "UTF-8") {
            $place = tng_utf8_decode($place);
        }
        $lines = doPlaces($place);
        break;
}

header("Content-type:text/html; charset=" . $session_charset);
echo "<table cellpadding=\"3\" cellspacing='1' border=\"0\" width=\"585\" class='normal'>\n$lines\n</table>\n";
