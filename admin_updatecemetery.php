<?php
include "begin.php";
include "config/mapconfig.php";
include "adminlib.php";

$admin_login = 1;
include "checklogin.php";
if (!$allow_edit) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

require "adminlog.php";

if ($newfile && $newfile != "none") {
    if (substr($maplink, 0, 1) == "/") $maplink = substr($maplink, 1);

    $newpath = "$rootpath$headstonepath/$maplink";

    if (@move_uploaded_file($newfile, $newpath)) {
        @chmod($newpath, 0644);
    } else {
        $message = _('The map image file could not be copied to') . " $newpath " . _('because the folder does not exist (check the Root Path) or does not have proper permissions (try chmod(777)).') . ".";
        header("Location: admin_cemeteries.php?message=" . urlencode($message));
        exit;
    }
}

$cemname = addslashes($cemname);
$city = addslashes($city);
$county = addslashes($county);
$state = addslashes($state);
$country = addslashes($country);
$latitude = addslashes($latitude);
$longitude = addslashes($longitude);
$zoom = addslashes($zoom);
$notes = addslashes($notes);
$place = addslashes($place);
$latitude = preg_replace("/,/", ".", $latitude);
$longitude = preg_replace("/,/", ".", $longitude);
if ($latitude && $longitude && !$zoom) $zoom = 13;
if (!$zoom) $zoom = 0;
$query = "UPDATE $cemeteries_table ";
$query .= "SET cemname=\"$cemname\", maplink=\"$maplink\", city=\"$city\", county=\"$county\", state=\"$state\", country=\"$country\", latitude=\"$latitude\", longitude=\"$longitude\", zoom=\"$zoom\", notes=\"$notes\", place=\"$place\" ";
$query .= "WHERE cemeteryID='$cemeteryID'";
$result = tng_query($query);
$tree = $assignedtree;
if (!$tree) {
    $query = "SELECT gedcom FROM $trees_table LIMIT 2";
    $result2 = tng_query($query);
    if (tng_num_rows($result2) == 1) {
        $row = tng_fetch_assoc($result2);
        $tree = $row['gedcom'];
    }
    tng_free_result($result2);
}

$place = trim($place);
if ($place) {
    //first check to see if any place exists in any tree with new place name
    $query = "SELECT * FROM $places_table WHERE place = \"$place\"";
    $result = tng_query($query);

    if (!tng_num_rows($result)) {
        if (!isset($usecoords)) {
            $latitude = $longitude = "";
            $zoom = 0;
        }
        $query = "INSERT IGNORE INTO $places_table (gedcom,place,placelevel,latitude,longitude,zoom,notes) VALUES ('$tree',\"$place\",'0',\"$latitude\",\"$longitude\",\"$zoom\",\"$notes\")";
        $result3 = tng_query($query);
    } elseif (isset($usecoords)) {
        $treestr = $tree && $tngconfig['places1tree'] ? "gedcom = '$tree' AND " : "";
        $query = "UPDATE $places_table SET latitude=\"$latitude\",longitude=\"$longitude\",zoom=\"$zoom\" WHERE {$treestr}place=\"$place\"";
        $result3 = tng_query($query);
    }
    tng_free_result($result);
}

adminwritelog("<a href=\"admin_editcemetery.php?cemeteryID=$cemeteryID\">" . _('Edit Existing Cemetery') . ": $cemeteryID</a>");

if ($newscreen == "return") {
    header("Location: admin_editcemetery.php?cemeteryID=$cemeteryID");
} else {
    if ($newscreen == "close") {
        ?>
        <!doctype html>
        <html lang="en">

        <body>
        <script>
            top.close();
        </script>
        </body>
        </html>
        <?php
    } else {
        $message = _('Changes to cemetery') . " $cemeteryID " . _('were successfully saved') . ".";
        header("Location: admin_cemeteries.php?message=" . urlencode($message));
    }
}
?>