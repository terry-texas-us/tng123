<?php
$query = "DELETE FROM $people_table WHERE gedcom = '$tree'";
$result = tng_query($query);

$query = "DELETE FROM $families_table WHERE gedcom = '$tree'";
$result = tng_query($query);

$query = "DELETE FROM $children_table WHERE gedcom = '$tree'";
$result = tng_query($query);

$query = "DELETE FROM $assoc_table WHERE gedcom = '$tree'";
$result = tng_query($query);

$query = "DELETE FROM $address_table WHERE gedcom = '$tree'";
$result = tng_query($query);

$query = "DELETE FROM $sources_table WHERE gedcom = '$tree'";
$result = tng_query($query);

$query = "DELETE FROM $repositories_table WHERE gedcom = '$tree'";
$result = tng_query($query);

$query = "DELETE FROM $events_table WHERE gedcom = '$tree'";
$result = tng_query($query);

$query = "DELETE FROM $notelinks_table WHERE gedcom = '$tree'";
$result = tng_query($query);

$query = "DELETE FROM $xnotes_table WHERE gedcom = '$tree'";
$result = tng_query($query);

$query = "DELETE FROM $citations_table WHERE gedcom = '$tree'";
$result = tng_query($query);

$query = "DELETE FROM $places_table WHERE gedcom = '$tree'";
$result = tng_query($query);

if ($tree) {
    $query = "SELECT mediaID FROM $media_table WHERE gedcom = '$tree'";
    $result = tng_query($query);
    while ($row = tng_fetch_assoc($result)) {
        $delquery = "DELETE FROM $albumlinks_table WHERE mediaID=\"{$row['mediaID']}\"";
        $delresult = tng_query($delquery) or die (_('Cannot execute query') . ": $delquery");
    }
    tng_free_result($result);

    $query = "DELETE FROM $media_table WHERE gedcom = '$tree'";
    $result = tng_query($query);

    $query = "DELETE FROM $medialinks_table WHERE gedcom = '$tree'";
    $result = tng_query($query);
}

$query = "UPDATE $people_table SET branch=\"\" WHERE gedcom = '$tree' AND branch = '$branch'";
$result = tng_query($query);

$query = "UPDATE $families_table SET branch=\"\" WHERE gedcom = '$tree' AND branch = '$branch'";
$result = tng_query($query);

$query = "DELETE FROM $branchlinks_table WHERE branch = '$branch' AND gedcom = '$tree'";
$result = tng_query($query);

