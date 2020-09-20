<?php
// MODHANDLER
// avoid PHP notices
if (!isset($extspath)) {
    $extspath = '';
}
if (!isset($modspath)) {
    $modspath = '';
}
$objinits = [
    'rootpath' => $rootpath,
    'modspath' => $modspath,
    'extspath' => $extspath,
    'options' => $options,
    'time_offset' => $time_offset,
    'sitever' => $sitever,
    'currentuserdesc' => $mhuser,
    'admtext' => $admtext,
    'templatenum' => $templatenum,
    'tng_version' => $tng_version
];
