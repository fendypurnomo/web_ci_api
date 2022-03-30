<?php

namespace App\Controllers\Fendy\Admin\Blog;

use Exception;

class Category extends \App\Controllers\Fendy\BaseAdminController
{
  protected $modelName = 'App\Models\Fendy\Blog\Category';
  protected $rules;

  public function __construct()
  {
    parent::__construct();
    $this->rules = new \App\Validation\Admin\Blog\Category;
  }

  /**
   * Get all data categories
   */
  public function index()
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
   * Create single data category
   */
  public function create()
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
  public function show($id = null)
  {
    if ($get = $this->model->showData($id)) {
      return $this->respond($get);
    }
    return $this->respond($this->tableRecordNotFound);
  }

  /**
   * Get single data category
   */
  public function edit($id = null)
  {
    return $this->show($id);
  }

  /**
   * Update single data category
   */
  public function update($id = null)
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
  public function delete($id = null)
  {
    if ($del = $this->model->deleteData($id)) {
      return $this->respondDeleted($del);
    }
    return $this->respond($this->tableRecordNotFound);
  }
}