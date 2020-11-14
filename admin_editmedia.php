<?php

include "begin.php";
include "config/mapconfig.php";
$mapkeystr = $map['key'] && $map['key'] != "1" ? "&amp;key=" . $map['key'] : "";
include "adminlib.php";
require_once "./admin/trees.php";

$textpart = "photos";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
if (!$allow_media_edit && (!$allow_media_add || !$added)) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}
include "showmedialib.php";

$query = "SELECT *, DATE_FORMAT(changedate, '%d %b %Y %H:%i:%s') AS changedate FROM $media_table ";
$query .= "WHERE mediaID = '$mediaID'";
$result = tng_query($query);
$row = tng_fetch_assoc($result);
$row['description'] = preg_replace("/\"/", "&#34;", $row['description']);
$row['notes'] = preg_replace("/\"/", "&#34;", $row['notes']);
$row['datetaken'] = preg_replace("/\"/", "&#34;", $row['datetaken']);
$row['placetaken'] = preg_replace("/\"/", "&#34;", $row['placetaken']);
$row['owner'] = preg_replace("/\"/", "&#34;", $row['owner']);
$row['map'] = preg_replace("/\"/", "&#34;", $row['map']);
$row['map'] = preg_replace("/>/", "&gt;", $row['map']);
$row['map'] = preg_replace("/</", "&lt;", $row['map']);

if ($row['usenl']) $row['bodytext'] = nl2br($row['bodytext']);

if ($row['abspath']) {
    $row['path'] = preg_replace("/&/", "&amp;", $row['path']);
}
tng_free_result($result);

$mediatypeID = $row['mediatypeID'];
$path = stripslashes($path);
$thumbpath = stripslashes($thumbpath);
if ($row['form']) {
    $form = strtoupper($row['form']);
} else {
    preg_match("/\.(.+)$/", $row['path'], $matches);
    $form = strtoupper($matches[1]);
}

$orderedTreesList = new OrderedTreesList($trees_table, $assignedtree);

$query = "SELECT medialinks.medialinkID AS mlinkID, medialinks.personID AS personID, medialinks.eventID, people.lastname AS lastname, people.lnprefix AS lnprefix, people.firstname AS firstname, people.prefix AS prefix,
 people.suffix AS suffix, people.nameorder AS nameorder, altdescription, altnotes, medialinks.gedcom AS gedcom, people.branch AS branch, treename, familyID, people.personID AS personID2, wifepeople.personID AS wpersonID, 
 wifepeople.firstname AS wfirstname, wifepeople.lnprefix AS wlnprefix, wifepeople.lastname AS wlastname, wifepeople.prefix AS wprefix, wifepeople.suffix AS wsuffix, wifepeople.nameorder AS wnameorder, 
 husbpeople.personID AS hpersonID, husbpeople.firstname AS hfirstname, husbpeople.lnprefix AS hlnprefix, husbpeople.lastname AS hlastname, husbpeople.prefix AS hprefix, husbpeople.suffix AS hsuffix, 
 husbpeople.nameorder AS hnameorder, sources.sourceID, sources.title, citationID, repositories.repoID AS repoID, reponame, defphoto, linktype, dontshow, people.living, people.private, families.living AS fliving, 
 families.private AS fprivate ";
$query .= "FROM $medialinks_table medialinks ";
$query .= "LEFT JOIN $trees_table trees ON medialinks.gedcom = trees.gedcom ";
$query .= "LEFT JOIN $people_table people ON medialinks.personID = people.personID AND medialinks.gedcom = people.gedcom ";
$query .= "LEFT JOIN $families_table families ON medialinks.personID = families.familyID AND medialinks.gedcom = families.gedcom ";
$query .= "LEFT JOIN $sources_table sources ON medialinks.personID = sources.sourceID AND medialinks.gedcom = sources.gedcom ";
$query .= "LEFT JOIN $citations_table citations ON medialinks.personID = citations.citationID AND medialinks.gedcom = citations.gedcom ";
$query .= "LEFT JOIN $repositories_table repositories ON medialinks.personID = repositories.repoID AND medialinks.gedcom = repositories.gedcom ";
$query .= "LEFT JOIN $people_table husbpeople ON families.husband = husbpeople.personID AND families.gedcom = husbpeople.gedcom ";
$query .= "LEFT JOIN $people_table wifepeople ON families.wife = wifepeople.personID AND families.gedcom = wifepeople.gedcom ";
$query .= "WHERE mediaID = '$mediaID' ";
$query .= "ORDER BY medialinks.medialinkID DESC";
$result2 = tng_query($query);
$numlinks = tng_num_rows($result2);

