<?php
global $allow_admin;
$tngconfig['showshare'] = false;
$flags = ['noicons' => true, 'noheader' => true, 'nobody' => true];
echo "<!doctype html>\n";
echo "<html lang='en'>\n";
$headElement = new HeadElementPublic($sitename ? "" : _("Our Family History"), $flags);
echo $headElement->getHtml();
standardHeaderVariants($headElement, $flags);
echo "<body id='bodytop' class='" . pathinfo(basename($_SERVER['SCRIPT_NAME']), PATHINFO_FILENAME) . "'>\n";
if ($tngconfig['maint']) {
    echo "<span class='fieldnameback yellow p-1'><strong>" . _("Maintenance Mode is ON") . "</strong></span><br><br>\n";
}
$title = getTemplateMessage('t1_maintitle');
?>
    <br>
    <div class="m-auto w-3/4">
        <table class="indexpage">
            <tr>
                <td colspan="3">
                    <img id="mainphoto" class="border-0 float-left" src="<?php echo $templatepath; ?><?php echo $tmp['t1_mainimage']; ?>" alt="">

                    <?php if ($tmp['t1_titlechoice'] == "text") { ?>
                        <em class="maintitle"><?php echo $title; ?></em>
                    <?php } else { ?>
                        <img class="ml-2" src="<?php echo $templatepath; ?><?php echo $tmp['t1_titleimage']; ?>" alt="">
                    <?php } ?>
                    <br>
                </td>
            </tr>
            <tr>
                <td class="normal align-top">
                    <?php
                    if ($currentuser) {
                        echo "<p><strong>" . _("Welcome") . ", $currentuserdesc.</strong></p>\n";
                    }
                    ?>
                    <h2><?php echo _("Search"); ?></h2>

                    <form name="searchform" action="search.php" method="get">
                        <label for="myfirstname"><?php echo _("First Name"); ?></label>
                        <input id="myfirstname" name="myfirstname" type="search" value="">
                        <label for="mylastname"><?php echo _("Last Name"); ?></label>
                        <input id="mylastname" name="mylastname" type="search" value="">
                        <input name="mybool" type="hidden" value="AND">
                        <input name="offset" type="hidden" value="0">
                        <input id="search-submit" type="submit" value="<?php echo _("Search"); ?>">
                    </form>

                    <br>
                    <?php
                    if ($chooselang) {
                        $query = "SELECT languageID, display, folder FROM $languages_table ORDER BY display";
                        $result = tng_query($query);
                        $numlangs = tng_num_rows($result);

                        if ($numlangs > 1) {
                            echo getFORM("savelanguage2", "get", "tngmenu3", "");
                            echo "<select id='newlanguage3' name='newlanguage3' style='font-size: smaller;' onchange='document.tngmenu3.submit();'>\n";

                            while ($row = tng_fetch_assoc($result)) {
                                echo "<option value='{$row['languageID']}'";
                                if ($languages_path . $row['folder'] == $mylanguage) {
                                    echo " selected";
                                }
                                echo ">{$row['display']}</option>\n";
                            }
                            echo "</select>\n";
                            echo "<input type='hidden' name='instance' value='3'>\n";
                            echo "</form>\n";
                        }
                        tng_free_result($result);
                    }
                    $mainpara = getTemplateMessage('t1_mainpara');
                    ?>
                </td>
                <td class="std-only">&nbsp;&nbsp;</td>
                <td class="normal std-only align-top">
                    <h2><?php echo _("Welcome"); ?></h2>
                    <?php
                    if ($mainpara) echo "<div>$mainpara</div>\n";

                    ?>
                    <h2><?php echo _("Other Features"); ?></h2>
                    <table class="w-full">
                        <tr>
                            <td class="align-top" style="width: 30%;">
                                <ul>
                                    <?php
                                    if ($currentuser) {
                                        echo "<li><a href='logout.php'>" . _("Log Out") . "</a></li>\n";
                                        if ($allow_admin) {
                                            echo "<li><a href='admin.php'>" . _("Administration") . "</a></li>\n";
                                        }
                                    } else {
                                        echo "<li><a href='login.php'>" . _("Log In") . "</a></li>\n";
                                        if (!$tngconfig['disallowreg']) {
                                            echo "<li><a href='newacctform.php'>" . _("Register for a User Account") . "</a></li>\n";
                                        }
                                    }
                                    echo "<li><a href='surnames.php'>" . _("Surnames") . "</a></li>\n";
                                    echo "<li><a href='searchform.php'>" . _("Advanced Search") . "</a></li>\n";
                                    echo "<li><a href='famsearchform.php'>" . _("Search Families") . "</a></li>\n";
                                    echo "<li><a href='searchsite.php'>" . _("Search Site") . "</a></li>\n";
                                    echo "<li><a href='places.php'>" . _("Places") . "</a></li>\n";
                                    echo "<li><a href='anniversaries.php'>" . _("Dates and Anniversaries") . "</a></li>\n";
                                    echo "<li><a href='calendar.php'>" . _("Calendar") . "</a></li>\n";
                                    echo "<li><a href='cemeteries.php'>" . _("Cemeteries") . "</a></li>\n";
                                    echo "<li><a href='bookmarks.php'>" . _("Bookmarks") . "</a></li>\n";
                                    ?>
                                </ul>
                            </td>
                            <td style="width: 5%;"></td>
                            <td class="align-top" style="width: 30%;">
                                <ul>
                                    <?php
                                    foreach ($mediatypes as $mediatype) {
                                        if (!$mediatype['disabled']) {
                                            echo "<li><a href='browsemedia.php?mediatypeID={$mediatype['ID']}'>{$mediatype['display']}</a></li>\n";
                                        }
                                    }
                                    echo "<li><a href='browsemedia.php'>" . _("All Media") . "</a></li>\n";
                                    echo "<li><a href='browsealbums.php'>" . _("Albums") . "</a></li>\n";
                                    ?>
                                </ul>
                            </td>
                            <td style="width: 5%;"></td>
                            <td class="align-top" style="width: 30%;">
                                <ul>
                                    <?php
                                    echo "<li><a href='whatsnew.php'>" . _("What's New") . "</a></li>\n";
                                    echo "<li><a href='mostwanted.php'>" . _("Most Wanted") . "</a></li>\n";
                                    echo "<li><a href='reports.php'>" . _("Reports") . "</a></li>\n";
                                    echo "<li><a href='statistics.php'>" . _("Statistics") . "</a></li>\n";
                                    echo "<li><a href='browsetrees.php'>" . _("Trees") . "</a></li>\n";
                                    echo "<li><a href='browsenotes.php'>" . _("Notes") . "</a></li>\n";
                                    echo "<li><a href='browsesources.php'>" . _("Sources") . "</a></li>\n";
                                    echo "<li><a href='browserepos.php'>" . _("Repositories") . "</a></li>\n";
                                    if (!$tngconfig['hidedna']) {
                                        echo "<li><a href='browse_dna_tests.php'>" . _("DNA Tests") . "</a></li>\n";
                                    }
                                    if ($allow_admin) {
                                        echo "<li><a href='showlog.php'>" . _("Access Log") . "</a></li>\n";
                                    }
                                    echo "<li><a href='suggest.php?page=$title'>" . _("Contact Us") . "</a></li>\n";
                                    ?>
                                </ul>
                                <br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <hr>
        <?php tng_footer(['basicfooter' => true]); ?>
    </div>
<?php echo "</body>\n"; ?>
<?php echo "</html>"; ?>