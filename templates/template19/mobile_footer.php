<br clear="both">
</div>
<div class="row2">
    <div class="container">
        <article class="contentBox3a">
            <h4><?php echo $text['quicklinks']; ?></h4>
            <div class="contentBox2a">
                <ul class="list1">
                    <li><a href="whatsnew.php"><?php echo $text['mnuwhatsnew']; ?></a></li>
                    <li><a href="searchform.php"><?php echo $text['mnusearch']; ?></a></li>
                    <li><a href="surnames.php"><?php echo $text['surnames']; ?></a></li>
                </ul>
            </div>
            <div class="contentBox2b">
                <ul class="list1">
                    <li><a href="calendar.php"><?php echo $text['calendar']; ?></a></li>
                    <li><a href="browsemedia.php"><?php echo $text['allmedia']; ?></a></li>
                    <li><a href="browsesources.php"><?php echo $text['mnusources']; ?></a></li>
                </ul>
            </div>
        </article>
        <article class="contentBox3b">
            <h4><!-- Title of 2nd box --><?php echo $text['contactus']; ?></h4>
            <ul class="list1">
                <!-- Contact Us Space -->
                <li><a href="suggest.php"><?php echo $text['contactus']; ?></a></li>
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
            <h4><?php echo $text['webmastermsg']; ?></h4>
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