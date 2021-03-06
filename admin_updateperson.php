<?php
include "begin.php";
include "adminlib.php";

include "checklogin.php";
require "adminlog.php";
require "datelib.php";

include "geocodelib.php";

$query = "SELECT branch, edituser, edittime FROM $people_table WHERE personID = \"$personID\" and gedcom = '$tree'";
$result = tng_query($query);
$row = tng_fetch_assoc($result);
tng_free_result($result);

if ((!$allow_edit && (!$allow_add || !$added)) || ($assignedtree && $assignedtree != $tree) || !checkbranch($row['branch'])) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

$editconflict = determineConflict($row, $people_table);

if (!$editconflict) {
    if ($newfamily == "ajax" && $session_charset != "UTF-8") {
        $firstname = tng_utf8_decode($firstname);
        $lastname = tng_utf8_decode($lastname);
        $lnprefix = tng_utf8_decode($lnprefix);
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

    $firstname = addslashes($firstname);
    $lastname = addslashes($lastname);
    $lnprefix = addslashes($lnprefix);
    $nickname = addslashes($nickname);
    $prefix = addslashes($prefix);
    $suffix = addslashes($suffix);
    $title = addslashes($title);
    $birthplace = addslashes($birthplace);
    $altbirthplace = addslashes($altbirthplace);
    $deathplace = addslashes($deathplace);
    $burialplace = addslashes($burialplace);
    $baptplace = addslashes($baptplace);
    $confplace = addslashes($confplace);
    $initplace = addslashes($initplace);
    $endlplace = addslashes($endlplace);

    $birthdatetr = convertDate($birthdate);
    $altbirthdatetr = convertDate($altbirthdate);
    $deathdatetr = convertDate($deathdate);
    $burialdatetr = convertDate($burialdate);
    $baptdatetr = convertDate($baptdate);
    $confdatetr = convertDate($confdate);
    $initdatetr = convertDate($initdate);
    $endldatetr = convertDate($endldate);

    $newdate = date("Y-m-d H:i:s", time() + (3600 * $time_offset));

    if (is_array($branch)) {
        foreach ($branch as $b) {
            if ($b) $allbranches = $allbranches ? "$allbranches,$b" : $b;

        }
    } else {
        $allbranches = $branch;
        $branch = [$branch];
    }

    if ($allbranches != $orgbranch) {
        $oldbranches = explode(",", $orgbranch);
        foreach ($oldbranches as $b) {
            if ($b && !in_array($b, $branch)) {
                $query = "DELETE FROM $branchlinks_table WHERE persfamID = \"$personID\" AND gedcom = '$tree' AND branch = \"$b\"";
                $result = tng_query($query);
            }
        }
        foreach ($branch as $b) {
            if ($b && !in_array($b, $oldbranches)) {
                $query = "INSERT IGNORE INTO $branchlinks_table (branch,gedcom,persfamID) VALUES(\"$b\",'$tree',\"$personID\")";
                $result = tng_query($query);
            }
        }
    }

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
    if (trim($confplace) && !in_array($conftplace, $places)) {
        array_push($places, $confplace);
    }
    if (trim($initplace) && !in_array($initplace, $places)) {
        array_push($places, $initplace);
    }
    if (trim($endlplace) && !in_array($endlplace, $places)) {
        array_push($places, $endlplace);
    }
    $placetree = $tngconfig['places1tree'] ? "" : $tree;
    foreach ($places as $place) {
        $query = "INSERT IGNORE INTO $places_table (gedcom,place,placelevel,zoom,geoignore) VALUES (\"$placetree\",\"$place\",'0','0','0')";
        $result = @tng_query($query) or die (_('Cannot execute query') . ": $query");
        if ($tngconfig['autogeo'] && tng_affected_rows()) {
            $ID = tng_insert_id();
            $message = geocode($place, 0, $ID);
        }
    }

    $query = "SELECT familyID FROM $children_table WHERE personID = \"$personID\" AND gedcom = '$tree' ORDER BY parentorder";
    $parents = tng_query($query);

    $famc = "";
    if ($parents && tng_num_rows($parents)) {
        while ($parent = tng_fetch_assoc($parents)) {
            eval("\$sealpdate = \$sealpdate{$parent['familyID']};");
            eval("\$sealpplace = \$sealpplace{$parent['familyID']};");
            $sealplace = addslashes($sealplace);
            eval("\$sealpdatetr = convertdate( \$sealpdate{$parent['familyID']} );");
            eval("\$frel = \$frel{$parent['familyID']};");
            eval("\$mrel = \$mrel{$parent['familyID']};");
            $query = "UPDATE $children_table SET sealdate=\"$sealpdate\", sealdatetr=\"$sealpdatetr\", sealplace=\"$sealpplace\", frel=\"$frel\", mrel=\"$mrel\" WHERE familyID = \"{$parent['familyID']}\" AND personID = \"$personID\" AND gedcom = '$tree'";
            $result2 = @tng_query($query);
            if (!$famc) $famc = $parent['familyID'];

        }
        tng_free_result($parents);
    }
    $famcstr = $famc ? ", famc = \"$famc\"" : "";
    if (!$living) $living = 0;
    if (!$private) $private = 0;
    if (!$burialtype) $burialtype = 0;
    $meta = metaphone($lnprefix . $lastname);
    $query = "UPDATE $people_table SET firstname=\"$firstname\", lnprefix=\"$lnprefix\", lastname=\"$lastname\", nickname=\"$nickname\", prefix=\"$prefix\", suffix=\"$suffix\", title=\"$title\", nameorder=\"$pnameorder\",
                 living=\"$living\", private=\"$private\", birthdate=\"$birthdate\", birthdatetr=\"$birthdatetr\", birthplace=\"$birthplace\", sex=\"$sex\", altbirthdate=\"$altbirthdate\", altbirthdatetr=\"$altbirthdatetr\",
                 altbirthplace=\"$altbirthplace\", deathdate=\"$deathdate\", deathdatetr=\"$deathdatetr\", deathplace=\"$deathplace\", burialdate=\"$burialdate\", burialdatetr=\"$burialdatetr\", burialplace=\"$burialplace\",
                 burialtype=\"$burialtype\", baptdate=\"$baptdate\", baptdatetr=\"$baptdatetr\", baptplace=\"$baptplace\", confdate=\"$confdate\", confdatetr=\"$confdatetr\", confplace=\"$confplace\", initdate=\"$initdate\",
                 initdatetr=\"$initdatetr\", initplace=\"$initplace\", endldate=\"$endldate\", endldatetr=\"$endldatetr\", endlplace=\"$endlplace\", changedate=\"$newdate\",branch=\"$allbranches\",changedby=\"$currentuser\",
                 edituser=\"\",edittime='0',metaphone=\"$meta\" $famcstr WHERE personID='$personID' AND gedcom = '$tree'";
    $result = tng_query($query);

    if ($sex == "M") {
        $self = "husband";
        $spouseorder = "husborder";
    } else {
        if ($sex == "F") {
            $self = "wife";
            $spouseorder = "wifeorder";
        } else {
            $self = "";
            $spouseorder = "";
        }
    }

    if ($self) {
        $query = "SELECT familyID, husband, wife FROM $families_table WHERE $families_table.$self = \"$personID\" AND gedcom = '$tree' ORDER BY $spouseorder";
    } else {
        $query = "SELECT familyID, husband, wife FROM $families_table WHERE ($families_table.husband = \"$personID\" OR $families_table.wife = \"$personID\") AND gedcom = '$tree'";
    }
    $marriages = tng_query($query);

    if ($marriages && tng_num_rows($marriages)) {
        while ($marriagerow = tng_fetch_assoc($marriages)) {
            if ($personID == $marriagerow['husband']) {
                $spquery = "SELECT living, private FROM $people_table WHERE personID = \"{$marriagerow['wife']}\" AND gedcom = '$tree'";
            } else {
                if ($personID == $marriagerow['wife']) {
                    $spquery = "SELECT living, private FROM $people_table WHERE personID = \"{$marriagerow['husband']}\" AND gedcom = '$tree'";
                } else {
                    $spquery = "";
                }
            }
            if ($spquery) {
                $spouselive = tng_query($spquery) or die (_('Cannot execute query') . ": $spquery");
                $spouserow = tng_fetch_assoc($spouselive);
                $spouseliving = $spouserow['living'];
                $spouseprivate = $spouserow['private'];
            } else {
                $spouseliving = $spouseprivate = 0;
            }
            $familyliving = ($living || $spouseliving) ? 1 : 0;
            $familyprivate = ($private || $spouseprivate) ? 1 : 0;

            $query = "UPDATE $families_table SET living = \"$familyliving\", private = \"$familyprivate\" WHERE familyID = \"{$marriagerow['familyID']}\" AND gedcom = '$tree'";
            $spouseresult = @tng_query($query);
        }
    }

    adminwritelog("<a href=\"admin_editperson.php?personID=$personID&tree=$tree\">" . _('Edit Existing Person') . ": $tree/$personID</a>");
} else {
    $message = _('Changes were not saved. Another user has locked the record.');
}

if ($media == "1") {
    header("Location: admin_newmedia.php?personID=$personID&tree=$tree&linktype=I&cw=$cw");
} elseif ($newfamily == "none") {
    $message = _('Changes to person') . " $personID " . _('were successfully saved') . ".";
    header("Location: admin_people.php?message=" . urlencode($message));
} elseif ($newfamily == "return") {
    header("Location: admin_editperson.php?personID=$personID&tree=$tree&cw=$cw");
} elseif ($newfamily == "child") {
    header("Location: admin_newfamily.php?child=$personID&tree=$tree&cw=$cw");
} elseif ($newfamily == "close") {
    ?>
    <!doctype html>
    <html lang="en">

    <body>
    <script>
        top.close();
    </script>
    </body>
    </html>
    <?php
} elseif ($newfamily == "ajax") {
    $row = [
        'personID' => $personID,
        'firstname' => $firstname,
        'lastname' => $lastname,
        'lnprefix' => $lnprefix,
        'prefix' => $prefix,
        'suffix' => $suffix,
        'title' => $title,
        'nameorder' => $pnameorder,
        'living' => $living,
        'private' => $private,
        'branch' => $allbranches,
        'allow_living' => 1
    ];
    $name = $session_charset == "UTF-8" ? getName($row) : utf8_encode(getName($row));
    echo "{\"id\":\"$personID\",\"name\":\"" . $name . "\"}";
} else {
    header("Location: admin_newfamily.php?$self=$personID&tree=$tree&cw=$cw");
}
?>