<?php
include "begin.php";
include "adminlib.php";
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

$tng_search_places = $_SESSION['tng_search_album'];

$query = "SELECT * FROM $albums_table WHERE albumID = \"$albumID\"";
$result = tng_query($query);
$row = tng_fetch_assoc($result);
tng_free_result($result);
$row['description'] = preg_replace("/\"/", "&#34;", $row['description']);
$row['keywords'] = preg_replace("/\"/", "&#34;", $row['keywords']);

$query2 = "SELECT albumlinkID, thumbpath, media.mediaID AS mediaID, usecollfolder, mediatypeID, notes, description, datetaken, placetaken, defphoto, media.gedcom ";
$query2 .= "FROM ($media_table media, $albumlinks_table albumlinks) ";
$query2 .= "WHERE albumID = \"$albumID\" AND media.mediaID = albumlinks.mediaID ";
$query2 .= "ORDER BY ordernum, description";
$result2 = tng_query($query2) or die (_('Cannot execute query') . ": $query2");
$numrows = tng_num_rows($result2);

$query3 = "SELECT alinkID, entityID, eventID, people.lastname AS lastname, people.lnprefix AS lnprefix, people.firstname AS firstname, people.suffix AS suffix, people.nameorder AS nameorder, ate.gedcom, treename, familyID, people.personID AS personID, wifepeople.personID AS wpersonID, wifepeople.firstname AS wfirstname, wifepeople.lnprefix AS wlnprefix, wifepeople.lastname AS wlastname, wifepeople.prefix AS wprefix, wifepeople.suffix AS wsuffix, wifepeople.nameorder AS wnameorder, husbpeople.personID AS hpersonID, husbpeople.firstname AS hfirstname, husbpeople.lnprefix AS hlnprefix, husbpeople.lastname AS hlastname, husbpeople.prefix AS hprefix, husbpeople.suffix AS hsuffix, husbpeople.nameorder AS hnameorder, sourceID, sources.title, repositories.repoID AS repoID, reponame, linktype ";
$query3 .= "FROM ($album2entities_table ate, $trees_table trees) ";
$query3 .= "LEFT JOIN $people_table people ON ate.entityID = people.personID AND ate.gedcom = people.gedcom ";
$query3 .= "LEFT JOIN $families_table families ON ate.entityID = families.familyID AND ate.gedcom = families.gedcom ";
$query3 .= "LEFT JOIN $sources_table sources ON ate.entityID = sources.sourceID AND ate.gedcom = sources.gedcom ";
$query3 .= "LEFT JOIN $repositories_table repositories ON ate.entityID = repositories.repoID AND ate.gedcom = repositories.gedcom ";
$query3 .= "LEFT JOIN $people_table husbpeople ON families.husband = husbpeople.personID AND families.gedcom = husbpeople.gedcom ";
$query3 .= "LEFT JOIN $people_table wifepeople ON families.wife = wifepeople.personID AND families.gedcom = wifepeople.gedcom ";
$query3 .= "WHERE albumID = \"$albumID\" AND ate.gedcom = trees.gedcom ";
$query3 .= "UNION ";
$query3 .= "SELECT alinkID, entityID, eventID, null, null, null, null, null, gedcom, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, linktype ";
$query3 .= "FROM $album2entities_table ";
$query3 .= "WHERE albumID = \"$albumID\" AND gedcom=\"\" ";
$query3 .= "ORDER BY alinkID DESC";
$result3 = tng_query($query3) or die (_('Cannot execute query') . ": $query3");
$numlinks = tng_num_rows($result3);

if (!$thumbmaxw) $thumbmaxw = 50;


if ($assignedtree) {
    $wherestr = "WHERE gedcom = '$assignedtree'";
    $tree = $assignedtree;
} else {
    $wherestr = "";
}
$treequery = "SELECT gedcom, treename FROM $trees_table $wherestr ORDER BY treename";

$helplang = findhelp("albums_help.php");

tng_adminheader(_('Edit Existing Album'), $flags);

$photo = "";

