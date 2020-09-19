<?php
function help_header($helptitle) {
    $relpath = "../../";
    include $relpath . "begin.php";
    include $relpath . "version.php";
    $header = "<!doctype html>\n";
    $header .= "<html lang=\"en\">\n";

    $header .= "<head>\n";
    $header .= "<title>$helptitle</title>\n";
    $header .= "<meta name=\"author\" content=\"Darrin Lythgoe\">\n";
    $header .= "<meta charset=utf-8\">\n";
    $header .= "<link href=\"{$relpath}css/bootstrap-reboot.min.css\" rel=\"stylesheet\" type=\"text/css\">\n";
    $header .= "<link href=\"{$relpath}css/genstyle.css?v=$tng_version\" rel=\"stylesheet\" type=\"text/css\">\n";
    $header .= "<link href=\"{$relpath}{$templatepath}css/templatestyle.css?v=$tng_version\" rel=\"stylesheet\" type=\"text/css\">\n";
    $header .= "<link href=\"{$relpath}{$templatepath}css/mytngstyle.css?v=$tng_version\" rel=\"stylesheet\" type=\"text/css\">\n";
    $header .= file_get_contents($relpath . "adminmeta.php");
    $header .= "<style>p {margin-top: 0;}</style>\n";
    $header .= "</head>";

    return $header;
}

global $link;
