<?php

namespace App\Models\Fendy\Wilayah;

class KabupatenKota extends \CodeIgniter\Model
{
  protected $table      = 'wilayah_kabupaten';
  protected $primaryKey = 'wilayah_kabupaten_id';
  protected $returnType = 'object';

  protected $allowedFields = ['wilayah_kabupaten_nama'];

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
      'wilayah_provinsi_id'    => $post->kode_provinsi,
      'wilayah_kabupaten_id'   => $post->kode_kab_kota,
      'wilayah_kabupaten_nama' => $post->nama_kab_kota,
      'wilayah_jenis_id'       => $post->kode_jenis
    ];

    if ($this->insert($data)) {
      return [
        'success' => true,
        'status'  => 200,
        'message' => 'Data Wilayah Kabupaten/Kota berhasil disimpan'
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
      'wilayah_kabupaten_nama' => $put->nama_kab_kota,
      'wilayah_jenis_id'       => $put->kode_jenis
    ];

    if ($this->update($id, $data)) {
      return [
        'success' => true,
        'status'  => 200,
        'message' => 'Data Wilayah Kabupaten/Kota berhasil diperbarui'
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
        'message' => 'Data Wilayah Kabupaten/Kota berhasil dihapus'
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
