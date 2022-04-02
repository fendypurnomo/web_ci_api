<?php

namespace App\Models\Fendy\Blog;

class News extends \CodeIgniter\Model
{
    protected $table = 'tabel_berita';
    protected $primaryKey = 'berita_id';
    protected $returnType = 'object';
    protected $allowedFields = ['kategori_id', 'pengguna_id', 'berita_judul', 'berita_seo', 'berita_isi', 'berita_tanggal', 'berita_gambar', 'berita_headline', 'berita_tag'];
    protected $useTimestamps = true;
    protected $createdField = 'berita_tanggal';
    protected $updatedField = 'berita_tanggal';

    /**
     * --------------------------------------------------
     *  Get data
     * --------------------------------------------------
    */
    public function getData($param, object $paging)
    {
        $sql = $this->sql('All');

        if ((isset($param['category']) && trim($param['category']) != null) && (isset($param['headline']) && trim($param['headline']) == null || ! isset($param['headline']))) {
            $sql = $this->where('ref_kategori.kategori_seo', $param['category']);
        }
        if ((isset($param['headline']) && trim($param['headline']) == 'true' || trim($param['headline']) == 1) && (isset($param['category']) && trim($param['category']) == null || ! isset($param['category']))) {
            $sql = $this->where('tabel_berita.berita_headline', 1);
        }
        if ((isset($param['category']) && trim($param['category']) != null) && (isset($param['headline']) && trim($param['headline']) == 'true' || trim($param['headline']) == 1)) {
            $array = ['tabel_berita.berita_headline' => 1, 'ref_kategori.kategori_seo' => $param['category']];
            $sql = $this->where($array);
        }
        if (isset($param['popular']) && trim($param['popular']) == 'true' || trim($param['popular']) == 1) {
            $sql = $this->orderBy('tabel_berita.berita_dibaca', 'DESC');
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

        $response = [
            'success' => true,
            'response' => [
                'data' => $data,
                'page' => $page,
                'perPage' => $perPage,
                'totalPages' => $totalPages,
                'totalRecords' => $totalRecords
            ]
        ];

        return $response;
    }

    /**
     * --------------------------------------------------
     *  Create data
     * --------------------------------------------------
    */
    public function createData($post, $img)
    {
        if (! $img->isValid() && $img->hasMoved()) {
            throw new \RuntimeException($img->getErrorString() . '(' . $img->getError() . ')');
        }

        helper('stringreplace');

        $newName = $img->getRandomName();
        $filepath = '../../../../../../../Pictures/Images/news/';
        $img->move($filepath, $newName);
        $tag = implode(',', (array) [$post->tag]);

        $data = [
            'kategori_id' => $post->category,
            'pengguna_id' => $post->editor,
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

        $response = [
            'success' => true,
            'message' => 'Data berita berhasil disimpan'
        ];

        return $response;
    }

    /**
     * --------------------------------------------------
     *  Show data
     * --------------------------------------------------
    */
    public function showData($id)
    {
        $query = $this->sql('single')->find($id);

        if (! $query) {
            throw new \RuntimeException('Permintaan data tidak dapat ditemukan!');
        }

        $response = [
            'success' => true,
            'response' => ['data' => $this->rowData($query)]
        ];

        return $response;
    }

    /**
     * --------------------------------------------------
     *  Update data
     * --------------------------------------------------
    */
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
            throw new \RuntimeException('Data gagal disimpan!');
        }

        $response = [
            'success' => true,
            'message' => 'Data berita berhasil diperbarui'
        ];

        return $response;
    }

    /**
     * --------------------------------------------------
     *  Delete data
     * --------------------------------------------------
    */
    public function deleteData($id)
    {
        $query = $this->delete($id);

        if (! $query) {
            throw new \RuntimeException('Data gagal dihapus!');
        }

        $response = [
            'success' => true,
            'messages' => 'Data berita berhasil dihapus'
        ];

        return $response;
    }

    /**
     * --------------------------------------------------
     *  Array row data
     * --------------------------------------------------
    */
    private function rowData($row)
    {
        $data = [
            'news_id' => $row->berita_id,
            'news_category_id' => $row->kategori_id,
            'news_read' => $row->berita_dibaca,
            'news_date' => $row->berita_tanggal,
            'news_headline' => $row->berita_headline,
            'news_editor' => $row->editor,
            'category_name' => $row->kategori_nama,
            'news_tag' => $row->berita_tag,
            'news_title' => $row->berita_judul,
            'news_seo' => $row->berita_seo,
            'news_img' => getenv('app.imgUrl') . 'news/' . $row->berita_gambar,
            'news_content' => $row->berita_isi
        ];

        return $data;
    }

    /**
     * --------------------------------------------------
     *  SQL data
     * --------------------------------------------------
    */
    private function sql(string $arg = null)
    {
        if ($arg == 'single') {
            $berita_isi = 'tabel_berita.berita_isi';
        } else {
            $berita_isi = 'LEFT(tabel_berita.berita_isi, 200) AS berita_isi';
        }

        $sql = $this->select('tabel_berita.berita_id,
                            tabel_berita.kategori_id,
                            tabel_berita.berita_judul,
                            tabel_berita.berita_seo,
                            ' . $berita_isi . ',
                            tabel_berita.berita_tanggal,
                            tabel_berita.berita_gambar,
                            tabel_berita.berita_tag,
                            IF(tabel_berita.berita_headline = 1, "Headline", "") AS berita_headline,
                            tabel_berita.berita_dibaca,
                            ref_kategori.kategori_nama,
                            ref_kategori.kategori_seo,
                            CONCAT_WS(\' \', tabel_pengguna.pengguna_nama_depan, tabel_pengguna.pengguna_nama_belakang) AS editor')
                    ->join('ref_kategori', 'tabel_berita.kategori_id = ref_kategori.kategori_id', 'LEFT')
                    ->join('tabel_pengguna', 'tabel_berita.pengguna_id = tabel_pengguna.pengguna_id', 'LEFT');

        return $sql;
    }
}
