<?php

namespace App\Models\Fendy\Blog;

class News extends \CodeIgniter\Model
{
  protected $table = 'tabel_berita AS a';
  protected $primaryKey = 'berita_id';
  protected $returnType = 'object';

  protected $allowedFields = [
    'kategori_id',
    'pengguna_id',
    'berita_judul',
    'berita_seo',
    'berita_isi',
    'berita_tanggal',
    'berita_gambar',
    'berita_headline',
    'berita_tag'
  ];

  protected $useTimestamps = true;
  protected $createdField = 'berita_tanggal';
  protected $updatedField = 'berita_tanggal';

  public function getAllData(object $paging = null)
  {
    $query = $this->queryGetData()->orderBy('a.berita_tanggal', 'DESC')->paginate($paging->perPage, '', $paging->page);

    if (! $query) {
      throw new \RuntimeException('Permintaan data gagal diproses!');
    }

    $page = $paging->page;
    $perPage = $paging->perPage;
    $totalRecords = $this->countAll();
    $totalPages = ceil($totalRecords / $perPage);

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

  public function getDataByCategory($category, $paging)
  {
    $query = $this->queryGetData()->where('b.kategori_seo', $category)->findAll($paging->perPage, $paging->page);

    if (! $query) {
      throw new \RuntimeException('Permintaan data gagal diproses!');
    }

    $page = $paging->page;
    $perPage = $paging->perPage;
    $totalRecords = $this->countAllResults();
    $totalPages = ceil($totalRecords / $perPage);

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

  public function createData($post, $img)
  {
    if ($img->isValid() && ! $img->hasMoved()) {
      $newName = $img->getRandomName();
      $filepath = '../../../../../../../Pictures/Images/news/';
      $img->move($filepath, $newName);

      helper('stringreplace');

      $tag = implode(',', (array) [$post->tag]);

      $data = [
        'kategori_id' => $post->category,
        'pengguna_id' => $post->user,
        'berita_judul' => $post->title,
        'berita_seo' => seoTitle($post->title),
        'berita_isi' => $post->content,
        'berita_tanggal' => date('Y-m-d H:i:s'),
        'berita_gambar' => $newName,
        'berita_headline' => $post->headline,
        'berita_tag' => $tag
      ];

      $query = $this->insert($data);

      if (! $query) {
        throw new \RuntimeException('Data gagal disimpan');
      }

      return [
        'success' => true,
        'status' => 201,
        'message' => 'Data berita berhasil disimpan'
      ];
    }
    throw new \RuntimeException($img->getErrorString() . '(' . $img->getError() . ')');
  }

  public function showData($id)
  {
    $query = $this->sql()->find($id);

    if (! $query) {
      throw new \RuntimeException('Permintaan data gagal diproses!');
    }

    return [
      'success' => true,
      'response' =>[
        'data' => $this->data($query)
      ]
    ];
  }

  public function updateData($id, $put)
  {
    helper('seo');

    $data = [
      'kategori_id' => $put->category,
      'pengguna_id' => $put->user,
      'berita_judul' => $put->title,
      'berita_seo' => seoTitle($put->title),
      'berita_isi' => $put->content,
      'berita_tanggal' => $put->date,
      'berita_gambar' => $put->img,
      'berita_headline' => $put->headline,
      'berita_tag' => $put->tag
    ];

    $query = $this->update($id, $data);

    if (! $query) {
      throw new \RuntimeException('Data gagal disimpan');
    }

    return [
      'success' => true,
      'status' => 200,
      'message' => 'Data berita berhasil diperbarui'
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
      'messages' => 'Data berita berhasil dihapus'
    ];
  }

  private function data($row)
  {
    return [
      'news_id' => $row->berita_id,
      'news_category_id' => $row->kategori_id,
      'news_title' => $row->berita_judul,
      'news_seo' => $row->berita_seo,
      'news_img' => $this->imgUrl() . $row->berita_gambar,
      'news_tag' => $row->berita_tag,
      'news_date' => $row->berita_tanggal,
      'news_read' => $row->berita_dibaca,
      'news_editor' => $row->editor,
      'category_name' => $row->kategori_nama,
      'news_content' => $row->berita_isi
    ];
  }

  private function queryGetData()
  {
    $this->select('a.berita_id, a.kategori_id, a.berita_judul, a.berita_seo, a.berita_isi, a.berita_tanggal, a.berita_gambar, a.berita_tag, a.berita_headline, a.berita_dibaca');
    $this->select('b.kategori_nama');
    $this->select('CONCAT_WS(\' \', c.pengguna_nama_depan, c.pengguna_nama_belakang ) AS editor');
    $this->join('ref_kategori AS b', 'a.kategori_id = b.kategori_id', 'left');
    $this->join('tabel_pengguna AS c', 'a.pengguna_id = c.pengguna_id', 'left');
    return $this;
  }

  private function imgURL()
  {
    return getenv('app.imgUrl') . 'news/';
  }
}