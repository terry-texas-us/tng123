<?php
include "begin.php";
include "adminlib.php";

$admin_login = 1;
include "checklogin.php";
require "adminlog.php";
require "datelib.php";

if (!$allow_add || ($assignedtree && $assignedtree != $tree)) exit;

include "deletelib.php";

//this line needed to prevent garbage chars in IS0-8859-2
header("Content-type:text/html; charset=" . $session_charset);
$personID = ucfirst(trim($personID));

if (!isset($baptplace)) $baptplace = "";
if (!isset($confplace)) $confplace = "";
if (!isset($initplace)) $initplace = "";
if (!isset($endlplace)) $endlplace = "";
if (!isset($altbirthdate)) $altbirthdate = "";
if (!isset($altbirthplace)) $altbirthplace = "";

if ($session_charset != "UTF-8") {
    $firstname = tng_utf8_decode($firstname);
    $lnprefix = tng_utf8_decode($lnprefix);
    $lastname = tng_utf8_decode($lastname);
    $nickname = tng_utf8_decode($nickname);
    $prefix = tng_utf8_decode($prefix);
    $suffix = tng_utf8_decode($suffix);
    $title = tng_utf8_decode($title);
    $birthplace = tng_utf8_decode($birthplace);
    $altbirthplace = tng_utf8_decode($altbirthplace);
    $deathplace = tng_utf8_decode($deathplace);
    $burialplace = tng_utf8_decode($burialplace);
    $baptplace = tng_utf8_decode($baptplace);
    $confplace = tng_utf8_decode($confplace);
    $initplace = tng_utf8_decode($initplace);
    $endlplace = tng_utf8_decode($endlplace);
}

if (!isset($baptdate)) $baptdate = "";
if (!isset($confdate)) $confdate = "";
if (!isset($initdate)) $initdate = "";
if (!isset($endldate)) $endldate = "";

$birthdatetr = convertDate($birthdate);
$altbirthdatetr = convertDate($altbirthdate);
$deathdatetr = convertDate($deathdate);
$burialdatetr = convertDate($burialdate);
$baptdatetr = convertDate($baptdate);
$confdatetr = convertDate($confdate);
$initdatetr = convertDate($initdate);
$endldatetr = convertDate($endldate);

$newdate = date("Y-m-d H:i:s", time() + (3600 * $time_offset));

$query = "SELECT personID FROM $people_table WHERE personID = '$personID' and gedcom = '$tree'";
$result = tng_query($query);

//delete all notes & citations linked to this person
deleteCitations($personID, $tree);
deleteEvents($personID, $tree);
deleteNoteLinks($personID, $tree);

