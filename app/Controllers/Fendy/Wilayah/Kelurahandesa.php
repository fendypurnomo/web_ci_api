<?php

namespace App\Controllers\Fendy\Wilayah;

class Kelurahandesa extends \App\Controllers\Fendy\BaseRestfulController
{
	protected $modelName = 'App\Models\Fendy\Wilayah\KelurahanDesa';

	/**
	 * Get all data kelurahan desa
	 */
	public function index()
	{
		if ($get = $this->model->getAllData(getQueryParamPagination())) {
			return $this->respond($get);
		}
		return $this->failNotFound('Tidak ada data Wilayah Kelurahan/Desa!');
	}

	/**
	 * Create single data kelurahan desa
	 */
	public function create()
	{
		if ($this->validate($this->rules->kelurahanDesa)) {
			if ($add = $this->model->insert(getRequest())) {
				return $this->respondCreated($add);
			}
			return $this->fail($this->requestCantProcessed);
		}
		return $this->fail([
			'message' => $this->validator->getErrors()
		]);
	}

	/**
	 * Get single data kelurahan desa
	 */
	public function show($id = null)
	{
		if ($get = $this->model->showData($id)) {
			return $this->respond($get);
		}
		return $this->failNotFound('Data Wilayah Kelurahan/Desa tidak dapat ditemukan!');
	}

	/**
	 * Get single data keluarahan desa
	 */
	public function edit($id = null)
	{
		return $this->show($id);
	}

	/**
	 * Update single data kelurahan desa
	 */
	public function update($id = null)
	{
		if ($this->validate($this->rules->kelurahanDesa)) {
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
	 * Delete single data kelurahan desa
	 */
	public function delete($id = null)
	{
		if ($del = $this->model->deleteData($id)) {
			return $this->respondDeleted($del);
		}
		return $this->failNotFound('Data Wilayah Kelurahan/Desa tidak dapat ditemukan!');
	}
}
