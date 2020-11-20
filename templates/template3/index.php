<?php

global $allow_admin;
$tngconfig['showshare'] = false;
$flags = ['noicons' => true, 'noheader' => true, 'nobody' => true];
echo "<!doctype html>\n";
echo "<html lang='en'>\n";
$headElement = new HeadElementPublic($sitename ? "" : _("Our Family History"), $flags);
echo $headElement->getHtml();
standardHeaderVariants($headElement, $flags);
echo "<body id='bodytop' class='" . pathinfo(basename($_SERVER['SCRIPT_NAME']), PATHINFO_FILENAME) . " homebody'>\n";
if ($tngconfig['maint']) {
    echo "<span class='fieldnameback yellow p-1'><strong>" . _("Maintenance Mode is ON") . "</strong></span><br><br>\n";
}
$title = getTemplateMessage('t3_maintitle');
?>
    <div class="text-center">
        <div class="indexpage" style="display: table;">
            <?php if ($tmp['t3_titlechoice'] == "text") { ?>
                <div style="padding:10px;">
                    <em class="maintitle"><?php echo $title; ?></em>
                </div>
            <?php } else { ?>
                <img src="<?php echo $templatepath; ?><?php echo $tmp['t3_titleimage']; ?>" alt="" class="titleimg" width="630" height="93">
            <?php } ?>
            <div id="tcontainer">
                <img src="<?php echo $templatepath; ?><?php echo $tmp['t3_mainimage']; ?>" alt="" class="mainimg">
                <div id="searchpane"><br>
                    <h2 class="header"><?php echo _("Search"); ?></h2>

                    <form id="form1" action="search.php" method="get">
                        <label class="normal" for="myfirstname"><?php echo _("First Name"); ?>:</label>
                        <br>
                        <input id="myfirstname" name="myfirstname" type="search">
                        <br>
                        <label class="normal" for="mylastname"><?php echo _("Last Name"); ?>:</label>
                        <br>
                        <input id="mylastname" name="mylastname" type="search">
                        <br>
                        <input name="mybool" type="hidden" value="AND">
                        <input name="offset" type="hidden" value="0">
                        <input name="search" type="submit" value="<?php echo _("Search"); ?>">
                    </form>
                    <br>
                    <div class="subheader">
                        <a href="searchform.php"><?php echo _("Advanced Search"); ?></a><br>
                        <a href="surnames.php"><?php echo _("Surnames"); ?></a><br><br>
                        <?php
                        if ($currentuser) {
                            echo "<p><strong>" . _("Welcome") . ", $currentuserdesc.</strong></p>\n";
                        }
                        if ($chooselang) {
                            $query = "SELECT languageID, display, folder FROM $languages_table ORDER BY display";
                            $result = tng_query($query);
                            $numlangs = tng_num_rows($result);

                            if ($numlangs > 1) {
                                echo getFORM("savelanguage2", "get", "tngmenu3", "");
                                echo "<select id='newlanguage3' name='newlanguage3' style='font-size: smaller;' onchange='document.tngmenu3.submit();'>";

                                while ($row = tng_fetch_assoc($result)) {
                                    echo "<option value='{$row['languageID']}'";
                                    if ($languages_path . $row['folder'] == $mylanguage) {
                                        echo " selected";
                                    }
                                    echo ">{$row['display']}</option>\n";
                                }
                                echo "</select>\n";
                                echo "<input name='instance' type='hidden' value='3'>";
                                echo "</form>\n";
                            }
                            tng_free_result($result);
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $mainpara = getTemplateMessage('t3_mainpara');
        if ($mainpara) {
            echo "<br><div class='tcontainer'><div style='display: inline-block; max-width: 700px; text-align: left;'>$mainpara</div></div>\n";
        }
        ?>
        <div class="mainmenu">
            <br>
            <a href="whatsnew.php"><?php echo _("What's New"); ?></a> &nbsp;|&nbsp;
            <?php
            foreach ($mediatypes as $mediatype) {
                if (!$mediatype['disabled']) {
                    echo "<a href='browsemedia.php?mediatypeID={$mediatype['ID']}'>{$mediatype['display']}</a> &nbsp;|&nbsp;\n";
                }
            }
            ?>
            <a href="browsealbums.php"><?php echo _("Albums"); ?></a> &nbsp;|&nbsp;
            <a href="browsemedia.php"><?php echo _("All Media"); ?></a>

            <br>
            <a href="mostwanted.php"><?php echo _("Most Wanted"); ?></a> &nbsp;|&nbsp;
            <a href="cemeteries.php"><?php echo _("Cemeteries"); ?></a> &nbsp;|&nbsp;
            <a href="browsemedia.php?mediatypeID=headstones"><?php echo _("Headstones"); ?></a> &nbsp;|&nbsp;
            <a href="places.php"><?php echo _("Places"); ?></a> &nbsp;|&nbsp;
            <a href="anniversaries.php"><?php echo _("Dates and Anniversaries"); ?></a> &nbsp;|&nbsp;
            <a href="calendar.php"><?php echo _("Calendar"); ?></a>

            <br>
            <a href="browsesources.php"><?php echo _("Sources"); ?></a> &nbsp;|&nbsp;
            <a href="browserepos.php"><?php echo _("Repositories"); ?></a> &nbsp;|&nbsp;
            <?php if (!$tngconfig['hidedna']) { ?>
                <a href="browse_dna_tests.php"><?php echo _("DNA Tests"); ?></a> &nbsp;|&nbsp;
            <?php } ?>
            <a href="reports.php"><?php echo _("Reports"); ?></a> &nbsp;|&nbsp;
            <a href="browsenotes.php"><?php echo _("Notes"); ?></a> &nbsp;|&nbsp;
            <a href="bookmarks.php"><?php echo _("Bookmarks"); ?></a> &nbsp;|&nbsp;
            <a href="statistics.php"><?php echo _("Statistics"); ?></a>
            <br>
            <?php
            if ($currentuser) {
                echo "<a href='logout.php'>" . _("Log Out") . "</a> &nbsp;|&nbsp;\n";
            } else {
                echo "<a href='login.php'>" . _("Log In") . "</a> &nbsp;|&nbsp;\n";
            }
            if ($allow_admin) {
                echo "<a href='showlog.php'>" . _("Access Log") . "</a> &nbsp;|&nbsp;\n";
                echo "<a href='admin.php'>" . _("Administration") . "</a> &nbsp;|&nbsp;\n";
            }
            if (!$currentuser && !$tngconfig['disallowreg']) {
                ?>
                <a href="newacctform.php"><?php echo _("Register for a User Account"); ?></a> &nbsp;|&nbsp;
            <?php } ?>
            <a href="suggest.php?page=<?php echo $title; ?>"><?php echo _("Contact Us"); ?></a>
        </div>
        <div class="footer" style="text-align: center;">
            <br><br>

            <?php
            $flags['basicfooter'] = true;
            tng_footer($flags);
            ?>
        </div>
    </div>
    <script>
        document.forms.form1.mylastname.focus();
    </script>

<?php echo "</body>"; ?>
<?php echo "</html>"; ?>