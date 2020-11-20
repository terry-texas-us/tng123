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
$dadlabel = getTemplateMessage('t18_dadside');
$momlabel = getTemplateMessage('t18_momside');
?>
    <style>
        body {
            margin: 0;
            background-color: #31708E;
        }
        #big-block-1 {
            background: url('<?php echo $templatepath; ?><?php echo $tmp['t18_mainimage']; ?>') no-repeat center 33%;
            background-size: 100% auto;
            height: 250px;
        }
    </style>

    <div class="theader">
        <div id="thomemast" class="mast">
            <h1><?php echo getTemplateMessage('t18_maintitle'); ?></h1>
            <span class="tsubtitle"><?php echo getTemplateMessage('t18_headsubtitle'); ?></span>
        </div>
        <div id="tmenu">
            <ul>
                <?php if ($dadlabel) { ?>
                    <li>
                        <a href="pedigree.php?personID=<?php echo $tmp['t18_dadperson']; ?>&amp;tree=<?php echo $tmp['t18_dadtree']; ?>"><?php echo $dadlabel; ?></a>
                    </li>
                    <?php
                }
                if ($momlabel) {
                    ?>
                    <li>
                        <a href="pedigree.php?personID=<?php echo $tmp['t18_momperson']; ?>&amp;tree=<?php echo $tmp['t18_momtree']; ?>"><?php echo $momlabel; ?></a>
                    </li>
                    <?php
                }
                echo showLinks($tmp['t18_featurelinks'], false);
                ?>
            </ul>
        </div>
    </div>
    <div class="tblock" id="big-block-1">
        <!--
	<div class="quote">
		<h2><?php echo getTemplateMessage('t18_welcome'); ?></h2>
		<p>Some other text goes here. Something about your family. Maybe a few paragraphs. blah blah blah blah.</p>
	</div>
-->
    </div>
    <div class="tblock-dark" id="big-block-2">
        <div id="linkarea">
            <ul class="left-indent">
                <li class="linkcol">
                    <article class="post">
                        <header class="entry-header">
                            <h2 class="entry-title"><?php echo getTemplateMessage('t18_welcome'); ?></h2></a>
                        </header>
                        <div class="entry-content">
                            <?php echo getTemplateMessage('t18_mainpara'); ?>
                        </div>
                        <?php
                        if ($currentuser) {
                            echo "<p class='entry-content'><strong>" . _("Welcome") . ", $currentuserdesc.</strong></p>\n";
                            echo "<ul class='home-menus'>\n";

                            echo "<li><a href='logout.php'>" . _("Log Out") . "</a></li>\n";
                        }
                        else {
                        echo "<ul class='home-menus'>\n";
                        echo "<li><a href='login.php'>" . _("Log In") . "</a></li>";
                        if (!$tngconfig['disallowreg']) {
                        ?>
                <li><a href="newacctform.php"><?php echo _("Register for a User Account"); ?></a></li>
                </p>
                <?php
                }
                }

                echo "</ul>\n";
                ?>
                <br>
                </article>
                </li>
                <li class="linkcol">
                    <article class="post">
                        <h2 class="entry-title"><?php echo _("Search"); ?></h2>
                        <form id="home-search-box" class="entry-content" name="searchform" action="search.php" method="get">
                            <div style="display: inline-block;">
                                <label for="myfirstname"><?php echo _("First Name"); ?></label>
                                <br>
                                <input id="myfirstname" name="myfirstname" type="search" value="">
                                <br>
                                <br>
                                <label for="mylastname"><?php echo _("Last Name"); ?></label>
                                <br>
                                <input id="mylastname" name="mylastname" type="search" value="">
                                <br>
                                <input type="hidden" name="mybool" value="AND">
                            </div>
                            <div style="display: inline-block; vertical-align: top; padding: 15px;">
                                <input id="search-submit" class="btn" type="submit" value="<?php echo _("Search"); ?>">
                                <br>
                                <br>
                                <ul class="home-menus">
                                    <li><a href="surnames.php"><?php echo _("Surnames"); ?></a></li>
                                    <li><a href="searchform.php"><?php echo _("Advanced Search"); ?></a></li>
                                </ul>
                            </div>
                        </form>

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
                                    echo "<input type='hidden' name='instance' value='3'></form>\n";
                                }

                                tng_free_result($result);
                                ?>
                            </div>
                        <?php } ?>

                        <div class="left-indent">
                            <h3 class="entry-title"><?php echo _("Contact Us"); ?></h3>
                            <p class="entry-content"><img src="<?php echo $templatepath; ?>img/email.gif" alt="email image"
                                    class="emailimg"><?php echo $text['contactus_long']; ?></p>
                        </div>
                    </article>
                </li>
                <li class="linkcol">
                    <article class="post">
                        <header class="entry-header">
                            <a href="<?php echo $tmp['t18_featurelink1']; ?>" title="" class="alignnone"><h2
                                    class="entry-title"><?php echo getTemplateMessage('t18_featuretitle1'); ?></h2></a>
                        </header>
                        <div class="entry-content">
                            <?php
                            echo getTemplateMessage('t18_featurepara1');
                            $tl1 = getTemplateMessage('t18_featurelink1');
                            if ($tl1) {
                                ?>
                                <p><a class="footer-link" href="<?php echo $tl1; ?>"><?php echo _("More"); ?> ...</a></p>
                            <?php } ?>
                        </div>
                    </article>
                </li>
            </ul>
        </div>
        <div style="clear:left;"></div>
    </div>
    <div class="tblock" id="big-block-3">
        <h2><a href="<?php echo $tmp['t18_featurelink2']; ?>" title=""><?php echo getTemplateMessage('t18_featuretitle2'); ?></a></h2>
        <div class="left-indent mainsection">
            <br>
            <div class="two-cols"><img src="<?php echo $templatepath . $tmp['t18_featurethumb2']; ?>" alt="Lorem Ipsum" title="">
                <?php
                echo getTemplateMessage('t18_featurepara2');
                $tl2 = getTemplateMessage('t18_featurelink2');
                if ($tl2) {
                    ?>
                    <p><a class="footer-link" href="<?php echo $tl2; ?>"><?php echo _("More"); ?> ...</a></p>
                <?php } ?>
            </div>
        </div>
        <div style="clear:left;"></div>
    </div>
    <div id="tfooter">
        <div class="other-features">
            <h2><?php echo _("Other Features"); ?></h2>
        </div>
        <div class="linkcol2">
            <ul class="fancy_list newspaper2">
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
        </div>
        <div style="clear:left;"></div>
    </div>
    <div id="subfooter">
        <?php
        $flags['basicfooter'] = true;
        tng_footer($flags);
        ?>
    </div>

<?php echo "</body>"; ?>
<?php echo "</html>"; ?>