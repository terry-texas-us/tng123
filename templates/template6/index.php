<?php

if (!isset($title) || !$title) {
    $title = getTemplateMessage('t6_maintitle');
}
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
    <table class="w-full" cellspacing="0" cellpadding="5">
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
                                    <label for="myfirstname"><?php echo _("First Name"); ?>:</label>
                                </td>
                                <td class="searchbox">
                                    <input id="myfirstname" name="myfirstname" type="search">
                                </td>

                            </tr>
                            <tr>
                                <td>
                                    <label for="mylastname"><?php echo _("Last Name"); ?>:</label>
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
                <p class="text-center">
                    [<a href="surnames.php"><?php echo _("Surnames"); ?></a>]<br>
                    [<a href="searchform.php"><?php echo _("Advanced Search"); ?></a>]
                </p>
                <p class="text-center">
                    [<a href="http://www.gendexnetwork.org">GenDex Network</a>]<br>
                    [<a href="http://www.familytreeseeker.com">FamilyTreeSeeker.com</a>]
                </p>
            </td>
            <td class="section">
                <img src="<?php echo $templatepath; ?>img/header_featphoto.gif" width="200" height="50" alt=""><br>
                <?php include "randomphoto.php"; ?>
                <p class="text-center">[<a href="browsemedia.php?mediatypeID=photos"><?php echo _("View all photos"); ?></a>]</p>
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
                <p class="text-center">[<a href="mostwanted.php"><?php echo _("Most Wanted"); ?></a>] </p>
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