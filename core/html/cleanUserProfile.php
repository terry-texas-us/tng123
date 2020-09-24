<?php

/**
 * @param array $row
 * @return array
 */
function cleanUserProfile(array $row): array {
    $row['description'] = preg_replace("/\"/", "&#34;", $row['description']);
    $row['realname'] = preg_replace("/\"/", "&#34;", $row['realname']);
    $row['phone'] = preg_replace("/\"/", "&#34;", $row['phone']);
    $row['email'] = preg_replace("/\"/", "&#34;", $row['email']);
    $row['address'] = preg_replace("/\"/", "&#34;", $row['address']);
    $row['city'] = preg_replace("/\"/", "&#34;", $row['city']);
    $row['state'] = preg_replace("/\"/", "&#34;", $row['state']);
    $row['website'] = preg_replace("/\"/", "&#34;", $row['website']);
    $row['country'] = preg_replace("/\"/", "&#34;", $row['country']);
    $row['notes'] = preg_replace("/\"/", "&#34;", $row['notes']);
    return $row;
}

