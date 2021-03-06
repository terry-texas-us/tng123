<?php
include "begin.php";
include "adminlib.php";

$admin_login = 1;
include "checklogin.php";
if (!$allow_media_edit && !$allow_media_add) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

require "adminlog.php";
initMediaTypes();

function reorderMedia($query, $plink, $mediatypeID) {
    global $medialinks_table, $media_table;

    $ptree = $plink['gedcom'];
    $eventID = $plink['eventID'];
    $result3 = tng_query($query);
    while ($personrow = tng_fetch_assoc($result3)) {
        $query = "SELECT medialinkID FROM ($medialinks_table, $media_table) WHERE personID = \"{$personrow['personID']}\" AND $medialinks_table.gedcom = \"$ptree\" AND $media_table.mediaID = $medialinks_table.mediaID AND eventID = \"$eventID\" AND mediatypeID = \"$mediatypeID\" ORDER BY ordernum";
        $result4 = tng_query($query);

        $counter = 1;
        while ($medialinkrow = tng_fetch_assoc($result4)) {
            $query = "UPDATE $medialinks_table SET ordernum = \"$counter\" WHERE medialinkID = \"{$medialinkrow['medialinkID']}\"";
            tng_query($query);
            $counter++;
        }
        tng_free_result($result4);
    }
    tng_free_result($result3);
}

$thumbquality = 80;
if (function_exists('imageJpeg')) include "imageutils.php";


$usefolder = $usecollfolder ? $mediatypes_assoc[$mediatypeID] : $mediapath;
$treestr = $tngconfig['mediatrees'] ? $tree . "/" : "";

if (substr($thumbpath, 0, 1) == "/") {
    $thumbpath = substr($thumbpath, 1);
}
$newthumbpath = "$rootpath$usefolder/$treestr$thumbpath";

$description = addslashes($description);
$notes = addslashes($notes);
$datetaken = addslashes($datetaken);
$place = addslashes($place);
$owner = addslashes($owner);
$imagemap = addslashes($imagemap);
$bodytext = addslashes($bodytext);
$latitude = addslashes($latitude);
$longitude = addslashes($longitude);
$zoom = addslashes($zoom);
$width = addslashes($width);
$height = addslashes($height);
$plot = addslashes($plot);

$latitude = preg_replace("/,/", ".", $latitude);
$longitude = preg_replace("/,/", ".", $longitude);
$imagemap = trim($imagemap);
if ($latitude && $longitude && !$zoom) $zoom = 13;
$fileparts = pathinfo($path);
$form = strtoupper($fileparts['extension']);
$newdate = date("Y-m-d H:i:s", time() + (3600 * $time_offset));
if ($abspath) {
    $path = $mediaurl;
} else {
    $abspath = 0;
}
if (!$showmap) $showmap = "0";
if (!$usenl) $usenl = 0;
if (!$alwayson) $alwayson = 0;
if (!$newwindow) $newwindow = 0;
if (!$usecollfolder) $usecollfolder = 0;

if (!$width) $width = 0;
if (!$height) $height = 0;
if (!$cemeteryID) $cemeteryID = 0;
if (!$linktocem) $linktocem = 0;
if (!$zoom) $zoom = 0;
if ($usecollfolder && $mediatypeID != $mediatypeID_org) {
    $oldmediapath = $mediatypes_assoc[$mediatypeID_org] . $treestr;
    $newmediapath = $mediatypes_assoc[$mediatypeID] . $treestr;
    if ($path_org) {
        $oldpath = "$rootpath$oldmediapath/$path_org";
        $newpath = "$rootpath$newmediapath/$path";
        if (file_exists($oldpath)) @rename($oldpath, $newpath);

    }

    if ($thumbpath_org) {
        $oldthumbpath = "$rootpath$oldmediapath/$thumbpath_org";
        $newthumbpath = "$rootpath$newmediapath/$thumbpath";
        if (file_exists($oldthumbpath)) {
            @rename($oldthumbpath, $newthumbpath);
        }
    }
}

$mediakey = $path && $path != $path_org ? "$usefolder/$path" : $mediakey_org;
if (!$mediakey) $mediakey = time();


if (substr($path, 0, 1) == "/") $path = substr($path, 1);

$newpath = "$rootpath$usefolder/$treestr$path";

if ($newfile && $newfile != "none") {
    if (@move_uploaded_file($newfile, $newpath)) {
        @chmod($newpath, 0644);
    } else {
        //improper permissions or folder doesn't exist (root path may be wrong)
        $message = _('The file could not be copied to') . " $newpath " . _('because the folder does not exist (check the Root Path) or does not have proper permissions (try chmod(777)).') . ".";
        header("Location: admin_media.php?message=" . urlencode($message));
        exit;
    }
}

