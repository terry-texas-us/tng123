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
    echo "<body id='bodytop' class='" . pathinfo(basename($_SERVER['SCRIPT_NAME']), PATHINFO_FILENAME) . " m-2'>\n";
}
if ($tngconfig['maint']) {
    echo "<span class='fieldnameback yellow p-1'><strong>{$text['mainton']}</strong></span><br><br>\n";
}
?>
<div>
    <table cellspacing="0" id="headertable">
        <tr>
            <?php
            $title = str_replace(["<br>", "<br>"], " ", getTemplateMessage('t7_maintitle'));
            if ($tmp['t7_titlechoice'] == "text" || isMobile()) {
                ?>
                <td class="logo" style="background:url(<?php echo $templatepath; ?>img/logoedge.gif) no-repeat right #DCD5B9;">
                    <div style="padding:10px;">
                        <em id="maintitle"><?php echo getTemplateMessage('t7_maintitle'); ?></em>
                    </div>
                </td>
            <?php } else { ?>
                <td class="logo">
                    <img src="<?php echo $templatepath; ?><?php echo $tmp['t7_titleimg']; ?>" alt="">
                </td>
            <?php } ?>
            <td class="news">
                <div><span class="emphasis"><?php echo $text['news']; ?>:</span>
                    <?php echo getTemplateMessage('t7_newstext'); ?>
                </div>
            </td>
        </tr>
    </table>
    <form action="search.php" method="get">
        <table class="w-full" cellspacing="0">
            <tr class="strip">
                <td class="fieldnameback">
                    <span class="fieldname">
                        <label class="text-nowrap"><?php echo $text['mnufirstname']; ?>: <input type="search" name="myfirstname"></label>
                        <label class="text-nowrap pl-2"><?php echo $text['mnulastname']; ?>: <input type="search" name="mylastname"></label>
                        <input type="hidden" name="mybool" value="AND"><input type="hidden" name="offset" value="0">
                        <span class="px-2"><input type="submit" name="search" value="<?php echo $text['mnusearch']; ?>"></span>
                    </span>
                </td>
            </tr>
        </table>
    </form>

    <table class="page w-full" cellspacing="0">
        <tr>
            <td class="section">

                <table width="193" cellspacing="0">
                    <tr>
                        <td class="tableheader"></td>
                        <td class="fieldname">
                            <?php
                            if ($currentuser) {
                                echo "<a href='logout.php' class='lightlink'>{$text['mnulogout']}</a><br>\n";
                            } else {
                                echo "<a href='login.php' class='lightlink'>{$text['mnulogon']}</a><br>\n";
                            }
                            echo "<a href='searchform.php' class='lightlink'>{$text['mnuadvancedsearch']}</a><br>\n";
                            echo "<a href='surnames.php' class='lightlink'>{$text['mnulastnames']}</a><br>\n";
                            echo "<a href='whatsnew.php' class='lightlink'>{$text['mnuwhatsnew']}</a><br>\n";
                            echo "<a href='mostwanted.php' class='lightlink'>{$text['mostwanted']}</a><br>\n";

                            foreach ($mediatypes as $mediatype) {
                                if (!$mediatype['disabled']) {
                                    echo "<a href='browsemedia.php?mediatypeID={$mediatype['ID']}' class='lightlink'>{$mediatype['display']}</a><br>\n";
                                }
                            }

                            echo "<a href='browsealbums.php' class='lightlink'>{$text['albums']}</a><br>\n";
                            echo "<a href='browsemedia.php' class='lightlink'>{$text['allmedia']}</a><br>\n";
                            echo "<a href='cemeteries.php' class='lightlink'>{$text['mnucemeteries']}</a><br>\n";
                            echo "<a href='places.php' class='lightlink'>{$text['places']}</a><br>\n";
                            echo "<a href='browsenotes.php' class='lightlink'>{$text['notes']}</a><br>\n";
                            echo "<a href='anniversaries.php' class='lightlink'>{$text['anniversaries']}</a><br>\n";
                            echo "<a href='calendar.php' class='lightlink'>{$text['calendar']}</a><br>\n";
                            echo "<a href='reports.php' class='lightlink'>{$text['mnureports']}</a><br>\n";
                            echo "<a href='browsesources.php' class='lightlink'>{$text['mnusources']}</a><br>\n";
                            echo "<a href='browserepos.php' class='lightlink'>{$text['repositories']}</a><br>\n";
                            if (!$tngconfig['hidedna']) {
                                echo "<a href='browse_dna_tests.php' class='lightlink'>{$text['dna_tests']}</a><br>\n";
                            }
                            echo "<a href='statistics.php' class='lightlink'>{$text['mnustatistics']}</a><br>\n";
                            echo "<a href='changelanguage.php' class='lightlink'>{$text['mnulanguage']}</a><br>\n";
                            if ($allow_admin) {
                                echo "<a href='showlog.php' class='lightlink'>{$text['mnushowlog']}</a><br>\n";
                                echo "<a href='admin.php' class='lightlink'>{$text['mnuadmin']}</a><br>\n";
                            }
                            echo "<a href='bookmarks.php' class='lightlink'>{$text['bookmarks']}</a><br>\n";
                            echo "<a href='suggest.php?page=$title' class='lightlink'>{$text['contactus']}</a><br>\n";
                            if (!$currentuser && !$tngconfig['disallowreg']) {
                                echo "<a href='newacctform.php' class='lightlink'>{$text['mnuregister']}</a><br>\n";
                            }
                            ?>
                        </td>
                    </tr>

                </table>
            </td>
            <td class='align-top'>
                <table class="bodytable" cellspacing="0">
                    <tr>
                        <td colspan="2"></td>
                    </tr>
                    <tr>
                        <td class="spacercol">&nbsp;&nbsp;&nbsp;</td>
                        <td class='align-top'>
                            <table class="bodytable" cellspacing="0">
                                <tr>
                                    <td class="maincontent"><br>
                                        <img src="<?php echo $templatepath; ?><?php echo $tmp['t7_mainimage']; ?>" alt=""
                                            class="bigphoto"><br>
                                        <span class="smaller">&nbsp;&nbsp;<i><?php echo getTemplateMessage('t7_photocaption'); ?></i><br></span>
                                        <div class="normal">
                                            <h3 class="emphasis"><?php echo getTemplateMessage('t7_headline'); ?></h3>
                                            <?php echo getTemplateMessage('t7_mainpara'); ?>
                                        </div> <!-- end of normal div -->
                                    </td>
                                    <td class="middlecol">&nbsp;&nbsp;&nbsp;</td>
                                    <td class="rightcontent"><br>
                                        <table width="200" cellspacing="0">
                                            <tr>
                                                <td class='align-top'><span class="emphasis"><?php echo $text['latupdates']; ?></span></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="line"></td>
                                            </tr>
                                            <tr>
                                                <td><span class="smallest">&nbsp;</span></td>
                                            </tr>
                                            <tr>
                                                <td class='align-top'>
                                                    <div class="normal">
                                                        <?php
                                                        $tngquery = "SELECT lastname, firstname, changedate, personID, gedcom, living, private, branch, lnprefix, title, suffix, prefix FROM $people_table ORDER BY changedate DESC LIMIT 10";
                                                        $resulttng = tng_query($tngquery) or die($text['cannotexecutequery'] . ": $tngquery");

                                                        $found = tng_num_rows($resulttng);
                                                        while ($dbrow = tng_fetch_assoc($resulttng)) {
                                                            $lastadd .= "<a href='getperson.php?personID={$dbrow['personID']}&amp;tree={$dbrow['gedcom']}'>";

                                                            $dbrights = determineLivingPrivateRights($dbrow);
                                                            $dbrow['allow_living'] = $dbrights['living'];
                                                            $dbrow['allow_private'] = $dbrights['private'];

                                                            $lastadd .= getNameRev($dbrow);
                                                            $lastadd .= "</a><br>\n";
                                                        }
                                                        tng_free_result($resulttng);
                                                        echo $lastadd
                                                        ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class='align-top'><span class="normal">&nbsp;</span></td>
                                            </tr>
                                            <tr>
                                                <td class='align-top'><span class="emphasis"><?php echo $text['featphoto']; ?></span></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="line"></td>
                                            </tr>
                                            <tr>
                                                <td><span class="smallest">&nbsp;</span></td>
                                            </tr>
                                            <tr>
                                                <td class='align-top'>
                                                    <div class="normal">
                                                        <?php include "randomphoto.php"; ?>

                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td class="spacercol">&nbsp;&nbsp;</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <hr>
    <div class="footer">
        <?php
        $flags['basicfooter'] = true;
        tng_footer($flags);
        ?>
    </div>
</div>

<?php echo "</body>"; ?>
<?php echo "</html>"; ?>"