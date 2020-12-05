<?php
global $allow_admin;
$flags = ['noicons' => true, 'noheader' => true, 'nobody' => true];

$flags['style'] = "<style>\n";
$flags['style'] .= "body {background-image: url('{$templatepath}img/Bottom_texture.jpg'); background-repeat: repeat; background-attachment: fixed; background-position: top left;}\n";
$flags['style'] .= "div.art-headerobject {background-image: url('$templatepath{$tmp['t9_headimg']}'); background-repeat: no-repeat; width: 432px; height: 150px;}\n";
$flags['style'] .= "</style>\n";
echo "<!doctype html>\n";
echo "<html lang='en'>\n";
$headElement = new HeadElementPublic($sitename ? "" : _("Our Family History"), $flags);
echo $headElement->getHtml();
standardHeaderVariants($headElement, $flags);
echo "<body id='bodytop' class='" . pathinfo(basename($_SERVER['SCRIPT_NAME']), PATHINFO_FILENAME) . "'>\n";
if ($tngconfig['maint']) {
    echo "<span class='p-1 fieldnameback yellow'><strong>" . _("Maintenance Mode is ON") . "</strong></span><br><br>\n";
}
$dadlabel = getTemplateMessage('t9_dadside');
$momlabel = getTemplateMessage('t9_momside');
$title = getTemplateMessage('t9_maintitle');
$text['contactus_long'] = str_replace("suggest.php", "suggest.php?page=$title", $text['contactus_long']);
?>