$query = "SELECT alwayson, thumbpath, media.mediaID AS mediaID, usecollfolder, mediatypeID, albumlinkID, media.gedcom ";
$query .= "FROM ($media_table media, $albumlinks_table albumlinks) ";
$query .= "WHERE albumID = \"$albumID\" AND media.mediaID = albumlinks.mediaID AND defphoto = '1'";
$defresult = tng_query($query);
if ($defresult) $drow = tng_fetch_assoc($defresult);

$thismediatypeID = $drow['mediatypeID'];
$usefolder = $drow['usecollfolder'] ? $mediatypes_assoc[$thismediatypeID] : $mediapath;
$treestr = $tngconfig['mediatrees'] && $drow['gedcom'] ? $drow['gedcom'] . "/" : "";
tng_free_result($defresult);

$photoref = "$usefolder/$treestr" . $drow['thumbpath'];

if ($drow['thumbpath'] && file_exists("$rootpath$photoref")) {
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
<script src="js/mediafind.js"></script>
    <script src="js/mediautils.js"></script>
    <script src="js/selectutils.js"></script>
    <script>
        <!--
        var tnglitbox;
        var album = "<?php echo $albumID; ?>";
        var entity = "";
        var tree = "";
        var type = "album";
        var thumbmaxw = parseInt("<?php echo $thumbmaxw; ?>");
        const dragmsg = "<?php echo _('Drag'); ?>";
        const remove_text = "<?php echo _('Remove'); ?>";
        const edit_text = "<?php echo _('Edit'); ?>";
        var mediacount = <?php echo $numrows; ?>;
        var linkcount = <?php echo $numlinks; ?>;
        const selectmsg = "<?php echo _('Please select/add a tree.'); ?>";
        const linkmsg = "<?php echo _('Please enter an ID for the selected Link Type.'); ?>";
        const duplinkmsg = "<?php echo _('A link to the selected entity already exists in this album.'); ?>";
        const invlinkmsg = "<?php echo _('The entity ID you entered is invalid. No link was created.'); ?>";
        const mkdefaultmsg = "<?php echo _('Make Default'); ?>";
        const searchmsg = "<?php echo _('Please enter a search value.'); ?>";
        const sortmsg = "<?php echo _('Sort'); ?>";
        const confdellink = "<?php echo _('Are you sure you want to delete this link?'); ?>";
        const confremmedia = "<?php echo _('Are you sure you want to remove this media from this album?'); ?>";
        const movetopmsg = "<?php echo _('Move to top'); ?>";
        var topmsg = "<?php echo _('Top'); ?>";
        const gomsg = "<?php echo _('Go'); ?>";
        var findopen;
        var orderaction = "order";

        function toggleAll(display) {
            toggleSection('details', 'plus0', display);
            toggleSection('addmedia', 'plus1', display);
            toggleSection('albumlinks', 'plus2', display);
            return false;
        }

        -->
    </script>
    <script src="js/albums.js"></script>

<?php
echo "</head>\n";
echo tng_adminlayout(" onload=\"startMediaSort()\"");

$albumtabs[0] = [1, "admin_albums.php", _('Search'), "findalbum"];
$albumtabs[1] = [$allow_add, "admin_newalbum.php", _('Add New'), "addalbum"];
$albumtabs[2] = [$allow_edit, "admin_orderalbumform.php", _('Sort'), "sortalbums"];
$albumtabs[3] = [$allow_edit, "#", _('Edit'), "edit"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/albums_help.php#edit');\" class='lightlink'>" . _('Help for this area') . "</a>";
$innermenu .= " &nbsp;|&nbsp; <a href='#' class='lightlink' onClick=\"return toggleAll('on');\">" . _('Expand all') . "</a> &nbsp;|&nbsp; <a href='#' class='lightlink' onClick=\"return toggleAll('off');\">" . _('Collapse all') . "</a>";
$menu = doMenu($albumtabs, "edit", $innermenu);
echo displayHeadline(_('Albums') . " &gt;&gt; " . _('Edit Existing Album'), "img/albums_icon.gif", $menu, "");
?>

    <form action="admin_updatealbum.php" method="post" name="form1" id="form1" onSubmit="return validateForm();">
        <table class="lightback">
            <tr class="databack">
                <td class="tngshadow">
                    <div>
                        <div id="thumbholder" class="<?php if (!$photo) {
                            echo "hidden ";
                        } ?>float-left">
                            <?php echo $photo; ?>
                        </div>
                        <span class="plainheader"><?php echo $row['albumname'] . ": </span><br>" . $row['description']; ?>
                    </div>
                    <?php
                    echo "<a href='#' onclick=\"return removeDefault();\" class='smaller' id=\"removedefault\"";
                    if (!$photo) echo " style=\"visibility:hidden\"";
                    echo ">" . _('Remove default photo') . "</a>\n";
                    ?>
                </td>
            </tr>

            <tr class="databack">
                <td class="tngshadow">
                    <?php echo displayToggle("plus0", 0, "details", _('Album Information'), _('Edit album name, description and keywords')); ?>

                    <div id="details" style="display:none;">
                        <br>
                        <table class="normal">
                            <tr>
                                <td><?php echo _('Album Name'); ?>:</td>
                                <td>
                                    <input type="text" name="albumname" size="50" value="<?php echo $row['albumname']; ?>">
                                </td>
                            </tr>
                            <tr>
                                <td class='align-top'><?php echo _('Description'); ?>:</td>
                                <td><textarea cols="60" rows="3" name="description"><?php echo $row['description']; ?></textarea></td>
                            </tr>
                            <tr>
                                <td class='align-top'><?php echo _('Keywords'); ?>:</td>
                                <td><textarea cols="60" rows="3" name="keywords"><?php echo $row['keywords']; ?></textarea></td>
                            <tr>
                                <td><?php echo _('Active'); ?>:</td>
                                <td>
                                    <input type="radio" name="active" value="1"<?php if ($row['active']) {
                                        echo " checked";
                                    } ?>> <?php echo _('Yes'); ?> &nbsp;
                                    <input type="radio" name="active" value="0"<?php if (!$row['active']) {
                                        echo " checked";
                                    } ?>> <?php echo _('No'); ?></td>
                            </tr>
                            </tr>
                            <tr>
                                <td class="align-top" colspan="2">
                                    <input type="checkbox" name="alwayson" value="1"<?php if ($row['alwayson']) {
                                        echo " checked";
                                    } ?>> <?php echo _('Always viewable'); ?></td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>

            <tr class="databack tngshadow">
                <td class="tngshadow">
                    <?php echo displayToggle("plus1", 1, "addmedia", _('Album Media') . " (<span id=\"mediacount\">$numrows</span>)", _('Manage media included in this album (Add, Delete, Sort)')); ?>

                    <div id="addmedia">
                        <p class="normal" style="padding-top:12px;">
                            <input type="button" value="<?php echo _('Add Media'); ?>"
                                onclick="return openAlbumMediaFind();"> <?php echo _('Search for existing media to include in this album') . " (<a href=\"admin_newmedia.php\" target='_blank'>" . _('upload new media here first') . "</a>)"; ?>
                        </p>

                        <p class="normal">&nbsp;<strong><?php echo _('Included Media'); ?>:</strong> <?php echo _('Browse, Delete or Drag to Sort'); ?></p>
                        <table id="ordertbl" class="fieldname normal">
                            <tr>
                                <th class="fieldnameback" style="width:102px;"><?php echo _('Sort'); ?></th>
                                <th class="fieldnameback" style="width:<?php echo($thumbmaxw + 10); ?>px;"><?php echo _('Thumb'); ?></th>
                                <th class="fieldnameback"><?php echo _('Description'); ?></th>
                                <th class="fieldnameback" style="width:154px;"><?php echo _('Date'); ?></th>
                                <th class="fieldnameback" style="width:105px;"><?php echo _('Collection'); ?></th>
                            </tr>
                        </table>

                        <div id="orderdivs">
                            <?php
                            $count = 1;
                            while ($lrow = tng_fetch_assoc($result2)) {
                                $lmediatypeID = $lrow['mediatypeID'];
                                $label = $mediatypes_display[$lmediatypeID] ? $mediatypes_display[$lmediatypeID] : $text[$lmediatypeID];
                                $usefolder = $lrow['usecollfolder'] ? $mediatypes_assoc[$lmediatypeID] : $mediapath;
                            $treestr2 = $tngconfig['mediatrees'] && $lrow['gedcom'] ? $lrow['gedcom'] . "/" : "";

                            $truncated = substr($lrow['notes'], 0, 90);
                            $truncated = strlen($lrow['notes']) > 90 ? substr($truncated, 0, strrpos($truncated, ' ')) . '&hellip;' : $lrow['notes'];
                            echo "<div class='sortrow' id=\"orderdivs_{$lrow['albumlinkID']}\" style=\"clear:both;position:relative;\" onmouseover=\"jQuery('#del_{$lrow['albumlinkID']}').css('visibility','visible');\" onmouseout=\"jQuery('#del_{$lrow['albumlinkID']}').css('visibility','hidden');\">";
                            echo "<table class='w-full' cellpadding='5' cellspacing='1'>";
                            echo "<tr>\n";
                                echo "<td class='rounded-lg dragarea normal'>";
                                echo "<img src='img/admArrowUp.gif' alt='' class='inline-block'>" . _('Drag') . "<img src='img/admArrowDown.gif' alt='' class='inline-block'>\n";
                                echo "</td>\n";
                                echo "<td class='lightback smaller' style=\"width:35px;text-align:center;\">";
                                echo "<div style=\"padding-bottom:5px;\"><a href='#' onclick=\"return moveItemInList('{$lrow['albumlinkID']}',1);\" title=\"" . _('Move to top') . "\"><img src='img/admArrowUp.gif' alt='' class='inline-block'><br>Top</a></div>\n";
                                echo "<input style=\"width:30px;\" class=\"movefields\" name=\"move{$lrow['albumlinkID']}\" id=\"move{$lrow['albumlinkID']}\" value=\"$count\" onkeypress=\"return handleMediaEnter('{$lrow['albumlinkID']}',jQuery('#move{$lrow['albumlinkID']}').val(),event);\">\n";
                                echo "<a href='#' onclick=\"return moveItemInList('{$lrow['albumlinkID']}',jQuery('#move{$lrow['albumlinkID']}').val());\" title=\"" . _('Move to top') . "\">Go</a>\n";
                                echo "</td>\n";

                            echo "<td class='lightback' style=\"width:" . ($thumbmaxw + 6) . "px;text-align:center;\">";
                            if ($lrow['thumbpath'] && file_exists("$rootpath$usefolder/$treestr2" . $lrow['thumbpath'])) {
                                $size = @GetImageSize("$rootpath$usefolder/$treestr2" . $lrow['thumbpath']);
                                echo "<a href=\"admin_editmedia.php?mediaID={$lrow['mediaID']}\"><img src=\"$usefolder/$treestr2" . str_replace("%2F", "/", rawurlencode($lrow['thumbpath'])) . "\" $size[3] alt=\"" . htmlentities($lrow['description'], ENT_QUOTES) . " \"></a>";
                                $foundthumb = true;
                            } else {
                                echo "&nbsp;";
                                $foundthumb = false;
                            }
                            echo "</td>\n";
                            $checked = $lrow['defphoto'] ? " checked" : "";
                            echo "<td class='lightback normal'><a href=\"admin_editmedia.php?mediaID={$lrow['mediaID']}\">{$lrow['description']}</a><br>" . strip_tags($truncated) . "<br>";
                            echo "<div id=\"del_{$lrow['albumlinkID']}\" class='smaller' style='color: #808080; visibility: hidden;'>";
                            if ($foundthumb) {
                                echo "<input type='radio' name=\"rthumbs\" value=\"r{$lrow['mediaID']}\"$checked onclick=\"makeDefault(this);\">" . _('Make Default');
                                echo " &nbsp;|&nbsp; ";
                            }
                                echo "<a href='#' onclick=\"return removeFromAlbum('{$lrow['mediaID']}','{$lrow['albumlinkID']}');\">" . _('Remove') . "</a>";
                                echo "</div></td>\n";
                            echo "<td class='lightback normal' style=\"width:150px;\">{$lrow['datetaken']}&nbsp;</td>\n";
                                echo "<td class='lightback normal' style=\"width:100px;\">" . $label . "&nbsp;</td>\n";
                                echo "</tr></table>";
                                echo "</div>\n";
                                $count++;
                            }
                            $numrows = tng_num_rows($result2);
                            tng_free_result($result2);
                            ?>
                        </div>
                        <div id="nomedia" class="normal" style="margin-left:3px;">
                            <?php if (!$numrows) echo _('No media included yet'); ?>
                        </div>
                </td>
            </tr>

            <tr class="databack">
                <td class="tngshadow">
                    <?php echo displayToggle("plus2", 1, "albumlinks", _('Album Links') . " (<span id=\"linkcount\">$numlinks</span>)", _('Link this item to People, Families, Sources, Repositories or Places')); ?>

                    <div id="albumlinks">
                        <table cellspacing="2" style="padding-top:12px;">
                            <tr>
                                <td class="normal"><?php echo _('Tree'); ?></td>
                                <td class="normal"><?php echo _('Type'); ?></td>
                                <td class="normal" colspan="2"><?php echo _('ID'); ?></td>
                            </tr>
                            <tr>
                                <td>
                                    <select name="tree1">
                                        <?php
                                        $firsttree = isset($_COOKIE['tng_tree']) ? $_COOKIE['tng_tree'] : "";
                                        $treeresult = tng_query($treequery) or die (_('Cannot execute query') . ": $treequery");
                                        while ($treerow = tng_fetch_assoc($treeresult)) {
                                            echo "		<option value=\"{$treerow['gedcom']}\"";
                                            if ($firsttree == $treerow['gedcom']) echo " selected";

                                            echo ">{$treerow['treename']}</option>\n";
                                        }
                                        tng_free_result($treeresult);
                                        ?>
                                    </select>
                                </td>
                                <td>
                                    <select name="linktype1">
                                        <option value="I"><?php echo _('Person'); ?></option>
                                        <option value="F"><?php echo _('Family'); ?></option>
                                        <option value="S"><?php echo _('Source'); ?></option>
                                        <option value="R"><?php echo _('Repository'); ?></option>
                                        <option value="L"><?php echo _('Place'); ?></option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" name="newlink1" id="newlink1" value="" onkeypress="return newlinkEnter(document.form1,this,event);">
                                </td>
                                <td class="normal">
                                    <input type="button" value="<?php echo _('Add'); ?>" onclick="return addMedia2EntityLink(document.form1);">
                                    &nbsp;<?php echo _('OR'); ?>&nbsp;
                                </td>
                                <td><a href="#"
                                        onclick="return findItem(findform.linktype1.options[findform.linktype1.selectedIndex].value,'newlink1',null,findform.tree1.options[findform.tree1.selectedIndex].value,'<?php echo $assignedbranch; ?>','a_<?php echo $albumID; ?>');"
                                        title="<?php echo _('Find...'); ?>" class="smallicon admin-find-icon"></a></td>
                            </tr>
                        </table>
                        <div id="alink_error" style="display:none;" class="normal red"></div>

                        <p class="normal">&nbsp;<strong><?php echo _('Existing Links'); ?>:</strong> <?php echo _('Browse or Delete'); ?></p>
                        <table class="normal">
                            <tbody id="linktable">
                            <tr>
                                <th class="fieldnameback fieldname whitespace-no-wrap"><?php echo _('Action'); ?></th>
                                <th class="fieldnameback fieldname whitespace-no-wrap"><?php echo _('Type'); ?></th>
                                <th class="fieldnameback fieldname whitespace-no-wrap"><?php echo _('Name') . ", " . _('ID'); ?></th>
                                <th class="fieldnameback fieldname whitespace-no-wrap"><?php echo _('Tree'); ?></th>
                                <th class="fieldnameback fieldname whitespace-no-wrap"><?php echo _('Event(s)'); ?></th>
                            </tr>
                            <?php
                            $oldlinks = 0;
                            if ($result3) {
                                while ($plink = tng_fetch_assoc($result3)) {
                                    $oldlinks++;
                                    if ($plink['personID'] != null) {
                                        $type = _('Person');
                                        $id = " (" . $plink['personID'] . ")";
                                        $rights = determineLivingPrivateRights($plink);
                                    $plink['allow_living'] = $rights['living'];
                                    $plink['allow_private'] = $rights['private'];
                                    $name = getName($plink);
                                } elseif ($plink['familyID'] != NULL) {
                                        $type = _('Family');
                                        $husb['gedcom'] = $plink['gedcom'];
                                    $husb['firstname'] = $plink['hfirstname'];
                                    $husb['lnprefix'] = $plink['hlnprefix'];
                                    $husb['lastname'] = $plink['hlastname'];
                                    $husb['prefix'] = $plink['hprefix'];
                                    $husb['suffix'] = $plink['hsuffix'];
                                    $husb['nameorder'] = $plink['hnameorder'];

                                    $wife['gedcom'] = $plink['gedcom'];
                                    $wife['firstname'] = $plink['wfirstname'];
                                    $wife['lnprefix'] = $plink['wlnprefix'];
                                    $wife['lastname'] = $plink['wlastname'];
                                    $wife['prefix'] = $plink['wprefix'];
                                    $wife['suffix'] = $plink['wsuffix'];
                                    $wife['nameorder'] = $plink['wnameorder'];

                                    $hrights = determineLivingPrivateRights($husb);
                                    $husb['allow_living'] = $hrights['living'];
                                    $husb['allow_private'] = $hrights['private'];
                                    $name = getName($husb);
                                    $wrights = determineLivingPrivateRights($wife);
                                    $wife['allow_living'] = $wrights['living'];
                                    $wife['allow_private'] = $wrights['private'];
                                    $wifename = getName($wife);
                                    if ($wifename) {
                                        if ($name) $name .= ", ";

                                        $name .= $wifename;
                                    }
                                    $id = " (" . $plink['familyID'] . ")";
                                } elseif ($plink['sourceID'] != NULL) {
                                        $type = _('Source');
                                        $id = " (" . $plink['sourceID'] . ")";
                                    $name = substr($plink['title'], 0, 25);
                                } elseif ($plink['repoID'] != NULL) {
                                        $type = _('Repository');
                                        $id = " (" . $plink['repoID'] . ")";
                                    $name = substr($plink['reponame'], 0, 25);
                                } else { //place
                                        $type = _('Place');
                                        $id = "";
                                    $name = $plink['entityID'];
                                }

                                include "eventmicro.php";
                                echo "<tr id=\"alink_{$plink['alinkID']}\"><td class='text-center lightback'>\n";
                                if ($type != "place") {
                                    echo "<a href='#' title=\"" . _('Edit') . "\" onclick=\"return editMedia2EntityLink({$plink['alinkID']});\" title=\"" . _('Edit') . "\" class='smallicon admin-edit-icon'></a>";
                                }
                                    echo "<a href='#' title=\"" . _('Remove Link') . "\" onclick=\"return deleteMedia2EntityLink({$plink['alinkID']});\" title=\"" . _('Remove Link') . "\" class='smallicon admin-delete-icon'></a>\n";
                                    echo "</td>\n";
                                echo "<td class='lightback normal'>" . $type . "</td>\n";
                                echo "<td class='lightback normal'>$name$id&nbsp;</td>\n";
                                    echo "<td class='lightback normal'>{$plink['treename']}</td>\n";
                                    echo "<td class='lightback normal' id=\"event_{$plink['alinkID']}\">$eventstr&nbsp;</td>\n";
                                    echo "</tr>\n";
                                }
                                tng_free_result($result3);
                            }
                            ?>
                            </tbody>
                        </table>
                        <div id="nolinks" class="normal" style="margin-left:3px;">
                            <?php if (!$oldlinks) echo _('No links exist yet'); ?>
                        </div>
                    </div>
                </td>
            </tr>

            <tr class="databack">
                <td class="tngshadow">
                    <p class="normal">
                        <?php
                        echo _('On save') . ":<br>";
                        echo "<input type='radio' name='newscreen' value='return'> " . _('Return to this page') . "<br>\n";
                        if ($cw) {
                            echo "<input type='radio' name='newscreen' value=\"close\" checked> " . _('Close this window') . "\n";
                        } else {
                            echo "<input type='radio' name='newscreen' value=\"none\" checked> " . _('Return to menu') . "\n";
                        }
                        ?>
                    </p>

                    <input type="hidden" value="<?php echo "$cw"; ?>" name="cw">
                    <input type="hidden" name="albumID" value="<?php echo "$albumID"; ?>">
                    <input type="submit" name="submit" accesskey="s" class="btn" value="<?php echo _('Save'); ?>">
                </td>
            </tr>
        </table>
    </form>

    <script>
        var findform = document.form1;
    </script>

<?php echo tng_adminfooter(); ?>