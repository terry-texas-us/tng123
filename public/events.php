<?php

/**
 * @param array $event
 * @return string
 */
function getEvent(array $event): string {
    $dateAndPlace = $event['eventdate'];
    if ($dateAndPlace && $event['eventplace']) {
        $dateAndPlace .= ", ";
    }
    $dateAndPlace .= $event['eventplace'];
    if ($dateAndPlace && $event['info']) {
        $dateAndPlace .= ". ";
    }
    return "<strong>" . getEventDisplayText($event) . "</strong> " . $dateAndPlace . $event['info'] . "<br>\n";
}

/**
 * @param array $event
 * @return mixed|string
 */
function getEventDisplayText(array $event): string {
    global $mylanguage, $languages_path;
    $dispvalues = explode("|", $event['display']);
    $numvalues = count($dispvalues);
    if ($numvalues > 1) {
        $displayval = "";
        for ($i = 0; $i < $numvalues; $i += 2) {
            $lang = $dispvalues[$i];
            if ($mylanguage == $languages_path . $lang) {
                $displayval = $dispvalues[$i + 1];
                break;
            }
        }
    } else {
        $displayval = $event['display'];
    }
    return $displayval;
}
