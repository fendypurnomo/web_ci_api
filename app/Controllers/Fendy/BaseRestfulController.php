<?php

namespace App\Controllers\Fendy;

use App\Libraries\MessagesTrait;

class BaseRestfulController extends \CodeIgniter\RESTful\ResourceController
{
	use MessagesTrait;

	protected $rules;

	public function __construct()
	{
		helper('request');

		$this->rules = new \App\Validation\News;
	}
}
