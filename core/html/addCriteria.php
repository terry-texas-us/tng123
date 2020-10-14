<?php

/**
 * @param $field
 * @param $value
 * @param $operator
 * @return string
 */
function addCriteria($field, $value, $operator) {
    $criteria = "";

    if ($operator == "=") {
        $criteria = " OR $field $operator '$value'";
    } else {
        $innercriteria = "";
        $terms = explode(' ', $value);
        foreach ($terms as $term) {
            if ($innercriteria) $innercriteria .= " AND ";
            $innercriteria .= "$field $operator '%$term%'";
        }
        if ($innercriteria) $criteria = " OR ($innercriteria)";
    }
    return $criteria;
}
