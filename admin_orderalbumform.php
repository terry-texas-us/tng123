<?php
include "begin.php";
include "adminlib.php";
$textpart = "photos";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
if (!$allow_edit) {
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

$flags['tabs'] = $tngconfig['tabs'];
tng_adminheader($admtext['sortmedia'], $flags);
?>
<script src="js/mediafind.js"></script>
<script src="js/selectutils.js"></script>
<script>
    var tnglitbox;
    var findopen;
    var album = '';
    var type = "album";
    var formname = "find";
    // TODO text ['reshere'] was not defined in any language. Manually added here.
    var resheremsg = '<span class="normal">' + "<?php echo _todo_('reshere'); ?>" + '</span>';
    ;

    function validateSortForm() {
        let rval = true;

        if (document.find.newlink1.value.length == 0) {
            alert("<?php echo $admtext['enterid']; ?>");
            rval = false;
        }
        return rval;
    }

    function getTree(treeobj) {
        if (treeobj.options.length)
            return treeobj.options['treeobj.selectedIndex'].value;
        else {
            alert("<?php echo $admtext['selecttree']; ?>");
            return false;
        }
    }

    var gsControlName = "";
</script>

<?php
echo "</head>\n";
echo tng_adminlayout();

$albumtabs[0] = [1, "admin_albums.php", $admtext['search'], "findalbum"];
$albumtabs[1] = [$allow_add, "admin_newalbum.php", $admtext['addnew'], "addalbum"];
$albumtabs[2] = [$allow_edit, "admin_orderalbumform.php", $admtext['text_sort'], "sortalbums"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/albums_help.php#sort');\" class='lightlink'>{$admtext['help']}</a>";
$menu = doMenu($albumtabs, "sortalbums", $innermenu);
echo displayHeadline($admtext['albums'] . " &gt;&gt; " . $admtext['text_sort'], "img/albums_icon.gif", $menu, $message);
?>

<table class="lightback">
    <tr class="databack">
        <td class="tngshadow">
            <form action="admin_orderalbums.php" method="post" name="find" onsubmit="return validateSortForm();">
                <h3 class="subhead"><?php echo $admtext['sortalbumind']; ?></h3>
                <table cellspacing="2">
                    <tr>
                        <td class="normal"><?php echo $admtext['tree']; ?></td>
                        <td class="normal"><?php echo $admtext['linktype']; ?></td>
                        <td class="normal" colspan="3"><?php echo $admtext['id']; ?></td>
                    </tr>
                    <tr>
                        <td>
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
                        <td>
                            <select name="linktype1">
                                <option value="I"><?php echo $admtext['person']; ?></option>
                                <option value="F"><?php echo $admtext['family']; ?></option>
                                <option value="S"><?php echo $admtext['source']; ?></option>
                                <option value="R"><?php echo $admtext['repository']; ?></option>
                                <option value="L"><?php echo $admtext['place']; ?></option>
                            </select>
                        </td>
                        <td>
                            <input type="text" name="newlink1" id="newlink1" value="<?php echo $personID; ?>">
                        </td>
                        <td class="normal">
                            <input type="submit" value="<?php echo $admtext['text_continue']; ?>"> &nbsp;<?php echo $admtext['text_or']; ?>&nbsp;
                        </td>
                        <td><a href="#"
                                onclick="return findItem(document.find.linktype1.options[document.find.linktype1.selectedIndex].value,'newlink1',null,document.find.tree1.options[document.find.tree1.selectedIndex].value,'<?php echo $assignedbranch; ?>');"
                                title="<?php echo $admtext['find']; ?>" class="smallicon admin-find-icon"></a>
                        </td>
                    </tr>
                </table>

            </form>

        </td>
    </tr>

</table>
<?php echo tng_adminfooter(); ?>