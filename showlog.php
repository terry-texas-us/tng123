<?php
$textpart = "showlog";
include "tng_begin.php";

if (!$allow_admin) {
    $message = _('You are not authorized to view this page. If you have a username and password, please login below.');
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
    $flags['scripting'] = "<script src=\"js/net.js\"></script>\n";
}
$owner = $sitename ? $sitename : $dbowner;

tng_header("$loglines " . _('Most Recent Actions') . "", $flags);
?>
    <h2 class="header"><?php echo "$loglines " . _('Most Recent Actions') . ""; ?></h2>
    <br class="clear-both">
<?php
if (isset($autorefresh)) {
    echo "<p class='normal'><a href=\"showlog.php?autorefresh=0\">" . _('Turn off Auto Refresh') . "</a></p>\n";
} else {
    echo "<p class='normal'><a href=\"showlog.php?autorefresh=1\">" . _('Auto Refresh (30 seconds)') . "</a></p>\n";
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
    <script>
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