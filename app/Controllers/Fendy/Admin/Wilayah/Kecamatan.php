<?php

namespace App\Controllers\Fendy\Admin\Wilayah;

use Exception;

class Kecamatan extends \App\Controllers\Fendy\BaseAdminController
{
  protected $modelName = 'App\Models\Fendy\Wilayah\Kecamatan';
  protected $rules;

  public function __construct()
  {
    parent::__construct();
    $this->rules = new \App\Validation\Admin\Wilayah\Kecamatan;
  }

  /**
   * Get all data kecamatan
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
   * Create single data kecamatan
   */
  public function create()
  {
    if ($this->validate($this->rules->tambahKecamatan)) {
      if ($add = $this->model->createData(getRequest())) {
        return $this->respondCreated($add);
      }
      return $this->fail($this->requestCantProcessed);
    }
    return $this->respond([
      'success' => false,
      'messages' => $this->validator->getErrors()
    ]);
  }

  /**
   * Get single data kecamatan
   */
  public function show($id = null)
  {
    if ($get = $this->model->showData($id)) {
      return $this->respond($get);
    }
    return $this->failNotFound('Data Wilayah Kecamatan tidak dapat ditemukan!');
  }

  /**
   * Get single data kecamatan
   */
  public function edit($id = null)
  {
    return $this->show($id);
  }

  /**
   * Update single data kecamatan
   */
  public function update($id = null)
  {
    if ($this->validate($this->rules->tambahKecamatan)) {
      if ($put = $this->model->updateData($id, getRequest())) {
        return $this->respondUpdated($put);
      }
      return $this->fail($this->requestCantProcessed);
    }
    return $this->respond([
      'success' => false,
      'messages' => $this->validator->getErrors()
    ]);
  }

  /**
   * Delete single data kecamatan
   */
  public function delete($id = null)
  {
    if ($del = $this->model->deleteData($id)) {
      return $this->respondDeleted($del);
    }
    return $this->failNotFound('Data Wilayah Kecamatan tidak dapat ditemukan!');
  }
}