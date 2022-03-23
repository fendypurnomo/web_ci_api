<?php

namespace App\Models\Fendy\Berita;

class Tags extends \CodeIgniter\Model
{
  protected $table      = 'tabel_tag';
  protected $primaryKey = 'tag_id';
  protected $returnType = 'object';

  protected $allowedFields = [
    'tag_nama',
    'tag_seo',
    'tag_hitung'
  ];

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
      'tag_nama' => $post->name,
      'tag_seo'  => $post->seo
    ];

    if ($this->insert($data)) {
      return [
        'success' => true,
        'status'  => 201,
        'message' => 'Data tag berhasil disimpan'
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
      'tag_nama' => $put->name,
      'tag_seo'  => $put->seo
    ];

    if ($this->update($id, $data)) {
      return [
        'success' => true,
        'status'  => 200,
        'message' => 'Data pesan berhasil diperbarui'
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
        'message' => 'Data tag berhasil dihapus'
      ];
    }
    return false;
  }

  private function data($row)
  {
    return [
      'id'    => $row->tag_id,
      'name'  => $row->tag_nama,
      'seo'   => $row->tag_seo,
      'count' => $row->tag_hitung
    ];
  }
}
