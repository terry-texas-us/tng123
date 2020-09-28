<?php
include "tng_begin.php";

initMediaTypes();

if ($templateswitching && $templatenum) {
    include "templates/$templatepfx$templatenum/index.php";
    exit;
}

echo "<!doctype html>\n";
echo "<html lang='en'>\n";

$flags = ['noicons' => true, 'noheader' => true];
$headElement = new HeadElementPublic($text['mnuheader'], $flags);

echo $headElement->getHtml();

if (isMobile()) {
    mobileHeaderVariants($headElement, $flags);
} else {
    standardHeaderVariants($headElement, $flags);
    echo "<body id='bodytop' class='" . pathinfo(basename($_SERVER['SCRIPT_NAME']), PATHINFO_FILENAME) . "'>\n";
}
if ($tngconfig['maint']) {
    echo "<span class='fieldnameback yellow p-1'><strong>{$text['mainton']}</strong></span><br><br>\n";
}

?>

<h1><?php echo $text['mnuheader']; ?></h1>

<?php
if ($currentuser) {
    echo "<p><strong>{$text['welcome']}, $currentuserdesc.</strong></p>\n";
}
?>
<h2><?php echo $text['mnusearchfornames']; ?></h2>

<form name="searchform" action="search.php" method="get">
    <label for="myfirstname"><?php echo $text['firstname']; ?></label>
    <input id="myfirstname" name="myfirstname" type="search">
    <label for="mylastname"><?php echo $text['lastname']; ?></label>
    <input id="mylastname" name="mylastname" type="search">
    <input name="mybool" type="hidden" value="AND">
    <input name="offset" type="hidden" value="0">
    <input name="search" type="submit" value="<?php echo $text['search']; ?>">
</form>
<hr>
<h2><?php echo $text['mnufeatures']; ?></h2>

<ul>
    <?php
    if ($currentuser) { // this means you're logged in
        echo "<li><a href='logout.php'>{$text['mnulogout']}</a></li>\n";
    } else {
        echo "<li><a href='login.php'>{$text['mnulogon']}</a></li>\n";
    }
    echo "<li><a href='newacctform.php'>{$text['mnuregister']}</a></li>\n";
    echo "<li><a href='searchform.php'>{$text['mnuadvancedsearch']}</a></li>\n";
    echo "<li><a href='surnames.php'>{$text['mnulastnames']}</a></li>\n";
    echo "<li><a href='bookmarks.php'>{$text['bookmarks']}</a></li>\n";
    echo "<li><a href='statistics.php'>{$text['mnustatistics']}</a></li>\n";
    echo "<li><a href='browsemedia.php?mediatypeID=photos'>{$text['mnuphotos']}</a></li>\n";
    echo "<li><a href='browsemedia.php?mediatypeID=histories'>{$text['mnuhistories']}</a></li>\n";
    echo "<li><a href='browsemedia.php?mediatypeID=documents'>{$text['documents']}</a></li>\n";
    echo "<li><a href='browsemedia.php?mediatypeID=videos'>{$text['videos']}</a></li>\n";
    echo "<li><a href='browsemedia.php?mediatypeID=recordings'>{$text['recordings']}</a></li>\n";
    echo "<li><a href='browsealbums.php'>{$text['albums']}</a></li>\n";
    echo "<li><a href='browsemedia.php'>{$text['allmedia']}</a></li>\n";
    echo "<li><a href='cemeteries.php'>{$text['mnucemeteries']}</a></li>\n";
    echo "<li><a href='browsemedia.php?mediatypeID=headstones'>{$text['mnutombstones']}</a></li>\n";
    echo "<li><a href='places.php'>{$text['places']}</a></li>\n";
    echo "<li><a href='browsenotes.php'>{$text['notes']}</a></li>\n";
    echo "<li><a href='anniversaries.php'>{$text['anniversaries']}</a></li>\n";
    echo "<li><a href='reports.php'>{$text['mnureports']}</a></li>\n";
    echo "<li><a href='browsesources.php'>{$text['mnusources']}</a></li>\n";
    echo "<li><a href='browserepos.php'>{$text['repositories']}</a></li>\n";
    echo "<li><a href='whatsnew.php'>{$text['mnuwhatsnew']}</a></li>\n";
    echo "<li><a href='mostwanted.php'>{$text['mostwanted']}</a></li>\n";
    echo "<li><a href='changelanguage.php'>{$text['mnulanguage']}</a></li>\n";

    if ($allow_admin) {
        echo "<li><a href='showlog.php'>{$text['mnushowlog']}</a></li>\n";
        echo "<li><a href='admin.php'>{$text['mnuadmin']}</a></li>\n";
    }
    echo "<li><a href='suggest.php'>{$text['contactus']}</a></li>\n";
    ?>
</ul>

<p><strong>Please customize this page!</strong></p>

<?php echo "</body>"; ?>
<?php echo "</html>"; ?>
