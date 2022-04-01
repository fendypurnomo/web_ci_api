<?php

namespace App\Controllers\Fendy\Admin\Wilayah;

use Exception;

class KabupatenKota extends \App\Controllers\Fendy\BaseAdminController
{
    protected $modelName = 'App\Models\Fendy\Wilayah\KabupatenKota';
    protected $rules;

    public function __construct()
    {
        parent::__construct();
        $this->rules = new \App\Validation\Admin\Wilayah\KabupatenKota;
    }

    /**
     * Get all data kabupaten kota
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
     * Create single data kabupaten kota
     */
    public function create()
    {
        if ($this->validate($this->rules->tambahKabupatenKota)) {
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
     * Get single data kabupaten kota
     */
    public function show($id = null)
    {
        if ($get = $this->model->showData($id)) {
            return $this->respond($get);
        }
        return $this->failNotFound('Data Wilayah Kabupaten/Kota tidak dapat ditemukan!');
    }

    /**
     * Get single data kabupaten kota
     */
    public function edit($id = null)
    {
        return $this->show($id);
    }

    /**
     * Update single data kabupaten kota
     */
    public function update($id = null)
    {
        if ($this->validate($this->rules->tambahKabupatenKota)) {
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
     * Delete single data kabupaten kota
     */
    public function delete($id = null)
    {
        if ($del = $this->model->deleteData($id)) {
            return $this->respondDeleted($del);
        }
        return $this->failNotFound('Data Wilayah Kabupaten/Kota tidak dapat ditemukan!');
    }
}
