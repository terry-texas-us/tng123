<?php
include "begin.php";
include "adminlib.php";
require_once "./admin/trees.php";

$textpart = "dna";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
if (!$allow_edit || ($assignedtree && $assignedtree != $tree)) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

$query = "SELECT * FROM $dna_groups_table WHERE gedcom = '$tree' AND dna_group = \"$dna_group\"";
$result = tng_query($query);
$row = tng_fetch_assoc($result);
$row['description'] = preg_replace("/\"/", "&#34;", $row['description']);
tng_free_result($result);

$treerow = getTree($trees_table, $tree);

$helplang = findhelp("dna_help.php");

tng_adminheader(_('Edit Existing Group'), $flags);
?>
<script src="js/selectutils.js"></script>
<script>
    function validateForm() {
        let rval = true;
        var form = document.form1;
        if (form1.description.value.length == 0) {
            alert("<?php echo _('Please enter a group description'); ?>");
            rval = false;
        } else if (document.form1.test_type.selectedIndex == 0) {
            alert("<?php echo _('Please select a test type.'); ?>");
            rval = false;
        }
        return rval;
    }

</script>

<?php
echo "</head>\n";
echo tng_adminlayout();

$dnatabs[0] = [1, "admin_dna_groups.php", _('Search'), "findtest"];
$dnatabs[1] = [$allow_add, "admin_new_dna_group.php", _('Add Group'), "addgroup"];
$dnatabs[2] = [$allow_edit, "#", _('Edit'), "edit"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/dna_help.php#add');\" class='lightlink'>" . _('Help for this area') . "</a>";
$menu = doMenu($dnatabs, "edit", $innermenu);
echo displayHeadline(_('DNA Groups') . " &gt;&gt; " . _('Edit Existing Group'), "img/dna_icon.gif", $menu, $message);
?>

<table class="lightback">
    <tr class="databack">
        <td class="tngshadow">
            <form action="admin_update_dna_groups.php" method="post" name="form1" id="form1" onSubmit="return validateForm();">
                <table class="normal">
                    <tr>
                        <td class='align-top'><?php echo _('Tree'); ?>:</td>
                        <td><?php echo $treerow['treename']; ?></td>
                    </tr>
                    <tr>
                        <td class='align-top'><?php echo _('Group ID'); ?>:</td>
                        <td><?php echo $row['dna_group']; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo _('Test Type'); ?>:</td>
                        <td>
                            <select name="test_type">
                                <option value=""></option>
                                <option value="atDNA" <?php if ($row['test_type'] == "atDNA") {
                                    echo "selected";
                                } ?>><?php echo _('atDNA (autosomal) Tests'); ?></option>
                                <option value="Y-DNA" <?php if ($row['test_type'] == "Y-DNA") {
                                    echo "selected";
                                } ?>><?php echo _('Y-DNA Tests'); ?></option>
                                <option value="mtDNA" <?php if ($row['test_type'] == "mtDNA") {
                                    echo "selected";
                                } ?>><?php echo _('mtDNA (Mitochondrial) Tests'); ?></option>
                                <option value="X-DNA" <?php if ($row['test_type'] == "X-DNA") {
                                    echo "selected";
                                } ?>><?php echo _('X-DNA'); ?></option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class='align-top'><?php echo _('Description'); ?>:</td>
                        <td>
                            <input type="text" name="description" size="60" value="<?php echo $row['description']; ?>">
                        </td>
                    </tr>

                </table>
                <span class="normal">
	<br></span>
                <input type="hidden" name="tree" value="<?php echo $tree; ?>">
                <input type="hidden" name="dna_group" value="<?php echo $dna_group; ?>">
                <input type="submit" name="submit" class="btn" value="<?php echo _('Save'); ?>">
            </form>
        </td>
    </tr>

</table>
<?php echo tng_adminfooter(); ?>
