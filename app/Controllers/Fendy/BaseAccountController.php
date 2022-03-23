<?php

namespace App\Controllers\Fendy;

use App\Libraries\MessagesTrait;
use CodeIgniter\API\ResponseTrait;

class BaseAccountController extends \CodeIgniter\RESTful\BaseResource
{
  use ResponseTrait;
  use MessagesTrait;

  protected $model;
  protected $rules;

  public function __construct()
  {
    helper(['request', 'sendmail', 'text', 'token', 'validation']);

    $this->model = new \App\Models\Fendy\Akun\User;
    $this->rules = new \App\Validation\User;
  }
}
