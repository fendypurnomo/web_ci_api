<?php

namespace App\Libraries;

class Authorization
{
  public $account;

  public function __construct()
  {
    return $this->authorization();
  }

  private function authorization(): object
  {
    helper('token');

    $authorization = getAuthorization();
    $decodeToken = decodeToken($authorization);
    $user = checkUserToken($decodeToken->data->id);

    return $this->account = $user;
  }
}