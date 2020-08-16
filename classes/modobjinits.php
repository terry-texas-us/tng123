<?php
// MODHANDLER
// avoid PHP notices
if (!isset($extspath)) {
  $extspath = '';
}
if (!isset($modspath)) {
  $modspath = '';
}
if (!empty($subroot)) {
  $subroot = rtrim($subroot, "/") . "/";
}
$objinits = array(
        'rootpath' => $rootpath,
        'subroot' => $subroot,
        'modspath' => $modspath,
        'extspath' => $extspath,
        'options' => $options,
        'time_offset' => $time_offset,
        'sitever' => $sitever,
        'currentuserdesc' => $mhuser,
        'admtext' => $admtext,
        'templatenum' => $templatenum,
        'tng_version' => $tng_version
);
?>