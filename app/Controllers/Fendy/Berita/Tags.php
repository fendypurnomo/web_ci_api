<?php

namespace App\Controllers\Fendy\Berita;

class Tags extends \App\Controllers\Fendy\BaseRestfulController
{
	protected $modelName = 'App\Models\Fendy\Berita\Tags';

	/**
	 * Get all data tags
	 */
	function index()
	{
		if ($get = $this->model->getAllData(getQueryParamPagination())) {
			return $this->respond($get);
		}
		return $this->fail($this->TABLE_RECORD_EMPTY);
	}

	/**
	 * Create single data tag
	 */
	function create()
	{
		if ($this->validate($this->rules->createTag)) {
			if ($add = $this->model->createData(getRequest())) {
				return $this->respondCreated($add);
			}
		}
		return $this->fail([
			'error' => 'badRequest',
			'field' => $this->validator->getErrors()
		]);
	}

	/**
	 * Get single data tag
	 */
	function show($id = null)
	{
		if ($get = $this->model->showData($id)) {
			return $this->respond($get);
		}
		return $this->failNotFound($this->TABLE_RECORD_NOT_FOUND);
	}

	/**
	 * Get single data tag
	 */
	function edit($id = null)
	{
		return $this->show($id);
	}

	/**
	 * Update single data tag
	 */
	function update($id = null)
	{
		if ($this->validate($this->rules->createTag)) {
			if ($put = $this->model->update($id, getRequest())) {
				return $this->respondUpdated($put);
			}
			return $this->fail($this->requestCantProcessed);
		}
		return $this->fail([
			'error' => 'badRequest',
			'field' => $this->validator->getErrors()
		]);
	}

	/**
	 * Delete single data tag
	 */
	function delete($id = null)
	{
		if ($del = $this->model->deleteData($id)) {
			return $this->respondDeleted($del);
		}
		return $this->failNotFound($this->TABLE_RECORD_NOT_FOUND);
	}
}
