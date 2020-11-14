<?php
include "begin.php";
include "adminlib.php";
$textpart = "sources";
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
    $firsttree = $assignedtree;
} else {
    $wherestr = "";
    $firsttree = isset($_COOKIE['tng_tree']) ? $_COOKIE['tng_tree'] : "";
}

$helplang = findhelp("sources_help.php");

tng_adminheader(_('Add New Source'), $flags);
?>
    <script src="js/selectutils.js"></script>
    <script>
        function validateForm() {
            let rval = true;
            document.form1.sourceID.value = TrimString(document.form1.sourceID.value);
            if (document.form1.sourceID.value.length == 0) {
                alert("<?php echo _('Please enter a Source ID.'); ?>");
                return false;
            }
            return rval;
        }

        const selecttree = "<?php echo _('Please select/add a tree.'); ?>";
    </script>
    </head>

<?php
echo tng_adminlayout(" onload=\"generateID('source',document.form1.sourceID,document.form1.tree1);\"");

$sourcetabs[0] = [1, "admin_sources.php", _('Search'), "findsource"];
$sourcetabs[1] = [$allow_add, "admin_newsource.php", _('Add New'), "addsource"];
$sourcetabs[2] = [$allow_edit && $allow_delete, "admin_mergesources.php", _('Merge'), "merge"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/sources_help.php#add');\" class='lightlink'>" . _('Help for this area') . "</a>";
$menu = doMenu($sourcetabs, "addsource", $innermenu);
echo displayHeadline(_('Sources') . " &gt;&gt; " . _('Add New Source'), "img/sources_icon.gif", $menu, $message);
?>

    <form action="admin_addsource.php" method="post" name="form1" onSubmit="return validateForm();">
        <table class="lightback">
            <tr class="databack">
                <td class="tngshadow">
                    <table class="normal">
                        <tr>
                            <td colspan="2"><strong><?php echo _('Please prefix Source ID with \"S\" for \"Source\"'); ?></strong></td>
                        </tr>
                        <tr>
                            <td><?php echo _('Tree'); ?></td>
                            <td>
                                <select name="tree1" onChange="generateID('source',document.form1.sourceID,document.form1.tree1);">
                                    <?php
                                    $query = "SELECT gedcom, treename FROM $trees_table $wherestr ORDER BY treename";
                                    $result = tng_query($query);
                                    $numtrees = tng_num_rows($result);
                                    while ($row = tng_fetch_assoc($result)) {
                                        echo "		<option value=\"{$row['gedcom']}\"";
                                        if ($firsttree == $row['gedcom']) echo " selected";

                                        echo ">{$row['treename']}</option>\n";
                                    }
                                    tng_free_result($result);
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><span class="normal"><?php echo _('Source ID'); ?>:</span></td>
                            <td>
                                <input type="text" name="sourceID" size="10" onBlur="this.value=this.value.toUpperCase()">
                                <input type="button" value="<?php echo _('Generate'); ?>" onClick="generateID('source',document.form1.sourceID,document.form1.tree1);">
                                <input type="submit" name="submit" value="<?php echo _('Lock'); ?>" onClick="document.form1.newscreen[0].checked = true;">
                                <input type="button" value="<?php echo _('Check'); ?>" onClick="checkID(document.form1.sourceID.value,'source','checkmsg',document.form1.tree1);">
                                <span id="checkmsg" class="normal"></span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="databack">
                <td class="tngshadow">
                    <table class="normal">
                        <?php include "micro_newsource.php"; ?>
                    </table>
                </td>
            </tr>
            <tr class="databack">
                <td class="tngshadow">
                    <p class="normal"><strong><?php echo _('Note: Additional events and notes may be added after the new source has been saved.'); ?></strong></p>
                    <input type="submit" class="btn" name="save" accesskey="s" value="<?php echo _('Save and continue...'); ?>">
                </td>
            </tr>
        </table>
    </form>

<?php echo tng_adminfooter(); ?>