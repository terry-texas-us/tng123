<?php

define("INCLUDED_LANGUAGES", "cs,de,en,es,po");

function help_header($helptitle) {
    $relpath = "../../";
    include $relpath . "begin.php";
    include $relpath . "version.php";
    $header = "<!doctype html>\n";
    $header .= "<html lang='en'>\n";

    $header .= "<head>\n";
    $header .= "<meta charset='utf-8'>\n";
    $header .= "<title>$helptitle</title>\n";
    $header .= "<meta name='author' content='Darrin Lythgoe'>\n";
    $header .= "<link href='{$relpath}css/bootstrap-reboot.min.css' rel='stylesheet'>\n";
    $header .= "<link href='{$relpath}css/genstyle.css?v=$tng_version' rel='stylesheet'>\n";
    $header .= "<link href='{$relpath}{$templatepath}css/templatestyle.css?v=$tng_version' rel='stylesheet'>\n";
    $header .= "<link href='{$relpath}{$templatepath}css/mytngstyle.css?v=$tng_version' rel='stylesheet'>\n";
    $header .= file_get_contents($relpath . "adminmeta.php");
    $header .= "</head>";

    return $header;
}

global $link;
