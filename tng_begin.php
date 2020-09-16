<?php
include_once "begin.php";

$tmp = getTemplateVars($templates_table, $templatenum);

include "genlib.php";
include "$mylanguage/text.php";

include "tngdblib.php";

if ((strpos($_SERVER['SCRIPT_NAME'], "/changelanguage.php") === FALSE && strpos($_SERVER['SCRIPT_NAME'], "/newacctform.php") === FALSE && strpos($_SERVER['SCRIPT_NAME'], "/addnewacct.php") === FALSE &&
        strpos($_SERVER['SCRIPT_NAME'], "/login.php") === FALSE && (!isset($nologin) || !$nologin) && (strpos($_SERVER['SCRIPT_NAME'], "/suggest.php") === FALSE || !empty($enttype))) || $_SESSION['currentuser']) {
    include "checklogin.php";
} else {
    $currentuser = $_SESSION['currentuser'];
    $currentuserdesc = $_SESSION['currentuserdesc'];
}
include "log.php";
