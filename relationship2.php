<?php
include "begin.php";
include "genlib.php";
$textpart = "search";
include "getlang.php";

include "checklogin.php";

$relationship_url = getURL("relationship", 1);

header("Location: " . "$relationship_url" . $_SERVER['QUERY_STRING']);
