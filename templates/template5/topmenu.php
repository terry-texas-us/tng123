<?php
global $tmp;
?>

<body id="bodytop" class="<?php echo pathinfo(basename($_SERVER['SCRIPT_NAME']), PATHINFO_FILENAME); ?>">
<div class="text-center">
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
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>
                <table class="w-full border-0">
                    <tr>
                        <td class="p-2 border-separate">
