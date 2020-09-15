<?php
include "begin.php";

$tmp = getTemplateVars($templates_table, $templatenum);
$tngconfig['maint'] = "";
include $cms['tngpath'] . "genlib.php";
$textpart = "language";
include $cms['tngpath'] . "getlang.php";
include $cms['tngpath'] . "$mylanguage/text.php";

$maintenance_mode = true;

tng_header($text['sitemaint'], $flags);
?>

<h2 class="header"><?php echo $text['sitemaint']; ?></h2>
<br style="clear: both;">

<?php
echo tng_coreicons();

echo "<p class='normal'>" . $text['standby'] . "</p><br><br>";

tng_footer("");
?>
