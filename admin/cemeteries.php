<?php

/**
 * @param string $cemeteries_table
 * @param $cemeteryId
 * @return string[]|null
 */
function fetchCemetery(string $cemeteries_table, $cemeteryId) {
    $query = "SELECT * FROM $cemeteries_table WHERE cemeteryID = '$cemeteryId'";
    $result = tng_query($query);
    if (!tng_num_rows($result)) {
        header("Location: thispagedoesnotexist.html");
        exit;
    }
    $cemetery = tng_fetch_assoc($result);
    tng_free_result($result);
    return $cemetery;
}
/**
 * Formats a detailed cemetery location from name and optional juristiction parts.
 *
 * @param array|null $cemetery
 * @return string
 */
function cemeteryLocation(?array $cemetery): string {
    if (empty($cemetery)) return "";
    return cemeteryPlace($cemetery, $cemetery['cemname']);
}
/**
 * Formats a cemetery location from optional juristiction parts.
 *
 * @param array|null $cemetery
 * @param string $placeDetails optional detail text prepended to location
 * @return string comma delimited cemetery location string
 */
function cemeteryPlace(?array $cemetery, string $placeDetails = ""): string {
    if (empty($cemetery)) return "";
    $place = $placeDetails;
    if ($cemetery['city']) {
        if ($place) $place .= ", ";
        $place .= $cemetery['city'];
    }
    if ($cemetery['county']) {
        if ($place) $place .= ", ";
        $place .= $cemetery['county'];
    }
    if ($cemetery['state']) {
        if ($place) $place .= ", ";
        $place .= $cemetery['state'];
    }
    if ($cemetery['country']) {
        if ($place) $place .= ", ";
        $place .= $cemetery['country'];
    }
    return $place;
}
