<?php
class NotFound extends Controllers
{
  public function __construct()
  {
    parent::__construct();

  }

  public function notFound()
  {
    $this->getViews()->getView($this, "notfound");
  }
}

$notFound = new NotFound();
$notFound->notFound();