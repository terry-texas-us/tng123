<?php
include "begin.php";
include "config/importconfig.php";
include "adminlib.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
if (!$allow_ged && $assignedtree) {
    $query = "SELECT disallowgedcreate FROM $trees_table WHERE gedcom = '$assignedtree'";
    $result = tng_query($query);
    $row = tng_fetch_assoc($result);
    $disallowgedcreate = $row['disallowgedcreate'];
    tng_free_result($result);

    if ($disallowgedcreate) {
        $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
        header("Location: admin_login.php?message=" . urlencode($message));
        exit;
    }
} else {
    $row = [];
    $row['gedcom'] = $row['branch'] = "";
}

if ($assignedtree) {
    $wherestr = "WHERE gedcom = '$assignedtree'";
} else {
    $wherestr = "";
}
$treequery = "SELECT gedcom, treename FROM $trees_table $wherestr ORDER BY treename";

$query = "SELECT branch, gedcom, description FROM $branches_table WHERE gedcom = \"{$row['gedcom']}\" ORDER BY description";
$branchresult = tng_query($query);

$helplang = findhelp("data_help.php");

tng_adminheader(_('GEDCOM Export'), $flags);
?>
<script>
    <?php
    include "branchlibjs.php";
    ?>

    function toggleStuff() {
        if (document.form1.exportmedia.checked == true)
            jQuery('#exprows').slideDown(400);
        else
            jQuery('#exprows').slideUp(400);
    }
</script>

<?php
echo "</head>\n";
echo tng_adminlayout();

$datatabs[0] = [1, "admin_dataimport.php", _('Import'), "import"];
$datatabs[1] = [$allow_ged, "admin_export.php", _('Export'), "export"];
$datatabs[2] = [1, "admin_secondmenu.php", _('Secondary Processes'), "second"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/data_help.php#export');\" class='lightlink'>" . _('Help for this area') . "</a>";
$menu = doMenu($datatabs, "export", $innermenu);
echo displayHeadline(_('Import/Export') . " &gt;&gt; " . _('GEDCOM Export'), "img/data_icon.gif", $menu, $message);
?>

<table class="lightback normal w-full" cellpadding="10" cellspacing="2">
    <tr class="databack">
        <td class="tngshadow">
            <form action="admin_gedcom2.php" method="post" name="form1">
                <table class="normal">
                    <tr>
                        <td><?php echo _('Tree'); ?>:</td>
                        <td>
                            <select name="tree" id="treeselect" onchange="swapBranches(document.form1);">
                                <?php
                                $treeresult = tng_query($treequery) or die (_('Cannot execute query') . ": $treequery");
                                $firsttree = "";
                                while ($treerow = tng_fetch_assoc($treeresult)) {
                                    if (!$firsttree) $firsttree = $treerow['gedcom'];

                                    echo "	<option value=\"{$treerow['gedcom']}\"";
                                    if ($treerow['gedcom'] == $tree) echo " selected";

                                    echo ">{$treerow['treename']}</option>\n";
                                }
                                tng_free_result($treeresult);
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo _('Branch'); ?>:</td>
                        <td>
                            <?php
                            $query = "SELECT branch, gedcom, description FROM $branches_table WHERE gedcom = \"$firsttree\" ORDER BY description";
                            $branchresult = tng_query($query);

                            echo "<select name='branch' id='branch' size=\"$selectnum\">\n";
                            echo "	<option value=\"\">" . _('All Branches') . "</option>\n";
                            while ($branch = tng_fetch_assoc($branchresult)) {
                                echo "	<option value=\"{$branch['branch']}\"";
                                if ($row['branch'] == $branch['branch']) {
                                    echo " selected";
                                }
                                echo ">{$branch['description']}</option>\n";
                            }
                            echo "</select>\n";
                            ?>
                        </td>
                    </tr>
                </table>

                <br>

                <input type="checkbox" name="exliving" id="exliving" value="1">
                <label for="exliving"><?php echo _('Exclude living'); ?></label> &nbsp;&nbsp;
                <input type="checkbox" name="exprivate" id="exprivate" value="1">
                <label for="exprivate"><?php echo _('Exclude private'); ?></label>
                <br><br>

                <input type="checkbox" name="exportmedia" id="exportmedia" value="1" onClick="toggleStuff();">
                <label for="exportmedia"><?php echo _('Export media links'); ?></label>

                <br>

                <div style="display:none;" id="exprows">
                    <table class="normal" cellspacing="10">
                        <tr>
                            <td><?php echo _('Select'); ?></td>
                            <td><?php echo _('Media Types'); ?></td>
                            <td><?php echo _('Local path'); ?>:</td>
                        </tr>
                        <?php
                        foreach ($mediatypes as $mediatype) {
                            $msgID = $mediatype['ID'];
                            switch ($msgID) {
                                case "photos":
                                    $value = strtok($locimppath['photos'], ",");
                                    break;
                                case "histories":
                                    $value = strtok($locimppath['histories'], ",");
                                    break;
                                case "documents":
                                    $value = strtok($locimppath['documents'], ",");
                                    break;
                                case "headstones":
                                    $value = strtok($locimppath['headstones'], ",");
                                    break;
                                default:
                                    if (isset($locimppath[$msgID])) {
                                        $value = strtok($locimppath[$msgID], ",");
                                    } else {
                                        $value = strtok($locimppath['other'], ",");
                                    }
                                    break;
                            }
                            echo "<tr>";
                            echo "<td><input type='checkbox' name=\"incl_$msgID\" value='1' checked></td>\n";
                            echo "<td>" . $mediatype['display'] . ":</td>\n";
                            echo "<td><input type='text' value='$value' name=\"exp_path_$msgID\" class=\"verylongfield\"></td>";
                            echo "</tr>\n";
                        }
                        ?>
                    </table>
                </div>
                <br>
                <input type="submit" name="submit" class="btn" value="<?php echo _('Export'); ?>">
            </form>
        </td>
    </tr>

</table>
<?php echo tng_adminfooter(); ?>
