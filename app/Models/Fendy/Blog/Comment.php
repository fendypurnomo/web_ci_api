<?php

namespace App\Models\Fendy\Blog;

class Comment extends \CodeIgniter\Model
{
    protected $DBGroup = 'blog';
    protected $table = 'komentar';
    protected $primaryKey = 'id_komentar';
    protected $returnType = 'object';
    protected $allowedFields = ['nama_komentar', 'url', 'isi_komentar', 'tgl', 'jam_komentar'];
    protected $useTimestamps = false;
    protected $createdField = 'tgl';

    /**
     * --------------------------------------------------
     * Get data
     * --------------------------------------------------
     */
    public function getData(object $paging)
    {
        $sql = $this->sql();

        $page = $paging->page;
        $perPage = $paging->perPage;
        $totalRecords = (int) $this->countAll(false);
        $totalPages = (int) ceil($totalRecords / $perPage);
        $query = $sql->paginate($paging->perPage, '', $paging->page);

        if (! $query) {
            throw new \RuntimeException('Permintaan data gagal diproses!');
        }
        if ($page > $totalPages) {
            throw new \RuntimeException('Data halaman yang Anda masukkan melebihi jumlah total halaman!');
        }
        foreach ($query as $row) {
            $data[] = $this->data($row);
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
     * Create data
     * --------------------------------------------------
     */
    public function createData($post)
    {
        $data = [
            'nama_komentar' => $post->name,
            'url' => $post->url,
            'isi_komentar' => $post->content
        ];

        $query = $this->insert($data);

        if (! $query) {
            throw new \RuntimeException('Data gagal disimpan');
        }

        $response = [
            'success' => true,
            'status' => 201,
            'message' => 'Data komentar berhasil disimpan'
        ];

        return $response;
    }

    /**
     * --------------------------------------------------
     * Show data
     * --------------------------------------------------
     */
    public function showData($id)
    {
        $query = $this->sql()->find($id);

        if (! $query) {
            throw new \RuntimeException('Permintaan data gagal diproses!');
        }

        $response = [
            'success' => true,
            'response' => [
            'data' => $this->rowData($query)
            ]
        ];

        return $response;
    }

    /**
     * --------------------------------------------------
     * Update data
     * --------------------------------------------------
     */
    public function updateData($id, $put)
    {
        $data = [
            'nama_komentar' => $put->name,
            'url' => $put->url,
            'isi_komentar' => $put->content
        ];

        $query = $this->update($id, $data);

        if (! $query) {
            throw new \RuntimeException('Data gagal disimpan!');
        }

        $response = [
            'success' => true,
            'status' => 200,
            'message' => 'Data komentar berhasil diperbarui'
        ];

        return $response;
    }

    /**
     * --------------------------------------------------
     * Delete data
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
            'status' => 200,
            'messages' => 'Data komentar berhasil dihapus'
        ];

        return $response;
    }

    /**
     * --------------------------------------------------
     * Array row data
     * --------------------------------------------------
     */
    private function rowData($row)
    {
        $data = [
            'comment_id' => $row->id_komentar,
            'comment_name' => $row->nama_komentar,
            'comment_site' => $row->url,
            'comment_content' => $row->isi_komentar,
            'comment_date' => $row->tgl,
            'news_id' => $row->id_berita,
            'news_url' => getenv('app.baseURL') . 'news/' . $row->judul_seo
        ];

        return $data;
    }

    /**
     * --------------------------------------------------
     * SQL data
     * --------------------------------------------------
     */
    private function sql()
    {
        $sql = $this->join('berita', 'komentar.id_berita = berita.id_berita', 'left');

        return $sql;
    }
}
