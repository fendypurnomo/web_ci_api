<?php

namespace App\Controllers\Fendy;

use App\Validation\MessagesTrait;

class BaseAdminController extends \CodeIgniter\RESTful\ResourceController
{
  use MessagesTrait;

  public function __construct()
  {
    helper(['request', 'token']);
  }
}