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

  public function getAllData($param, object $paging)
  {
    $sql = $this->sql();

    if (isset($param['category']) && ! isset($param['headline'])) {
      $sql = $this->where('ref_kategori.kategori_seo', $param['category']);
    }
    elseif (! isset($param['category']) && isset($param['headline'])) {
      $sql = $this->where('tabel_berita.berita_headline', $param['headline']);
    }
    elseif ( isset($param['category']) && isset($param['headline'])) {
      $sql = $this->where('tabel_berita.berita_headline', $param['headline'])
                  ->where('ref_kategori.kategori_seo', $param['category']);
    }

    $sql = $this->orderBy('tabel_berita.berita_tanggal', 'DESC');
    $totalRecords = $this->countAllResults(false);

    $page = $paging->page;
    $perPage = $paging->perPage;
    $totalPages = ceil($totalRecords / $perPage);

    $query = $sql->paginate($perPage, '', $page);

    if (! $query) {
      throw new \RuntimeException('Permintaan data tidak dapat ditemukan!');
    }

    if ($page > $totalPages) {
      throw new \RuntimeException('Data halaman yang Anda masukkan melebihi jumlah total halaman!');
    }

    foreach ($query as $row) {
      $data[] = $this->dataRow($row);
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
    if (! $img->isValid() && $img->hasMoved()) {
      throw new \RuntimeException($img->getErrorString() . '(' . $img->getError() . ')');
    }

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
      'message' => 'Data berita berhasil disimpan'
    ];
  }

  public function showData($id)
  {
    $query = $this->sql()->find($id);

    if (! $query) {
      throw new \RuntimeException('Permintaan data tidak dapat ditemukan!');
    }

    return [
      'success' => true,
      'response' => ['data' => $this->dataRow($query)]
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
      'messages' => 'Data berita berhasil dihapus'
    ];
  }

  private function dataRow($row)
  {
    return [
      'news_id' => $row->berita_id,
      'news_category_id' => $row->kategori_id,
      'news_read' => $row->berita_dibaca,
      'news_date' => $row->berita_tanggal,
      'news_editor' => $row->editor,
      'category_name' => $row->kategori_nama,
      'news_tag' => $row->berita_tag,
      'news_title' => $row->berita_judul,
      'news_seo' => $row->berita_seo,
      'news_img' => getenv('app.imgUrl') . 'news/' . $row->berita_gambar,
      'news_content' => $row->berita_isi
    ];
  }

  private function sql()
  {
    $this->select('tabel_berita.berita_id,
                   tabel_berita.kategori_id,
                   tabel_berita.berita_judul,
                   tabel_berita.berita_seo,
                   LEFT(tabel_berita.berita_isi, 200) AS berita_isi,
                   tabel_berita.berita_tanggal,
                   tabel_berita.berita_gambar,
                   tabel_berita.berita_tag,
                   tabel_berita.berita_headline,
                   tabel_berita.berita_dibaca,
                   ref_kategori.kategori_nama,
                   ref_kategori.kategori_seo,
                   CONCAT_WS(\' \', tabel_pengguna.pengguna_nama_depan, tabel_pengguna.pengguna_nama_belakang) AS editor')
         ->join('ref_kategori', 'tabel_berita.kategori_id = ref_kategori.kategori_id', 'LEFT')
         ->join('tabel_pengguna', 'tabel_berita.pengguna_id = tabel_pengguna.pengguna_id', 'LEFT');
    return $this;
  }
}