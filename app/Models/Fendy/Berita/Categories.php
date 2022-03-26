<?php

namespace App\Models\Fendy\Berita;

class Categories extends \CodeIgniter\Model
{
  protected $table = 'ref_kategori';
  protected $primaryKey = 'kategori_id';
  protected $returnType = 'object';
  protected $allowedFields = ['kategori_nama', 'kategori_seo', 'kategori_aktif'];

  public function getAllData($paging = null)
  {
    if ($query = $this->paginate($paging->perPage, '', $paging->page)) {
      foreach ($query as $row) { $data[] = $this->data($row); }

      $page = $paging->page;
      $perPage = $paging->perPage;
      $totalRecords = $this->countAll();
      $totalPages = ceil($totalRecords / $perPage);

      return [
        'data' => $data,
        'page' => $page,
        'perPage' => $perPage,
        'totalPages' => $totalPages,
        'totalRecords' => $totalRecords
      ];
    }
    return false;
  }

  public function createData($post)
  {
    $data = [
      'kategori_nama' => $post->name,
      'kategori_seo' => $post->seo,
      'kategori_aktive' => $post->active
    ];

    if ($this->insert($data)) {
      return [
        'success' => true,
        'status' => 201,
        'message' => 'Data kategori berhasil disimpan'
      ];
    }
    return false;
  }

  public function showData($id)
  {
    if ($row = $this->find($id)) {
      return ['data' => $this->data($row)];
    }
    return false;
  }

  public function updateData($id, $put)
  {
    $data = [
      'kategori_nama' => $put->name,
      'kategori_seo' => $put->seo,
      'kategori_aktive' => $put->active
    ];

    if ($this->update($id, $data)) {
      return [
        'success' => true,
        'status' => 200,
        'messages' => 'Data kategori berhasil diperbarui'
      ];
    }
    return false;
  }

  public function deleteData($id)
  {
    if ($this->find($id)) {
      $this->delete($id);
      return [
        'success' => true,
        'status' => 200,
        'messages' => 'Data kategori berhasil dihapus'
      ];
    }
    return false;
  }

  private function data($row)
  {
    return [
      'id' => $row->kategori_id,
      'name' => $row->kategori_nama,
      'seo' => $row->kategori_seo,
      'active' => $row->kategori_aktif
    ];
  }
}