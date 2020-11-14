<?php
include "begin.php";
include "adminlib.php";
$textpart = "branches";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
if (!$allow_add) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

if ($assignedtree) {
    $wherestr = "WHERE gedcom = '$assignedtree'";
    $tree = $assignedtree;
} else {
    $wherestr = "";
    $tree = isset($_COOKIE['tng_tree']) ? $_COOKIE['tng_tree'] : "";
}
$orgtree = $tree;
$treequery = "SELECT gedcom, treename FROM $trees_table $wherestr ORDER BY treename";

$helplang = findhelp("branches_help.php");

tng_adminheader(_('Add New Branch'), $flags);
?>
    <script src="js/selectutils.js"></script>
    <script>
        function validateForm() {
            let rval = true;
            document.form1.branch.value = document.form1.branch.value.replace(/[^a-zA-Z0-9-_]+/g, "");
            if (document.form1.branch.value.length == 0) {
                alert("<?php echo _('Please enter a branch ID.'); ?>");
                rval = false;
            } else if (document.form1.description.value.length == 0) {
                alert("<?php echo _('Please enter a branch description.'); ?>");
                rval = false;
            }
            return rval;
        }

        var tree = "";
    </script>

<?php
echo "</head>\n";
echo tng_adminlayout();

$branchtabs[0] = [1, "admin_branches.php", _('Search'), "findbranch"];
$branchtabs[1] = [$allow_add, "admin_newbranch.php", _('Add New'), "addbranch"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/branches_help.php#add');\" class='lightlink'>" . _('Help for this area') . "</a>";
$menu = doMenu($branchtabs, "addbranch", $innermenu);
echo displayHeadline(_('Branches') . " &gt;&gt; " . _('Add New Branch'), "img/branches_icon.gif", $menu, $message);
?>

    <table class="lightback">
        <tr class="databack">
            <td class="tngshadow">
                <form action="admin_addbranch.php" method="post" name="form1" onsubmit="return validateForm();">
                    <table class="normal">
                        <tr>
                            <td><?php echo _('Tree'); ?>:</td>
                            <td>
                                <select name="tree" id="tree1">
                                    <?php
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
                        </tr>
                        <tr>
                            <td class='align-top'><?php echo _('Branch ID'); ?>:</td>
                            <td>
                                <input type="text" name="branch" size="20" maxlength="20">
                            </td>
                        </tr>
                        <tr>
                            <td class='align-top'><?php echo _('Description'); ?>:</td>
                            <td>
                                <input type="text" name="description" size="60">
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <div id="startind1"><br><strong><?php echo _('Starting Individual'); ?>:</strong></div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div id="startind2">&nbsp;&nbsp;<?php echo _('Person ID'); ?>:</div>
                            </td>
                            <td>
                                <table id="startind3" class="normal">
                                    <tr>
                                        <td>
                                            <input type="text" name="personID" id="personID" size="10"> &nbsp;<?php echo _('OR'); ?>&nbsp;
                                        </td>
                                        <td><a href="#" onclick="return findItem('I','personID','',getTree(document.getElementById('tree1')),'<?php echo $assignedbranch; ?>');" title="<?php echo _('Find...'); ?>" class="smallicon admin-find-icon"></a></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div id="numgens1"><br><strong><?php echo _('Number of Generations'); ?>:</strong></div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div id="numgens2">&nbsp;&nbsp;<?php echo _('Ancestors'); ?>:</div>
                            </td>
                            <td>
                                <div id="numgens3">
                                    <input type="text" name="agens" size="3" maxlength="3" value="0"> &nbsp;&nbsp; <?php echo _('Descendant generations from each ancestor'); ?>:
                                    <select name="dagens">
                                        <option value="0">0</option>
                                        <option value="1" selected>1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div id="numgens4">&nbsp;&nbsp;<?php echo _('Descendants'); ?>:</div>
                            </td>
                            <td>
                                <div id="numgens5">
                                    <input type="text" name="dgens" size="3" maxlength="3" value="0"> &nbsp;&nbsp;
                                    <input type="checkbox" name="dospouses" checked="checked" value="1"> <?php echo _('Include spouses for all descendants'); ?></div>
                            </td>
                        </tr>
                    </table>
                    <br>
                    <input type="submit" name="submit" accesskey="s" class="btn" value="<?php echo _('Save'); ?>">
                    <input type="submit" name="submitx" class="btn" value="<?php echo _('Save and Exit'); ?>">
                </form>
            </td>
        </tr>

    </table>
<?php echo tng_adminfooter(); ?>