<?php global $text, $currentuser, $allow_admin, $tmp; ?>

<body id="bodytop" class="<?php echo pathinfo(basename($_SERVER['SCRIPT_NAME']), PATHINFO_FILENAME); ?> templatebody m-2">
<table class="page">
    <tr>
        <td class="mainborder" rowspan="5">
            &nbsp;
        </td>
        <td class="headerrow" style="background: url(<?php echo $templatepath; ?><?php echo $tmp['t8_headimg']; ?>) no-repeat;">
            <table class="headertable">
                <tr class="headertextrow">
                    <td>
                        <span class="headertext text_white"><?php echo getTemplateMessage('t8_headtitle1'); ?></span><span
                            class="headertext text_tan"><?php echo getTemplateMessage('t8_headtitle2'); ?></span><span
                            class="headertext text_white"><?php echo getTemplateMessage('t8_headtitle3'); ?></span>
                        <br>
                        <span class="normal text_grey"><?php echo getTemplateMessage('t8_headsubtitle'); ?></span>
                    </td>
                    <td class="searchtext">
                        <form id="topsearchform" name="topsearchform" action="search.php" method="get">
                            <label for="myfirstname" class="subsearch"><?php echo $text['mnufirstname']; ?>:</label>
                            <input name="myfirstname" type="search" id="myfirstname">
                            <label for="mylastname" class="subsearch"><?php echo $text['mnulastname']; ?>:</label>
                            <input name="mylastname" type="search" id="mylastname">
                            <input type="hidden" value="AND" name="mybool">
                            <input alt="Submit Search" style="vertical-align: bottom; border:none;" type="image" name="imageField"
                                src="<?php echo $templatepath; ?>img/searchbutton.gif">
                            <br>
                            <span>[<a class="subsearch" href="searchform.php"><?php echo $text['mnuadvancedsearch']; ?></a>]&nbsp;&nbsp;</span>
                            <span>[<a class="subsearch" href="surnames.php"><?php echo $text['mnulastnames']; ?></a>]</span>
                        </form>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr class="menurow">
        <td colspan="2">
            <div class="menucol">
                <?php
                if (!isset($title) || !$title) {
                    $title = getTemplateMessage('t6_maintitle');
                }
                echo tng_icons(1, $title);
                global $currentuserdesc, $flags;
                $flags['noicons'] = true;

                if ($currentuser) {
                    echo "<span class='logintext'>{$text['welcome']}, $currentuser</span>";
                } else {
                    echo "<span class='logintext'>{$text['anon']}</span>";
                }
                ?>
            </div>
        </td>
    </tr>
    <tr>
<?php if (strpos($_SERVER['SCRIPT_NAME'], 'index.php') === false) {  // main index page ?>
    <td class='mainbg' style='border-collapse: separate;' colspan='3'>
<?php } else {  // regular pages ?>
    <td style='border-collapse:separate;' colspan='3'>
<?php } ?>