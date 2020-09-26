<?php
include "begin.php";
$tngconfig['maint'] = "";
include "adminlib.php";
$textpart = "setup";
include "$mylanguage/admintext.php";

$maintenance_mode = true;
include "checklogin.php";
include "version.php";

tng_adminheader($admtext['maintmode'], '');
echo "</head>";
?>

<body class="admin-body">
<div class="lightback">
    <div style="padding:10px;" class="databack normal">
        <p class="plainheader"><?php echo $admtext['maintmode']; ?></p>

        <p class="normal"><?php echo $admtext['maintexp']; ?>
        </p><br><br>
    </div>
</div>
<?php echo "<div style=\"text-align: center;\"><span class='normal'>$tng_title</span></div>"; ?>
</body>
<?php echo "</html>"; ?>
