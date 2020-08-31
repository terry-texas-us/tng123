<?php

/**
 * Fetches all from 'families' cleaning some text and formatting 'changedate'
 * @param string|null &$familyID ensures first character capital
 * @param string $families_table 'families' table
 * @param array $tree tree containing family
 * @return array fetched row
 */
function fetchAndCleanFamilyRow(?string &$familyID, string $families_table, string $tree): array {
    $row = [];
    if ($familyID) {
        $familyID = ucfirst($familyID);
        $query = "SELECT *, DATE_FORMAT(changedate,\"%d %b %Y %H:%i:%s\") as changedate FROM $families_table WHERE familyID = \"$familyID\" AND gedcom = \"$tree\"";
        $result = tng_query($query);
        $row = tng_fetch_assoc($result);
        tng_free_result($result);
        $row['marrplace'] = preg_replace("/\"/", "&#34;", $row['marrplace']);
        $row['sealplace'] = preg_replace("/\"/", "&#34;", $row['sealplace']);
        $row['divplace'] = preg_replace("/\"/", "&#34;", $row['divplace']);
        $row['notes'] = preg_replace("/\"/", "&#34;", $row['notes']);
    }
    return $row;
}

