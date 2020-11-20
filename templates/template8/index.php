<?php

global $allow_admin;
$flags['noicons'] = true;
echo "<!doctype html>\n";
echo "<html lang='en'>\n";
$headElement = new HeadElementPublic($sitename ? "" : _("Home Page"), $flags);
echo $headElement->getHtml();
standardHeaderVariants($headElement, $flags);
echo "<body id='bodytop' class='" . pathinfo(basename($_SERVER['SCRIPT_NAME']), PATHINFO_FILENAME) . "'>\n";
if ($tngconfig['maint']) {
    echo "<span class='fieldnameback yellow p-1'><strong>" . _("Maintenance Mode is ON") . "</strong></span><br><br>\n";
}
?>
    <table class="home_table">
        <tr>
            <td class="homenav_col">
                <span class="subhead text_brown"><u><b><?php echo getTemplateMessage('t8_menutitle'); ?></b></u></span><br>
                <ul class="homenav">
                    <li>
                        <a href="pedigree.php?personID=<?php echo $tmp['t8_momperson']; ?>&amp;tree=<?php echo $tmp['t8_momtree']; ?>"><?php echo getTemplateMessage('t8_momside'); ?>
                            <br>&nbsp;&nbsp;
                            <span class="text_grey"><?php echo getTemplateMessage('t8_momsidenames'); ?></span></a>
                    </li>
                    <li>
                        <a href="pedigree.php?personID=<?php echo $tmp['t8_dadperson']; ?>&amp;tree=<?php echo $tmp['t8_dadtree']; ?>"><?php echo getTemplateMessage('t8_dadside'); ?>
                            <br>&nbsp;&nbsp;
                            <span class="text_grey"><?php echo getTemplateMessage('t8_dadsidenames'); ?></span></a>
                    </li>
                </ul>
                <br>
                <ul class="homenav">
                    <li><a href="whatsnew.php"><?php echo _("What's New"); ?></a></li>
                </ul>
                <br>
                <ul class="homenav">
                    <?php
                    foreach ($mediatypes as $mediatype) {
                        if (!$mediatype['disabled']) {
                            echo "<li><a href=\"browsemedia.php?mediatypeID={$mediatype['ID']}\">{$mediatype['display']}</a></li>\n";
                        }
                    }
                    ?>
                    <li><a href="browsealbums.php"<?php echo _("Albums"); ?></a></li>
                    <li><a href="cemeteries.php"><?php echo _("Cemeteries"); ?></a></li>
                    <li><a href="browsesources.php"><?php echo _("Sources"); ?></a></li>
                    <li><a href="reports.php"><?php echo _("Reports"); ?></a></li>
                </ul>
                <br>
                <ul class="homenav">
                    <li><a href="anniversaries.php"><?php echo _("Dates and Anniversaries"); ?></a></li>
                    <li><a href="calendar.php"><?php echo _("Calendar"); ?></a></li>
                    <li><a href="places.php"><?php echo _("Places"); ?></a></li>
                    <?php if (!$tngconfig['hidedna']) { ?>
                        <li><a href="browse_dna_tests.php"><?php echo _("DNA Tests"); ?></a></li>
                    <?php } ?>
                    <li><a href="statistics.php"><?php echo _("Statistics"); ?></a></li>
                </ul>
                <br>
                <?php
                if ($allow_admin) {
                    echo "<ul class=\"homenav\">";
                    echo "<li><a href=\"admin.php\">" . _("Administration") . "</a></li>";
                    echo "</ul><br>";
                }
                ?>
            </td>
            <td class="home_section" id="hs1">
                <h2 class="header"><?php echo _("Welcome"); ?></h2>
                <?php include "randomphoto.php"; ?>
                <?php echo getTemplateMessage('t8_mainpara'); ?>
                <br class="clear-both"><br>
            </td>
            <td class="home_section" id="hs2">
                <h2 class="header"><?php echo _("Features"); ?></h2>
                <?php echo getTemplateMessage('t8_featurespara'); ?>
                <hr>
                <h2 class="header"><?php echo _("Contact Us"); ?></h2>
                <?php
                $title1 = getTemplateMessage('t8_headtitle1');
                $title2 = getTemplateMessage('t8_headtitle2');
                $title3 = getTemplateMessage('t8_headtitle3');
                $title = $title1 . " " . $title2 . " " . $title3;
                $text['contactus_long'] = str_replace("suggest.php", "suggest.php?page=$title", $text['contactus_long']);
                echo $text['contactus_long'];
                ?>
                <br class="clear-both"><br>
            </td>
            <td class="home_section" id="hs3">
                <div class="latest_news rounded-lg">
                    <h2 class="header"><?php echo _("Latest News"); ?></h2>
                    <hr>
                    <?php echo getTemplateMessage('t8_latestnews'); ?>
                </div>
            </td>
        </tr>
    </table>
<?php tng_footer($flags); ?>