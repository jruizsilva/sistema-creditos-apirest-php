<?php
require_once 'Config/Config.php';
require_once 'Helpers/Helpers.php';

$url = !empty($_GET['url']) ? $_GET['url'] : "home/home";
$arrUrl = explode('/', $url);
$controllerClassName = ucwords($arrUrl[0]);
$method = $arrUrl[0];
$params = "";

if (!empty($arrUrl[1])) {
  $method = $arrUrl[1];
}
if (!empty($arrUrl[2])) {
  for ($i = 2; $i < count($arrUrl); $i++) {
    $params .= $arrUrl[$i] . ',';
  }
  $params = trim($params, ',');
}

spl_autoload_register(function ($class) {
  if (file_exists("Libraries/Core/$class.php")) {
    require_once "Libraries/Core/$class.php";
  }
});


$controllerFile = "Controllers/" . $controllerClassName . ".php";
if (file_exists($controllerFile)) {
  require_once $controllerFile;
  $controllerClassInstance = new $controllerClassName();
  if (method_exists($controllerClassInstance, $method)) {
    $controllerClassInstance->{$method}($params);
  } else {
    require_once 'Controllers/NotFound.php';
  }
} else {
  require_once 'Controllers/NotFound.php';
}

