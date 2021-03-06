<?php

include "begin.php";
include "adminlib.php";
require_once "admin/pagination.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
$tng_search_album = $_SESSION['tng_search_album'] = 1;
if ($newsearch) {
    $exptime = 0;
    setcookie("tng_search_album_post[search]", $searchstring, $exptime);
    setcookie("tng_search_album_post[tree]", $tree, $exptime);
    setcookie("tng_search_album_post[tngpage]", 1, $exptime);
    setcookie("tng_search_album_post[offset]", 0, $exptime);
} else {
    if (!$searchstring) {
        $searchstring = stripslashes($_COOKIE['tng_search_album_post']['search']);
    }
    if (!$tree) $tree = $_COOKIE['tng_search_album_post']['tree'];

    if (!isset($offset)) {
        $tngpage = $_COOKIE['tng_search_album_post']['tngpage'];
        $offset = $_COOKIE['tng_search_album_post']['offset'];
    } else {
        $exptime = 05;
        setcookie("tng_search_album_post[tngpage]", $tngpage, $exptime);
        setcookie("tng_search_album_post[offset]", $offset, $exptime);
    }
}
$searchstring_noquotes = preg_replace("/\"/", "&#34;", $searchstring);
$searchstring = addslashes($searchstring);

if ($offset) {
    $offsetplus = $offset + 1;
    $newoffset = "$offset, ";
} else {
    $offsetplus = 1;
    $newoffset = "";
    $tngpage = 1;
}

if ($assignedtree) $tree = $assignedtree;


$query = "SELECT * ";
$query .= "FROM $albums_table ";
$query .= $searchstring ? "WHERE albumname LIKE \"%$searchstring%\" OR description LIKE \"%$searchstring%\" OR keywords LIKE \"%$searchstring%\"" : "";
$query .= "ORDER BY albumname ";
$query .= "LIMIT $newoffset" . $maxsearchresults;
$result = tng_query($query);
$numrows = tng_num_rows($result);

if ($numrows == $maxsearchresults || $offsetplus > 1) {
    $query = "SELECT count(albumID) AS acount ";
    $query .= "FROM $albums_table ";
    $query .= $searchstring ? "WHERE albumname LIKE \"%$searchstring%\" OR description LIKE \"%$searchstring%\" OR keywords LIKE \"%$searchstring%\"" : "";
    $result2 = tng_query($query);
    $row = tng_fetch_assoc($result2);
    $totrows = $row['acount'];
    tng_free_result($result2);
} else {
    $totrows = $numrows;
}

$helplang = findhelp("albums_help.php");

tng_adminheader(_('Albums'), $flags);

echo "</head>\n";
echo tng_adminlayout();

