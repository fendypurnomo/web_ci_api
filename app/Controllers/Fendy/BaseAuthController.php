<?php

namespace App\Controllers\Fendy;

use App\Validation\MessagesTrait;
use CodeIgniter\API\ResponseTrait;

class BaseAuthController extends \CodeIgniter\RESTful\BaseResource
{
  use ResponseTrait;
  use MessagesTrait;

  protected $model;

  public function __construct()
  {
    helper(['request', 'sendmail', 'stringreplace', 'text', 'token']);

    $this->model = new \App\Models\Fendy\Akun\User;
  }
}