<?php

global $allow_admin;
$flags = ['noicons' => true, 'noheader' => true, 'nobody' => true];

echo "<!doctype html>\n";
echo "<html lang='en'>\n";

$headElement = new HeadElementPublic($sitename ? "" : $text['ourhist'], $flags);
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
$dadlabel = getTemplateMessage('t11_dadside');
$momlabel = getTemplateMessage('t11_momside');
$title = getTemplateMessage('t11_maintitle');
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
                                    <a href="pedigree.php?personID=<?php echo $tmp['t11_dadperson']; ?>&amp;tree=<?php echo $tmp['t11_dadtree']; ?>"><span
                                            class="l"></span><span class="r"></span><span
                                            class="t"><?php echo $dadlabel; ?></span></a>
                                </li>
                                <?php
                            }
                            if ($momlabel) {
                                ?>
                                <li>
                                    <a href="pedigree.php?personID=<?php echo $tmp['t11_momperson']; ?>&amp;tree=<?php echo $tmp['t11_momtree']; ?>"><span
                                            class="l"></span><span class="r"></span><span
                                            class="t"><?php echo $momlabel; ?></span></a>
                                </li>
                                <?php
                            }
                            echo showLinks($tmp['t11_featurelinks'], false, "", "<span class='l'></span><span class='r'></span><span class='t'>xxx</span>");
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
                                                <div class="text-center">
                                                    <br>
                                                    <img src="<?php echo $templatepath . $tmp['t11_mainimage']; ?>" alt="" id="mainphoto" class="rounded-lg">
                                                </div>
                                                <p class="big-header">
                                                    <img src="<?php echo $templatepath; ?>img/greenvine1.png"
                                                        style="margin:0 0 0 10px; float:left;" alt="" class="greenvine">
                                                    <img src="<?php echo $templatepath; ?>img/greenvine2.png"
                                                        style="margin:0 10px 0 0; float:right;" alt="" class="greenvine">
                                                    <?php echo $title; ?>
                                                </p>
                                            </div>
                                            <table class="art-article">
                                                <tbody>
                                                <tr class="even">
                                                    <td>
                                                        <div class="left-indent">
                                                            <?php
                                                            echo getTemplateMessage('t11_mainpara');
                                                            $text['contactus_long'] = str_replace("suggest.php", "suggest.php?page=$title", $text['contactus_long']);
                                                            ?>
                                                            <h4><?php echo $text['contactus']; ?></h4>
                                                            <p class="contact"><img src="<?php echo $templatepath; ?>img/email.gif"
                                                                    alt="email image"
                                                                    class="emailimg"><?php echo $text['contactus_long']; ?></p>
                                                        </div>
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
                        <div class="art-layout-cell art-sidebar1" id="tsearchbox">
                            <div class="art-block">
                                <div class="art-block-body">
                                    <div class="art-blockheader">
                                        <h2 class="site-head"><?php echo $text['search']; ?></h2>
                                    </div>
                                    <div class="art-blockcontent">
                                        <div class="art-blockcontent-body">
                                            <div>
                                                <form name="searchform" action="search.php" method="get">
                                                    <label for="myfirstname"><?php echo $text['firstname']; ?></label>
                                                    <input type="search" value="" name="myfirstname">
                                                    <br>
                                                    <label for="mylastname"><?php echo $text['lastname']; ?></label>
                                                    <input type="search" value="" name="mylastname">
                                                    <input type="hidden" name="mybool" value="AND">
                                                    <input type="submit" id="search-submit" value="<?php echo $text['search']; ?>">
                                                </form>

                                                <br>
                                                <ul class="home-menus">
                                                    <li><a href="surnames.php"><?php echo $text['surnames']; ?></a></li>
                                                    <li><a href="searchform.php"><?php echo $text['mnuadvancedsearch']; ?></a></li>
                                                </ul>

                                                <br>
                                                <?php
                                                if ($currentuser) {
                                                    echo "<p><strong>{$text['welcome']}, $currentuserdesc.</strong></p>\n";
                                                    echo "<ul class='home-menus'>\n";

                                                    echo "<li><a href='logout.php'>{$text['mnulogout']}</a></li>\n";
                                                } else {
                                                    echo "<ul class='home-menus'>\n";
                                                    echo "<li><a href='login.php'>{$text['mnulogon']}</a></li>";
                                                    if (!$tngconfig['disallowreg']) {
                                                        ?>
                                                        <li><a href="newacctform.php"><?php echo $text['mnuregister']; ?></a></li></p>
                                                        <?php
                                                    }
                                                }

                                                echo "</ul>\n<br>\n";

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
                                                ?>
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
                    <div class="art-footer-body">
                        <div class="art-footer-text">

                            <div class="dotted-line">&nbsp;</div>
                            <div id="linkarea">
                                <ul class="fancy_list">
                                    <li><a href="whatsnew.php"><?php echo $text['mnuwhatsnew']; ?></a></li>
                                    <li><a href="mostwanted.php"><?php echo $text['mostwanted']; ?></a></li>
                                    <li><a href="places.php"><?php echo $text['places']; ?></a></li>
                                    <li><a href="browsenotes.php"><?php echo $text['notes']; ?></a></li>
                                    <li><a href="anniversaries.php"><?php echo $text['anniversaries']; ?></a></li>
                                    <li><a href="calendar.php"><?php echo $text['calendar']; ?></a></li>
                                    <li><a href="reports.php"><?php echo $text['reports']; ?></a></li>
                                    <?php
                                    foreach ($mediatypes as $mediatype) {
                                        if (!$mediatype['disabled']) {
                                            echo "<li><a href='browsemedia.php?mediatypeID={$mediatype['ID']}'>{$mediatype['display']}</a></li>\n";
                                        }
                                    }
                                    ?>
                                    <li><a href="browsemedia.php"><?php echo $text['allmedia']; ?></a></li>
                                    <li><a href="browsealbums.php"><?php echo $text['albums']; ?></a></li>
                                    <li><a href="cemeteries.php"><?php echo $text['mnucemeteries']; ?></a></li>
                                    <li><a href="browsesources.php"><?php echo $text['mnusources']; ?></a></li>
                                    <li><a href="browserepos.php"><?php echo $text['repositories']; ?></a></li>
                                    <?php if (!$tngconfig['hidedna']) { ?>
                                        <li><a href="browse_dna_tests.php"><?php echo $text['dna_tests']; ?></a></li>
                                    <?php } ?>
                                    <li><a href="statistics.php"><?php echo $text['mnustatistics']; ?></a></li>
                                    <li><a href="bookmarks.php"><?php echo $text['bookmarks']; ?></a></li>
                                    <?php if ($allow_admin) { ?>
                                        <li><a href="showlog.php"><?php echo $text['mnushowlog']; ?></a></li>
                                        <li><a href="admin.php"><?php echo $text['mnuadmin']; ?></a></li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <div class="cleared"></div>
                            <br>

                            <div class="dotted-line">&nbsp;</div>

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
    </div>

<?php echo "</body>"; ?>
<?php echo "</html>"; ?>