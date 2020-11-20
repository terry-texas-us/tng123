<?php
include "begin.php";
include "adminlib.php";

$admin_login = 1;
include "checklogin.php";
if (!$allow_media_edit) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}
require "adminlog.php";
$albumname = addslashes($albumname);
$description = addslashes($description);
$keywords = addslashes($keywords);
if (!$alwayson) $alwayson = 0;
$query = "UPDATE $albums_table SET albumname=\"$albumname\",description=\"$description\",keywords=\"$keywords\",active=\"$active\",alwayson=\"$alwayson\" WHERE albumID=\"$albumID\"";
$result = tng_query($query);
//cycle through all ph fields
//delete if requested
adminwritelog(_('Edit Existing Album') . ": $albumID");
if ($newscreen == "return") {
    header("Location: admin_editalbum.php?albumID=$albumID");
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
        $message = _('Changes to album') . " $albumID " . _('were successfully saved') . ".";
        header("Location: admin_albums.php?message=" . urlencode($message));
    }
}
?>