<?php

namespace App\Controllers\Fendy\Admin\Wilayah;

class Kecamatan extends \App\Controllers\Fendy\BaseAdminController
{
	protected $modelName = 'App\Models\Fendy\Wilayah\Kecamatan';

	/**
	 * Get all data kecamatan
	 */
	public function index()
	{
		if ($get = $this->model->getAllData(getQueryParamPagination())) {
			return $this->respond($get);
		}
		return $this->failNotFound('Tidak ada data Wilayah Kecamatan!');
	}

	/**
	 * Create single data kecamatan
	 */
	public function create()
	{
		if ($this->validate($this->rules->kecamatan)) {
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
	 * Get single data kecamatan
	 */
	public function show($id = null)
	{
		if ($get = $this->model->showData($id)) {
			return $this->respond($get);
		}
		return $this->failNotFound('Data Wilayah Kecamatan tidak dapat ditemukan!');
	}

	/**
	 * Get single data kecamatan
	 */
	public function edit($id = null)
	{
		return $this->show($id);
	}

	/**
	 * Update single data kecamatan
	 */
	public function update($id = null)
	{
		if ($this->validate($this->rules->kecamatan)) {
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
	 * Delete single data kecamatan
	 */
	public function delete($id = null)
	{
		if ($del = $this->model->deleteData($id)) {
			return $this->respondDeleted($del);
		}
		return $this->failNotFound('Data Wilayah Kecamatan tidak dapat ditemukan!');
	}
}
