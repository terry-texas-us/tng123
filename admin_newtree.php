<?php
include "begin.php";
include "adminlib.php";

/** @global mixed $beforeimport yes if modal request made 'Add New Tree' during GEDCOM Import */
$beforeimport = $_GET['beforeimport'] ?? null;

$admin_login = 1;
include "checklogin.php";
include "version.php";
if (!$allow_add) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

$helplang = findhelp("trees_help.php");

if ($beforeimport == "yes") { // ajax html excludes html and body tags
    header("Content-type:text/html; charset=" . $session_charset);
    echo "<div class='databack ajaxwindow' id='newtree'>\n";
    echo "<h3 class='subhead'>" . _('Add New Tree') . " |\n";
    echo "<a href='#' onclick=\"return openHelp('{$helplang}/trees_help.php#add', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\">" . _('Help for this area') . "></a></h3>";
} else {
    tng_adminheader(_('Add New Tree'), $flags);
    ?>
    <script>
        function validateTreeForm(form) {
            let rval = true;
            if (form.gedcom.value.length == 0) {
                alert("<?php echo _('Please enter a tree ID.'); ?>");
                rval = false;
            } else {
                if (!alphaNumericCheck(form.gedcom.value)) {
                    alert("<?php echo _('Please use only alphanumeric characters in your Tree ID.'); ?>");
                    rval = false;
                } else {
                    if (form.treename.value.length == 0) {
                        alert("<?php echo _('Please enter a tree name.'); ?>");
                        rval = false;
                    }
                }
            }
            return rval;
        }

        function alphaNumericCheck(string) {
            const regex = /^[0-9A-Za-z_-]+$/;
            return regex.test(string);
        }
    </script>
    <?php
    echo "</head>";
    echo tng_adminlayout();
    $allow_add_tree = $assignedtree ? 0 : $allow_add;
    $treetabs[0] = [1, "admin_trees.php", _('Search'), "findtree"];
    $treetabs[1] = [$allow_add_tree, "admin_newtree.php", _('Add New'), "addtree"];
    $innermenu = "<a href='#' onclick=\"return openHelp('$helplang/trees_help.php#add');\" class='lightlink'>" . _('Help for this area') . "</a>";
    $menu = doMenu($treetabs, "addtree", $innermenu);
    echo displayHeadline(_('Trees') . " &gt;&gt; " . _('Add New Tree'), "img/trees_icon.gif", $menu, $message);
}
?>
    <table <?php echo !$beforeimport ? " class='lightback w-full'" : "" ?> cellpadding="10" cellspacing="2">
        <tr class="databack">
            <td<?php echo !$beforeimport ? " class=\"tngshadow\"" : "" ?>>
                <form action="admin_addtree.php" method="post" name="treeform"
                    onsubmit="return validateTreeForm(this);">
                    <table class="normal">
                        <tr>
                            <td><?php echo _('Tree ID'); ?>:</td>
                            <td>
                                <input type="text" name="gedcom" size="20" maxlength="20">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Tree Name'); ?>:</td>
                            <td>
                                <input type="text" name="treename" size="50" value="<?php echo $treename; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td class='align-top'><?php echo _('Description'); ?>:</td>
                            <td><textarea cols="40" rows="3" name="description"><?php echo $description; ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Owner'); ?>:</td>
                            <td>
                                <input type="text" name="owner" size="50" value="<?php echo $owner; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('E-mail'); ?>:</td>
                            <td>
                                <input type="text" name="email" size="50" value="<?php echo $email; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Address'); ?>:</td>
                            <td>
                                <input type="text" name="address" size="50" value="<?php echo $address; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('City'); ?>:</td>
                            <td>
                                <input type="text" name="city" size="50" value="<?php echo $city; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('State/Province'); ?>:</td>
                            <td>
                                <input type="text" name="state" size="50" value="<?php echo $state; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Zip/Postal Code'); ?>:</td>
                            <td>
                                <input type="text" name="zip" size="50" value="<?php echo $zip; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Country'); ?>:</td>
                            <td>
                                <input type="text" name="country" size="50" value="<?php echo $country; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Phone'); ?>:</td>
                            <td>
                                <input type="text" name="phone" size="50" value="<?php echo $phone; ?>">
                            </td>
                        </tr>
                    </table>
                    <span class="normal">
                    <input type="checkbox" name="private" value="1"<?php if ($private) {
                        echo " checked";
                    } ?>> <?php echo _('Keep owner information private'); ?><br>
                    <input type="checkbox" name="disallowgedcreate" value="1"<?php if ($disallowgedcreate) {
                        echo " checked";
                    } ?>> <?php echo _('Don\'t allow users to download GEDCOM files'); ?><br>
                    <input type="checkbox" name="disallowpdf" value="1"<?php if ($disallowpdf) {
                        echo " checked";
                    } ?>> <?php echo _('Don\'t allow users to create PDF files'); ?>
                    <br><br>
                    </span>
                    <input type="hidden" name="beforeimport" value="<?php echo $beforeimport; ?>">
                    <input type="submit" name="submit" accesskey="s" class="btn"
                        value="<?php echo _('Save'); ?>">
                    <span id="treemsg"
                        class="normal msgapproved"></span>
                </form>
            </td>
        </tr>
    </table>
<?php
if ($beforeimport) {
    echo "</div>\n";
} else {
    echo tng_adminfooter();
}
?>