<?php

include "begin.php";
include "adminlib.php";
$textpart = "sources";
include "$mylanguage/admintext.php";

define("MODAL_FIND_RESULTS_LIMIT", 100);

include "checklogin.php";
if ($session_charset != "UTF-8") {
    $criteria = tng_utf8_decode($criteria);
    $myffirstname = tng_utf8_decode($myffirstname);
    $myflastname = tng_utf8_decode($myflastname);
    $myhusbname = tng_utf8_decode($myhusbname);
    $mywifename = tng_utf8_decode($mywifename);
}

$criteria = trim($criteria);
$f = $filter == "c" ? "%" : "";

header("Content-type:text/html; charset=" . $session_charset);

$mediaquery = "";
if (!isset($albumID)) $albumID = "";
if (!isset($mediaID)) $mediaID = "";

if ($albumID) {
    $mediaquery = "SELECT entityID, gedcom FROM $album2entities_table WHERE gedcom = '$tree' AND albumID = \"$albumID\" AND linktype = \"$type\"";
} else {
    if ($mediaID) {
        $mediaquery = "SELECT personID AS entityID, gedcom FROM $medialinks_table WHERE gedcom = '$tree' AND mediaID = \"$mediaID\" AND linktype = \"$type\"";
    }
}

if ($mediaquery) {
    $result2 = tng_query($mediaquery) or die ($admtext['cannotexecutequery'] . ": $mediaquery");
    $alreadygot = [];
    while ($row2 = tng_fetch_assoc($result2))
        $alreadygot[] = $row2['entityID'];
    tng_free_result($result2);
}

function showAction($entityID, $num = null) {
    global $alreadygot, $admtext, $albumID, $mediaID;

    $id = $num ? $num : $entityID;
    $lines = "<td class='lightback'>";
    $lines .= "<div id=\"link_$id\" class='normal' style=\"text-align:center;width:50px;";
    if ($albumID || $mediaID) {
        $gotit = in_array($entityID, $alreadygot);
        if ($gotit) {
            $lines .= "display:none";
        }
        $lines .= "\"><a href='#' onclick=\"return addMedia2EntityLink(findform, '" . str_replace("&#39;", "\\'", $entityID) . "', '$num');\">" . $admtext['add'] . "</a></div>";
        $lines .= "<div id=\"linked_$id\" style=\"text-align:center;width:50px;";
        if (!$gotit) {
            $lines .= "display:none";
        }
        $lines .= "\"><img src=\"img/tng_test.gif\" alt=\"\" width='20' height='20'>";
        $lines .= "<div id=\"sdef_" . urlencode($entityID) . "\"></div>";
    } else {
        $lines .= "\"><a href='#' onclick=\"selectEntity(document.find.newlink1, '$id');\">" . $admtext['select'] . "</a>";
    }
    $lines .= "</div>";
    $lines .= "</td>\n";

    return $lines;
}

$selectline = $mediaID || $albumID ? "<td class=\"fieldnameback fieldname nw\" width=\"50\">&nbsp;<b>" . $admtext['select'] . "</b>&nbsp;</td>\n" : "";

