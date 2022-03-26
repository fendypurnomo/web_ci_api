<?php

namespace App\Controllers\Fendy\Admin\Wilayah;

class Provinsi extends \App\Controllers\Fendy\BaseAdminController
{
  protected $modelName = 'App\Models\Fendy\Wilayah\Provinsi';
  protected $rules;

  public function __construct()
  {
    parent::__construct();
    $this->rules = new \App\Validation\Admin\Wilayah;
  }

  /**
   * Get all data provinsi
   */
  public function index()
  {
    if ($get = $this->model->getAllData(getQueryParamPagination())) {
      return $this->respond($get);
    }
    return $this->failNotFound('Tidak ada data Wilayah Provinsi!');
  }

  /**
   * Create single data provinsi
   */
  public function create()
  {
    if ($this->validate($this->rules->provinsi)) {
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
   * Get single data provinsi
   */
  public function show($id = null)
  {
    if ($get = $this->model->showData($id)) {
      return $this->respond($get);
    }
    return $this->failNotFound('Data Wilayah Provinsi tidak dapat ditemukan!');
  }

  /**
   * Get single data provinsi
   */
  public function edit($id = null)
  {
    return $this->show($id);
  }

  /**
   * Update single data provinsi
   */
  public function update($id = null)
  {
    if ($this->validate($this->rules->provinsi)) {
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
   * Delete single data provinsi
   */
  public function delete($id = null)
  {
    if ($del = $this->model->deleteData($id)) {
      return $this->respondDeleted($del);
    }
    return $this->failNotFound('Data Wilayah Provinsi tidak dapat ditemukan!');
  }
}