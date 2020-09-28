<?php

if (!isset($title) || !$title) {
    $title = getTemplateMessage('t6_maintitle');
}

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
    <table class="page">
    <tr class="row60">
        <td colspan="4" class="headertitle">
            <?php echo getTemplateMessage('t6_maintitle'); ?>
        </td>
    </tr>
    <tr>
        <td class="titlemid">
            <img src="<?php echo $templatepath; ?><?php echo $tmp['t6_headimg']; ?>" width="559" height="60" alt="">
        </td>
    </tr>
    <tr class="tablebkground">
    <td colspan="4" class="padding" style="border-collapse:separate;">
<?php } ?>
    <table class="w-100" cellspacing="0" cellpadding="5">
        <tr>
            <td class="section">
                <img src="<?php echo $templatepath; ?>img/header_welcome.gif" width="200" height="50" alt=""><br>
                <span class="normal"><?php echo getTemplateMessage('t6_mainpara'); ?><br><br><br></span>
                <img src="<?php echo $templatepath; ?>img/header_search.gif" width="200" height="50" alt=""><br>
                <span class="normal"><?php echo getTemplateMessage('t6_searchpara'); ?></span>
                <br><br>
                <form id="form1" action="search.php" method="get">
                    <div>
                        <input type="hidden" value="AND" name="mybool">
                        <table cellspacing="0">
                            <tr>
                                <td>
                                    <label for="myfirstname"><?php echo $text['firstname']; ?>:</label>
                                </td>
                                <td class="searchbox">
                                    <input id="myfirstname" name="myfirstname" type="search">
                                </td>

                            </tr>
                            <tr>
                                <td>
                                    <label for="mylastname"><?php echo $text['lastname']; ?>:</label>
                                </td>
                                <td class="searchbox">
                                    <input id="mylastname" name="mylastname" type="search">
                                </td>
                                <td rowspan="2">
                                    <input type="image" name="imageField" src="<?php echo $templatepath; ?>img/searchbutton.gif">
                                </td>
                            </tr>
                        </table>
                    </div>
                </form>
                <p class="center">
                    [<a href="surnames.php"><?php echo $text['mnulastnames']; ?></a>]<br>
                    [<a href="searchform.php"><?php echo $text['mnuadvancedsearch']; ?></a>]
                </p>
                <p class="center">
                    [<a href="http://www.gendexnetwork.org">GenDex Network</a>]<br>
                    [<a href="http://www.familytreeseeker.com">FamilyTreeSeeker.com</a>]
                </p>
            </td>
            <td class="section">
                <img src="<?php echo $templatepath; ?>img/header_featphoto.gif" width="200" height="50" alt=""><br>
                <?php include "randomphoto.php"; ?>
                <p class="center">[<a href="browsemedia.php?mediatypeID=photos"><?php echo $text['viewphotos']; ?></a>]</p>
                <p class="normal"><img src="<?php echo $templatepath; ?>img/header_famhist.gif" width="200" height="50" alt=""><br>
                    <?php echo getTemplateMessage('t6_fhpara'); ?>
                </p>
                <table width="250" cellspacing="0">
                    <tr>
                        <td class="emphasis">
                            <?php echo getTemplateMessage('t6_hisside'); ?>
                        </td>
                        <td class="emphasis">
                            <?php echo getTemplateMessage('t6_herside'); ?>
                        </td>
                    </tr>
                    <tr class="row5">
                        <td colspan="2"></td>
                    </tr>
                    <tr>
                        <td class="normal align-top">
                            <?php echo $tmp['t6_fhlinkshis']; ?>
                        </td>
                        <td class="normal align-top">
                            <?php echo $tmp['t6_fhlinkshers']; ?>
                        </td>
                    </tr>
                </table>
                <p>&nbsp;</p>
            </td>
            <td class="section">
                <p class="normal"><img src="<?php echo $templatepath; ?>img/header_mostwanted.gif" width="200" height="50" alt="">
                </p>
                <?php echo getTemplateMessage('t6_mwpara'); ?>
                <p class="center">[<a href="mostwanted.php"><?php echo $text['mostwanted']; ?></a>] </p>
                <p class="normal"><img src="<?php echo $templatepath; ?>img/header_resources.gif" width="200" height="50" alt="">
                </p>
                <?php echo getTemplateMessage('t6_respara'); ?>
                <div class="normal">
                    <?php echo $tmp['t6_reslinks']; ?>
                </div>
            </td>
        </tr>
    </table>
<?php tng_footer(''); ?>