<?php
global $allow_admin;
$tngconfig['showshare'] = false;
$flags = ['noicons' => true, 'noheader' => true, 'nobody' => true];
echo "<!doctype html>\n";
echo "<html lang='en'>\n";
$headElement = new HeadElementPublic($sitename ? "" : _("Home Page"), $flags);
echo $headElement->getHtml();
standardHeaderVariants($headElement, $flags);
echo "<body id='bodytop' class='" . pathinfo(basename($_SERVER['SCRIPT_NAME']), PATHINFO_FILENAME) . "'>\n";
if ($tngconfig['maint']) {
    echo "<span class='fieldnameback yellow p-1'><strong>" . _("Maintenance Mode is ON") . "</strong></span><br><br>\n";
}
$dadlabel = getTemplateMessage('t14_dadside');
$momlabel = getTemplateMessage('t14_momside');
$title = getTemplateMessage('t14_maintitle');
$text['contactus_long'] = str_replace("suggest.php", "suggest.php?page=$title", $text['contactus_long']);
?>
    <div id="art-main">
        <div class="cleared reset-box"></div>
        <div class="art-nav">
            <div class="art-nav-outer">
                <div class="art-nav-wrapper">
                    <div class="art-nav-inner">
                        <ul class="art-hmenu">
                            <?php if ($dadlabel) { ?>
                                <li>
                                    <a href="pedigree.php?personID=<?php echo $tmp['t14_dadperson']; ?>&amp;tree=<?php echo $tmp['t14_dadtree']; ?>"><span
                                            class="l"></span><span class="r"></span><span
                                            class="t"><?php echo $dadlabel; ?></span></a>
                                </li>
                                <?php
                            }
                            if ($momlabel) {
                                ?>
                                <li>
                                    <a href="pedigree.php?personID=<?php echo $tmp['t14_momperson']; ?>&amp;tree=<?php echo $tmp['t14_momtree']; ?>"><span
                                            class="l"></span><span class="r"></span><span
                                            class="t"><?php echo $momlabel; ?></span></a>
                                </li>
                                <?php
                            }
                            if ($tmp['t14_featurelinks']) {
                                echo showLinks($tmp['t14_featurelinks'], false, "", "<span class='l'></span><span class='r'></span><span class='t'>xxx</span>");
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="cleared reset-box"></div>
        <div class="art-sheet">
            <div class="art-sheet-cc"></div>
            <div class="art-sheet-body">
                <div class="art-content-layout">
                    <div class="art-content-layout-row">
                        <div class="art-layout-cell art-content">
                            <div class="art-post">
                                <div class="art-post-body">
                                    <div class="art-post-inner art-article">
                                        <div class="art-postcontent">

                                            <div class="left-indent">
                                                <h1 class="big-header">
                                                    <?php echo $title; ?>
                                                </h1>
                                                <h2 class="subheader"><?php echo getTemplateMessage('t14_headsubtitle'); ?></h2>
                                                <hr>
                                            </div>

                                            <div class="art-block titlebox rounded-lg" id="tsearchbox">
                                                <div class="art-block-body">
                                                    <div class="art-blockheader">
                                                        <h2 class="site-head"><?php echo _("Search"); ?></h2>
                                                    </div>
                                                    <br>
                                                    <div class="art-blockcontent">
                                                        <div class="art-blockcontent-body">
                                                            <div>
                                                                <form name="searchform" action="search.php" method="get">
                                                                    <label for="myfirstname"><?php echo _("First Name"); ?></label>
                                                                    <input type="search" value="" name="myfirstname">
                                                                    <br>
                                                                    <label for="mylastname"><?php echo _("Last Name"); ?></label>
                                                                    <input type="search" value="" name="mylastname">
                                                                    <input type="hidden" name="mybool" value="AND">
                                                                    <input type="submit" id="search-submit" value="<?php echo _("Search"); ?>">
                                                                </form>

                                                                <br>
                                                                <ul class="home-menus">
                                                                    <li><a href="surnames.php"><?php echo _("Surnames"); ?></a></li>
                                                                    <li><a href="searchform.php"><?php echo _("Advanced Search"); ?></a></li>
                                                                </ul>

                                                                <br>
                                                                <?php
                                                                if ($currentuser) {
                                                                    echo "<p><strong>" . _("Welcome") . ", $currentuserdesc.</strong></p>\n";
                                                                    echo "<ul class='home-menus'>\n";

                                                                    echo "<li><a href='logout.php'>" . _("Log Out") . "</a></li>\n";
                                                                } else {
                                                                    echo "<ul class='home-menus'>\n";
                                                                    echo "<li><a href='login.php'>" . _("Log In") . "</a></li>";
                                                                    if (!$tngconfig['disallowreg']) {
                                                                        ?>
                                                                        <li><a href="newacctform.php"><?php echo _("Register for a User Account"); ?></a></li></p>
                                                                        <?php
                                                                    }
                                                                }

                                                                echo "</ul>\n";
                                                                ?>
                                                            </div>
                                                            <div class="cleared"></div>
                                                        </div>
                                                    </div>
                                                    <div class="cleared"></div>
                                                </div>
                                            </div>

                                            <table class="art-article">
                                                <tbody>
                                                <tr class="even">
                                                    <td>
                                                        <div class="left-indent">
                                                            <h3><?php echo getTemplateMessage('t14_welcome'); ?></h3>
                                                            <?php echo getTemplateMessage('t14_mainpara'); ?>
                                                        </div>
                                                        <div class="left-indent">
                                                            <h3><?php echo _("Contact Us"); ?></h3>
                                                            <p class="contact"><img src="<?php echo $templatepath; ?>img/email.gif"
                                                                    alt="email image"
                                                                    class="emailimg"><?php echo $text['contactus_long']; ?></p>
                                                        </div>
                                                        <?php if ($chooselang) { ?>
                                                            <div class="left-indent">
                                                                <br>
                                                                <?php
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
                                                                    echo "<input name='instance' type='hidden' value='3'>\n";
                                                                    echo "</form>\n";
                                                                }
                                                                tng_free_result($result);
                                                                ?>
                                                            </div>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>

                                        </div>
                                        <div class="cleared"></div>
                                    </div>

                                    <div class="cleared"></div>
                                </div>
                            </div>

                            <div class="cleared"></div>
                        </div>
                        <div class="art-layout-cell art-sidebar1" id="sidebar">
                            <img src="<?php echo $templatepath . $tmp['t14_mainimage']; ?>" alt="" id="mainphoto" class="rounded-lg"><br><br>
                            <i><?php echo getTemplateMessage('t14_photocaption'); ?></i>
                        </div>
                    </div>
                </div>
                <div class="cleared"></div>
            </div>
        </div>

        <div class="art-sheet" id="otherfeatures">
            <div class="art-sheet-cc"></div>
            <div class="art-sheet-body">
                <div class="art-footer">
                    <div class="art-footer-body">
                        <div class="art-footer-text">

                            <div id="linkarea">
                                <ul class="left-indent">
                                    <li class="linkcol" id="otherarea" style="width:25%;">
                                        <h2 class="site-head"><?php _("Other Features"); ?></h2>
                                        <hr class="bottomhr">
                                    </li>
                                    <li class="linkcol" style="width:75%;">
                                        <ul class="fancy_list">
                                            <li><a href="whatsnew.php"><?php echo _("What's New"); ?></a></li>
                                            <li><a href="mostwanted.php"><?php echo _("Most Wanted"); ?></a></li>
                                            <li><a href="places.php"><?php echo _("Places"); ?></a></li>
                                            <li><a href="browsenotes.php"><?php echo _("Notes"); ?></a></li>
                                            <li><a href="anniversaries.php"><?php echo _("Dates and Anniversaries"); ?></a></li>
                                            <li><a href="calendar.php"><?php echo _("Calendar"); ?></a></li>
                                            <li><a href="reports.php"><?php echo _("Reports"); ?></a></li>
                                            <li><a href="statistics.php"><?php echo _("Statistics"); ?></a></li>
                                            <?php
                                            foreach ($mediatypes as $mediatype) {
                                                if (!$mediatype['disabled']) {
                                                    echo "<li><a href='browsemedia.php?mediatypeID={$mediatype['ID']}'>{$mediatype['display']}</a></li>\n";
                                                }
                                            }
                                            ?>
                                            <li><a href="browsemedia.php"><?php echo _("All Media"); ?></a></li>
                                            <li><a href="browsealbums.php"><?php echo _("Albums"); ?></a></li>
                                            <li><a href="cemeteries.php"><?php echo _("Cemeteries"); ?></a></li>
                                            <li><a href="browsesources.php"><?php echo _("Sources"); ?></a></li>
                                            <li><a href="browserepos.php"><?php echo _("Repositories"); ?></a></li>
                                            <?php if (!$tngconfig['hidedna']) { ?>
                                                <li><a href="browse_dna_tests.php"><?php echo _("DNA Tests"); ?></a></li>
                                            <?php } ?>
                                            <li><a href="bookmarks.php"><?php echo _("Bookmarks"); ?></a></li>
                                            <?php if ($allow_admin) { ?>
                                                <li><a href="showlog.php"><?php echo _("Access Log"); ?></a></li>
                                                <li><a href="admin.php"><?php echo _("Administration"); ?></a></li>
                                            <?php } ?>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <div class="cleared"></div>
                        </div>
                        <div class="cleared"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="art-nav" style="margin-top:0;">
            <div class="art-nav-outer">
                <div class="art-nav-wrapper">
                    <div class="art-nav-inner">
                        <div class="t tngfooter">
                            <?php
                            $flags['basicfooter'] = true;
                            tng_footer($flags);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="cleared reset-box"></div>
        <br>

    </div>

    <script>
        document.forms.searchform.myfirstname.focus();
    </script>

<?php echo "</body>"; ?>
<?php echo "</html>"; ?>