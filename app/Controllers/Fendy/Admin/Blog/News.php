<?php

namespace App\Controllers\Fendy\Admin\Blog;

use Exception;

class News extends \App\Controllers\Fendy\BaseAdminController
{
  protected $modelName = 'App\Models\Fendy\Blog\News';
  protected $rules;

  public function __construct()
  {
    parent::__construct();
    $this->rules = new \App\Validation\Admin\Blog\News;
  }

	/**
	 * Get all data news
	 */
	function index()
	{
		try {
			if ($get = $this->model->getAllData(getRequestQueryParamPagination()))
			return $this->respond($get);
		}
		catch (Exception $e) {
			return $this->respond([
				'success' => false,
				'messages' => $e->getMessage()
			]);
		}
	}

	/**
	 * Create single data news
	 */
	function create()
	{
		if ($this->validate($this->rules->createNews)) {
			$img = $this->request->getFile('img');

			if ($add = $this->model->createData(getRequest(), $img)) {
				return $this->respondCreated($add);
			}
			return $this->respond([$this->requestNotFound]);
		}
		return $this->respond([
			'success' => false,
			'error' => 'badRequest',
			'messages' => $this->validator->getErrors()
		]);
	}

	/**
	 * Get single data news
	 */
	function show($id = null)
	{
		if ($get = $this->model->showData($id)) {
			return $this->respond($get);
		}
		return $this->respond($this->tableRecordNotFound);
	}

	/**
	 * Get single data news
	 */
	function edit($id = null)
	{
		return $this->show($id);
	}

	/**
	 * Update single data news
	 */
	function update($id = null)
	{
		if ($this->validate($this->rules->createNews)) {
			if ($put = $this->model->updateData($id, getRequest())) {
				return $this->respondUpdated($put);
			}
			return $this->fail($this->requestNotFound);
		}
		return $this->respond([
			'success' => false,
			'error' => 'badRequest',
			'messages' => $this->validator->getErrors()
		]);
	}

	/**
	 * Delete single data news
	 */
	function delete($id = null)
	{
		if ($del = $this->model->deleteData($id)) {
			return $this->respondDeleted($del);
		}
		return $this->respond($this->tableRecordNotFound);
	}
}