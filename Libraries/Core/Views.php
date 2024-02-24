<?php

class Views
{
  function getView($controllerClassInstance, $view, $data = "")
  {
    $controllerClassName = get_class($controllerClassInstance);
    if ($controllerClassName == "Home") {
      $view = "Views/" . $view . ".php";
    } else {
      $view = "Views/" . $controllerClassName . "/" . $view . ".php";
    }
    require_once($view);
  }
}