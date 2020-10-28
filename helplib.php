<?php

define("INCLUDED_LANGUAGES", "cs,de,en,es,po");

function help_header($helptitle) {
    $relpath = "../../";
    include $relpath . "begin.php";
    include $relpath . "version.php";
    $header = "<!doctype html>\n";
    $header .= "<html lang='en'>\n";
    $header .= "<head>\n";
    $header .= "<title>$helptitle</title>\n";
    $header .= "<meta charset='utf-8'>\n";
    $header .= "<meta name='author' content='Darrin Lythgoe'>\n";
    $header .= "<link href='{$relpath}build/styles/style.css' rel='stylesheet'>\n";
    $header .= "<link href='{$relpath}{$templatepath}styles/style.css' rel='stylesheet'>\n";
    $header .= "</head>";
    return $header;
}

global $link;
