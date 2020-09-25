<?php
include "begin.php";
include "adminlib.php";
$textpart = "photos";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
if (!$allow_media_edit) {
    $message = $admtext['norights'];
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

require "adminlog.php";

$albumname = addslashes($albumname);
$description = addslashes($description);
$keywords = addslashes($keywords);

if (!$alwayson) {
    $alwayson = 0;
}

$query = "UPDATE $albums_table SET albumname=\"$albumname\",description=\"$description\",keywords=\"$keywords\",active=\"$active\",alwayson=\"$alwayson\" WHERE albumID=\"$albumID\"";
$result = tng_query($query);

//cycle through all ph fields
//delete if requested
adminwritelog($admtext['modifyalbum'] . ": $albumID");

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
        $message = $admtext['changestoalbum'] . " $albumID {$admtext['succsaved']}.";
        header("Location: admin_albums.php?message=" . urlencode($message));
    }
}
?>