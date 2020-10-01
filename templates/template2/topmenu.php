<?php global $text, $tmp; ?>
<body id="bodytop" class="<?php echo pathinfo(basename($_SERVER['SCRIPT_NAME']), PATHINFO_FILENAME); ?> bodytopmenu">

<table class="page w-100" cellspacing="0">
    <tr>
        <td>&nbsp;</td>
        <td class='align-top'>
            <img src="<?php echo $templatepath; ?><?php echo $tmp['t2_headimg']; ?>" alt="" class="headerimg" width="70" height="99">
        </td>
        <td class="align-top" align="center">
            <table cellspacing="0">
                <tr>
                    <td align="center"><a href="index.php" class="toptitle">
                            <?php if ($tmp['t2_titlechoice'] == "text") { ?>
                                <em class="toptitle"><?php echo getTemplateMessage('t2_maintitle'); ?></em>
                            <?php } else { ?>
                                <img src="<?php echo $templatepath; ?><?php echo $tmp['t2_headtitleimg']; ?>"
                                     alt="<?php echo $text['ourpages']; ?>" width="312" height="78" class="noimgborder">
                            <?php } ?>

                        </a></td>
                </tr>
                <tr>
                    <td class="align-bottom" align="center">
						<span class="topmenu">
						<br>
						<a href="index.php" class="topmenu"><?php echo $text['mnuheader']; ?></a>
						&nbsp;|&nbsp;
						<a href="whatsnew.php" class="topmenu"><?php echo $text['mnuwhatsnew']; ?></a>
						&nbsp;|&nbsp;
						<a href="browsemedia.php?mediatypeID=photos"
                           class="topmenu"><?php echo $text['mnuphotos']; ?></a>
						&nbsp;|&nbsp;
						<a href="browsemedia.php?mediatypeID=histories"
                           class="topmenu"><?php echo $text['mnuhistories']; ?></a>
						&nbsp;|&nbsp;
						<a href="browsemedia.php?mediatypeID=headstones"
                           class="topmenu"><?php echo $text['mnutombstones']; ?></a>
						&nbsp;|&nbsp;
						<a href="reports.php" class="topmenu"><?php echo $text['mnureports']; ?></a>
						&nbsp;|&nbsp;
						<a href="surnames.php" class="topmenu"><?php echo $text['mnulastnames']; ?></a>
						</span>
                    </td>
                </tr>
            </table>
        </td>
        <td class="align-top" align="right">
            <form id="topsearch" action="search.php" method="get" style="margin:0;">
                <table cellspacing="0">
                    <tr>
                        <td class="topmenu">
                            <span class="headertitle"><?php echo $text['search']; ?></span><br>
                            <?php echo $text['firstname']; ?>:<br>
                            <input type="search" name="myfirstname" class="searchbox" size="10">
                            <br>
                            <img src="img/spacer.gif" alt="" width="100%" height="3"><br>
                            <?php echo $text['lastname']; ?>: <br>
                            <input type="search" name="mylastname" size="10" class="searchbox">
                            <br>
                            <input type="hidden" name="mybool" value="AND">
                        </td>
                        <td><br><br>
                            <input type="image" name="imgsubmit" src="<?php echo $templatepath; ?>img/button-header.jpg"
                                   style="border:none;" class="menusubmit">
                        </td>
                    </tr>
                </table>
            </form>
        </td>
    </tr>
    <tr>
        <td colspan="4" class="tabletopedge"></td>
    </tr>

    <tr>
        <td colspan="4" class="tablebkground">
            <table class="w-100" cellspacing="0" cellpadding="10">
                <tr>
                    <td>
                        <div class="normal">
                            <!-- end topmenu.php for template 2 -->