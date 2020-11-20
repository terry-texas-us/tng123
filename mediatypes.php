<?php
//NOTES: "ID" is also the ID in alltext.php that holds the text to be displayed (ie, $text[photo] = "Photo"). It will exist in each language file.
//"Folder" is the location where files of this type are generally held.

global $photopath, $documentpath, $historypath, $headstonepath, $mediapath;
$mediatypes = [];
$mediatypes_assoc = [];
$mediatypes_icons = [];
$mediatypes_thumbs = [];
$mediatypes_display = [];
$mediatypes_like = [];
$mediatypeObjs = [];
$mctr = 0;
$maxmediafilesize = 5000000; //5 Mb is too large to create a thumbnail

/**
 * @param $newtype
 */
function setMediaType($newtype) {
    global $mediatypes, $mediatypes_assoc, $mediatypes_icons, $mediatypes_thumbs, $mediatypes_display, $mediatypes_like, $mediatypeObjs, $mctr;
    global $mediatypes_locpaths, $text;

    $ID = $newtype['mediatypeID'];

    $mediatypes[$mctr] = $newtype;
    if (isset($text[$ID])) {
        $mediatypes[$mctr]['display'] = $text[$ID];
    }
    $mediatypes[$mctr]['ID'] = $ID;

    $mediatypeObjs[$ID] = $mediatypes[$mctr];

    $mediatypes_assoc[$ID] = $newtype['path'];
    $mediatypes_locpaths[$ID] = isset($newtype['localpath']) ? $newtype['localpath'] : "";
    $mediatypes_icons[$ID] = $newtype['icon'];
    $mediatypes_thumbs[$ID] = $newtype['thumb'];
    $mediatypes_display[$ID] = isset($newtype['display']) ? $newtype['display'] : "";
    $mediatypes_like[$newtype['liketype']][] = $ID;
    $mctr++;
}

// To change display order of these groups, simply move the corresponding lines below up or down.

function initMediaTypes() {
    global $photopath, $documentpath, $headstonepath, $historypath, $mediapath, $mediatypes_table, $mediatypes;

    if (count($mediatypes)) return;

if (!isset($mediatypes_table)) return;
    $query = "SELECT * FROM $mediatypes_table ORDER BY ordernum, display";
    $result = @tng_query($query);

    if ($result) {
        while ($row = tng_fetch_assoc($result)) {
            switch ($row['mediatypeID']) {
                case "photos":
                    setMediaType([
                        "mediatypeID" => "photos",
                        "path" => $photopath,
                        "icon" => "",
                        "thumb" => "photos_thumb.png",
                        "liketype" => "photos",
                        "exportas" => "PHOTO",
                        "type" => 0,
                        "disabled" => $row['disabled']
                    ]);
                    break;
                case "documents":
                    setMediaType([
                        "mediatypeID" => "documents",
                        "path" => $documentpath,
                        "icon" => "",
                        "thumb" => "documents_thumb.png",
                        "liketype" => "documents",
                        "exportas" => "DOCUMENT",
                        "type" => 0,
                        "disabled" => $row['disabled']
                    ]);
                    break;
                case "headstones":
                    setMediaType([
                        "mediatypeID" => "headstones",
                        "path" => $headstonepath,
                        "icon" => "",
                        "thumb" => "headstones_thumb.png",
                        "liketype" => "headstones",
                        "exportas" => "HEADSTONE",
                        "type" => 0,
                        "disabled" => $row['disabled']
                    ]);
                    break;
                case "histories":
                    setMediaType([
                        "mediatypeID" => "histories",
                        "path" => $historypath,
                        "icon" => "",
                        "thumb" => "histories_thumb.png",
                        "liketype" => "histories",
                        "exportas" => "HISTORY",
                        "type" => 0,
                        "disabled" => $row['disabled']
                    ]);
                    break;
                case "recordings":
                    setMediaType([
                        "mediatypeID" => "recordings",
                        "path" => $mediapath,
                        "icon" => "",
                        "thumb" => "recordings_thumb.png",
                        "liketype" => "recordings",
                        "exportas" => "RECORDING",
                        "type" => 0,
                        "disabled" => $row['disabled']
                    ]);
                    break;
                case "videos":
                    setMediaType([
                        "mediatypeID" => "videos",
                        "path" => $mediapath,
                        "icon" => "",
                        "thumb" => "videos_thumb.png",
                        "liketype" => "videos",
                        "exportas" => "VIDEO",
                        "type" => 0,
                        "disabled" => $row['disabled']
                    ]);
                    break;
                default:
                    $row['type'] = 1;
                    setMediaType($row);
                    break;
            }
        }
        tng_free_result($result);
    }
}
