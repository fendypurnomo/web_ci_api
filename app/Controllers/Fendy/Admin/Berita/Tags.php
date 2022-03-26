<?php

namespace App\Controllers\Fendy\Admin\Berita;

class Tags extends \App\Controllers\Fendy\BaseAdminController
{
	protected $modelName = 'App\Models\Fendy\Berita\Tags';
	protected $rules;

	public function __construct()
	{
		$this->rules = new \App\Validation\Admin\Tags;
	}

	/**
	 * Get all data tags
	 */
	function index()
	{
		if ($get = $this->model->getAllData(getQueryParamPagination())) {
			return $this->respond($get);
		}
		return $this->fail($this->tableRecordEmpty);
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
		return $this->respond([
			'success' => false,
			'error' => 'badRequest',
			'messages' => $this->validator->getErrors()
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
		return $this->failNotFound($this->tableRecordNotFound);
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
		return $this->respond([
			'success' => false,
			'error' => 'badRequest',
			'messages' => $this->validator->getErrors()
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
		return $this->failNotFound($this->tableRecordNotFound);
	}
}