<?php

global $allow_admin;

$tngconfig['showshare'] = false;
$flags = ['noicons' => true, 'noheader' => true, 'nobody' => true];

echo "<!doctype html>\n";
echo "<html lang='en'>\n";

$headElement = new HeadElementPublic($sitename ? "" : $text['ourpages'], $flags);
echo $headElement->getHtml();

if (isMobile()) {
    mobileHeaderVariants($headElement, $flags);
} else {
    standardHeaderVariants($headElement, $flags);
    echo "<body id='bodytop' class='" . pathinfo(basename($_SERVER['SCRIPT_NAME']), PATHINFO_FILENAME) . " bodyindex'>\n";
}
if ($tngconfig['maint']) {
    echo "<span class='fieldnameback yellow p-1'><strong>{$text['mainton']}</strong></span><br><br>\n";
}
$title = getTemplateMessage('t2_maintitle');
?>
    <script>
        pedigreeoff = new Image(162, 24);
        pedigreeoff.src = "<?php echo $templatepath; ?>img/pedigreeoff.gif";
        pedigreeon = new Image(162, 24);
        pedigreeon.src = "<?php echo $templatepath; ?>img/pedigreeon.gif";

        photosoff = new Image(193, 24);
        photosoff.src = "<?php echo $templatepath; ?>img/photosoff.gif";
        photoson = new Image(193, 24);
        photoson.src = "<?php echo $templatepath; ?>img/photoson.gif";

        function swap(x, y) {
            document.images[x].src = eval(y + '.src');
        }
    </script>

    <div class="center">
        <table class="indexpage rounded10" style="padding:0;">
            <tr>
                <td class='align-top'>
                    <div class="databack rounded10">
                        <div style="float:left;display:inline;">
                            <?php if ($tmp['t2_titlechoice'] == "text" || isMobile()) { ?>
                                <div id="titlecontainer">
                                    <em class="maintitle"><?php echo $title; ?></em>
                                </div>
                            <?php } else { ?>
                                <img src="<?php echo $templatepath; ?><?php echo $tmp['t2_titleimage']; ?>" alt="" width="443"
                                    height="114" class="noimgborder rounded10">
                                <?php
                            }
                            $mainpara = getTemplateMessage('t2_mainpara');
                            ?>
                            <br>
                            <?php
                            if ($mainpara) {
                                echo "<div style='max-width: 390px; padding-left:20px;'>$mainpara</div><br>\n";
                            }
                            ?>
                            <a href="pedigree.php?personID=<?php echo $tmp['t2_pedperson']; ?>&amp;tree=<?php echo $tmp['t2_pedtree']; ?>"
                               class="mainlink smalltitle">&#8226; <?php echo $text['pedigree']; ?></a>
                            <a href="extrastree.php?personID=<?php echo $tmp['t2_phhistperson']; ?>&amp;tree=<?php echo $tmp['t2_phhisttree']; ?>"
                               class="mainlink smalltitle">&#8226; <?php echo $text['photoshistories']; ?></a>

                            <div id="linktable">
                                <br><br>
                                <table cellspacing="4">
                                    <tr>
                                        <td rowspan="6">&nbsp;&nbsp;&nbsp;</td>
                                        <td class='align-top'>
                                            <?php
                                            if ($currentuser) {
                                                echo "<a href='logout.php' class='sidelink'>" . strtoupper($text['mnulogout']) . "</a>\n";
                                            } else {
                                                echo "<a href='login.php' class='sidelink'>" . strtoupper($text['mnulogon']) . "</a>\n";
                                            }
                                            ?>
                                        </td>
                                        <td>&nbsp;&nbsp;</td>
                                        <td class='align-top'>
                                            <a href="whatsnew.php" class="sidelink"><?php echo $text['mnuwhatsnew']; ?></a>
                                        </td>
                                        <td>&nbsp;&nbsp;&nbsp;</td>
                                        <td class='align-top'>
                                            <a href="statistics.php" class="sidelink"><?php echo $text['mnustatistics']; ?></a></td>
                                        <td>&nbsp;&nbsp;&nbsp;</td>
                                        <td class='align-top'>
                                            <a href="anniversaries.php" class="sidelink"><?php echo $text['anniversaries']; ?></a>
                                        </td>
                                        <td>&nbsp;&nbsp;&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td class='align-top'>
                                            <a href="browsemedia.php?mediatypeID=photos" class="sidelink"><?php echo $text['mnuphotos']; ?></a>
                                        </td>
                                        <td>&nbsp;&nbsp;&nbsp;</td>
                                        <td class='align-top'>
                                            <a href="browsemedia.php?mediatypeID=histories" class="sidelink"><?php echo $text['mnuhistories']; ?></a>
                                        </td>
                                        <td>&nbsp;&nbsp;&nbsp;</td>
                                        <td class='align-top'>
                                            <a href="cemeteries.php" class="sidelink"><?php echo $text['mnucemeteries']; ?></a>
                                        </td>
                                        <td>&nbsp;&nbsp;&nbsp;</td>
                                        <td class='align-top'>
                                            <a href="places.php" class="sidelink"><?php echo $text['places']; ?></a>
                                        </td>
                                        <td>&nbsp;&nbsp;&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td class='align-top'>
                                            <a href="browsemedia.php?mediatypeID=documents" class="sidelink"><?php echo $text['documents']; ?></a>
                                        </td>
                                        <td>&nbsp;&nbsp;&nbsp;</td>
                                        <td class='align-top'>
                                            <a href="browsemedia.php" class="sidelink"><?php echo $text['allmedia']; ?></a>
                                        </td>
                                        <td>&nbsp;&nbsp;&nbsp;</td>
                                        <td class='align-top'>
                                            <a href="browsemedia.php?mediatypeID=headstones" class="sidelink"><?php echo $text['mnutombstones']; ?></a>
                                        </td>
                                        <td>&nbsp;&nbsp;&nbsp;</td>
                                        <td class='align-top'>
                                            <a href="browsealbums.php" class="sidelink"><?php echo $text['albums']; ?></a>
                                        </td>
                                        <td>&nbsp;&nbsp;&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td class='align-top'>
                                            <a href="reports.php" class="sidelink"><?php echo $text['mnureports']; ?></a>
                                        </td>
                                        <td>&nbsp;&nbsp;&nbsp;</td>
                                        <td class='align-top'>
                                            <a href="browsesources.php" class="sidelink"><?php echo $text['mnusources']; ?></a>
                                        </td>
                                        <td>&nbsp;&nbsp;&nbsp;</td>
                                        <td class='align-top'>
                                            <a href="bookmarks.php" class="sidelink"><?php echo $text['bookmarks']; ?></a>
                                        </td>
                                        <td>&nbsp;&nbsp;&nbsp;</td>
                                        <td class='align-top'>
                                            <a href="suggest.php?page=<?php echo $title; ?>" class="sidelink"><?php echo $text['contactus']; ?></a>
                                        </td>
                                        <td>&nbsp;&nbsp;&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td class='align-top'>
                                            <a href="mostwanted.php" class="sidelink"><?php echo $text['mostwanted']; ?></a>
                                        </td>
                                        <td>&nbsp;&nbsp;&nbsp;</td>
                                        <td class='align-top'>
                                            <a href="browserepos.php" class="sidelink"><?php echo $text['repositories']; ?></a>
                                        </td>
                                        <td>&nbsp;&nbsp;&nbsp;</td>
                                        <td class='align-top'>
                                            <a href="showlog.php" class="sidelink"><?php if ($allow_admin) {
                                                    echo $text['mnushowlog'];
                                                } ?></a>
                                        </td>
                                        <td>&nbsp;&nbsp;&nbsp;</td>
                                        <td class='align-top'>
                                            <a href="admin.php" class="sidelink"><?php if ($allow_admin) {
                                                    echo $text['mnuadmin'];
                                                } ?></a>&nbsp;
                                        </td>
                                        <td>&nbsp;&nbsp;&nbsp;</td>
                                    </tr>
                                    <?php if (!$currentuser && !$tngconfig['disallowreg']) { ?>
                                        <tr>
                                            <td class="align-top" colspan="4">
                                                <a href="newacctform.php" class="sidelink"><?php echo $text['mnuregister']; ?></a>
                                            </td>
                                            <td>&nbsp;&nbsp;&nbsp;</td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </div>
                            <br>

                            <form id="form1" name="searchform" action="search.php" method="get">
                                <div id="searchblock">
                                    <div id="searchtitleblock">
                                        <span class="smalltitle"><?php echo $text['search']; ?></span>
                                        <table cellspacing="6">
                                            <tr>
                                                <td align="center">
                                                    <a href="searchform.php" class="sidelink"><?php echo $text['mnuadvancedsearch']; ?></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center">
                                                    <a href="surnames.php" class="sidelink"><?php echo $text['mnulastnames']; ?></a>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div id="searchformblock">
                                        <label for="myfirstname"><small><?php echo $text['firstname']; ?>:</small></label>
                                        <br>
                                        <input id="myfirstname" class="searchbox" name="myfirstname" type="search">
                                        <br>
                                        <label for="mylastname"><small><?php echo $text['lastname']; ?>:</small></label>
                                        <br>
                                        <input id="mylastname" class="searchbox" name="mylastname" type="search">
                                        <br>
                                        <input name="mybool" type="hidden" value="AND">
                                    </div>
                                    <div id="searcharrowblock">
                                        <input class="indexsubmit" name="imgsubmit" src="<?php echo $templatepath; ?>img/button.jpg" type="image" style="border: none;" alt="">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div style="display:inline;">
                            <img src="<?php echo $templatepath; ?><?php echo $tmp['t2_mainimage']; ?>" alt="" width="327"
                                style="max-height:460px;" class="noimgborder rounded10" id="mainphoto"><br><br>
                        </div>
                        <div style="clear:left;"></div>
                    </div>
                </td>
            </tr>
        </table>
        <div class="footer">
            <p><a href="changelanguage.php" class="footer"><?php echo $text['mnulanguage']; ?></a></p>

            <?php
            $flags['basicfooter'] = true;
            tng_footer($flags);
            ?>
        </div>
    </div>
    <script>
        document.forms.searchform.myfirstname.focus();
    </script>

<?php echo "</body>"; ?>
<?php echo "</html>"; ?>