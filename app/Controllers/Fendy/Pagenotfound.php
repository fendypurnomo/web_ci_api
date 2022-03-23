<?php

namespace App\Controllers\Fendy;

use App\Libraries\MessagesTrait;

class Pagenotfound extends \CodeIgniter\RESTful\ResourceController
{
  use MessagesTrait;

  // Index page not found
  function index()
  {
    return $this->failNotFound($this->pageNotFound)->send();
  }
}