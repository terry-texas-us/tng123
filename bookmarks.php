<?php
$textpart = "getperson";
include "tng_begin.php";

$newroot = preg_replace("/\//", "", $rootpath);
$newroot = preg_replace("/ /", "", $newroot);
$newroot = preg_replace("/\./", "", $newroot);
$ref = "tngbookmarks_$newroot";

echo "<!doctype html>\n";
echo "<html lang='en'>\n";

tng_header($text['bookmarks'], $flags);
?>
<!-- DED added alt='' & changed span to div in next line-->
<h2 class="header"><span class="headericon" id="bookmarks-hdr-icon"></span><?php echo $text['bookmarks']; ?></h2>
<br style="clear: left;">
<?php
echo "<p class='normal'>" . $text['bkmkvis'] . "</p>";

echo "<ul class='normal'>\n";
if (isset($_COOKIE[$ref])) {
    $bcount = 0;
    $bookmarks = explode("|", $_COOKIE[$ref]);
    foreach ($bookmarks as $bookmark) {
        if (trim($bookmark)) {
            echo "<li>" . stripslashes($bookmark) . " | <a href=\"ajx_deletebookmark.php?idx=$bcount\">{$text['remove']}</a></li>\n";
            $bcount++;
        }
    }
} else {
    echo "<li>0 {$text['bookmarks']}</li>";
}
echo "</ul><br>\n";
tng_footer("");
?>
