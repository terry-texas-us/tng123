<?php
$textpart = "showlog";
include "tng_begin.php";

if (!$allow_admin) {
    $message = $admtext['norights'];
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

require "config/logconfig.php";

if ($maxloglines) {
    $loglines = $maxloglines;
} else {
    $loglines = "";
}

if (isset($autorefresh)) {
    $flags['scripting'] = "<script type=\"text/javascript\" src=\"js/net.js\"></script>\n";
}
$owner = $sitename ? $sitename : $dbowner;

echo "<!doctype html>\n";
echo "<html lang='en'>\n";

tng_header("$loglines {$text['mostrecentactions']}", $flags);
?>

    <h2 class="header"><?php echo "$loglines {$text['mostrecentactions']}"; ?></h2>
    <br style="clear: both;">
<?php
if (isset($autorefresh)) {
    echo "<p class='normal'><a href=\"showlog.php?autorefresh=0\">{$text['refreshoff']}</a></p>\n";
} else {
    echo "<p class='normal'><a href=\"showlog.php?autorefresh=1\">{$text['autorefresh']}</a></p>\n";
}
?>
    <div class="normal" id="content">
        <?php
        if (empty($autorefresh)) {
            $lines = file($logfile);
            foreach ($lines as $line) {
                if (strpos($line, "<script") === false) {
                    echo "$line<br>\n";
                } else {
                    echo htmlspecialchars($line) . "<strong>Please investigate this access</strong><br>\n";
                }
            }
        }
        ?>
    </div>

<?php
if (isset($autorefresh)) {
    ?>
    <script type="text/javascript">
        function refreshPage() {
            var loader1 = new net.ContentLoader('ajx_logxml.php', FillPage, null, "POST", '');
            var timer = setTimeout("refreshPage()", 30000);
        }

        function FillPage() {
            var content = document.getElementById("content");
            content.innerHTML = this.req.responseText;
        }

        refreshPage();
    </script>
    <?php
}
tng_footer("");
?>