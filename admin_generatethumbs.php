<?php
include "begin.php";
include "adminlib.php";
$textpart = "photos";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
@set_time_limit(0);

require "adminlog.php";

if (!$allow_media_add) {
    echo _('You are not authorized to view this page. If you have a username and password, please login below.');
    exit;
}

header("Content-type:text/html; charset=" . $session_charset);

initMediaTypes();

$thumbquality = 80;
$maxsizeallowed = 4096; // in kilobytes
if (function_exists('imageJpeg')) include "imageutils.php";


$query = "SELECT mediaID, path, thumbpath, mediatypeID, usecollfolder, form, description FROM $media_table where path != \"\"";
$result = tng_query($query);

$count = 0;
$conflicts = 0;
$conflictstr = "";
$updated = 0;

while ($row = tng_fetch_assoc($result)) {
    $needsupdate = 0;
    $newthumbpath = "";
    $mediatypeID = $row['mediatypeID'];
    $usefolder = $row['usecollfolder'] ? $mediatypes_assoc[$mediatypeID] : $mediapath;
    if (!$row['form']) {
        $path = $row['thumbpath'] ? $row['thumbpath'] : $row['path'];
        preg_match("/\.([^.]*?)$/", $path, $matches);
        $ext = strtoupper($matches[1]);
    } else {
        $ext = trim($row['form']);
    }

    if (trim($row['thumbpath']) && !$repath) {
        if ((!$regenerate && file_exists("$rootpath$usefolder/" . $row['thumbpath'])) || !in_array($ext, $imagetypes)) {
            $newthumbpath = "";
        } else {
            $newthumbpath = "$rootpath$usefolder/" . $row['thumbpath'];
        }
    } elseif ($row['path'] && in_array($ext, $imagetypes)) {
        //insert prefix in path directly before file name
        $thumbparts = pathinfo($row['path']);
        $thumbpath = $thumbparts['dirname'];
        if ($thumbpath == ".") $thumbpath = "";

        if ($thumbpath) $thumbpath .= "/";

        $lastperiod = strrpos($thumbparts['basename'], ".");
        $base = substr($thumbparts['basename'], 0, $lastperiod);
        $thumbpath .= $thumbprefix . $base . $thumbsuffix . "." . $thumbparts['extension'];
        $newthumbpath = "$rootpath$usefolder/$thumbpath";
        if (file_exists($newthumbpath)) $newthumbpath = "";

        $needsupdate = 1;
    }
    if ($newthumbpath) {
        // TODO Need to sanitize file path
        $path = "$rootpath$usefolder/" . trim($row['path']);
        $destInfo = pathinfo($newthumbpath);
        if (strtoupper($srcInfo['extension']) != "PDF") {
            if (file_exists($path)) {
                if (ceil(filesize($path) / 1000) > $maxsizeallowed) {
                    $needsupdate = 0;
                    $conflicts++;
                    $conflictstr .= $conflicts . ". \"" . truncateIt($row['description'], 30) . "\" | " . $row['path'] . " " . _('(original is too large)') . "<br>\n";  //file is too big
                } else {
                    if (function_exists('imageJpeg') && image_createThumb($path, $newthumbpath, $thumbmaxw, $thumbmaxh, $thumbquality)) {
                        if (strtoupper($destInfo['extension']) == "GIF") {
                            $thumbpath = substr_replace($thumbpath, 'jpg', -3);
                            $newthumbpath = substr_replace($newthumbpath, 'jpg', -3);
                        }
                        @chmod($newthumbpath, 0644);
                        $count++;
                    } else {
                        $needsupdate = 0;
                        $conflicts++;
                        $conflictstr .= $conflicts . ". \"" . truncateIt($row['description'], 30) . "\" | " . $newthumbpath . " " . _('(invalid image or inadequate permissions)') . "<br>\n";  //thumb couldn't be created
                    }
                }
            } else {
                $needsupdate = 0;
                $conflicts++;
                $conflictstr .= $conflicts . ". \"" . truncateIt($row['description'], 30) . "\" | " . $row['path'] . " " . _('(original not found)') . "<br>\n";  //original doesn't exist
            }
        }
    }
    if ($needsupdate) {
        $changedate = date("Y-m-d H:i:s", time() + (3600 * $time_offset));
        $query = "UPDATE $media_table SET thumbpath=\"$thumbpath\", changedate=\"$changedate\", changedby=\"$currentuser\" WHERE mediaID=\"{$row['mediaID']}\"";
        $result2 = tng_query($query);
        $updated++;
    }
}
tng_free_result($result);

adminwritelog("" . _('Generate Thumbnails') . ": " . _('Thumbnails generated') . ": $count; " . _('Records updated') . ": $updated; " . _('Thumbnails not generated due to path, permissions, size or file name problems') . ": $conflicts");

echo "<p><strong>" . _('Thumbnails generated') . ":</strong> $count<br><strong>" . _('Records updated') . ":</strong> $updated</p>";
if ($conflicts) {
    echo "<p><strong>" . _('Thumbnails not generated due to path, permissions, size or file name problems') . ":</strong> $conflicts</p><p style=\"line-height:1.5;\">$conflictstr</p>";
}
