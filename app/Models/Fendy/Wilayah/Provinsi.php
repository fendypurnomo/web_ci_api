<?php

namespace App\Models\Fendy\Wilayah;

class Provinsi extends \CodeIgniter\Model
{
  protected $table      = 'wilayah_provinsi';
  protected $primaryKey = 'wilayah_provinsi_id';
  protected $returnType = 'object';

  protected $allowedFields = ['wilayah_provinsi_nama'];

  public function getAllData($paging = null)
  {
    if ($query = $this->paginate($paging->perPage, '', $paging->page)) {
      foreach ($query as $row) {
        $data[] = $this->data($row);
      }

      $page         = $paging->page;
      $perPage      = $paging->perPage;
      $totalRecords = $this->countAll();
      $totalPages   = ceil($totalRecords / $perPage);

      return [
        'data'         => $data,
        'page'         => $page,
        'perPage'      => $perPage,
        'totalPages'   => $totalPages,
        'totalRecords' => $totalRecords
      ];
    }
    return false;
  }

  public function createData($post)
  {
    $data = [
      'wilayah_provinsi_id'   => $post->kode_provinsi,
      'wilayah_provinsi_nama' => $post->nama_provinsi
    ];

    if ($this->insert($data)) {
      return [
        'success' => true,
        'status'  => 200,
        'message' => 'Data Wilayah Provinsi berhasil disimpan'
      ];
    }
    return false;
  }

  public function showData($id)
  {
    if ($row = $this->find($id)) {
      return [
        'data' => $this->data($row)
      ];
    }
    return false;
  }

  public function updateData($id, $put)
  {
    $data = [
      'wilayah_provinsi_nama' => $put->nama_provinsi
    ];

    if ($this->update($id, $data)) {
      return [
        'success' => true,
        'status'  => 200,
        'message' => 'Data Wilayah Provinsi berhasil diperbarui'
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
        'status'  => 200,
        'message' => 'Data Wilayah Provinsi berhasil dihapus'
      ];
    }
    return false;
  }

  private function data($row)
  {
    return [
      'kode_provinsi' => $row->wilayah_provinsi_id,
      'nama_provinsi' => $row->wilayah_provinsi_nama
    ];
  }
}
