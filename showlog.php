<?php
$textpart = "showlog";
include "tng_begin.php";

if (!$allow_admin) {
    $message = $admtext['norights'];
    header("Location: admin_login.php?message=" . urlencode($message));
    exit;
}

if (isset($cms['events'])) {
    include 'cmsevents.php';
    cms_logs();
}
require $subroot . "logconfig.php";

if ($maxloglines) {
    $loglines = $maxloglines;
} else {
    $loglines = "";
}

$showlog_url = getURL("showlog", 1);
$logxml_url = getURL("ajx_logxml", 0);

if (isset($autorefresh)) {
    $flags['scripting'] = "<script type=\"text/javascript\" src=\"{$cms['tngpath']}js/net.js\"></script>\n";
}
$owner = $sitename ? $sitename : $dbowner;
tng_header("$loglines {$text['mostrecentactions']}", $flags);
?>

    <h2 class="header"><?php echo "$loglines {$text['mostrecentactions']}"; ?></h2>
    <br style="clear: both;">
<?php
if (isset($autorefresh)) {
    echo "<p class='normal'><a href=\"$showlog_url" . "autorefresh=0\">{$text['refreshoff']}</a></p>\n";
} else {
    echo "<p class='normal'><a href=\"$showlog_url" . "autorefresh=1\">{$text['autorefresh']}</a></p>\n";
}
?>

    <div align="left" class="normal" id="content">
        <?php
        if (empty($autorefresh)) {
            $lines = file($logfile);
            foreach ($lines as $line) {
                if (strpos($line, "<script") === false) {
                    echo "$line<br>\n";
                } else {
                    echo htmlspecialchars($line) . "<strong>Please investigate this access</strong> <br>\n";
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
            var loader1 = new net.ContentLoader('<?php echo $logxml_url ?>', FillPage, null, "POST", '');
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