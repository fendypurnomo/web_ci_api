<?php

namespace App\Models\Fendy\Wilayah;

class Kecamatan extends \CodeIgniter\Model
{
  protected $table = 'tabel_wilayah_kecamatan';
  protected $primaryKey = 'wilayah_kecamatan_id';
  protected $returnType = 'object';
  protected $allowedFields = ['wilayah_kecamatan_nama'];

  public function getAllData(object $paging = null)
  {
    if ($query = $this->paginate($paging->perPage, '', $paging->page)) {
      $page = $paging->page;
      $perPage = $paging->perPage;
      $totalRecords = (int) $this->countAll();
      $totalPages = (int) ceil($totalRecords / $perPage);

      if ($page > $totalPages) throw new \RuntimeException('Data halaman yang Anda masukkan melebihi jumlah total halaman!');

      foreach ($query as $row) {
        $data[] = $this->data($row);
      }

      return [
        'success' => true,
        'response' => [
          'data' => $data,
          'page' => $page,
          'perPage' => $perPage,
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
      'wilayah_kabupaten_id' => $post->kode_kab_kota,
      'wilayah_kecamatan_id' => $post->kode_kecamatan,
      'wilayah_kecamatan_nama' => $post->nama_kecamatan
    ];

    if ($this->insert($data)) {
      return [
        'success' => true,
        'status' => 200,
        'messages' => 'Data Wilayah Kecamatan berhasil disimpan'
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
    $data = ['wilayah_kecamatan_nama' => $put->nama_kecamatan];

    if ($this->update($id, $data)) {
      return [
        'success' => true,
        'status' => 200,
        'messages' => 'Data Wilayah Kecamatan berhasil diperbarui'
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
        'messages' => 'Data kecamatan berhasil dihapus'
      ];
    }
    return false;
  }

  private function data($row)
  {
    return [
      'kode_kab_kota' => $row->wilayah_kabupaten_id,
      'kode_kecamatan' => $row->wilayah_kecamatan_id,
      'nama_kecamatan' => $row->wilayah_kecamatan_nama
    ];
  }
}