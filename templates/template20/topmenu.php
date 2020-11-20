<?php

global $subroot, $currentuser, $currentuserdesc, $allow_admin, $tmp, $mediatypes, $rootpath;
?>

<body id="bodytop" class="<?php echo pathinfo(basename($_SERVER['SCRIPT_NAME']), PATHINFO_FILENAME); ?> publicback">

<div class="scroll-to-top"><a href="#"><img src="img/backtotop.png" alt=""/></a></div>

<div id="hidden">
    <input type="hidden" id="imageplus" value="<?php echo $templatepath . "img/plus.gif"; ?> ">
    <input type="hidden" id="imageminus" value="<?php echo $templatepath . "img/minus.gif"; ?> ">
</div>
<?php
echo "<script>\n";
echo "var imgplus = document.getElementById('imageplus').value; \n";
echo "var imgminus = document.getElementById('imageminus').value; \n";
echo "</script>\n";
?>
<div class="page">
    <div id="header">
        <div id="leftphoto">
            <img src="<?php echo $templatepath; ?><?php echo $tmp['t20_leftimg']; ?>" alt="left-photo" class="leftphoto"/>
        </div>

        <div id="banner">

            <?php
            /* The Banner Option controls how the page title or banner is displayed, valid options are:
                    image - uses the Template Settings Title image file
                    text - uses the Template Settings Title 1 and 2 text variables */

            if ($tmp['t20_titlechoice'] == "image") {
                ?>
                <img src="<?php echo $templatepath; ?><?php echo $tmp['t20_titleimg']; ?>" alt="" class="banner"/>

                <?php
            } elseif ($tmp['t20_titlechoice'] == "text") {
                ?>
                <div id="textbanner">
			<span class="titletop"><?php
                echo getTemplateMessage('t20_headtitle1'); ?></span><br>
                    <span class="titlebottom">&nbsp;<?php
                        echo getTemplateMessage('t20_headtitle2'); ?></span>
                </div>
                <?php
            }
            ?>

            <!--  Pedigree links in page banner section -->

            <div id="tmenu">
                <ul>
                    <?php

                    // check which Pedigree links are defined

                    $mydadlabel = getTemplateMessage('t20_dadside');
                    $mymomlabel = getTemplateMessage('t20_momside');
                    $spdadlabel = getTemplateMessage('t20_spdadside');
                    $spmomlabel = getTemplateMessage('t20_spmomside');

                    if ($mydadlabel) {
                        ?>
                        <li>
                            <a href="pedigree.php?personID=<?php echo $tmp['t20_dadperson']; ?>&amp;tree=<?php echo $tmp['t20_dadtree']; ?>"><?php echo $mydadlabel; ?></a>
                        </li>
                        <?php
                    }
                    if ($mymomlabel) {
                        ?>
                        <li>
                            <a href="pedigree.php?personID=<?php echo $tmp['t20_momperson']; ?>&amp;tree=<?php echo $tmp['t20_momtree']; ?>"><?php echo $mymomlabel; ?></a>
                        </li>
                        <?php
                    }
                    if ($spdadlabel) {
                        ?>
                        <li>
                            <a href="pedigree.php?personID=<?php echo $tmp['t20_spdadperson']; ?>&amp;tree=<?php echo $tmp['t20_spdadtree']; ?>"><?php echo $spdadlabel; ?></a>
                        </li>
                        <?php
                    }
                    if ($spmomlabel) {
                        ?>
                        <li>
                            <a href="pedigree.php?personID=<?php echo $tmp['t20_spmomperson']; ?>&amp;tree=<?php echo $tmp['t20_spmomtree']; ?>"><?php echo $spmomlabel; ?></a>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </div>        <!-- end of pedigree links div -->
        </div>    <!-- end of banner div -->
        <div id="rightphoto">
            <img src="<?php echo $templatepath; ?><?php echo $tmp['t20_rightimg']; ?>" alt="right-photo" class="rightphoto"/>
        </div>

    </div>  <!-- end of header div -->
    <div class="cleared reset-box"></div>

    <div class="colmask t20leftmenu">  <!--  end of colmask t20leftmenu div is in the footer.php -->
        <!-- <div id="templatecontainer">-->
        <div class="colleft">   <!-- end of colleft div is in the footer.php -->
            <!-- <div id="templateleft"> -->
            <div class="col2">  <!-- Column 2 start of left column -->
                <div class="menuback">
                    <?php
                    if ($currentuser) {
                        echo "<p class='blueemphasis'>&nbsp;&nbsp;" . _("Welcome") . ", $currentuserdesc.</p>\n";
                    } else {
                        echo "<p class='blueemphasis'>&nbsp;&nbsp;" . _("Welcome") . ", " . _("Visitor") . ".</p>\n";
                    }
                    ?>
                    <a href="searchform.php" class="searchimg"><?php echo _("Search"); ?></a>

                    <form action="search.php" method="get">
                        <p class="fieldname"><?php echo _("First Name"); ?>:<br>
                            <input type="text" name="myfirstname" class="searchbox" size="14"/>
                        </p>
                        <p class="fieldname"><?php echo _("Last Name"); ?>: <br>
                            <input type="text" name="mylastname" class="searchbox" size="14"/>
                        </p>
                        <input type="hidden" name="mybool" value="AND"/>
                        <input type="submit" name="search" value="<?php echo _("Search"); ?>" class="small"/>
                    </form>
                    <div id="leftnavmenu" class="fieldname">
                        <ul>
                            <li class="bullet"><a href="searchform.php" class="leftnavlink"><?php echo _("Advanced Search"); ?></a></li>
                            <li class="bullet"><a href="surnames.php" class="leftnavlink"><?php echo _("Surnames"); ?></a></li>
                        </ul>
                        <?php
                        if ($currentuser) {
                            echo "<ul>\n";
                            echo "<li class=\"bullet\"><a href=\"logout.php\" class=\"leftnavlink\">" . _("Log Out") . "</a></li>\n";
                        } else {
                            echo "<ul>\n";
                            echo "<li class=\"bullet\"><a href=\"login.php\" class=\"leftnavlink\">" . _("Log In") . "</a></li>\n";
                            if (!$currentuser && !$tngconfig['disallowreg'])
                                echo "<li class=\"bullet\"><a href=\"newacctform.php\" class=\"leftnavlink\">" . _("Register for a User Account") . "</a></li>\n";
                        }

                        echo "<li class=\"bullet\"><a href=\"changelanguage.php\" class=\"lightlink\">" . _("Change Language") . "</a></li>\n";
                        ?>
                        </ul><br>
                    </div>

                    <div class="arrowlistmenu">
                        <p class="whiteheader mt-0 text-base menuheader expandable">
                            <?php echo getTemplateMessage('t20_sidebarhead1'); ?>
                        </p>
                    </div>

                    <div id="ancestor" class="fieldname">
                        <ul class="categoryitems">

                            <?php

                            // Check if optional family headings are used
                            $mydadheading = getTemplateMessage('t20_dadheading');
                            $mymomheading = getTemplateMessage('t20_momheading');
                            $spdadheading = getTemplateMessage('t20_spdadheading');
                            $spmomheading = getTemplateMessage('t20_spmomheading');
                            //	optional Dad heading - suppress if not used
                            if ($mydadheading) {
                                ?>
                                <li class="bullet"><a href="<?php echo $tmp['t20_dadpagelink']; ?>"><?php echo getTemplateMessage('t20_dadheading'); ?></a></li>

                                <?php
                            }
                            if ($mydadlabel) {
                                ?>
                                <li class="bullet"><a href="pedigree.php?personID=<?php echo $tmp['t20_dadperson']; ?>&amp;tree=<?php echo $tmp['t20_dadtree']; ?>"><?php echo $mydadlabel; ?></a></li>
                                <?php
                            }
                            //	optional Mom heading - suppress if not used
                            if ($mymomheading) {
                                ?>

                                <li class="bullet"><a href="<?php echo $tmp['t20_mompagelink']; ?>"><?php echo getTemplateMessage('t20_momheading'); ?></a></li>

                                <?php
                            }
                            if ($mymomlabel) {
                                ?>
                                <li class="bullet"><a href="pedigree.php?personID=<?php echo $tmp['t20_momperson']; ?>&amp;tree=<?php echo $tmp['t20_momtree']; ?>"><?php echo $mymomlabel; ?></a></li>
                                <?php
                            }
                            //	optional Spouse Dad heading - suppress if not used
                            if ($spdadheading) {
                                ?>
                                <li class="bullet"><a href="<?php echo $tmp['t20_spdadpagelink']; ?>"><?php echo getTemplateMessage('t20_spdadheading'); ?></a></li>

                                <?php
                            }
                            if ($spdadlabel) {
                                ?>
                                <li class="bullet"><a href="pedigree.php?personID=<?php echo $tmp['t20_spdadperson']; ?>&amp;tree=<?php echo $tmp['t20_spdadtree']; ?>"><?php echo $spdadlabel; ?></a></li>
                                <?php
                            }
                            //	optional Spouse Mom heading - suppress if not used
                            if ($spmomheading) {
                                ?>
                                <li class="bullet"><a href="<?php echo $tmp['t20_spmompagelink']; ?>"><?php echo getTemplateMessage('t20_spmomheading'); ?></a></li>

                                <?php
                            }
                            if ($spmomlabel) {
                                ?>
                                <li class="bullet"><a href="pedigree.php?personID=<?php echo $tmp['t20_spmomperson']; ?>&amp;tree=<?php echo $tmp['t20_spmomtree']; ?>"><?php echo $spmomlabel; ?></a></li>
                                <?php
                            }
                            ?>
                        </ul>
                        <br>
                    </div>

                    <div class="arrowlistmenu">
                        <p class="whiteheader mt-0 text-base menuheader expandable">
                            <?php echo getTemplateMessage('t20_sidebarhead2'); ?>
                        </p>
                    </div>

                    <div id="stories" class="fieldname">
                        <ul class="categoryitems">
                            <li class="bullet"><a href="<?php echo $tmp['t20_featurelink1']; ?>"><?php echo getTemplateMessage('t20_featuretitle1'); ?></a></li>
                            <li class="bullet"><a href="<?php echo $tmp['t20_featurelink2']; ?>"><?php echo getTemplateMessage('t20_featuretitle2'); ?></a></li>
                            <li class="bullet"><a href="<?php echo $tmp['t20_featurelink3']; ?>"><?php echo getTemplateMessage('t20_featuretitle3'); ?></a></li>
                            <li class="bullet"><a href="<?php echo $tmp['t20_featurelink4']; ?>"><?php echo getTemplateMessage('t20_featuretitle4'); ?></a></li>
                            <li class="bullet"><a href="<?php echo $tmp['t20_featurelink5']; ?>"><?php echo getTemplateMessage('t20_featuretitle5'); ?></a></li>
                            <li class="bullet"><a href="<?php echo $tmp['t20_featurelink6']; ?>"><?php echo getTemplateMessage('t20_featuretitle6'); ?></a></li>

                        </ul>
                        <br>
                    </div>

                    <div class="arrowlistmenu">
                        <p class="whiteheader mt-0 text-base menuheader expandable">
                            <?php echo getTemplateMessage('t20_sidebarhead3'); ?>
                        </p>
                    </div>
                    <div id="gen" class="fieldname">
                        <ul class="categoryitems">
                            <?php
                            echo "<li class=\"bullet\"><a href=\"whatsnew.php\" class=\"lightlink\">" . _("What's New") . "</a></li>\n";
                            echo "<li class=\"bullet\"><a href=\"mostwanted.php\" class=\"lightlink\">" . _("Most Wanted") . "</a></li>\n";
                            echo "<li class=\"bullet\"><a href=\"reports.php\" class=\"lightlink\">" . _("Reports") . "</a></li>\n";
                            if (!$tngconfig['hidedna'])
                                echo "<li class=\"bullet\"><a href=\"browse_dna_tests.php\" class=\"lightlink\">" . _("DNA Tests") . "</a></li>\n";
                            echo "<li class=\"bullet\"><a href=\"statistics.php\" class=\"lightlink\">" . _("Statistics") . "</a></li>\n";
                            if ($allow_admin) {
                                echo "<li class=\"bullet\"><a href=\"showlog.php\" class=\"lightlink\">" . _("Access Log") . "</a></li>\n";
                                echo "<li class=\"bullet\"><a href=\"admin.php\" class=\"lightlink\">" . _("Administration") . "</a></li>\n";
                            }

                            ?>
                        </ul>
                        <br>
                    </div>    <!-- end of gen div  -->
                    <!-- </ul> <br> stray end tag -->

                </div>   <!-- end of menuback div -->
                <div class="cleared reset-box"></div>

            </div>  <!-- end of col2 div -->

            <div class="col1">  <!-- Column 1 start == center column -->
                <!-- <div id="templatecenter"> -->
                <div class="content">
