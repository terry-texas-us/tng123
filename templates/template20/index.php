<?php

$mydadheading = getTemplateMessage('t20_dadheading');
$mymomheading = getTemplateMessage('t20_momheading');
$spdadheading = getTemplateMessage('t20_spdadheading');
$spmomheading = getTemplateMessage('t20_spmomheading');

include("surname_cloud.class.php");
$flags['noicons'] = false;
$flags['noheader'] = false;
$flags['nobody'] = false;
$tngconfig['showshare'] = false;
tng_header($sitename ? "" : _("Our Family Genealogy Pages"), $flags);
?>
    <div id="homepage" class="content">
        <div id="leftsection" class="leftsection"><br>
            <div id="randomphoto" class="text-center">
                <?php
                if ($tmp['t20_photoption'] == "random") {
                    $rp_maxwidth = $tmp['t20_randomphotowidth'];  //  width 350 is needed to allow display in 1024 screen width
                    $rp_maxheight = $tmp['t20_randomphotoheight'];
                    $rp_mediatypeID = $tmp['t20_randomphotomediatypeID'];

                    include("randomphoto.php");
                } else {
                    ?>
                    <img src="<?php echo $templatepath; ?><?php echo $tmp['t20_mainimage']; ?>" alt="" class="bigphoto w-full"><br>
                    <span class="smaller italic">
	                	&nbsp;&nbsp;<?php echo getTemplateMessage('t20_photocaption'); ?><br>
		            </span>
                <?php } ?>
            </div>
            <br>
            <h3><a href="<?php echo $tmp['t20_dadpagelink']; ?>"><span class="blueemphasis"><?php echo getTemplateMessage('t20_dadheading'); ?></span></a></h3>
            <?php echo getTemplateMessage('t20_dadpara'); ?>
            <?php if ($mymomheading) { ?>
                <h3><a href="<?php echo $tmp['t20_mompagelink']; ?>"><span class="blueemphasis"><?php echo getTemplateMessage('t20_momheading'); ?></span></a></h3>
            <?php } ?>
            <?php echo getTemplateMessage('t20_mompara'); ?>
            <h3><a href="<?php echo $tmp['t20_spdadpagelink']; ?>"><span class="blueemphasis"><?php echo getTemplateMessage('t20_spdadheading'); ?></span></a></h3>
            <?php echo getTemplateMessage('t20_spdadpara'); ?>
            <?php if ($spmomheading) { ?>
                <h3><a href="<?php echo $tmp['t20_spmompagelink']; ?>"><span class="blueemphasis"><?php echo getTemplateMessage('t20_spmomheading'); ?></span></a></h3>
            <?php } ?>
            <?php echo getTemplateMessage('t20_spmompara'); ?>
        </div>  <!--  .leftsection -->

        <div id="rightsection" class="rightsection"><br>
            <h3 class="blueemphasis"><?php echo getTemplateMessage('t20_storiesheading'); ?></h3>
            <div class="normal">
                <p>
                    <a href="<?php echo $tmp['t20_featurelink1']; ?>"><img src="<?php echo $templatepath; ?><?php echo $tmp['t20_featurethumb1']; ?>" alt="feature 1" class="featureimg"/><span
                            class="blueemphasis featurelink"><?php echo getTemplateMessage('t20_featuretitle1'); ?></span></a>
                    <br class="featuretext"><?php echo getTemplateMessage('t20_featurepara1'); ?>
                </p>
                <p>
                    <a href="<?php echo $tmp['t20_featurelink2']; ?>"><img src="<?php echo $templatepath; ?><?php echo $tmp['t20_featurethumb2']; ?>" alt="feature 2" class="featureimg"/><span
                            class="blueemphasis featurelink"><?php echo getTemplateMessage('t20_featuretitle2'); ?></span></a>
                    <br class="featuretext"><?php echo getTemplateMessage('t20_featurepara2'); ?>
                </p>
                <p>
                    <a href="<?php echo $tmp['t20_featurelink3']; ?>"><img src="<?php echo $templatepath; ?><?php echo $tmp['t20_featurethumb3']; ?>" alt="feature 3" class="featureimg"/><span
                            class="blueemphasis featurelink"><?php echo getTemplateMessage('t20_featuretitle3'); ?></span></a>
                    <br class="featuretext"><?php echo getTemplateMessage('t20_featurepara3'); ?>
                </p>
                <p>
                    <a href="<?php echo $tmp['t20_featurelink4']; ?>"><img src="<?php echo $templatepath; ?><?php echo $tmp['t20_featurethumb4']; ?>" alt="feature 4" class="featureimg"/><span
                            class="blueemphasis featurelink"><?php echo getTemplateMessage('t20_featuretitle4'); ?></span></a>
                    <br class="featuretext"><?php echo getTemplateMessage('t20_featurepara4'); ?>
                </p>
                <p>
                    <a href="<?php echo $tmp['t20_featurelink5']; ?>"><img src="<?php echo $templatepath; ?><?php echo $tmp['t20_featurethumb5']; ?>" alt="feature 5" class="featureimg"/><span
                            class="blueemphasis featurelink"><?php echo getTemplateMessage('t20_featuretitle5'); ?></span></a>
                    <br class="featuretext"><?php echo getTemplateMessage('t20_featurepara5'); ?>
                </p>
                <p>
                    <a href="<?php echo $tmp['t20_featurelink6']; ?>"><img src="<?php echo $templatepath; ?><?php echo $tmp['t20_featurethumb6']; ?>" alt="feature 6" class="featureimg"/><span
                            class="blueemphasis featurelink"><?php echo getTemplateMessage('t20_featuretitle6'); ?></span></a>
                    <br class="featuretext"><?php echo getTemplateMessage('t20_featurepara6'); ?>
                </p>
            </div>
            <div id="contactus" class="normal"><b><?php echo _("Contact Us"); ?></b></div>

            <div class="normal">
                <p><img src="<?php echo $templatepath; ?>img/email.gif" alt="email image" class="emailimg"/></p>
                <p class="featuretext"><?php echo $text['contactus_long']; ?></p><br>
            </div>
        </div> <!--  .rightsection -->

    </div> <!-- .content -->
    <div style="clear:both;">
        <br>
        <h2 style="text-align: center;"><?php echo getTemplateMessage('t20_topsurnames'); ?></h2>
        <br>
        <div>
            <?php
            $nc = new surname_cloud();
            $nc->display($tmp['t20_nbrsurnames'] . _(" in ") . $sitename);
            ?>
        </div>
    </div>
<?php echo tng_footer($flags); ?>