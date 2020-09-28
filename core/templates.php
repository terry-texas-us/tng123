<?php

declare (strict_types=1);

define("TEMPLATES_PATH", "templates");

/**
 * @param mysqli_result $result
 * @return array of t<template>_<keyname>[_<language>] => <value>
 */
function buildTemplateArray(mysqli_result $result) {
    $tmp = [];
    while ($row = tng_fetch_assoc($result)) {
        $key = "t" . $row['template'] . "_" . $row['keyname'];
        if ($row['language']) {
            $key .= "_" . $row['language'];
        }
        $tmp[$key] = $row['value'];
    }
    tng_free_result($result);
    return $tmp;
}

/**
 * @param $table
 * @param $template
 * @return array
 */
function getTemplateVars($table, $template) {
    $query = "SELECT * FROM $table WHERE template = '$template'";
    $result = tng_query_noerror($query);

    return ($result == FALSE) ? [] : buildTemplateArray($result);
}

/**
 * @param $table
 * @return array
 */
function getAllTemplatesVars($table) {
    $query = "SELECT * FROM $table ORDER BY template, ordernum";
    $result = tng_query($query);

    return buildTemplateArray($result);
}
