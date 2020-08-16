<?php
include("begin.php");
include("adminlib.php");
$textpart = "sources";
include("$mylanguage/admintext.php");

include("checklogin.php");

require("datelib.php");
require("adminlog.php");

if (!$allow_add) {
  $message = $admtext['norights'];
  exit;
}

if ($session_charset != "UTF-8") {
  $citepage = tng_utf8_decode($citepage);
  $citetext = tng_utf8_decode($citetext);
  $citenote = tng_utf8_decode($citenote);
}

/*
if (get_magic_quotes_gpc() == 0) {
	$citedate = addslashes($citedate);
	$citepage = addslashes($citepage);
	$citetext = addslashes($citetext);
	$citenote = addslashes($citenote);
}
*/

$citedatetr = convertDate($citedate);
$sourceID = strtoupper($sourceID);

$template = "ssssssssss";
$query = "INSERT INTO $citations_table (gedcom, persfamID, eventID, sourceID, page, quay, citedate, citedatetr, citetext, note, description, ordernum)  
	VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?,'', 999)";
$params = array(&$template, &$tree, &$persfamID, &$eventID, &$sourceID, &$citepage, &$quay, &$citedate, &$citedatetr, &$citetext, &$citenote);
tng_execute($query, $params);
$citationID = tng_insert_id();

$_SESSION['lastcite'] = $tree . "|" . $citationID;

adminwritelog($admtext['addnewcite'] . ": $citationID/$tree/$persfamID/$eventID/$sourceID");

$query = "SELECT title FROM $sources_table WHERE sourceID = \"$sourceID\" AND gedcom = \"$tree\"";
$result = tng_query($query);
$row = tng_fetch_assoc($result);

$citationsrc = "[$sourceID] " . $row['title'];
$citationsrc = cleanIt($citationsrc);
$truncated = truncateIt($citationsrc, 75);
header("Content-type:text/html; charset=" . $session_charset);
echo "{\"id\":\"$citationID\",\"persfamID\":\"$persfamID\",\"tree\":\"$tree\",\"eventID\":\"$eventID\",\"display\":\"$truncated\",\"allow_edit\":$allow_edit,\"allow_delete\":$allow_delete}";
