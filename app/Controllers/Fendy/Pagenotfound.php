<?php

namespace App\Controllers\Fendy;

use App\Validation\MessagesTrait;

class Pagenotfound extends \CodeIgniter\RESTful\ResourceController
{
    use MessagesTrait;

    function index()
    {
        return $this->failNotFound($this->pageNotFound)->send();
    }
}
