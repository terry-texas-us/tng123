<?php
include "begin.php";
include "adminlib.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
require "adminlog.php";

initMediaTypes();

//mediatypeID and linktype should be passed in
$linktype = $linktype1;
$personID = attachPrefixSuffix(ucfirst($newlink1), $linktype);
$eventID = $event1;
$tree = $linktype == "L" && $tngconfig['places1tree'] ? "" : $tree1;

$sortstr = preg_replace("/xxx/", $text[$mediatypeID], _('Sort xxx for'));

switch ($linktype) {
    case "I":
        $query = "SELECT lastname, lnprefix, firstname, prefix, suffix, nameorder, branch FROM $people_table WHERE personID='$personID' AND gedcom = '$tree'";
        $result2 = tng_query($query);
        $person = tng_fetch_assoc($result2);
        $person['allow_living'] = 1;
        $person['allow_private'] = 1;
        $namestr = "$personID: " . getName($person);
        tng_free_result($result2);
        $test_url = "getperson.php?";
        $testID = "personID";
        break;
    case "F":
        $query = "SELECT branch FROM $families_table WHERE familyID=\"$personID\" AND gedcom = '$tree'";
        $result2 = tng_query($query);
        $person = tng_fetch_assoc($result2);
        $namestr = "" . _('Family') . ": $personID";
        tng_free_result($result2);
        $test_url = "familygroup.php?";
        $testID = "familyID";
        break;
    case "S":
        $query = "SELECT title FROM $sources_table WHERE sourceID=\"$personID\" AND gedcom = '$tree'";
        $result2 = tng_query($query);
        $person = tng_fetch_assoc($result2);
        $namestr = "" . _('Source') . ": $personID";
        if ($person['title']) $namestr .= ", " . $person['title'];

        $person['branch'] = "";
        tng_free_result($result2);
        $test_url = "showsource.php?";
        $testID = "sourceID";
        break;
    case "R":
        $query = "SELECT reponame FROM $repositories_table WHERE repoID=\"$personID\" AND gedcom = '$tree'";
        $result2 = tng_query($query);
        $person = tng_fetch_assoc($result2);
        $namestr = "" . _('Repository') . ": $personID";
        if ($person['reponame']) $namestr .= ", " . $person['reponame'];

        $person['branch'] = "";
        tng_free_result($result2);
        $test_url = "showrepo.php?";
        $testID = "repoID";
        break;
    case "L":
        $namestr = $personID;
        $person['branch'] = "";
        $test_url = "placesearch.php?";
        $testID = "psearch";
        break;
}

if (!checkbranch($person['branch'])) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

adminwritelog("<a href=\"admin_ordermedia.php?personID=$personID&amp;tree=$tree\">$sortstr: $tree/$personID</a>");

$photo = "";

$query = "SELECT alwayson, thumbpath, media.mediaID AS mediaID, usecollfolder, mediatypeID, medialinkID, media.gedcom ";
$query .= "FROM ($media_table media, $medialinks_table medialinks) ";
$query .= "WHERE personID = \"$personID\" AND medialinks.gedcom = '$tree' AND media.mediaID = medialinks.mediaID AND defphoto = '1'";
$result = tng_query($query);
if ($result) $row = tng_fetch_assoc($result);

$thismediatypeID = $row['mediatypeID'];
tng_free_result($result);

$query = "SELECT * ";
$query .= "FROM ($medialinks_table medialinks, $media_table media) ";
$query .= "WHERE medialinks.personID='$personID' AND medialinks.gedcom = '$tree' AND media.mediaID = medialinks.mediaID AND eventID = '$eventID' AND mediatypeID = '$mediatypeID' ";
$query .= "ORDER BY ordernum";
$result = tng_query($query);

$numrows = tng_num_rows($result);

if (!$numrows) {
    $message = _('No results found. Please try again.');
    header("Location: admin_ordermediaform.php?personID=$personID&message=" . urlencode($message));
    exit;
}

$helplang = findhelp("media_help.php");

tng_adminheader($sortstr, $flags);

$treestr = $tngconfig['mediatrees'] && $row['gedcom'] ? $row['gedcom'] . "/" : "";
$usefolder = $row['usecollfolder'] ? $mediatypes_assoc[$thismediatypeID] : $mediapath;

if ($row['thumbpath']) {
    $photoref = "$usefolder/$treestr" . $row['thumbpath'];
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
}
?>
<script>
    var entity = "<?php echo $personID; ?>";
    var tree = "<?php echo $tree; ?>";
    var album = "";
    var orderaction = "order";
</script>
    <script src="js/selectutils.js"></script>
    <script src="js/mediautils.js"></script>

    </head>

<?php
echo tng_adminlayout(" onLoad=\"startMediaSort()\"");

