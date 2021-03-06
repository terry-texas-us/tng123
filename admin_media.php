<?php

include "begin.php";
include "config/mapconfig.php";
include "adminlib.php";
require_once "admin/pagination.php";

$admin_login = true;
include "checklogin.php";
include "version.php";
include_once "tngdblib.php";
$maxnoteprev = 350;  //don't use the global value here because we always want to truncate

if ($newsearch) {
    $exptime = 0;
    $searchstring = stripslashes(trim($searchstring));
    setcookie("tng_search_media_post[search]", $searchstring, $exptime);
    setcookie("tng_search_media_post[mediatypeID]", $mediatypeID, $exptime);
    setcookie("tng_search_media_post[fileext]", $fileext, $exptime);
    setcookie("tng_search_media_post[unlinked]", $unlinked, $exptime);
    setcookie("tng_search_media_post[hsstat]", $hsstat, $exptime);
    setcookie("tng_search_media_post[cemeteryID]", $cemeteryID, $exptime);
    setcookie("tng_tree", $tree, $exptime);
    setcookie("tng_search_media_post[tngpage]", 1, $exptime);
    setcookie("tng_search_media_post[offset]", 0, $exptime);
} else {
    if (!$searchstring) {
        $searchstring = stripslashes($_COOKIE['tng_search_media_post']['search']);
    }
    if (!$mediatypeID) {
        $mediatypeID = $_COOKIE['tng_search_media_post']['mediatypeID'];
    }
    if (!$fileext) {
        $fileext = $_COOKIE['tng_search_media_post']['fileext'];
    }
    if (!$unlinked) {
        $unlinked = $_COOKIE['tng_search_media_post']['unlinked'];
    }
    if (!$hsstat) $hsstat = $_COOKIE['tng_search_media_post']['hsstat'];

    if (!$cemeteryID) {
        $cemeteryID = $_COOKIE['tng_search_media_post']['cemeteryID'];
    }
    if (!$tree) $tree = $_COOKIE['tng_tree'];

    if (!isset($offset)) {
        $tngpage = $_COOKIE['tng_search_media_post']['tngpage'];
        $offset = $_COOKIE['tng_search_media_post']['offset'];
    } else {
        $exptime = 0;
        setcookie("tng_search_media_post[tngpage]", $tngpage, $exptime);
        setcookie("tng_search_media_post[offset]", $offset, $exptime);
    }
    $albumID = isset($_COOKIE['tng_search_media_post']['album']) ? $_COOKIE['tng_search_media_post']['album'] : "";
}

if ($offset) {
    $offsetplus = $offset + 1;
    $newoffset = "$offset, ";
} else {
    $offsetplus = 1;
    $newoffset = "";
    $tngpage = 1;
}

if ($assignedtree) {
    $wherestr = "WHERE gedcom = '$assignedtree'";
    $wherestr2 = " AND medialinks.gedcom = '$assignedtree'";
} else {
    $wherestr = "";
    if ($tree) $wherestr2 = " AND medialinks.gedcom = '$tree'";

}
$orgwherestr = $wherestr;
$orgtree = $tree;

$originalstring = preg_replace("/\"/", "&#34;", $searchstring);

