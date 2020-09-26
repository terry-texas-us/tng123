<?php
$textpart = "login";
include "tng_begin.php";

session_start();

echo "<!doctype html>\n";
echo "<html lang='en'>\n";

$flags['error'] = "";

tng_header($text['login'], $flags);

$loginfieldclass = "medfield";
$loginbtnclass = "btn";

include "loginlib.php";
?>

    <script>
        document.form1.tngusername.focus();
    </script>
<?php
tng_footer("");
?>