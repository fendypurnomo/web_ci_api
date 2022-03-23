<?php

namespace App\Controllers\Fendy;

class Mac extends \CodeIgniter\Controller
{
  function index()
  {
    $mac = new \App\Libraries\Macaddress('Windows');
    return $this->response->setJSON($mac::$macAddress);
  }
}