$wherestr = $searchstring ? "(media.mediaID LIKE '%$searchstring%' OR description LIKE '%$searchstring%' OR path LIKE '%$searchstring%' OR notes LIKE '%$searchstring%' OR bodytext LIKE '%$searchstring%' OR owner LIKE '%$searchstring%')" : "";
if ($assignedtree) {
    $wherestr .= $wherestr ? " AND (media.gedcom = '$tree' || media.gedcom = '')" : "(media.gedcom = '$tree' || media.gedcom = '')";
} elseif ($tree) {
    $wherestr .= $wherestr ? " AND media.gedcom = '$tree'" : "media.gedcom = '$tree'";
}
if ($mediatypeID) {
    $wherestr .= $wherestr ? " AND mediatypeID = '$mediatypeID'" : "mediatypeID = '$mediatypeID'";
}
if ($fileext) {
    $wherestr .= $wherestr ? " AND form = '$fileext'" : "form = '$fileext'";
}
if ($hsstat != "all") {
    if ($hsstat) {
        $wherestr .= $wherestr ? " AND status = '$hsstat'" : "status = '$hsstat'";
    } else {
        $wherestr .= $wherestr ? " AND (status = '$hsstat' OR status IS NULL)" : "(status = '$hsstat' OR status IS NULL)";
    }
}
if ($cemeteryID) {
    $wherestr .= $wherestr ? " AND cemeteryID = '$cemeteryID'" : "cemeteryID = '$cemeteryID'";
}
if ($unlinked) {
    $join = "LEFT JOIN $medialinks_table medialinks ON media.mediaID = medialinks.mediaID";
    $medialinkID = "medialinkID,";
    $wherestr .= $wherestr ? " AND medialinkID is NULL" : "medialinkID is NULL";
}
if ($wherestr) $wherestr = "WHERE $wherestr";


$query = "SELECT media.mediaID AS mediaID, $medialinkID description, notes, thumbpath, mediatypeID, usecollfolder, latitude, longitude, zoom, media.gedcom ";
$query .= "FROM $media_table media $join ";
$query .= "$wherestr ";
$query .= "ORDER BY description ";
$query .= "LIMIT $newoffset" . $maxsearchresults;
$result = tng_query($query);

$numrows = tng_num_rows($result);
if ($numrows == $maxsearchresults || $offsetplus > 1) {
    $query = "SELECT count(media.mediaID) AS mcount ";
    $query .= "FROM $media_table media ";
    $query .= "$join ";
    $query .= "$wherestr";
    $result2 = tng_query($query);
    $row = tng_fetch_assoc($result2);
    $totrows = $row['mcount'];
    tng_free_result($result2);
} else {
    $totrows = $numrows;
}

$helplang = findhelp("media_help.php");

tng_adminheader(_('Media'), $flags);

$standardtypes = [];
foreach ($mediatypes as $mediatype) {
    if (!$mediatype['type']) {
        $standardtypes[] = "\"" . $mediatype['ID'] . "\"";
    }
}
$sttypestr = implode(",", $standardtypes);
?>
<script src="js/mediautils.js"></script>
<script>
    var tnglitbox;
    const entercollid = "<?php echo _('Please enter a collection ID.'); ?>";
    const entercolldisplay = "<?php echo _('Please enter a collection display name.'); ?>";
    const entercollipath = "<?php echo _('Please enter a collection folder name.'); ?>";
    const entercollicon = "<?php echo _('Please enter a collection icon file name.'); ?>";
    const confmtdelete = "<?php echo _('Are you sure you want to delete this media type?'); ?>";
    var stmediatypes = new Array(<?php echo $sttypestr; ?>);
    var manage = 1;
    var allow_media_edit = <?php echo($allow_media_edit ? "1" : "0"); ?>;
    var allow_media_delete = <?php echo($allow_media_delete ? "1" : "0"); ?>;
    var allow_edit = <?php echo($allow_edit ? "1" : "0"); ?>;
    var allow_delete = <?php echo($allow_delete ? "1" : "0"); ?>;

    function toggleHeadstoneCriteria(mediatypeID) {
        var hsstatus = document.getElementById('hsstatrow');
        var cemrow = document.getElementById('cemrow');
        if (mediatypeID == 'headstones') {
            cemrow.style.display = '';
            hsstatus.style.display = '';
        } else {
            cemrow.style.display = 'none';
            document.form1.cemeteryID.selectedIndex = 0;
            hsstatus.style.display = 'none';
            document.form1.hsstat.selectedIndex = 0;
            if (mediatypeID && stmediatypes.indexOf(mediatypeID) == -1) {
                if (jQuery('#editmediatype').length) jQuery('#editmediatype').show();
                if (jQuery('#delmediatype').length) jQuery('#delmediatype').show();
            } else {
                if (jQuery('#editmediatype').length) jQuery('#editmediatype').hide();
                if (jQuery('#delmediatype').length) jQuery('#delmediatype').hide();
            }
        }
        return false;
    }

    function resetForm() {
        document.form1.searchstring.value = '';
        document.form1.tree.selectedIndex = 0;
        document.form1.mediatypeID.selectedIndex = 0;
        document.form1.fileext.value = '';
        document.form1.unlinked.checked = false;
        document.form1.hsstat.selectedIndex = 0;
        document.form1.cemeteryID.selectedIndex = 0;
    }

    function confirmDelete(mediaID) {
        if (confirm('<?php echo _('Are you sure you want to delete this media?'); ?>')) {
            <?php if ($tngconfig['mediadel'] == 2) { ?>
            if (confirm('<?php echo _('Do you want to delete the physical file as well?'); ?>')) {
                deleteIt('media', mediaID, '', 1);
            } else {
                deleteIt('media', mediaID, '', 0);
            }
            <?php } else { ?>
            deleteIt('media', mediaID);
            <?php } ?>
        }
        return false;
    }
