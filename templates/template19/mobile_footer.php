<br clear="both">
</div>
<div class="row2">
    <div class="container">
        <article class="contentBox3a">
            <h4><?php echo _("Quick Links"); ?></h4>
            <div class="contentBox2a">
                <ul class="list1">
                    <li><a href="whatsnew.php"><?php echo _("What's New"); ?></a></li>
                    <li><a href="searchform.php"><?php echo _("Search"); ?></a></li>
                    <li><a href="surnames.php"><?php echo _("Surnames"); ?></a></li>
                </ul>
            </div>
            <div class="contentBox2b">
                <ul class="list1">
                    <li><a href="calendar.php"><?php echo _("Calendar"); ?></a></li>
                    <li><a href="browsemedia.php"><?php echo _("All Media"); ?></a></li>
                    <li><a href="browsesources.php"><?php echo _("Sources"); ?></a></li>
                </ul>
            </div>
        </article>
        <article class="contentBox3b">
            <h4><!-- Title of 2nd box --><?php echo _("Contact Us"); ?></h4>
            <ul class="list1">
                <!-- Contact Us Space -->
                <li><a href="suggest.php"><?php echo _("Contact Us"); ?></a></li>
                <?php
                //if($tmp['t19_ttitletext']) {
                ?>
                <li><?php echo getTemplateMessage('t19_ttitletext'); ?></li>
                <?php
                //if($tmp['t19_link']) {
                ?>
                <li><?php echo getTemplateMessage('t19_link'); ?></li>
            </ul>
        </article>
        <article class="contentBox3c">
            <h4><?php echo _("Webmaster Message"); ?></h4>
            <p><?php echo getTemplateMessage('t19_latestnews'); ?></p>
        </article>
        <div class="clear"></div>
    </div>
</div>
<?php
$footer .= "<script src=\"{$templatepath}javascripts/main.js\" type=\"text/javascript\"></script>\n";
$footer .= "<script src=\"{$templatepath}javascripts/jquery.nivo.slider.js\" type=\"text/javascript\"></script>\n";
$footer .= "<script src=\"{$templatepath}javascripts/wow.min.js\"></script>\n";
$footer .= "<script>new WOW().init();</script>\n";
?>