if ($result && tng_num_rows($result)) {
    echo "{\"error\":\"" . _('Person') . " $personID " . _('could not be added because this ID already exists.') . "\"}";
} else {
    $places = [];
    if (trim($birthplace) && !in_array($birthplace, $places)) {
        array_push($places, $birthplace);
    }
    if (trim($altbirthplace) && !in_array($altbirthplace, $places)) {
        array_push($places, $altbirthplace);
    }
    if (trim($deathplace) && !in_array($deathplace, $places)) {
        array_push($places, $deathplace);
    }
    if (trim($burialplace) && !in_array($burialplace, $places)) {
        array_push($places, $burialplace);
    }
    if (trim($baptplace) && !in_array($baptplace, $places)) {
        array_push($places, $baptplace);
    }
    if (trim($confplace) && !in_array($confplace, $places)) {
        array_push($places, $confplace);
    }
    if (trim($initplace) && !in_array($initplace, $places)) {
        array_push($places, $initplace);
    }
    if (trim($endlplace) && !in_array($endlplace, $places)) {
        array_push($places, $endlplace);
    }
    $placetree = $tngconfig['places1tree'] ? "" : $tree;
    $template = "ssd";
    foreach ($places as $place) {
        $temple = strlen($place) == 5 && $place == strtoupper($place) ? 1 : 0;
        $query = "INSERT IGNORE INTO $places_table (gedcom, place, placelevel, zoom, geoignore, temple) VALUES (?, ?, '0', '0', '0', ?)";
        $params = [&$template, &$placetree, &$place, &$temple];
        tng_execute($query, $params);
    }

    if (is_array($branch)) {
        foreach ($branch as $b) {
            if ($b) $allbranches = $allbranches ? "$allbranches,$b" : $b;

        }
    } else {
        $allbranches = $branch;
    }
    if (!$allbranches) $allbranches = "";

    if (!$living) $living = 0;

    if (!$private) $private = 0;

    if (!$burialtype) $burialtype = 0;

    if ($type != "child") $familyID = "";

    $meta = metaphone($lnprefix . $lastname);
    $query = "INSERT INTO $people_table (personID,firstname,lnprefix,lastname,nickname,prefix,suffix,title,nameorder,living,private,birthdate,birthdatetr,birthplace,sex,altbirthdate,altbirthdatetr,
		altbirthplace,deathdate,deathdatetr,deathplace,burialdate,burialdatetr,burialplace,burialtype,baptdate,baptdatetr,baptplace,confdate,confdatetr,confplace,initdate,initdatetr,initplace,
		endldate,endldatetr,endlplace,changedate,gedcom,branch,changedby,famc,metaphone,edituser,edittime)
		VALUES(?, ?, ?, ?, ?, ?, ?, ?, '0', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '', '0')";
    $template = "ssssssssssssssssssssssssssssssssssssssssss";
    $params = [&$template, &$personID, &$firstname, &$lnprefix, &$lastname, &$nickname, &$prefix, &$suffix, &$title, &$living, &$private, &$birthdate, &$birthdatetr,
        &$birthplace, &$sex, &$altbirthdate, &$altbirthdatetr, &$altbirthplace, &$deathdate, &$deathdatetr, &$deathplace, &$burialdate, &$burialdatetr, &$burialplace,
        &$burialtype, &$baptdate, &$baptdatetr, &$baptplace, &$confdate, &$confdatetr, &$confplace, &$initdate, &$initdatetr, &$initplace, &$endldate, &$endldatetr, &$endlplace,
        &$newdate, &$tree, &$allbranches, &$currentuser, &$familyID, &$meta];
    tng_execute($query, $params);
    $ID = tng_insert_id();

    $query = "SELECT personID, lastname, firstname, lnprefix, birthdate, altbirthdate, prefix, suffix, nameorder FROM $people_table WHERE ID='$ID'";
    $result = tng_query($query);
    $row = tng_fetch_assoc($result);
    tng_free_result($result);

    $branchlist = explode(',', $allbranches);
    $template = "sss";
    foreach ($branchlist as $b) {
        $query = "INSERT IGNORE INTO $branchlinks_table (branch, gedcom, persfamID) VALUES(?, ?, ?)";
        $params = [&$template, &$b, &$tree, &$personID];
        tng_execute($query, $params);
    }

    $row['allow_living'] = $row['allow_private'] = 1;

    if ($type == "child") {
        if ($familyID) {
            $query = "SELECT personID FROM $children_table WHERE familyID='$familyID' AND gedcom='$tree'";
            $result = @tng_query($query);
            $order = tng_num_rows($result) + 1;
            tng_free_result($result);

            $query = "INSERT INTO $children_table (familyID,personID,ordernum,gedcom,frel,mrel,haskids,parentorder,sealdate,sealdatetr,sealplace) VALUES (?, ?, ?, ?, ?, ?, 0, 0, '', \"0000-00-00\", '')";
            $template = "ssisss";
            $params = [&$template, &$familyID, &$personID, &$order, &$tree, &$frel, &$mrel];
            tng_execute($query, $params);

            $query = "SELECT husband, wife FROM $families_table WHERE familyID='$familyID' AND gedcom='$tree'";
            $result = @tng_query($query);
            $famrow = tng_fetch_assoc($result);
            if ($famrow['husband']) {
                $query = "UPDATE $children_table SET haskids='1' WHERE personID = \"{$famrow['husband']}\" AND gedcom = '$tree'";
                $result2 = @tng_query($query);
            }
            if ($famrow['wife']) {
                $query = "UPDATE $children_table SET haskids='1' WHERE personID = \"{$famrow['wife']}\" AND gedcom = '$tree'";
                $result2 = @tng_query($query);
            }
            tng_free_result($result);
        }

        if ($row['birthdate']) {
            $birthdate = _('b.') . " " . $row['birthdate'];
        } else {
            if ($row['altbirthdate']) {
                $birthdate = _('c.') . " " . $row['altbirthdate'];
            } else {
                $birthdate = "";
            }
        }
        $rval = "<div class='sortrow' id=\"child_$personID\" style=\"width:500px;clear:both;display:none;\"";
        $rval .= " onmouseover=\"jQuery('#unlinkc_$personID').css('visibility','visible');\" onmouseout=\"jQuery('#unlinkc_$personID').css('visibility','hidden');\">\n";
        $rval .= "<table class='w-full' cellpadding='5' cellspacing='1'>";
        $rval .= "<tr>\n";
        $rval .= "<td class='dragarea rounded-lg normal'>";
        $rval .= "<img src='img/admArrowUp.gif' alt='' class='inline-block'>" . _('Drag') . "<img src='img/admArrowDown.gif' alt='' class='inline-block'>\n";
        $rval .= "</td>\n";
        $rval .= "<td class='lightback normal childblock'>\n";
        $name = getName($row);
        $rval .= "<div id=\"unlinkc_$personID\" class=\"smaller hide-right\"><a href='#' onclick=\"return unlinkChild('$personID','child_unlink');\">" . _('Unlink') . "</a> &nbsp; | &nbsp; <a href='#' onclick=\"return unlinkChild('$personID','child_delete');\">" . _('Delete') . "</a></div>";
        $rval .= "<a href='#' onclick=\"EditChild('$personID');\">" . $name . "</a> - $personID<br>$birthdate</div>\n</td>\n</tr>\n</table>\n</div>\n";
        echo $rval;
    } elseif ($type == "spouse") {
        $name = getName($row);
        $name = preg_replace("/\"/", "\\\"", $name);
        echo "{\"id\":\"{$row['personID']}\",\"name\":\"$name\"}";
    }
    adminwritelog("<a href=\"admin_editperson.php?personID=$personID&amp;tree=$tree\">" . _('Add New Person') . ": $tree/$personID</a>");
    if ($needped) {
        header("Location: pedigree.php?personID=$personID&tree=$tree");
    }
}
