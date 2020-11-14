<?php
include "begin.php";
include "adminlib.php";
$textpart = "families";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
$tree = $tree1;
if (!$allow_add || ($assignedtree && $assignedtree != $tree)) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

require "adminlog.php";
require "datelib.php";

include "geocodelib.php";
include "deletelib.php";

$familyID = ucfirst(trim($familyID));
setcookie("tng_tree", $tree, 0);

if (!isset($sealdate)) $sealdate = "";
if (!isset($sealplace)) $sealplace = "";

if ($newfamily == "ajax" && $session_charset != "UTF-8") {
    $marrplace = tng_utf8_decode($marrplace);
    $divplace = tng_utf8_decode($divplace);
    $sealplace = tng_utf8_decode($sealplace);
    $marrtype = tng_utf8_decode($marrtype);
}

$marrdatetr = convertDate($marrdate);
$divdatetr = convertDate($divdate);
$sealdatetr = convertDate($sealdate);

$newdate = date("Y-m-d H:i:s", time() + (3600 * $time_offset));

$query = "SELECT familyID FROM $families_table WHERE familyID = '$familyID' AND gedcom = '$tree'";
$result = tng_query($query);

if ($result && tng_num_rows($result)) {
    $message = _('Family') . " $familyID " . _('could not be added because this ID already exists.');
    header("Location: admin_families.php?message=$message");
    exit;
}

//delete all notes, citations & children linked to this person
deleteCitations($familyID, $tree);
deleteEvents($familyID, $tree);
deleteNoteLinks($familyID, $tree);
deleteChildren($familyID, $tree);

$places = [];
if (trim($marrplace) && !in_array($marrplace, $places)) {
    array_push($places, $marrplace);
}
if (trim($divplace) && !in_array($divplace, $places)) {
    array_push($places, $divplace);
}
if (trim($sealplace) && !in_array($sealplace, $places)) {
    array_push($places, $sealplace);
}
$placetree = $tngconfig['places1tree'] ? "" : $tree;
$template = "sss";
foreach ($places as $place) {
    $temple = strlen($place) == 5 && $place == strtoupper($place) ? 1 : 0;
    $query = "INSERT IGNORE INTO $places_table (gedcom, place, placelevel, zoom, geoignore, temple) ";
    $query .= "VALUES (?, ?, '0', '0', '0', ?)";
    $params = [&$template, &$placetree, &$place, &$temple];
    tng_execute($query, $params);
    if ($tngconfig['autogeo'] && tng_affected_rows()) {
        $ID = tng_insert_id();
        $message = geocode($place, 0, $ID);
    }
}

//get living from husband, wife
$husband = ucfirst(trim($husband));
if ($husband) {
    $spquery = "SELECT living FROM $people_table WHERE personID = \"$husband\" AND gedcom = '$tree'";
    $spouselive = tng_query($spquery) or die (_('Cannot execute query') . ": $spquery");
    $spouserow = tng_fetch_assoc($spouselive);
    $husbliving = $spouserow['living'];

    $query = "SELECT husborder FROM $families_table WHERE gedcom = '$tree' AND husband = \"$husband\" ORDER BY husborder DESC";
    $husbresult = tng_query($query);
    $husbrow = tng_fetch_assoc($husbresult);
    tng_free_result($husbresult);

    $husborder = $husbrow['husborder'] + 1;
} else {
    $husbliving = 0;
    $husborder = 0;
}

$wife = ucfirst(trim($wife));
if ($wife) {
    $spquery = "SELECT living FROM $people_table WHERE personID = \"$wife\" AND gedcom = '$tree'";
    $spouselive = tng_query($spquery) or die (_('Cannot execute query') . ": $spquery");
    $spouserow = tng_fetch_assoc($spouselive);
    $wifeliving = $spouserow['living'];

    $query = "SELECT wifeorder FROM $families_table WHERE gedcom = '$tree' AND wife = \"$wife\" ORDER BY wifeorder DESC";
    $wiferesult = tng_query($query);
    $wiferow = tng_fetch_assoc($wiferesult);
    tng_free_result($wiferesult);
    $wifeorder = $wiferow['wifeorder'] + 1;
} else {
    $wifeliving = 0;
    $wifeorder = 0;
}
$familyliving = ($living || $husbliving || $wifeliving) ? 1 : 0;
if (!$private) $private = 0;
if (is_array($branch)) {
    foreach ($branch as $b) {
        if ($b) $allbranches = $allbranches ? "$allbranches,$b" : $b;

    }
} else {
    $allbranches = $branch;
}
if (!$allbranches) $allbranches = "";

$query = "INSERT INTO $families_table (familyID,husband,husborder,wife,wifeorder,living,private,marrdate,marrdatetr,marrplace,marrtype,divdate,divdatetr,divplace,sealdate,sealdatetr,sealplace,changedate,gedcom,branch,changedby,status,edituser,edittime) 
	VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '', '', '0')";
$template = "sssssssssssssssssssss";
$params = [&$template, &$familyID, &$husband, &$husborder, &$wife, &$wifeorder, &$familyliving, &$private, &$marrdate, &$marrdatetr, &$marrplace, &$marrtype, &$divdate, &$divdatetr,
    &$divplace, &$sealdate, &$sealdatetr, &$sealplace, &$newdate, &$tree, &$allbranches, &$currentuser];
tng_execute($query, $params);

$branchlist = explode(',', $allbranches);
$template = "sss";
foreach ($branchlist as $b) {
    $query = "INSERT IGNORE INTO $branchlinks_table (branch,gedcom,persfamID) VALUES(?, ?, ?)";
    $params = [&$template, &$b, &$tree, &$familyID];
    tng_execute($query, $params);
}

if ($lastperson) {
    $haskids = getHasKids($tree, $lastperson);

    $template = "sssi";
    $query = "INSERT INTO $children_table (familyID, personID, ordernum, gedcom, mrel, frel, haskids, parentorder, sealdate, sealdatetr, sealplace) ";
    $query .= "VALUES (?, ?, 1, ?, '', '', ?, 0, '', \"0000-00-00\", '')";
    $params = [&$template, &$familyID, &$lastperson, &$tree, &$haskids];
    tng_execute($query, $params);

    $template = "ss";
    if ($husband) {
        $query = "UPDATE $children_table SET haskids='1' WHERE personID = ? AND gedcom = ?";
        $params = [&$template, &$husband, &$tree];
        tng_execute($query, $params);
    }
    if ($wife) {
        $query = "UPDATE $children_table SET haskids='1' WHERE personID = ? AND gedcom = ?";
        $params = [&$template, &$wife, &$tree];
        tng_execute($query, $params);
    }

    $template = "sss";
    $query = "UPDATE $people_table SET famc=? WHERE personID = ? AND gedcom = ?";
    $params = [&$template, &$familyID, &$lastperson, &$tree];
    tng_execute($query, $params);
}

adminwritelog("<a href=\"admin_editfamily.php?familyID=$familyID&amp;tree=$tree\">" . _('Add New Family') . ": $tree/$familyID</a>");

if ($newfamily == "ajax") {
    echo "1";
} else {
    header("Location: admin_editfamily.php?familyID=$familyID&tree=$tree&cw=$cw&added=1");
}
