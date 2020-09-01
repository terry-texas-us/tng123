<?php

if (isset($_GET['lang']) || isset($_GET['mylanguage']) || isset($_GET['language']) || isset($_GET['session_language']) || isset($_GET['rootpath'])) {
    die("Sorry!");
}
$tngconfig = array();

if (strpos($_SERVER['SCRIPT_NAME'], "/admin_updateconfig.php") === FALSE) {
    include "processvars.php";
}

include "subroot.php";
include_once "tngconnect.php";
include $tngconfig['subroot'] . "config.php";
$subroot = $tngconfig['subroot'] ? $tngconfig['subroot'] : $cms['tngpath'];

$templatepfx = is_numeric($templatenum) ? "template" : "";
$templatepath = $templateswitching && $templatenum ? "templates/$templatepfx$templatenum/" : "";

if (isset($sitever)) {
    setcookie("tng_siteversion", $sitever, time() + 31536000, "/");
} else {
    if (isset($_COOKIE['tng_siteversion'])) {
        $sitever = $_COOKIE['tng_siteversion'];
    }
}

include_once "siteversion.php";
if (!isset($sitever)) {
    $sitever = getSiteVersion();
}

@session_start();
$session_language = $_SESSION['session_language'] ?? $language;
$session_charset = $_SESSION['session_charset'] ?? $charset;

$endrootpath = "";

$languages_path = "languages/";
include $cms['tngpath'] . "getlang.php";


include "./admin/locale.php";

function _todo_($text) {
    return $text;
}

$link = tng_db_connect($database_host, $database_name, $database_username, $database_password, $database_port, $database_socket);

require_once "./core/templates.php";