$mediatabs[0] = [1, "admin_media.php", _('Search'), "findmedia"];
$mediatabs[1] = [$allow_media_add, "admin_newmedia.php", _('Add New'), "addmedia"];
$mediatabs[2] = [$allow_media_edit, "admin_ordermediaform.php", _('Sort'), "sortmedia"];
$mediatabs[3] = [$allow_media_edit && !$assignedtree, "admin_thumbnails.php", _('Thumbnails'), "thumbs"];
$mediatabs[4] = [$allow_media_add && !$assignedtree, "admin_photoimport.php", _('Import'), "import"];
$mediatabs[5] = [$allow_media_add, "admin_mediaupload.php", _('Upload'), "upload"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/media_help.php#sortfor');\" class='lightlink'>" . _('Help for this area') . "</a>";
$innermenu .= " &nbsp;|&nbsp; <a href=\"$test_url" . "$testID=$personID&amp;tree=$tree\" target='_blank' class='lightlink'>" . _('Test') . "</a>";
$menu = doMenu($mediatabs, "sortmedia", $innermenu);
echo displayHeadline(_('Media') . " &gt;&gt; " . _('Sort'), "img/photos_icon.gif", $menu, $message);
?>

    <table class="lightback">
        <tr class="databack">
            <td class="tngshadow">
                <span class="subhead"><?php echo "<div id=\"thumbholder\" style=\"float:left;\">$photo</div><strong>$sortstr<br>$namestr</strong>"; ?></span><br>
                <br style="clear: left;">
                <?php
                echo "<p class=\"smaller\" id=\"removedefault\"";
                if (!$photo) echo " style='display: none;'";

                echo "><a href='#' onclick=\"return removeDefault();\">" . _('Remove default photo') . "</a></p>\n";
                ?>
                <table id="ordertbl" class="fieldname normal">
                    <tr>
                        <th class="fieldnameback" style="width:102px;"><?php echo _('Sort'); ?></th>
                        <th class="fieldnameback" style="width:<?php echo($thumbmaxw + 10); ?>px;"><?php echo _('Thumb'); ?></th>
                        <th class="fieldnameback"><?php echo _('Description'); ?></th>
                        <th class="fieldnameback" style="width:49px;"><?php echo _('Show'); ?></th>
                        <th class="fieldnameback" style="width:155px;"><?php echo _('Date Taken/Created'); ?></th>
                    </tr>
                </table>

                <form name="form1">
                    <div id="orderdivs">
                        <?php
                        $result = tng_query($query);
                        $count = 1;
                        while ($row = tng_fetch_assoc($result)) {
                            $treestr = $tngconfig['mediatrees'] && $row['gedcom'] ? $row['gedcom'] . "/" : "";
                        $usefolder = $row['usecollfolder'] ? $mediatypes_assoc[$mediatypeID] : $mediapath;
                        $truncated = substr($row['notes'], 0, 90);
                        $truncated = strlen($row['notes']) > 90 ? substr($truncated, 0, strrpos($truncated, ' ')) . '&hellip;' : $row['notes'];
                        echo "<div class='sortrow' id=\"orderdivs_{$row['medialinkID']}\" style=\"clear:both;position:relative;\" onmouseover=\"jQuery('#md_{$row['medialinkID']}').css('visibility','visible');\" onmouseout=\"jQuery('#md_{$row['medialinkID']}').css('visibility','hidden');\">";
                        echo "<table class='w-full' cellpadding='5' cellspacing='1'>\n";
                        echo "<tr>\n";
                            echo "<td class='dragarea rounded-lg normal'>";
                            echo "<img src='img/admArrowUp.gif' alt='' class='inline-block'>" . _('Drag') . "<img src='img/admArrowDown.gif' alt='' class='inline-block'>\n";
                            echo "</td>\n";
                            echo "<td class='lightback smaller' style=\"width:35px;text-align:center;\">";
                            echo "<div style=\"padding-bottom:5px;\"><a href='#' onclick=\"return moveItemInList('{$row['medialinkID']}',1);\" title=\"" . _('Move to top') . "\"><img src='img/admArrowUp.gif' alt='' class='inline-block'><br>" . _('Top') . "</a></div>\n";
                            echo "<input style=\"width:30px;\" class=\"movefields\" name=\"move{$row['medialinkID']}\" id=\"move{$row['medialinkID']}\" value=\"$count\" onkeypress=\"handleMediaEnter('{$row['medialinkID']}',jQuery('#move{$row['medialinkID']}').val(),event);\">\n";
                            echo "<a href='#' onclick=\"return moveItemInList('{$row['medialinkID']}',jQuery('#move{$row['medialinkID']}').val());\" title=\"" . _('Move to top') . "\">" . _('Go') . "</a>\n";
                            echo "</td>\n";

                        echo "<td class='lightback' style=\"width:" . ($thumbmaxw + 6) . "px;text-align:center;\">";
                        if ($row['thumbpath'] && file_exists("$rootpath$usefolder/$treestr" . $row['thumbpath'])) {
                            $size = @GetImageSize("$rootpath$usefolder/$treestr" . $row['thumbpath']);
                            echo "<a href=\"admin_editmedia.php?mediaID={$row['mediaID']}\"><img src=\"$usefolder/$treestr" . str_replace("%2F", "/", rawurlencode($row['thumbpath'])) . "\" $size[3] alt=\"{$row['description']}\"></a>";
                        } else {
                            echo "&nbsp;";
                        }
                        echo "</td>\n";
                        $checked = $row['defphoto'] ? " checked" : "";
                        echo "<td class='lightback normal'><a href=\"admin_editmedia.php?mediaID={$row['mediaID']}\">{$row['description']}</a><br>$truncated<br>\n";
                            echo "<span id=\"md_{$row['medialinkID']}\" class='smaller' style='color: #808080; visibility: hidden;'>\n";
                            echo "<input type='radio' name=\"rthumbs\" value=\"r{$row['mediaID']}\"$checked onclick=\"makeDefault(this);\">" . _('Make Default') . "\n";
                            echo " &nbsp;|&nbsp; ";
                            echo "<a href='#' onclick=\"return removeFromSort('media','{$row['medialinkID']}');\">" . _('Remove') . "</a>";
                            echo "</span>&nbsp;</td>\n";
                        echo "<td class='lightback normal' style=\"width:45px;text-align:center;vertical-align:top;\">";
                        $checked = $row['dontshow'] ? "" : " checked";
                        echo "<input type='checkbox' name=\"show{$row['medialinkID']}\" onclick=\"toggleShow(this);\" value='1'$checked>&nbsp;</td>\n";
                        echo "<td class='lightback normal' style=\"width:150px;\">{$row['datetaken']}&nbsp;</td>\n";
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