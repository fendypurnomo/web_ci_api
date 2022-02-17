<?php

namespace App\Controllers\Fendy\Wilayah;

class Kabupatenkota extends \App\Controllers\Fendy\BaseRestfulController
{
	protected $modelName = 'App\Models\Fendy\Wilayah\KabupatenKota';

	/**
	 * Get all data kabupaten kota
	 */
	public function index()
	{
		if ($get = $this->model->getAllData(getQueryParamPagination())) {
			return $this->respond($get);
		}
		return $this->failNotFound('Tidak ada data Wilayah Kabupaten/Kota!');
	}

	/**
	 * Create single data kabupaten kota
	 */
	public function create()
	{
		if ($this->validate($this->rules->kabupatenKota)) {
			if ($add = $this->model->createData(getRequest())) {
				return $this->respondCreated($add);
			}
			return $this->fail($this->requestCantProcessed);
		}
		return $this->fail([
			'message' => $this->validator->getErrors()
		]);
	}

	/**
	 * Get single data kabupaten kota
	 */
	public function show($id = null)
	{
		if ($get = $this->model->showData($id)) {
			return $this->respond($get);
		}
		return $this->failNotFound('Data Wilayah Kabupaten/Kota tidak dapat ditemukan!');
	}

	/**
	 * Get single data kabupaten kota
	 */
	public function edit($id = null)
	{
		return $this->show($id);
	}

	/**
	 * Update single data kabupaten kota
	 */
	public function update($id = null)
	{
		if ($this->validate($this->rules->kabupatenKota)) {
			if ($put = $this->model->updateData($id, getRequest())) {
				return $this->respondUpdated($put);
			}
			return $this->fail($this->requestCantProcessed);
		}
		return $this->fail([
			'message' => $this->validator->getErrors()
		]);
	}

	/**
	 * Delete single data kabupaten kota
	 */
	public function delete($id = null)
	{
		if ($del = $this->model->deleteData($id)) {
			return $this->respondDeleted($del);
		}
		return $this->failNotFound('Data Wilayah Kabupaten/Kota tidak dapat ditemukan!');
	}
}
