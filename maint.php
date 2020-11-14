<?php
include "begin.php";

$tmp = getTemplateVars($templates_table, $templatenum);
$tngconfig['maint'] = "";
include "genlib.php";
$textpart = "language";
include "getlang.php";
include "$mylanguage/text.php";

$maintenance_mode = true;

tng_header(_('Site maintenance in progress'), $flags);
?>

<h2 class="header"><?php echo _('Site maintenance in progress'); ?></h2>
<br class="clear-both">

<?php
echo "<p class='normal'>" . _('The site is temporarily unavailable while we update our database. Please try again in a few minutes. If the site remains down for an extended period of time, please <a href=\"suggest.php\">contact the site owner</a>.') . "</p><br><br>";
tng_footer("");
?>
