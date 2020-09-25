<?php
function getPhotoSrc($persfamID, $living, $gender) {
    global $rootpath, $photopath, $mediapath, $mediatypes_assoc;
    global $photosext, $tree, $medialinks_table, $media_table, $tngconfig;

    $photo = [];

    $query = "SELECT media.mediaID, medialinkID, alwayson, thumbpath, mediatypeID, usecollfolder ";
    $query .= "FROM ($media_table media, $medialinks_table medialinks) ";
    $query .= "WHERE personID = '$persfamID' AND medialinks.gedcom = '$tree' AND media.mediaID = medialinks.mediaID AND defphoto = '1'";
    $result = tng_query($query);
    $row = tng_fetch_assoc($result);

    $photocheck = "";
    if ($row['thumbpath']) {
        if ($row['alwayson'] || checkLivingLinks($row['mediaID'])) {
            $mediatypeID = $row['mediatypeID'];
            $usefolder = $row['usecollfolder'] ? $mediatypes_assoc[$mediatypeID] : $mediapath;
            $photocheck = "$usefolder/" . $row['thumbpath'];
            $photoref = "$usefolder/" . str_replace("%2F", "/", rawurlencode($row['thumbpath']));
            $photolink = xmlcharacters("showmedia.php?mediaID={$row['mediaID']}&amp;medialinkID={$row['medialinkID']}");
        }
    } elseif ($living) {
        $photoref = $photocheck = $tree ? "$photopath/$tree.$persfamID.$photosext" : "$photopath/$persfamID.$photosext";
        $photolink = "";
    }

    $gotfile = $photocheck ? file_exists("$rootpath$photocheck") : false;
    if (!$gotfile) {
        if ($gender && $tngconfig['usedefthumbs']) {
            if ($gender == "M") {
                $photocheck = "img/male.jpg";
            } elseif ($gender == "F") {
                $photocheck = "img/female.jpg";
            }
            $photoref = $photocheck;
            $gotfile = file_exists("$rootpath$photocheck");
        }
    }
    if ($gotfile) {
        $photo['ref'] = $photoref;
        $photo['link'] = $photolink;
    } else {
        $photo['ref'] = "";
        $photo['link'] = "";
    }

    return $photo;
}
