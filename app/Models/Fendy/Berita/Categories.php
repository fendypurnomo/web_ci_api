<?php

namespace App\Models\Fendy\Berita;

use Exception;

class Categories extends \CodeIgniter\Model
{
  protected $table = 'ref_kategori';
  protected $primaryKey = 'kategori_id';
  protected $returnType = 'object';
  protected $allowedFields = ['kategori_nama', 'kategori_seo', 'kategori_aktif'];

  public function getAllData(object $paging = null)
  {
    if ($query = $this->paginate($paging->perPage, '', $paging->page)) {
      $totalRecords = (int) $this->countAll();
      $totalPages = (int) ceil($totalRecords / $paging->perPage);

      if ($paging->page > $totalPages) {
        throw new Exception('Data halaman yang Anda masukkan melebihi jumlah total halaman!');
      }

      foreach ($query as $row) {
        $data[] = $this->data($row);
      }

      return [
        'success' => true,
        'response' => [
          'data' => $data,
          'page' => (int) $paging->page,
          'perPage' => (int) $paging->perPage,
          'totalPages' => $totalPages,
          'totalRecords' => $totalRecords
        ]
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