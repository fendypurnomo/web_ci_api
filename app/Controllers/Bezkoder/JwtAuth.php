<?php

namespace App\Controllers\Bezkoder;

use CodeIgniter\RESTful\ResourceController;
use Firebase\JWT\JWT;

class JwtAuth extends ResourceController
{
	protected $modelName = 'App\Models\Bezkoder\JwtAuthModel';
	protected $format    = 'json';

	public function privateKey()
	{
		$privateKey = <<<EOD
			-----BEGIN RSA PRIVATE KEY-----
			MIICXAIBAAKBgQC8kGa1pSjbSYZVebtTRBLxBz5H4i2p/llLCrEeQhta5kaQu/Rn
			vuER4W8oDH3+3iuIYW4VQAzyqFpwuzjkDI+17t5t0tyazyZ8JXw+KgXTxldMPEL9
			5+qVhgXvwtihXC1c5oGbRlEDvDF6Sa53rcFVsYJ4ehde/zUxo6UvS7UrBQIDAQAB
			AoGAb/MXV46XxCFRxNuB8LyAtmLDgi/xRnTAlMHjSACddwkyKem8//8eZtw9fzxz
			bWZ/1/doQOuHBGYZU8aDzzj59FZ78dyzNFoF91hbvZKkg+6wGyd/LrGVEB+Xre0J
			Nil0GReM2AHDNZUYRv+HYJPIOrB0CRczLQsgFJ8K6aAD6F0CQQDzbpjYdx10qgK1
			cP59UHiHjPZYC0loEsk7s+hUmT3QHerAQJMZWC11Qrn2N+ybwwNblDKv+s5qgMQ5
			5tNoQ9IfAkEAxkyffU6ythpg/H0Ixe1I2rd0GbF05biIzO/i77Det3n4YsJVlDck
			ZkcvY3SK2iRIL4c9yY6hlIhs+K9wXTtGWwJBAO9Dskl48mO7woPR9uD22jDpNSwe
			k90OMepTjzSvlhjbfuPN1IdhqvSJTDychRwn1kIJ7LQZgQ8fVz9OCFZ/6qMCQGOb
			qaGwHmUK6xzpUbbacnYrIM6nLSkXgOAwv7XXCojvY614ILTK3iXiLBOxPu5Eu13k
			eUz9sHyD6vkgZzjtxXECQAkp4Xerf5TGfQXGXhxIX52yH+N2LtujCdkQZjXAsGdm
			B2zNzvrlgRmgBrklMTrMYgm1NPcW+bRLGcwgW2PTvNM=
			-----END RSA PRIVATE KEY-----
		EOD;

		return $privateKey;
	}

	public function all()
	{
		return $this->response
			->setStatusCode(200)
			->setContentType('text/plain')
			->setBody('Angular 11 - JWT Authentication with Codeigniter 4 Restful API.');
	}

	public function user()
	{
		return $this->response
			->setStatusCode(200)
			->setContentType('text/plain')
			->setBody('User Dashboard');
	}

	public function mod()
	{
		return $this->response
			->setStatusCode(200)
			->setContentType('text/plain')
			->setBody('Moderator Dashboard');
	}

	public function admin()
	{
		return $this->response
			->setStatusCode(200)
			->setContentType('text/plain')
			->setBody('Admin Dashboard');
	}

	public function signin()
	{
		$post  = $this->request->getJSON();
		$query = $this->model
			->where('username', $post->username)
			->orWhere('email', $post->username)
			->limit(1)
			->first();

		if ($query > 0) {
			if (password_verify($post->password, $query['password'])) {
				$payload = [
					'aud' => 'audience'
				];

				$jwt = JWT::encode($payload, $this->privateKey());

				$output = [
					'username'    => $query['username'],
					'email'       => $query['email'],
					'accessToken' => $jwt,
					'roles'       => [$query['roles']]
				];
			} else {
				$output = [
					'status'  => 400,
					'message' => 'Login failed. Password you are entered is wrong!'
				];
			}
		} else {
			$output = [
				'status'  => 400,
				'message' => 'Sorry, your username not found!'
			];
		}
		return $this->respond($output);
	}

	public function signup()
	{
		$post = $this->request->getJSON();

		$data = [
			'username' => $post->username,
			'email'    => $post->email,
			'password' => password_hash($post->password, PASSWORD_DEFAULT)
		];
		$this->model->insert($data);

		$output = [
			'status'  => 200,
			'message' => 'Data inserted'
		];
		return $this->respond($output);
	}
}
