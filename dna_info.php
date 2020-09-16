<?php
// %version:11.0.0.2%
//Created By Add DNA Test Results Mod
require_once "begin.php";
require_once "genlib.php";
$textpart = "dna";
require_once "getlang.php";
require_once "$mylanguage/text.php";

header("Content-type:text/html; charset=" . $session_charset);
?>
<div class="databack ajaxwindow" id="dnainfo">
    <h3 class="subhead"><img src="img/dna_icon.gif" width="20" height="20" align="left" alt=""
                             vspace="0">&nbsp;<?php echo $text['dna_info_head']; ?></h3>

    <a><span style="font-size: x-small; color: #000000; "><?php echo $text['Ydna_LITbox_info']; ?></span></a>

    <br><br>
    <form>
        <input type="button" onclick="tnglitbox.remove();return false;" value="<?php echo $text['closewindow']; ?>">
    </form>
</div>