<?php
include "begin.php";
include "adminlib.php";
require_once "./admin/trees.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
if (!$allow_edit || ($assignedtree && $assignedtree != $tree)) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

$query = "SELECT * FROM $branches_table WHERE gedcom = '$tree' AND branch = '$branch'";
$result = tng_query($query);
$row = tng_fetch_assoc($result);
$row['description'] = preg_replace("/\"/", "&#34;", $row['description']);
tng_free_result($result);

$treerow = getTree($trees_table, $tree);

$helplang = findhelp("branches_help.php");

tng_adminheader(_('Edit Existing Tree'), $flags);
?>
<script src="js/selectutils.js"></script>
<script>
    function validateForm() {
        let rval = true;
        var form = document.form1;
        if (form1.description.value.length == 0) {
            alert("<?php echo _('Please enter a branch description.'); ?>");
            rval = false;
        }
        return rval;
    }

    var tnglitbox;

    function startLabels(form) {
        //pass the form fields as args
        var form = document.form1;
        if (form.personID.value.length == 0) {
            alert("<?php echo _('Please enter a starting individual ID.'); ?>");
        } else if (isNaN(form.agens.value) || isNaN(form.dgens.value)) {
            alert("<?php echo _('Values for Ancestors and Descendants must be numeric.'); ?>");
        } else {
            var args = "&personID=" + form.personID.value + "&agens=" + form.agens.value + "&dagens=" + form.dagens.value + "&dgens=" + form.dgens.value + "&dospouses=" + form.dospouses.value;
            tnglitbox = new LITBox('ajx_branchmenu.php?branch=<?php echo $branch; ?>&tree=<?php echo $tree; ?>' + args, {
                width: 420, height: 420
            });
        }
        return false;
    }

    function showBranchPeople() {
        tnglitbox = new LITBox('ajx_showbranch.php?branch=<?php echo $branch; ?>&tree=<?php echo $tree; ?>', {
            width: 420, height: 420
        });
        return false;
    }

    var tree = "<?php echo $tree; ?>";

    function addLabels() {
        var form1 = document.form1;

        jQuery('#branchresults').html('');
        jQuery('#labelspinner').show();
        params = {
            branchaction: jQuery("input:radio[name ='branchaction']:checked").val(),
            set: jQuery("input:radio[name ='set']:checked").val(),
            overwrite: jQuery('#overwrite').val(),
            personID: form1.personID.value,
            agens: form1.agens.value,
            dagens: jQuery('#dagens').val(),
            dgens: form1.dgens.value,
            dospouses: jQuery('#dospouses').attr('checked') ? true : "",
            tree: '<?php echo $tree; ?>',
            branch: '<?php echo $branch; ?>'
        };
        jQuery.ajax({
            url: 'ajx_labels.php',
            data: params,
            dataType: 'html',
            success: function (req) {
                jQuery('#labelspinner').hide();
                jQuery('#branchresults').html(req);
            }
        });
        return false;
    }

    function toggleClear(option) {
        jQuery('#allpart').fadeIn(300);
        jQuery('#labelsub').val(option ? '<?php echo _('Delete'); ?>' : '<?php echo _('Clear labels'); ?>');
        jQuery('#overwrite1').fadeOut(300);
    }

    function toggleAdd() {
        jQuery('#allpart').fadeOut(300);
        document.form2.set[1].checked = true;
        jQuery('#labelsub').val('<?php echo _('Add labels'); ?>');
        jQuery('#overwrite1').fadeIn(300);
    }
</script>

<?php
echo "</head>\n";
echo tng_adminlayout();

$branchtabs[0] = [1, "admin_branches.php", _('Search'), "findbranch"];
$branchtabs[1] = [$allow_add, "admin_newbranch.php", _('Add New'), "addbranch"];
$branchtabs[2] = [$allow_edit, "#", _('Edit'), "edit"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/branches_help.php#add');\" class='lightlink'>" . _('Help for this area') . "</a>";
$menu = doMenu($branchtabs, "edit", $innermenu);
echo displayHeadline(_('Branches') . " &gt;&gt; " . _('Edit Existing Branch'), "img/branches_icon.gif", $menu, $message);
?>

<table class="lightback">
    <tr class="databack">
        <td class="tngshadow">
            <form action="admin_updatebranch.php" method="post" name="form1" id="form1" onSubmit="return validateForm();">
                <table class="normal">
                    <tr>
                        <td class='align-top'><?php echo _('Tree'); ?>:</td>
                        <td><?php echo $treerow['treename']; ?></td>
                    </tr>
                    <tr>
                        <td class='align-top'><?php echo _('Branch ID'); ?>:</td>
                        <td><?php echo $branch; ?></td>
                    </tr>
                    <tr>
                        <td class='align-top'><?php echo _('Description'); ?>:</td>
                        <td>
                            <input type="text" name="description" size="60" value="<?php echo $row['description']; ?>">
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
                                        <input type="text" name="personID" id="personID" value="<?php echo $row['personID']; ?>" size="10"> &nbsp;<?php echo _('OR'); ?>&nbsp;
                                    </td>
                                    <td><a href="#" onclick="return findItem('I','personID','','<?php echo $tree; ?>','<?php echo $assignedbranch; ?>');" title="<?php echo _('Find...'); ?>"
                                            class="smallicon admin-find-icon"></a></td>
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
                                <input type="text" name="agens" size="3" maxlength="3" value="<?php echo $row['agens'] ? $row['agens'] : 0; ?>">
                                &nbsp;&nbsp; <?php echo _('Descendant generations from each ancestor'); ?>:
                                <select name="dagens" id="dagens">
                                    <?php
                                    $dagens = $row['dagens'] != "" ? $row['dagens'] : 1;
                                    for ($i = 0; $i < 6; $i++) {
                                        echo "<option value=\"$i\"";
                                        if ($i == $dagens) echo " selected";

                                        echo ">$i</option>";
                                    }
                                    ?>
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
                                <input type="text" name="dgens" size="3" maxlength="3" value="<?php echo $row['dgens'] ? $row['dgens'] : 0; ?>"> &nbsp;&nbsp;
                                <input type="checkbox" name="dospouses" id="dospouses"<?php if ($row['inclspouses']) {
                                    echo " checked";
                                } ?> value="1"> <?php echo _('Include spouses for all descendants'); ?>
                            </div>
                        </td>
                    </tr>
                </table>
                <span class="normal">
	<br></span>
                <input type="hidden" name="tree" value="<?php echo $tree; ?>">
                <input type="hidden" name="branch" value="<?php echo $branch; ?>">
                <input type="submit" name="submit" class="btn" value="<?php echo _('Save'); ?>">
                <input type="submit" name="submitx" accesskey="s" class="btn" value="<?php echo _('Save and Exit'); ?>">
                <input type="button" class="btn" value="<?php echo _('Add labels'); ?>" onclick="return startLabels(document.forms.form1);">
                <input type="button" class="btn" value="<?php echo _('Show people with this tree/branch'); ?>" onclick="return showBranchPeople();">
            </form>
        </td>
    </tr>

</table>
<?php echo tng_adminfooter(); ?>
