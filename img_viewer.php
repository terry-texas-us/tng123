<?php
$textpart = "imgviewer";
include "tng_begin.php";

include "functions.php";

if ($medialinkID) {
    $query = "SELECT mediatypeID, personID, linktype, $medialinks_table.gedcom AS gedcom, eventID, ordernum FROM ($media_table, $medialinks_table) WHERE medialinkID = \"$medialinkID\" AND $media_table.mediaID = $medialinks_table.mediaID";
    $result = tng_query($query);
    $row = tng_fetch_assoc($result);
    $personID = $row['personID'];
    if (!$requirelogin || !$treerestrict || !$assignedtree) {
        $tree = $row['gedcom'];
    }
    $ordernum = $row['ordernum'];
    $mediatypeID = $row['mediatypeID'];
    $linktype = $row['linktype'];
    if ($linktype == "P") $linktype = "I";

    $eventID = $row['eventID'];
} else {
    $query = "SELECT mediatypeID, gedcom FROM $media_table WHERE mediaID = \"$mediaID\"";
    $result = tng_query($query);
    $row = tng_fetch_assoc($result);
    $mediatypeID = $row['mediatypeID'];
    if (!$requirelogin || !$treerestrict || !$assignedtree) {
        $tree = $row['gedcom'];
    }
}

if ($requirelogin && $treerestrict && $assignedtree && $row['gedcom'] && $row['gedcom'] != $assignedtree) {
    header("location: browsemedia.php?");
    exit;
}
if (!tng_num_rows($result)) {
    tng_free_result($result);
    header("Location: thispagedoesnotexist.html");
}
include "checklogin.php";
include "showmedialib.php";

$info = getMediaInfo($mediatypeID, $mediaID, $personID, $albumID, $albumlinkID, $cemeteryID, $eventID);
$imgrow = $info['imgrow'];

echo "<!doctype html>\n";
echo "<html lang='en'>\n";

$flags['link'] = "<link href='build/styles/img_viewer.css' rel='stylesheet'>\n";
$flags['scripting'] = "<script src='js/img_viewer.js'></script>\n";
$flags['noheader'] = true;
$flags['noicons'] = true;
$flags['nobody'] = true;
$flags['nomobile'] = true;

tng_header($imgrow['description'], $flags);
echo '<body style="background-image: none;">';

$usefolder = $imgrow['usecollfolder'] ? $mediatypes_assoc[$mediatypeID] : $mediapath;
$treestr = $tngconfig['mediatrees'] && $imgrow['gedcom'] ? $imgrow['gedcom'] . "/" : "";
if ($imgrow['abspath'] || substr($imgrow['path'], 0, 4) == "http" || substr($imgrow['path'], 0, 1) == "/") {
    $mediasrc = $imgrow['path'];
} else {
    $mediasrc = "$usefolder/$treestr" . str_replace("%2F", "/", rawurlencode($imgrow['path']));
}

// get image info
if (substr($imgrow['path'], 0, 4) == "http") {
    [$width, $height] = @getimagesize($imgrow['path']);
} else {
    [$width, $height] = @getimagesize("$rootpath$usefolder/$treestr" . $imgrow['path']);
}

$maxw = $tngconfig['imgmaxw'];
$maxh = $tngconfig['imgmaxh'];
$orgwidth = $width;
$orgheight = $height;

if ($maxw && ($width > $maxw)) {
    $width = $maxw;
    $height = floor($width * $orgheight / $orgwidth);
}
if ($maxh && ($height > $maxh)) {
    $height = $maxh;
    $width = floor($height * $orgwidth / $orgheight);
}
$float = strpos($_SERVER['HTTP_USER_AGENT'], "MSIE 7") > 0 ? " style=\"float:left\"" : "";
?>
<div id="imgviewer"<?php echo $float; ?>>
    <map name="imgMapViewer" id="imgMapViewer"><?php echo $imgrow['map']; ?></map>
    <?php
    // clean up the description
    $imgrow['description'] = str_replace("\r\n", "<br>", $imgrow['description']);
    $imgrow['description'] = str_replace("\n", "<br>", $imgrow['description']);

    // if running in standalone mode we need to display the title and notes info
    if (isset($_GET['sa'])) {
        $sa = 1;
        if (!empty($imgrow['description'])) {
            echo "<h3 class='subhead' id=\"img_desc\">{$imgrow['description']}</h3>";
        }
        if (!empty($imgrow['notes'])) {
            echo "<p class='normal' id=\"img_notes\">{$imgrow['notes']}</p>";
        }
    } else {
        $sa = 0;
    }
    ?>
</div>
<script>
    <?php
    echo "var magmode_msg = \"{$text['magmode']}\";\n";
    echo "var zoomin_msg = \"{$text['zoomin']}\";\n";
    echo "var zoomout_msg = \"{$text['zoomout']}\";\n";
    echo "var panmode_msg = \"{$text['panmode']}\";\n";
    echo "var pan_msg = \"{$text['pan']}\";\n";
    echo "var magnifyreg_msg = \"{$text['magnifyreg']}\";\n";
    echo "var fw_msg = \"{$text['fitwidth']}\";\n";
    echo "var fh_msg = \"{$text['fitheight']}\";\n";
    echo "var nw_msg = \"{$text['newwin']}\";\n";
    echo "var opennw_msg = \"{$text['opennw']}\";\n";
    echo "var imgctrls_msg = \"{$text['imgctrls']}\";\n";
    echo "var vwrctrls_msg = \"{$text['vwrctrls']}\";\n";
    echo "var close_msg = \"{$text['vwrclose']}\";\n";
    echo "var imgnewwin_url = \"img_newwin.php?\";\n";
    echo "if(parent.document.getElementById(window.name)) {viewer = imageViewer(\"imgviewer\", \"$mediasrc\", \"$width\", \"$height\", $sa, \"$mediaID\", \"$medialinkID\", \"" . urlencode($imgrow['description']) . "\");}\n";
    ?>
</script>
</body>
</html>