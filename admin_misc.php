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
                <h3 class="subhead"><a href="admin_whatsnewmsg.php"><img src="img/tng_expand.gif" class="inline-block"><?php echo $admtext['whatsnew']; ?></a></h3>
                <p class="normal miscmenu"><?php echo $admtext['whatsnewblurb']; ?></p>
                <hr>
                <h3 class="subhead"><a href="admin_mostwanted.php"><img src="img/tng_expand.gif" class="inline-block"><?php echo $admtext['mostwanted']; ?></a></h3>
                <p class="normal miscmenu"><?php echo $admtext['mwblurb']; ?></p>
                <hr>
                <h3 class="subhead"><a href="admin_data_validation.php"><img src="img/tng_expand.gif" class="inline-block"><?php echo $admtext['dataval']; ?></a></h3>
                <p class="normal miscmenu"><?php echo $admtext['dvblurb']; ?></p>
                <hr>
            </td>
        </tr>
    </table>
    </div>
<?php echo tng_adminfooter(); ?>