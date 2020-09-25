<?php
include "begin.php";
include "genlib.php";
include "getlang.php";
include "$mylanguage/text.php";

include "checklogin.php";
?>

<html>
<head>
    <link href="genstyle.css" rel="stylesheet" type="text/css">
    <link href="mytngstyle.css" rel="stylesheet" type="text/css">
</head>
<body>

<h1>Random Photo Block</h1>

<p>This page displays a random photo from your database. You can move this functionality to any other TNG page
    by copying the PHP code from this page to your destination.</p>
<br style="clear: both;">

<?php
//COPY EVERYTHING IN THIS BLOCK
//Change these vars to affect max width & height of your photo. Aspect ratio will be maintained. Leaving
//these values blank will cause your photo to be displayed actual size.
$maxwidth = "100";
$maxheight = "100";

$query = "SELECT distinct media.mediaID, path, media.description, usecollfolder ";
$query .= "FROM ($media_table media, $medialinks_table medialinks, $people_table people) ";
$query .= "WHERE media.mediaID = medialinks.mediaID ";
if ($tree) {
    $query .= "AND (media.gedcom = '$tree' || media.gedcom = '') ";
}
$query .= "AND medialinks.gedcom = people.gedcom AND medialinks.personID = people.personID AND mediatypeID = 'photos' AND (living != '1' OR alwayson = '1') ";
$query .= "ORDER BY RAND() ";
$query .= "LIMIT 1";
$result = tng_query($query);
$imgrow = tng_fetch_assoc($result);
tng_free_result($result);

$usefolder = $imgrow['usecollfolder'] ? $photopath : $mediapath;
$photoinfo = @GetImageSize("$rootpath$usefolder/" . $imgrow['path']);
$photowtouse = $photoinfo[0];
$photohtouse = $photoinfo[1];

//these lines do the resizing
if ($maxheight && $photohtouse > $maxheight) {
    $photowtouse = intval($maxheight * $photowtouse / $photohtouse);
    $photohtouse = $maxheight;
}
if ($maxwidth && $photowtouse > $maxwidth) {
    $photohtouse = intval($maxwidth * $photohtouse / $photowtouse);
    $photowtouse = $maxwidth;
}

//these lines restrict the table width so the caption will not be wider than the photo
if ($maxwidth) {
    $width = "width=\"$maxwidth\"";
}
if ($maxheight) {
    $height = "height=\"$maxheight\"";
}

echo "<table $width $height>\n";
echo "<tr><td class='text-center'><a href=\"showmedia.php?mediaID={$imgrow['mediaID']}\"><img src=\"$usefolder/" . str_replace("%2F", "/", rawurlencode($imgrow['path'])) . "\" width=\"$photowtouse\" height=\"$photohtouse\" alt=\"{$imgrow['description']}\" title=\"{$imgrow['description']}\"></a></td></tr>\n";
echo "<tr><td class='text-center'><span class='normal'><a href=\"showmedia.php?mediaID={$imgrow['mediaID']}\">{$imgrow['description']}</a></span></td></tr>";
echo "</table>";
?>

<br style="clear: both;">
<p>If you want to use this on a PHP page you created from scratch, you will need to include the PHP block
    at the top of this page as well.</p>

<p>Notes:<br>
    1) To simplify matters here, all photos attached to living individuals have been removed.
    No check is done, however, to see if the photo is attached to a source cited for a living individual or
    a family flagged as living.<br>
    2) To restrict a photo to certain dimensions, fill in the "maxwidth" and/or "maxheight" variables in the code.
    Please note that although this will resize the display dimensions, the file size and bandwidth requirements will
    not be affected. If you want to show random thumbnails instead, change each occurence of "path" above to "thumbpath" (lines 31, 40 and 59).</p>

</body>
</html>
