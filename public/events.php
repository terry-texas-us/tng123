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
    return "<strong>" . getEventDisplay($event['display']) . "</strong> " . $dateAndPlace . $event['info'] . "<br>\n";
}
