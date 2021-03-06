<?php

$flags['noicons'] = false;
echo "<!doctype html>\n";
echo "<html lang='en'>\n";
global $tngconfig;
$headElement = new HeadElementPublic($sitename ? "" : _("Home Page"), $flags);
echo $headElement->getHtml();
standardHeaderVariants($headElement, $flags);
echo "<body id='bodytop' class='" . pathinfo(basename($_SERVER['SCRIPT_NAME']), PATHINFO_FILENAME) . "'>\n";
if ($tngconfig['maint']) {
    echo "<span class='fieldnameback yellow p-1'><strong>" . _("Maintenance Mode is ON") . "</strong></span><br><br>\n";
}
?>
    <br class="clear-both"><br>
    <div class="content-sidebar-wrap">
        <main class="content">
            <div class="home-top widget-area">
                <section id="featured-article" class="widget featured-content">
                    <div class="">
                        <h4 class="widget-title"><?php echo getTemplateMessage('t15_subhead1'); ?></h4>
                        <article class="post">
                            <a href="<?php echo $tmp['t15_featurelink1']; ?>" title="" class="alignnone"><img
                                    src="<?php echo $templatepath . $tmp['t15_mainimage']; ?>" id="mainphoto" class=""
                                    alt="main image"></a>
                            <header class="entry-header">
                                <h2 class="entry-title"><a
                                        href="<?php echo $tmp['t15_featurelink1']; ?>"><?php echo getTemplateMessage('t15_featuretitle1'); ?></a>
                                </h2>
                            </header>
                            <div class="entry-content">
                                <?php echo getTemplateMessage('t15_featurepara1'); ?>
                            </div>
                        </article>
                    </div>
                </section>
            </div>
            <div class="home-middle widget-area">
                <section class="widget featured-content">
                    <div class="">
                        <h4 class="widget-title"><?php echo getTemplateMessage('t15_subhead2'); ?></h4>
                        <article class="post entry">

                            <a href="<?php echo $tmp['t15_featurelink2']; ?>" title="" class="alignnone">
                                <img src="<?php echo $templatepath . $tmp['t15_featurethumb2']; ?>" alt="Lorem Ipsum" title=""
                                    class="" width="405"></a>
                            <header class="entry-header">
                                <h2 class="entry-title"><a
                                        href="<?php echo $tmp['t15_featurelink2']; ?>"><?php echo getTemplateMessage('t15_featuretitle2'); ?></a>
                                </h2>
                            </header>
                            <div class="entry-content">
                                <?php echo getTemplateMessage('t15_featurepara2'); ?>
                            </div>
                        </article>
                        <article class="post">
                            <a href="<?php echo $tmp['t15_featurelink3']; ?>" title="" class="alignnone"><img
                                    src="<?php echo $templatepath . $tmp['t15_featurethumb3']; ?>" class="" alt="interest"
                                    width="405"></a>
                            <header class="entry-header">
                                <h2 class="entry-title"><a
                                        href="<?php echo $tmp['t15_featurelink3']; ?>"><?php echo getTemplateMessage('t15_featuretitle3'); ?></a>
                                </h2>
                            </header>
                            <div class="entry-content">
                                <?php echo getTemplateMessage('t15_featurepara3'); ?>
                            </div>
                        </article>
                    </div>
                </section>
            </div>
        </main>
        <aside class="sidebar sidebar-primary widget-area">
            <section class="widget featured-content">
                <div class="">
                    <h4 class="widget-title"><?php echo getTemplateMessage('t15_sidebarhead1'); ?></h4>
                    <article class="post entry">
                        <a href="<?php echo $tmp['t15_featurelink4']; ?>" title="" class="alignleft"><img
                                src="<?php echo $templatepath . $tmp['t15_featurethumb4']; ?>" class="" alt="" height="100"
                                width="100"></a>
                        <header class="entry-header">
                            <h2 class="entry-title"><a
                                    href="<?php echo $tmp['t15_featurelink4']; ?>"><?php echo getTemplateMessage('t15_featuretitle4'); ?></a></h2>
                        </header>
                        <?php echo getTemplateMessage('t15_featurepara4'); ?>
                        <br class="clear-both">
                    </article>
                    <article class="post entry">
                        <a href="<?php echo $tmp['t15_featurelink5']; ?>" title="" class="alignleft"><img
                                src="<?php echo $templatepath . $tmp['t15_featurethumb5']; ?>" class="" alt="" height="100"
                                width="100"></a>
                        <header class="entry-header">
                            <h2 class="entry-title"><a
                                    href="<?php echo $tmp['t15_featurelink5']; ?>"><?php echo getTemplateMessage('t15_featuretitle5'); ?></a></h2>
                        </header>
                        <?php echo getTemplateMessage('t15_featurepara5'); ?>
                        <br class="clear-both">
                    </article>
                    <article class="post entry">
                        <a href="<?php echo $tmp['t15_featurelink6']; ?>" title="" class="alignleft"><img
                                src="<?php echo $templatepath . $tmp['t15_featurethumb6']; ?>" class="" alt="" height="100"
                                width="100"></a>
                        <header class="entry-header">
                            <h2 class="entry-title"><a
                                    href="<?php echo $tmp['t15_featurelink6']; ?>"><?php echo getTemplateMessage('t15_featuretitle6'); ?></a></h2>
                        </header>
                        <?php echo getTemplateMessage('t15_featurepara6'); ?>
                        <br class="clear-both">
                    </article>
                </div>
            </section>
            <section class="widget widget_text">
                <div class="">
                    <h4 class="widget-title"><?php echo getTemplateMessage('t15_sidebarhead2'); ?></h4>
                    <div class="">
                        <a href="<?php echo $tmp['t15_featurelink7']; ?>" title="" class="alignleft"><img
                                src="<?php echo $templatepath . $tmp['t15_featurethumb7']; ?>" class="" alt="" height="150"
                                width="150"></a>
                        <?php echo getTemplateMessage('t15_featurepara7'); ?>
                    </div>
                </div>
            </section>
            <section class="widget widget_text">
                <div class="">
                    <h4 class="widget-title"><?php echo getTemplateMessage('t15_sidebarhead3'); ?></h4>
                    <a href="<?php echo $tmp['t15_featurelink8']; ?>" title="" class="alignnone"><img
                            src="<?php echo $templatepath . $tmp['t15_featurethumb8']; ?>" class="" alt="" height="200"
                            width="360"></a>
                    <div class="">
                        <?php echo getTemplateMessage('t15_featurepara8'); ?>
                    </div>
                </div>
            </section>
        </aside>
    </div>
    <br class="clear-both">

<?php tng_footer($flags); ?>

<?php echo "</body>"; ?>
<?php echo "</html>"; ?>