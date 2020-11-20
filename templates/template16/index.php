<?php

$tngconfig['showshare'] = false;
$flags = ['noicons' => true, 'noheader' => true, 'nobody' => true, 'bodyclass' => "homebody"];
echo "<!doctype html>\n";
echo "<html lang='en'>\n";
$headElement = new HeadElementPublic($sitename ? "" : _("Our Family History"), $flags);
echo $headElement->getHtml();
standardHeaderVariants($headElement, $flags);
echo "<body id='bodytop' class='" . pathinfo(basename($_SERVER['SCRIPT_NAME']), PATHINFO_FILENAME) . "'>\n";
if ($tngconfig['maint']) {
    echo "<span class='fieldnameback yellow p-1'><strong>" . _("Maintenance Mode is ON") . "</strong></span><br><br>\n";
}
echo "<body id='bodytop' class='" . pathinfo(basename($_SERVER['SCRIPT_NAME']), PATHINFO_FILENAME) . " homebody'>\n";
$dadlabel = getTemplateMessage('t16_dadside');
$momlabel = getTemplateMessage('t16_momside');
$title = getTemplateMessage('t16_maintitle');

$rp_maxwidth = "300";
$rp_maxheight = "300";

$search = "<h3>" . _("Search") . "</h3>\n";
$search .= "<form action='search.php' method='get'>\n";
$search .= "<label for='myfirstname' class='formfield' style='padding-top: 0;'>" . _("First Name") . ":</label>\n";
$search .= "<input id='myfirstname' class='formfield' name='myfirstname' type='search'>\n";
$search .= "<label for='mylastname' class='formfield'>" . _("Last Name") . ": </label>\n";
$search .= "<input id='mylastname' class='formfield' name='mylastname' type='search'><br>\n";
$search .= "<input name='mybool' type='hidden' value='AND'>\n";
$search .= "<div style='float: left; margin-right: 10px; margin-bottom: 5px;'>\n";
$search .= "<input type='submit' name='search' value='" . _("Search") . "' class='btn' id='searchbtn'>\n";
$search .= "</div>\n";
$search .= "<a href='searchform.php'>" . _("Advanced Search") . "</a><br>\n";
$search .= "<a href='surnames.php'>" . _("Surnames") . "</a>\n";
$search .= "<br style='clear: both;'>\n";
$search .= "</form>\n";
?>
    <div id="tcontainer">
        <div id="tbackground">
            <div id="tpage">
                <div class="theader">
                    <div id="thomemast" class="mast">
                        <h1><?php echo $title; ?></h1>
                    </div>
                    <div id="tmenu">
                        <ul>
                            <?php if ($dadlabel) { ?>
                                <li>
                                    <a href="pedigree.php?personID=<?php echo $tmp['t16_dadperson']; ?>&amp;tree=<?php echo $tmp['t16_dadtree']; ?>"><?php echo $dadlabel; ?></a>
                                </li>
                                <?php
                            }
                            if ($momlabel) {
                                ?>
                                <li>
                                    <a href="pedigree.php?personID=<?php echo $tmp['t16_momperson']; ?>&amp;tree=<?php echo $tmp['t16_momtree']; ?>"><?php echo $momlabel; ?></a>
                                </li>
                                <?php
                            }
                            echo showLinks($tmp['t16_featurelinks'], false);
                            ?>
                        </ul>
                    </div>
                </div>
                <div id="tbody">
                    <div id="tsidebar">
                        <div class="tsidesection">
                            <?php echo $search; ?>
                        </div>
                        <div class="tsidesection">
                            <h3><?php echo _("Featured Photo"); ?></h3>
                            <?php
                            $rp_maxwidth = "100%";
                            include "randomphoto.php";
                            ?>
                        </div>
                        <div class="tsidesection">
                            <h3><?php echo $admtext['menu']; ?></h3>
                            <ul class="vmenu">
                                <li><a href="whatsnew.php"><?php echo _("What's New"); ?></a></li>
                                <li><a href="mostwanted.php"><?php echo _("Most Wanted"); ?></a></li>
                                <?php
                                foreach ($mediatypes as $mediatype) {
                                    if (!$mediatype['disabled']) {
                                        echo "<li><a href='browsemedia.php?mediatypeID={$mediatype['ID']}'>{$mediatype['display']}</a></li>\n";
                                    }
                                }
                                ?>
                                <li><a href="browsealbums.php"><?php echo _("Albums"); ?></a></li>
                                <li><a href="browsemedia.php"><?php echo _("All Media"); ?></a></li>
                                <li><a href="cemeteries.php"><?php echo _("Cemeteries"); ?></a></li>
                                <li><a href="places.php"><?php echo _("Places"); ?></a></li>
                                <li><a href="browsenotes.php"><?php echo _("Notes"); ?></a></li>
                                <li><a href="anniversaries.php"><?php echo _("Dates and Anniversaries"); ?></a></li>
                                <li><a href="calendar.php"><?php echo _("Calendar"); ?></a></li>
                                <li><a href="reports.php"><?php echo _("Reports"); ?></a></li>
                                <li><a href="browsesources.php"><?php echo _("Sources"); ?></a></li>
                                <li><a href="browserepos.php"><?php echo _("Repositories"); ?></a></li>
                                <?php if (!$tngconfig['hidedna']) { ?>
                                    <li><a href="browse_dna_tests.php"><?php echo _("DNA Tests"); ?></a></li>
                                <?php } ?>
                                <li><a href="statistics.php"><?php echo _("Statistics"); ?></a></li>
                                <?php if ($allow_admin) { ?>
                                    <li><a href="showlog.php"><?php echo _("Access Log"); ?></a></li>
                                    <li><a href="admin.php"><?php echo _("Administration"); ?></a></li>
                                <?php } ?>
                                <li><a href="bookmarks.php"><?php echo _("Bookmarks"); ?></a></li>
                            </ul>
                        </div>
                    </div>
                    <div id="thomebody">
                        <div class="tblock" id="big-block-1">
                            <h2><?php echo getTemplateMessage('t16_welcome'); ?></h2>
                            <div class="left-indent mainsection">
                                <?php if ($tmp['t16_mainimage']) { ?>
                                    <div id="mainphoto">
                                        <img src="<?php echo $templatepath . $tmp['t16_mainimage']; ?>" alt="" class="temppreview">
                                    </div>
                                    <?php
                                }
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
                                    echo "<input type='hidden' name='instance' value='3'>\n";
                                    echo "</form>\n";
                                }
                                tng_free_result($result);

                                if ($currentuser) {
                                    echo "<p class='mt-2'><strong>" . _("Welcome") . ", $currentuserdesc.</strong> <a href='logout.php'>" . _("Log Out") . "</a></p>\n";
                                } else {
                                    $loginContent = "";
                                    if (!$tngconfig['showlogin']) {
                                        $loginContent = "<a href='login.php'>" . _("Log In") . "</a>";
                                    }
                                    if (!$tngconfig['disallowreg']) {
                                        if ($loginContent) $loginContent .= " | ";

                                        $loginContent .= "<a href='newacctform.php'>" . _("Register for a User Account") . "</a>";
                                    }
                                    if ($loginContent) echo "<p>$loginContent</p>\n";
                                }
                                echo getTemplateMessage('t16_mainpara');
                                ?>
                                <h3><?php echo _("Contact Us"); ?></h3>
                                <p class="contact">
                                    <img src="<?php echo $templatepath; ?>img/email.gif" alt="email image" class="emailimg"><?php echo $text['contactus_long']; ?>
                                </p>
                            </div>
                            <div style="clear:both;"></div>
                        </div>
                        <?php
                        $feature_headline = getTemplateMessage('t16_featuretitle1');
                        $feature_text = getTemplateMessage('t16_featurepara1');
                        if ($feature_headline || $feature_text) {
                            ?>
                            <div class="tblock" id="big-block-2">
                                <h2><?php echo $feature_headline ?></h2>
                                <div class="left-indent mainsection">
                                    <?php echo $feature_text ?>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="tblock">
                            <h2><?php echo _("What's New") . " | <a href='whatsnew.php'>" . _("More") . "</a>"; ?></h2>
                            <?php include "widget_whatsnew.php"; ?>
                        </div>
                        <div class="tblock">
                            <h2><?php echo _("Surnames") . " | <a href='surnames.php'>" . _("More") . "</a>"; ?></h2>
                            <?php
                            include "surname_cloud.class.php";
                            $nc = new surname_cloud();
                            $nc->display();
                            ?>
                        </div>
                    </div>
                </div>
                <hr>
                <div id="tfooter">
                    <?php
                    $flags['basicfooter'] = true;
                    tng_footer($flags);
                    ?>
                </div>
            </div>
        </div>
    </div>

<?php echo "</body>"; ?>
<?php echo "</html>"; ?>