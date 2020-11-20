<?php
include "begin.php";
include "adminlib.php";

include "checklogin.php";
if (!$allow_add || ($assignedtree && $assignedtree != $tree)) exit;

require "adminlog.php";

if ($session_charset != "UTF-8") $note = tng_utf8_decode($note);

$orgnote = preg_replace("/$lineending/", " ", stripslashes($note));

$template = "ss";
$query = "INSERT INTO $xnotes_table (noteID, gedcom, note)  VALUES('', ?, ?)";
$params = [&$template, &$tree, &$note];
tng_execute($query, $params);
$xnoteID = tng_insert_id();

if (!$private) $private = "0";

$template = "sssss";
$query = "INSERT INTO $notelinks_table (persfamID, gedcom, xnoteID, eventID, secret, ordernum) VALUES (?, ?, ?, ?, ?, 999)";
$params = [&$template, &$persfamID, &$tree, &$xnoteID, &$eventID, &$private];
tng_execute($query, $params);
$ID = tng_insert_id();

adminwritelog(_('Add New Note') . ": $tree/$persfamID/$xnoteID/$eventID");

$orgnote = cleanIt($orgnote);
$truncated = truncateIt($orgnote, 75);
header("Content-type:text/html; charset=" . $session_charset);
echo "{\"id\":\"$ID\",\"persfamID\":\"$persfamID\",\"tree\":\"$tree\",\"eventID\":\"$eventID\",\"display\":\"$truncated\",\"allow_edit\":$allow_edit,\"allow_delete\":$allow_delete}";
