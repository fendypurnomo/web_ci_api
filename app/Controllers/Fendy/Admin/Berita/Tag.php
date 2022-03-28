<?php

namespace App\Controllers\Fendy\Admin\Berita;

use Exception;

class Tag extends \App\Controllers\Fendy\BaseAdminController
{
  protected $modelName = 'App\Models\Fendy\Berita\Tag';
  protected $rules;

  public function __construct()
  {
    parent::__construct();
    $this->rules = new \App\Validation\Admin\Tag;
  }

  /**
   * Get all data tags
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
    return $this->respond($this->tableRecordNotFound);
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
    return $this->respond($this->tableRecordNotFound);
  }
}