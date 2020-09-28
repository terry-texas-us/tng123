<?php
$textpart = "showphoto";
include "tng_begin.php";

if (!is_numeric($mediaID)) {
    header("Location: thispagedoesnotexist.html");
    exit;
}

include "functions.php";
include "personlib.php";

//starting time between slides
$slidetime_display = "3.0";
//starting time in microseconds
$slidetime_micro = 3000;

initMediaTypes();

$mediaID = preg_replace("/[^0-9]/", '', $mediaID);
$medialinkID = preg_replace("/[^0-9]/", '', $medialinkID);
$albumlinkID = preg_replace("/[^0-9]/", '', $albumlinkID);
$cemeteryID = preg_replace("/[^0-9]/", '', $cemeteryID);

if ($medialinkID) {
    //look up media & medialinks joined
    //get info for linked person/family/source/repo
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
    if ($linktype == "P") {
        $linktype = "I";
    }
    $eventID = $row['eventID'];
} else {
    if ($albumlinkID) {
        $query = "SELECT albumname, description, ordernum, $albums_table.albumID AS albumID FROM ($albums_table, $albumlinks_table)
			WHERE albumlinkID = \"$albumlinkID\" AND $albumlinks_table.albumID = $albums_table.albumID";
        $result = tng_query($query);
        $row = tng_fetch_assoc($result);
        $ordernum = $row['ordernum'];
        $albumID = $row['albumID'];
        $albumname = $row['albumname'];
        $albdesc = $row['description'];
        tng_free_result($result);
    }
    $query = "SELECT mediatypeID, gedcom FROM $media_table WHERE mediaID = \"$mediaID\"";
    $result = tng_query($query);
    $row = tng_fetch_assoc($result);
    $mediatypeID = $row['mediatypeID'];
    if (!$requirelogin || !$treerestrict || !$assignedtree) {
        $tree = $row['gedcom'];
    }
}
//redirect if we're not supposed to be here
if ($requirelogin && $treerestrict && $assignedtree && $row['gedcom'] && $row['gedcom'] != $assignedtree) {
    header("location: browsemedia.php?");
    exit;
}
if (!tng_num_rows($result)) {
    tng_free_result($result);
    header("Location: thispagedoesnotexist.html");
    exit;
}
include "checklogin.php";
include "showmedialib.php";

$mediaperpage = 1;
$max_showmedia_pages = 5;

$info = getMediaInfo($mediatypeID, $mediaID, $personID, $albumID, $albumlinkID, $cemeteryID, $eventID);
$ordernum = $info['ordernum'];
$mediaID = $info['mediaID'];
$medianotes = $info['medianotes'];
$mediadescription = $info['mediadescription'];
$page = $info['page'];
$result = $info['result'];
$imgrow = $info['imgrow'];
if (isMobile() || ($imgrow['form'] && !in_array($imgrow['form'], $imagetypes))) {
    $tngconfig['ssdisabled'] = 1;
}
$numitems = tng_num_rows($result);

if ($personID && !$albumlinkID) {
    if ($linktype == "L") {
        $row['allow_living'] = 1;
        $rightbranch = 1;
    } else {
        if ($linktype == "F") {
            $query = "SELECT familyID, husband, wife, living, marrdate, gedcom, branch FROM $families_table WHERE familyID = \"$personID\" AND gedcom = '$tree'";
        } elseif ($linktype == "S") {
            $query = "SELECT title FROM $sources_table WHERE sourceID = \"$personID\" AND gedcom = '$tree'";
        } elseif ($linktype == "R") {
            $query = "SELECT reponame FROM $repositories_table WHERE repoID = \"$personID\" AND gedcom = '$tree'";
        } elseif ($linktype == "I") {
            $query = "SELECT lastname, firstname, prefix, suffix, title, lnprefix, living, private, branch, $people_table.gedcom, birthdate, birthdatetr, altbirthdate, altbirthdatetr, deathdate, deathdatetr, burialdate, burialdatetr, sex, disallowgedcreate, IF(birthdatetr !='0000-00-00',YEAR(birthdatetr),YEAR(altbirthdatetr)) AS birth, IF(deathdatetr !='0000-00-00',YEAR(deathdatetr),YEAR(burialdatetr)) AS death
				FROM $people_table, $trees_table WHERE personID = \"$personID\" AND $people_table.gedcom = '$tree' AND $people_table.gedcom = $trees_table.gedcom";
        }
        $result2 = tng_query($query);
        if ($result2) {
            $row = tng_fetch_assoc($result2);
            if ($linktype == "S" || $linktype == "R") {
                $row['allow_living'] = $row['allow_private'] = 1;
                $rightbranch = 1;
            } else {
                $righttree = checktree($tree);
                $rightbranch = $righttree ? checkbranch($row['branch']) : false;
                $rights = determineLivingPrivateRights($row, $righttree, $rightbranch);
                $row['allow_living'] = $rights['living'];
                $row['allow_private'] = $rights['private'];
                $disallowgedcreate = $row['disallowgedcreate'];
            }
            tng_free_result($result2);
        }
    }
}

