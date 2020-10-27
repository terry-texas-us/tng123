<?php

global $allow_admin;
$tngconfig['showshare'] = false;
$flags = ['noicons' => true, 'noheader' => true, 'nobody' => true];
echo "<!doctype html>\n";
echo "<html lang='en'>\n";
$headElement = new HeadElementPublic($sitename ? "" : $text['ourpages'], $flags);
echo $headElement->getHtml();
standardHeaderVariants($headElement, $flags);
echo "<body id='bodytop' class='" . pathinfo(basename($_SERVER['SCRIPT_NAME']), PATHINFO_FILENAME) . "'>\n";
if ($tngconfig['maint']) {
    echo "<span class='fieldnameback yellow p-1'><strong>{$text['mainton']}</strong></span><br><br>\n";
}
$title1 = getTemplateMessage('t4_headtitle1');
$title2 = getTemplateMessage('t4_headtitle2');
$title = "$title1 $title2";
$text['contactus_long'] = str_replace("suggest.php", "suggest.php?page=$title", $text['contactus_long']);
?>
    <div class="text-center">
        <table class="indexpage">
            <tr>
                <td colspan="4" class="line"></td>
            </tr>
            <tr>
                <td class="menuback">
                    <a href="searchform.php" class="searchimg"><?php echo $text['search']; ?></a>
                    <form action="search.php" method="get">
                        <table class="menuback">
                            <tr>
                                <td>
                                    <label class="fieldname"><?php echo $text['mnufirstname']; ?>:<br>
                                        <input class="searchbox" name="myfirstname" type="search">
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="fieldname"><?php echo $text['mnulastname']; ?>: <br>
                                        <input class="searchbox" name="mylastname" type="search">
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input name="mybool" type="hidden" value="AND">
                                    <input name="search" type="submit" value="<?php echo $text['mnusearchfornames']; ?>">
                                </td>
                            </tr>
                        </table>
                    </form>
                    <table class="menuback">
                        <tr>
                            <td>
                                <div class="fieldname">
                                    <ul>
                                        <li><a href="searchform.php" class="lightlink"><?php echo $text['mnuadvancedsearch']; ?></a></li>
                                        <li><a href="surnames.php" class="lightlink"><?php echo $text['mnulastnames']; ?></a><br><br></li>
                                    </ul>
                                    <?php
                                    if ($currentuser) {
                                        echo "<p><span class='emphasisyellow'>{$text['welcome']}, $currentuserdesc.</span></p>\n";
                                        echo "<ul>\n";
                                        echo "<li><a href='logout.php' class='lightlink'>{$text['mnulogout']}</a></li>\n";
                                    } else {
                                        echo "<ul>\n";
                                        echo "<li><a href='login.php' class='lightlink'>{$text['mnulogon']}</a></li>\n";
                                    }
                                    echo "<li><a href='whatsnew.php' class='lightlink'>{$text['mnuwhatsnew']}</a></li>\n";
                                    echo "<li><a href='mostwanted.php' class='lightlink'>{$text['mostwanted']}</a></li>\n";
                                    foreach ($mediatypes as $mediatype) {
                                        if (!$mediatype['disabled']) {
                                            echo "<li><a href='browsemedia.php?mediatypeID={$mediatype['ID']}' class='lightlink'>{$mediatype['display']}</a></li>\n";
                                        }
                                    }
                                    echo "<li><a href='browsealbums.php' class='lightlink'>{$text['albums']}</a></li>\n";
                                    echo "<li><a href='browsemedia.php' class='lightlink'>{$text['allmedia']}</a></li>\n";
                                    echo "<li><a href='cemeteries.php' class='lightlink'>{$text['mnucemeteries']}</a></li>\n";
                                    echo "<li><a href='places.php' class='lightlink'>{$text['places']}</a></li>\n";
                                    echo "<li><a href='browsenotes.php' class='lightlink'>{$text['notes']}</a></li>\n";
                                    echo "<li><a href='anniversaries.php' class='lightlink'>{$text['anniversaries']}</a></li>\n";
                                    echo "<li><a href='calendar.php' class='lightlink'>{$text['calendar']}</a></li>\n";
                                    echo "<li><a href='reports.php' class='lightlink'>{$text['mnureports']}</a></li>\n";
                                    echo "<li><a href='browsesources.php' class='lightlink'>{$text['mnusources']}</a></li>\n";
                                    echo "<li><a href='browserepos.php' class='lightlink'>{$text['repositories']}</a></li>\n";
                                    if (!$tngconfig['hidedna']) {
                                        echo "<li><a href='browse_dna_tests.php' class='lightlink'>{$text['dna_tests']}</a></li>\n";
                                    }
                                    echo "<li><a href='statistics.php' class='lightlink'>{$text['mnustatistics']}</a></li>\n";
                                    echo "<li><a href='changelanguage.php' class='lightlink'>{$text['mnulanguage']}</a></li>\n";
                                    if ($allow_admin) {
                                        echo "<li><a href='showlog.php' class='lightlink'>{$text['mnushowlog']}</a></li>\n";
                                        echo "<li><a href='admin.php' class='lightlink'>{$text['mnuadmin']}</a></li>\n";
                                    }
                                    echo "<li><a href='bookmarks.php' class='lightlink'>{$text['bookmarks']}</a></li>\n";
                                    echo "<li><a href='suggest.php?page=$title' class='lightlink'>{$text['contactus']}</a></li>\n";
                                    if (!$currentuser && !$tngconfig['disallowreg']) {
                                        echo "<li><a href='newacctform.php' class='lightlink'>{$text['mnuregister']}</a></li>\n";
                                    }
                                    echo "</ul><br>\n";
                                    ?>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
                <td class="spacercol">&nbsp;&nbsp;&nbsp;</td>
                <td class="content">
                    <img src="<?php echo $templatepath; ?><?php echo $tmp['t4_headimg']; ?>" alt="" class="smallphoto">
                    <?php if ($tmp['t4_titlechoice'] == "text") { ?>
                        <div><br>
                            <span class="titletop"><?php echo $title1; ?></span><br>
                            <span class="titlebottom">&nbsp;<?php echo $title2; ?></span>

                        </div>
                    <?php } else { ?>
                        <img src="<?php echo $templatepath; ?><?php echo $tmp['t4_titleimg']; ?>" alt="" class="banner" width="468" height="100">
                    <?php } ?>
                    <div>
                        <div class="leftsection"><br>
                            <img src="<?php echo $templatepath; ?><?php echo $tmp['t4_mainimage']; ?>" alt="" class="bigphoto"><br>
                            <span class="smaller">&nbsp;&nbsp;<i><?php echo getTemplateMessage('t4_photocaption'); ?></i><br></span>
                            <div class="normal">
                                <h3><?php echo getTemplateMessage('t4_headline'); ?></h3>
                                <p><?php echo getTemplateMessage('t4_mainpara'); ?></p>
                            </div>
                        </div>
                        <div class="rightsection"><br>
                            <table cellspacing="0">
                                <tr>
                                    <td class='align-top'><span class="normal"><b><?php echo $text['featarts']; ?></b></span></td>
                                </tr>
                                <tr>
                                    <td class="line align-top"></td>
                                </tr>
                                <tr>
                                    <td class='align-top'>
                                        <div class="normal">
                                            <p>
                                                <a href="<?php echo $tmp['t4_featurelink1']; ?>"><img
                                                        src="<?php echo $templatepath; ?><?php echo $tmp['t4_featurethumb1']; ?>"
                                                        alt="feature 1" class="featureimg"></a>
                                                <a href="<?php echo $tmp['t4_featurelink1']; ?>"><span
                                                        class="emphasis"><?php echo getTemplateMessage('t4_featuretitle1'); ?></span></a> <?php echo getTemplateMessage('t4_featurepara1'); ?>
                                                <br style="clear: left;">
                                            </p>
                                            <p>
                                                <a href="<?php echo $tmp['t4_featurelink2']; ?>"><img
                                                        src="<?php echo $templatepath; ?><?php echo $tmp['t4_featurethumb2']; ?>"
                                                        alt="feature 2" class="featureimg"></a>
                                                <a href="<?php echo $tmp['t4_featurelink2']; ?>"><span
                                                        class="emphasis"><?php echo getTemplateMessage('t4_featuretitle2'); ?></span></a> <?php echo getTemplateMessage('t4_featurepara2'); ?>
                                                <br style="clear: left;">
                                            </p>
                                            <p>
                                                <a href="<?php echo $tmp['t4_featurelink3']; ?>"><img
                                                        src="<?php echo $templatepath; ?><?php echo $tmp['t4_featurethumb3']; ?>"
                                                        alt="feature 3" class="featureimg"></a>
                                                <a href="<?php echo $tmp['t4_featurelink3']; ?>"><span
                                                        class="emphasis"><?php echo getTemplateMessage('t4_featuretitle3'); ?></span></a> <?php echo getTemplateMessage('t4_featurepara3'); ?>
                                                <br style="clear: left;">
                                            </p>
                                            <p>
                                                <a href="<?php echo $tmp['t4_featurelink4']; ?>"><img
                                                        src="<?php echo $templatepath; ?><?php echo $tmp['t4_featurethumb4']; ?>"
                                                        alt="feature 4" class="featureimg"></a>
                                                <a href="<?php echo $tmp['t4_featurelink4']; ?>"><span
                                                        class="emphasis"><?php echo getTemplateMessage('t4_featuretitle4'); ?></span></a> <?php echo getTemplateMessage('t4_featurepara4'); ?>
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='align-top'><span class="normal">&nbsp;</span></td>
                                </tr>
                                <tr>
                                    <td class='align-top'><span class="normal"><b><?php echo $text['contactus']; ?></b></span></td>
                                </tr>
                                <tr>
                                    <td class="line align-top"></td>
                                </tr>
                                <tr>
                                    <td class='align-top'>
                                        <div class="normal">
                                            <p><img src="<?php echo $templatepath; ?>img/email.gif" alt="email image"
                                                    class="emailimg"><?php echo $text['contactus_long']; ?></p><br>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </td>
                <td class="spacercol">&nbsp;&nbsp;&nbsp;</td>
            </tr>
            <tr>
                <td colspan="4" class="line"></td>
            </tr>
        </table>
        <br>
        <div class="footer">
            <?php
            $flags['basicfooter'] = true;
            tng_footer($flags);
            ?>
        </div>
    </div>

<?php echo "</body>"; ?>
<?php echo "</html>"; ?>