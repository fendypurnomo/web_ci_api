<?php

namespace App\Models\Fendy\Blog;

class News extends \CodeIgniter\Model
{
  protected $table = 'tabel_berita';
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
    if ($query = $this->sql()->orderBy('berita_tanggal', 'DESC')->paginate($paging->perPage, '', $paging->page)) {
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

      if ($this->insert($data)) {
        return [
          'success' => true,
          'status' => 201,
          'message' => 'Data berita berhasil disimpan'
        ];
      }
      return false;
    }
    throw new \RuntimeException($img->getErrorString() . '(' . $img->getError() . ')');
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

    if ($this->update($id, $data)) {
      return [
        'success' => true,
        'status' => 200,
        'message' => 'Data berita berhasil diperbarui'
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
        'messages' => 'Data berita berhasil dihapus'
      ];
    }
    return false;
  }

  private function data($row)
  {
    return [
      'news_id' => $row->berita_id,
      'news_title' => $row->berita_judul,
      'news_seo' => $row->berita_seo,
      'news_img' => $this->imgUrl() . $row->berita_gambar,
      'news_tag' => $row->berita_tag,
      'news_date' => $row->berita_tanggal,
      'news_editor' => $row->pengguna_nama_depan . ' ' . $row->pengguna_nama_belakang,
      'news_category' => $row->kategori_nama,
      'news_content' => $row->berita_isi
    ];
  }

  private function sql()
  {
    $this->join('ref_kategori', 'tabel_berita.kategori_id = ref_kategori.kategori_id', 'left');
    $this->join('tabel_pengguna', 'tabel_berita.pengguna_id = tabel_pengguna.pengguna_id', 'left');
    return $this;
  }

  private function imgURL()
  {
    return getenv('app.imgUrl') . 'news/';
  }
}