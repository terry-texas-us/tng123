<?php
global $text, $tmp;
?>
<body id="bodytop" class="<?php echo pathinfo(basename($_SERVER['SCRIPT_NAME']), PATHINFO_FILENAME); ?>">
<div class="center">
    <table class="maintable">
        <tr>
            <td class="tableheader"></td>
        </tr>
        <tr>
            <td class="tablesubheader"></td>
        </tr>
        <tr>
            <td>
                <table class="innertable">
                    <tr>
                        <td>
                            <img src="<?php echo $templatepath; ?><?php echo $tmp['t5_headimg']; ?>" alt="" class="smallphoto"></td>
                        <td class="banner">
                            <?php echo getTemplateMessage('t5_maintitle'); ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr class="row30">

            <!-- OPTIONS: The following line can be used to display the Site Name
                  by removing the comment characters and commenting the line
                  after the END of OPTIONS -->

            <!--    	<td class="sitename"><?php echo "$sitename"; ?></td> -->
            <!--		or you could copy the menu between the EDIT lines in footer.php
                and replace the ADD MENU ITEMS HERE in between the following lines -->
            <!--		<td class=topmenu>

                    ADD MENU ITEMS HERE to display footer menu items in bar

                    </td>  -->
            <!-- 	  if using either of the above lines, delete or comment out the
                    following line END of OPTIONS -->

            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>
                <table class="w-100 border-0" cellspacing="0" cellpadding="7" border="0">
                    <tr>
                        <td style="border-collapse:separate;">
                            <!-- end topmenu.php for template 5 -->