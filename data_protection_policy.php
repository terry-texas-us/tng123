<?php
$nologin = 1;
include "tng_begin.php";

$logstring = "<a href='data_protection_policy.php'>" . xmlcharacters($text['dataprotect']) . "</a>";
writelog($logstring);
preparebookmark($logstring);

tng_header($text['dataprotect'], $flags);

$langfolder = findlangfolder("data_protection_policy.php");

include "$langfolder/data_protection_policy.php";

tng_footer("");
