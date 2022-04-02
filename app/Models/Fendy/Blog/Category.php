<?php

namespace App\Models\Fendy\Blog;

class Category extends \CodeIgniter\Model
{
    protected $table = 'ref_kategori';
    protected $primaryKey = 'kategori_id';
    protected $returnType = 'object';
    protected $allowedFields = ['kategori_nama', 'kategori_seo', 'kategori_aktif'];

    /**
     * --------------------------------------------------
     * Get data
     * --------------------------------------------------
     */
    public function getData(object $param, object $paging)
    {
        if ((isset($param->search) && trim($param->search) != null) && (isset($param->value) && trim($param->value) != null)) {
            if ($param->search === 'id') {
                return self::showData($param->value);
            }
            if ($param->search === 'name') {
                $this->like('kategori_seo', $param->value, 'both');
                $this->orLike('kategori_nama', $param->value, 'both');
            }
        }

        $page = $paging->page;
        $perPage = $paging->perPage;
        $totalRecords = $this->countAllResults(false);
        $totalPages = ceil($totalRecords / $perPage);
        $query = $this->paginate($perPage, '', $page);

        if (! $query) {
            throw new \RuntimeException('Permintaan data tidak dapat ditemukan!');
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
            'kategori_nama' => $post->name,
            'kategori_seo' => $post->seo,
            'kategori_aktive' => $post->active
        ];

        $query = $this->insert($data);

        if (! $query) {
            throw new \RuntimeException('Data gagal disimpan!');
        }

        $response = [
            'success' => true,
            'status' => 201,
            'message' => 'Data kategori berhasil disimpan'
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
            'messages' => 'Data kategori berhasil dihapus'
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
            'category_id' => $row->kategori_id,
            'category_name' => $row->kategori_nama,
            'category_seo' => $row->kategori_seo
        ];

        return $data;
    }
}
