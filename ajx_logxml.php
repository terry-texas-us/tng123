<?php
include "begin.php";
require($subroot . "logconfig.php");
include($cms['tngpath'] . "genlib.php");
include($cms['tngpath'] . "getlang.php");

include($cms['tngpath'] . "checklogin.php");

header("Content-type:text/html; charset=" . $session_charset);
$lines = file($logfile);
foreach ($lines as $line) {
  echo "$line<br/>\n";
}
