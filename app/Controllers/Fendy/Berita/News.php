<?php

namespace App\Controllers\Fendy\Berita;

class News extends \App\Controllers\Fendy\BaseRestfulController
{
	protected $modelName = 'App\Models\Fendy\Berita\News';

	private $user;

	public function __construct()
	{
		parent::__construct();

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
		return $this->fail($this->tableRecordEmpty);
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
		return $this->fail([
			'error' => 'invalidInput',
			'field' => $this->validator->getErrors()
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
		return $this->failNotFound($this->tableRecordNotFound);
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
		return $this->fail([
			'error' => 'badRequest',
			'field' => $this->validator->getErrors()
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
		return $this->failNotFound($this->tableRecordNotFound);
	}
}
