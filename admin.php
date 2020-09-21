<?php
include "begin.php";
include "adminlib.php";
$textpart = "index";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";

tng_adminheader($admtext['mainmenu'], "");

echo "</head>";

if ($sitever == "mobile" || $sitever == "tablet") {
    ?>
    <frameset rows="64,*,0">
        <frame name="rightbanner" src="admin_rightbanner.php" id="rightbanner" scrolling="No">
        <frame name="main" src="admin_main.php" scrolling="auto">
    </frameset>
<?php } else { ?>
    <frameset rows="64, *, 0" cols="168, *">
        <frame name="corner" src="admin_corner.php" scrolling="no">
        <frame name="rightbanner" src="admin_rightbanner.php" id="rightbanner" scrolling="No">
        <frame name="leftbanner" src="admin_leftbanner.php" scrolling="auto">
        <frame name="main" src="admin_main.php" scrolling="auto">
    </frameset>
<?php } ?>
<?php echo "</html>";
