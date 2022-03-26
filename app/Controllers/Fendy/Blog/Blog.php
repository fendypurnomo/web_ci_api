<?php

namespace App\Controllers\Fendy\Blog;

class Blog extends \CodeIgniter\RESTful\ResourceController
{
  // Get all data categories
  function categories()
  {
    $model = new \App\Models\Fendy\Berita\Categories();
    if ($get = $model->getAllData(getQueryParamPagination())) {
      return $this->respond($get);
    }
    return $this->respond($this->tableRecordEmpty);
  }

  // Get all data tags
  function tags()
  {
    $model = new \App\Models\Fendy\Berita\Tags();
    if ($get = $model->getAllData(getQueryParamPagination())) {
      return $this->respond($get);
    }
    return $this->respond($this->tableRecordEmpty);
  }

  // Get all data news
  function news()
  {
    $model = new \App\Models\Fendy\Berita\News();
    if ($get = $model->getAllData(getQueryParamPagination())) {
      return $this->respond($get);
    }
    return $this->respond($this->tableRecordEmpty);
  }

  // Get all data wilayah provinsi
  function provinsi()
  {
    $model = new \App\Models\Fendy\Wilayah\Provinsi();
    if ($get = $model->getAllData(getQueryParamPagination())) {
      return $this->respond($get);
    }
    return $this->respond($this->tableRecordEmpty);
  }

  // Get all data wilayah kabupaten kota
  function kabupatenKota()
  {
    $model = new \App\Models\Fendy\Wilayah\KabupatenKota();
    if ($get = $model->getAllData(getQueryParamPagination())) {
      return $this->respond($get);
    }
    return $this->respond($this->tableRecordEmpty);
  }

  // Get all data wilayah kecamatan
  function kecamatan()
  {
    $model = new \App\Models\Fendy\Wilayah\Kecamatan();
    if ($get = $model->getAllData(getQueryParamPagination())) {
      return $this->respond($get);
    }
    return $this->respond($this->tableRecordEmpty);
  }

  // Get all data wilayah kelurahan desa
  function kelurahanDesa()
  {
    $model = new \App\Models\Fendy\Wilayah\KelurahanDesa();
    if ($get = $model->getAllData(getQueryParamPagination())) {
      return $this->respond($get);
    }
    return $this->respond($this->tableRecordEmpty);
  }
}