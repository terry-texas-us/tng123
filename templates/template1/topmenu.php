<?php global $text, $tmp; ?>

<body id="bodytop" class="<?php echo defaultTemplateClass(); ?>">

<?php if ($tmp['t1_titlechoice'] == "text") { ?>
    <div style="float:left;"><img src="<?php echo $templatepath; ?>img/header-image.gif" alt="" width="93" height="72"></div>
    <div>
        <em><a href="index.php" class="toptitle"><?php echo getTemplateMessage('t1_maintitle'); ?></a></em>
    </div>
    <br>
<?php } else { ?>
    <a href="index.php"><img src="<?php echo $templatepath; ?><?php echo $tmp['t1_headimgplustitle']; ?>" alt=""></a>
<?php } ?>
<br>
