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
      $query = $this->model->getAllData(getRequestQueryParamPagination());
      return $this->respond($query);
    }
    catch (Exception $e) {
      return $this->respond([
        'success' => false,
        'messages' => $e->getMessage()
      ]);
    }
  }

  /**
   * Create data news
   */
  function create()
  {
    try {
      if ($this->validate($this->rules->createNews)) {
        $img = $this->request->getFile('img');
        $query = $this->model->createData(getRequest(), $img);
        return $this->respondCreated($query);
      }
      return $this->respond([
        'success' => false,
        'error' => 'badRequest',
        'messages' => $this->validator->getErrors()
      ]);
    }
    catch (Exception $e) {
      return $this->respond(['success' => false, 'messages' => $e->getMessage()]);
    }
  }

  /**
   * Get single data news
   */
  function show($id = null)
  {
    try {
      $query = $this->model->showData($id);
      return $this->respond($query);
    }
    catch (Exception $e) {
      return $this->respond(['success' => false, 'messages' => $e->getMessage()]);
    }
  }

  /**
   * Get single data news
   */
  function edit($id = null)
  {
    return $this->show($id);
  }

  /**
   * Update data news
   */
  function update($id = null)
  {
    try {
      if ($this->validate($this->rules->createNews)) {
        $query = $this->model->updateData($id, getRequest());
        return $this->respondUpdated($query);
      }
      return $this->respond([
        'success' => false,
        'error' => 'badRequest',
        'messages' => $this->validator->getErrors()
      ]);
    }
    catch (Exception $e) {
      return $this->respond(['success' => false, 'messages' => $e->getMessage()]);
    }
  }

  /**
   * Delete single data news
   */
  function delete($id = null)
  {
    try {
      $query = $this->model->deleteData($id);
      return $this->respondDeleted($query);
    }
    catch (Exception $e) {
      return $this->respond(['success' => false, 'messages' => $e->getMessage()]);
    }
  }
}