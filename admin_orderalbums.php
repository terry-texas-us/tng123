<?php
include "begin.php";
include "adminlib.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
require "adminlog.php";

initMediaTypes();

//mediatypeID and linktype should be passed in
$personID = ucfirst($newlink1);
$linktype = $linktype1;
$eventID = $event1;
$tree = $tree1;

$sortstr = preg_replace("/xxx/", _('Albums'), _('Sort xxx for'));

switch ($linktype) {
    case "I":
        $query = "SELECT lastname, lnprefix, firstname, prefix, suffix, nameorder, branch FROM $people_table WHERE personID='$personID' AND gedcom = '$tree'";
        $result2 = tng_query($query);
        $person = tng_fetch_assoc($result2);
        $person['allow_living'] = 1;
        $namestr = "$personID: " . getName($person);
        tng_free_result($result2);
        break;
    case "F":
        $query = "SELECT branch FROM $families_table WHERE familyID=\"$personID\" AND gedcom = '$tree'";
        $result2 = tng_query($query);
        $person = tng_fetch_assoc($result2);
        $namestr = "" . _('Family') . ": $personID";
        tng_free_result($result2);
        break;
    case "S":
        $query = "SELECT title FROM $sources_table WHERE sourceID=\"$personID\" AND gedcom = '$tree'";
        $result2 = tng_query($query);
        $person = tng_fetch_assoc($result2);
        $namestr = "" . _('Source') . ": $personID";
        if ($person['title']) $namestr .= ", " . $person['title'];

        $person['branch'] = "";
        tng_free_result($result2);
        break;
    case "R":
        $query = "SELECT reponame FROM $repositories_table WHERE repoID=\"$personID\" AND gedcom = '$tree'";
        $result2 = tng_query($query);
        $person = tng_fetch_assoc($result2);
        $namestr = "" . _('Repository') . ": $personID";
        if ($person['reponame']) $namestr .= ", " . $person['reponame'];

        $person['branch'] = "";
        tng_free_result($result2);
        break;
    case "L":
        $namestr = $personID;
        $person['branch'] = "";
        break;
}

if (!checkbranch($person['branch'])) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

adminwritelog("<a href=\"admin_ordermedia.php?personID=$personID&amp;tree=$tree\">$sortstr: $action</a>");

$photofound = 0;
$photo = "";

$query = "SELECT alwayson, thumbpath, $media_table.mediaID AS mediaID, usecollfolder, mediatypeID, medialinkID FROM ($media_table, $medialinks_table)
	WHERE personID = \"$personID\" AND $medialinks_table.gedcom = '$tree' AND $media_table.mediaID = $medialinks_table.mediaID AND defphoto = '1'";
$result = tng_query($query);
if ($result) $row = tng_fetch_assoc($result);

$thismediatypeID = $row['mediatypeID'];
$usefolder = $row['usecollfolder'] ? $mediatypes_assoc[$thismediatypeID] : $mediapath;
tng_free_result($result);

if ($row['thumbpath']) {
    $photoref = "$usefolder/" . $row['thumbpath'];
} else {
    $photoref = $tree ? "$usefolder/$tree.$personID.$photosext" : "$photopath/$personID.$photosext";
}

if (file_exists("$rootpath$photoref")) {
    $photoinfo = @getimagesize("$rootpath$photoref");
    if ($photoinfo[1] <= $thumbmaxh) {
        $photohtouse = $photoinfo[1];
        $photowtouse = $photoinfo[0];
    } else {
        $photohtouse = $thumbmaxh;
        $photowtouse = intval($thumbmaxh * $photoinfo[0] / $photoinfo[1]);
    }
    $photo = "<img src=\"" . str_replace("%2F", "/", rawurlencode($photoref)) . "?" . time() . "\" alt=\"\" width=\"$photowtouse\" height=\"$photohtouse\" align=\"left\" style=\"border-width:1;border-style:solid;margin-right:10px\">";
    $photofound = 1;
}

$query = "SELECT * FROM ($album2entities_table, $albums_table) WHERE $album2entities_table.entityID=\"$personID\" AND $album2entities_table.gedcom = '$tree' AND $albums_table.albumID = $album2entities_table.albumID ORDER BY ordernum";
$result = tng_query($query);

$numrows = tng_num_rows($result);

if (!$numrows) {
    $message = _('No results found. Please try again.');
    header("Location: admin_orderalbumform.php?personID=$personID&message=" . urlencode($message));
    exit;
}

$helplang = findhelp("media_help.php");

tng_adminheader($sortstr, $flags);

?>
<script>
    var entity = "<?php echo $personID; ?>";
    var album = "<?php echo $albumID; ?>";
    var tree = "<?php echo $tree; ?>";
    var orderaction = "alborder";
</script>
    <script src="js/albums.js"></script>
    <script src="js/selectutils.js"></script>
    <script src="js/mediautils.js"></script>
    </head>

<?php
echo tng_adminlayout(" onload=\"startMediaSort()\"");

