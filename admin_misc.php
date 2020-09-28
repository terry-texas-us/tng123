<?php
include "begin.php";
include "adminlib.php";
$textpart = "misc";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";
if ($assignedtree) {
    $message = $admtext['norights'];
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

$helplang = findhelp("misc_help.php");

$flags['tabs'] = $tngconfig['tabs'];
tng_adminheader($admtext['misc'], $flags);

echo "</head>\n";
echo tng_adminlayout();

$misctabs[0] = [1, "admin_misc.php", $admtext['menu'], "misc"];
$misctabs[1] = [1, "admin_whatsnewmsg.php", $admtext['whatsnew'], "whatsnew"];
$misctabs[2] = [1, "admin_mostwanted.php", $admtext['mostwanted'], "mostwanted"];
$misctabs[3] = [1, "admin_data_validation.php", $admtext['dataval'], "validation"];
$innermenu = "<a href='#' onclick=\"return openHelp('$helplang/misc_help.php');\" class='lightlink'>{$admtext['help']}</a>";
$menu = doMenu($misctabs, "misc", $innermenu);
echo displayHeadline($admtext['misc'], "img/misc_icon.gif", $menu, $message);
?>
<table class="lightback">
    <tr class="databack">
        <td class="tngshadow">
            <h3 class="subhead"><img src="img/tng_expand.gif" width="15" height="15"> <a href="admin_whatsnewmsg.php"><?php echo $admtext['whatsnew']; ?></a></h3>
            <span class="normal miscmenu"><?php echo $admtext['whatsnewblurb']; ?></span>
            <hr>
            <h3 class="subhead"><img src="img/tng_expand.gif" width="15" height="15"> <a href="admin_mostwanted.php"><?php echo $admtext['mostwanted']; ?></a></h3>
            <span class="normal miscmenu"><?php echo $admtext['mwblurb']; ?></span>
            <hr>
            <h3 class="subhead"><img src="img/tng_expand.gif" width="15" height="15"> <a href="admin_data_validation.php"><?php echo $admtext['dataval']; ?></a></h3>
            <span class="normal miscmenu"><?php echo $admtext['dvblurb']; ?></span>
            <hr>
        </td>
    </tr>
</table>
</div>
<?php echo "<div style=\"text-align: center;\"><span class='normal'>$tng_title</span></div>"; ?>
</body>
</html>