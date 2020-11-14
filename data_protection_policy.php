<?php
$nologin = 1;
include "tng_begin.php";

$logstring = "<a href='data_protection_policy.php'>" . xmlcharacters(_('Data Protection Policy')) . "</a>";
writelog($logstring);
preparebookmark($logstring);

tng_header(_('Data Protection Policy'), $flags);

$langfolder = findlangfolder("data_protection_policy.php");

include "$langfolder/data_protection_policy.php";

tng_footer("");
