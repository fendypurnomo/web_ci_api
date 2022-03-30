<?php

namespace App\Controllers\Fendy\Admin\Blog;

use Exception;

class Comment extends \App\Controllers\Fendy\BaseAdminController
{
  protected $modelName = 'App\Models\Fendy\Blog\Comment';
  protected $rules;

  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Get all data comments
   */
  public function index()
  {
    try {
      $query = $this->model->getAllData(getRequestQueryParamPagination());
      return $this->respond($query);
    }
    catch (Exception $e) {
      return $this->respond(['success' => false, 'messages' => $e->getMessage()]);
    }
  }

  /**
   * Create data comment
   */
  public function create()
  {
    try {
      if ($this->validate($this->rules->createComment)) {
        $query = $this->model->createData(getRequest());
        return $this->respondCreated($query);
      }
      return $this->respond([
        'sucess' => false,
        'error' => 'badRequest',
        'messages' => $this->validator->getErrors()
      ]);
    }
    catch (Exception $e) {
      return $this->respond(['success' => false, 'messages' => $e->getMessage()]);
    }
  }

  /**
   * Get single data comment
   */
  public function show($id = null)
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
   * Get single data comment
   */
  public function edit($id = null)
  {
    return $this->show($id);
  }

  /**
   * Update data comment
   */
  public function update($id = null)
  {
    try {
      if ($this->validate($this->rules->createComment)) {
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
   * Delete single data comment
   */
  public function delete($id = null)
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