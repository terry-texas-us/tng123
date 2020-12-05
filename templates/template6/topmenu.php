<?php
global $tmp;
?>

<body id="bodytop" class="<?php echo pathinfo(basename($_SERVER['SCRIPT_NAME']), PATHINFO_FILENAME); ?> templatebody">
<table class="page">
    <tr class="row60">
        <td colspan="4" class="headertitle">
            <?php echo getTemplateMessage('t6_maintitle'); ?> <!-- Our Family History -->
        </td>
    </tr>
    <tr>
        <td class="titlemid">
            <img src="<?php echo $templatepath; ?><?php echo $tmp['t6_headimg']; ?>" width="559" height="60" alt="">
        </td>
    </tr>
    <tr>
        <td class="headerback">

            <?php
            if (!isset($title) || !$title) {
                $title = getTemplateMessage('t6_maintitle');
            }
            echo tng_icons(1, $title);
            global $currentuser, $currentuserdesc, $flags;
            $flags['noicons'] = true;

            if ($currentuser) {
                echo "<span class='headertext'>" . _("Welcome") . ", $currentuserdesc</span>&nbsp;";
                echo "<a href=\"logout.php\"><span class='headertext-sm'>" . _("Log Out") . "</span></a>";
            } else {
                echo "<span class='headertext'>" . _("You are currently anonymous") . "</span>&nbsp;";
                echo "<a href=\"login.php\"><span class='headertext-sm'>" . _("Log In") . "</span></a>";
            }
            ?>

        </td>
    </tr>
    <tr>
        <td colspan="4" class="gradient">
            &nbsp;
        </td>
    </tr>
    <tr class="tablebkground">
        <td colspan="4" class="padding" style="border-collapse:separate;">
