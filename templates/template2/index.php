<?php
global $allow_admin;
$tngconfig['showshare'] = false;
$flags = ['noicons' => true, 'noheader' => true, 'nobody' => true];
echo "<!doctype html>\n";
echo "<html lang='en'>\n";
$headElement = new HeadElementPublic($sitename ? "" : _("Our Family Genealogy Pages"), $flags);
echo $headElement->getHtml();
standardHeaderVariants($headElement, $flags);
echo "<body id='bodytop' class='" . pathinfo(basename($_SERVER['SCRIPT_NAME']), PATHINFO_FILENAME) . " bodyindex'>\n";
if ($tngconfig['maint']) {
    echo "<span class='p-1 fieldnameback yellow'><strong>" . _("Maintenance Mode is ON") . "</strong></span><br><br>\n";
}
$title = getTemplateMessage('t2_maintitle');
$mainpara = getTemplateMessage('t2_mainpara');
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

    <div class="md:w-11/12 mx-auto">
        <table class="w-full p-0 rounded-lg indexpage">
            <tr>
                <td>
                    <div class="rounded-lg databack">
                        <div class="inline float-left">
                            <?php if ($tmp['t2_titlechoice'] == "text") { ?>
                                <div id="titlecontainer">
                                    <em class="maintitle"><?php echo $title; ?></em>
                                </div>
                            <?php } else { ?>
                                <img src="<?php echo $templatepath; ?><?php echo $tmp['t2_titleimage']; ?>" alt="" width="443" height="114" class="rounded-lg noimgborder">
                            <?php } ?>
                            <?php if ($mainpara) echo "<div class='pl-5 max-w-md'>$mainpara</div><br>\n"; ?>
                            <a href="pedigree.php?personID=<?php echo $tmp['t2_pedperson']; ?>&amp;tree=<?php echo $tmp['t2_pedtree']; ?>"
                                class="mainlink smalltitle">&#8226; <?php echo _("Pedigree"); ?></a>
                            <a href="extrastree.php?personID=<?php echo $tmp['t2_phhistperson']; ?>&amp;tree=<?php echo $tmp['t2_phhisttree']; ?>"
                                class="mainlink smalltitle">&#8226; <?php echo _("Photos &amp; Histories"); ?></a>

                            <div id="linktable" class="my-4">
                                <table>
                                    <tr>
                                        <td rowspan="6" class="pr-3"></td>
                                        <td class='align-top'>
                                            <?php
                                            if ($currentuser) {
                                                echo "<a href='logout.php' class='sidelink'>" . strtoupper(_("Log Out")) . "</a>\n";
                                            } else {
                                                echo "<a href='login.php' class='sidelink'>" . strtoupper(_("Log In")) . "</a>\n";
                                            }
                                            ?>
                                        </td>
                                        <td class="pr-2"></td>
                                        <td><a href="whatsnew.php" class="sidelink"><?php echo _("What's New"); ?></a></td>
                                        <td class="pr-2"></td>
                                        <td><a href="statistics.php" class="sidelink"><?php echo _("Statistics"); ?></a></td>
                                        <td class="pr-2"></td>
                                        <td><a href="anniversaries.php" class="sidelink"><?php echo _("Dates and Anniversaries"); ?></a></td>
                                    </tr>
                                    <tr>
                                        <td><a href="browsemedia.php?mediatypeID=photos" class="sidelink"><?php echo _("Photos"); ?></a></td>
                                        <td></td>
                                        <td><a href="browsemedia.php?mediatypeID=histories" class="sidelink"><?php echo _("Histories"); ?></a></td>
                                        <td></td>
                                        <td><a href="cemeteries.php" class="sidelink"><?php echo _("Cemeteries"); ?></a></td>
                                        <td></td>
                                        <td><a href="places.php" class="sidelink"><?php echo _("Places"); ?></a></td>
                                    </tr>
                                    <tr>
                                        <td><a href="browsemedia.php?mediatypeID=documents" class="sidelink"><?php echo _("Documents"); ?></a></td>
                                        <td></td>
                                        <td><a href="browsemedia.php" class="sidelink"><?php echo _("All Media"); ?></a></td>
                                        <td></td>
                                        <td><a href="browsemedia.php?mediatypeID=headstones" class="sidelink"><?php echo _("Headstones"); ?></a></td>
                                        <td></td>
                                        <td><a href="browsealbums.php" class="sidelink"><?php echo _("Albums"); ?></a></td>
                                    </tr>
                                    <tr>
                                        <td><a href="reports.php" class="sidelink"><?php echo _("Reports"); ?></a></td>
                                        <td></td>
                                        <td><a href="browsesources.php" class="sidelink"><?php echo _("Sources"); ?></a></td>
                                        <td></td>
                                        <td><a href="bookmarks.php" class="sidelink"><?php echo _("Bookmarks"); ?></a></td>
                                        <td></td>
                                        <td><a href="suggest.php?page=<?php echo $title; ?>" class="sidelink"><?php echo _("Contact Us"); ?></a></td>
                                    </tr>
                                    <tr>
                                        <td><a href="mostwanted.php" class="sidelink"><?php echo _("Most Wanted"); ?></a></td>
                                        <td></td>
                                        <td><a href="browserepos.php" class="sidelink"><?php echo _("Repositories"); ?></a></td>
                                        <td></td>
                                        <td><a href="showlog.php" class="sidelink"><?php if ($allow_admin) {
                                                    echo _("Access Log");
                                                } ?></a></td>
                                        <td></td>
                                        <td><a href="admin.php" class="sidelink"><?php if ($allow_admin) {
                                                    echo _("Administration");
                                                } ?></a></td>
                                    </tr>
                                    <?php if (!$currentuser && !$tngconfig['disallowreg']) { ?>
                                        <tr class="mt-4">
                                            <td colspan="4"><a href="newacctform.php" class="sidelink"><?php echo _("Register for a User Account"); ?></a></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </div>
                            <form id="form1" name="searchform" action="search.php" method="get">
                                <div id="searchblock" class="flex">
                                    <div id="searchtitleblock">
                                        <span class="smalltitle"><?php echo _("Search"); ?></span>
                                        <table>
                                            <tr>
                                                <td><a href="searchform.php" class="sidelink"><?php echo _("Advanced Search"); ?></a></td>
                                            </tr>
                                            <tr>
                                                <td><a href="surnames.php" class="sidelink"><?php echo _("Surnames"); ?></a></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div id="searchformblock">
                                        <label for="myfirstname"><small><?php echo _("First Name"); ?>:</small></label>
                                        <br>
                                        <input id="myfirstname" class="searchbox" name="myfirstname" type="search">
                                        <br>
                                        <label for="mylastname"><small><?php echo _("Last Name"); ?>:</small></label>
                                        <br>
                                        <input id="mylastname" class="searchbox" name="mylastname" type="search">
                                        <input name="mybool" type="hidden" value="AND">
                                    </div>
                                    <div id="searcharrowblock">
                                        <input class="indexsubmit" name="imgsubmit" src="<?php echo $templatepath; ?>img/button.jpg" type="image" alt="">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div style="display:inline;">
                            <img src="<?php echo $templatepath; ?><?php echo $tmp['t2_mainimage']; ?>" alt="" id="mainphoto" class="rounded-lg noimgborder" style="max-height: 460px;" width="327"><br><br>
                        </div>
                        <div style="clear:left;"></div>
                    </div>
                </td>
            </tr>
        </table>
        <div class="footer">
            <p><a href="changelanguage.php" class="footer"><?php echo _("Change Language"); ?></a></p>
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