$albumtabs[0] = [1, "admin_albums.php", _('Search'), "findalbum"];
$albumtabs[1] = [$allow_media_add, "admin_newalbum.php", _('Add New'), "addalbum"];
$albumtabs[2] = [$allow_media_edit, "admin_orderalbumform.php", _('Sort'), "sortalbums"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/albums_help.php#modify');\" class='lightlink'>" . _('Help for this area') . "</a>";
$menu = doMenu($albumtabs, "findalbum", $innermenu);
echo displayHeadline(_('Albums'), "img/albums_icon.gif", $menu, $message);
?>

    <table class="lightback">
        <tr class="databack">
            <td class="tngshadow">
                <div class="normal">

                    <form action="admin_albums.php" name="form1" id="form1">
                        <table>
                            <tr>
                                <td><span class="normal"><?php echo _('Search for'); ?>: </span></td>
                                <td>
                                    <input class="longfield" name="searchstring" type="search" value="<?php echo $searchstring_noquotes; ?>">
                                </td>
                                <td>
                                    <input type="submit" name="submit" value="<?php echo _('Search'); ?>" class="align-top">
                                    <input type="submit" name="submit" value="<?php echo _('Reset'); ?>" onClick="document.form1.searchstring.value='';" class="align-top">
                                </td>
                            </tr>
                        </table>

                        <input type="hidden" name="findalbum" value="1">
                        <input type="hidden" name="newsearch" value="1">
                    </form>

                    <?php
                    $numrowsplus = $numrows + $offset;
                    if (!$numrowsplus) $offsetplus = 0;
                    ?>
                    <table class="normal">
                        <tr>
                            <th class="fieldnameback fieldname"><?php echo _('Action'); ?></th>
                            <th class="fieldnameback fieldname"><?php echo _('Thumb'); ?></th>
                            <th class="fieldnameback fieldname"><?php echo _('Album Name') . ", " . _('Description'); ?></th>
                            <th class="fieldnameback fieldname"><?php echo _('Album Media'); ?></th>
                            <th class="fieldnameback fieldname"><?php echo _('Active'); ?>?</th>
                            <th class="fieldnameback fieldname"><?php echo _('Linked to'); ?></th>
                        </tr>
                        <?php
                        if ($numrows) {
                        $actionstr = "";
                        if ($allow_media_edit) {
                            $actionstr .= "<a href=\"admin_editalbum.php?albumID=xxx\" title=\"" . _('Edit') . "\" class='smallicon admin-edit-icon'></a>";
                        }
                        if ($allow_media_delete) {
                            $actionstr .= "<a href='#' onclick=\"if(confirm('" . _('Are you sure you want to delete this album?') . "' )){deleteIt('album',xxx);} return false;\" title=\"" . _('Delete') . "\" class='smallicon admin-delete-icon'></a>";
                        }
                        $actionstr .= "<a href=\"showalbum.php?albumID=xxx\" target='_blank' title=\"" . _('Test') . "\" class='smallicon admin-test-icon'></a>";

                    while ($row = tng_fetch_assoc($result)) {
                        $newactionstr = preg_replace("/xxx/", $row['albumID'], $actionstr);
                        echo "<tr id=\"row_{$row['albumID']}\">\n";
                        echo "<td class='lightback'>\n";
                        echo "<div class='action-btns'>$newactionstr</div>\n";
                        echo "</td>\n";
                        echo "<td class='lightback normal' style=\"width:" . ($thumbmaxw + 6) . "px;text-align:center;vertical-align:top\">";

                        $query2 = "SELECT thumbpath, usecollfolder, mediatypeID ";
                        $query2 .= "FROM ($media_table media, $albumlinks_table albumlinks) ";
                        $query2 .= "WHERE albumID = \"{$row['albumID']}\" AND media.mediaID = albumlinks.mediaID AND defphoto='1'";
                        $result2 = tng_query($query2) or die (_('Cannot execute query') . ": $query2");
                        $trow = tng_fetch_assoc($result2);
                        $tmediatypeID = $trow['mediatypeID'];
                        $tusefolder = $trow['usecollfolder'] ? $mediatypes_assoc[$tmediatypeID] : $mediapath;

                        tng_free_result($result2);

                        if ($trow['thumbpath'] && file_exists("$rootpath$tusefolder/" . $trow['thumbpath'])) {
                            $size = @GetImageSize("$rootpath$tusefolder/" . $trow['thumbpath']);
                            echo "<a href=\"admin_editalbum.php?albumID={$row['albumID']}\">\n";
                            echo "<img src=\"$tusefolder/" . str_replace("%2F", "/", rawurlencode($trow['thumbpath'])) . "\" $size[3] alt=\"{$row['albumname']}\">\n";
                            echo "</a>\n";
                        } else {
                            echo "&nbsp;";
                        }
                        echo "</td>\n";

                        $query = "SELECT count(albumlinkID) AS acount FROM $albumlinks_table WHERE albumID = \"{$row['albumID']}\"";
                        $cresult = tng_query($query);
                        $crow = tng_fetch_assoc($cresult);
                        $acount = $crow['acount'];
                        tng_free_result($cresult);

                        $editlink = "admin_editalbum.php?albumID={$row['albumID']}";
                        $albumname = $allow_edit ? "<a href=\"$editlink\" title=\"" . _('Edit') . "\">" . $row['albumname'] . "</a>" : "<u>" . $row['albumname'] . "</u>";

                        echo "<td class='lightback normal'>$albumname<br>" . strip_tags($row['description']) . "</td>\n";
                        echo "<td class='lightback normal text-center'>$acount</td>\n";
                        $active = $row['active'] ? _('Yes') : _('No');
                        echo "<td class='lightback normal text-center'>$active</td>\n";

                        $query = "SELECT people.personID AS personID2, familyID, husband, wife, people.lastname AS lastname, people.lnprefix AS lnprefix, people.firstname AS firstname, people.prefix AS prefix, people.suffix AS suffix, nameorder, album2entities.entityID AS personID, sources.title, sources.sourceID, repositories.repoID, reponame ";
                        $query .= "FROM $album2entities_table album2entities ";
                        $query .= "LEFT JOIN $people_table people ON album2entities.entityID = people.personID AND album2entities.gedcom = people.gedcom ";
                        $query .= "LEFT JOIN $families_table families ON album2entities.entityID = families.familyID AND album2entities.gedcom = families.gedcom ";
                        $query .= "LEFT JOIN $sources_table sources ON album2entities.entityID = sources.sourceID AND album2entities.gedcom = sources.gedcom ";
                        $query .= "LEFT JOIN $repositories_table repositories ON (album2entities.entityID = repositories.repoID AND album2entities.gedcom = repositories.gedcom) ";
                        $query .= "WHERE albumID = '{$row['albumID']}' ";
                        if ($assignedtree) {
                            $query .= "AND album2entities.gedcom = '$assignedtree' ";
                        } elseif ($tree) {
                            $query .= "AND album2entities.gedcom = '$tree' ";
                        }
                        $query .= "ORDER BY lastname, lnprefix, firstname, personID ";
                        $query .= "LIMIT 10";
                        $presult = tng_query($query);
                        $alinktext = "";
                        while ($prow = tng_fetch_assoc($presult)) {
                            $prow['allow_living'] = 1;
                            if ($prow['personID2'] != NULL) {
                                $alinktext .= "<li>" . getName($prow) . " ({$prow['personID2']})</li>\n";
                            } elseif ($prow['sourceID'] != NULL) {
                                $sourcetext = $prow['title'] ? "" . _('Source') . ": {$prow['title']}" : "" . _('Source') . ": {$prow['sourceID']}";
                                $alinktext .= "<li>$sourcetext ({$prow['sourceID']})</li>\n";
                            } elseif ($prow['repoID'] != NULL) {
                                $repotext = $prow['reponame'] ? "" . _('Repository') . ": {$prow['reponame']}" : "" . _('Repository') . ": {$prow['repoID']}";
                                $alinktext .= "<li>$repotext ({$prow['repoID']})</li>\n";
                            } elseif ($prow['familyID'] != NULL) {
                                $alinktext .= "<li>" . _('Family') . ": " . getFamilyName($prow) . "</li>\n";
                            } else {
                                $alinktext .= "<li>{$prow['personID']}</li>";
                            }
                        }
                        $alinktext = $alinktext ? "<ul>\n$alinktext\n</ul>\n" : "&nbsp;";
                        echo "<td class='lightback normal'>$alinktext</td>\n";
                        echo "</tr>\n";
                    }
                    ?>
                </table>
            <?php
            echo "<div class='w-full class=lg:flex my-6'>";
            echo getPaginationLocationHtml($offsetplus, $numrowsplus, $totrows);
            echo getPaginationControlsHtml($totrows, "admin_notelist.php?searchstring=$searchstring_noquotes&amp;offset", $maxsearchresults, 3);
            echo "</div>";
            }
            else {
                echo "</table>\n" . _('No records exist.');
            }
            tng_free_result($result);
            ?>
                </form>

            </div>
        </td>
    </tr>
</table>
<?php echo tng_adminfooter(); ?>