if (function_exists('imageJpeg') && $thumbcreate == "auto") {
    if (image_createThumb($newpath, $newthumbpath, $thumbmaxw, $thumbmaxh, $thumbquality)) {
        $destInfo = pathInfo($newthumbpath);
        if (strtoupper($destInfo['extension']) == "GIF") {
            $thumbpath = substr_replace($thumbpath, 'jpg', -3);
            $newthumbpath = substr_replace($newthumbpath, 'jpg', -3);
        }
        @chmod($newthumbpath, 0644);
    } else {
        //could not create thumbnail (size or type problem) or permissions (root path may be wrong)
        $message = _('The thumbnail file could not be copied to') . " $newthumbpath " . _('because the original file is too large or is not a valid image, or because the folder does not exist (check the Root Path) or does not have proper permissions (try chmod(777)).') . ".";
        header("Location: admin_media.php?message=" . urlencode($message));
        exit;
    }
} else {
    if ($newthumb && $newthumb != "none") {
        if (@move_uploaded_file($newthumb, $newthumbpath)) {
            @chmod($newthumbpath, 0644);
        } else {
            //improper permissions or folder doesn't exist (root path may be wrong)
            $message = _('The thumbnail file could not be copied to') . " $newthumbpath " . _('because the folder does not exist (check the Root Path) or does not have proper permissions (try chmod(777)).') . ".";
            header("Location: admin_media.php?message=" . urlencode($message));
            exit;
        }
    }
}
$query = "UPDATE $media_table ";
$query .= "SET path=\"$path\", thumbpath=\"$thumbpath\", description=\"$description\", notes=\"$notes\", width=\"$width\", height=\"$height\", datetaken=\"$datetaken\", placetaken=\"$place\", owner=\"$owner\", changedate=\"$newdate\", changedby=\"$currentuser\", form=\"$form\",alwayson=\"$alwayson\", mediatypeID=\"$mediatypeID\", map=\"$imagemap\", abspath=\"$abspath\", gedcom = '$tree', status=\"$status\", cemeteryID='$cemeteryID', plot=\"$plot\", showmap=\"$showmap\", linktocem=\"$linktocem\", latitude=\"$latitude\", longitude=\"$longitude\",zoom=\"$zoom\", bodytext=\"$bodytext\", usenl=\"$usenl\", newwindow=\"$newwindow\", usecollfolder=\"$usecollfolder\", mediakey=\"$mediakey\"  ";
$query .= "WHERE mediaID=\"$mediaID\"";
$result = tng_query($query);
if ($mediatypeID != $mediatypeID_org) {
    $query = "SELECT personID, $medialinks_table.gedcom, eventID FROM ($medialinks_table, $media_table) WHERE $medialinks_table.mediaID = \"$mediaID\" AND $medialinks_table.mediaID = $media_table.mediaID";
    $result2 = tng_query($query);
    if ($result2) {
        while ($plink = tng_fetch_assoc($result2)) {
            $query = "SELECT personID FROM $people_table WHERE personID = \"{$plink['personID']}\" AND gedcom = \"{$plink['gedcom']}\"";
            reorderMedia($query, $plink, $mediatypeID_org);
            reorderMedia($query, $plink, $mediatypeID);

            $query = "SELECT familyID AS personID FROM $families_table WHERE familyID = \"{$plink['personID']}\" AND gedcom = \"{$plink['gedcom']}\"";
            reorderMedia($query, $plink, $mediatypeID_org);
            reorderMedia($query, $plink, $mediatypeID);

            $query = "SELECT sourceID AS personID FROM $sources_table WHERE sourceID = \"{$plink['personID']}\" AND gedcom = \"{$plink['gedcom']}\"";
            reorderMedia($query, $plink, $mediatypeID_org);
            reorderMedia($query, $plink, $mediatypeID);

            $query = "SELECT repoID AS personID FROM $repositories_table WHERE repoID = \"{$plink['personID']}\" AND gedcom = \"{$plink['gedcom']}\"";
            reorderMedia($query, $plink, $mediatypeID_org);
            reorderMedia($query, $plink, $mediatypeID);
        }
        tng_free_result($result2);
    }
}

adminwritelog("<a href=\"admin_editmedia.php?mediaID=$mediaID\">" . _('Edit Existing Media') . ": $mediaID</a>");

if ($newmedia == "return") {
    header("Location: admin_editmedia.php?mediaID=$mediaID&cw=$cw");
} else {
    if ($newmedia == "close") {
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
        $message = _('Changes to item') . " $mediaID " . _('were successfully saved') . ".";
        header("Location: admin_media.php?message=" . urlencode($message));
    }
}
?>