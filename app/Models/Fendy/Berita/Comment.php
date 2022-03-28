<?php

namespace App\Models\Fendy\Berita;

use Exception;

class Comment extends \CodeIgniter\Model
{
  protected $DBGroup = 'blog';
  protected $table = 'komentar';
  protected $primaryKey = 'id_komentar';
  protected $returnType = 'object';
  protected $allowedFields = ['nama_komentar', 'url', 'isi_komentar', 'tgl', 'jam_komentar'];
  protected $useTimestamps = false;
  protected $createdField = 'tgl';

  public function getAllData(object $paging = null)
  {
    if ($query = $this->sql()->paginate($paging->perPage, '', $paging->page)) {
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
      'nama_komentar' => $post->name,
      'url' => $post->url,
      'isi_komentar' => $post->content
    ];

    if ($this->insert($data)) {
      return [
        'success' => true,
        'status' => 201,
        'message' => 'Data komentar berhasil disimpan'
      ];
    }
    return false;
  }

  public function showData($id)
  {
    if ($row = $this->sql()->find($id)) {
      return ['data' => $this->data($row)];
    }
    return false;
  }

  public function updateData($id, $put)
  {
    $data = [
      'nama_komentar' => $put->name,
      'url' => $put->url,
      'isi_komentar' => $put->content
    ];

    if ($this->update($id, $data)) {
      return [
        'success' => true,
        'status' => 200,
        'message' => 'Data komentar berhasil diperbarui'
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
        'messages' => 'Data komentar berhasil dihapus'
      ];
    }
    return false;
  }

  private function data($row)
  {
    return [
      'id' => $row->id_komentar,
      'name' => $row->nama_komentar,
      'url' => $row->url,
      'content' => $row->isi_komentar,
      'date' => $row->tgl,
      'news' => $this->baseURL() . $row->judul_seo
    ];
  }

  private function sql()
  {
    $this->join('berita', 'komentar.id_berita = berita.id_berita', 'left');
    return $this;
  }

  private function baseURL()
  {
    return getenv('app.baseURL') . 'fendy/news/';
  }
}