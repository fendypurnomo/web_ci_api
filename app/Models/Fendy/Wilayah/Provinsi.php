<?php

namespace App\Models\Fendy\Wilayah;

use Exception;

class Provinsi extends \CodeIgniter\Model
{
  protected $table = 'tabel_wilayah_provinsi';
  protected $primaryKey = 'wilayah_provinsi_id';
  protected $returnType = 'object';
  protected $allowedFields = ['wilayah_provinsi_nama'];

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
      'wilayah_provinsi_id' => $post->kode_provinsi,
      'wilayah_provinsi_nama' => $post->nama_provinsi
    ];

    if ($this->insert($data)) {
      return [
        'success' => true,
        'status' => 200,
        'messages' => 'Data Wilayah Provinsi berhasil disimpan'
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
    $data = ['wilayah_provinsi_nama' => $put->nama_provinsi];

    if ($this->update($id, $data)) {
      return [
        'success' => true,
        'status' => 200,
        'messages' => 'Data Wilayah Provinsi berhasil diperbarui'
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
        'messages' => 'Data Wilayah Provinsi berhasil dihapus'
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