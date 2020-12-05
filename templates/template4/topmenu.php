<?php
global $currentuser, $currentuserdesc, $allow_admin, $tmp, $mediatypes;
?>

<body id="bodytop" class="<?php echo pathinfo(basename($_SERVER['SCRIPT_NAME']), PATHINFO_FILENAME); ?> publicback">

<div class="text-center">
    <table class="page">
        <tr>
            <td colspan="4" class="line"></td>
        </tr>
        <tr>
            <td class="menuback">
                <a href="searchform.php" class="searchimg"><?php echo _("Search"); ?></a>
                <form action="search.php" method="get">
                    <table class="menuback">
                        <tr>
                            <td><span class="fieldname"><?php echo _("First Name"); ?>:<br><input type="search" name="myfirstname"
                                        class="searchbox" size="14"></span></td>
                        </tr>
                        <tr>
                            <td><span class="fieldname"><?php echo _("Last Name"); ?>: <br><input type="search" name="mylastname"
                                        class="searchbox" size="14"></span></td>
                        </tr>
                        <tr>
                            <td>
                                <input type="hidden" name="mybool" value="AND">
                                <input type="submit" name="search" value="<?php echo _("Search"); ?>" class="small">
                            </td>
                        </tr>
                    </table>
                </form>
                <table class="menuback">
                    <tr>
                        <td>
                            <div class="fieldname">
                                <ul>
                                    <li><a href="searchform.php"
                                            class="lightlink"><?php echo _("Advanced Search"); ?></a></li>
                                    <li><a href="surnames.php" class="lightlink"><?php echo _("Surnames"); ?></a>
                                    </li>
                                </ul>
                                <?php
                                if ($currentuser) {
                                    echo "<p><span class=\"emphasisyellow\">&nbsp;&nbsp;" . _("Welcome") . ", $currentuserdesc.</span></p>\n";
                                    echo "<ul>\n";
                                    echo "<li><a href=\"logout.php\" class='lightlink'>" . _("Log Out") . "</a></li>\n";
                                } else {
                                    echo "<ul>\n";
                                    echo "<li><a href=\"login.php\" class='lightlink'>" . _("Log In") . "</a></li>\n";
                                }
                                echo "<li><a href=\"whatsnew.php\" class='lightlink'>" . _("What's New") . "</a></li>\n";
                                echo "<li><a href=\"mostwanted.php\" class='lightlink'>" . _("Most Wanted") . "</a></li>\n";

                                foreach ($mediatypes as $mediatype) {
                                    if (!$mediatype['disabled']) {
                                        echo "<li><a href=\"browsemedia.php?mediatypeID={$mediatype['ID']}\" class='lightlink'>{$mediatype['display']}</a></li>\n";
                                    }
                                }

                                echo "<li><a href=\"browsealbums.php\" class='lightlink'>" . _("Albums") . "</a></li>\n";
                                echo "<li><a href=\"browsemedia.php\" class='lightlink'>" . _("All Media") . "</a></li>\n";
                                echo "<li><a href=\"cemeteries.php\" class='lightlink'>" . _("Cemeteries") . "</a></li>\n";
                                echo "<li><a href=\"places.php\" class='lightlink'>" . _("Places") . "</a></li>\n";
                                echo "<li><a href=\"browsenotes.php\" class='lightlink'>" . _("Notes") . "</a></li>\n";
                                echo "<li><a href=\"anniversaries.php\" class='lightlink'>" . _("Dates and Anniversaries") . "</a></li>\n";
                                echo "<li><a href=\"calendar.php\" class='lightlink'>" . _("Calendar") . "</a></li>\n";
                                echo "<li><a href=\"reports.php\" class='lightlink'>" . _("Reports") . "</a></li>\n";
                                echo "<li><a href=\"browsesources.php\" class='lightlink'>" . _("Sources") . "</a></li>\n";
                                echo "<li><a href=\"browserepos.php\" class='lightlink'>" . _("Repositories") . "</a></li>\n";
                                if (!$tngconfig['hidedna']) {
                                    echo "<li><a href=\"browse_dna_tests.php\" class='lightlink'>" . _("DNA Tests") . "</a></li>\n";
                                }
                                echo "<li><a href=\"statistics.php\" class='lightlink'>" . _("Statistics") . "</a></li>\n";
                                echo "<li><a href=\"changelanguage.php\" class='lightlink'>" . _("Change Language") . "</a></li>\n";
                                if ($allow_admin) {
                                    echo "<li><a href=\"showlog.php\" class='lightlink'>" . _("Access Log") . "</a></li>\n";
                                    echo "<li><a href=\"admin.php\" class='lightlink'>" . _("Administration") . "</a></li>\n";
                                }
                                echo "<li><a href=\"bookmarks.php\" class='lightlink'>" . _("Bookmarks") . "</a></li>\n";
                                echo "<li><a href=\"suggest.php?page=$title\" class='lightlink'>" . _("Contact Us") . "</a></li>\n";
                                if (!$currentuser && !$tngconfig['disallowreg']) {
                                    echo "<li><a href=\"newacctform.php\" class='lightlink'>" . _("Register for a User Account") . "</a></li>\n";
                                }
                                ?>
                                </ul>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
            <td class="spacercol">&nbsp;&nbsp;&nbsp;</td>
            <td class="content">
                <table class="table-full">
                    <tr>
                        <td>
                            <?php if ($tmp['t4_titlechoice'] == "text") { ?>
                                <div>
                                    <span class="titletop"><?php echo getTemplateMessage('t4_headtitle1'); ?></span><br>
                                    <span class="titlebottom">&nbsp;<?php echo getTemplateMessage('t4_headtitle2'); ?></span>

                                </div>
                            <?php } else { ?>
                                <img src="<?php echo $templatepath; ?><?php echo $tmp['t4_titleimg']; ?>" alt="" class="banner" width="468" height="100">
                            <?php } ?>

                        </td>
                        <td><img src="<?php echo $templatepath; ?><?php echo $tmp['t4_headimg']; ?>" alt="" class="smallphoto"></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="line"></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="normal" style="border-collapse:separate;"><br>
