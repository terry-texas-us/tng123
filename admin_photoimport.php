<?php
include "begin.php";
include "adminlib.php";
$textpart = "photos";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
if (!$allow_media_add || $assignedtree) {
    $message = $admtext['norights'];
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

if ($assignedtree) {
    $wherestr = "WHERE gedcom = '$assignedtree'";
} else {
    $wherestr = "";
}
$treequery = "SELECT gedcom, treename FROM $trees_table $wherestr ORDER BY treename";

$helplang = findhelp("data_help.php");

$flags['tabs'] = $tngconfig['tabs'];
// TODO text ['phimport'] was not defined in any language. Manually added here.
tng_adminheader(_todo_('Photo Import'), $flags);

$standardtypes = [];
$moptions = "";
$likearray = "var like = new Array();\n";
foreach ($mediatypes as $mediatype) {
    if (!$mediatype['type']) {
        $standardtypes[] = "\"" . $mediatype['ID'] . "\"";
    }
    $msgID = $mediatype['ID'];
    $moptions .= "	<option value=\"$msgID\"";
    if ($msgID == $mediatypeID) {
        $moptions .= " selected";
    }
    $moptions .= ">" . $mediatype['display'] . "</option>\n";
    $likearray .= "like['$msgID'] = '{$mediatype['liketype']}';\n";
}
$sttypestr = implode(",", $standardtypes);

echo "</head>\n";
echo tng_adminlayout();

$mediatabs[0] = [1, "admin_media.php", $admtext['search'], "findmedia"];
$mediatabs[1] = [$allow_media_add, "admin_newmedia.php", $admtext['addnew'], "addmedia"];
$mediatabs[2] = [$allow_media_edit, "admin_ordermediaform.php", $admtext['text_sort'], "sortmedia"];
$mediatabs[3] = [$allow_media_edit && !$assignedtree, "admin_thumbnails.php", $admtext['thumbnails'], "thumbs"];
$mediatabs[4] = [!$assignedtree, "admin_photoimport.php", $admtext['import'], "import"];
$mediatabs[5] = [!$assignedtree, "admin_mediaupload.php", $admtext['upload'], "upload"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/media_help.php#import');\" class='lightlink'>{$admtext['help']}</a>";
$menu = doMenu($mediatabs, "import", $innermenu);
echo displayHeadline($admtext['media'] . " &gt;&gt; " . $admtext['import'], "img/photos_icon.gif", $menu, $message);
?>

<table class="lightback">
    <tr class="databack">
        <td class="tngshadow">
            <form action="admin_photoimporter.php" method="post" name="form1">
                <table>
                    <tr>
                        <td><span class="normal"><?php echo $admtext['mediatype']; ?>:</span></td>
                        <td>
                            <select name="mediatypeID" onChange="switchOnType(this.options[this.selectedIndex].value)">
                                <?php
                                foreach ($mediatypes as $mediatype) {
                                    $msgID = $mediatype['ID'];
                                    echo "	<option value=\"$msgID\">" . $mediatype['display'] . "</option>\n";
                                }
                                ?>
                            </select>
                            <?php if (!$assignedtree && $allow_add && $allow_edit && $allow_delete) { ?>
                                <input type="button" name="addnewmediatype" value="<?php echo $admtext['addnewcoll']; ?>" class="align-top"
                                    onclick="tnglitbox = new LITBox('admin_newcollection.php?field=mediatypeID', {width:600, height:340});">
                                <input type="button" name="editmediatype" id="editmediatype" value="<?php echo $admtext['edit']; ?>" style="vertical-align:top;display:none;"
                                    onclick="editMediatype(document.form1.mediatypeID);">
                                <input type="button" name="delmediatype" id="delmediatype" value="<?php echo $admtext['text_delete']; ?>" style="vertical-align:top;display:none;"
                                    onclick="confirmDeleteMediatype(document.form1.mediatypeID);">
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="normal"><?php echo $admtext['tree']; ?>*: </span></td>
                        <td>
                            <select name="tree">
                                <option value=""></option>
                                <?php
                                $treeresult = tng_query($treequery) or die ($admtext['cannotexecutequery'] . ": $treequery");
                                while ($treerow = tng_fetch_assoc($treeresult)) {
                                    echo "	<option value=\"{$treerow['gedcom']}\"";
                                    if ($treerow['gedcom'] == $tree) {
                                        echo " selected";
                                    }
                                    echo ">{$treerow['treename']}</option>\n";
                                }
                                tng_free_result($treeresult);
                                ?>
                            </select>
                        </td>
                    </tr>
                </table>
                <p class="normal">*<?php echo $admtext['phalltrees']; ?></p>
                <input type="submit" name="submit" class="btn" value="<?php echo $admtext['import']; ?>">
            </form>
        </td>
    </tr>

</table>
<script src="js/mediautils.js"></script>
<script>
    var tree = "<?php echo $tree; ?>";
    var tnglitbox;
    const entercollid = "<?php echo $admtext['entercollid']; ?>";
    const entercolldisplay = "<?php echo $admtext['entercolldisplay']; ?>";
    const entercollipath = "<?php echo $admtext['entercollpath']; ?>";
    const entercollicon = "<?php echo $admtext['entercollicon']; ?>";
    const confmtdelete = "<?php echo $admtext['confmtdelete']; ?>";
    var stmediatypes = new Array(<?php echo $sttypestr; ?>);
    var allow_edit = <?php echo($allow_edit ? "1" : "0"); ?>;
    var allow_delete = <?php echo($allow_delete ? "1" : "0"); ?>;
    var manage = 1;
    <?php echo $likearray; ?>
</script>

<?php echo tng_adminfooter(); ?>