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
?>
</head>

<body background="img/background.gif">
<div width="100%" class="lightback">
    <div style="padding:10px;" class="databack normal">
        <p class="plainheader"><?php echo $admtext['maintmode']; ?></p>

        <p class="normal"><?php echo $admtext['maintexp']; ?>
        </p><br><br>
    </div>
</div>
<?php echo "<div align=\"right\"><span class='normal'>$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>