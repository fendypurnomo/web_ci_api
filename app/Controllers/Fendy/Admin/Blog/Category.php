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
      $query = $this->model->getAllData(getRequestQueryParamPagination());
      return $this->respond($query);
    }
    catch (Exception $e) {
      return $this->respond(['success' => false, 'messages' => $e->getMessage()]);
    }
  }

  /**
   * Create single data category
   */
  public function create()
  {
    try {
      if ($this->validate($this->rules->createCategory)) {
        $query = $this->model->createData(getRequest());
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
   * Get single data category
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
    try {
      if ($this->validate($this->rules->createCategory)) {
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
   * Delete single data category
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