</script>

<?php
echo "</head>\n";
echo tng_adminlayout();

$mediatabs[0] = [1, "admin_media.php", _('Search'), "findmedia"];
$mediatabs[1] = [$allow_media_add, "admin_newmedia.php", _('Add New'), "addmedia"];
$mediatabs[2] = [$allow_media_edit, "admin_ordermediaform.php", _('Sort'), "sortmedia"];
$mediatabs[3] = [$allow_media_edit && !$assignedtree, "admin_thumbnails.php", _('Thumbnails'), "thumbs"];
$mediatabs[4] = [$allow_media_add && !$assignedtree, "admin_photoimport.php", _('Import'), "import"];
$mediatabs[5] = [$allow_media_add, "admin_mediaupload.php", _('Upload'), "upload"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/media_help.php#modify');\" class='lightlink'>" . _('Help for this area') . "</a>";
$menu = doMenu($mediatabs, "findmedia", $innermenu);
echo displayHeadline(_('Media'), "img/photos_icon.gif", $menu, $message);
?>

<table class="lightback">
    <tr class="databack">
        <td class="tngshadow">
            <div class="normal">

                <form action="admin_media.php" name="form1" id="form1">
                    <table class="normal">
                        <tr>
                            <td><?php echo _('Search for'); ?>:</td>
                            <td>
                                <?php
                                $newwherestr = $wherestr;
                                $wherestr = $orgwherestr;
                                include "treequery.php";
                                $wherestr = $newwherestr;
                                ?>
                                <input class="longfield" name="searchstring" type="search" value="<?php echo $originalstring; ?>">
                                <input type="submit" name="submit" value="<?php echo _('Search'); ?>" class="align-top">
                                <input type="submit" name="submit" value="<?php echo _('Reset'); ?>" onClick="resetForm();" class="align-top">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('File ext.'); ?>:</td>
                            <td>
                                <input type="text" name="fileext" value="<?php echo $fileext; ?>" size="3">
                                &nbsp;&nbsp;<input type="checkbox" name="unlinked" value="1"<?php if ($unlinked) {
                                    echo " checked";
                                } ?> > <?php echo _('Unlinked only'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Collection'); ?>:</td>
                            <td>
                                <select name="mediatypeID" onchange="toggleHeadstoneCriteria(this.options[this.selectedIndex].value)">

                                    <?php
                                    echo "<option value=\"\">" . _('All') . "</option>\n";
                                    foreach ($mediatypes as $mediatype) {
                                        $msgID = $mediatype['ID'];
                                        echo "	<option value=\"$msgID\"";
                                        if ($msgID == $mediatypeID) echo " selected";

                                        echo ">" . $mediatype['display'] . "</option>\n";
                                    }
                                    ?>
                                </select>
                                <?php if (!$assignedtree && $allow_add && $allow_edit && $allow_delete) { ?>
                                    <input type="button" name="addnewmediatype" value="<?php echo _('Add Collection'); ?>" class="align-top"
                                        onclick="tnglitbox = new LITBox('admin_newcollection.php?field=mediatypeID', {width:600, height:340});">
                                    <input type="button" name="editmediatype" id="editmediatype" value="<?php echo _('Edit'); ?>" style="vertical-align:top;display:none;"
                                        onclick="editMediatype(document.form1.mediatypeID);">
                                    <input type="button" name="delmediatype" id="delmediatype" value="<?php echo _('Delete'); ?>" style="vertical-align:top;display:none;"
                                        onclick="confirmDeleteMediatype(document.form1.mediatypeID);">
                                <?php } ?>
                            </td>
                        </tr>
                        <tr id="hsstatrow">
                            <td><?php echo _('Status'); ?>:</td>
                            <td>
                                <select name="hsstat">
                                    <option value="all"<?php if ($hsstat == "all") {
                                        echo " selected";
                                    } ?>>&nbsp;
                                    </option>
                                    <option value=""<?php if (!$hsstat) {
                                        echo " selected";
                                    } ?>><?php echo _('No status'); ?></option>
                                    <option value="notyetlocated"<?php if ($hsstat == "notyetlocated") {
                                        echo " selected";
                                    } ?>><?php echo _('Not yet located'); ?></option>
                                    <option value="located"<?php if ($hsstat == "located") {
                                        echo " selected";
                                    } ?>><?php echo _('Located'); ?></option>
                                    <option value="unmarked"<?php if ($hsstat == "unmarked") {
                                        echo " selected";
                                    } ?>><?php echo _('Unmarked'); ?></option>
                                    <option value="missing"<?php if ($hsstat == "missing") {
                                        echo " selected";
                                    } ?>><?php echo _('Missing'); ?></option>
                                    <option value="cremated"<?php if ($hsstat == "cremated") {
                                        echo " selected";
                                    } ?>><?php echo _('Cremated'); ?></option>
                                </select>
                            </td>
                        </tr>
                        <tr id="cemrow">
                            <td><?php echo _('Cemetery'); ?>:</td>
                            <td>
                                <select name="cemeteryID">
                                    <option selected></option>
                                    <?php
                                    $query = "SELECT cemname, cemeteryID, city, county, state, country FROM $cemeteries_table ORDER BY country, state, county, city, cemname";
                                    $cemresult = tng_query($query);
                                    while ($cemrow = tng_fetch_assoc($cemresult)) {
                                        $cemetery = "{$cemrow['country']}, {$cemrow['state']}, {$cemrow['county']}, {$cemrow['city']}, {$cemrow['cemname']}";
                                        echo "		<option value=\"{$cemrow['cemeteryID']}\"";
                                        if ($cemeteryID == $cemrow['cemeteryID']) {
                                            echo " selected";
                                        }
                                        echo ">$cemetery</option>\n";
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                    </table>

                    <input type="hidden" name="findmedia" value="1">
                    <input type="hidden" name="newsearch" value="1">
                </form>
                <?php
                $numrowsplus = $numrows + $offset;
                if (!$numrowsplus) $offsetplus = 0;
                ?>
                <form action="admin_updateselectedmedia.php" method="post" name="form2">
                    <?php if ($allow_media_delete || $allow_media_edit) { ?>
                        <p class="whitespace-no-wrap">
                            <input type="button" name="selectall" value="<?php echo _('Select All'); ?>" onClick="toggleAll(1);">
                            <input type="button" name="clearall" value="<?php echo _('Clear All'); ?>" onClick="toggleAll(0);">&nbsp;&nbsp;
                            <?php if ($allow_media_delete) { ?>
                                <input type="submit" name="xphaction" value="<?php echo _('Delete Selected'); ?>"
                                    onClick="return confirm('<?php echo _('Are you sure you want to delete the selected records?'); ?>');">&nbsp;&nbsp;
                                <?php
                            }
                            if ($allow_media_edit) {
                            ?>
                            <input type="submit" name="xphaction" value="<?php echo _('Convert Selected to'); ?>">
                            <select name="newmediatype" class="align-top">
                                <?php
                                foreach ($mediatypes as $mediatype) {
                                    $msgID = $mediatype['ID'];
                                    if ($msgID != $mediatypeID) {
                                        echo "	<option value=\"$msgID\">" . $mediatype['display'] . "</option>\n";
                                    }
                                }
                                echo "</select>&nbsp;&nbsp;\n";

                                $albumquery = "SELECT albumID, albumname FROM $albums_table ORDER BY albumname";
                                $albumresult = tng_query($albumquery) or die (_('Cannot execute query') . ": $albumquery");
                                $numalbums = tng_num_rows($albumresult);
                                if ($numalbums) {
                                    echo "<input type='submit' name=\"xphaction\" value=\"" . _('Add to Album') . "\">\n";
                                    echo "<select name=\"albumID\" style=\"vertical-align:top;\">\n";
                                    while ($albumrow = tng_fetch_assoc($albumresult)) {
                                        echo "	<option value=\"{$albumrow['albumID']}\"";
                                        if ($albumrow['albumID'] == $albumID) echo " selected";

                                        echo ">{$albumrow['albumname']}</option>\n";
                                    }
                                    echo "</select>\n";
                                }
                                tng_free_result($albumresult);
                                }
                                ?>
                        </p>
                    <?php } ?>

                    <table class="normal">
                        <tr>
                            <th class="fieldnameback fieldname"><?php echo _('Action'); ?></th>
                            <?php if ($allow_edit || $allow_media_edit || $allow_delete || $allow_media_delete) { ?>
                                <th class="fieldnameback fieldname"><?php echo _('Select'); ?></th>
                            <?php } ?>
                            <th class="fieldnameback fieldname"><?php echo _('Thumb'); ?></th>
                            <th class="fieldnameback fieldname"><?php echo "" . _('Title') . ", " . _('Description') . ""; ?></th>
                            <?php if ($map['key']) { ?>
                                <th class="fieldnameback fieldname"><?php echo _('Geocode Location'); ?></th>
                                <?php
                            }
                            if (!$mediatypeID) {
                                ?>
                                <th class="fieldnameback fieldname"><?php echo _('Collection'); ?></th>
                            <?php } ?>
                            <th class="fieldnameback fieldname"><?php echo _('Linked to'); ?></th>
                        </tr>
                        <?php
                        if ($numrows) {
                        $actionstr = "";
                        if ($allow_media_edit) {
                            $actionstr .= "<a href=\"admin_editmedia.php?mediaID=xxx\" title=\"" . _('Edit') . "\" class='smallicon admin-edit-icon'></a>";
                        }
                        if ($allow_media_delete) {
                            $actionstr .= "<a href='#' onClick=\"return confirmDelete('xxx');\" title=\"" . _('Delete') . "\" class='smallicon admin-delete-icon'></a>";
                        }
                        $actionstr .= "<a href=\"showmedia.php?mediaID=xxx\" target='_blank' title=\"" . _('Test') . "\" class='smallicon admin-test-icon'></a>";

                        while ($row = tng_fetch_assoc($result)) {
                            $mtypeID = $row['mediatypeID'];
                            $usefolder = $row['usecollfolder'] ? $mediatypes_assoc[$mtypeID] : $mediapath;
                            $newactionstr = preg_replace("/xxx/", $row['mediaID'], $actionstr);
                            echo "<tr id=\"row_{$row['mediaID']}\"><td class='lightback'><div class='action-btns'>$newactionstr</div></td>\n";
                            if ($allow_edit || $allow_media_edit || $allow_delete || $allow_media_delete) {
                                echo "<td class='lightback text-center'><input type='checkbox' name=\"ph{$row['mediaID']}\" value='1'></td>";
                            }
                            echo "<td class='lightback text-center'>";
                            $treestr = $tngconfig['mediatrees'] && $row['gedcom'] ? $row['gedcom'] . "/" : "";
                            if ($row['thumbpath'] && file_exists("$rootpath$usefolder/$treestr" . $row['thumbpath'])) {
                                $photoinfo = @GetImageSize("$rootpath$usefolder/$treestr" . $row['thumbpath']);
                                if ($photoinfo['1'] < 50) {
                                    $photohtouse = $photoinfo['1'];
                                    $photowtouse = $photoinfo['0'];
                                } else {
                                    $photohtouse = 50;
                                    $photowtouse = intval(50 * $photoinfo['0'] / $photoinfo['1']);
                                }
                                echo "<span class='normal'>";
                                echo "<img border=0 src=\"$usefolder/$treestr" . str_replace("%2F", "/", rawurlencode($row['thumbpath'])) . "\" width=\"$photowtouse\" height=\"$photohtouse\"></span>\n";
                            } else {
                                echo "&nbsp;";
                            }
                            echo "</td>\n";
                            $description = $allow_edit || $allow_media_edit ? "<a href=\"admin_editmedia.php?mediaID={$row['mediaID']}\">{$row['description']}</a>" : $row['description'];
                            echo "<td class='lightback'><span class='normal'>$description<br>" . truncateIt(getXrefNotes($row['notes']), $maxnoteprev) . "</span></td>\n";
                            if ($map['key']) {
                                echo "<td nowrap class='lightback'><span class='normal'>";
                                $geo = "";
                                if ($row['latitude']) {
                                    $geo .= _('Latitude') . ": " . number_format($row['latitude'], 3);
                                }
                                if ($row['longitude']) {
                                    if ($geo) $geo .= "<br>";

                                    $geo .= _('Longitude') . ": " . number_format($row['longitude'], 3);
                                }
                                if ($row['zoom']) {
                                    if ($geo) $geo .= "<br>";

                                    $geo .= _('Zoom') . ": " . $row['zoom'];
                                }
                                echo "$geo&nbsp;</span></td>\n";
                            }
                            if (!$mediatypeID) {
                                $label = $text[$mtypeID] ? $text[$mtypeID] : $mediatypes_display[$mtypeID];
                                echo "<td nowrap class='lightback normal'>&nbsp;" . $label . "&nbsp;</td>\n";
                            }

                            $query = "SELECT people.personID AS personID2, familyID, husband, wife, people.lastname AS lastname, people.lnprefix AS lnprefix, people.firstname AS firstname, people.prefix AS prefix, people.suffix AS suffix, nameorder, medialinks.personID AS personID, sources.title, sources.sourceID, repositories.repoID, reponame, linktype, families.gedcom AS gedcom ";
                            $query .= "FROM $medialinks_table medialinks ";
                            $query .= "LEFT JOIN $people_table people ON medialinks.personID = people.personID AND medialinks.gedcom = people.gedcom ";
                            $query .= "LEFT JOIN $families_table families ON medialinks.personID = families.familyID AND medialinks.gedcom = families.gedcom ";
                            $query .= "LEFT JOIN $sources_table sources ON medialinks.personID = sources.sourceID AND medialinks.gedcom = sources.gedcom ";
                            $query .= "LEFT JOIN $repositories_table repositories ON (medialinks.personID = repositories.repoID AND medialinks.gedcom = repositories.gedcom) ";
                            $query .= "WHERE mediaID = \"{$row['mediaID']}\"$wherestr2 ";
                            $query .= "ORDER BY lastname, lnprefix, firstname, personID ";
                            $query .= "LIMIT 10";
                            $presult = tng_query($query);
                            $medialinktext = "";
                            $citelinks = [];
                            while ($prow = tng_fetch_assoc($presult)) {
                                $prights = determineLivingPrivateRights($prow);
                                $prow['allow_living'] = $prights['living'];
                                $prow['allow_private'] = $prights['private'];
                                if ($prow['personID2'] != NULL) {
                                    $medialinktext .= "<li>" . getName($prow) . " ({$prow['personID2']})</li>\n";
                                } elseif ($prow['sourceID'] != NULL) {
                                    $sourcetext = $prow['title'] ? "" . _('Source') . ": {$prow['title']}" : "" . _('Source') . ": {$prow['sourceID']}";
                                    $medialinktext .= "<li>$sourcetext ({$prow['sourceID']})</li>\n";
                                } elseif ($prow['repoID'] != NULL) {
                                    $repotext = $prow['reponame'] ? "" . _('Repository') . ": {$prow['reponame']}" : "" . _('Repository') . ": {$prow['repoID']}";
                                    $medialinktext .= "<li>$repotext ({$prow['repoID']})</li>\n";
                                } elseif ($prow['familyID'] != NULL) {
                                    $medialinktext .= "<li>" . _('Family') . ": " . getFamilyName($prow) . "</li>\n";
                                } elseif (!$prow['linktype'] || $prow['linktype'] == "C") {
                                    $query = "SELECT persfamID, sourceID, gedcom FROM $citations_table WHERE citationID = \"{$prow['personID']}\"";
                                    $cresult = tng_query($query);
                                    if ($cresult) {
                                        $crow = tng_fetch_assoc($cresult);
                                        if ($crow) {
                                            $persfamID = $crow['persfamID'];
                                            if (!in_array($persfamID, $citelinks)) {
                                                $medialinktext .= "<li>" . _('Citation') . ": ";
                                                $citelinks[] = $persfamID;
                                                if (substr($persfamID, 0, 1) == $tngconfig['personprefix'] || substr($persfamID, -1) == $tngconfig['personsuffix']) {
                                                    $presult2 = getPersonSimple($crow['gedcom'], $persfamID);
                                                    if ($presult2) {
                                                        $cprow = tng_fetch_assoc($presult2);
                                                        $cprights = determineLivingPrivateRights($cprow);
                                                        $cprow['allow_living'] = $cprights['living'];
                                                        $cprow['allow_private'] = $cprights['private'];
                                                        $medialinktext .= getName($cprow) . " ($persfamID)";
                                                        tng_free_result($presult2);
                                                    }
                                                } elseif (substr($persfamID, 0, 1) == $tngconfig['familyprefix'] || substr($persfamID, -1) == $tngconfig['familysuffix']) {
                                                    $presult2 = getFamilyData($crow['gedcom'], $persfamID);
                                                    if ($presult2) {
                                                        $famrow = tng_fetch_assoc($presult2);
                                                        $familyname = getFamilyName($famrow);
                                                        $medialinktext .= "" . _('Family') . ": $familyname ($persfamID)";
                                                        tng_free_result($presult2);
                                                    }
                                                }
                                                $medialinktext .= "</li>\n";
                                            }
                                        }
                                        tng_free_result($cresult);
                                    }
                                } else {
                                    $medialinktext .= "<li>{$prow['personID']}</li>";
                                }
                            }
                            $medialinktext = $medialinktext ? "<ul>\n$medialinktext\n</ul>\n" : "&nbsp;";
                            echo "<td nowrap class='lightback normal'>$medialinktext</td>\n";
                            echo "</tr>\n";
                        }
                        ?>
                    </table>
                <?php
                echo "<div class='w-full class=lg:flex my-6'>";
                echo getPaginationLocationHtml($offsetplus, $numrowsplus, $totrows);
                echo getPaginationControlsHtml($totrows, "admin_media.php?searchstring=$searchstring&amp;mediatypeID=$mediatypeID&amp;fileext=$fileext&amp;hsstat=$hsstat&amp;cemeteryID=$cemeteryID&amp;offset", $maxsearchresults, 3);
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
<script>
    toggleHeadstoneCriteria('<?php echo $mediatypeID; ?>');
</script>

<?php echo tng_adminfooter(); ?>
