<?php

namespace App\Models\Fendy\Blog;

class Tag extends \CodeIgniter\Model
{
  protected $table = 'tabel_tag';
  protected $primaryKey = 'tag_id';
  protected $returnType = 'object';
  protected $allowedFields = ['tag_nama', 'tag_seo', 'tag_hitung'];

  public function getAllData(object $paging = null)
  {
    if ($query = $this->paginate($paging->perPage, '', $paging->page)) {
      $page = $paging->page;
      $perPage = $paging->perPage;
      $totalRecords = (int) $this->countAll();
      $totalPages = (int) ceil($totalRecords / $perPage);

      if ($paging->page > $totalPages) throw new \RuntimeException('Data halaman yang Anda masukkan melebihi jumlah total halaman!');

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
      'tag_nama' => $post->name,
      'tag_seo' => $post->seo
    ];

    if ($this->insert($data)) {
      return [
        'success' => true,
        'status' => 201,
        'messages' => 'Data tag berhasil disimpan'
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
      'tag_nama' => $put->name,
      'tag_seo' => $put->seo
    ];

    if ($this->update($id, $data)) {
      return [
        'success' => true,
        'status' => 200,
        'messages' => 'Data pesan berhasil diperbarui'
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
        'messages' => 'Data tag berhasil dihapus'
      ];
    }
    return false;
  }

  private function data($row)
  {
    return [
      'tag_id' => $row->tag_id,
      'tag_name' => $row->tag_nama,
      'tag_seo' => $row->tag_seo,
      'tag_count' => $row->tag_hitung
    ];
  }
}