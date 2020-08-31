<?php

/**
 * @param string $id person or family to check
 * @param string $tree tree to check
 * @return string '*' if person has associations, else ''
 */
function checkForAssociations(string $id, string $tree): string {
    global $admtext, $assoc_table;

    $query = "SELECT count(assocID) as acount FROM {$assoc_table} WHERE personID = \"{$id}\" AND gedcom = \"{$tree}\"";
    $result = tng_query($query) or die ($admtext . ": $query");
    $row = tng_fetch_assoc($result);
    tng_free_result($result);
    return $row['acount'] ? "*" : "";
}
