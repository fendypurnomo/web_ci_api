<?php

namespace App\Controllers\Fendy\Admin\Berita;

class News extends \App\Controllers\Fendy\BaseAdminController
{
  protected $modelName = 'App\Models\Fendy\Berita\News';
  protected $rules;

  private $user;

  public function __construct()
  {
    parent::__construct();

    $this->rules = new \App\Validation\Admin\News;
    $this->user = new \App\Libraries\Authorization();
  }

	/**
	 * Get all data news
	 */
	function index()
	{
		if ($get = $this->model->getAllData(getQueryParamPagination())) {
			return $this->respond($get);
		}
		return $this->respond($this->tableRecordEmpty);
	}

	/**
	 * Create single data news
	 */
	function create()
	{
		if ($this->validate($this->rules->createNews)) {
			if ($add = $this->model->createData(getRequest(), $this->user->account->pengguna_id)) {
				return $this->respondCreated($add);
			}
			return $this->fail($this->requestNotFound);
		}
		return $this->respond([
			'success' => false,
			'error' => 'invalidInput',
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