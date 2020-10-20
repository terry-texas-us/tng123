<?php

global $allow_admin;

$flags['noicons'] = true;

echo "<!doctype html>\n";
echo "<html lang='en'>\n";

$headElement = new HeadElementPublic($sitename ? "" : $text['mnuheader'], $flags);
echo $headElement->getHtml();

if (isMobile()) {
    mobileHeaderVariants($headElement, $flags);
} else {
    standardHeaderVariants($headElement, $flags);
    echo "<body id='bodytop' class='" . pathinfo(basename($_SERVER['SCRIPT_NAME']), PATHINFO_FILENAME) . "'>\n";
}
if ($tngconfig['maint']) {
    echo "<span class='fieldnameback yellow p-1'><strong>{$text['mainton']}</strong></span><br><br>\n";
}

if (isMobile()) {
    ?>
    <div class="headerrow"
        style="background-image: url(<?php echo $templatepath; ?><?php echo $tmp['t8_headimg']; ?>);background-position:right;">
        <span class="headertext text_white"><?php echo getTemplateMessage('t8_headtitle1'); ?></span><span
            class="headertext text_tan"><?php echo getTemplateMessage('t8_headtitle2'); ?></span><span
            class="headertext text_white"><?php echo getTemplateMessage('t8_headtitle3'); ?></span>
    </div>
    <br>
<?php } ?>
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
                    <li><a href="whatsnew.php"><?php echo $text['mnuwhatsnew']; ?></a></li>
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
                    <li><a href="browsealbums.php"<?php echo $text['albums']; ?></a></li>
                    <li><a href="cemeteries.php"><?php echo $text['mnucemeteries']; ?></a></li>
                    <li><a href="browsesources.php"><?php echo $text['mnusources']; ?></a></li>
                    <li><a href="reports.php"><?php echo $text['mnureports']; ?></a></li>
                </ul>
                <br>
                <ul class="homenav">
                    <li><a href="anniversaries.php"><?php echo $text['anniversaries']; ?></a></li>
                    <li><a href="calendar.php"><?php echo $text['calendar']; ?></a></li>
                    <li><a href="places.php"><?php echo $text['places']; ?></a></li>
                    <?php if (!$tngconfig['hidedna']) { ?>
                        <li><a href="browse_dna_tests.php"><?php echo $text['dna_tests']; ?></a></li>
                    <?php } ?>
                    <li><a href="statistics.php"><?php echo $text['mnustatistics']; ?></a></li>
                </ul>
                <br>
                <?php
                if ($allow_admin) {
                    echo "<ul class=\"homenav\">";
                    echo "<li><a href=\"admin.php\">{$text['mnuadmin']}</a></li>";
                    echo "</ul><br>";
                }
                ?>
            </td>
            <td class="home_section" id="hs1">
                <h2 class="header"><?php echo $text['welcome']; ?></h2>
                <?php include "randomphoto.php"; ?>
                <?php echo getTemplateMessage('t8_mainpara'); ?>
                <br class="clear-both"><br>
            </td>
            <td class="home_section" id="hs2">
                <h2 class="header"><?php echo $text['features']; ?></h2>
                <?php echo getTemplateMessage('t8_featurespara'); ?>
                <hr>
                <h2 class="header"><?php echo $text['contactus']; ?></h2>
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
                    <h2 class="header"><?php echo $text['latestnews']; ?></h2>
                    <hr>
                    <?php echo getTemplateMessage('t8_latestnews'); ?>
                </div>
            </td>
        </tr>
    </table>
<?php tng_footer($flags); ?>