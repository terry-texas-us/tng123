<?php
$textpart = "login";
include "tng_begin.php";

session_start();

$flags['error'] = "";

tng_header($text['login'], $flags);

$loginfieldclass = "medfield";
$loginbtnclass = "btn";

include "loginlib.php";
?>

    <script type="text/javascript">
        document.form1.tngusername.focus();
    </script>
<?php
tng_footer("");
?>