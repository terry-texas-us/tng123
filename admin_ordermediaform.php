<?php
include "begin.php";
include "adminlib.php";
$textpart = "photos";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
if (!$allow_media_edit) {
    $message = $admtext['norights'];
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

if ($assignedtree) {
    $wherestr = "WHERE gedcom = '$assignedtree'";
    $tree = $assignedtree;
} else {
    $wherestr = "";
}
$treequery = "SELECT gedcom, treename FROM $trees_table $wherestr ORDER BY treename";

$helplang = findhelp("media_help.php");

tng_adminheader($admtext['sortmedia'], $flags);
?>
<script src="js/mediafind.js"></script>
<script src="js/selectutils.js"></script>
<script>
    var findopen;
    var album = '';
    var media = '';
    var type = "media";
    //var formname = "find";
    var findform = "find";
    // TODO text ['reshere'] was not defined in any language. Manually added here.
    var resheremsg = '<span class="normal">' + "<?php echo _todo_('reshere'); ?>" + '</span>';

    function validateForm() {
        let rval = true;

        if (document.find.newlink1.value.length == 0) {
            alert("<?php echo $admtext['enterid']; ?>");
            rval = false;
        }
        return rval;
    }

    function getTree(treeobj) {
        if (treeobj.options.length)
            return treeobj.options[treeobj.selectedIndex].value;
        else {
            alert("<?php echo $admtext['selecttree']; ?>");
            return false;
        }
    }
</script>

<?php
echo "</head>\n";
echo tng_adminlayout();

$mediatabs[0] = [1, "admin_media.php", $admtext['search'], "findmedia"];
$mediatabs[1] = [$allow_media_add, "admin_newmedia.php", $admtext['addnew'], "addmedia"];
$mediatabs[2] = [$allow_media_edit, "admin_ordermediaform.php", $admtext['text_sort'], "sortmedia"];
$mediatabs[3] = [!$assignedtree, "admin_thumbnails.php", $admtext['thumbnails'], "thumbs"];
$mediatabs[4] = [$allow_media_add && !$assignedtree, "admin_photoimport.php", $admtext['import'], "import"];
$mediatabs[5] = [$allow_media_add, "admin_mediaupload.php", $admtext['upload'], "upload"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/media_help.php#sort');\" class='lightlink'>{$admtext['help']}</a>";
$menu = doMenu($mediatabs, "sortmedia", $innermenu);
echo displayHeadline($admtext['media'] . " &gt;&gt; " . $admtext['text_sort'], "img/photos_icon.gif", $menu, $message);
?>

<table class="lightback">
    <tr class="databack">
        <td class="tngshadow">
            <form action="admin_ordermedia.php" method="get" name="find" onsubmit="return validateForm();">
                <h3 class="subhead"><?php echo $admtext['sortmediaind']; ?></h3>
                <table cellspacing="2">
                    <tr>
                        <td class="normal"><?php echo $admtext['tree']; ?></td>
                        <td class="normal"><?php echo $admtext['linktype']; ?></td>
                        <td class="normal"><?php echo $admtext['mediatype']; ?></td>
                        <td class="normal" colspan="3"><?php echo $admtext['id']; ?></td>
                    </tr>
                    <tr>
                        <td class='align-top'>
                            <select name="tree1">
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
                        <td class='align-top'>
                            <select name="linktype1" onchange="toggleEventLink(this.selectedIndex);">
                                <option value="I"><?php echo $admtext['person']; ?></option>
                                <option value="F"><?php echo $admtext['family']; ?></option>
                                <option value="S"><?php echo $admtext['source']; ?></option>
                                <option value="R"><?php echo $admtext['repository']; ?></option>
                                <option value="L"><?php echo $admtext['place']; ?></option>
                            </select>
                        </td>
                        <td class='align-top'>
                            <select name="mediatypeID">
                                <?php
                                foreach ($mediatypes as $mediatype) {
                                    $msgID = $mediatype['ID'];
                                    echo "	<option value=\"$msgID\"";
                                    if ($msgID == $mediatypeID) {
                                        echo " selected";
                                    }
                                    echo ">" . $mediatype['display'] . "</option>\n";
                                }
                                ?>
                            </select>
                        </td>
                        <td>
                            <input type="text" name="newlink1" id="newlink1" value="<?php echo $personID; ?>" onblur="toggleEventRow(document.find.eventlink1.checked);">
                        </td>
                        <td><a href="#"
                               onclick="return findItem(document.find.linktype1.options[document.find.linktype1.selectedIndex].value,'newlink1',null,document.find.tree1.options[document.find.tree1.selectedIndex].value,'<?php echo $assignedbranch; ?>');"
                               title="<?php echo $admtext['find']; ?>" class="smallicon admin-find-icon"></a></td>
                        <td>
                            <input type="submit" value="<?php echo $admtext['text_continue']; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">&nbsp;</td>
                        <td colspan="2">
                            <span id="eventlink1" class="normal"><input type="checkbox" name="eventlink1" value="1" onclick="return toggleEventRow(this.checked);"> <?php echo $admtext['eventlink']; ?></span><br>
                            <select name="event1" id="eventrow1" style="display:none;">
                                <option value=""></option>
                            </select>
                        </td>
                        <td class="normal align-top">&nbsp;</td>
                    </tr>
                </table>

            </form>

        </td>
    </tr>

</table>
<?php echo tng_adminfooter(); ?>
