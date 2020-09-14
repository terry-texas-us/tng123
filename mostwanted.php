<?php

$textpart = "reports";
include "tng_begin.php";

if (!empty($cms['events'])) {
    include 'cmsevents.php';
    cms_whatsnew();
}
include $cms['tngpath'] . "functions.php";

$getperson_url = getURL("getperson", 1);
$showmedia_url = getURL("showmedia", 1);
$mostwanted_url = getURL("mostwanted", 0);

$logstring = "<a href=\"$mostwanted_url\">" . xmlcharacters($text['mostwanted']) . "</a>";
writelog($logstring);
preparebookmark($logstring);

$suggest_url = getURL("suggest", 1);
$getperson_url = getURL("getperson", 1);

$gotImageJpeg = function_exists('imageJpeg');

function showDivs($type) {
    global $text, $people_table, $media_table, $mostwanted_table, $mediatypes_assoc, $mediapath, $rootpath, $suggest_url, $getperson_url;
    global $gotImageJpeg, $maxmediafilesize, $tree;

    $mediatext = "<table class=\"whiteback\" cellpadding=\"8\" cellspacing=\"2\" width=\"100%\">\n";

    $query = "SELECT mostwanted.ID AS mwID, mwtype, thumbpath, abspath, form, usecollfolder, mediatypeID, path, media.description AS mtitle, mostwanted.personID, mostwanted.gedcom, mostwanted.mediaID, mostwanted.description as mwdesc, mostwanted.title as mwtitle, lastname, firstname, lnprefix, suffix, prefix, people.title as title, living, private, nameorder, branch ";
    $query .= "FROM $mostwanted_table mostwanted ";
    $query .= "LEFT JOIN $media_table media ON mostwanted.mediaID = media.mediaID ";
    $query .= "LEFT JOIN $people_table people ON mostwanted.personID = people.personID AND mostwanted.gedcom = people.gedcom ";
    $query .= "WHERE mwtype = '$type' ";
    if ($tree) {
        $query .= " AND mostwanted.gedcom = '$tree' ";
    }
    $query .= "ORDER BY ordernum";
    $result = tng_query($query);

    while ($row = tng_fetch_assoc($result)) {
        $mediatypeID = $row['mediatypeID'];
        $usefolder = $row['usecollfolder'] ? $mediatypes_assoc[$mediatypeID] : $mediapath;
        $row['allow_living'] = 1;
        $imgsrc = $row['mediaID'] ? getSmallPhoto($row) : "";

        $mediatext .= "<tr><td class='databack normal'>\n";
        $href = getMediaHREF($row, 0);
        if ($imgsrc) {
            $mediatext .= "<div class=\"mwimage\">\n<div class=\"media-img\"><div class=\"media-prev\" id=\"prev{$row['mediaID']}\" style=\"display:none;\"></div></div>\n";
            $mediatext .= "<a href=\"$href\"";
            if ($gotImageJpeg && isPhoto($row) && filesize("$rootpath$usefolder/" . $row['path']) < $maxmediafilesize) {
                $mediatext .= " class=\"media-preview\" id=\"img-{$row['mediaID']}-0-" . urlencode("$usefolder/{$row['path']}") . "\"";
            }
            $mediatext .= ">$imgsrc</a>\n";
            $mediatext .= "</div>\n";
        }
        $mediatext .= "<span><strong>{$row['mwtitle']}</strong></span><br><br>";
        $mediatext .= "<div style=\"margin:0;\">{$row['mwdesc']}</div>";

        $mediatext .= "<div class=\"mwperson\">\n";
        if ($type == "person") {
            if ($row['personID']) {
                $mediatext .= "<a href=\"$suggest_url" . "enttype=I&amp;ID={$row['personID']}&amp;tree={$row['gedcom']}\">" . $text['tellus'] . "</a>";

                $rights = determineLivingPrivateRights($row);
                $row['allow_living'] = $rights['living'];
                $row['allow_private'] = $rights['private'];

                $name = getName($row);
                $mediatext .= " &nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp; " . $text['moreinfo'] . " <a href=\"$getperson_url" . "personID={$row['personID']}&amp;tree={$row['gedcom']}\">$name</a>";
            } else {
                $mediatext .= "<a href=\"{$suggest_url}page={$text['mostwanted']}:+{$row['mwtitle']}\">" . $text['tellus'] . "</a>";
            }
        }
        if ($type == "photo" && $row['mediaID']) {
            $mediatext .= "<a href=\"{$suggest_url}page={$text['mostwanted']}:+{$row['mtitle']}\">" . $text['tellus'] . "</a>";
            $mediatext .= " &nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp; " . $text['moreinfo'] . " <a href=\"$href\">{$row['mtitle']}</a> &nbsp;&nbsp;&nbsp;";
        }
        $mediatext .= "</div>\n";
        $mediatext .= "</td></tr>\n";
    }
    $numrows = tng_num_rows($result);
    tng_free_result($result);

    $mediatext .= "</table>\n";

    return $mediatext;
}

$flags = [];
tng_header($text['mostwanted'], $flags);

$flags['imgprev'] = true;
?>
    <h2 class="header"><span class="headericon" id="mw-hdr-icon"></span><?php echo $text['mostwanted']; ?></h2><br clear="left">
<?php
echo treeDropdown(['startform' => true, 'endform' => true, 'action' => 'mostwanted', 'method' => 'get', 'name' => 'form1', 'id' => 'form1']);

echo "<div class=\"titlebox mwblock\">\n";
echo "<h3 class='subhead'>" . $text['mysperson'] . "</h3>\n";
echo showDivs("person");
echo "</div>\n";

echo "<br>\n";

echo "<div class=\"titlebox mwblock\">\n";
echo "<h3 class='subhead'>" . $text['mysphoto'] . "</h3>\n";
echo showDivs("photo");
echo "</div>\n";

tng_footer($flags);
?>