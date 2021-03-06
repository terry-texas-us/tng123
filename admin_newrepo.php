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
    $firsttree = $assignedtree;
} else {
    $wherestr = "";
    $firsttree = isset($_COOKIE['tng_tree']) ? $_COOKIE['tng_tree'] : "";
}

$helplang = findhelp("repositories_help.php");

tng_adminheader(_('Add New Repository'), $flags);
?>
    <script src="js/selectutils.js"></script>
    <script>
        function validateForm() {
            var rval = true;
            document.form1.repoID.value = TrimString(document.form1.repoID.value);
            if (document.form1.repoID.value.length == 0) {
                alert("<?php echo _('Please enter a Repository ID.'); ?>");
                return false;
            } else if (document.form1.reponame.value.length == 0) {
                alert("<?php echo _('Please enter a Repository name.'); ?>");
                return false;
            }
            return rval;
        }

        const selecttree = "<?php echo _('Please select/add a tree.'); ?>";
    </script>
    </head>

<?php
echo tng_adminlayout(" onload=\"generateID('repo',document.form1.repoID,document.form1.tree1);\"");

$repotabs[0] = [1, "admin_repositories.php", _('Search'), "findrepo"];
$repotabs[1] = [$allow_add, "admin_newrepo.php", _('Add New'), "addrepo"];
$repotabs[2] = [$allow_edit && $allow_delete, "admin_mergerepos.php", _('Merge'), "merge"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/repositories_help.php#add');\" class='lightlink'>" . _('Help for this area') . "</a>";
$menu = doMenu($repotabs, "addrepo", $innermenu);
echo displayHeadline(_('Repositories') . " &gt;&gt; " . _('Add New Repository'), "img/repos_icon.gif", $menu, $message);
?>

    <form action="admin_addrepo.php" method="post" name="form1" onSubmit="return validateForm();">
        <table class="lightback">
            <tr class="databack">
                <td class="tngshadow">
                    <table>
                        <tr>
                            <td class="align-top" colspan="2"><span class="normal"><strong><?php echo _('Please prefix Repository ID with \"REPO\" for \"Repository\"'); ?></strong></span></td>
                        </tr>
                        <tr>
                            <td class='align-top'><span class="normal"><?php echo _('Tree'); ?>:</span></td>
                            <td>
                                <select name="tree1" onChange="generateID('repo',document.form1.repoID,document.form1.tree1);">
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
                            <td class='align-top'><span class="normal"><?php echo _('Repository ID'); ?>:</span></td>
                            <td>
                                <input type="text" name="repoID" size="10" onBlur="this.value=this.value.toUpperCase()">
                                <input type="button" value="<?php echo _('Generate'); ?>" onClick="generateID('repo',document.form1.repoID,document.form1.tree1);">
                                <input type="submit" name="submit" value="<?php echo _('Lock'); ?>" onClick="document.form1.newscreen[0].checked = true;">
                                <input type="button" value="<?php echo _('Check'); ?>" onClick="checkID(document.form1.repoID.value,'repo','checkmsg',document.form1.tree1);">
                                <span id="checkmsg" class="normal"></span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="databack">
                <td class="tngshadow">
                    <table class="normal">
                        <tr>
                            <td><?php echo _('Name'); ?>:</td>
                            <td><span class="normal"><input type="text" name="reponame" size="40"> (<?php echo _('required'); ?>)</span></td>
                        </tr>
                        <tr>
                            <td><?php echo _('Address 1'); ?>:</td>
                            <td>
                                <input type="text" name="address1" size="50">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Address 2'); ?>:</td>
                            <td>
                                <input type="text" name="address2" size="50">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('City'); ?>:</td>
                            <td>
                                <input type="text" name="city" size="50">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('State/Province'); ?>:</td>
                            <td>
                                <input type="text" name="state" size="50">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Zip/Postal Code'); ?>:</td>
                            <td>
                                <input type="text" name="zip" size="20">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Country'); ?>:</td>
                            <td>
                                <input type="text" name="country" size="50">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Phone'); ?>:</td>
                            <td>
                                <input type="text" name="phone" size="30" value="">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('E-mail'); ?>:</td>
                            <td>
                                <input type="text" name="email" size="50" value="">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Web Site'); ?>:</td>
                            <td>
                                <input type="text" name="www" size="50" value="">
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="databack">
                <td class="tngshadow">
                    <p class="normal"><strong><?php echo _('Note: Additional events and notes may be added after the new repository has been saved.'); ?></strong></p>
                    <input type="submit" name="save" class="btn" accesskey="s" value="<?php echo _('Save and continue...'); ?>">
                </td>
            </tr>
        </table>
    </form>

<?php echo tng_adminfooter(); ?>