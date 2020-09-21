<?php
include "begin.php";
include "adminlib.php";
$textpart = "login";
include "$mylanguage/admintext.php";

$admin_login = 1;
include "checklogin.php";
include "version.php";

require "config/logconfig.php";

if ($adminmaxloglines) {
    $loglines = $adminmaxloglines;
} else {
    $loglines = "";
}

tng_adminheader($admtext['adminlogfile'], "");
echo "</head>";
?>

    <body class="admin-body">
    <div class="lightback">
        <div style="padding:10px;" class="databack normal">
            <p class="plainheader"><?php echo "$loglines " . $admtext['mostrecentactions']; ?></p>
        <table class="normal">
            <tr>
                <td class="fieldnameback fieldname"><?php echo $admtext['mostrecentactions']; ?></td>
            </tr>
            <?php
            $lines = file($adminlogfile);

            foreach ($lines as $line) {
                echo "<tr><td class='lightback'>$line</td></tr>\n";
            }
            ?>
        </table>
        </div>
    </div>

    <?php echo "<div style=\"text-align: center;\"><span class='normal'>$tng_title, v.$tng_version</span></div>"; ?>
    </body>
<?php echo "</html>"; ?>