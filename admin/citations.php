<?php

/**
 * @param string $id 'personID' or 'familyID'
 * @param string $tree
 * @return array
 */
function checkForCitations(string $id, string $tree): array {
    global $citations_table, $text;

    $query = "SELECT DISTINCT eventID ";
    $query .= "FROM $citations_table ";
    $query .= "WHERE persfamID = \"{$id}\" AND gedcom = \"{$tree}\"";
    $result = tng_query($query) or die ($text . ": $query");
    $citations = [];
    while ($citation = tng_fetch_assoc($result)) {
        if (!$citation['eventID']) {
            $citation['eventID'] = "general";
        }
        $citations[$citation['eventID']] = "*";
    }
    tng_free_result($result);
    return $citations;
}