$albumtabs[0] = [1, "admin_albums.php", _('Search'), "findalbum"];
$albumtabs[1] = [$allow_add, "admin_newalbum.php", _('Add New'), "addalbum"];
$albumtabs[2] = [$allow_edit, "admin_orderalbumform.php", _('Sort'), "sortalbums"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/albums_help.php#sort');\" class='lightlink'>" . _('Help for this area') . "</a>";
$menu = doMenu($albumtabs, "sortalbums", $innermenu);
echo displayHeadline(_('Albums') . " &gt;&gt; " . _('Sort'), "img/albums_icon.gif", $menu, "");
?>

    <table class="lightback">
        <tr class="databack">
            <td class="tngshadow">
                <span class="subhead"><?php echo "<div id=\"thumbholder\" style=\"float:left;\">$photo</div><strong>$sortstr<br>$namestr</strong>"; ?></span><br>
                <br style="clear: left;">
                <br>
                <table id="ordertbl" class="fieldname normal">
                    <tr>
                        <th class="fieldnameback" style="width:102px;"><?php echo _('Sort'); ?></th>
                        <th class="fieldnameback" style="width:<?php echo($thumbmaxw + 10); ?>px;"><?php echo _('Thumb'); ?></th>
                        <th class="fieldnameback"><?php echo _('Description'); ?></th>
                    </tr>
                </table>

                <form name="form1">
                    <div id="orderdivs">
                        <?php
                        $result = tng_query($query);
                        $count = 1;
                        while ($row = tng_fetch_assoc($result)) {
                            $usefolder = $row['usecollfolder'] ? $mediatypes_assoc[$mediatypeID] : $mediapath;
                        $truncated = substr($row['description'], 0, 90);
                        $truncated = strlen($row['description']) > 90 ? substr($truncated, 0, strrpos($truncated, ' ')) . '&hellip;' : $row['description'];
                        echo "<div class='sortrow' id=\"orderdivs_{$row['alinkID']}\" style=\"clear:both;position:relative;\" onmouseover=\"jQuery('#md_{$row['albumID']}').css('visibility','visible');\" onmouseout=\"jQuery('#md_{$row['albumID']}').css('visibility','hidden');\">";
                        echo "<table class='w-full' cellpadding='5' cellspacing='1'><tr>\n";
                            echo "<td class='dragarea rounded-lg normal'>";
                            echo "<img src='img/admArrowUp.gif' alt='' class='inline-block'>" . _('Drag') . "<img src='img/admArrowDown.gif' alt='' class='inline-block'>\n";
                            echo "</td>\n";
                            echo "<td class='lightback smaller' style=\"width:35px;text-align:center;\">";
                            echo "<div style=\"padding-bottom:5px;\"><a href='#' onclick=\"return moveItemInList('{$row['alinkID']}',1);\" title=\"" . _('Move to top') . "\"><img src='img/admArrowUp.gif' alt='' class='inline-block'><br>" . _('Top') . "</a></div>\n";
                            echo "<input style=\"width:30px;\" class=\"movefields\" name=\"move{$row['alinkID']}\" id=\"move{$row['alinkID']}\" value=\"$count\" onkeypress=\"handleMediaEnter('{$row['alinkID']}',jQuery('#move{$row['alinkID']}').val(),event);\">\n";
                            echo "<a href='#' onclick=\"return moveItemInList('{$row['alinkID']}',jQuery('#move{$row['alinkID']}').val());\" title=\"" . _('Move to top') . "\">" . _('Go') . "</a>\n";
                            echo "</td>\n";
                        echo "<td class='lightback' style=\"width:" . ($thumbmaxw + 6) . "px;text-align:center;\">";

                            $query2 = "SELECT thumbpath, usecollfolder, mediatypeID FROM ($albumlinks_table, $media_table) WHERE albumID=\"{$row['albumID']}\" AND defphoto = '1' AND $albumlinks_table.mediaID = $media_table.mediaID";
                            $result2 = tng_query($query2) or die (_('Cannot execute query') . ": $query2");
                            $trow = tng_fetch_assoc($result2);
                        $tmediatypeID = $trow['mediatypeID'];
                        $tusefolder = $trow['usecollfolder'] ? $mediatypes_assoc[$tmediatypeID] : $mediapath;
                        tng_free_result($result2);

                        if ($trow['thumbpath'] && file_exists("$rootpath$tusefolder/" . $trow['thumbpath'])) {
                            $size = @GetImageSize("$rootpath$tusefolder/" . $trow['thumbpath']);
                            echo "<a href=\"admin_editalbum.php?albumID={$row['albumID']}\"><img src=\"$tusefolder/" . str_replace("%2F", "/", rawurlencode($trow['thumbpath'])) . "\" $size[3] alt=\"{$row['albumname']}\"></a>";
                        } else {
                            echo "&nbsp;";
                        }
                        echo "</td>\n";
                        $checked = $row['defphoto'] ? " checked" : "";
                            echo "<td class='lightback normal'><a href=\"editalbum.php?albumID={$row['albumID']}\">{$row['albumname']}</a><br>$truncated<br>";
                            echo "<span id=\"md_{$row['albumID']}\" class='smaller' style=\"visibility:hidden;\"><a href='#' onclick=\"return removeFromSort('album','{$row['alinkID']}');\">" . _('Remove') . "</a></span></td>\n";
                            echo "</tr></table>";
                        echo "</div>\n";
                        $count++;
                    }
                    tng_free_result($result);
                    ?>
                </div>
            </form>

        </td>
    </tr>

    </table>
<?php echo tng_adminfooter(); ?>