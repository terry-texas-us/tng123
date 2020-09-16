<?php
include "begin.php";
include "genlib.php";
$textpart = "search";
include "getlang.php";

include "checklogin.php";

$anniversaries_url = getURL("anniversaries", 1);

$tngyear = preg_replace("/[^0-9]/", "", $tngyear);
$tngkeywords = preg_replace("/[^A-Za-z0-9]/", "", $tngkeywords);

header("Location: " . "$anniversaries_url" . "tngevent=$tngevent&tngdaymonth=$tngdaymonth&tngmonth=$tngmonth&tngyear=$tngyear&tngkeywords=$tngkeywords&tngneedresults=$tngneedresults&offset=$offset&tree=$tree&tngpage=$tngpage");
