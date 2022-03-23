<?php

namespace App\Controllers\Fendy;

class Messages extends \App\Controllers\Fendy\BaseRestfulController
{
  protected $model;
  protected $rules;

  function __construct()
  {
    parent::__construct();

    $this->model = new \App\Models\Fendy\Messages;
    $this->rules = new \App\Validation\Messages;
  }

  // Get all messages
  function index()
  {
    if ($get = $this->model->getAllData(getQueryParamPagination())) {
      return $this->respond($get);
    }
    return $this->fail($this->tableRecordEmpty);
  }

  // Create single message
  function create()
  {
    if ($this->validate($this->rules->createMessage)) {
      if ($add = $this->model->createData(getRequest())) {
        return $this->respondCreated($add);
      }
      return $this->fail($this->requestCantProcessed);
    }
    return $this->fail([
      'error' => 'badRequest',
      'field' => $this->validator->getErrors()
    ]);
  }

  // Get single message
  function show($id = null)
  {
    if ($get = $this->model->showData($id)) {
      return $this->respond($get);
    }
    return $this->failNotFound($this->tableRecordNotFound);
  }

  // Get single message
  function edit($id = null)
  {
    return $this->show($id);
  }

  // Update single message
  function update($id = null)
  {
    if ($this->validate($this->rules->createMessage)) {
      if ($put = $this->model->updateData($id, getRequest())) {
        return $this->respondUpdated($put);
      }
      return $this->fail($this->requestCantProcessed);
    }
    return $this->fail([
      'error' => 'badRequest',
      'field' => $this->validator->getErrors()
    ]);
  }

  // Delete single message
  function delete($id = null)
  {
    if ($del = $this->model->deleteData($id)) {
      return $this->respondDeleted($del);
    }
    return $this->fail($this->tableRecordNotFound);
  }
}