<?php

namespace App\Controllers\Positronx;

class Pagination extends \CodeIgniter\RESTful\ResourceController
{
	protected $modelName = 'App\Models\Positronx\PaginationModel';

	public function index()
	{
		$query = $this->model->paginate(10);

		if ($query) {
			foreach($query as $row){
				$data[] = [
					'id'    => $row['wilayah_provinsi_id'],
					'title' => $row['wilayah_provinsi_nama']
				];
			}
			return $this->respond(['data'=>$data]);
		}

		return $this->failNotFound('Maaf. Terjadi kesalahan!');
	}
}