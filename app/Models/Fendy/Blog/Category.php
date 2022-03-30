<?php

namespace App\Models\Fendy\Blog;

class Category extends \CodeIgniter\Model
{
  protected $table = 'ref_kategori';
  protected $primaryKey = 'kategori_id';
  protected $returnType = 'object';
  protected $allowedFields = ['kategori_nama', 'kategori_seo', 'kategori_aktif'];

  public function getAllData(object $paging = null)
  {
    $query = $this->paginate($paging->perPage, '', $paging->page);

    if (! $query) {
      throw new \RuntimeException('Permintaan data gagal diproses!');
    }

    $page = $paging->page;
    $perPage = $paging->perPage;
    $totalRecords = (int) $this->countAll();
    $totalPages = (int) ceil($totalRecords / $perPage);

    if ($page > $totalPages) {
      throw new \RuntimeException('Data halaman yang Anda masukkan melebihi jumlah total halaman!');
    }

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

  public function createData($post)
  {
    $data = [
      'kategori_nama' => $post->name,
      'kategori_seo' => $post->seo,
      'kategori_aktive' => $post->active
    ];

    $query = $this->insert($data);

    if (! $query) {
      throw new \RuntimeException('Data gagal disimpan!');
    }

    return [
      'success' => true,
      'status' => 201,
      'message' => 'Data kategori berhasil disimpan'
    ];
  }

  public function showData($id)
  {
    $query = $this->find($id);

    if (! $query) {
      throw new \RuntimeException('Permintaan data gagal diproses!');
    }

    return [
      'success' => true,
      'response' => [
        'data' => $this->data($query)
      ]
    ];
  }

  public function updateData($id, $put)
  {
    $data = [
      'kategori_nama' => $put->name,
      'kategori_seo' => $put->seo,
      'kategori_aktive' => $put->active
    ];

    $query = $this->update($id, $data);

    if (! $query) {
      throw new \RuntimeException('Data gagal disimpan!');
    }

    return [
      'success' => true,
      'status' => 200,
      'messages' => 'Data kategori berhasil diperbarui'
    ];
  }

  public function deleteData($id)
  {
    $query = $this->delete($id);

    if (! $query) {
      throw new \RuntimeException('Data gagal dihapus!');
    }

    return [
      'success' => true,
      'status' => 200,
      'messages' => 'Data kategori berhasil dihapus'
    ];
  }

  private function data($row)
  {
    return [
      'category_id' => $row->kategori_id,
      'category_name' => $row->kategori_nama,
      'category_seo' => $row->kategori_seo
    ];
  }
}