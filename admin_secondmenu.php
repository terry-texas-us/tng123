<?php
include "begin.php";
include "adminlib.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";

if ($assignedtree) {
    $wherestr = "WHERE gedcom = '$assignedtree'";
} else {
    $wherestr = "";
}
$query = "SELECT gedcom, treename FROM $trees_table $wherestr ORDER BY treename";
$result = tng_query($query);

$helplang = findhelp("second_help.php");

tng_adminheader(_('Secondary Processes'), $flags);

echo "</head>\n";
echo tng_adminlayout();

$allow_export = 1;
if (!$allow_ged && $assignedtree) {
    $query = "SELECT disallowgedcreate FROM $trees_table WHERE gedcom = '$assignedtree'";
    $disresult = tng_query($query);
    $row = tng_fetch_assoc($disresult);
    if ($row['disallowgedcreate']) $allow_export = 0;

    tng_free_result($disresult);
}

$datatabs[0] = [1, "admin_dataimport.php", _('Import'), "import"];
$datatabs[1] = [$allow_export, "admin_export.php", _('Export'), "export"];
$datatabs[2] = [1, "admin_secondmenu.php", _('Secondary Processes'), "second"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/second_help.php');\" class='lightlink'>" . _('Help for this area') . "</a>";
$menu = doMenu($datatabs, "second", $innermenu);
echo displayHeadline(_('Import/Export') . " &gt;&gt; " . _('Secondary Processes'), "img/data_icon.gif", $menu, (isset($message) ? $message : ""));
?>

<table class="lightback">
    <tr class="databack">
        <td class="tngshadow">
            <form action="admin_secondary.php" method="post" name="form1">
	<span class="normal"><?php echo _('Tree'); ?>: <select name="tree">
<?php
if (!$assignedtree) echo "<option value='--all--'>" . _('All Trees') . "</option>\n";
while ($row = tng_fetch_assoc($result)) {
    echo "	<option value=\"{$row['gedcom']}\">{$row['treename']}</option>\n";
}
?>
	</select><br><br></span>
                <input type="submit" name="secaction" value="<?php echo _('Track Lines'); ?>">
                <input type="submit" name="secaction" value="<?php echo _('Sort Children'); ?>">
                <input type="submit" name="secaction" value="<?php echo _('Sort Spouses'); ?>">
                <input type="submit" name="secaction" value="<?php echo _('Relabel Branches'); ?>">
                <input type="submit" name="secaction" value="<?php echo _('Create GENDEX'); ?>">
                <input type="submit" name="secaction" value="<?php echo _('Trim Media Menus'); ?>">
                <input type="submit" name="secaction" value="<?php echo _('Refresh Living'); ?>">
                <input type="submit" name="secaction" value="<?php echo _('Make Private'); ?>">
            </form>
            <p class="normal"><?php echo _('Where to post your GENDEX file'); ?>:<br>
                &raquo; <a href="http://gendexnetwork.org" target="_blank">GenDex Network</a><br>
                &raquo; <a href="http://www.familytreeseeker.com" target="_blank">FamilyTreeSeeker.com</a>
            </p>
        </td>
    </tr>
</table>
<?php echo tng_adminfooter(); ?>
