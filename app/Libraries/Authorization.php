<?php

namespace App\Libraries;

use Exception;

class Authorization
{
  public $account;

  public function __construct()
  {
    return $this->authorization();
  }

  private function authorization(): object
  {
    helper(['request', 'token']);

    $authorization = getAuthorization();
    $decodeToken   = decodeToken($authorization);

    $model = new \App\Models\Fendy\Akun\User();
    $query = $model->find($decodeToken->data->id);

    if (!$query) throw new Exception('Maaf, kami tidak dapat menemukan akun Anda!');

    return $this->account = $query;
  }
}
