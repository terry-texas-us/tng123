<?php
// %version:11.0.0.2%
//Created By Add DNA Test Results Mod
require_once "begin.php";
require_once "genlib.php";
require_once "getlang.php";

header("Content-type:text/html; charset=" . $session_charset);
?>
<div class="databack ajaxwindow" id="dnainfo">
    <h3 class="subhead"><img src="img/dna_icon.gif" width="20" height="20" align="left" alt=""
            vspace="0">&nbsp;<?php echo _('DNA Test Info'); ?></h3>

    <a><span
            style="font-size: x-small; color: #000000; "><?php echo _('Test(s) linked to this person were not necessarily taken by this person.<br>The \'Haplogroup\' column displays data in red if the result is \'Predicted\' or green if the test is \'Confirmed\''); ?></span></a>

    <br><br>
    <form>
        <input type="button" onclick="tnglitbox.remove();return false;" value="<?php echo _('Close this window'); ?>">
    </form>
</div>