<?php
$url = $_SERVER["SCRIPT_NAME"];
$break = Explode('/', $url);
$file = $break[count($break) - 1];
$cachefile = substr_replace($file, "", -4);

$newsitever = getSiteVersion();
if (isMobile() || $newsitever != "standard") {
    if (isMobile()) {
        $cachefile = ($cachefile . '_cache_m.html');
    } elseif (!isMobile() || $newsitever == "mobile") {
        $cachefile = ($cachefile . '_cache_mdt.html');
    }
} else {
    $cachefile = ($cachefile . '_cache.html');
}

if (!$cachemode) {
    if (file_exists($cachefile) && time() - $cachetime < filemtime($cachefile)) {
        readfile($cachefile);
        exit;
    }
} else {
    if (file_exists($cachefile)) {
        readfile($cachefile);
        exit;
    }
}
ob_start();
