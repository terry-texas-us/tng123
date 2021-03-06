<?php
$mylanguage = "";
if ($session_language) {
    $mylanguage = $languages_path . $session_language;
} else {
    $newroot = preg_replace("/\//", "", $rootpath);
    $newroot = preg_replace("/ /", "", $newroot);
    $newroot = preg_replace("/\./", "", $newroot);
    $langcookiename = "tnglang_$newroot";
    $charcookiename = "tngchar_$newroot";
    $norelscookiename = "tngnorels_$newroot";

    if (isset($_COOKIE[$langcookiename])) {
        $mylanguage = $languages_path . $_COOKIE[$langcookiename];
        $_SESSION['session_language'] = $_COOKIE[$langcookiename];
        if (isset($_COOKIE[$charcookiename])) {
            $session_charset = $_SESSION['session_charset'] = $_COOKIE[$charcookiename];
        } else {
            $session_charset = $_SESSION['session_charset'] = "";
        }
        if (isset($_COOKIE[$norelscookiename])) {
            $session_norels = $_SESSION['session_norels'] = $_COOKIE[$norelscookiename];
        } else {
            $session_norels = $_SESSION['session_norels'] = "";
        }
    } elseif (isset($lang)) {
        $mylanguage = $languages_path . $lang;
        $_SESSION['session_language'] = $lang;
        $session_norels = $norels;
    }
}
if ($mylanguage) {
    if (!isset($endrootpath)) $endrootpath = '';
    $file_exists = file_exists($rootpath . $endrootpath . "$mylanguage/text.php");
} else {
    $file_exists = false;
}
if (!$mylanguage || !$file_exists) {
    $mylanguage = $languages_path . $language;
    $_SESSION['session_language'] = $language;
}
$session_language = $_SESSION['session_language'] ?? '';
$session_norels = $_SESSION['session_norels'] ?? '';

if (!$session_charset) {
    $session_charset = $_SESSION['session_charset'] = ($charset ? $charset : "ISO-8859-1");
}
