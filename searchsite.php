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
    <br style="clear: both;">
<?php
if ($msg) {
    echo "<h3 id='errormsg' class='msgerror subhead'>" . stripslashes(strip_tags($msg)) . "</h3>";
}

$fieldclass = $sitever == "mobile" ? "medfield" : "longfield";

$onsubmit = "return searchGoogleWebSite('" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "')";
$formstr = getFORM("", "GET", "searchsite", "", $onsubmit);
echo $formstr;
?>
    <div class="searchformbox">
        <table cellspacing="1" cellpadding="4" class="normal">
            <tr>
                <td class="fieldnameback fieldname"><?php echo $text['searchfor']; ?>:</td>
                <td class="databack">
                    <input type="text" name="s" id="GoogleText" type="search" class="<?php echo $fieldclass; ?>">
                </td>
            </tr>
        </table>

        <?php
        if ($sitever != "mobile") {
            echo "<br><br>\n";
        }
        ?>
        <p style="max-width:400px;"><?php echo $text['searchnote']; ?></p>
    </div>

    <div class="searchsidebar">
        <p class="normal">
            <input type="submit" id="searchbtn" class="btn" value="<?php echo $text['search']; ?>">
            <input type="reset" id="resetbtn" class="btn" value="<?php echo $text['tng_reset']; ?>">
        </p>
        <br><br>
        <p>
            <a href="searchform.php" class="snlink">&raquo; <?php echo $text['searchnames']; ?></a>
            <a href="famsearchform.php" class="snlink">&raquo; <?php echo $text['searchfams']; ?></a>
        </p>
    </div>

    </form>
    <div style="height:200px;"></div>
    <br style="clear: both;">
<?php
tng_footer("");
?>