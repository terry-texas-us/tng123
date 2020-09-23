<?php
include "begin.php";

$tmp = getTemplateVars($templates_table, $templatenum);
$tngconfig['maint'] = "";
include "genlib.php";
$textpart = "language";
include "getlang.php";
include "$mylanguage/text.php";

$maintenance_mode = true;

echo "<!doctype html>\n";
echo "<html lang='en'>\n";

tng_header($text['sitemaint'], $flags);
?>

<h2 class="header"><?php echo $text['sitemaint']; ?></h2>
<br style="clear: both;">

<?php
echo "<p class='normal'>" . $text['standby'] . "</p><br><br>";
tng_footer("");
?>
