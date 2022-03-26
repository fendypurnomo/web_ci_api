<?php

namespace App\Controllers\Fendy\Admin\Berita;

class Comments extends \App\Controllers\Fendy\BaseAdminController
{
	protected $modelName = 'App\Models\Fendy\Berita\Comments';

	/**
	 * Get all data comments
	 */
	function index()
	{
		if ($get = $this->model->getAllData(getQueryParamPagination())) {
			return $this->respond($get);
		}
		return $this->respond($this->tableRecordEmpty);
	}

	/**
	 * Create single data comment
	 */
	function create()
	{
		if ($this->validate($this->rules->createComment)) {
			if ($add = $this->model->createData(getRequest())) {
				return $this->respondCreated($add);
			}
		}
		return $this->respond([
			'sucess' => false,
			'error' => 'badRequest',
			'messages' => $this->validator->getErrors()
		]);
	}

	/**
	 * Get single data comment
	 */
	function show($id = null)
	{
		if ($get = $this->model->showData($id)) {
			return $this->respond($get);
		}
		return $this->respond($this->tableRecordNotFound);
	}

	/**
	 * Get single data comment
	 */
	function edit($id = null)
	{
		return $this->show($id);
	}

	/**
	 * Update single data comment
	 */
	function update($id = null)
	{
		if ($this->validate($this->rules->createComment)) {
			if ($put = $this->model->updateData($id, getRequest())) {
				return $this->respondUpdated($put);
			}
		}
		return $this->respond([
			'success' => false,
			'error' => 'badRequest',
			'messages' => $this->validator->getErrors()
		]);
	}

	/**
	 * Delete single data comment
	 */
	function delete($id = null)
	{
		if ($del = $this->model->deleteData($id)) {
			return $this->respondDeleted($del);
		}
		return $this->respond($this->tableRecordNotFound);
	}
}
