<?php
include "begin.php";
include "adminlib.php";

$admin_login = 1;
include "checklogin.php";
$error_pfx = $ajax ? "error:" : "";

$tree = $tree1;
if (!$allow_add || ($assignedtree && $assignedtree != $tree)) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    if ($ajax) {
        echo $error_pfx . $message;
    } else {
        header("Location: admin_login.php?message=" . urlencode($message));
    }
    exit;
}

require "adminlog.php";

$sourceID = ucfirst($sourceID);
setcookie("tng_tree", $tree, 0);

if ($session_charset != "UTF-8") {
    $shorttitle = tng_utf8_decode($shorttitle);
    $title = tng_utf8_decode($title);
    $author = tng_utf8_decode($author);
    $callnum = tng_utf8_decode($callnum);
    $publisher = tng_utf8_decode($publisher);
    $actualtext = tng_utf8_decode($actualtext);
}

$newdate = date("Y-m-d H:i:s", time() + (3600 * $time_offset));

if (!$repoID) $repoID = 0;

$template = "sssssssssss";
$query = "INSERT INTO $sources_table (sourceID,shorttitle,title,author,callnum,publisher,repoID,actualtext,changedate,gedcom,changedby,type,other,comments) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '', '', '')";
$params = [&$template, &$sourceID, &$shorttitle, &$title, &$author, &$callnum, &$publisher, &$repoID, &$actualtext, &$newdate, &$tree1, &$currentuser];
$affected_rows = tng_execute_noerror($query, $params);
if ($affected_rows == 1) {
    adminwritelog("<a href=\"admin_editsource.php?sourceID=$sourceID&amp;tree=$tree\">" . _('Add New Source') . ": $tree/$sourceID</a>");
} else {
    die ($error_pfx . _('Cannot execute query') . ": $query");
}
if (isset($ajax)) {
    echo $sourceID;
} else {
    header("Location: admin_editsource.php?sourceID=$sourceID&tree=$tree&added=1");
}
