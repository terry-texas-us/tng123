<?php
include "begin.php";
include "adminlib.php";

include "checklogin.php";

require "adminlog.php";

$query = "DELETE FROM $citations_table WHERE citationID = '$citationID'";
$result = @tng_query($query);

$query = "SELECT count(citationID) AS ccount FROM $citations_table WHERE gedcom='$tree' AND persfamID = '$personID' AND eventID = '$eventID'";
$result = tng_query($query);
$row = tng_fetch_assoc($result);
tng_free_result($result);

if ($_SESSION['lastcite'] == $tree . "|" . $citationID) {
    unset($_SESSION['lastcite']);
}

adminwritelog("" . _('Deleted') . ": " . _('Citation') . " $citationID");

echo $row['ccount'];

