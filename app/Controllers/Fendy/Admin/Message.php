<?php

namespace App\Controllers\Fendy\Admin;

use Exception;

class Message extends \App\Controllers\Fendy\BaseAdminController
{
    protected $modelName = 'App\Models\Fendy\Message';
    protected $rules;

    public function __construct()
    {
        parent::__construct();
        $this->rules = new \App\Validation\Admin\Message;
    }

    // Get all messages
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

    // Create single message
    public function create()
    {
        if ($this->validate($this->rules->createMessage)) {
            if ($add = $this->model->createData(getRequest())) {
                return $this->respondCreated($add);
            }
            return $this->fail($this->requestCantProcessed);
        }
        return $this->respond([
            'success' => false,
            'error' => 'badRequest',
            'messages' => $this->validator->getErrors()
        ]);
    }

    // Get single message
    public function show($id = null)
    {
        if ($get = $this->model->showData($id)) {
            return $this->respond($get);
        }
        return $this->respond($this->tableRecordNotFound);
    }

    // Get single message
    public function edit($id = null)
    {
        return $this->show($id);
    }

    // Update single message
    public function update($id = null)
    {
        if ($this->validate($this->rules->createMessage)) {
            if ($put = $this->model->updateData($id, getRequest())) {
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

    // Delete single message
    public function delete($id = null)
    {
        if ($del = $this->model->deleteData($id)) {
            return $this->respondDeleted($del);
        }
        return $this->respond($this->tableRecordNotFound);
    }
}
