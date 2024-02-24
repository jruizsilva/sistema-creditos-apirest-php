<?php

class Controllers
{
  private $model;
  private $views;

  public function __construct()
  {
    $this->views = new Views();
    $this->loadModel();
  }

  public function loadModel()
  {
    $modelClassName = get_class($this) . "Model";
    $routeClass = "Models/" . $modelClassName . ".php";

    if (file_exists($routeClass)) {
      require_once($routeClass);
      $this->model = new $modelClassName();
    }
  }

  public function getModel()
  {
    return $this->model;
  }

  public function getViews()
  {
    return $this->views;
  }
}