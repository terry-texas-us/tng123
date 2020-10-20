<?php

global $allow_admin;

$tngconfig['showshare'] = false;
$flags = ['noicons' => true, 'noheader' => true, 'nobody' => true];

echo "<!doctype html>\n";
echo "<html lang='en'>\n";

$headElement = new HeadElementPublic($sitename ? "" : $tmp['t5_maintitle'], $flags);
echo $headElement->getHtml();
if (isMobile()) {
    mobileHeaderVariants($headElement, $flags);
} else {
    standardHeaderVariants($headElement, $flags);
    echo "<body id='bodytop' class='" . pathinfo(basename($_SERVER['SCRIPT_NAME']), PATHINFO_FILENAME) . " mt-2'>\n";
}
if ($tngconfig['maint']) {
    echo "<span class='fieldnameback yellow p-1'><strong>{$text['mainton']}</strong></span><br><br>\n";
}
$title = getTemplateMessage('t5_maintitle');
$text['contactus_long'] = str_replace("suggest.php", "suggest.php?page=$title", $text['contactus_long']);
?>
    <div class="text-center">
        <table class="maintable">
            <tr>
                <td class="row-5" colspan="4"></td>
            </tr>
            <tr>
                <td class="imagesection">
                </td>
                <td class="spacercol">
                </td>
                <td class="content" colspan="2">

                    <table class="innertable w-full" cellpadding="5" cellspacing="0">
                        <tr>
                            <td colspan="2" class="indexheader">
                                <?php echo $title; ?> <!-- Our Family History and Ancestry -->
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="boxback">
                                <div id="menubar">
                                    <a href="whatsnew.php" class="lightlink2"><?php echo $text['mnuwhatsnew']; ?></a>
                                    <?php
                                    foreach ($mediatypes as $mediatype) {
                                        if (!$mediatype['disabled']) {
                                            echo "| <a href='browsemedia.php?mediatypeID={$mediatype['ID']}' class='lightlink2'>{$mediatype['display']}</a>\n";
                                        }
                                    }
                                    ?>
                                    | <a href="browsealbums.php" class="lightlink2"><?php echo $text['albums']; ?></a>
                                    | <a href="browsemedia.php" class="lightlink2"><?php echo $text['allmedia']; ?></a><br>

                                    <a href="mostwanted.php" class="lightlink2"><?php echo $text['mostwanted']; ?></a>
                                    | <a href="reports.php" class="lightlink2"><?php echo $text['mnureports']; ?></a>
                                    | <a href="cemeteries.php" class="lightlink2"><?php echo $text['mnucemeteries']; ?></a>
                                    | <a href="anniversaries.php" class="lightlink2"><?php echo $text['anniversaries']; ?></a>
                                    | <a href="calendar.php" class="lightlink2"><?php echo $text['calendar']; ?></a>
                                    | <a href="places.php" class="lightlink2"><?php echo $text['places']; ?></a><br>

                                    <a href="browsenotes.php" class="lightlink2"><?php echo $text['notes']; ?></a>
                                    | <a href="browsesources.php" class="lightlink2"><?php echo $text['mnusources']; ?></a>
                                    | <a href="browserepos.php" class="lightlink2"><?php echo $text['repositories']; ?></a>
                                    <?php if (!$tngconfig['hidedna']) { ?>
                                        | <a href="browse_dna_tests.php" class="lightlink2"><?php echo $text['dna_tests']; ?></a>
                                    <?php } ?>
                                    | <a href="statistics.php" class="lightlink2"><?php echo $text['mnustatistics']; ?></a>
                                    | <a href="bookmarks.php" class="lightlink2"><?php echo $text['bookmarks']; ?></a>
                                    | <a href="suggest.php" class="lightlink2"><?php echo $text['contactus']; ?></a>
                                    <?php
                                    if ($allow_admin) {
                                        echo "| <a href='showlog.php' class='lightlink2'>{$text['mnushowlog']}</a>\n";
                                        echo "| <a href='admin.php' class='lightlink2'>{$text['mnuadmin']}</a>\n";
                                    }
                                    ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="leftcontent">
                                    <div class="theader">
                                        <h1><?php echo $text['welcome']; ?>!</h1>
                                    </div>
                                    <div class="normal">
                                        <?php echo getTemplateMessage('t5_mainpara'); ?>
                                        <p><?php echo $text['contactus_long']; ?></p>
                                        <ul>
                                            <?php
                                            if (!$currentuser) {
                                                if (!$tngconfig['disallowreg']) {
                                                    echo "<li><a href='newacctform.php'>{$text['mnuregister']}</a></li>\n";
                                                }
                                                echo "<li><a href='login.php'>{$text['mnulogon']}</a></li>\n";
                                            } else {
                                                echo "<li><a href='logout.php'>{$text['mnulogout']}</a></li>\n";
                                            }
                                            if ($chooselang) {
                                                echo "<li><a href='changelanguage.php'>{$text['mnulanguage']}</a></li>\n";
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                                <div class="rightcontent">
                                    <img src="<?php echo $templatepath; ?><?php echo $tmp['t5_mainimage']; ?>" alt=""
                                        class="indexphoto"><br><br>
                                    <span class="right" style="margin-right:8px;"><?php echo $text['whichbranch']; ?></span>
                                </div>
                                <div class="rightcontent">
                                    <form action="search.php" method="get">
                                        <table class="indexbox rounded" id="searchbox">
                                            <tr>
                                                <td class="padding">
                                                    <label><?php echo $text['mnufirstname']; ?>:<br>
                                                        <input type="search" name="myfirstname" class="searchbox">
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="padding">
                                                    <label><?php echo $text['mnulastname']; ?>:<br>
                                                        <input type="search" name="mylastname" class="searchbox">
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="padding">
                                                    <span class="normal">
                                                        <input type="hidden" name="mybool" value="AND">
                                                        <input type="submit" name="search" value="<?php echo $text['mnusearchfornames']; ?>"><br><br>
						                                <?php echo "<a href='surnames.php' class='lightlink2'>{$text['mnulastnames']}</a><br>\n"; ?>
                                                        <?php echo "<a href='searchform.php' class='lightlink2'>{$text['mnuadvancedsearch']}</a>\n"; ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        </table>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="4" class="row12"></td>
            </tr>
        </table>
        <br>
        <div class="footer small">
            <?php
            $flags['basicfooter'] = true;
            tng_footer($flags);
            ?>
        </div>
    </div>

<?php echo "</body>"; ?>
<?php echo "</html>"; ?>