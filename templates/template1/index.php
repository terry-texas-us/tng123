<?php
$tngconfig['showshare'] = false;
$flags['noicons'] = true;
$flags['noheader'] = true;
$flags['nobody'] = true;

echo "<!doctype html>\n";
echo "<html lang='en'>\n";

tng_header($sitename ? "" : $text['ourhist'], $flags);
if ($sitever != "mobile") {
    echo "<body id='bodytop' class='" . pathinfo(basename($_SERVER['SCRIPT_NAME']), PATHINFO_FILENAME) . "'>\n";
}
$title = getTemplateMessage('t1_maintitle');
?>
    <br>
    <div class="m-auto w-75">
        <table class="indexpage">
            <tr>
                <td colspan="3">
                    <img id="mainphoto" class="border-0 float-left" src="<?php echo $templatepath; ?><?php echo $tmp['t1_mainimage']; ?>" alt="">

                    <?php if ($tmp['t1_titlechoice'] == "text" || $sitever == "mobile") { ?>
                        <em class="maintitle"><?php echo $title; ?></em>
                    <?php } else { ?>
                        <img class="ml-2" src="<?php echo $templatepath; ?><?php echo $tmp['t1_titleimage']; ?>" alt="">
                    <?php } ?>
                    <br>
                </td>
            </tr>
            <tr>
                <td class="normal align-top">
                    <?php
                    if ($currentuser) {
                        echo "<p><strong>{$text['welcome']}, $currentuserdesc.</strong></p>\n";
                    }
                    ?>
                    <h2><?php echo $text['mnusearchfornames']; ?></h2>

                    <form method="get" name="searchform" action="search.php">
                        <label for="myfirstname"><?php echo $text['firstname']; ?></label>
                        <br>
                        <input type="text" value="" name="myfirstname">
                        <br>
                        <label for="mylastname"><?php echo $text['lastname']; ?></label>
                        <br>
                        <input type="text" value="" name="mylastname">
                        <br>
                        <input type="hidden" name="mybool" value="AND">
                        <input type="submit" id="search-submit" value="<?php echo $text['search']; ?>">
                    </form>

                    <br>
                    <?php
                    if ($chooselang) {
                        $query = "SELECT languageID, display, folder FROM $languages_table ORDER BY display";
                        $result = tng_query($query);
                        $numlangs = tng_num_rows($result);

                        if ($numlangs > 1) {
                            echo getFORM("savelanguage2", "get", "tngmenu3", "");
                            echo "<select name='newlanguage3' id='newlanguage3' onchange='document.tngmenu3.submit();'>\n";

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
                    }
                    $mainpara = getTemplateMessage('t1_mainpara');
                    ?>
                </td>
                <td class="std-only">&nbsp;&nbsp;</td>
                <td class="normal std-only align-top">
                    <h2><?php echo $text['welcome']; ?></h2>
                    <?php
                    if ($mainpara) {
                        echo "<div>$mainpara</div>\n";
                    }
                    ?>
                    <h2><?php echo $text['mnufeatures']; ?></h2>
                    <table class="w-100">
                        <tr>
                            <td class="align-top" style="width: 30%;">
                                <ul>
                                    <?php
                                    if ($currentuser) {
                                        echo "<li><a href='logout.php'>{$text['mnulogout']}</a></li>\n";
                                        if ($allow_admin) {
                                            echo "<li><a href='admin.php'>{$text['mnuadmin']}</a></li>\n";
                                        }
                                    } else {
                                        echo "<li><a href='login.php'>{$text['mnulogon']}</a></li>\n";
                                        if (!$tngconfig['disallowreg']) {
                                            echo "<li><a href='newacctform.php'>{$text['mnuregister']}</a></li>\n";
                                        }
                                    }
                                    echo "<li><a href='surnames.php'>{$text['mnulastnames']}</a></li>\n";
                                    echo "<li><a href='searchform.php'>{$text['mnuadvancedsearch']}</a></li>\n";
                                    echo "<li><a href='famsearchform.php'>{$text['searchfams']}</a></li>\n";
                                    echo "<li><a href='searchsite.php'>{$text['searchsitemenu']}</a></li>\n";
                                    echo "<li><a href='places.php'>{$text['places']}</a></li>\n";
                                    echo "<li><a href='anniversaries.php'>{$text['anniversaries']}</a></li>\n";
                                    echo "<li><a href='calendar.php'>{$text['calendar']}</a></li>\n";
                                    echo "<li><a href='cemeteries.php'>{$text['mnucemeteries']}</a></li>\n";
                                    echo "<li><a href='bookmarks.php'>{$text['bookmarks']}</a></li>\n";
                                    ?>
                                </ul>
                            </td>
                            <td style="width: 5%;"></td>
                            <td class="align-top" style="width: 30%;">
                                <ul>
                                    <?php
                                    foreach ($mediatypes as $mediatype) {
                                        if (!$mediatype['disabled']) {
                                            echo "<li><a href='browsemedia.php?mediatypeID={$mediatype['ID']}'>{$mediatype['display']}</a></li>\n";
                                        }
                                    }
                                    echo "<li><a href='browsemedia.php'>{$text['allmedia']}</a></li>\n";
                                    echo "<li><a href='browsealbums.php'>{$text['albums']}</a></li>\n";
                                    ?>
                                </ul>
                            </td>
                            <td style="width: 5%;"></td>
                            <td class="align-top" style="width: 30%;">
                                <ul>
                                    <?php
                                    echo "<li><a href='whatsnew.php'>{$text['mnuwhatsnew']}</a></li>\n";
                                    echo "<li><a href='mostwanted.php'>{$text['mostwanted']}</a></li>\n";
                                    echo "<li><a href='reports.php'>{$text['mnureports']}</a></li>\n";
                                    echo "<li><a href='statistics.php'>{$text['mnustatistics']}</a></li>\n";
                                    echo "<li><a href='browsetrees.php'>{$text['trees']}</a></li>\n";
                                    echo "<li><a href='browsenotes.php'>{$text['notes']}</a></li>\n";
                                    echo "<li><a href='browsesources.php'>{$text['mnusources']}</a></li>\n";
                                    echo "<li><a href='browserepos.php'>{$text['repositories']}</a></li>\n";
                                    if (!$tngconfig['hidedna']) {
                                        echo "<li><a href='browse_dna_tests.php'>{$text['dna_tests']}</a></li>\n";
                                    }
                                    if ($allow_admin) {
                                        echo "<li><a href='showlog.php'>{$text['mnushowlog']}</a></li>\n";
                                    }
                                    echo "<li><a href='suggest.php?page=$title'>{$text['contactus']}</a></li>\n";
                                    ?>
                                </ul>
                                <br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <hr>
        <?php
        $flags['basicfooter'] = true;
        tng_footer($flags);
        ?>
    </div>
<?php echo "</body>\n"; ?>
<?php echo "</html>"; ?>