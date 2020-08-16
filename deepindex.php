<?php
include("begin.php");
include($cms['tngpath'] . "genlib.php");
include($cms['tngpath'] . "adminlib.php");
$textpart = "index";
include("$mylanguage/admintext.php");

$admin_login = 1;
if ($link) {
  include("checklogin.php");
}
?>
<!-- frames -->
<frameset rows="54,*" cols="150,*" framespacing="0" frameborder="0">
    <frame name="corner" src="admin_corner.php" marginwidth="5" marginheight="2" leftmargin="5" rightmargin="5" topmargin="2" bottommargin="4" scrolling="no" frameborder="0">
    <frame name="rightbanner" src="admin_rightbanner.php" id="rightbanner" frameborder="0" scrolling="No" marginwidth="10" marginheight="5" leftmargin="10" rightmargin="0" topmargin="5" bottommargin="0">
    <frame name="leftbanner" src="admin_leftbanner.php" marginwidth="10" marginheight="10" leftmargin="10" topmargin="10" rightmargin="5" scrolling="auto" frameborder="0">
    <frame name="main" src="<?php echo $page; ?>" marginwidth="5" marginheight="5" leftmargin="5" rightmargin="0" topmargin="5" bottommargin="0" scrolling="auto" frameborder="0">
</frameset>
