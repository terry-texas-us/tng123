<?php

/**
 * @param string $id
 * @param array $tree
 * @return array
 */
function checkForNoteLinks(string $id, string $tree): array {
    global $notelinks_table;

    $gotnotes = [];
    $query = "SELECT DISTINCT eventID as eventID ";
    $query .= "FROM {$notelinks_table} ";
    $query .= "WHERE persfamID=\"{$id}\" AND gedcom =\"{$tree}\"";
    $notelinks = tng_query($query);

    while ($notelink = tng_fetch_assoc($notelinks)) {
        if (!$notelink['eventID']) {
            $notelink['eventID'] = "general";
        }
        $gotnotes[$notelink['eventID']] = "*";
    }
    tng_free_result($notelinks);
    return $gotnotes;
}
