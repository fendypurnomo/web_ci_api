<?php

namespace App\Controllers\Fendy\Admin\Berita;

class Categories extends \App\Controllers\Fendy\BaseAdminController
{
	protected $modelName = 'App\Models\Fendy\Berita\Categories';
	protected $rules;

  public function __construct()
  {
    $this->rules = new \App\Validation\Admin\Categories;
  }

	/**
	 * Get all data categories
	 */
	function index()
	{
		if ($get = $this->model->getAllData(getQueryParamPagination())) {
			return $this->respond($get);
		}
		return $this->respond($this->tableRecordEmpty);
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
		return $this->respond([
			'success' => false,
			'error' => 'badRequest',
			'messages' => $this->validator->getErrors()
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
		return $this->respond($this->tableRecordNotFound);
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
		return $this->respond([
			'success' => false,
			'error' => 'badRequest',
			'messages' => $this->validator->getErrors()
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
		return $this->respond($this->tableRecordNotFound);
	}
}