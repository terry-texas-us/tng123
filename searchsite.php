<?php
$textpart = "search";
include "tng_begin.php";

//if required login, redirect to search people?
if ($requirelogin && !$currentuser) {
    header("Location: searchform.php");
    exit;
}
echo "<!doctype html>\n";
echo "<html lang='en'>\n";

tng_header($text['searchnames'], $flags);
?>
    <h2 class="header"><span class="headericon" id="searchsite-hdr-icon"></span><?php echo $text['searchsitemenu']; ?></h2>
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
            <label for="GoogleText" class="fieldnameback fieldname p-1"><?php echo $text['searchfor']; ?>:</label>
            <input id="GoogleText" class="<?php echo $fieldclass; ?>" name="s" type="search" placeholder="<?php echo $text['searchsite']; ?> ...">
        </div>
        <br><br>
        <p style="max-width:400px;"><?php echo $text['searchnote']; ?></p>
    </div>
    <div class="searchsidebar">
        <p class="normal">
            <input type="submit" id="searchbtn" class="btn" value="<?php echo $text['search']; ?>">
            <input type="reset" id="resetbtn" class="btn" value="<?php echo $text['tng_reset']; ?>">
        </p>
        <br><br>
        <p>
            <a href="searchform.php" class="snlink rounded">&raquo; <?php echo $text['searchnames']; ?></a>
            <a href="famsearchform.php" class="snlink rounded">&raquo; <?php echo $text['searchfams']; ?></a>
        </p>
    </div>
<?php echo "</form>\n"; ?>
    <div style="height: 200px;"></div>
    <br class="clear-both">
<?php tng_footer(""); ?>