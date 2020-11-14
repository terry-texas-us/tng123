<?php
$textpart = "getperson";
include "tng_begin.php";

$newroot = preg_replace("/\//", "", $rootpath);
$newroot = preg_replace("/ /", "", $newroot);
$newroot = preg_replace("/\./", "", $newroot);
$ref = "tngbookmarks_$newroot";

tng_header(_('Bookmarks'), $flags);
?>
<!-- DED added alt='' & changed span to div in next line-->
<h2 class="header"><span class="headericon" id="bookmarks-hdr-icon"></span><?php echo _('Bookmarks'); ?></h2>
<br style="clear: left;">
<?php
echo "<p class='normal'>" . _('<strong>Note:</strong> These bookmarks are only visible on this computer and in this browser.') . "</p>";

echo "<ul class='normal'>\n";
if (isset($_COOKIE[$ref])) {
    $bcount = 0;
    $bookmarks = explode("|", $_COOKIE[$ref]);
    foreach ($bookmarks as $bookmark) {
        if (trim($bookmark)) {
            echo "<li>" . stripslashes($bookmark) . " | <a href=\"ajx_deletebookmark.php?idx=$bcount\">" . _('Remove') . "</a></li>\n";
            $bcount++;
        }
    }
} else {
    echo "<li>0 " . _('Bookmarks') . "</li>";
}
echo "</ul><br>\n";
tng_footer("");
?>
