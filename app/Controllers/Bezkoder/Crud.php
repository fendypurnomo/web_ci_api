<?php

namespace App\Controllers\Bezkoder;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class Crud extends ResourceController
{
	use ResponseTrait;

	protected $modelName = 'App\Models\Bezkoder\CrudModel';
	protected $format    = 'json';

	public function index()
	{
		$query = $this->model->findAll();
		return $this->respond($query);
	}

	public function show($id = null)
	{
		$query = $this->model->find($id);

		if ($query) {
			return $this->respond($query);
		} else {
			return $this->failNotFound('No data found with id ' . $id);
		}
	}

	public function create()
	{
		$data  = $this->request->getJSON();

		$this->model->insert($data);

		$output = [
			'status'  => 200,
			'message' => [
				'success' => 'Data inserted'
			]
		];
		return $this->respond($output);
	}

	public function update($id = null)
	{
		$data  = $this->request->getJSON();

		$this->model->update($id, $data);

		$output = [
			'status'  => 200,
			'message' => [
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
			'status'  => 200,
			'message' => [
				'success' => 'Data deleted'
			]
		];

		return $this->respond($output);
	}
}