$livinginfo = findLivingPrivate($mediaID, $tree);
$noneliving = $livinginfo['noneliving'] && $livinginfo['noneprivate'];

$showPhotoInfo = $imgrow['alwayson'] || $noneliving;
$nonamesloc = $livinginfo['private'] ? $tngconfig['nnpriv'] : $nonames;

if ($noneliving || !$nonamesloc || $imgrow['alwayson']) {
    $description = preg_replace("/\"/", "&#34;", $mediadescription);
    $notes = nl2br(getXrefNotes($medianotes, $tree));
    $mapnote = $info['gotmap'] ? "<p>" . $text['mediamaptext'] . "</p>\n" : "";
} else {
    $description = $notes = ($livinginfo['private'] ? $admtext['text_private'] : $text['living']);
    $mapnote = "";
}
$logdesc = $nonamesloc && !$noneliving && !$imgrow['alwayson'] ? ($livinginfo['private'] ? $admtext['text_private'] : $text['living']) : $description;
$mediatypeIDstr = $text[$mediatypeID] ? $text[$mediatypeID] : $mediatypes_display[$mediatypeID];

if (!$personID) {
    writelog("<a href=\"showmedia.php?mediaID=$mediaID&amp;tnggallery=$tnggallery\">$mediatypeIDstr: $logdesc ($mediaID)</a>");
    preparebookmark("<a href=\"showmedia.php?mediaID=$mediaID&amp;tnggallery=$tnggallery\">$mediatypeIDstr: $description ($mediaID)</a>");
} elseif ($albumlinkID) {
    writelog("<a href=\"showmedia.php?mediaID=$mediaID&amp;albumlinkID=$albumlinkID&amp;tnggallery=$tnggallery\">{$text['albums']}: $logdesc ($mediaID)</a>");
    preparebookmark("<a href=\"showmedia.php?mediaID=$mediaID&amp;albumlinkID=$albumlinkID&amp;tnggallery=$tnggallery\">{$text['albums']}: $description ($mediaID)</a>");
} else {
    writelog("<a href=\"showmedia.php?mediaID=$mediaID&amp;medialinkID=$medialinkID\">$mediatypeIDstr: $logdesc ($mediaID)</a>");
    preparebookmark("<a href=\"showmedia.php?mediaID=$mediaID&amp;medialinkID=$medialinkID\">$mediatypeIDstr: $description ($mediaID)</a>");
}

$flags['tabs'] = $tngconfig['tabs'];
$flags['link'] = "<link href='css/media.css' rel='stylesheet'>\n";
if (!$tngprint) {
    $flags['scripting'] = "<script src=\"js/slideshow.js\"></script>\n";
    $flags['scripting'] .= "<script>\n";
    $flags['scripting'] .= "var showmediaxmlfile = 'ajx_showmediaxml.php?';\n";
    $flags['scripting'] .= "</script>\n";
}

$imageFolder = $imgrow['usecollfolder'] ? $mediatypes_assoc[$mediatypeID] : $mediapath;
$fixImagePath = str_replace(' ', '%20', $imgrow['path']);
$fbOGimage = "<meta property=\"og:image\" content=\"" . $tngdomain . "/" . $imageFolder . "/" . $fixImagePath . "\">\n";
$fbOGimage = "<meta property=\"og:image\" content=\"" . $tngdomain . "/" . $imageFolder . "/" . $fixImagePath . "\">\n";

echo "<!doctype html>\n";
echo "<html lang='en'>\n";

