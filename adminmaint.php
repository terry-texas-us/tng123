<?php
include "begin.php";
$tngconfig['maint'] = "";
include "adminlib.php";
$textpart = "setup";
include "$mylanguage/admintext.php";

$maintenance_mode = true;
include "checklogin.php";
include "version.php";

tng_adminheader(_('Maintenance Mode'), '');

echo "</head>\n";
echo tng_adminlayout();
?>

<div class="lightback">
    <div style="padding:10px;" class="databack normal">
        <p class="plainheader"><?php echo _('Maintenance Mode'); ?></p>

        <p class="normal"><?php echo _('All database access is temporarily unavailable for site maintenance. Please try again later. If regular functions do not resume within a few hours of first seeing this message, please contact the site administrator.'); ?>
        </p><br><br>
    </div>
</div>
<?php echo "<div style=\"text-align: center;\"><span class='normal'>$tng_title</span></div>"; ?>
</body>
<?php echo "</html>"; ?>