<div id="art-main">
    <div class="cleared reset-box"></div>
    <div class="art-sheet">
        <div class="art-sheet-tl"></div>
        <div class="art-sheet-tr"></div>
        <div class="art-sheet-bl"></div>
        <div class="art-sheet-br"></div>
        <div class="art-sheet-tc"></div>
        <div class="art-sheet-bc"></div>
        <div class="art-sheet-cl"></div>
        <div class="art-sheet-cr"></div>
        <div class="art-sheet-cc"></div>
        <div class="art-sheet-body">
            <div class="art-header">
                <div class="art-header-clip">
                    <div class="art-header-center">
                        <div class="art-header-jpeg"></div>
                    </div>
                </div>
                <div class="art-headerobject"></div>
                <div class="art-logo">
                    <h1 class="art-logo-name"><a href="<?php echo $homepage; ?>"><?php echo $title; ?></a></h1>
                    <h2 class="art-logo-text"><?php echo getTemplateMessage('t9_headsubtitle'); ?></h2>
                </div>
            </div>
            <div class="cleared reset-box"></div>
            <div class="art-nav">
                <div class="art-nav-l"></div>
                <div class="art-nav-r"></div>
                <div class="art-nav-outer">
                    <ul class="art-hmenu">
                        <?php if ($dadlabel) { ?>
                            <li>
                                <a href="pedigree.php?personID=<?php echo $tmp['t9_dadperson']; ?>&amp;tree=<?php echo $tmp['t9_dadtree']; ?>"><span
                                        class="l"></span><span class="t"><?php echo $dadlabel; ?></span></a>
                            </li>
                            <?php
                        }
                        if ($momlabel) {
                            ?>
                            <li>
                                <a href="pedigree.php?personID=<?php echo $tmp['t9_momperson']; ?>&amp;tree=<?php echo $tmp['t9_momtree']; ?>"><span
                                        class="l"></span><span class="t"><?php echo $momlabel; ?></span></a>
                            </li>
                        <?php } ?>
                        <li>
                            <a href="suggest.php?page=<?php echo $title; ?>"><span class="l"></span><span
                                    class="t"><?php echo _("Contact Us"); ?></span></a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="cleared reset-box"></div>
            <div class="art-content-layout">
                <div class="art-content-layout-row">
                    <div class="art-layout-cell art-sidebar1">
                        <div class="art-vmenublock">
                            <div class="art-vmenublock-tl"></div>
                            <div class="art-vmenublock-tr"></div>
                            <div class="art-vmenublock-bl"></div>
                            <div class="art-vmenublock-br"></div>
                            <div class="art-vmenublock-tc"></div>
                            <div class="art-vmenublock-bc"></div>
                            <div class="art-vmenublock-cl"></div>
                            <div class="art-vmenublock-cr"></div>
                            <div class="art-vmenublock-cc"></div>
                            <div class="art-vmenublock-body">
                                <div class="art-vmenublockcontent">
                                    <div class="art-vmenublockcontent-body">
                                        <ul class="art-vmenu">
                                            <li><a href="whatsnew.php"><span class="l"></span><span class="r"></span><span
                                                        class="t"><?php echo _("What's New"); ?></span></a></li>
                                            <li><a href="mostwanted.php"><span class="l"></span><span class="r"></span><span
                                                        class="t"><?php echo _("Most Wanted"); ?></span></a></li>
                                            <?php
                                            foreach ($mediatypes as $mediatype) {
                                                if (!$mediatype['disabled']) {
                                                    echo "<li><a href='browsemedia.php?mediatypeID={$mediatype['ID']}'><span class='l'></span><span class='r'></span><span class='t'>{$mediatype['display']}</span></a></li>\n";
                                                }
                                            }
                                            ?>
                                            <li><a href="browsealbums.php"><span class="l"></span><span class="r"></span><span
                                                        class="t"><?php echo _("Albums"); ?></span></a></li>
                                            <li><a href="browsemedia.php"><span class="l"></span><span class="r"></span><span
                                                        class="t"><?php echo _("All Media"); ?></span></a></li>
                                            <li><a href="cemeteries.php"><span class="l"></span><span class="r"></span><span
                                                        class="t"><?php echo _("Cemeteries"); ?></span></a></li>
                                            <li><a href="places.php"><span class="l"></span><span class="r"></span><span
                                                        class="t"><?php echo _("Places"); ?></span></a></li>
                                            <li><a href="browsenotes.php"><span class="l"></span><span class="r"></span><span
                                                        class="t"><?php echo _("Notes"); ?></span></a></li>
                                            <li><a href="anniversaries.php"><span class="l"></span><span class="r"></span><span
                                                        class="t"><?php echo _("Dates and Anniversaries"); ?></span></a></li>
                                            <li><a href="calendar.php"><span class="l"></span><span class="r"></span><span
                                                        class="t"><?php echo _("Calendar"); ?></span></a></li>
                                            <li><a href="reports.php"><span class="l"></span><span class="r"></span><span
                                                        class="t"><?php echo _("Reports"); ?></span></a></li>
                                            <li><a href="browsesources.php"><span class="l"></span><span class="r"></span><span
                                                        class="t"><?php echo _("Sources"); ?></span></a></li>
                                            <li><a href="browserepos.php"><span class="l"></span><span class="r"></span><span
                                                        class="t"><?php echo _("Repositories"); ?></span></a></li>
                                            <?php if (!$tngconfig['hidedna']) { ?>
                                                <li><a href="browse_dna_tests.php"><span class="l"></span><span class="r"></span><span
                                                            class="t"><?php echo _("DNA Tests"); ?></span></a></li>
                                            <?php } ?>
                                            <li><a href="statistics.php"><span class="l"></span><span class="r"></span><span
                                                        class="t"><?php echo _("Statistics"); ?></span></a></li>
                                            <?php if ($allow_admin) { ?>
                                                <li><a href="showlog.php"><span class="l"></span><span class="r"></span><span
                                                            class="t"><?php echo _("Access Log"); ?></span></a></li>
                                                <li><a href="admin.php"><span class="l"></span><span class="r"></span><span
                                                            class="t"><?php echo _("Administration"); ?></span></a></li>
                                            <?php } ?>
                                            <li><a href="bookmarks.php"><span class="l"></span><span class="r"></span><span
                                                        class="t"><?php echo _("Bookmarks"); ?></span></a></li>
                                        </ul>

                                        <div class="cleared"></div>
                                    </div>
                                </div>
                                <div class="cleared"></div>
                            </div>
                        </div>

                        <div class="cleared"></div>
                    </div>
                    <div class="art-layout-cell art-content">
                        <div class="art-post">
                            <div class="art-post-body">
                                <div class="art-post-inner art-article">
                                    <h2 class="art-postheader"><?php echo getTemplateMessage('t9_welcome'); ?></h2>
                                    <div class="cleared"></div>
                                    <div class="art-postcontent">
                                        <img src="<?php echo $templatepath . $tmp['t9_mainimage']; ?>" alt="" class="float-left temppreview">
                                        <?php
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
                                                echo "<input name='instance' type='hidden' value='3'>\n";
                                                echo "</form>\n";
                                            }
                                            tng_free_result($result);
                                        }

                                        if ($currentuser) {
                                            echo "<p class='subhead'><strong>" . _("Welcome") . ", $currentuserdesc.</strong> <a href='logout.php'>" . _("Log Out") . "</a></p>\n";
                                        } else {
                                            $loginContent = "";
                                            if (!$tngconfig['showlogin']) {
                                                $loginContent = "<a href='login.php'>" . _("Log In") . "</a>";
                                            }
                                            if (!$tngconfig['disallowreg']) {
                                                if ($loginContent) $loginContent .= " | ";

                                                $loginContent .= "<a href='newacctform.php'>" . _("Register for a User Account") . "</a>";
                                            }
                                            if ($loginContent) echo "<p class='subhead'>$loginContent</p>\n";
                                        }
                                        echo getTemplateMessage('t9_mainpara');
                                        ?>
                                        <h4><?php echo _("Contact Us"); ?></h4>
                                        <p><img src="<?php echo $templatepath; ?>img/email.gif" alt="email image"
                                                class="emailimg"><?php echo $text['contactus_long']; ?></p>

                                    </div>
                                    <div class="cleared"></div>
                                </div>

                                <div class="cleared"></div>
                            </div>
                        </div>

                        <div class="cleared"></div>
                    </div>
                    <div class="art-layout-cell art-sidebar2">
                        <div class="art-block">
                            <div class="art-block-tl"></div>
                            <div class="art-block-tr"></div>
                            <div class="art-block-bl"></div>
                            <div class="art-block-br"></div>
                            <div class="art-block-tc"></div>
                            <div class="art-block-bc"></div>
                            <div class="art-block-cl"></div>
                            <div class="art-block-cr"></div>
                            <div class="art-block-cc"></div>
                            <div class="art-block-body">
                                <div class="art-blockheader">
                                    <div class="l"></div>
                                    <div class="r"></div>
                                    <h3 class="t"><?php echo _("Search"); ?></h3>
                                </div>
                                <div class="art-blockcontent">
                                    <div class="art-blockcontent-tl"></div>
                                    <div class="art-blockcontent-tr"></div>
                                    <div class="art-blockcontent-bl"></div>
                                    <div class="art-blockcontent-br"></div>
                                    <div class="art-blockcontent-tc"></div>
                                    <div class="art-blockcontent-bc"></div>
                                    <div class="art-blockcontent-cl"></div>
                                    <div class="art-blockcontent-cr"></div>
                                    <div class="art-blockcontent-cc"></div>
                                    <div class="art-blockcontent-body">
                                        <div>
                                            <form name="searchform" action="search.php" method="get">
                                                <label for="myfirstname"><?php echo _("First Name"); ?></label>
                                                <input id="myfirstname" name="myfirstname" type="search" value="" style="width: 95%;">
                                                <label for="mylastname"><?php echo _("Last Name"); ?></label>
                                                <input id="mylastname" name="mylastname" type="search" value="" style="width: 95%;">
                                                <input type="hidden" name="mybool" value="AND">
                                                <input type="submit" style="margin-top: 5px; margin-bottom: 5px;" value="<?php echo _("Search"); ?>">
                                            </form>
                                            <ul class="home-menus">
                                                <li><a href="surnames.php"><?php echo _("Surnames"); ?></a></li>
                                                <li><a href="searchform.php"><?php echo _("Advanced Search"); ?></a></li>
                                            </ul>
                                        </div>
                                        <div class="cleared"></div>
                                    </div>
                                </div>
                                <div class="cleared"></div>
                            </div>
                        </div>
                        <div class="art-block">
                            <div class="art-block-tl"></div>
                            <div class="art-block-tr"></div>
                            <div class="art-block-bl"></div>
                            <div class="art-block-br"></div>
                            <div class="art-block-tc"></div>
                            <div class="art-block-bc"></div>
                            <div class="art-block-cl"></div>
                            <div class="art-block-cr"></div>
                            <div class="art-block-cc"></div>
                            <div class="art-block-body">
                                <div class="art-blockheader">
                                    <div class="l"></div>
                                    <div class="r"></div>
                                    <h3 class="t"><?php echo _("Features"); ?></h3>
                                </div>
                                <div class="art-blockcontent">
                                    <div class="art-blockcontent-tl"></div>
                                    <div class="art-blockcontent-tr"></div>
                                    <div class="art-blockcontent-bl"></div>
                                    <div class="art-blockcontent-br"></div>
                                    <div class="art-blockcontent-tc"></div>
                                    <div class="art-blockcontent-bc"></div>
                                    <div class="art-blockcontent-cl"></div>
                                    <div class="art-blockcontent-cr"></div>
                                    <div class="art-blockcontent-cc"></div>
                                    <div class="art-blockcontent-body">
                                        <div>
                                            <p><?php echo getTemplateMessage('t9_featurepara'); ?></p>
                                            <ul class="home-menus">
                                                <?php echo showLinks($tmp['t9_featurelinks'], true); ?>
                                            </ul>
                                        </div>
                                        <div class="cleared"></div>
                                    </div>
                                </div>
                                <div class="cleared"></div>
                            </div>
                        </div>
                        <div class="art-block">
                            <div class="art-block-tl"></div>
                            <div class="art-block-tr"></div>
                            <div class="art-block-bl"></div>
                            <div class="art-block-br"></div>
                            <div class="art-block-tc"></div>
                            <div class="art-block-bc"></div>
                            <div class="art-block-cl"></div>
                            <div class="art-block-cr"></div>
                            <div class="art-block-cc"></div>
                            <div class="art-block-body">
                                <div class="art-blockheader">
                                    <div class="l"></div>
                                    <div class="r"></div>
                                    <h3 class="t"><?php echo _("Resources"); ?></h3>
                                </div>
                                <div class="art-blockcontent">
                                    <div class="art-blockcontent-tl"></div>
                                    <div class="art-blockcontent-tr"></div>
                                    <div class="art-blockcontent-bl"></div>
                                    <div class="art-blockcontent-br"></div>
                                    <div class="art-blockcontent-tc"></div>
                                    <div class="art-blockcontent-bc"></div>
                                    <div class="art-blockcontent-cl"></div>
                                    <div class="art-blockcontent-cr"></div>
                                    <div class="art-blockcontent-cc"></div>
                                    <div class="art-blockcontent-body">
                                        <div>
                                            <ul class="home-menus">
                                                <?php echo showLinks($tmp['t9_reslinks'], true); ?>
                                            </ul>
                                        </div>
                                        <div class="cleared"></div>
                                    </div>
                                </div>
                                <div class="cleared"></div>
                            </div>
                        </div>

                        <div class="cleared"></div>
                    </div>
                </div>
            </div>
            <div class="cleared"></div>
            <div class="art-footer">
                <div class="art-footer-t"></div>
                <div class="art-footer-b"></div>
                <div class="art-footer-body">
                    <div class="art-footer-text">
                        <a href="tngrss.php" class="art-rss-tag-icon" title="RSS"></a>
                        <?php
                        $flags['basicfooter'] = true;
                        tng_footer($flags);
                        ?>
                    </div>
                    <div class="cleared"></div>
                </div>
            </div>
            <div class="cleared"></div>
        </div>
    </div>
    <div class="cleared"></div>
    <br><br>
</div>

<?php echo "</body>"; ?>
<?php echo "</html>"; ?>
