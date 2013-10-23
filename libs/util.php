<?php
define("ROOT", dirname(__FILE__) . '/../');

define("SITE", "http://service.tnnsst35.com/twitter/");

define("MINUTE", 60);
define("HOUR", MINUTE * 60);
define("DAY", HOUR * 24);

function pr($ary) {
    print_r($ary);
}

function vd($ary) {
    var_dump($ary);
}

function e($str) {
    echo $str;
}

function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, "UTF-8");
}

function eh($str) {
    e(h($str, ENT_QUOTES, "UTF-8"));
}

function inRange($val, $min, $max) {
    return $val <= $max && $val >= $min;
}

function getParam($key, $default = null) {
    return isset($_GET[$key]) ? $_GET[$key] : $default;
}

function postParam($key, $default = null) {
    return isset($_POST[$key]) ? $_POST[$key] : $default;
}

function requestParam($key, $default = null) {
    return isset($_REQUEST[$key]) ? $_REQUEST[$key] : $default;
}

function redirect($url) {
    header("Location: {$url}");
}

function loadFile($path) {
    require_once ROOT . "{$path}";
}

function loadFiles($paths) {
    foreach ($paths as $path) {
        loadFile($path);
    }
}

function toCamelCase($str) {
    $tokens = explode("_", $str);
    $res = "";
    foreach ($tokens as $token) {
        $res .= ucfirst($token);
    }
    return $res;
}

function getAccessInfo() {
    $url        = getParam("url");
    if ($url) {
        list($controller, $method) = explode("/", $url);
    }
    if (!isset($controller) || !$controller) $controller = "top";
    if (!isset($method) || !$method)         $method     = "index";
    return array(
            "controller" => $controller,
            "method"     => $method,
            );
}

function _log($log, $filename = "debug") {
    $fp  = fopen(ROOT . "logs/" . $filename . ".log", "a+");
    $now = date("Y-m-d H:i:s");
    fwrite($fp, "[{$now}] {$log}");
    fclose($fp);
}
