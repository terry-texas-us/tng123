<?php
include "begin.php";
include "adminlib.php";
$textpart = "photos";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
if (!$allow_media_edit && (!$allow_media_add || !$added)) {
    $message = $admtext['norights'];
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

$query2 = "SELECT albumlinkID, thumbpath, $media_table.mediaID as mediaID, usecollfolder, mediatypeID, notes, description, datetaken, placetaken, defphoto, $media_table.gedcom FROM ($media_table, $albumlinks_table)
	WHERE albumID = \"$albumID\" AND $media_table.mediaID = $albumlinks_table.mediaID order by ordernum, description";
$result2 = tng_query($query2) or die ($admtext['cannotexecutequery'] . ": $query2");
$numrows = tng_num_rows($result2);

$query3 = "SELECT alinkID, entityID, eventID, people.lastname as lastname, people.lnprefix as lnprefix, people.firstname as firstname, people.suffix as suffix, people.nameorder as nameorder, ate.gedcom, treename, familyID, people.personID as personID, wifepeople.personID as wpersonID, wifepeople.firstname as wfirstname, wifepeople.lnprefix as wlnprefix, wifepeople.lastname as wlastname, wifepeople.prefix as wprefix, wifepeople.suffix as wsuffix, wifepeople.nameorder as wnameorder, husbpeople.personID as hpersonID, husbpeople.firstname as hfirstname, husbpeople.lnprefix as hlnprefix, husbpeople.lastname as hlastname, husbpeople.prefix as hprefix, husbpeople.suffix as hsuffix, husbpeople.nameorder as hnameorder, sourceID, sources.title, repositories.repoID as repoID, reponame, linktype ";
$query3 .= "FROM ($album2entities_table as ate, $trees_table trees) ";
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
$result3 = tng_query($query3) or die ($admtext['cannotexecutequery'] . ": $query3");
$numlinks = tng_num_rows($result3);

if (!$thumbmaxw) {
    $thumbmaxw = 50;
}

if ($assignedtree) {
    $wherestr = "WHERE gedcom = \"$assignedtree\"";
    $tree = $assignedtree;
} else {
    $wherestr = "";
}
$treequery = "SELECT gedcom, treename FROM $trees_table $wherestr ORDER BY treename";

$helplang = findhelp("albums_help.php");

$flags['tabs'] = $tngconfig['tabs'];
tng_adminheader($admtext['modifyalbum'], $flags);

$photo = "";

$query = "SELECT alwayson, thumbpath, $media_table.mediaID as mediaID, usecollfolder, mediatypeID, albumlinkID, $media_table.gedcom FROM ($media_table, $albumlinks_table)
	WHERE albumID = \"$albumID\" AND $media_table.mediaID = $albumlinks_table.mediaID AND defphoto = '1'";
$defresult = tng_query($query);
if ($defresult) {
    $drow = tng_fetch_assoc($defresult);
}
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
<script type="text/javascript" src="js/mediafind.js"></script>
<script type="text/javascript" src="js/mediautils.js"></script>
<script type="text/javascript" src="js/selectutils.js"></script>
<script type="text/javascript">
    <!--
    var tnglitbox;
    var album = "<?php echo $albumID; ?>";
    var entity = "";
    var tree = "";
    var type = "album";
    var thumbmaxw = parseInt("<?php echo $thumbmaxw; ?>");
    var dragmsg = "<?php echo $admtext['drag']; ?>";
    var remove_text = "<?php echo $admtext['remove']; ?>";
    var edit_text = "<?php echo $admtext['edit']; ?>";
    var mediacount = <?php echo $numrows; ?>;
    var linkcount = <?php echo $numlinks; ?>;
    var selectmsg = "<?php echo $admtext['selecttree']; ?>";
    var linkmsg = "<?php echo $admtext['enterid']; ?>";
    var duplinkmsg = "<?php echo $admtext['duplinkmsg']; ?>";
    var invlinkmsg = "<?php echo $admtext['invlinkmsg']; ?>";
    var mkdefaultmsg = "<?php echo $admtext['makedefault']; ?>";
    var searchmsg = "<?php echo $admtext['entersearchvalue']; ?>";
    var sortmsg = "<?php echo $admtext['text_sort']; ?>";
    var confdellink = "<?php echo $admtext['confdellink']; ?>";
    var confremmedia = "<?php echo $admtext['confremmedia']; ?>";
    var movetopmsg = "<?php echo $admtext['movetop']; ?>";
    var topmsg = "<?php echo $text['top']; ?>";
    var gomsg = "<?php echo $admtext['go']; ?>";
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
<script src="js/admin.js"></script>
</head>

<body background="img/background.gif" onload="startMediaSort()">

<?php
$albumtabs[0] = array(1, "admin_albums.php", $admtext['search'], "findalbum");
$albumtabs[1] = array($allow_add, "admin_newalbum.php", $admtext['addnew'], "addalbum");
$albumtabs[2] = array($allow_edit, "admin_orderalbumform.php", $admtext['text_sort'], "sortalbums");
$albumtabs[3] = array($allow_edit, "#", $admtext['edit'], "edit");
$innermenu = "<a href=\"#\" onclick=\"return openHelp('$helplang/albums_help.php#edit');\" class=\"lightlink\">{$admtext['help']}</a>";
$innermenu .= " &nbsp;|&nbsp; <a href=\"#\" class=\"lightlink\" onClick=\"return toggleAll('on');\">{$text['expandall']}</a> &nbsp;|&nbsp; <a href=\"#\" class=\"lightlink\" onClick=\"return toggleAll('off');\">{$text['collapseall']}</a>";
$menu = doMenu($albumtabs, "edit", $innermenu);
echo displayHeadline($admtext['albums'] . " &gt;&gt; " . $admtext['modifyalbum'], "img/albums_icon.gif", $menu, "");
?>

<form action="admin_updatealbum.php" method="post" name="form1" id="form1" onSubmit="return validateForm();">
    <table width="100%" cellpadding="10" cellspacing="2" class="lightback">
        <tr class="databack">
            <td class="tngshadow">
                <div>
                    <div id="thumbholder" style="float:left;<?php if (!$photo) {
                        echo "display:none";
                    } ?>"><?php echo $photo; ?></div>
                    <span class="plainheader"><?php echo $row['albumname'] . ": </span><br>" . $row['description']; ?></div>
                <?php
                echo "<a href=\"#\" onclick=\"return removeDefault();\" class=\"smaller\" id=\"removedefault\"";
                if (!$photo) {
                    echo " style=\"visibility:hidden\"";
                }
                echo ">{$admtext['removedef']}</a>\n";
                ?>
            </td>
        </tr>

        <tr class="databack">
            <td class="tngshadow">
                <?php echo displayToggle("plus0", 0, "details", $admtext['existingalbuminfo'], $admtext['infosubt']); ?>

                <div id="details" style="display:none">
                    <br>
                    <table class="normal">
                        <tr>
                            <td><?php echo $admtext['albumname']; ?>:</td>
                            <td><input type="text" name="albumname" size="50" value="<?php echo $row['albumname']; ?>"></td>
                        </tr>
                        <tr>
                            <td valign="top"><?php echo $admtext['description']; ?>:</td>
                            <td><textarea cols="60" rows="3" name="description"><?php echo $row['description']; ?></textarea></td>
                        </tr>
                        <tr>
                            <td valign="top"><?php echo $admtext['keywords']; ?>:</td>
                            <td><textarea cols="60" rows="3" name="keywords"><?php echo $row['keywords']; ?></textarea></td>
                        <tr>
                            <td><?php echo $admtext['active']; ?>:</td>
                            <td><input type="radio" name="active" value="1"<?php if ($row['active']) {
                                    echo " checked=\"checked\"";
                                } ?>> <?php echo $admtext['yes']; ?> &nbsp; <input type="radio" name="active" value="0"<?php if (!$row['active']) {
                                    echo " checked=\"checked\"";
                                } ?>> <?php echo $admtext['no']; ?></td>
                        </tr>
                        </tr>
                        <tr>
                            <td valign="top" colspan="2"><input type="checkbox" name="alwayson" value="1"<?php if ($row['alwayson']) {
                                    echo " checked";
                                } ?>> <?php echo $admtext['alwayson']; ?></td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>

        <tr class="databack tngshadow">
            <td class="tngshadow">
                <?php echo displayToggle("plus1", 1, "addmedia", $admtext['albmedia'] . " (<span id=\"mediacount\">$numrows</span>)", $admtext['mediasubt']); ?>

                <div id="addmedia">
                    <p class="normal" style="padding-top:12px">
                        <input type="button" value="<?php echo $admtext['addmedia']; ?>"
                               onclick="return openAlbumMediaFind();"> <?php echo $admtext['selmedia'] . " (<a href=\"admin_newmedia.php\" target=\"_blank\">" . $admtext['uploadfirst'] . "</a>)"; ?>
                    </p>

                    <p class="normal">&nbsp;<strong><?php echo $admtext['inclmedia']; ?>:</strong> <?php echo $admtext['emoptions']; ?></p>
                    <table id="ordertbl" width="100%" cellpadding="3" cellspacing="1" class="fieldname normal">
                        <tr>
                            <th class="fieldnameback" style="width:102px"><?php echo $admtext['text_sort']; ?></th>
                            <th class="fieldnameback" style="width:<?php echo($thumbmaxw + 10); ?>px"><?php echo $admtext['thumb']; ?></th>
                            <th class="fieldnameback"><?php echo $admtext['description']; ?></th>
                            <th class="fieldnameback" style="width:154px"><?php echo $admtext['date']; ?></th>
                            <th class="fieldnameback" style="width:105px"><?php echo $admtext['mediatype']; ?></th>
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
                            echo "<div class=\"sortrow\" id=\"orderdivs_{$lrow['albumlinkID']}\" style=\"clear:both;position:relative\" onmouseover=\"jQuery('#del_{$lrow['albumlinkID']}').css('visibility','visible');\" onmouseout=\"jQuery('#del_{$lrow['albumlinkID']}').css('visibility','hidden');\">";
                            echo "<table width=\"100%\" cellpadding=\"5\" cellspacing=\"1\"><tr>\n";
                            echo "<td class=\"dragarea normal\">";
                            echo "<img src=\"img/admArrowUp.gif\" alt=\"\"><br>" . $admtext['drag'] . "<br><img src=\"img/admArrowDown.gif\" alt=\"\">\n";
                            echo "</td>\n";

                            echo "<td class=\"lightback smaller\" style=\"width:35px;text-align:center\">";
                            echo "<div style=\"padding-bottom:5px\"><a href=\"#\" onclick=\"return moveItemInList('{$lrow['albumlinkID']}',1);\" title=\"{$admtext['movetop']}\"><img src=\"img/admArrowUp.gif\" alt=\"\"><br>Top</a></div>\n";
                            echo "<input style=\"width:30px\" class=\"movefields\" name=\"move{$lrow['albumlinkID']}\" id=\"move{$lrow['albumlinkID']}\" value=\"$count\" onkeypress=\"return handleMediaEnter('{$lrow['albumlinkID']}',jQuery('#move{$lrow['albumlinkID']}').val(),event);\">\n";
                            echo "<a href=\"#\" onclick=\"return moveItemInList('{$lrow['albumlinkID']}',jQuery('#move{$lrow['albumlinkID']}').val());\" title=\"{$admtext['movetop']}\">Go</a>\n";
                            echo "</td>\n";

                            echo "<td class=\"lightback\" style=\"width:" . ($thumbmaxw + 6) . "px;text-align:center;\">";
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
                            echo "<td class=\"lightback normal\"><a href=\"admin_editmedia.php?mediaID={$lrow['mediaID']}\">{$lrow['description']}</a><br>" . strip_tags($truncated) . "<br>";
                            echo "<div id=\"del_{$lrow['albumlinkID']}\" class=\"smaller\" style=\"color:gray;visibility:hidden\">";
                            if ($foundthumb) {
                                echo "<input type=\"radio\" name=\"rthumbs\" value=\"r{$lrow['mediaID']}\"$checked onclick=\"makeDefault(this);\">" . $admtext['makedefault'];
                                echo " &nbsp;|&nbsp; ";
                            }
                            echo "<a href=\"#\" onclick=\"return removeFromAlbum('{$lrow['mediaID']}','{$lrow['albumlinkID']}');\">{$admtext['remove']}</a>";
                            echo "</div></td>\n";
                            echo "<td class=\"lightback normal\" style=\"width:150px;\" valign=\"top\">{$lrow['datetaken']}&nbsp;</td>\n";
                            echo "<td class=\"lightback normal\" style=\"width:100px;\" valign=\"top\">" . $label . "&nbsp;</td>\n";
                            echo "</tr></table>";
                            echo "</div>\n";
                            $count++;
                        }
                        $numrows = tng_num_rows($result2);
                        tng_free_result($result2);
                        ?>
                    </div>
                    <div id="nomedia" class="normal" style="margin-left:3px">
                        <?php
                        if (!$numrows) {
                            echo $admtext['nomedia'];
                        }
                        ?>
                    </div>
            </td>
        </tr>

        <tr class="databack">
            <td class="tngshadow">
                <?php echo displayToggle("plus2", 1, "albumlinks", $admtext['albumlinks'] . " (<span id=\"linkcount\">$numlinks</span>)", $admtext['linkssubt']); ?>

                <div id="albumlinks">
                    <table cellspacing="2" style="padding-top:12px">
                        <tr>
                            <td class="normal"><?php echo $admtext['tree']; ?></td>
                            <td class="normal"><?php echo $admtext['linktype']; ?></td>
                            <td class="normal" colspan="2"><?php echo $admtext['id']; ?></td>
                        </tr>
                        <tr>
                            <td>
                                <select name="tree1">
                                    <?php
                                    $firsttree = isset($_COOKIE['tng_tree']) ? $_COOKIE['tng_tree'] : "";
                                    $treeresult = tng_query($treequery) or die ($admtext['cannotexecutequery'] . ": $treequery");
                                    while ($treerow = tng_fetch_assoc($treeresult)) {
                                        echo "		<option value=\"{$treerow['gedcom']}\"";
                                        if ($firsttree == $treerow['gedcom']) {
                                            echo " selected=\"selected\"";
                                        }
                                        echo ">{$treerow['treename']}</option>\n";
                                    }
                                    tng_free_result($treeresult);
                                    ?>
                                </select>
                            </td>
                            <td>
                                <select name="linktype1">
                                    <option value="I"><?php echo $admtext['person']; ?></option>
                                    <option value="F"><?php echo $admtext['family']; ?></option>
                                    <option value="S"><?php echo $admtext['source']; ?></option>
                                    <option value="R"><?php echo $admtext['repository']; ?></option>
                                    <option value="L"><?php echo $admtext['place']; ?></option>
                                </select>
                            </td>
                            <td><input type="text" name="newlink1" id="newlink1" value="" onkeypress="return newlinkEnter(document.form1,this,event);"></td>
                            <td class="normal"><input type="button" value="<?php echo $admtext['add']; ?>" onclick="return addMedia2EntityLink(document.form1);">
                                &nbsp;<?php echo $admtext['text_or']; ?>&nbsp;
                            </td>
                            <td><a href="#"
                                   onclick="return findItem(findform.linktype1.options[findform.linktype1.selectedIndex].value,'newlink1',null,findform.tree1.options[findform.tree1.selectedIndex].value,'<?php echo $assignedbranch; ?>','a_<?php echo $albumID; ?>');"
                                   title="<?php echo $admtext['find']; ?>" class="smallicon admin-find-icon"></a></td>
                        </tr>
                    </table>
                    <div id="alink_error" style="display:none;" class="normal red"></div>

                    <p class="normal">&nbsp;<strong><?php echo $admtext['existlinks']; ?>:</strong> <?php echo $admtext['eloptions']; ?></p>
                    <table cellpadding="3" cellspacing="1" class="normal">
                        <tbody id="linktable">
                        <tr>
                            <th class="fieldnameback fieldname nw"><?php echo $admtext['action']; ?></th>
                            <th class="fieldnameback fieldname nw"><?php echo $admtext['linktype']; ?></th>
                            <th class="fieldnameback fieldname nw"><?php echo $admtext['name'] . ", " . $admtext['id']; ?></th>
                            <th class="fieldnameback fieldname nw"><?php echo $admtext['tree']; ?></th>
                            <th class="fieldnameback fieldname nw"><?php echo $admtext['event']; ?></th>
                        </tr>
                        <?php
                        $oldlinks = 0;
                        if ($result3) {
                            while ($plink = tng_fetch_assoc($result3)) {
                                $oldlinks++;
                                if ($plink['personID'] != NULL) {
                                    $type = $admtext['person'];
                                    $id = " (" . $plink['personID'] . ")";
                                    $rights = determineLivingPrivateRights($plink);
                                    $plink['allow_living'] = $rights['living'];
                                    $plink['allow_private'] = $rights['private'];
                                    $name = getName($plink);
                                } elseif ($plink['familyID'] != NULL) {
                                    $type = $admtext['family'];
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
                                        if ($name) {
                                            $name .= ", ";
                                        }
                                        $name .= $wifename;
                                    }
                                    $id = " (" . $plink['familyID'] . ")";
                                } elseif ($plink['sourceID'] != NULL) {
                                    $type = $admtext['source'];
                                    $id = " (" . $plink['sourceID'] . ")";
                                    $name = substr($plink['title'], 0, 25);
                                } elseif ($plink['repoID'] != NULL) {
                                    $type = $admtext['repository'];
                                    $id = " (" . $plink['repoID'] . ")";
                                    $name = substr($plink['reponame'], 0, 25);
                                } else { //place
                                    $type = $admtext['place'];
                                    $id = "";
                                    $name = $plink['entityID'];
                                }

                                include "eventmicro.php";

                                echo "<tr id=\"alink_{$plink['alinkID']}\"><td class=\"lightback\" align=\"center\">\n";
                                if ($type != "place") {
                                    echo "<a href=\"#\" title=\"{$admtext['edit']}\" onclick=\"return editMedia2EntityLink({$plink['alinkID']});\" title=\"{$admtext['edit']}\" class=\"smallicon admin-edit-icon\"></a>";
                                }
                                echo "<a href=\"#\" title=\"{$admtext['removelink']}\" onclick=\"return deleteMedia2EntityLink({$plink['alinkID']});\" title=\"{$admtext['removelink']}\" class=\"smallicon admin-delete-icon\"></a>\n";
                                echo "</td>\n";
                                echo "<td class=\"lightback  normal\">" . $type . "</td>\n";
                                echo "<td class=\"lightback  normal\">$name$id&nbsp;</td>\n";
                                echo "<td class=\"lightback  normal\">{$plink['treename']}</td>\n";
                                echo "<td class=\"lightback normal\" id=\"event_{$plink['alinkID']}\">$eventstr&nbsp;</td>\n";
                                echo "</tr>\n";
                            }
                            tng_free_result($result3);
                        }
                        ?>
                        </tbody>
                    </table>
                    <div id="nolinks" class="normal" style="margin-left:3px">
                        <?php
                        if (!$oldlinks) {
                            echo $admtext['nolinks'];
                        }
                        ?>
                    </div>
                </div>
            </td>
        </tr>

        <tr class="databack">
            <td class="tngshadow">
                <p class="normal">
                    <?php
                    echo $admtext['onsave'] . ":<br>";
                    echo "<input type=\"radio\" name=\"newscreen\" value=\"return\"> {$admtext['savereturn']}<br>\n";
                    if ($cw) {
                        echo "<input type=\"radio\" name=\"newscreen\" value=\"close\" checked=\"checked\"> {$text['closewindow']}\n";
                    } else {
                        echo "<input type=\"radio\" name=\"newscreen\" value=\"none\" checked=\"checked\"> {$admtext['saveback']}\n";
                    }
                    ?>
                </p>

                <input type="hidden" value="<?php echo "$cw"; /*stands for "close window" */ ?>" name="cw">
                <input type="hidden" name="albumID" value="<?php echo "$albumID"; ?>">
                <input type="submit" name="submit" accesskey="s" class="btn" value="<?php echo $admtext['save']; ?>">
            </td>
        </tr>
    </table>
</form>

<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
<script type="text/javascript">
    var findform = document.form1;
</script>
</body>
</html>