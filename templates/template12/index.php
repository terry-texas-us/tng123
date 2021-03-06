<?php

$tngconfig['showshare'] = false;
$tngconfig['showprint'] = 1;
$tngconfig['showbmarks'] = 1;
$flags = ['noicons' => true, 'noheader' => false];
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
    <div class="cb-tng-area" style="height:24px;">
        <div style="margin-left: 10px; margin-right: 10px;">
            <?php
            $title = getTemplateMessage('t12_maintitle');
            echo tng_icons(1, $title);
            ?>
        </div>
    </div>
    <div class="cb-layout-wrapper clearfix">
        <div class="cb-content-layout">
            <div class="cb-content-layout-row">
                <div class="cb-layout-cell cb-content clearfix">
                    <article class="cb-post cb-article">
                        <div class="cb-postcontent cb-postcontent-0 clearfix">

                            <div class="cb-content-layout layout-item-0">
                                <div class="cb-content-layout-row ">
                                    <div class="cb-layout-cell layout-item-1">
                                        <h2 style="text-align: center;">
                                            <a href="<?php echo $tmp['t12_featurelink1']; ?>"><?php echo getTemplateMessage('t12_phototitlel'); ?></a>
                                        </h2>
                                        <p style="text-align: center;">
                                            <a href="<?php echo $tmp['t12_featurelink1']; ?>">
                                                <img width="300" alt="" src="<?php echo $templatepath . $tmp['t12_photol']; ?>"></a>
                                        </p>
                                        <p><?php echo getTemplateMessage('t12_photocaptionl'); ?></p>
                                    </div>

                                    <div class="cb-layout-cell layout-item-1">
                                        <h2 style="text-align: center;"><?php echo getTemplateMessage('t12_welcome'); ?></h2>
                                        <?php echo getTemplateMessage('t12_mainpara'); ?>
                                    </div>

                                    <div class="cb-layout-cell layout-item-1">
                                        <h2 style="text-align: center;">
                                            <a href="<?php echo $tmp['t12_featurelink2']; ?>"><?php echo getTemplateMessage('t12_phototitler'); ?></a>
                                        </h2>
                                        <p style="text-align: center;">
                                            <a href="<?php echo $tmp['t12_featurelink2']; ?>">
                                                <img width="300" alt="" src="<?php echo $templatepath . $tmp['t12_photor']; ?>"></a>
                                        </p>
                                        <p><?php echo getTemplateMessage('t12_photocaptionr'); ?></p>
                                        <h2 style="text-align: center;"></h2>
                                    </div>
                                </div>
                            </div>
                            <div class="cb-content-layout-wrapper layout-item-2">
                                <div class="cb-content-layout layout-item-3">
                                    <div class="cb-content-layout-row">
                                        <div class="cb-layout-cell layout-item-4">
                                            <h2 style="text-align: center;"><?php echo getTemplateMessage('t12_topsurnames'); ?></h2>
                                            <!-- Surname Cloud -->
                                            <br>
                                            <div>
                                                <?php
                                                include "surname_cloud.class.php";
                                                $nc = new surname_cloud();
                                                $nc->display(100);
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </div>
<?php tng_footer($flags); ?>