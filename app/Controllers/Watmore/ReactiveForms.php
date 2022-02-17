<?php

namespace App\Controllers\Watmore;

use CodeIgniter\RESTful\ResourceController;

class ReactiveForms extends ResourceController
{
	protected $modelName = 'App\Models\Watmore\ReactiveFormsModel';
	protected $format    = 'json';

	public function index()
	{
		$data = $this->model->findAll();
		return $this->respond($data);
	}

	public function show($id = null)
	{
		$query = $this->model->find($id);

		$data = [
			'id'        => $query['id'],
			'title'     => $query['title'],
			'firstName' => $query['firstName'],
			'lastName'  => $query['lastName'],
			'email'     => $query['email'],
			'role'      => $query['role']
		];

		if ($query) {
			return $this->respond($data);
		} else {
			return $this->failNotFound('No data found with id ' . $id);
		}
	}

	public function create()
	{
		$post = $this->request->getJSON();

		$data = [
			'title'     => $post->title,
			'firstName' => $post->firstName,
			'lastName'  => $post->lastName,
			'email'     => $post->email,
			'role'      => $post->role,
			'password'  => password_hash($post->password, PASSWORD_DEFAULT)
		];
		$this->model->insert($data);

		$output = [
			'status'	 => 200,
			'messages' => [
				'success' => 'Data inserted'
			]
		];
		return $this->respond($output);
	}

	public function update($id = null)
	{
		$post = $this->request->getJSON();

		$data = [
			'title'     => $post->title,
			'firstName' => $post->firstName,
			'lastName'  => $post->lastName,
			'email'     => $post->email,
			'role'      => $post->role
		];

		if ($post->password != null) {
			$this->model->update($id, [
				'title'     => $post->title,
				'firstName' => $post->firstName,
				'lastName'  => $post->lastName,
				'email'     => $post->email,
				'role'      => $post->role,
				'password'  => password_hash($post->password, PASSWORD_DEFAULT)
			]);
		} else {
			$this->model->update($id, $data);
		}

		$output = [
			'status'	 => 200,
			'messages' => [
				'success' => 'Data updated'
			]
		];
		return $this->respond($output);
	}

	public function delete($id = null)
	{
		$query = $this->model->find($id);

		if ($query) {
			$this->model->delete($id);
		} else {
			return $this->failNotFound('No data found with id ' . $id);
		}

		$output = [
			'status'	 => 200,
			'messages' => [
				'success' => 'Data deleted'
			]
		];
		return $this->respond($output);
	}
}
