<?php
require_once "libs/util.php";

$access = getAccessInfo();

$controller = $access["controller"];
$method     = $access["method"];

loadFile("libs/MongoModel.class.php");
loadFile("libs/MysqlModel.class.php");
loadFile("libs/controller.class.php");
loadFile("controllers/{$controller}_controller.php");
$class = toCamelCase("{$controller}_controller");

$obj = new $class;
$obj->$method();
$obj = null;
