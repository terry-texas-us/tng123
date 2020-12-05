<?php
global $tmp;
?>

<body id="bodytop" class="<?php echo pathinfo(basename($_SERVER['SCRIPT_NAME']), PATHINFO_FILENAME); ?> bodytopmenu">

<table class="w-full page">
    <tr>
        <td></td>
        <td><img src="<?php echo $templatepath; ?><?php echo $tmp['t2_headimg']; ?>" alt="" class="headerimg" width="70" height="99"></td>
        <td>
            <table>
                <tr>
                    <td>
                        <a href="index.php" class="toptitle">
                            <?php if ($tmp['t2_titlechoice'] == "text") { ?>
                                <em class="toptitle"><?php echo getTemplateMessage('t2_maintitle'); ?></em>
                            <?php } else { ?>
                                <img src="<?php echo $templatepath; ?><?php echo $tmp['t2_headtitleimg']; ?>"
                                    alt="<?php echo _("Our Family Genealogy Pages"); ?>" width="312" height="78" class="noimgborder">
                            <?php } ?>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>
						<span class="topmenu">
						<a href="index.php" class="topmenu"><?php echo _("Home Page"); ?></a>
						&nbsp;|&nbsp;
						<a href="whatsnew.php" class="topmenu"><?php echo _("What's New"); ?></a>
						&nbsp;|&nbsp;
						<a href="browsemedia.php?mediatypeID=photos" class="topmenu"><?php echo _("Photos"); ?></a>
						&nbsp;|&nbsp;
						<a href="browsemedia.php?mediatypeID=histories" class="topmenu"><?php echo _("Histories"); ?></a>
						&nbsp;|&nbsp;
						<a href="browsemedia.php?mediatypeID=headstones" class="topmenu"><?php echo _("Headstones"); ?></a>
						&nbsp;|&nbsp;
						<a href="reports.php" class="topmenu"><?php echo _("Reports"); ?></a>
						&nbsp;|&nbsp;
						<a href="surnames.php" class="topmenu"><?php echo _("Surnames"); ?></a>
						</span>
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <form id="topsearch" action="search.php" method="get">
                <table>
                    <tr>
                        <td class="topmenu px-4">
                            <span class="headertitle"><?php echo _("Search"); ?></span><br>
                            <label for="myfirstname"><?php echo _("First Name"); ?>:<br></label>
                            <input id="myfirstname" class="searchbox" name="myfirstname" type="search">
                            <br>
                            <label for="mylastname"><?php echo _("Last Name"); ?>:<br></label>
                            <input id="mylastname" class="searchbox" name="mylastname" type="search">
                            <input type="hidden" name="mybool" value="AND">
                        </td>
                        <td class="pt-10">
                            <input type="image" name="imgsubmit" src="<?php echo $templatepath; ?>img/button-header.jpg" class="menusubmit">
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
            <table class="w-full">
                <tr>
                    <td class="p-3">
                        <div class="normal">
