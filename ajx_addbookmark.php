<?php
include "begin.php";
include "genlib.php";
$textpart = "getperson";
include "getlang.php";
include "$mylanguage/text.php";

include "checklogin.php";

$newroot = preg_replace("/\//", "", $rootpath);
$newroot = preg_replace("/\s*/", "", $newroot);
$newroot = preg_replace("/\./", "", $newroot);
$ref = "tngbookmarks_$newroot";

$bookmarks = explode("|", $_COOKIE[$ref]);
$bookmarkstr = $_SESSION['tnglastpage'];
foreach ($bookmarks as $bookmark) {
    if ($bookmark && stripslashes($bookmark) != stripslashes($_SESSION['tnglastpage'])) {
        $bookmarkstr .= "|" . $bookmark;
    }
}

setcookie($ref, stripslashes($bookmarkstr), time() + 31536000, "/");

header("Content-type:text/html; charset=" . $session_charset);
?>

<div class="databack ajaxwindow" id="bkmkdiv">
    <h3 class="subhead"><img src="img/tng_bmk.gif" width="20" height="20" align="left" alt="" vspace="0">&nbsp;<?php echo $text['bookmarked']; ?></h3>
    <form>
        <input type="button" onclick="tnglitbox.remove();return false;" value="<?php echo $text['closewindow']; ?>">
        <input type="button" onclick="window.location.href='bookmarks.php';" value="<?php echo $text['mngbookmarks']; ?>">
    </form>
</div>