tng_header($mediatypeIDstr . ": " . $description, $flags);

$imgviewer = $tngconfig['imgviewer'];
if (!$imgviewer || in_array($imgrow['mediatypeID'], $mediatypes_like[$imgviewer])) {
    include "js/img_utils.js";
}

$usefolder = $imgrow['usecollfolder'] ? $mediatypes_assoc[$mediatypeID] : $mediapath;
$size = @GetImageSize("$rootpath$usefolder/" . $imgrow['path'], $info);
$adjheight = $size['1'] - 1;

if (!$tngconfig['ssdisabled'] && !$tngprint && $numitems > 1) {
    $sscontrols = " &nbsp;&nbsp;&nbsp; <a href='#' onclick=\"return start();\" class=\"snlink\">&raquo; {$text['slidestart']}</a>\n";
} else {
    $sscontrols = "";
}

if ($personID) {
    if ($linktype == "I") {
        $namestr = getName($row);
        $years = getYears($row);
        $type = "person";
    } elseif ($linktype == "F") {
        $namestr = $text['family'] . ": " . getFamilyName($row);
        $years = $row['marrdate'] && $row['allow_living'] && $row['allow_private'] ? $text['marrabbr'] . " " . displayDate($row['marrdate']) : "";
        $type = "family";
    } elseif ($linktype == "S") {
        $namestr = $row['title'];
        $type = "source";
    } elseif ($linktype == "R") {
        $namestr = $row['reponame'];
        $type = "repo";
    } else {
        $namestr = $personID;
        $type = "place";
    }
    $mediastr = showSmallPhoto($personID, $namestr, $row['allow_living'] && $row['allow_private'], 0, false, $row['sex']);
    $slideshowheader = $namestr;
    echo tng_DrawHeading($mediastr, $namestr, $years);

    echo tng_menu($linktype, $type, $personID, "&nbsp;");
} else {
    if ($albumlinkID) {
        $mediastr = "<span class='headericon' id=\"albums-hdr-icon\"></span>\n";
        $slideshowheader = $albumname;
        echo tng_DrawHeading($mediastr, $albumname, $albdesc);
    } else {
        $titlemsg = $text[$mediatypeID] ? $text[$mediatypeID] : $mediatypes_display[$mediatypeID];
        $icon = $mediatypes_icons[$mediatypeID];
        if ($mediatypes_icons[$mediatypeID]) {
            $icon = "<img src=\"{$mediatypes_icons[$mediatypeID]}\" width='20' height='20' alt=\"\" class='headericon'/>";
        } else {
            $icon = "<span class='headericon' id=\"{$mediatypeID}-hdr-icon\"></span>";
        }
        echo "<h1 class='header'>$icon$titlemsg</h1>\n";

        $slideshowheader = $titlemsg;
    }
}

if (!$tngprint && !$tngconfig['ssdisabled']) {
    ?>
    <div>
    <?php
}
if (!$tngprint) {
    $pagenav = getMediaNavigation($mediaID, $personID, $albumlinkID, $result, true);

    if ($page < $totalpages) {
        $nextpage = $page + 1;
    } else {
        $nextpage = 1;
    }
    $nextmediaID = get_item_id($result, $nextpage - 1, "mediaID");
    $nextmedialinkID = get_item_id($result, $nextpage - 1, "medialinkID");
    $nextalbumlinkID = get_item_id($result, $nextpage - 1, "albumlinkID");
}
tng_free_result($result);

echo "<p class='normal' style=\"margin-top:2.5em;\">$pagenav$sscontrols</p>";

