<?php
$textpart = "login";
include "tng_begin.php";

session_start();
//$_SESSION['destinationpage8'] = $HTTP_REFERER;

$flags['error'] = "";

tng_header($text['login'], $flags);

$loginfieldclass = "medfield";
$loginbtnclass = "btn";

include($cms['tngpath'] . "loginlib.php");
?>

    <script type="text/javascript">
        document.form1.tngusername.focus();
    </script>
<?php
tng_footer("");
?>