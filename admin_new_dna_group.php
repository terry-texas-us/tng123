<?php
include "begin.php";
include "adminlib.php";
$textpart = "dna";
include "getlang.php";
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
}
$orgtree = $tree;
$treequery = "SELECT gedcom, treename FROM $trees_table $wherestr ORDER BY treename";

$helplang = findhelp("dna_help.php");

tng_adminheader(_('Add Group'), $flags);
?>
    <script src="js/selectutils.js"></script>
    <script>
        function validateForm() {
            let rval = true;
            document.form1.dna_group.value = document.form1.dna_group.value.replace(/[^a-zA-Z0-9-_]+/g, "");
            if (document.form1.dna_group.value.length == 0) {
                alert("<?php echo _('Please enter a group ID'); ?>");
                rval = false;
            } else if (document.form1.description.value.length == 0) {
                alert("<?php echo _('Please enter a group description'); ?>");
                rval = false;
            } else if (document.form1.test_type.selectedIndex == 0) {
                alert("<?php echo _('Please select a test type.'); ?>");
                rval = false;
            }
            return rval;
        }

        var tree = "";
    </script>

<?php
echo "</head>\n";
echo tng_adminlayout();

$dnatabs[0] = [1, "admin_dna_groups.php", _('Search'), "findtest"];
$dnatabs[1] = [$allow_add, "admin_new_dna_group.php", _('Add Group'), "addgroup"];
$dnatabs[2] = [1, "admin_dna_tests.php", _('DNA Tests'), "findtest"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/dna_help.php#add');\" class='lightlink'>" . _('Help for this area') . "</a> ";
$menu = doMenu($dnatabs, "addgroup", $innermenu);
echo displayHeadline(_('DNA Groups') . " &gt;&gt; " . _('Add Group'), "img/dna_icon.gif", $menu, $message);
?>

    <table class="lightback">
        <tr class="databack">
            <td class="tngshadow">
                <form action="admin_add_dna_group.php" method="post" name="form1" onsubmit="return validateForm();">
                    <table class="normal">
                        <tr>
                            <td><?php echo _('Tree'); ?>:</td>
                            <td>
                                <select name="tree" id="tree2">
                                    <?php
                                    $treeresult = tng_query($treequery) or die (_('Cannot execute query') . ": $treequery");
                                    while ($treerow = tng_fetch_assoc($treeresult))
                                        echo "	<option value=\"{$treerow['gedcom']}\">{$treerow['treename']}</option>\n";
                                    tng_free_result($treeresult);
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class='align-top'><?php echo _('Group ID'); ?>:</td>
                            <td>
                                <input type="text" name="dna_group" size="20" maxlength="20">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Test Type'); ?>:</td>
                            <td>
                                <select name="test_type">
                                    <option value=""></option>
                                    <option value="atDNA"><?php echo _('atDNA (autosomal) Tests'); ?></option>
                                    <option value="Y-DNA"><?php echo _('Y-DNA Tests'); ?></option>
                                    <option value="mtDNA"><?php echo _('mtDNA (Mitochondrial) Tests'); ?></option>
                                    <option value="X-DNA"><?php echo _('X-DNA'); ?></option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class='align-top'><?php echo _('Description'); ?>:</td>
                            <td>
                                <input type="text" name="description" size="60">
                            </td>
                        </tr>

                    </table>
                    <br>
                    <input type="submit" name="submit" class="btn" value="<?php echo _('Save'); ?>">
                </form>
            </td>
        </tr>

    </table>
<?php echo tng_adminfooter(); ?>