switch ($type) {
    case "I":
        $myffirstname = trim($myffirstname);
        $myflastname = trim($myflastname);
        $myfpersonID = trim($myfpersonID);
        $allwhere = "gedcom = '$tree'";
        if ($branch) {
            $allwhere .= " AND branch LIKE \"%$branch%\"";
        }
        if ($myfpersonID) {
            $myfpersonID = strtoupper($myfpersonID);
            if ($f != "%" && substr($myfpersonID, 0, 1) != $tngconfig['personprefix']) {
                $myfpersonID = $tngconfig['personprefix'] . $myfpersonID;
            }
            $allwhere .= " AND personID LIKE \"$f$myfpersonID%\"";
        }
        if ($myffirstname) {
            $allwhere .= " AND firstname LIKE \"$f" . trim($myffirstname) . "%\"";
        }
        if ($myflastname) {
            if ($lnprefixes) {
                $allwhere .= " AND TRIM(CONCAT_WS(' ',lnprefix,lastname)) LIKE \"$f" . trim($myflastname) . "%\"";
            } else {
                $allwhere .= " AND lastname LIKE \"$f" . trim($myflastname) . "%\"";
            }
        }

        $more = getLivingPrivateRestrictions("", $myffirstname, false);

        if ($more) {
            if ($allwhere) {
                $allwhere = $tree ? "$allwhere AND " : "($allwhere) AND ";
            }
            $allwhere .= $more;
        }

        $query = "SELECT personID, lastname, firstname, lnprefix, birthdate, altbirthdate, deathdate, burialdate, prefix, suffix, nameorder, living, private, branch, gedcom ";
        $query .= "FROM $people_table ";
        $query .= "WHERE $allwhere ";
        $query .= "ORDER BY lastname, lnprefix, firstname ";
        $query .= "LIMIT " . MODAL_FIND_RESULTS_LIMIT;
        $result = tng_query($query);

        if (tng_num_rows($result)) {
            $lines = "<tr>\n";
            $lines .= $selectline;
            $lines .= "<th class=\"fieldnameback fieldname nw\">" . $admtext['personid'] . "</th>\n";
            $lines .= "<th class=\"fieldnameback fieldname nw\">" . $admtext['name'] . "</th>\n";
            $lines .= "<th class=\"fieldnameback fieldname nw\">" . $admtext['birthdate'] . "</th>\n";
            $lines .= "<th class=\"fieldnameback fieldname nw\">" . $admtext['deathdate'] . "</th>\n";
            $lines .= "</tr>\n";

            while ($row = tng_fetch_assoc($result)) {
                $birthdate = $deathdate = "";
                $rights = determineLivingPrivateRights($row);
                $row['allow_living'] = $rights['living'];
                $row['allow_private'] = $rights['private'];

                if ($rights['both']) {
                    if ($row['birthdate']) {
                        $birthdate = "{$admtext['birthabbr']} " . displayDate($row['birthdate']);
                    } else {
                        if ($row['altbirthdate']) {
                            $birthdate = "{$admtext['chrabbr']} " . displayDate($row['altbirthdate']);
                        }
                    }
                    if ($row['deathdate']) {
                        $deathdate = "{$admtext['deathabbr']} " . displayDate($row['deathdate']);
                    } else {
                        if ($row['burialdate']) {
                            $deathdate = "{$admtext['burialabbr']} " . displayDate($row['burialdate']);
                        }
                    }
                    if (!$birthdate && $deathdate) {
                        $birthdate = $admtext['nobirthinfo'];
                    }
                }
                $namestr = getName($row);
                $lines .= "<tr id=\"linkrow_{$row['personID']}\">\n";
                if ($mediaquery) {
                    $lines .= showAction($row['personID']);
                }
                $lines .= "<td class='lightback'>{$row['personID']}</td>\n";
                $lines .= "<td class='lightback'><a href='#' onclick=\"return retItem('{$row['personID']}');\" id=\"item_{$row['personID']}\">$namestr</a></td>\n";
                $lines .= "<td class='lightback'><span id=\"birth_{$row['personID']}\">$birthdate</span></td>\n";
                $lines .= "<td class='lightback'>$deathdate</td>\n";
                $lines .= "</tr>\n";
            }
        }
        break;
    case "F":
        $myhusbname = trim($myhusbname);
        $mywifename = trim($mywifename);
        $myfamilyID = trim($myfamilyID);
        $allwhere = "families.gedcom = '$tree'";
        if ($branch) {
            $allwhere .= " AND families.branch LIKE '%$branch%'";
        }
        if ($myfamilyID) {
            $myfamilyID = strtoupper($myfamilyID);
            if ($f != "%" && substr($myfamilyID, 0, 1) != $tngconfig['familyprefix']) {
                $myfamilyID = $tngconfig['familyprefix'] . $myfamilyID;
            }
            $allwhere .= " AND familyID LIKE '%$myfamilyID%'";
        }
        $joinon = "";
        if ($assignedbranch) {
            $allwhere .= " AND families.branch LIKE '%$assignedbranch%'";
        }

        $allwhere2 = "";

        if ($mywifename) {
            $terms = explode(' ', $mywifename);
            foreach ($terms as $term) {
                if ($allwhere2) {
                    $allwhere2 .= " AND ";
                }
                $allwhere2 .= "CONCAT_WS(' ',wifepeople.firstname,TRIM(CONCAT_WS(' ',wifepeople.lnprefix,wifepeople.lastname))) LIKE \"$f$term%\"";
            }
        }
        if ($myhusbname) {
            $terms = explode(' ', $myhusbname);
            foreach ($terms as $term) {
                if ($allwhere2) {
                    $allwhere2 .= " AND ";
                }
                $allwhere2 .= "CONCAT_WS(' ',husbpeople.firstname,TRIM(CONCAT_WS(' ',husbpeople.lnprefix,husbpeople.lastname))) LIKE \"$f$term%\"";
            }
        }
        if ($allwhere2) {
            $allwhere2 = "AND $allwhere2";
        }

        $query = "SELECT familyID, wifepeople.personID AS wpersonID, wifepeople.firstname AS wfirstname, wifepeople.lnprefix AS wlnprefix, wifepeople.lastname AS wlastname, wifepeople.suffix AS wsuffix, wifepeople.nameorder AS wnameorder, wifepeople.living AS wliving, wifepeople.private AS wprivate, wifepeople.branch AS wbranch, husbpeople.personID AS hpersonID, husbpeople.firstname AS hfirstname, husbpeople.lnprefix AS hlnprefix, husbpeople.lastname AS hlastname, husbpeople.suffix AS hsuffix, husbpeople.nameorder AS hnameorder, husbpeople.living AS hliving, husbpeople.private AS hprivate, husbpeople.branch AS hbranch ";
        $query .= "FROM $families_table families ";
        $query .= "LEFT JOIN $people_table wifepeople ON families.wife = wifepeople.personID AND families.gedcom = wifepeople.gedcom ";
        $query .= "LEFT JOIN $people_table husbpeople ON families.husband = husbpeople.personID AND families.gedcom = husbpeople.gedcom ";
        $query .= "WHERE $allwhere $allwhere2 ";
        $query .= "ORDER BY hlastname, hlnprefix, hfirstname ";
        $query .= "LIMIT " . MODAL_FIND_RESULTS_LIMIT;
        $result = tng_query($query);

        if (tng_num_rows($result)) {
            $lines = "<tr>\n";
            $lines .= $selectline;
            $lines .= "<th class=\"fieldnameback fieldname nw\">" . $admtext['familyid'] . "</th>\n";
            $lines .= "<th class=\"fieldnameback fieldname nw\">" . $admtext['husbname'] . "</th>\n";
            $lines .= "<th class=\"fieldnameback fieldname nw\">" . $admtext['wifename'] . "</th>\n";
            $lines .= "</tr>\n";

            while ($row = tng_fetch_assoc($result)) {
                $thishusb = $thiswife = "";
                if ($row['hpersonID']) {
                    $person['firstname'] = $row['hfirstname'];
                    $person['lnprefix'] = $row['hlnprefix'];
                    $person['lastname'] = $row['hlastname'];
                    $person['suffix'] = $row['hsuffix'];
                    $person['nameorder'] = $row['hnameorder'];
                    $person['living'] = $row['hliving'];
                    $person['private'] = $row['hprivate'];
                    $person['branch'] = $row['hbranch'];
                    $rights = determineLivingPrivateRights($person);
                    $person['allow_living'] = $rights['living'];
                    $person['allow_private'] = $rights['private'];
                    $thishusb = getName($person);
                }
                if ($row['wpersonID']) {
                    if ($thisfamily) {
                        $thisfamily .= "<br>";
                    }
                    $person['firstname'] = $row['wfirstname'];
                    $person['lnprefix'] = $row['wlnprefix'];
                    $person['lastname'] = $row['wlastname'];
                    $person['suffix'] = $row['wsuffix'];
                    $person['nameorder'] = $row['wnameorder'];
                    $person['living'] = $row['wliving'];
                    $person['private'] = $row['wprivate'];
                    $person['branch'] = $row['wbranch'];
                    $rights = determineLivingPrivateRights($person);
                    $person['allow_living'] = $rights['living'];
                    $person['allow_private'] = $rights['private'];
                    $thiswife = getName($person);
                }
                $lines .= "<tr id=\"linkrow_{$row['familyID']}\">\n";
                if ($mediaquery) {
                    $lines .= showAction($row['familyID']);
                }
                $lines .= "<td class='lightback'>" . $row['familyID'] . "</td>\n";
                $lines .= "<td class='lightback'><a href='#' onclick=\"return retItem('{$row['familyID']}');\" id=\"item_{$row['familyID']}\">$thishusb</a></td>\n";
                $lines .= "<td class='lightback'>$thiswife</td></tr>\n";
            }
        }
        break;
    case "S":
        $query = "SELECT sourceID, title, shorttitle ";
        $query .= "FROM $sources_table ";
        $query .= "WHERE gedcom = '$tree' AND (title LIKE \"$f$criteria%\" OR shorttitle LIKE \"$f$criteria%\") ";
        $query .= "ORDER BY title ";
        $query .= "LIMIT " . MODAL_FIND_RESULTS_LIMIT;
        $result = tng_query($query);

        if (tng_num_rows($result)) {
            $lines = "<tr>\n";
            $lines .= $selectline;
            $lines .= "<th class=\"fieldnameback fieldname nw\" style=\"width:100px;\">" . $admtext['sourceid'] . "</th>\n";
            $lines .= "<th class=\"fieldnameback fieldname nw\">" . $admtext['title'] . "</th>\n";
            $lines .= "</tr>\n";

            while ($row = tng_fetch_assoc($result)) {
                $lines .= "<tr id=\"linkrow_{$row['sourceID']}\">\n";
                if ($mediaquery) {
                    $lines .= showAction($row['sourceID']);
                }
                $lines .= "<td class='lightback'>" . $row['sourceID'] . "</td>\n";
                $title = $row['title'] ? $row['title'] : $row['shorttitle'];
                $lines .= "<td class='lightback'><a href='#' onclick=\"return retItem('{$row['sourceID']}');\" id=\"item_{$row['sourceID']}\">" . truncateIt($title, 100) . "</a></td>\n";
                $lines .= "</tr>\n";
            }
        }
        break;
    case "C":
        //get citations, joined with sources
        //display title, plus cite ID fields
        //return citation ID
        $query = "SELECT citationID, title, shorttitle, persfamID, citations.sourceID, eventID, page ";
        $query .= "FROM $citations_table citations, $sources_table sources ";
        $query .= "WHERE citations.gedcom = '$tree' AND citations.gedcom = sources.gedcom AND citations.sourceID = sources.sourceID AND (title LIKE \"$f$criteria%\" OR shorttitle LIKE \"$f$criteria%\") ";
        $query .= "ORDER BY title, shorttitle ";
        $query .= "LIMIT " . MODAL_FIND_RESULTS_LIMIT;
        $result = tng_query($query);

        if (tng_num_rows($result)) {
            $lines = "<tr>\n";
            $lines .= $selectline;
            $lines .= "<th class=\"fieldnameback fieldname nw\" style=\"width:100px;\">" . $admtext['id'] . "</th>\n";
            $lines .= "<th class=\"fieldnameback fieldname nw\">" . $admtext['sourceid'] . "</th>\n";
            $lines .= "<th class=\"fieldnameback fieldname nw\">" . $admtext['title'] . "</th>\n";
            $lines .= "<th class=\"fieldnameback fieldname nw\">" . $admtext['page'] . "</th>\n";
            $lines .= "<th class=\"fieldnameback fieldname nw\">" . $admtext['personid'] . "/" . $admtext['familyid'] . "</th>\n";
            $lines .= "<th class=\"fieldnameback fieldname nw\">" . $admtext['event'] . "</th>\n";
            $lines .= "</tr>\n";

            while ($row = tng_fetch_assoc($result)) {
                $lines .= "<tr id=\"linkrow_{$row['citationID']}\">\n";
                if ($mediaquery) {
                    $lines .= showAction($row['citationID']);
                }
                $lines .= "<td class='lightback'>" . $row['citationID'] . "</td>\n";
                $title = $row['title'] ? $row['title'] : $row['shorttitle'];
                $lines .= "<td class='lightback'>" . $row['sourceID'] . "</td>\n";
                $lines .= "<td class='lightback'><a href='#' onclick=\"return retItem('{$row['citationID']}');\" id=\"item_{$row['citationID']}\">" . truncateIt($title, 100) . "</a></td>\n";
                $lines .= "<td class='lightback'>" . $row['page'] . "</td>\n";
                $lines .= "<td class='lightback'>" . $row['persfamID'] . "</td>\n";
                $lines .= "<td class='lightback'>" . $row['eventID'] . "</td>\n";
                $lines .= "</tr>\n";
            }
        }
        break;
    case "R":
        $query = "SELECT repoID, reponame FROM $repositories_table WHERE gedcom = '$tree' AND reponame LIKE \"$f$criteria%\" ORDER BY reponame LIMIT " . MODAL_FIND_RESULTS_LIMIT;
        $result = tng_query($query);

        if (tng_num_rows($result)) {
            $lines = "<tr>\n";
            $lines .= $selectline;
            $lines .= "<td class=\"fieldnameback fieldname nw\" style=\"width:100px;\">" . $admtext['repoid'] . "</td>\n";
            $lines .= "<td class=\"fieldnameback fieldname nw\">" . $admtext['title'] . "</td>\n";
            $lines .= "</tr>\n";

            while ($row = tng_fetch_assoc($result)) {
                $lines .= "<tr id=\"linkrow_{$row['repoID']}\">\n";
                if ($mediaquery) {
                    $lines .= showAction($row['repoID']);
                }
                $lines .= "<td class='lightback'>" . $row['repoID'] . "</td>\n";
                $lines .= "<td class='lightback'><a href='#' onclick=\"return retItem('{$row['repoID']}');\" id=\"item_{$row['repoID']}\">" . truncateIt($row['reponame'], 75) . "</a></td>\n";
                $lines .= "</tr>\n";
            }
        }
        break;
    case "L":
        $allwhere = $tree && !$tngconfig['places1tree'] ? "gedcom = '$tree'" : "1=1";
        if ($criteria) {
            $allwhere .= " AND place LIKE \"$f$criteria%\"";
        }
        if ($temple) {
            $allwhere .= " AND temple = 1";
        }
        $query = "SELECT ID, place, temple, notes FROM $places_table WHERE $allwhere ORDER BY place LIMIT " . MODAL_FIND_RESULTS_LIMIT;
        $result = tng_query($query);

        if (tng_num_rows($result)) {
            $lines = "<tr>\n";
            $lines .= $selectline;
            $lines .= "<td class=\"fieldnameback fieldname nw\">" . $admtext['place'] . "</td>\n";
            $lines .= "</tr>\n";

            $num = 1;
            while ($row = tng_fetch_assoc($result)) {
                $row['place'] = preg_replace("/'/", "&#39;", $row['place']);
                $notes = $row['temple'] && $row['notes'] ? " (" . truncateIt($row['notes'], 75) . ")" : "";
                $place_slashed = addslashes(preg_replace("/[^A-Za-z0-9]/", "_", $row['place']));
                $lines .= "<tr id=\"linkrow_{$row['ID']}\">\n";
                if ($mediaquery) {
                    $lines .= showAction($row['place'], $num);
                }
                $lines .= "<td class='lightback'><a href='#' onclick='return retItem(\"{$row['ID']}\",true);' class=\"rplace\" id=\"item_{$row['ID']}\">{$row['place']}</a>$notes</td>\n";
                $lines .= "</tr>\n";
                $num++;
            }
        }
        break;
}

if (tng_num_rows($result)) {
    echo "<table class='normal w-100'>\n$lines\n</table>\n";
} else {
    echo $admtext['noresults'];
}

tng_free_result($result);
