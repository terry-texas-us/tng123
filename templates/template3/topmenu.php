<?php global $text, $tmp; ?>

<body id="bodytop" class="<?php echo pathinfo(basename($_SERVER['SCRIPT_NAME']), PATHINFO_FILENAME); ?>">
<table class="tableborder rounded-lg t3shadow w-full" cellspacing="0" cellpadding="5">
    <tr>
        <td class="t3hdr rounded-lg">
            <img src="<?php echo $templatepath; ?><?php echo $tmp['t3_headimg']; ?>" alt="" class="headerphoto" width="186" height="110">
        </td>
        <td class="topmenu rounded-lg">
            <?php if ($tmp['t3_titlechoice'] == "text") { ?>
                <em class="toptitle"><?php echo getTemplateMessage('t3_maintitle'); ?></em><br>
            <?php } else { ?>
                <img src="<?php echo $templatepath; ?><?php echo $tmp['t3_headtitleimg']; ?>" alt="" class="menutitle">
            <?php } ?>
            <br>
            <a href="index.php" class="topmenu"><?php echo $text['homepage']; ?></a> |
            <a href="whatsnew.php" class="topmenu"><?php echo $text['mnuwhatsnew']; ?></a> |
            <a href="browsemedia.php?mediatypeID=photos" class="topmenu"><?php echo $text['mnuphotos']; ?></a> |
            <a href="browsemedia.php?mediatypeID=histories" class="topmenu"><?php echo $text['mnuhistories']; ?></a> |
            <a href="browsesources.php" class="topmenu"><?php echo $text['mnusources']; ?></a> |
            <a href="reports.php" class="topmenu"><?php echo $text['mnureports']; ?></a> |
            <a href="calendar.php" class="topmenu"><?php echo $text['calendar']; ?></a> |
            <a href="cemeteries.php" class="topmenu"><?php echo $text['mnucemeteries']; ?></a> |
            <a href="browsemedia.php?mediatypeID=headstones" class="topmenu"><?php echo $text['mnutombstones']; ?></a> |
            <a href="statistics.php" class="topmenu"><?php echo $text['mnustatistics']; ?></a> |
            <a href="surnames.php" class="topmenu"><?php echo $text['mnulastnames']; ?></a>
        </td>
    </tr>
</table>