$helplang = findhelp("media_help.php");

tng_adminheader(_('Edit Existing Media'), $flags);

$standardtypes = [];
$moptions = "";
$likearray = "var like = new Array();\n";
foreach ($mediatypes as $mediatype) {
    if (!$mediatype['type']) {
        $standardtypes[] = "\"" . $mediatype['ID'] . "\"";
    }
    $msgID = $mediatype['ID'];
    $moptions .= "	<option value=\"$msgID\"";
    if ($msgID == $mediatypeID) $moptions .= " selected";

    $moptions .= ">" . $mediatype['display'] . "</option>\n";
    $likearray .= "like['$msgID'] = '{$mediatype['liketype']}';\n";
}
$sttypestr = implode(",", $standardtypes);

$usefolder = $row['usecollfolder'] ? $mediatypes_assoc[$mediatypeID] : $mediapath;

if ($row['thumbpath'] && file_exists("$rootpath$usefolder/" . $row['thumbpath'])) {
    $photoinfo = @GetImageSize("$rootpath$usefolder/" . $row['thumbpath']);
    if ($photoinfo[1] < 50) {
        $photohtouse = $photoinfo[1];
        $photowtouse = $photoinfo[0];
    } else {
        $photohtouse = 50;
        $photowtouse = intval(50 * $photoinfo[0] / $photoinfo[1]);
    }
    $photo = "<img border=0 src=\"$usefolder/" . str_replace("%2F", "/", rawurlencode($row['thumbpath'])) . "\" width=\"$photowtouse\" height=\"$photohtouse\" style=\"border-color:#000000;margin-right:6px;\"></span>\n";
} else {
    $photo = "";
}

if ($row['path'] && ($form == "JPG" || $form == "JPEG" || $form == "GIF" || $form == "PNG")) {
    $size = @GetImageSize("$rootpath$usefolder/" . $row['path']);
    $isphoto = TRUE;
} else {
    $size = "";
    $isphoto = FALSE;
}
if ($map['key'] && $isConnected) {
    echo "<script src=\"{$http}://maps.googleapis.com/maps/api/js?language=" . _('&amp;hl=en') . "$mapkeystr\"></script>\n";
}
?>
<?php
$onload = $onunload = "";
if ($isphoto && !$row['abspath']) $onload = "init();";

$placeopen = 0;
if ($map['key']) {
    include "googlemaplib2.php";
    if (!$map['startoff']) {
        $onload .= "divbox('mapcontainer');";
        $placeopen = 1;
    }
}
if ($onload) $onload = " onload='$onload'";

echo "</head>\n";

echo tng_adminlayout($onload);

