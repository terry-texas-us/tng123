<?php

/**
 * @param string $id
 * @param string $tree
 * @return array
 */
function checkForEvents(string $id, string $tree): array {
    global $events_table;

    $query = "SELECT parenttag ";
    $query .= "FROM {$events_table} ";
    $query .= "WHERE persfamID=\"{$id}\" AND gedcom =\"{$tree}\"";
    $result = tng_query($query);

    $gotmore = [];
    while ($more = tng_fetch_assoc($result)) {
        $gotmore[$more['parenttag']] = "*";
    }
    tng_free_result($result);
    return $gotmore;
}
