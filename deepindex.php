<?php
include "begin.php";
include "genlib.php";
include "adminlib.php";
$textpart = "index";
include "$mylanguage/admintext.php";

$admin_login = 1;
if ($link) {
    include "checklogin.php";
}
?>
<frameset rows="64, *" cols="168, *">
    <frame name="corner" src="admin_corner.php" scrolling="no">
    <frame name="rightbanner" src="admin_rightbanner.php" id="rightbanner" scrolling="No">
    <frame name="leftbanner" src="admin_leftbanner.php" scrolling="auto">
    <frame name="main" src="<?php echo $page; ?>" scrolling="auto">
</frameset>
