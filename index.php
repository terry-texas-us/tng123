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
$headElement = new HeadElementPublic(_('Home Page'), $flags);
echo $headElement->getHtml();
standardHeaderVariants($headElement, $flags);
echo "<body id='bodytop' class='" . pathinfo(basename($_SERVER['SCRIPT_NAME']), PATHINFO_FILENAME) . "'>\n";
if ($tngconfig['maint']) {
    echo "<span class='fieldnameback yellow p-1'><strong>" . _('Maintenance Mode is ON') . "</strong></span><br><br>\n";
}
?>

<h1><?php echo _('Home Page'); ?></h1>

<?php
if ($currentuser) {
    echo "<p><strong>" . _('Welcome headline') . ", $currentuserdesc.</strong></p>\n";
}
?>
<h2><?php echo _('Search'); ?></h2>

<form name="searchform" action="search.php" method="get">
    <label for="myfirstname"><?php echo _('First Name'); ?></label>
    <input id="myfirstname" name="myfirstname" type="search">
    <label for="mylastname"><?php echo _('Last Name'); ?></label>
    <input id="mylastname" name="mylastname" type="search">
    <input name="mybool" type="hidden" value="AND">
    <input name="offset" type="hidden" value="0">
    <input name="search" type="submit" value="<?php echo _('Search'); ?>">
</form>
<hr>
<h2><?php echo _('Other Features'); ?></h2>

<ul>
    <?php
    if ($currentuser) { // this means you're logged in
        echo "<li><a href='logout.php'>" . _('Log Out') . "</a></li>\n";
    } else {
        echo "<li><a href='login.php'>" . _('Log In') . "</a></li>\n";
    }
    echo "<li><a href='newacctform.php'>" . _('Register for a User Account') . "</a></li>\n";
    echo "<li><a href='searchform.php'>" . _('Advanced Search') . "</a></li>\n";
    echo "<li><a href='surnames.php'>" . _('Surnames') . "</a></li>\n";
    echo "<li><a href='bookmarks.php'>" . _('Bookmarks') . "</a></li>\n";
    echo "<li><a href='statistics.php'>" . _('Statistics') . "</a></li>\n";
    echo "<li><a href='browsemedia.php?mediatypeID=photos'>" . _('Photos') . "</a></li>\n";
    echo "<li><a href='browsemedia.php?mediatypeID=histories'>" . _('Histories') . "</a></li>\n";
    echo "<li><a href='browsemedia.php?mediatypeID=documents'>" . _('Documents') . "</a></li>\n";
    echo "<li><a href='browsemedia.php?mediatypeID=videos'>" . _('Videos') . "</a></li>\n";
    echo "<li><a href='browsemedia.php?mediatypeID=recordings'>" . _('Recordings') . "</a></li>\n";
    echo "<li><a href='browsealbums.php'>" . _('Albums') . "</a></li>\n";
    echo "<li><a href='browsemedia.php'>" . _('All Media') . "</a></li>\n";
    echo "<li><a href='cemeteries.php'>" . _('Cemeteries') . "</a></li>\n";
    echo "<li><a href='browsemedia.php?mediatypeID=headstones'>" . _('Headstones') . "</a></li>\n";
    echo "<li><a href='places.php'>" . _('Places') . "</a></li>\n";
    echo "<li><a href='browsenotes.php'>" . _('Notes') . "</a></li>\n";
    echo "<li><a href='anniversaries.php'>" . _('Dates and Anniversaries') . "</a></li>\n";
    echo "<li><a href='reports.php'>" . _('Reports') . "</a></li>\n";
    echo "<li><a href='browsesources.php'>" . _('Sources') . "</a></li>\n";
    echo "<li><a href='browserepos.php'>" . _('Repositories') . "</a></li>\n";
    echo "<li><a href='whatsnew.php'>{_('What\'s New')}</a></li>\n";
    echo "<li><a href='mostwanted.php'>" . _('Most Wanted') . "</a></li>\n";
    echo "<li><a href='changelanguage.php'>" . _('Change Language') . "</a></li>\n";

    if ($allow_admin) {
        echo "<li><a href='showlog.php'>" . _('Access Log') . "</a></li>\n";
        echo "<li><a href='admin.php'>" . _('Administration') . "</a></li>\n";
    }
    echo "<li><a href='suggest.php'>" . _('Contact Us') . "</a></li>\n";
    ?>
</ul>

<p><strong>Please customize this page!</strong></p>

<?php echo "</body>"; ?>
<?php echo "</html>"; ?>
