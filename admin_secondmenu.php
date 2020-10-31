<?php
include "begin.php";
include "adminlib.php";
$textpart = "secondary";
include "$mylanguage/admintext.php";

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

tng_adminheader($admtext['secondary'], $flags);

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

$datatabs[0] = [1, "admin_dataimport.php", $admtext['import'], "import"];
$datatabs[1] = [$allow_export, "admin_export.php", $admtext['export'], "export"];
$datatabs[2] = [1, "admin_secondmenu.php", $admtext['secondarymaint'], "second"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/second_help.php');\" class='lightlink'>{$admtext['help']}</a>";
$menu = doMenu($datatabs, "second", $innermenu);
echo displayHeadline($admtext['datamaint'] . " &gt;&gt; " . $admtext['secondary'], "img/data_icon.gif", $menu, (isset($message) ? $message : ""));
?>

<table class="lightback">
    <tr class="databack">
        <td class="tngshadow">
            <form action="admin_secondary.php" method="post" name="form1">
	<span class="normal"><?php echo $admtext['tree']; ?>: <select name="tree">
<?php
if (!$assignedtree) echo "<option value='--all--'>{$admtext['alltrees']}</option>\n";
while ($row = tng_fetch_assoc($result)) {
    echo "	<option value=\"{$row['gedcom']}\">{$row['treename']}</option>\n";
}
?>
	</select><br><br></span>
                <input type="submit" name="secaction" value="<?php echo $admtext['tracklines']; ?>">
                <input type="submit" name="secaction" value="<?php echo $admtext['sortchildren']; ?>">
                <input type="submit" name="secaction" value="<?php echo $admtext['sortspouses']; ?>">
                <input type="submit" name="secaction" value="<?php echo $admtext['relabelbranches']; ?>">
                <input type="submit" name="secaction" value="<?php echo $admtext['creategendex']; ?>">
                <input type="submit" name="secaction" value="<?php echo $admtext['evalmedia']; ?>">
                <input type="submit" name="secaction" value="<?php echo $admtext['refreshliving']; ?>">
                <input type="submit" name="secaction" value="<?php echo $admtext['makeprivate']; ?>">
            </form>
            <p class="normal"><?php echo $admtext['postgdx']; ?>:<br>
                &raquo; <a href="http://gendexnetwork.org" target="_blank">GenDex Network</a><br>
                &raquo; <a href="http://www.familytreeseeker.com" target="_blank">FamilyTreeSeeker.com</a>
            </p>
        </td>
    </tr>
</table>
<?php echo tng_adminfooter(); ?>
