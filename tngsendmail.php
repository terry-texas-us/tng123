<?php
include "begin.php";
$tngconfig['maint'] = "";
include "genlib.php";
$textpart = "gedcom";
include "getlang.php";
include "$mylanguage/text.php";

if ($enttype) include "checklogin.php";

include "config/logconfig.php";
include "tngmaillib.php";

$valid_user_agent = isset($_SERVER["HTTP_USER_AGENT"]) && $_SERVER["HTTP_USER_AGENT"] != "";

$emailfield = $_SESSION['tng_email'];
eval("\$youremail = \$$emailfield;");
$_SESSION['tng_email'] = "";

$commentsfield = $_SESSION['tng_comments'];
eval("\$comments = \$$commentsfield;");
$_SESSION['tng_comments'] = "";

$yournamefield = $_SESSION['tng_yourname'];
eval("\$yourname = \$$yournamefield;");
$_SESSION['tng_yourname'] = "";

$tngwebsite = $tngdomain;

if (preg_match("/\n[[:space:]]*(to|bcc|cc|boundary)[[:space:]]*[:|=].*@/i", $youremail) || preg_match("/[\r|\n][[:space:]]*(to|bcc|cc|boundary)[[:space:]]*[:|=].*@/", $yourname) || !$valid_user_agent) {
    die("sorry!");
}
if (preg_match("/\r/", $youremail) || preg_match("/\n/", $youremail) || preg_match("/\r/", $yourname) || preg_match("/\n/", $yourname)) {
    die("sorry!");
}

$youremail = strtok($youremail, ",; ");
if (!$youremail || !$comments || !$yourname) {
    die("sorry!");
}

if ($addr_exclude) {
    $bad_addrs = explode(",", $addr_exclude);
    foreach ($bad_addrs as $bad_addr) {
        if ($bad_addr) {
            if (strstr($youremail, trim($bad_addr))) {
                die("sorry");
            }
        }
    }
}

if ($msg_exclude) {
    $bad_msgs = explode(",", $msg_exclude);
    foreach ($bad_msgs as $bad_msg) {
        if ($bad_msg) {
            if (stristr($comments, trim($bad_msg))) {
                die("sorry");
            }
        }
    }
}

if ($enttype == "I") {
    $typestr = "person";
    $query = "SELECT firstname, lnprefix, lastname, prefix, suffix, sex, nameorder, living, private, branch, disallowgedcreate, IF(birthdatetr !='0000-00-00',YEAR(birthdatetr),YEAR(altbirthdatetr)) AS birth, IF(deathdatetr !='0000-00-00',YEAR(deathdatetr),YEAR(burialdatetr)) AS death ";
    $query .= "FROM $people_table people, $trees_table trees ";
    $query .= "WHERE personID = '$ID' AND people.gedcom = '$tree' AND people.gedcom = trees.gedcom";
    $result = tng_query($query);
    $row = tng_fetch_assoc($result);

    $righttree = checktree($tree);
    $rights = determineLivingPrivateRights($row, $righttree);
    $row['allow_living'] = $rights['living'];
    $row['allow_private'] = $rights['private'];

    $name = getName($row) . " ($ID)";
    $pagelink = "$tngwebsite/getperson.php?personID=$ID&tree=$tree";
    tng_free_result($result);
} elseif ($enttype == "F") {
    $typestr = "family";
    $query = "SELECT familyID, husband, wife, living, private, marrdate, gedcom, branch FROM $families_table WHERE familyID = '$ID' AND gedcom = '$tree'";
    $result = tng_query($query);
    $row = tng_fetch_assoc($result);

    $righttree = checktree($tree);
    $rights = determineLivingPrivateRights($row, $righttree);
    $row['allow_living'] = $rights['living'];
    $row['allow_private'] = $rights['private'];

    $name = $text['family'] . ": " . getFamilyName($row);
    $pagelink = "$tngwebsite/familygroup.php?familyID=$ID&tree=$tree";
    tng_free_result($result);
} elseif ($enttype == "S") {
    $query = "SELECT title FROM $sources_table WHERE sourceID = '$ID' AND gedcom = '$tree'";
    $result = tng_query($query);
    $row = tng_fetch_assoc($result);
    $name = $text['source'] . ": {$row['title']} ($ID)";
    $pagelink = "$tngwebsite/showsource.php?sourceID=$ID&tree=$tree";
    tng_free_result($result);
} elseif ($enttype == "R") {
    $query = "SELECT reponame FROM $repositories_table WHERE repoID = '$ID' AND gedcom = '$tree'";
    $result = tng_query($query);
    $row = tng_fetch_assoc($result);
    $name = $text['repository'] . ": {$row['reponame']} ($ID)";
    $pagelink = "$tngwebsite/showrepo.php?repoID=$ID&tree=$tree";
    tng_free_result($result);
} elseif ($enttype == "L") {
    $name = $ID;
    if ($tree && !$tngconfig['places1tree']) {
        $treestr = "tree=$tree&amp;";
    } else {
        $treestr = "";
    }
    $pagelink = "$tngwebsite/placesearch.php{$treestr}psearch=" . urlencode($name);
}
if ($enttype) {
    $subject = $text['proposed'] . ": $name";
    $query = "SELECT treename, email, owner FROM $trees_table WHERE gedcom='$tree'";
    $treeresult = tng_query($query);
    $treerow = tng_fetch_assoc($treeresult);
    tng_free_result($treeresult);

    $body = $text['proposed'] . ": $name\n{$text['tree']}: {$treerow['treename']}\n{$text['link']}: $pagelink\n\n{$text['description']}: " . stripslashes($comments) . "\n\n$yourname\n$youremail";

    $sendemail = $treerow['email'] ? $treerow['email'] : $emailaddr;
    $owner = $treerow['owner'] ? $treerow['owner'] : ($sitename ? $sitename : $dbowner);
} else {
    $page = $page ? " ($page)" : "";
    $subject = $text['comments2'] . $page;
    $body = $text['comments2'] . $page . ": " . stripslashes($comments) . "\n\n$yourname\n$youremail";

    $sendemail = $emailaddr;
    $owner = $sitename ? $sitename : $dbowner;
}
if ($currentuser) {
    $body .= "\n{$text['user']}: $currentuserdesc ($currentuser)";
}
$emailtouse = $tngconfig['fromadmin'] == 1 ? $emailaddr : $youremail;

$success = tng_sendmail($yourname, $emailtouse, $owner, $sendemail, $subject, $body, $emailaddr, $youremail);
$message = $success ? "mailsent" : $message = "mailnotsent&sowner=" . urlencode($owner) . "&ssendemail=" . urlencode($sendemail);

header("Location: suggest.php?enttype=$enttype&ID=$ID&tree=$tree&message=$message");
