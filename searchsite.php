<?php
$textpart = "search";
include "tng_begin.php";

//if required login, redirect to search people?
if ($requirelogin && !$currentuser) {
    header("Location: searchform.php");
    exit;
}
tng_header(_('Search People'), $flags);
?>
    <h2 class="header"><span class="headericon" id="searchsite-hdr-icon"></span><?php echo _('Search Site'); ?></h2>
    <br class="clear-both">
<?php
if ($msg) {
    echo "<h3 id='errormsg' class='msgerror subhead'>" . stripslashes(strip_tags($msg)) . "</h3>";
}
$fieldclass = "longfield";

$onsubmit = "return searchGoogleWebSite('" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "')";
echo getFORM("", "GET", "searchsite", "", $onsubmit);
?>
    <div class="searchformbox">
        <div class="normal">
            <label for="GoogleText" class="fieldnameback fieldname p-1"><?php echo _('Search for'); ?>:</label>
            <input id="GoogleText" class="<?php echo $fieldclass; ?>" name="s" type="search" placeholder="<?php echo _('Search this site'); ?> ...">
        </div>
        <br><br>
        <p style="max-width:400px;"><?php echo _('Note: This page uses Google to perform its search. The number of matches returned will be directly affected by the extent to which Google has been able to index the site.'); ?></p>
    </div>
    <div class="searchsidebar">
        <p class="normal">
            <input type="submit" id="searchbtn" class="btn" value="<?php echo _('Search'); ?>">
            <input type="reset" id="resetbtn" class="btn" value="<?php echo _('Reset'); ?>">
        </p>
        <br><br>
        <p>
            <a href="searchform.php" class="snlink rounded">&raquo; <?php echo _('Search People'); ?></a>
            <a href="famsearchform.php" class="snlink rounded">&raquo; <?php echo _('Search Families'); ?></a>
        </p>
    </div>
<?php echo "</form>\n"; ?>
    <div style="height: 200px;"></div>
    <br class="clear-both">
<?php tng_footer(""); ?>