if ($noneliving || $imgrow['alwayson']) {
    $show_on_top = false;
    if ((isset($mediatypes_like['histories']) && !in_array($mediatypeID, $mediatypes_like['histories'])) || !$imgrow['bodytext']) {
        echo $mapnote;
        showMediaSource($imgrow);
        echo "<br><br>";
        $show_on_top = true;
    }

    echo "<h3 class='subhead'>$description</h3>\n";
    if ($notes) {
        echo "<p class='normal'>$notes</p>\n";
    } else {
        echo "<br><br>";
    }

    if (!$show_on_top) {
        showMediaSource($imgrow);
    }

    if ($mediatypeID == "headstones" && ($imgrow['status'] || $imgrow['plot'])) {
        echo "<p class='normal'>";
        if ($imgrow['status']) {
            $status = $imgrow['status'];
            if ($status && $text[$status]) {
                $imgrow['status'] = $text[$status];
            }
            echo "<b>{$text['status']}:</b> {$imgrow['status']}";
        }
        if ($imgrow['plot']) {
            if ($imgrow['status']) {
                echo "<br>";
            }
            echo "<b>{$text['plot']}:</b> " . nl2br($imgrow['plot']);
        }
        echo "</p>";
    } elseif (!$tngconfig['imgviewer'] || in_array($mediatypeID, $mediatypes_like[$tngconfig['imgviewer']])) {
        echo "<br>\n";
    } else {
        echo "<br>\n";
    }

    $medialinktext = getMediaLinkText($mediaID, $ioffset);
    $albumlinktext = getAlbumLinkText($mediaID);
    echo showTable($imgrow, $medialinktext, $albumlinktext);

    //do cemetery name here for headstones
    //do map here for headstones
    if ($imgrow['cemeteryID']) {
        doCemPlusMap($imgrow, $tree);
    }

    if (!$tngprint) {
        echo "<br><p class='normal'>$pagenav$sscontrols</p><br>\n";
    }
} else {
    ?>
    <div style="border:1px solid black;padding:5px;width:<?php echo $size['0']; ?>px;height:<?php echo $adjheight; ?>px;">
        <strong><span class="normal"><?php echo $livinginfo['private'] ? $admtext['text_private'] : $text['living']; ?></span></strong>
    </div>
    <?php
}
if (!$tngprint && !$tngconfig['ssdisabled']) {
    ?>
    </div>
    <?php
    $flags['more'] = "<script>\n//<![CDATA[\nvar timeoutID;\nvar myslides;\nvar resumemsg='&gt; {$text['slideresume']}';\n";
    $flags['more'] .= "var slidestopmsg = '&gt; {$text['slidestop']}';\n";
    $flags['more'] .= "var startmsg='&gt; {$text['slidestart']}';\n";
    $flags['more'] .= "var plussecsmsg = \"{$text['plussecs']}\";\n";
    $flags['more'] .= "var minussecsmsg = \"{$text['minussecs']}\";\n";
    $flags['more'] .= "var slidesecsmsg = \"{$text['slidesecs']}\";\n";

    if ($ss) {
        $flags['more'] .= "jQuery(document).ready(start);\n";
    }
    if ($imgviewer && !in_array($imgrow['mediatypeID'], $mediatypes_like[$imgviewer])) {
        $flags['more'] .= "jQuery(document).ready(adjustWidth);\n";
        $flags['more'] .= "\nfunction adjustWidth() {\nif(jQuery('#imgdiv').length && jQuery('#theimage').width() > document.getElementById('imgdiv').clientWidth) \njQuery('#imgdiv').width(jQuery('#theimage').width() + \"px\");\n}\n";
    }
    $slideshowheader = preg_replace("/\"/", "&#34;", $slideshowheader);
    $flags['more'] .= $tngconfig['ssrepeat'] ? "\nrepeat = true;\n" : "\nrepeat = false;\n";
    $flags['more'] .= "\nfunction start() {\n";
    $flags['more'] .= "tnglitbox = new LITBox(\"ajx_slideshow.php?mediaID=$mediaID&medialinkID=$medialinkID&albumlinkID=$albumlinkID&cemeteryID=$cemeteryID\", {width:900, height:675, title:'" . addslashes(truncateIt($slideshowheader, 100)) . "',onremove:function(){tnglitbox=null;timeoutID=null;},doneLoading:startSlides});\n";
    $flags['more'] .= "jQuery('#slidetoggle').click(function() {stopshow();return false;});\n";
    $flags['more'] .= "return false;}\n";
    $flags['more'] .= "\nfunction startSlides() {\n";
    $flags['more'] .= "myslides = new Slideshow({timeout:$slidetime_micro, startingID:'$mediaID', mediaID:'$nextmediaID', medialinkID:'$nextmedialinkID', albumlinkID:'$nextalbumlinkID', cemeteryID:'$cemeteryID'});\n";
    $flags['more'] .= "}\n";
    $flags['more'] .= "//]]>\n</script>\n";
}
echo "<br><br>\n";

tng_footer($flags);
?>