<?php

/**
 * @param $query
 * @param string[] $endTags
 * @return string
 */
function extractWhereClause($query, $endTags = ["ORDER BY", "LIMIT"]): string {
    $wherePosition = stripos($query, "WHERE");
    if ($wherePosition) {
        foreach ($endTags as $endTag) {
            $tagPosition = stripos($query, $endTag);
            if ($tagPosition) {
                return substr($query, $wherePosition, $tagPosition - $wherePosition);
            }
        }
    }
    return "";
}

