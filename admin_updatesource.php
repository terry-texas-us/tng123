<?php
include "begin.php";
include "adminlib.php";
$textpart = "sources";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
if (!$allow_edit || ($assignedtree && $assignedtree != $tree)) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

require "adminlog.php";

$shorttitle = addslashes($shorttitle);
$title = addslashes($title);
$author = addslashes($author);
$callnum = addslashes($callnum);
$publisher = addslashes($publisher);
$actualtext = addslashes($actualtext);

$newdate = date("Y-m-d H:i:s", time() + (3600 * $time_offset));

$query = "UPDATE $sources_table SET shorttitle=\"$shorttitle\",title=\"$title\",author=\"$author\",callnum=\"$callnum\",publisher=\"$publisher\",repoID=\"$repoID\",actualtext=\"$actualtext\",changedate=\"$newdate\",changedby=\"$currentuser\" WHERE sourceID=\"$sourceID\" AND gedcom = '$tree'";
$result = tng_query($query);

adminwritelog("<a href=\"admin_editsource.php?sourceID=$sourceID&amp;tree=$tree\">" . _('Edit Existing Source') . ": $tree/$sourceID</a>");

if ($newscreen == "return") {
    header("Location: admin_editsource.php?sourceID=$sourceID&tree=$tree");
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
        $message = _('Changes to source') . " $sourceID " . _('were successfully saved') . ".";
        header("Location: admin_sources.php?message=" . urlencode($message));
    }
}
?>
