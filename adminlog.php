<?php
function adminwritelog($string) {
    global $admtext, $currentuserdesc, $time_offset;

    require "config/logconfig.php";

    $string .= " ({$admtext['user']}: $currentuserdesc)";

    $lines = file($adminlogfile);
    if ($adminmaxloglines && sizeof($lines) >= $adminmaxloglines) {
        array_pop($lines);
    }
    $updated = date("D d M Y H:i:s", time() + (3600 * intval($time_offset)));
    array_unshift($lines, "$updated $string.\n");

    $fp = @fopen($adminlogfile, "w");
    if (!$fp) {
        die ("{$admtext['cannotopen']} $adminlogfile");
    }

    flock($fp, LOCK_EX);
    $linecount = 0;
    foreach ($lines as $line) {
        trim($line);
        if ($line) {
            fwrite($fp, $line);
        }
        $linecount++;
        if ($linecount == $adminmaxloglines) {
            break;
        }
    }
    flock($fp, LOCK_UN);
    fclose($fp);
}

