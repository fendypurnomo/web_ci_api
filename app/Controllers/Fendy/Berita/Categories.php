<?php

namespace App\Controllers\Fendy\Berita;

class Categories extends \App\Controllers\Fendy\BaseRestfulController
{
	protected $modelName = 'App\Models\Fendy\Berita\Categories';

	/**
	 * Get all data categories
	 */
	function index()
	{
		if ($get = $this->model->getAllData(getQueryParamPagination())) {
			return $this->respond($get);
		}
		return $this->fail($this->TABLE_RECORD_EMPTY);
	}

	/**
	 * Create single data category
	 */
	function create()
	{
		if ($this->validate($this->rules->createCategory)) {
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
	 * Get single data category
	 */
	function show($id = null)
	{
		if ($get = $this->model->showData($id)) {
			return $this->respond($get);
		}
		return $this->failNotFound($this->TABLE_RECORD_NOT_FOUND);
	}

	/**
	 * Get single data category
	 */
	function edit($id = null)
	{
		return $this->show($id);
	}

	/**
	 * Update single data category
	 */
	function update($id = null)
	{
		if ($this->validate($this->rules->createCategory)) {
			if ($put = $this->model->update($id, getRequest())) {
				return $this->respondUpdated($put);
			}
		}
		return $this->fail([
			'error' => 'badRequest',
			'field' => $this->validator->getErrors()
		]);
	}

	/**
	 * Delete single data category
	 */
	function delete($id = null)
	{
		if ($del = $this->model->deleteData($id)) {
			return $this->respondDeleted($del);
		}
		return $this->failNotFound($this->TABLE_RECORD_NOT_FOUND);
	}
}
