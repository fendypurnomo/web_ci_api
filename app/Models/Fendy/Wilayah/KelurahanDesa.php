<?php

namespace App\Models\Fendy\Wilayah;

class KelurahanDesa extends \CodeIgniter\Model
{
  protected $table = 'tabel_wilayah_kelurahan';
  protected $primaryKey = 'wilayah_kelurahan_id';
  protected $returnType = 'object';
  protected $allowedFields = ['wilayah_kelurahan_nama'];

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
      'wilayah_kecamatan_id' => $post->kode_kecamatan,
      'wilayah_kelurahan_id' => $post->kode_kel_desa,
      'wilayah_kelurahan_nama' => $post->nama_kel_desa,
      'wilayah_jenis_id' => $post->kode_jenis
    ];

    if ($this->insert($data)) {
      return [
        'success' => true,
        'status' => 200,
        'messages' => 'Data Wilayah Kelurahan/Desa berhasil disimpan'
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
      'wilayah_kelurahan_nama' => $put->nama_kel_desa,
      'wilayah_jenis_id' => $put->kode_jenis
    ];

    if ($this->update($id, $data)) {
      return [
        'success' => true,
        'status' => 200,
        'messages' => 'Data Wilayah Kelurahan/Desa berhasil diperbarui'
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
        'messages' => 'Data Wilayah Kelurahan/Desa berhasil dihapus'
      ];
    }
    return false;
  }

  private function data($row)
  {
    return [
      'kode_kecamatan' => $row->wilayah_kecamatan_id,
      'kode_kel_desa' => $row->wilayah_kelurahan_id,
      'nama_kel_desa' => $row->wilayah_kelurahan_nama
    ];
  }
}