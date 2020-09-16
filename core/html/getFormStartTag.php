<?php

function getFormStartTag($action, $method, $class = "", $id = "", $onsubmit = null) {
    $url = $action ? $action . ".php" : "";
    $html = "<form action=\"$url\"";
    if ($method) {
        $html .= " method=\"$method\"";
    }
    if ($class) {
        $html .= " class=\"$class\"";
    }
    if ($id) {
        $html .= " id=\"$id\"";
    }
    if ($onsubmit) {
        $html .= " onsubmit=\"$onsubmit\"";
    }
    $html .= ">\n";
    return $html;
}
