<?php
include "begin.php";
include "adminlib.php";
require_once "./admin/trees.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
if (!$allow_edit || $assignedbranch) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

$row = getTree($trees_table, $tree);

$query = "SELECT description FROM $branches_table WHERE gedcom = '$tree' and branch = '$branch'";
$result = tng_query($query);
$brow = tng_fetch_assoc($result);
tng_free_result($result);

$query = "SELECT count(persfamID) AS pcount FROM $branchlinks_table WHERE gedcom = '$tree' AND branch = '$branch'";
$result = tng_query($query);
$prow = tng_fetch_assoc($result);
$pcount = $prow['pcount'];
tng_free_result($result);

$helplang = findhelp("branches_help.php");

tng_adminheader(_('Label Branches'), $flags);
?>
    <script src="js/selectutils.js"></script>
    <script>
        var tree = "<?php echo $tree; ?>";

        function toggleClear(option) {
            jQuery('#overwrite1').fadeOut(300);
            jQuery('#overwrite2').fadeOut(300);
            jQuery('#allpart').fadeIn(300);
            jQuery('#labelsub').val(option ? "<?php echo _('Delete'); ?>" : "<?php echo _('Clear labels'); ?>");
        }

        function toggleAdd() {
            jQuery('#overwrite1').fadeIn(300);
            jQuery('#overwrite2').fadeIn(300);
            jQuery('#allpart').fadeOut(300);
            document.form1.set[1].checked = true;
            jQuery('#labelsub').val('<?php echo _('Add labels'); ?>');
            togglePartial();
        }

        function confirmDelete() {
            return confirm("<?php echo _('Are you sure you want to delete all people and families with this branch label?'); ?>") ? validateForm() : false;
        }

        function toggleAll() {
            jQuery('#startind1').fadeOut(300);
            jQuery('#startind2').fadeOut(300);
            jQuery('#startind3').fadeOut(300);
            jQuery('#numgens1').fadeOut(300);
            jQuery('#numgens2').fadeOut(300);
            jQuery('#numgens3').fadeOut(300);
            jQuery('#numgens4').fadeOut(300);
        jQuery('#numgens5').fadeOut(300);
    }

    function togglePartial() {
        jQuery('#startind1').fadeIn(300);
        jQuery('#startind2').fadeIn(300);
        jQuery('#startind3').fadeIn(300);
        jQuery('#numgens1').fadeIn(300);
        jQuery('#numgens2').fadeIn(300);
        jQuery('#numgens3').fadeIn(300);
        jQuery('#numgens4').fadeIn(300);
        jQuery('#numgens5').fadeIn(300);
    }

        function validateForm() {
            let rval = true;
            var option = true;
            if (jQuery('#labelsub').val() == "<?php echo _('Delete'); ?>")
                option = confirm("<?php echo _('Are you sure you want to delete all people and families with this branch label?'); ?>");
            if (option) {
                if (document.form1.set[1].checked) {
                    if (document.form1.personID.value.length == 0) {
                        alert("<?php echo _('Please enter a starting individual ID.'); ?>");
                        rval = false;
                    } else if (isNaN(document.form1.agens.value) || isNaN(document.form1.dgens.value)) {
                        alert("<?php echo _('Values for Ancestors and Descendants must be numeric.'); ?>");
                        rval = false;
                    }
                }
                return rval;
            } else
                return false;
        }
    </script>

<?php
echo "</head>\n";
echo tng_adminlayout();

$branchtabs[0] = [1, "admin_branches.php", _('Search'), "findbranch"];
$branchtabs[1] = [$allow_add, "admin_newbranch.php", _('Add New'), "addbranch"];
$branchtabs[2] = [$allow_edit, "#", _('Label Branches'), "label"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/branches_help.php#labelbranch');\" class='lightlink'>" . _('Help for this area') . "</a>";
$menu = doMenu($branchtabs, "label", $innermenu);
echo displayHeadline(_('Branches') . " &gt;&gt; " . _('Label Branches'), "img/branches_icon.gif", $menu, $message);
?>

    <table class="lightback">
        <tr class="databack">
            <td class="tngshadow">
                <form action="admin_branchlabels.php" method="post" id="form1" name="form1" onSubmit="return validateForm();">
                    <table cellpadding="1" class="normal">
                        <tr>
                            <td><strong><?php echo _('Tree'); ?>:</strong></td>
                            <td><?php echo $row['treename']; ?>
                                <input type="hidden" name="tree" value="<?php echo $tree; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td class='align-top'><strong><?php echo _('Branch'); ?>:</strong></td>
                            <td class='align-top'><?php echo $brow['description'] . "<br>(" . _('People') . " + " . _('Families') . " = $pcount*)"; ?>
                                <input type="hidden" name="branch" value="<?php echo $branch; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><br><strong><?php echo _('Action'); ?>:</strong></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                &nbsp;&nbsp;<input type="radio" name="branchaction" value="add" checked onClick="toggleAdd();"> <?php echo _('Add labels'); ?>
                                &nbsp;&nbsp;<input type="radio" name="branchaction" value="clear" onClick="toggleClear(0);"> <?php echo _('Clear labels'); ?>
                                &nbsp;&nbsp;<input type="radio" name="branchaction" value="delete" onClick="toggleClear(1);"> <?php echo _('Delete people and families with this branch label'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div id="allpart" style="display:none;">
                                    &nbsp;&nbsp;<input type="radio" name="set" value="all" onClick="toggleAll();"> <?php echo _('All'); ?>
                                    &nbsp;&nbsp;<input type="radio" name="set" value="partial" checked onClick="togglePartial();"> <?php echo _('Partial'); ?>
                                </div>
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
                                        <td><a href="#" onclick="return findItem('I','personID','','<?php echo $tree; ?>','<?php echo $assignedbranch; ?>');" title="<?php echo _('Find...'); ?>" class="smallicon admin-find-icon"></a></td>
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
                                    <input type="checkbox" name="dospouses" checked="checked"> <?php echo _('Include spouses for all descendants'); ?></div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div id="overwrite1"><br><strong><?php echo _('Existing labels'); ?>:</strong></div>
                            </td>
                            <td>
                                <div id="overwrite2"><br>
                                    <select name="overwrite">
                                        <option value="2" selected><?php echo _('Append New'); ?></option>
                                        <option value="1"><?php echo _('Overwrite'); ?></option>
                                        <option value="0"><?php echo _('Leave'); ?></option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <br>
                    <input type="submit" id="labelsub" value="<?php echo _('Add labels'); ?>">
                    <input type="button" value="<?php echo _('Show people with this tree/branch'); ?>"
                        onclick="window.location.href='admin_showbranch.php?tree=<?php echo $tree; ?>&branch=<?php echo $branch; ?>';">
                </form>
                <p class="normal">
                    *<?php echo _('This number represents the total number of branch links, not necessarily the number of people or families currently linked to this branch. If you have recently re-imported your data, you may need to relabel your branches.'); ?></p>
            </td>
        </tr>
    </table>
<?php echo tng_adminfooter(); ?>