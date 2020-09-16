<?php
include "begin.php";
include "adminlib.php";
$textpart = "notes";
include "$mylanguage/admintext.php";

include "checklogin.php";

require "adminlog.php";

if ($noteID) {
  $query = "DELETE FROM $citations_table WHERE eventID = \"{$tngconfig['noteprefix']}$noteID{$tngconfig['notesuffix']}\"";
  $result = @tng_query($query);
}

deleteNote($noteID, 1);

$query = "SELECT count(ID) AS ncount FROM $notelinks_table WHERE gedcom='$tree' AND persfamID = '$personID' AND eventID = '$eventID'";
$result = tng_query($query);
$row = tng_fetch_assoc($result);
tng_free_result($result);

adminwritelog($admtext['deleted'] . ": {$admtext['note']} $noteID");

echo $row['ncount'];

