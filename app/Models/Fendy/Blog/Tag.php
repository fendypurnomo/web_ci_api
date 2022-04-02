<?php

namespace App\Models\Fendy\Blog;

class Tag extends \CodeIgniter\Model
{
    protected $table = 'tabel_tag';
    protected $primaryKey = 'tag_id';
    protected $returnType = 'object';
    protected $allowedFields = ['tag_nama', 'tag_seo', 'tag_hitung'];

    /**
     * --------------------------------------------------
     * Get data
     * --------------------------------------------------
     */
    public function getData(object $paging = null)
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
            $data[] = $this->rowData($row);
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
            'tag_nama' => $post->name,
            'tag_seo' => $post->seo
        ];

        $query = $this->insert($data);

        if (! $query) {
            throw new \RuntimeException('Data gagal disimpan!');
        }

        $response = [
            'success' => true,
            'status' => 201,
            'messages' => 'Data tag berhasil disimpan'
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
            'tag_nama' => $put->name,
            'tag_seo' => $put->seo
        ];

        $query = $this->update($id, $data);

        if (! $query) {
            throw new \RuntimeException('Data gagal disimpan!');
        }

        $response = [
            'success' => true,
            'status' => 200,
            'messages' => 'Data pesan berhasil diperbarui'
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
            'messages' => 'Data tag berhasil dihapus'
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
            'tag_id' => $row->tag_id,
            'tag_name' => $row->tag_nama,
            'tag_seo' => $row->tag_seo,
            'tag_count' => $row->tag_hitung
        ];

        return $data;
    }
}
