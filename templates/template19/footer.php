<?php global $text, $flags, $tng_version, $cms; ?>

<br clear="both">
</div>
<!-- This section begins the 3 footer boxes  -->
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
            <h4><?php echo $text['contactus']; ?></h4>
            <ul class="list1">
                <li><a href="suggest.php"><?php echo $text['contactus']; ?></a></li>
                <li><?php echo getTemplateMessage('t19_ttitletext'); ?></li>
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
<footer>
    <p class="center"><a href="index.php"><?php echo getTemplateMessage('t19_maintitle'); ?></a> &copy; &nbsp;<script type="text/javascript">document.write((new Date()).getFullYear());</script>
    </p>
    <?php
    $flags['basicfooter'] = true;
    echo tng_footer($flags);
    ?>
</footer>

<link href="<?php echo $templatepath; ?>css/nivo-slider.css" media="screen" rel="stylesheet" type="text/css">
<script src="<?php echo $templatepath; ?>javascripts/jquery.nivo.slider.js" type="text/javascript"></script>
<script src="<?php echo $templatepath; ?>javascripts/main.js" type="text/javascript"></script>
<script src="<?php echo $templatepath; ?>javascripts/wow.min.js"></script>
<script>new WOW().init();</script>
