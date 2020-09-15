<?php
function ClearData($tree) {
    global $people_table, $families_table, $children_table, $sources_table, $events_table, $repositories_table, $trees_table;
    global $notelinks_table, $xnotes_table, $citations_table, $places_table, $address_table, $assoc_table, $admtext;

    $clear_files = [$address_table, $assoc_table, $children_table, $citations_table, $families_table, $notelinks_table, $people_table, $repositories_table, $sources_table, $xnotes_table];

    $query = "SELECT COUNT(*) AS trees FROM $trees_table";
    if (!($result = tng_query($query))) {
        die ($admtext['cannotexecutequery'] . ": $query");
    }

    $row = tng_fetch_assoc($result);
    $tree_cnt = $row['trees'];

    for ($i = 0; $i < sizeof($clear_files); $i++) {
        $query = (($tree_cnt >= 2) ? "DELETE FROM " : "TRUNCATE ") . $clear_files[$i];
        $query .= (($tree_cnt >= 2) ? " WHERE gedcom = '$tree'" : "");

        if (!($result = tng_query($query))) {
            die ($admtext['cannotexecutequery'] . ": $query");
        }
    }

    $query = "DELETE FROM $events_table WHERE gedcom = '$tree' AND persfamID != 'XXX'";
    $result = tng_query($query);

    $query = "DELETE FROM $places_table WHERE gedcom = '$tree' AND (latitude is null OR latitude = '') AND (longitude is null OR longitude = '') AND (notes is null OR notes = '')";
    $result = tng_query($query);
}

