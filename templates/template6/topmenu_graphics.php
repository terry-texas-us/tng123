<?php

global $tmp;
?>
<body>
<div class="text-center">
    <table class="page">
        <tr class="row60">
            <td colspan="4" class="headertitle">
                <img src="<?php echo $templatepath; ?>img/titletop.jpg" alt="">
            </td>
        </tr>
        <tr>
            <td class="titlemid">
                <img src="<?php echo $templatepath; ?>img/titlebottom.jpg" width="559" height="60" alt="">
            </td>
        </tr>
        <tr>
            <td class="headerback">

                <?php
                echo tng_icons(1);
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
            <td class="gradient">
                &nbsp;
            </td>
        </tr>
        <tr class="tablebkground">
            <td class="padding">
                <!-- end topmenu graphic for template 6 -->