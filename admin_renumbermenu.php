<?php
include "begin.php";
include "adminlib.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
if ($assignedtree) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

$query = "SELECT gedcom, treename FROM $trees_table ORDER BY treename";
$result = tng_query($query);

$helplang = findhelp("backuprestore_help.php");

tng_adminheader(_('Utilities'), $flags);

echo "</head>\n";
echo tng_adminlayout();

$utiltabs[0] = [1, "admin_utilities.php?sub=tables", _('Tables'), "tables"];
$utiltabs[1] = [1, "admin_utilities.php?sub=structure", _('Table structure'), "structure"];
$utiltabs[2] = [1, "admin_renumbermenu.php", _('Resequence IDs'), "renumber"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/backuprestore_help.php');\" class='lightlink'>" . _('Help for this area') . "</a>";
$menu = doMenu($utiltabs, "renumber", $innermenu);
$headline = _('Utilities') . " &gt;&gt; " . _('Resequence IDs');
echo displayHeadline($headline, "img/backuprestore_icon.gif", $menu, $message);
?>

    <table class="lightback">
        <tr class="databack">
            <td class="tngshadow">
                <p class="normal"><?php echo _('<strong>WARNING:</strong> Resequencing your IDs could cause external links to your site to break or point to erroneous locations.'); ?></p>

                <h3 class="subhead"><?php echo _('Resequence IDs'); ?></h3>
                <form action="admin_renumber.php" method="post" name="form1">
                    <table class="normal">
                        <tr>
                            <td><?php echo _('Tree'); ?>:</td>
                            <td>
                                <select name="tree">
                                    <?php
                                    while ($row = tng_fetch_assoc($result)) {
                                        echo "	<option value=\"{$row['gedcom']}\">{$row['treename']}</option>\n";
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('ID Type'); ?>:</td>
                            <td>
                                <select name="type">
                                    <option value="person"><?php echo _('People'); ?></option>
                                    <option value="family"><?php echo _('Families'); ?></option>
                                    <option value="source"><?php echo _('Sources'); ?></option>
                                    <option value="repo"><?php echo _('Repositories'); ?></option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo _('Minimum Digits'); ?>*:</td>
                            <td>
                                <select name="digits">
                                    <?php
                                    for ($i = 1; $i <= 20; $i++)
                                        echo "<option value=\"$i\">$i</option>\n";
                                    ?>
                                </select>
                            </td>
                        </tr>
                    </table>
                    <br>
                    <input type="hidden" name="start" value="1">
                    <input type="submit" class="btn" value="<?php echo _('Resequence IDs'); ?>"<?php if (!$tngconfig['maint']) {
                        echo " disabled";
                    } ?>>
                    <?php
                    if (!$tngconfig['maint']) {
                        echo "<span class='normal'>" . _('You must be in Maintenance Mode to run this utility (go to Setup &gt;&gt; Configuration &gt;&gt; General Settings)') . "</span>";
                    }
                    ?>
                    <br><br>
                    <?php echo "<p class='normal'>*" . _('Not including ID prefix') . "</p>\n"; ?>
                </form>
            </td>
        </tr>
    </table>
<?php echo tng_adminfooter(); ?>