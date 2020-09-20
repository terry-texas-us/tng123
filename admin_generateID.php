<?php
include "begin.php";
include "adminlib.php";
$textpart = "generateID";
include "$mylanguage/admintext.php";

include "checklogin.php";

function getNewID($type, $table) {
    global $tree, $admtext, $tngconfig;

    eval("\$prefix = \$tngconfig['{$type}prefix'];");
    eval("\$suffix = \$tngconfig['{$type}suffix'];");

    if (!isset($tngconfig['oldids'])) {
        $tngconfig['oldids'] = "";
    }
    if ($tngconfig['oldids']) {
        if ($prefix) {
            $prefixlen = strlen($prefix) + 1;
            $query = "SELECT MAX(0+SUBSTRING($type" . "ID,$prefixlen)) AS newID FROM $table WHERE gedcom = '$tree' AND $type" . "ID LIKE \"$prefix%\"";
        } else {
            $query = "SELECT MAX(0+SUBSTRING_INDEX($type" . "ID,'$suffix',1)) AS newID FROM $table WHERE gedcom = '$tree'";
        }

        $result = tng_query($query) or die ($admtext['cannotexecutequery'] . ": $query");
        $maxrow = tng_fetch_array($result);
        tng_free_result($result);

        $newID = $prefix . str_pad($maxrow['newID'] + 1, strlen($maxrow['newID']) . $suffix, "0", STR_PAD_LEFT);
    } else {
        if (isset($_COOKIE['tng_' . $type . 'lastid_' . $tree])) {
            $lastid = $_COOKIE['tng_' . $type . 'lastid_' . $tree];
        } else {
            $lastid = 1;
        }
        if (!trim($lastid)) {
            $lastid = 0;
        }
        $found = false;

        $typestr = $type . "ID";
        if ($prefix) {
            $preflen = strlen($prefix);
            $numpart = "CAST(SUBSTRING($typestr," . ($preflen + 1) . ") as SIGNED)";
            $wherestr = " AND $numpart >= $lastid";
        } elseif ($suffix) {
            $suflen = strlen($suffix);
            $numpart = "CAST(SUBSTRING($typestr,0,LENGTH($typestr - " . ($sufflen + 1) . ")) as SIGNED)";
            $wherestr = " AND $numpart >= $lastid";
        } else {
            $numpart = $typestr;
            $wherestr = "";
        }

        $maxrows = 10000;
        $nextone = 0;
        $newnum = "";
        do {
            $query = "SELECT $typestr FROM $table WHERE gedcom = '$tree' $wherestr
				ORDER BY $numpart
				LIMIT $nextone, $maxrows";
            $result = tng_query($query);
            $numrows = tng_num_rows($result);

            while (($row = tng_fetch_array($result)) && !$found) {
                if ($prefix) {
                    $number = intval(substr($row[$typestr], $preflen));
                } elseif ($suffix) {
                    $number = intval(substr($row[$typestr], 0, -$suflen));
                } else {
                    $number = intval($row[$typestr]);
                }

                if ($number > $lastid) {
                    $found = true;
                    $newnum = $lastid;
                    break;
                } elseif ($number == $lastid) {
                    $lastid += 1;
                }
            }
            $nextone += $maxrows;
        } while (!$found && $numrows == $maxrows);

        $newID = $prefix . $lastid . $suffix;
        setcookie('tng_' . $type . 'lastid_' . $tree, $newnum, time() + 60 * 60 * 24 * 365);
    }

    return $newID;
}

switch ($type) {
    case "person":
        $newID = getNewID("person", $people_table);
        break;
    case "family":
        $newID = getNewID("family", $families_table);
        break;
    case "source":
        $newID = getNewID("source", $sources_table);
        break;
    case "repo":
        $newID = getNewID("repo", $repositories_table);
        break;
}
echo $newID;
