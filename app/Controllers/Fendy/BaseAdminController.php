<?php

namespace App\Controllers\Fendy;

use App\Validation\MessagesTrait;

class BaseAdminController extends \CodeIgniter\RESTful\ResourceController
{
  use MessagesTrait;

  protected $rules;

  public function __construct()
  {
    helper('request');
  }
}