$mediatabs[0] = [1, "admin_media.php", _('Search'), "findmedia"];
$mediatabs[1] = [$allow_media_add, "admin_newmedia.php", _('Add New'), "addmedia"];
$mediatabs[2] = [$allow_media_edit, "admin_ordermediaform.php", _('Sort'), "sortmedia"];
$mediatabs[3] = [$allow_media_edit && !$assignedtree, "admin_thumbnails.php", _('Thumbnails'), "thumbs"];
$mediatabs[4] = [$allow_media_add && !$assignedtree, "admin_photoimport.php", _('Import'), "import"];
$mediatabs[5] = [$allow_media_add, "admin_mediaupload.php", _('Upload'), "upload"];
$mediatabs[6] = [$allow_media_edit, "#", _('Edit'), "edit"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/media_help.php#modify');\" class='lightlink'>" . _('Help for this area') . "</a> ";
$innermenu .= "&nbsp;|&nbsp;<a href='#' class='lightlink' onClick=\"return toggleAll('on');\">" . _('Expand all') . "</a> &nbsp;|&nbsp; <a href='#' class='lightlink' onClick=\"return toggleAll('off');\">" . _('Collapse all') . "</a>";
$innermenu .= " &nbsp;|&nbsp; <a href=\"showmedia.php?mediaID=$mediaID\" target='_blank' class='lightlink'>" . _('Test') . "</a>";
$menu = doMenu($mediatabs, "edit", $innermenu);
echo displayHeadline(_('Media') . " &gt;&gt; " . _('Existing Media Information'), "img/photos_icon.gif", $menu, "");
?>

    <form action="admin_updatemedia.php" method="post" name="form1" id="form1" enctype="multipart/form-data" onsubmit="return validateForm();">
        <table class="lightback">
            <tr class="databack">
                <td class="tngshadow">
                    <table cellpadding="0" cellspacing="0" class="normal">
                        <tr>
                            <td class='align-top'>
                                <div id="thumbholder" style="margin-right: 5px;<?php if (!$photo) {
                                    echo "display: none";
                                } ?>"><?php echo $photo; ?></div>
                            </td>
                            <td>
                                <span class="plainheader"><?php echo $row['description']; ?></span><br>
                                <?php echo $row['notes']; ?>

                                <div class="topbuffer bottombuffer smallest">
                                    <?php echo "<a href='#' onclick=\"document.form1.fsubmit.click();\" class=\"smallicon si-plus admin-save-icon\">" . _('Save') . "</a>\n"; ?>
                                    <br><br>
                                </div>

                                <span class="smallest"><?php echo _('Last Modified Date') . ": " . $row['changedate'] . ($row['changedby'] ? " ({$row['changedby']})" : ""); ?></span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="databack">
                <td class="tngshadow">
                    <?php echo displayToggle("plus0", 1, "mediafile", _('Media File'), _('Upload a new file from your computer, or select from files already on your site')); ?>

                    <div id="mediafile">
                        <br>
                        <table class="normal">
                            <tr>
                                <td class='align-top'><?php echo _('Collection'); ?>:</td>
                                <td>
                                    <select name="mediatypeID" onchange="switchOnType(this.options[this.selectedIndex].value)">
                                        <?php
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
                            <tr>
                                <td class="align-top" colspan="2">
                                    <input type="checkbox" name="abspath" value="1"<?php if ($row['abspath']) {
                                        echo " checked";
                                    } ?> onClick="toggleMediaURL();">
                                    <span class="normal"> <?php echo _('This media comes from an external source (you must supply your own thumbnail)'); ?></span></td>
                            </tr>
                            <tr>
                                <td colspan="2"><strong><br><?php echo _('Media File'); ?></strong></td>
                            </tr>
                            <tr id="imgrow">
                                <td><?php echo _('File to upload'); ?>*:</td>
                                <td>
                                    <input type="file" name="newfile" size="60" onChange="populatePath(document.form1.newfile,document.form1.path);">
                                </td>
                            </tr>
                            <tr id="pathrow">
                                <td><?php echo _('File name on site'); ?>**:</td>
                                <td>
                                    <input type="text" value="<?php if (!$row['abspath']) {
                                        echo $row['path'];
                                    } ?>" name="path" id="path" size="60">
                                    <input type="hidden" value="<?php if (!$row['abspath']) {
                                        echo $row['path'];
                                    } ?>" id="path_org" name="path_org">
                                    <input type="hidden" id="path_last" name="path_last">
                                    <input type="button" value="<?php echo "" . _('Select') . "..."; ?>"
                                        name="photoselect"
                                        onclick="javascript:var folder = document.form1.usecollfolder[1].checked ? document.form1.mediatypeID.options[document.form1.mediatypeID.selectedIndex].value : 'media';FilePicker('path',folder);">
                                </td>
                            </tr>
                            <tr id="abspathrow" style="display:none;">
                                <td><?php echo _('Media URL'); ?>:</td>
                                <td>
                                    <input type="text" value="<?php if ($row['abspath']) {
                                        echo $row['path'];
                                    } ?>" name="mediaurl" size="60">
                                </td>
                            </tr>

                            <!-- history section -->
                            <tr id="bodytextrow">
                                <td class='align-top'><?php echo _('<strong>OR</strong><br>Body Text'); ?>:</td>
                                <td><textarea cols="100" rows="11" name="bodytext" id="bodytext"><?php echo $row['bodytext']; ?></textarea></td>
                            </tr>

                            <?php if (function_exists("imageJpeg")) { ?>
                                <tr>
                                    <td class='align-top'><strong><br><?php echo _('Thumbnail Image File'); ?></strong></td>
                                    <td class='align-top'><br>
                                        <input type="radio" name="thumbcreate" value="specify" checked="checked"
                                            onClick="document.form1.newthumb.style.visibility='visible'; document.form1.thumbselect.style.visibility='visible';"> <?php echo _('Specify image'); ?>
                                        &nbsp;
                                        <input type="radio" name="thumbcreate" value="auto"
                                            onClick="document.form1.newthumb.style.visibility='hidden'; document.form1.thumbselect.style.visibility='hidden'; prepopulateThumb(); document.form1.abspath.checked=false;"> <?php echo _('Create from original'); ?>
                                    </td>
                                </tr>
                            <?php } else { ?>
                                <tr>
                                    <td colspan="2"><strong><br><?php echo _('Thumbnail Image File'); ?></strong></td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td><?php echo _('File to upload'); ?>*:</td>
                                <td>
                                    <input type="file" name="newthumb" size="60" onChange="populatePath(document.form1.newthumb,document.form1.thumbpath);">
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('File name on site'); ?>**:</td>
                                <td>
                                    <input type="text" value="<?php echo $row['thumbpath']; ?>" name="thumbpath" id="thumbpath" size="60">
                                    <input type="hidden" value="<?php if (!$row['abspath']) {
                                        echo $row['thumbpath'];
                                    } ?>" id="thumbpath_org" name="thumbpath_org">
                                    <input type="hidden" id="thumbpath_last" name="thumbpath_last">
                                    <input type="button" value="<?php echo "" . _('Select') . "..."; ?>" name="thumbselect"
                                        OnClick="javascript:var folder = document.form1.usecollfolder[1].checked ? document.form1.mediatypeID.options[document.form1.mediatypeID.selectedIndex].value : 'media';FilePicker('thumbpath',folder);">
                                </td>
                            </tr>
                            <tr>
                                <td class='align-top'><strong><br><?php echo _('Store files in'); ?></strong></td>
                                <td class='align-top'><br>
                                    <input type="radio" name="usecollfolder" value="0"<?php if (!$row['usecollfolder']) {
                                        echo " checked";
                                    } ?>> <?php echo _('Multimedia Folder'); ?> &nbsp;
                                    <input type="radio" name="usecollfolder" value="1"<?php if ($row['usecollfolder']) {
                                        echo " checked";
                                    } ?>> <?php echo _('Collection Folder (e.g., \"photos\")'); ?>
                                </td>
                            </tr>
                            <tr id="vidrow1">
                                <td><?php echo _('Width (pixels)'); ?>:</td>
                                <td>
                                    <input type="text" name="width" value="<?php echo $row['width']; ?>" size="40">
                                </td>
                            </tr>
                            <tr id="vidrow2">
                                <td><?php echo _('Height (pixels)'); ?>:</td>
                                <td>
                                    <input type="text" name="height" value="<?php echo $row['height']; ?>" size="40">
                                    <span class="normal"> (<?php echo _('Please allow about 16 vertical pixels for the media player controller.'); ?>)</span></td>
                            </tr>
                        </table>
                        <p class="smaller">
                            <?php
                            echo "*" . _('Leave this field blank if the file has already been uploaded.') . "<br>\n";
                            echo "**" . _('Required. This should correspond to the name and location of your file <em>within the collection folder</em> once the file is uploaded. For example, suppose you are uploading a photo and your photos folder is called <em>photos</em>. If you want your file to be called <em>myphoto.jpg</em> and go in a subfolder of photos called <em>newphotos</em>, you would enter <em>newphotos/myphoto.jpg</em> in this field.') . "<br>\n";
                            ?>
                        </p>
                    </div>
                </td>
            </tr>

            <tr class="databack">
                <td class="tngshadow">
                    <?php echo displayToggle("plus1", 1, "details", _('Media Information'), _('Edit media title, description and other basic details')); ?>

                    <div id="details">
                        <br>
                        <table class="normal">
                            <tr>
                                <td class='align-top'><?php echo _('Title'); ?>:</td>
                                <td><textarea cols="70" rows="3" name="description"><?php echo $row['description']; ?></textarea></td>
                            </tr>
                            <tr>
                                <td class='align-top'><?php echo _('Description'); ?>:</td>
                                <td><textarea cols="70" rows="5" name="notes"><?php echo $row['notes']; ?></textarea></td>
                            </tr>
                            <tr>
                                <td><?php echo _('Owner/Source'); ?>:</td>
                                <td>
                                    <input type="text" name="owner" value="<?php echo $row['owner']; ?>" size="40">
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Date Taken/Created'); ?>:</td>
                                <td>
                                    <input type="text" name="datetaken" value="<?php echo $row['datetaken']; ?>" size="40" onblur="checkDate(this);">
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Tree'); ?>:</td>
                                <td>
                                    <?php
                                    if ($assignedtree) {
                                        if ($row['gedcom']) {
                                            $treeresult = tng_query($orderedTreesList->getQuery());
                                            $treerow = tng_fetch_assoc($treeresult);
                                            echo $treerow['treename'];
                                            tng_free_result($treeresult);
                                        } else {
                                            echo _('All Trees');
                                    }
                                    echo "<input type='hidden' name='tree' value='{$row['gedcom']}'>";
                                } else {
                                        echo "<select name='tree' onchange=\"$('#microtree').val($(this).val());\">";
                                        echo "	<option value=''>" . _('All Trees') . "</option>\n";
                                    if ($row['gedcom']) $tree = $row['gedcom'];

                                        echo $orderedTreesList->getSelectOptionsHtml($row['gedcom']);
                                    }
                                    ?>
                                    </select>
                                </td>
                            </tr>

                            <!-- headstone section -->
                            <tr id="cemrow">
                                <td><?php echo _('Cemetery'); ?>:</td>
                                <td>
                                    <div id="cemchoice"<?php if ($row['cemeteryID'] || $mediatypeID == "headstones") {
                                        echo " style='display: none;'";
                                    } ?>><a href="#" onclick="return toggleCemSelect();"><?php echo _('Select'); ?></a></div>
                                    <div id="cemselect"<?php if (!$row['cemeteryID'] && $mediatypeID != "headstones") {
                                        echo " style='display: none;'";
                                    } ?>>
                                        <select name="cemeteryID">
                                            <option selected></option>
                                            <?php
                                            $query = "SELECT cemname, cemeteryID, city, county, state, country ";
                                            $query .= "FROM $cemeteries_table ";
                                            $query .= "ORDER BY country, state, county, city, cemname";
                                            $cemresult = tng_query($query);
                                        while ($cemrow = tng_fetch_assoc($cemresult)) {
                                            $cemetery = "{$cemrow['country']}, {$cemrow['state']}, {$cemrow['county']}, {$cemrow['city']}, {$cemrow['cemname']}";
                                            echo "<option value='{$cemrow['cemeteryID']}'";
                                            if ($row['cemeteryID'] == $cemrow['cemeteryID']) {
                                                echo " selected";
                                            }
                                            echo ">$cemetery</option>\n";
                                        }
                                            ?>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr id="hsplotrow">
                                <td class='align-top'><?php echo _('Plot'); ?>:</td>
                                <td><textarea cols="70" rows="2" name="plot"><?php echo $row['plot']; ?></textarea></td>
                            </tr>
                            <tr id="hsstatrow">
                                <td><?php echo _('Status'); ?>:</td>
                                <td>
                                    <select name="status">
                                        <option value="">&nbsp;</option>
                                        <option value="notyetlocated"<?php if ($row['status'] == 'notyetlocated') {
                                            echo " selected";
                                        } ?>><?php echo _('Not yet located'); ?></option>
                                        <option value="located"<?php if ($row['status'] == 'located') {
                                            echo " selected";
                                        } ?>><?php echo _('Located'); ?></option>
                                        <option value="unmarked"<?php if ($row['status'] == 'unmarked') {
                                            echo " selected";
                                        } ?>><?php echo _('Unmarked'); ?></option>
                                        <option value="missing"<?php if ($row['status'] == 'missing') {
                                            echo " selected";
                                        } ?>><?php echo _('Missing'); ?></option>
                                        <option value="cremated"<?php if ($row['status'] == 'cremated') {
                                            echo " selected";
                                        } ?>><?php echo _('Cremated'); ?></option>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td class="align-top" colspan="2">
                                    <input type="checkbox" name="alwayson" value="1"<?php if ($row['alwayson']) {
                                        echo " checked";
                                    } ?>> <?php echo _('Always viewable'); ?></td>
                            </tr>

                            <!-- history section -->
                            <tr id="newwinrow">
                                <td class="align-top" colspan="2">
                                    <input type="checkbox" name="newwindow" value="1"<?php if ($row['newwindow']) {
                                        echo " checked";
                                    } ?>> <?php echo _('Open in new window'); ?></td>
                            </tr>

                            <!-- headstone section -->
                            <tr id="linktocemrow">
                                <td class="align-top" colspan="2">
                                    <input type="checkbox" name="linktocem" value="1"<?php if ($row['linktocem']) {
                                        echo " checked";
                                    } ?>> <?php echo _('Link this media directly to the selected cemetery'); ?></td>
                            </tr>
                            <tr id="maprow">
                                <td class="align-top" colspan="2">
                                    <input type="checkbox" name="showmap" value="1"<?php if ($row['showmap']) {
                                        echo " checked";
                                    } ?>> <?php echo _('Show cemetery map and media whenever this item is displayed'); ?></td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>

            <tr class="databack">
                <td class="tngshadow" id="linkstd">
                    <?php echo displayToggle("plus2", 1, "links", _('Media Links') . " (<span id=\"linkcount\">$numlinks</span>)", _('Link this item to People, Families, Sources, Repositories or Places')); ?>

                    <?php include "micro_medialinks.php"; ?>
                </td>
            </tr>

            <tr class="databack">
                <td class="tngshadow">
                    <?php echo displayToggle("plus3", $placeopen, "placeinfo", _('Place Taken/Created'), ""); ?>

                    <div id="placeinfo"<?php if (!$placeopen) {
                        echo " style='display: none;'";
                    } ?>>
                        <table class="w-full topbuffer normal">
                            <tr>
                                <td width="150"><?php echo _('Place Taken/Created'); ?>:</td>
                                <td>
                                    <input id="place" class="float-left" name="place" type="text" value="<?php echo $row['placetaken']; ?>" size="40">
                                    <a href="#" class="smallicon admin-find-icon dn2px" title="<?php echo _('Find...'); ?>" onclick="return openFindPlaceForm('place');"></a>
                                </td>
                            </tr>
                            <?php if ($map['key']) { ?>
                                <tr>
                                    <td colspan="2">
                                        <div style="padding:0 10px 10px 0;">
                                            <?php
                                            // draw the map here
                                            include "googlemapdrawthemap.php";
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td><?php echo _('Latitude'); ?>:</td>
                                <td>
                                    <input type="text" name="latitude" value="<?php echo $row['latitude']; ?>" size="20" id="latbox">
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo _('Longitude'); ?>:</td>
                                <td>
                                    <input type="text" name="longitude" value="<?php echo $row['longitude']; ?>" size="20" id="lonbox">
                                </td>
                            </tr>
                            <?php if ($map['key']) { ?>
                                <tr>
                                    <td><?php echo _('Zoom'); ?>:</td>
                                    <td>
                                        <input type="text" name="zoom" value="<?php echo $row['zoom']; ?>" size="20" id="zoombox">
                                    </td>
                                </tr>
                            <?php } ?>
                    </table>
                </div>
            </td>
        </tr>

        <?php if ($isphoto && !$row['abspath']) { ?>
            <tr class="databack">
                <td class="tngshadow">
                    <?php echo displayToggle("plus4", 0, "imagemapdiv", _('Image Map'), _('Link regions of your image to different people or other pages (optional)')); ?>

                    <div id="imagemapdiv" class="normal" style="display:none;">
                        <p><?php echo _('To link a region of this photo to an individual, first select the individual\'s tree, then create a rectangle for the desired region. This is done by clicking in the upper left corner of the region and then dragging to the lower right corner. Alternately, you may click in the upper left corner and then again in the lower right corner. A popup box will then help you select the individual. After the selection is made, code for the image map will be added to the box below. Repeat this process as needed for additional regions.'); ?></p>
                        <div class="normal">
                            <label for="maptree"><?php echo _('Tree'); ?>:</label>
                            <select name="maptree" id="maptree">
                                <?php echo $orderedTreesList->getSelectOptionsHtml(); ?>
                            </select>
                            <br><br>
                            <strong><?php echo _('For rectangles'); ?>:</strong>
                            <p><?php echo _('First click in the upper left corner of the rectangle, then click in the lower right corner.'); ?></p>
                        </div>
                        <br>
                        <?php
                        $width = $size[0];
                        $height = $size[1];
                        if ($width && $height) {
                            if ($tngconfig['imgmaxw'] && ($width > $tngconfig['imgmaxw'])) {
                                $width = $tngconfig['imgmaxw'];
                                $height = intval($width * $size[1] / $size[0]);
                            }
                            if ($tngconfig['imgmaxh'] && ($height > $tngconfig['imgmaxh'])) {
                                $height = $tngconfig['imgmaxh'];
                                $width = intval($height * $size[0] / $size[1]);
                            }
                        }
                        $widthstr = "width='$width'";
                        $heightstr = "height='$height'";
                        echo "" . _('Image dimensions') . ": $width " . _('pixels wide') . " x $height " . _('pixels high') . "";
                        $treestr = $tngconfig['mediatrees'] && $row['gedcom'] ? $row['gedcom'] . "/" : "";
                        ?>
                        <br>
                        <div id="imgholder" style="position:relative;">
                            <img id="myimg" src="<?php echo "$usefolder/$treestr" . str_replace("%2F", "/", rawurlencode($row['path'])); ?>" <?php echo "$widthstr $heightstr"; ?>
                                alt="<?php echo _('First click in the center of the circle, then click anywhere on the outside of the circle.'); ?>"
                                style="cursor:crosshair;">
                        </div>
                        <p class="normal"><?php echo _('Image Map'); ?>:
                            <br><textarea cols="80" rows="4" name="imagemap" id="imagemap"><?php echo $row['map']; ?></textarea></p>

                    </div>
                </td>
            </tr>
        <?php } ?>

            <tr class="databack">
                <td class="tngshadow">
                    <p class="normal">
                        <?php
                        echo _('On save') . ":<br>";
                        echo "<input type='radio' name=\"newmedia\" value='return'> " . _('Return to this page') . "<br>\n";
                        if ($cw) {
                            echo "<input type='radio' name=\"newmedia\" value=\"close\" checked> " . _('Close this window') . "\n";
                        } else {
                            echo "<input type='radio' name=\"newmedia\" value=\"none\" checked> " . _('Return to menu') . "\n";
                        }
                        ?>
                    </p>

                    <input type="hidden" name="usenl" value="0">
                    <input type="hidden" name="mediatypeID_org" value="<?php echo "$mediatypeID"; ?>">
                    <input type="hidden" name="mediaID" value="<?php echo "$mediaID"; ?>">
                    <input type="hidden" name="mediakey_org" value="<?php echo $row['mediakey']; ?>">
                    <input type="hidden" value="<?php echo "$cw"; ?>" name="cw">
                    <input type="submit" name="fsubmit" class="btn" accesskey="s" value="<?php echo _('Save'); ?>">
                </td>
            </tr>
        </table>
    </form>

    <script>
        var tree = "";
        var type = "media";
        var treename = new Array();
        var seclitbox, tnglitbox;
        <?php
        echo "var media = \"$mediaID\";\n";
        echo "var thumbprefix = \"$thumbprefix\";\n";
        echo "var thumbsuffix = \"$thumbsuffix\";\n";
        echo "const treemsg = \"" . _('Tree') . "\";\n";
        echo "const personmsg = \"" . _('Person') . "\";\n";
        echo "const idmsg = \"" . _('ID') . "\";\n";
        echo "const familymsg = \"" . _('Family') . "\";\n";
        echo "const sourcemsg = \"" . _('Source') . "\";\n";
        echo "const repositorymsg = \"" . _('Repository') . "\";\n";
        echo "const placemsg = \"" . _('Place') . "\";\n";
        echo "const findmsg = \"" . _('Find...') . "\";\n";
        echo "const altdescmsg = \"" . _('Alternate Title') . "\";\n";
        echo "const altnotesmsg = \"" . _('Alternate Description') . "\";\n";
        echo "const makedefaultmsg = \"" . _('Make Default') . "\";\n";
        echo "const eventlinkmsg = \"" . _('Link to specific event') . "\";\n";
        echo "const eventmsg = \"" . _('Event(s)') . "\";\n";
        echo "const sortmsg = \"" . _('Sort') . "\";\n";
        echo "const confdellink = \"" . _('Are you sure you want to delete this link?') . "\";\n";
        echo "const remove_text = \"" . _('Remove Link') . "\";\n";
        echo "const edit_text = \"" . _('Edit') . "\";\n";
        echo "const yesmsg = \"" . _('Yes') . "\";\n";
        echo "var linkcount = $numlinks;\n";
        echo "var manage = 0;\n";
        echo "var assignedbranch = \"$assignedbranch\";\n";
        echo "var getperson_url = \"getperson.php?\";\n";
        echo $likearray;
        ?>
        const entercollid = "<?php echo _('Please enter a collection ID.'); ?>";
        const entercolldisplay = "<?php echo _('Please enter a collection display name.'); ?>";
        const entercollipath = "<?php echo _('Please enter a collection folder name.'); ?>";
        const entercollicon = "<?php echo _('Please enter a collection icon file name.'); ?>";
        const confmtdelete = "<?php echo _('Are you sure you want to delete this media type?'); ?>";
        const yestext = "<?php echo _('Yes'); ?>";
        var stmediatypes = new Array(<?php echo $sttypestr; ?>);
        var allow_edit = <?php echo($allow_edit ? "1" : "0"); ?>;
        var allow_delete = <?php echo($allow_delete ? "1" : "0"); ?>;
        const linkmsg = "<?php echo _('Please enter an ID for the selected Link Type.'); ?>";
        const confdeletefile = "<?php echo _('Are you sure you want to delete this file?'); ?>";

        function validateForm() {
            let rval = true;
            var frm = document.form1;
            if (frm.path.value.length == 0 && frm.mediaurl.value.length == 0 && frm.bodytext.value.length == 0 && frm.mediatypeID.options[frm.mediatypeID.selectedIndex].value != "headstones") {
                alert("<?php echo _('Please enter the path (folder and file name) of the image file within the photos folder on your web server.'); ?>");
                rval = false;
            } else if (frm.thumbpath.value.length == 0 && frm.thumbcreate[1].checked == true) {
                alert("<?php echo _('Please enter a destination name for your thumbnail image'); ?>");
                rval = false;
            } else if (frm.thumbpath.value.length > 0 && frm.path.value == frm.thumbpath.value) {
                alert("<?php echo _('The principal image and the thumbnail image may not be the same file. Please select a different thumbnail image, or have one created for you.'); ?>");
                rval = false;
            } else {
                frm.path.value = frm.path.value.replace(/\\/g, "/");
                frm.thumbpath.value = frm.thumbpath.value.replace(/\\/g, "/");
            }
            if (rval && frm.newfile.value && frm.path.value != from.path_org.value) {
                rval = false;
                var usecollfolder = frm.usecollfolder[0].checked ? 0 : 1;
                var mediatypeID = frm.mediatypeID.options[frm.mediatypeID.selectedIndex].value;
                var thumbpath = frm.newthumb.value ? frm.thumbpath.value : "";
            var params = {path: frm.path.value, thumbpath: thumbpath, usecollfolder: usecollfolder, mediatypeID: mediatypeID};
            jQuery.ajax({
                url: 'admin_checkfile.php',
                data: params,
                dataType: 'json',
                success: function (vars) {
                    frm.path.value = vars.path;
                    if (vars.thumbpath)
                        frm.thumbpath.value = vars.thumbpath;
                    document.form1.submit();
                }
            });
        }
        return rval;
    }

    function toggleAll(display) {
        toggleSection('mediafile', 'plus0', display);
        toggleSection('details', 'plus1', display);
        toggleSection('links', 'plus2', display);
        toggleSection('placeinfo', 'plus3', display);
        if (jQuery('#imagemapdiv').length)
            toggleSection('imagemapdiv', 'plus4', display);
        return false;
    }
</script>
<script src="js/mediautils.js"></script>
<script src="js/mediafind.js"></script>
<script src="js/selectutils.js"></script>
<script src="js/datevalidation.js"></script>
<script>
    var preferEuro = <?php echo($tngconfig['preferEuro'] ? $tngconfig['preferEuro'] : "false"); ?>;
    var preferDateFormat = '<?php echo $preferDateFormat; ?>';
    switchOnType(document.form1.mediatypeID.options[document.form1.mediatypeID.selectedIndex].value);
    toggleMediaURL();
    var findform = document.form1;
    <?php
    include "niceditmsgs.php";
    ?>
</script>
<script src="js/nicedit.js"></script>
<script>
    //<![CDATA[
    bkLib.onDomLoaded(function () {
        new nicEditor({fullPanel: true}).panelInstance('bodytext');
        <?php
        if ($isphoto && !$row['abspath']) echo "init();\n";

        if ($map['key'] && !$map['startoff']) {
            echo "divbox('mapcontainer');\n";
        }
        if ($added) {
            echo "toggleSection('mediafile','plus0');\n";
            echo "toggleSection('details','plus1');\n";
        }
        ?>
    });

    var box;
    var x1, y1;

    $(document).ready(function () {

        $('#myimg').mousedown(function (e) {
            e.preventDefault();
            if ($("#mlbox").length)
                var a = 1;
            else {
                $('.bselected').removeClass('bselected').addClass('bunselected');

                box = $('<div id="mlbox" class="mlbox bunselected">').hide();

                $('#imgholder').append(box);

                x1 = e.pageX;
                y1 = e.pageY;
                //console.log('x:'+e.pageX+' y:'+e.pageY+' rxp:'+relativeXPosition+' ryp:'+relativeYPosition+' x1:'+x1+' y1:'+y1);

                box.css({
                    top: e.pageY - $(e.target).offset().top - 1, //offsets
                    left: e.pageX - $(e.target).offset().left - 1 //offsets
                }).fadeIn();
            }
        });

        $('#myimg').mousemove(function (e) {

            e.preventDefault();
            $("#mlbox").css({
                width: Math.abs(e.pageX - x1 - 1), //offsets
                height: Math.abs(e.pageY - y1 - 1) //offsets
            }).fadeIn();
        });

        $('#myimg').mouseup(function () {
            var tree = jQuery('#maptree').val();
            findItem('I', 'imagemap', '', tree, assignedbranch);
            $("#current").attr({id: ''});
        });
    });
    //]]>
</script>

<?php echo tng_adminfooter(); ?>