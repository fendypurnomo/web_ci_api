<?php

namespace App\Models\Fendy\Wilayah;

use Exception;

class KabupatenKota extends \CodeIgniter\Model
{
  protected $table = 'tabel_wilayah_kabupaten';
  protected $primaryKey = 'wilayah_kabupaten_id';
  protected $returnType = 'object';
  protected $allowedFields = ['wilayah_kabupaten_nama'];

  public function getAllData($paging = null)
  {
    if ($query = $this->paginate($paging->perPage, '', $paging->page)) {
      $totalRecords = $this->countAll();
      $totalPages = ceil($totalRecords / $paging->perPage);

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
      'wilayah_kabupaten_id' => $post->kode_kab_kota,
      'wilayah_kabupaten_nama' => $post->nama_kab_kota,
      'wilayah_jenis_id' => $post->kode_jenis
    ];

    if ($this->insert($data)) {
      return [
        'success' => true,
        'status' => 200,
        'messages' => 'Data Wilayah Kabupaten/Kota berhasil disimpan'
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
      'wilayah_kabupaten_nama' => $put->nama_kab_kota,
      'wilayah_jenis_id' => $put->kode_jenis
    ];

    if ($this->update($id, $data)) {
      return [
        'success' => true,
        'status' => 200,
        'messages' => 'Data Wilayah Kabupaten/Kota berhasil diperbarui'
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
        'messages' => 'Data Wilayah Kabupaten/Kota berhasil dihapus'
      ];
    }
    return false;
  }

  private function data($row)
  {
    return [
      'kode_provinsi' => $row->wilayah_provinsi_id,
      'kode_kab_kota' => $row->wilayah_kabupaten_id,
      'nama_kab_kota' => $row->wilayah_kabupaten_nama
    ];
  }
}