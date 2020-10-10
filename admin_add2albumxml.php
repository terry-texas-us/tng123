<?php

include "begin.php";
include "adminlib.php";
$textpart = "photos";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";

initMediaTypes();

function get_album_nav($total, $perpage, $pagenavpages) {
    global $page, $totalpages, $text, $orgtree, $albumID, $searchstring, $mediatypeID, $hsstat, $cemeteryID;

    if (!$page) {
        $page = 1;
    }
    if (!$perpage) {
        $perpage = 50;
    }

    if ($total <= $perpage) {
        return "";
    }

    $totalpages = ceil($total / $perpage);
    if ($page > $totalpages) {
        $page = $totalpages;
    }

    if ($page > 1) {
        $prevpage = $page - 1;
        $navoffset = (($prevpage * $perpage) - $perpage);
        $prevlink = " <a href='#' onclick=\"return getMoreMedia('$searchstring', '$mediatypeID', '$hsstat', '$cemeteryID', '$navoffset', '$orgtree', '$prevpage', '$albumID');\" title=\"{$text['text_prev']}\">&laquo;{$text['text_prev']}</a> ";
    }
    if ($page < $totalpages) {
        $nextpage = $page + 1;
        $navoffset = (($nextpage * $perpage) - $perpage);
        $nextlink = "<a href='#' onclick=\"return getMoreMedia('$searchstring', '$mediatypeID', '$hsstat', '$cemeteryID', '$navoffset', '$orgtree', '$nextpage', '$albumID');\" title=\"{$text['text_next']}\">{$text['text_next']}&raquo;</a>";
    }
    $curpage = 0;
    while ($curpage++ < $totalpages) {
        $navoffset = (($curpage - 1) * $perpage);
        if (($curpage <= $page - $pagenavpages || $curpage >= $page + $pagenavpages) && $pagenavpages) {
            if ($curpage == 1) {
                $firstlink = " <a href='#' onclick=\"return getMoreMedia('$searchstring', '$mediatypeID', '$hsstat', '$cemeteryID', '$navoffset', '$orgtree', '$curpage', '$albumID');\" title=\"{$text['firstpage']}\">&laquo;1</a> ... ";
            }
            if ($curpage == $totalpages) {
                $lastlink = "... <a href='#' onclick=\"return getMoreMedia('$searchstring', '$mediatypeID', '$hsstat', '$cemeteryID', '$navoffset', '$orgtree', '$curpage', '$albumID');\" title=\"{$text['lastpage']}\">$totalpages&raquo;</a>";
            }
        } else {
            if ($curpage == $page) {
                $pagenav .= " [$curpage] ";
            } else {
                $pagenav .= " <a href='#' onclick=\"return getMoreMedia('$searchstring', '$mediatypeID', '$hsstat', '$cemeteryID', '$navoffset', '$orgtree', '$curpage', '$albumID');\">$curpage</a> ";
            }
        }
    }
    $pagenav = "<span class='normal'>$prevlink $firstlink $pagenav $lastlink $nextlink</span>";

    return $pagenav;
}

$wherestr = $searchstring ? "($media_table.mediaID LIKE \"%$searchstring%\" OR description LIKE \"%$searchstring%\" OR path LIKE \"%$searchstring%\" OR notes LIKE \"%$searchstring%\" OR owner LIKE \"%$searchstring%\" OR bodytext LIKE \"%$searchstring%\")" : "";
if ($searchtree) {
    $wherestr .= $wherestr ? " AND (gedcom = '' OR gedcom = \"$searchtree\")" : "(gedcom = '' OR gedcom = \"$searchtree\")";
}
if ($mediatypeID) {
    $wherestr .= $wherestr ? " AND mediatypeID = \"$mediatypeID\"" : "mediatypeID = \"$mediatypeID\"";
}
if ($fileext) {
    $wherestr .= $wherestr ? " AND form = \"$fileext\"" : "form = \"$fileext\"";
}
if ($hsstat) {
    $wherestr .= $wherestr ? " AND status = \"$hsstat\"" : "status = \"$hsstat\"";
}
if ($cemeteryID) {
    $wherestr .= $wherestr ? " AND cemeteryID = \"$cemeteryID\"" : "cemeteryID = \"$cemeteryID\"";
}
if ($wherestr) {
    $wherestr = "WHERE $wherestr";
}

if (isset($offset) && $offset != 0) {
    $offsetplus = $offset + 1;
    $newoffset = "$offset, ";
} else {
    $offset = 0;
    $offsetplus = 1;
    $newoffset = "";
    $page = 1;
}
// TODO $medialinkID and $join undefined in sql query
$query = "SELECT $media_table.mediaID AS mediaID, $medialinkID description, notes, thumbpath, mediatypeID, usecollfolder, datetaken, $media_table.gedcom FROM $media_table $join $wherestr ORDER BY description LIMIT $newoffset" . $maxsearchresults;
$result = tng_query($query);

