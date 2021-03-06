<?php
include "begin.php";
include "genlib.php";

include_once "tngdblib.php";
include "checklogin.php";
include "tngmaillib.php";

if ($session_charset != "UTF-8") {
    $newplace = tng_utf8_decode($newplace);
    $newinfo = tng_utf8_decode($newinfo);
    $usernote = tng_utf8_decode($usernote);
}
$postdate = date("Y-m-d H:i:s", time() + (3600 * $time_offset));
$query = "INSERT INTO $temp_events_table (type,gedcom,personID,familyID,eventID,eventdate,eventplace,info,note,user,postdate) VALUES (\"$type\",'$tree',\"$personID\",'$familyID',\"$eventID\",\"$newdate\",\"$newplace\",\"$newinfo\",\"$usernote\",\"$currentuser\",\"$postdate\")";
$result = tng_query($query);

$righttree = checktree($tree);

if ($tngconfig['revmail']) {
    if ($personID) {
        $result = getPersonSimple($tree, $personID);
        $namerow = tng_fetch_assoc($result);
        $rights = determineLivingPrivateRights($namerow, $righttree);
        $namerow['allow_living'] = $rights['living'];
        $namerow['allow_private'] = $rights['private'];
        $namestr = getName($namerow) . " ($personID)";
        tng_free_result($result);
    } else {
        $result = getFamilyData($tree, $familyID);
        $frow = tng_fetch_assoc($result);
        $hname = $wname = "";
        $frights = determineLivingPrivateRights($frow, $righttree);
        $frow['allow_living'] = $frights['living'];
        $frow['allow_private'] = $frights['private'];
        if ($frow['husband']) {
            $presult = getPersonSimple($tree, $frow['husband']);
            $prow = tng_fetch_assoc($presult);
            tng_free_result($presult);
            $prights = determineLivingPrivateRights($prow, $righttree);
            $prow['allow_living'] = $prights['living'];
            $prow['allow_private'] = $prights['private'];
            $hname = getName($prow);
        }
        if ($frow['wife']) {
            $presult = getPersonSimple($tree, $frow['wife']);
            $prow = tng_fetch_assoc($presult);
            tng_free_result($presult);
            $prights = determineLivingPrivateRights($prow, $righttree);
            $prow['allow_living'] = $prights['living'];
            $prow['allow_private'] = $prights['private'];
            $wname = getName($prow);
        }
        tng_free_result($result);

        $persfamID = $familyID;
        $plus = $hname && $wname ? " + " : "";
        $namestr = _('Family') . ": $hname$plus$wname ($familyID)";
    }
    $query = "SELECT treename, email, owner FROM $trees_table WHERE gedcom='$tree'";
    $treeresult = tng_query($query);
    $treerow = tng_fetch_assoc($treeresult);
    $sendemail = $treerow['email'] ? $treerow['email'] : $emailaddr;
    $owner = $treerow['owner'] ? $treerow['owner'] : ($sitename ? $sitename : $dbowner);
    tng_free_result($treeresult);

    $message = "" . _('You have a suggested change that needs your review. This submission concerns:') . "\n\n$namestr\n" . _('User') . ": $currentuser\n\n" . _('Administration') . ": $tngdomain/admin.php";
    tng_sendmail("TNG", $emailaddr, $owner, $sendemail, _('Suggested change needs your review'), $message, $emailaddr, $emailaddr);
}
echo 1;

