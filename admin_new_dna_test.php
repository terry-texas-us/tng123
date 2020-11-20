<?php
include "begin.php";
include "adminlib.php";

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

$helplang = findhelp("dna_help.php");

tng_adminheader(_('Add New DNA Test'), $flags);

echo "</head>\n";
echo tng_adminlayout();

$dnatabs[0] = [1, "admin_dna_tests.php", _('Search'), "findtest"];
$dnatabs[1] = [$allow_add, "admin_new_dna_test.php", _('Add New'), "addtest"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/dna_help.php#add');\" class='lightlink'>" . _('Help for this area') . "</a> ";
$innermenu .= "&nbsp;|&nbsp;<a href='#' class='lightlink' onClick=\"return toggleAll('on');\">" . _('Expand all') . "</a> &nbsp;|&nbsp; <a href='#' class='lightlink' onClick=\"return toggleAll('off');\">" . _('Collapse all') . "</a>";
$menu = doMenu($dnatabs, "addtest", $innermenu);
echo displayHeadline(_('DNA Tests') . " &gt;&gt; " . _('Add New DNA Test'), "img/dna_icon.gif", $menu, "");
?>

<form action="admin_add_dna_test.php" method="post" name="form1" id="form1" onsubmit="return validateForm();">
    <table class="lightback">
        <tr class="databack">
            <td class="tngshadow">
                <?php echo displayToggle("plus0", 1, "testinfo", _('Test Information'), _('Upload a new file from your computer, or select from files already on your site')); ?>

                <div id="testinfo">
                    <br>
                    <table class="normal">
                        <tr>
                            <td><?php echo _('Test Type'); ?>:</td>
                            <td>
                                <select name="test_type" id="test_type">
                                    <option value=""></option>
                                    <option value="atDNA"><?php echo _('atDNA (autosomal) Tests'); ?></option>
                                    <option value="Y-DNA"><?php echo _('Y-DNA Tests'); ?></option>
                                    <option value="mtDNA"><?php echo _('mtDNA (Mitochondrial) Tests'); ?></option>
                                    <option value="X-DNA"><?php echo _('X-DNA'); ?></option>
                                </select>&nbsp;<img src="img/spinner.gif" style="display:none;" id="treespinner2" alt="" class="spinner">&nbsp;&nbsp;&nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Test Number/Name'); ?>:</td>
                            <td>
                                <input type="text" name="test_number" class="medfield">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Vendor'); ?>:</td>
                            <td>
                                <input type="text" name="vendor" class="medfield">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Test Date'); ?>:</td>
                            <td>
                                <input type="text" name="test_date" class="medfield" onblur="checkDate(this);">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Match Date'); ?>:</td>
                            <td>
                                <input type="text" name="match_date" class="w-64" onblur="checkDate(this);">
                            </td>
                        </tr>
                        <?php if ($test_type == "atDNA") { ?>
                            <tr>
                                <td><?php echo _('GEDmatch ID'); ?>:</td>
                                <td>
                                    <input type="text" name="GEDmatchID" value="<?php echo $row['GEDmatchID']; ?>" id="GEDmatchID" size="40" maxlength="40">
                                </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td><strong><?php echo _('Keep Test Private'); ?>:</strong>&nbsp;</td>
                            <td>
                                <select name="private_test">
                                    <option value="0"<?php if (!$row['private_test']) {
                                        echo " selected";
                                    } ?>><?php echo _('No'); ?></option>
                                    <option value="1"<?php if ($row['private_test']) {
                                        echo " selected";
                                    } ?>><?php echo _('Yes'); ?></option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><br><strong><?php echo _('Person who took this test'); ?></strong></td>
                        </tr>
                        <tr>
                            <td><?php echo _('Tree'); ?>:</td>
                            <td>
                                <select name="mynewgedcom">
                                    <option value=""></option>
                                    <?php
                                    $query = "SELECT gedcom, treename FROM $trees_table $wherestr ORDER BY treename";
                                    $treeresult = tng_query($query);

                                    while ($treerow = tng_fetch_assoc($treeresult)) {
                                        echo "	<option value=\"{$treerow['gedcom']}\">{$treerow['treename']}</option>\n";
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo "" . _('Person ID') . " "; ?>:</td>
                            <td>

                                <input type="text" name="personID" id="personID" size="20" maxlength="22"> &nbsp;<?php echo _('OR'); ?>&nbsp;
                                <a href="#" onclick="return findItem('I','personID','',document.form1.mynewgedcom.options[document.form1.mynewgedcom.selectedIndex].value,'<?php echo $assignedbranch; ?>');" title="<?php echo _('Find...'); ?>">
                                    <img src="img/tng_find.gif" title="<?php echo _('Find...'); ?>" alt="<?php echo _('Find...'); ?>" class="align-middle" width="20" height="20" style="margin-left:2px;margin-bottom:4px;">
                                </a>
                                <span id="deststrfield"><?php echo $takername; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo "" . _('OR') . " " . _('Person not in database') . " "; ?></td>
                            <td>
                                <input type="text" name="person_name" value="<?php echo $row['person_name']; ?>" id="person_name" size="40" maxlength="100">
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;<strong><?php echo _('Keep Name Private'); ?>:</strong>&nbsp;<input type="checkbox" name="private_dna" value="1">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>

        <tr class="databack">
            <td class="tngshadow">
                <p class="normal"><strong><?php echo _('Note: More information may be added, and the test linked to more individuals, on the next screen.'); ?></strong></p>
                <input type="hidden" value="<?php echo "$cw"; ?>" name="cw">
                <input type="submit" name="submitbtn" class="btn" accesskey="s" value="<?php echo _('Save and continue...'); ?>">
            </td>
        </tr>

    </table>
</form>
<?php echo "<div style=\"text-align: center;\"><span class='normal'>$tng_title</span></div>"; ?>
<script>
    var tree = "<?php echo $tree; ?>";
    var tnglitbox;

    function validateForm() {
        let rval = true;
//req: test number, test type
        var frm = document.form1;
        if (!frm.test_type.selectedIndex) {
            alert("<?php echo _('Please select a test type.'); ?>");
            rval = false;
        }
//removed test_number alert
        return rval;
    }

    function toggleAll(display) {
        toggleSection('testinfo', 'plus0', display);
        return false;
    }
</script>
<script src="js/datevalidation.js"></script>
<script src="js/selectutils.js"></script>
<script>
    var preferEuro = <?php echo($tngconfig['preferEuro'] ? $tngconfig['preferEuro'] : "false"); ?>;
    var preferDateFormat = '<?php echo $preferDateFormat; ?>';
</script>
</body>
</html>