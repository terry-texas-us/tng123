<?php

global $allow_admin;
$tngconfig['showshare'] = false;
$flags = ['noicons' => true, 'noheader' => true, 'nobody' => true];
echo "<!doctype html>\n";
echo "<html lang='en'>\n";
$headElement = new HeadElementPublic($sitename ? "" : _("Our Family Genealogy Pages"), $flags);
echo $headElement->getHtml();
standardHeaderVariants($headElement, $flags);
echo "<body id='bodytop' class='" . pathinfo(basename($_SERVER['SCRIPT_NAME']), PATHINFO_FILENAME) . " m-2'>\n";
if ($tngconfig['maint']) {
    echo "<span class='fieldnameback yellow p-1'><strong>" . _("Maintenance Mode is ON") . "</strong></span><br><br>\n";
}
?>
<div>
    <table cellspacing="0" id="headertable">
        <tr>
            <?php
            $title = str_replace(["<br>", "<br>"], " ", getTemplateMessage('t7_maintitle'));
            if ($tmp['t7_titlechoice'] == "text") {
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
                <div><span class="emphasis"><?php echo _("News"); ?>:</span>
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
                        <label class="whitespace-no-wrap"><?php echo _("First Name"); ?>: <input type="search" name="myfirstname"></label>
                        <label class="whitespace-no-wrap pl-2"><?php echo _("Last Name"); ?>: <input type="search" name="mylastname"></label>
                        <input type="hidden" name="mybool" value="AND"><input type="hidden" name="offset" value="0">
                        <span class="px-2"><input type="submit" name="search" value="<?php echo _("Search"); ?>"></span>
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
                                echo "<a href='logout.php' class='lightlink'>" . _("Log Out") . "</a><br>\n";
                            } else {
                                echo "<a href='login.php' class='lightlink'>" . _("Log In") . "</a><br>\n";
                            }
                            echo "<a href='searchform.php' class='lightlink'>" . _("Advanced Search") . "</a><br>\n";
                            echo "<a href='surnames.php' class='lightlink'>" . _("Surnames") . "</a><br>\n";
                            echo "<a href='whatsnew.php' class='lightlink'>" . _("What's New") . "</a><br>\n";
                            echo "<a href='mostwanted.php' class='lightlink'>" . _("Most Wanted") . "</a><br>\n";

                            foreach ($mediatypes as $mediatype) {
                                if (!$mediatype['disabled']) {
                                    echo "<a href='browsemedia.php?mediatypeID={$mediatype['ID']}' class='lightlink'>{$mediatype['display']}</a><br>\n";
                                }
                            }

                            echo "<a href='browsealbums.php' class='lightlink'>" . _("Albums") . "</a><br>\n";
                            echo "<a href='browsemedia.php' class='lightlink'>" . _("All Media") . "</a><br>\n";
                            echo "<a href='cemeteries.php' class='lightlink'>" . _("Cemeteries") . "</a><br>\n";
                            echo "<a href='places.php' class='lightlink'>" . _("Places") . "</a><br>\n";
                            echo "<a href='browsenotes.php' class='lightlink'>" . _("Notes") . "</a><br>\n";
                            echo "<a href='anniversaries.php' class='lightlink'>" . _("Dates and Anniversaries") . "</a><br>\n";
                            echo "<a href='calendar.php' class='lightlink'>" . _("Calendar") . "</a><br>\n";
                            echo "<a href='reports.php' class='lightlink'>" . _("Reports") . "</a><br>\n";
                            echo "<a href='browsesources.php' class='lightlink'>" . _("Sources") . "</a><br>\n";
                            echo "<a href='browserepos.php' class='lightlink'>" . _("Repositories") . "</a><br>\n";
                            if (!$tngconfig['hidedna']) {
                                echo "<a href='browse_dna_tests.php' class='lightlink'>" . _("DNA Tests") . "</a><br>\n";
                            }
                            echo "<a href='statistics.php' class='lightlink'>" . _("Statistics") . "</a><br>\n";
                            echo "<a href='changelanguage.php' class='lightlink'>" . _("Change Language") . "</a><br>\n";
                            if ($allow_admin) {
                                echo "<a href='showlog.php' class='lightlink'>" . _("Access Log") . "</a><br>\n";
                                echo "<a href='admin.php' class='lightlink'>" . _("Administration") . "</a><br>\n";
                            }
                            echo "<a href='bookmarks.php' class='lightlink'>" . _("Bookmarks") . "</a><br>\n";
                            echo "<a href='suggest.php?page=$title' class='lightlink'>" . _("Contact Us") . "</a><br>\n";
                            if (!$currentuser && !$tngconfig['disallowreg']) {
                                echo "<a href='newacctform.php' class='lightlink'>" . _("Register for a User Account") . "</a><br>\n";
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
                                                <td class='align-top'><span class="emphasis"><?php echo _("Latest Updates"); ?></span></td>
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
                                                        $resulttng = tng_query($tngquery) or die(_("Cannot execute query") . ": $tngquery");

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
                                                <td class='align-top'><span class="emphasis"><?php echo _("Featured Photo"); ?></span></td>
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