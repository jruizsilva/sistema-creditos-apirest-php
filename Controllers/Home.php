<?php

class Home extends Controllers
{
  public function __construct()
  {
    parent::__construct();
  }


  public function home($params)
  {
    $data['page_tag'] = "Home";
    $data['page_title'] = "Pagina principal - Jonathan";
    $data['page_name'] = "home";
    $this->getViews()->getView($this, "home", $data);
  }

}