$numrows = tng_num_rows($result);
if ($numrows == $maxsearchresults || $offsetplus > 1) {
// TODO $join undefined in sql query
    $query = "SELECT count($media_table.mediaID) AS mcount FROM $media_table $join $wherestr";
    $result2 = tng_query($query);
    $row = tng_fetch_assoc($result2);
    $totrows = $row['mcount'];
    tng_free_result($result2);
} else {
    $totrows = $numrows;
}

if ($albumID) {
    $query2 = "SELECT mediaID FROM $albumlinks_table WHERE albumID = \"$albumID\"";
    $result2 = tng_query($query2) or die ($admtext['cannotexecutequery'] . ": $query2");
    $alreadygot = [];
    while ($row2 = tng_fetch_assoc($result2))
        $alreadygot[] = $row2['mediaID'];
    tng_free_result($result2);
} else {
    $alreadygot[] = [];
}

header("Content-type:text/html; charset=" . $session_charset);

$numrowsplus = $numrows + $offset;
if (!$numrowsplus) {
    $offsetplus = 0;
}
echo "<p class='normal'>{$admtext['matches']}: $offsetplus {$text['to']} $numrowsplus {$text['of']} $totrows";
$pagenav = get_album_nav($totrows, $maxsearchresults, 5);
echo " &nbsp; <span class='adminnav'>$pagenav</span></p>";
?>
    <table cellpadding="3" cellspacing="1" width="705" class="normal">
        <tr>
            <th class="fieldnameback" width="50"><span class="fieldname"><?php echo $admtext['select']; ?></span></th>
            <th class="fieldnameback"><span class="fieldname"><?php echo $admtext['thumb']; ?></span></th>
            <th class="fieldnameback"><span class="fieldname"><?php echo $admtext['description']; ?></span></th>
            <th class="fieldnameback"><span class="fieldname"><?php echo $admtext['date']; ?></span></th>
            <th class="fieldnameback"><span class="fieldname"><?php echo $admtext['mediatype']; ?></span></th>
        </tr>
        <?php
        while ($row = tng_fetch_assoc($result)) {
            $mtypeID = $row['mediatypeID'];
            $label = $mediatypes_display[$mtypeID] ? $mediatypes_display[$mtypeID] : $text[$mtypeID];
            $treestr = $tngconfig['mediatrees'] && $row['gedcom'] ? $row['gedcom'] . "/" : "";
            $usefolder = $row['usecollfolder'] ? $mediatypes_assoc[$mtypeID] : $mediapath;
            echo "<tr id=\"addrow_{$row['mediaID']}\"><td class='lightback text-center'>";
            echo "<div id=\"add_{$row['mediaID']}\" class=\"normal\"";
            $gotit = in_array($row['mediaID'], $alreadygot);
            if ($gotit) {
                echo " style='display: none;'";
            }
            if ($albumID) {
                echo "><a href='#' onclick=\"return addToAlbum('{$row['mediaID']}');\">" . $admtext['add'] . "</a></div>";
            } else {
                echo "><a href='#' onclick=\"return selectMedia('{$row['mediaID']}');\">" . $admtext['select'] . "</a></div>";
            }
            echo "<div id=\"added_{$row['mediaID']}\"";
            if (!$gotit) {
                echo " style='display: none;'>";
            } else {
                echo "><img src=\"img/tng_test.gif\" alt='' width='20' height='20' class=\"smallicon\">";
            }
            echo "</div>";
            echo "&nbsp;</td>";
            echo "<td class='lightback text-center' id=\"thumbcell_{$row['mediaID']}\">";
            if ($row['thumbpath'] && file_exists("$rootpath$usefolder/$treestr" . $row['thumbpath'])) {
                $size = @GetImageSize("$rootpath$usefolder/$treestr" . $row['thumbpath']);
                echo "<a href=\"admin_editmedia.php?mediaID={$row['mediaID']}\" target='_blank'><img border=0 src=\"$usefolder/$treestr" . str_replace("%2F", "/", rawurlencode($row['thumbpath'])) . "\" $size[3]></a>\n";
            } else {
                echo "&nbsp;";
            }
            echo "</td>\n";
            $truncated = substr($row['notes'], 0, 90);
            $truncated = strlen($row['notes']) > 90 ? substr($truncated, 0, strrpos($truncated, ' ')) . '&hellip;' : $row['notes'];
            echo "<td class='lightback normal' id=\"desc_{$row['mediaID']}\"><a href=\"admin_editmedia.php?mediaID={$row['mediaID']}\">{$row['description']}</a><br>$truncated &nbsp;</td>";
            echo "<td class='lightback normal' style=\"width:100px;\" id=\"date_{$row['mediaID']}\">{$row['datetaken']}&nbsp;</td>\n";
            echo "<td class='lightback'><span class='normal' id=\"mtype_{$row['mediaID']}\">" . $label . "&nbsp;</span></td>\n";
            echo "</tr>\n";
        }
        ?>
    </table>
<?php
echo "<p class='normal'>{$admtext['matches']}: $offsetplus {$text['to']} $numrowsplus {$text['of']} $totrows";
echo " &nbsp; <span class='adminnav'>$pagenav</span></p>";
?>