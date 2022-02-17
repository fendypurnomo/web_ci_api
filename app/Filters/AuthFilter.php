<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;

class AuthFilter implements \CodeIgniter\Filters\FilterInterface
{
	use \CodeIgniter\API\ResponseTrait;

	public function before(RequestInterface $request, $arguments = null)
	{
		helper('token');

		try {
			$decode = decodeToken(getAuthorization());

			checkUserToken($decode->data->id);

			return $request;
		} catch (Exception $e) {
			return \Config\Services::response()->setJSON([
				'status'  => 401,
				'error'   => 'Unauthorized',
				'message' => $e->getMessage()
			])->setStatusCode(401);
		}
	}

	public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
	{
	}
}
