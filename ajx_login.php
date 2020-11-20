<?php
include "begin.php";
$tngconfig['maint'] = "";
include "genlib.php";
include "getlang.php";

include "log.php";

header("Content-type:text/html; charset=" . $session_charset);
?>

<div style="margin:10px 20px 0 20px; border:0;">
    <?php
    $loginfieldclass = "loginfield";
    $loginbtnclass = "btn loginbtn";
    include "loginlib.php";
    ?>
</div>