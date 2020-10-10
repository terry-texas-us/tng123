<?php

global $allow_admin;

$tngconfig['showshare'] = false;
$flags = ['noicons' => true, 'noheader' => true, 'nobody' => true];

echo "<!doctype html>\n";
echo "<html lang='en'>\n";

$headElement = new HeadElementPublic($sitename ? "" : $text['ourhist'], $flags);
echo $headElement->getHtml();
if (isMobile()) {
    mobileHeaderVariants($headElement, $flags);
} else {
    standardHeaderVariants($headElement, $flags);
    echo "<body id='bodytop' class='" . pathinfo(basename($_SERVER['SCRIPT_NAME']), PATHINFO_FILENAME) . " homebody'>\n";
}
if ($tngconfig['maint']) {
    echo "<span class='fieldnameback yellow p-1'><strong>{$text['mainton']}</strong></span><br><br>\n";
}
$title = getTemplateMessage('t3_maintitle');
?>
    <div class="text-center">
        <div class="indexpage" style="display: table;">
            <?php if ($tmp['t3_titlechoice'] == "text" || isMobile()) { ?>
                <div style="padding:10px;">
                    <em class="maintitle"><?php echo $title; ?></em>
                </div>
            <?php } else { ?>
                <img src="<?php echo $templatepath; ?><?php echo $tmp['t3_titleimage']; ?>" alt="" class="titleimg" width="630" height="93">
            <?php } ?>
            <div id="tcontainer">
                <img src="<?php echo $templatepath; ?><?php echo $tmp['t3_mainimage']; ?>" alt="" class="mainimg">
                <div id="searchpane"><br>
                    <h2 class="header"><?php echo $text['mnusearchfornames']; ?></h2>

                    <form id="form1" action="search.php" method="get">
                        <label class="normal" for="myfirstname"><?php echo $text['mnufirstname']; ?>:</label>
                        <br>
                        <input id="myfirstname" name="myfirstname" type="search">
                        <br>
                        <label class="normal" for="mylastname"><?php echo $text['mnulastname']; ?>:</label>
                        <br>
                        <input id="mylastname" name="mylastname" type="search">
                        <br>
                        <input name="mybool" type="hidden" value="AND">
                        <input name="offset" type="hidden" value="0">
                        <input name="search" type="submit" value="<?php echo $text['mnusearchfornames']; ?>">
                    </form>
                    <br>
                    <div class="subheader">
                        <a href="searchform.php"><?php echo $text['mnuadvancedsearch']; ?></a><br>
                        <a href="surnames.php"><?php echo $text['mnulastnames']; ?></a><br><br>
                        <?php
                        if ($currentuser) {
                            echo "<p><strong>{$text['welcome']}, $currentuserdesc.</strong></p>\n";
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
        if (!isMobile()) {
            ?>
            <div class="mainmenu">
                <br>
                <a href="whatsnew.php"><?php echo $text['mnuwhatsnew']; ?></a> &nbsp;|&nbsp;
                <?php
                foreach ($mediatypes as $mediatype) {
                    if (!$mediatype['disabled']) {
                        echo "<a href='browsemedia.php?mediatypeID={$mediatype['ID']}'>{$mediatype['display']}</a> &nbsp;|&nbsp;\n";
                    }
                }
                ?>
                <a href="browsealbums.php"><?php echo $text['albums']; ?></a> &nbsp;|&nbsp;
                <a href="browsemedia.php"><?php echo $text['allmedia']; ?></a>

                <br>
                <a href="mostwanted.php"><?php echo $text['mostwanted']; ?></a> &nbsp;|&nbsp;
                <a href="cemeteries.php"><?php echo $text['mnucemeteries']; ?></a> &nbsp;|&nbsp;
                <a href="browsemedia.php?mediatypeID=headstones"><?php echo $text['mnutombstones']; ?></a> &nbsp;|&nbsp;
                <a href="places.php"><?php echo $text['places']; ?></a> &nbsp;|&nbsp;
                <a href="anniversaries.php"><?php echo $text['anniversaries']; ?></a> &nbsp;|&nbsp;
                <a href="calendar.php"><?php echo $text['calendar']; ?></a>

                <br>
                <a href="browsesources.php"><?php echo $text['mnusources']; ?></a> &nbsp;|&nbsp;
                <a href="browserepos.php"><?php echo $text['repositories']; ?></a> &nbsp;|&nbsp;
                <?php if (!$tngconfig['hidedna']) { ?>
                    <a href="browse_dna_tests.php"><?php echo $text['dna_tests']; ?></a> &nbsp;|&nbsp;
                <?php } ?>
                <a href="reports.php"><?php echo $text['mnureports']; ?></a> &nbsp;|&nbsp;
                <a href="browsenotes.php"><?php echo $text['notes']; ?></a> &nbsp;|&nbsp;
                <a href="bookmarks.php"><?php echo $text['bookmarks']; ?></a> &nbsp;|&nbsp;
                <a href="statistics.php"><?php echo $text['mnustatistics']; ?></a>
                <br>
                <?php
                if ($currentuser) {
                    echo "<a href='logout.php'>{$text['mnulogout']}</a> &nbsp;|&nbsp;\n";
                } else {
                    echo "<a href='login.php'>{$text['mnulogon']}</a> &nbsp;|&nbsp;\n";
                }

                if ($allow_admin) {
                    echo "<a href='showlog.php'>{$text['mnushowlog']}</a> &nbsp;|&nbsp;\n";
                    echo "<a href='admin.php'>{$text['mnuadmin']}</a> &nbsp;|&nbsp;\n";
                }
                if (!$currentuser && !$tngconfig['disallowreg']) {
                    ?>
                    <a href="newacctform.php"><?php echo $text['mnuregister']; ?></a> &nbsp;|&nbsp;
                <?php } ?>
                <a href="suggest.php?page=<?php echo $title; ?>"><?php echo $text['contactus']; ?></a>
            </div>
        <?php } ?>
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