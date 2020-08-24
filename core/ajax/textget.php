<?php

function isAjaxRequest() {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
}

if (isAjaxRequest()) {
    $scriptName = is_string($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : '';
    if (strpos($scriptName, 'ajax/textget.php') !== false) {
        $source = $_GET['source'] ?? 'source not passed';
        echo $source;
    }
}
