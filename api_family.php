<?php
include "begin.php";
include "genlib.php";
include "getlang.php";

include "api_checklogin.php";
include "personlib.php";
include "api_library.php";
include "log.php";

header("Content-Type: application/json; charset=" . $session_charset);

//get family
$query = "SELECT familyID, husband, wife, living, private, marrdate, gedcom, branch ";
$query .= "FROM $families_table ";
$query .= "WHERE familyID = \"{$familyID}\" AND gedcom = '$tree'";
$result = tng_query($query);
$famrow = tng_fetch_assoc($result);
if (!tng_num_rows($result)) {
    tng_free_result($result);
    echo "{\"error\":\"No one in database with that ID and tree\"}";
    exit;
} else {
    tng_free_result($result);
}

echo "{\n";

$righttree = checktree($tree);
$rightbranch = checkbranch($famrow['branch']);
$rights = determineLivingPrivateRights($famrow, $righttree, $rightbranch);
$row['allow_living'] = $rights['living'];
$row['allow_private'] = $rights['private'];

$famname = getFamilyName($famrow);
$namestr = _('Family') . ": " . $famname;

$logstring = "<a href=\"familygroup.php?familyID=$familyID&amp;tree=$tree\">" . _('Family Group Sheet for') . " $famname</a>";
writelog($logstring);

$family = "\"id\":\"{$famrow['familyID']}\",\"tree\":\"{$famrow['gedcom']}\"";
//get husband & spouses
if ($famrow['husband']) {
    $query = "SELECT * ";
    $query .= "FROM $people_table ";
    $query .= "WHERE personID = \"{$famrow['husband']}\" AND gedcom = '$tree'";
    $result = tng_query($query);
    $husbrow = tng_fetch_assoc($result);

    $hrights = determineLivingPrivateRights($husbrow, $righttree);
    $husbrow['allow_living'] = $hrights['living'];
    $husbrow['allow_private'] = $hrights['private'];

    $events = [];
    $family .= ",\"father\":{" . api_person($husbrow, $fullevents) . "}";
    tng_free_result($result);
}

//get wife & spouses
if ($famrow['wife']) {
    $query = "SELECT * ";
    $query .= "FROM $people_table ";
    $query .= "WHERE personID = \"{$famrow['wife']}\" AND gedcom = '$tree'";
    $result = tng_query($query);
    $wiferow = tng_fetch_assoc($result);

    $wrights = determineLivingPrivateRights($wiferow, $righttree);
    $wiferow['allow_living'] = $wrights['living'];
    $wiferow['allow_private'] = $wrights['private'];

    $events = [];
    $family .= ",\"mother\":{" . api_person($wiferow, $fullevents) . "}";
    tng_free_result($result);
}

$events = [];
if ($rights['both']) {
    setMinEvent(["date" => $famrow['marrdate'], "place" => $famrow['marrplace'], "event" => "MARR"], $famrow['marrdatetr']);
    setMinEvent(["date" => $famrow['divdate'], "place" => $famrow['divplace'], "event" => "DIV"], $famrow['divdatetr']);

    if ($fullevents && $rights['lds']) {
        setMinEvent(["date" => $famrow['sealdate'], "place" => $famrow['sealplace'], "event" => "SLGS"], $famrow['sealdatetr']);
    }

    if ($fullevents) doCustomEvents($familyID, "F");

}
$eventstr = processEvents($events);
if ($eventstr) $family .= "," . $eventstr;


//for each child
$query = "SELECT $people_table.personID AS personID, branch, firstname, lnprefix, lastname, prefix, suffix, nameorder, living, private, famc, sex, birthdate, birthplace,
	altbirthdate, altbirthplace, haskids, deathdate, deathplace, burialdate, burialplace, baptdate, baptplace, confdate, confplace, initdate, initplace, endldate, endlplace, sealdate, sealplace ";
$query .= "FROM $people_table people, {$children_table} children";
$query .= "WHERE people.personID = children.personID AND children.familyID = \"{$famrow['familyID']}\" AND people.gedcom = '$tree' AND children.gedcom = '$tree' ";
$query .= "ORDER BY ordernum";
$children = tng_query($query);

if ($children && tng_num_rows($children)) {
    $childcount = 0;
    $family .= ",\"children\":[";
    while ($childrow = tng_fetch_assoc($children)) {
        if ($childcount) $family .= ",";

        $childcount++;

        $crights = determineLivingPrivateRights($childrow, $righttree);
        $childrow['allow_living'] = $crights['living'];
        $childrow['allow_private'] = $crights['private'];

        $events = [];
        $family .= "{" . api_person($childrow, $fullevents) . "}";
    }
    $family .= "]";
}
tng_free_result($children);

echo $family;

echo "}";
