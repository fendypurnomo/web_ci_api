<?php

namespace App\Models\Fendy\Blog;

class Comment extends \CodeIgniter\Model
{
    protected $table = 'tabel_komentar';
    protected $primaryKey = 'komentar_id';
    protected $returnType = 'object';
    protected $allowedFields = ['komentar_nama', 'komentar_isi', 'komentar_tanggal'];
    protected $useTimestamps = true;
    protected $createdField = 'komentar_tanggal';

    /**
     * --------------------------------------------------
     * Get data
     * --------------------------------------------------
     */
    public function getData(object $param, object $paging)
    {
        $sql = $this->orderBy('komentar_tanggal', 'DESC');
        $page = $paging->page;
        $perPage = $paging->perPage;
        $totalRecords = (int) $this->countAllResults(false);
        $totalPages = (int) ceil($totalRecords / $perPage);
        $query = $sql->paginate($perPage, '', $page);

        if (! $query) {
            throw new \RuntimeException('Permintaan data gagal diproses!');
        }
        if ($page > $totalPages) {
            throw new \RuntimeException('Data halaman yang Anda masukkan melebihi jumlah total halaman!');
        }
        foreach ($query as $row) {
            $data[] = self::rowData($row);
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
            'berita_id' => $post->news_id,
            'komentar_nama' => $post->name,
            'komentar_isi' => $post->content,
            'komentar_parent' => $post->parent
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
        $query = $this->find($id);

        if (! $query) {
            throw new \RuntimeException('Permintaan data gagal diproses!');
        }

        $response = [
            'success' => true,
            'response' => ['data' => self::rowData($query)]
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
            'komentar_nama' => $put->name,
            'komentar_isi' => $put->content,
            'komentar_aktif' => $put->active
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
            'comment_id' => $row->komentar_id,
            'comment_news_id' => $row->komentar_berita_id,
            'comment_parent_id' => $row->komentar_parent,
            'comment_name' => $row->komentar_nama,
            'comment_content' => $row->komentar_isi,
            'comment_date' => $row->komentar_tanggal
        ];

        return $data;
    }
}
