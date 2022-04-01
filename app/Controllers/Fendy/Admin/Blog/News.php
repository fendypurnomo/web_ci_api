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

    /*
    |--------------------------------------------------
    | Get news data
    |--------------------------------------------------
    */
    public function index()
    {
        try {
            $param = $this->request->getGet();
            $query = $this->model->getAllData($param, getRequestQueryParamPagination());
            return $this->respond($query);
        }
        catch (Exception $e) {
            return $this->respond(['success' => false, 'messages' => $e->getMessage()]);
        }
    }

    /*
    |--------------------------------------------------
    | Create news data
    |--------------------------------------------------
    */
    public function create()
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

    /*
    |--------------------------------------------------
    | Get single news data
    |--------------------------------------------------
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

    /*
    |--------------------------------------------------
    | Get single news data
    |--------------------------------------------------
    */
    public function edit($id = null)
    {
        return $this->show($id);
    }

    /*
    |--------------------------------------------------
    | Update news data
    |--------------------------------------------------
    */
    public function update($id = null)
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

    /*
    |--------------------------------------------------
    | Delete news data
    |--------------------------------------------------
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
