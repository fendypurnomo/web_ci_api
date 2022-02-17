<?php

namespace App\Models\Positronx;

class PaginationModel extends \CodeIgniter\Model
{
	protected $table      = 'wilayah_provinsi';
	protected $primaryKey = 'wilayah_provinsi_id';
	protected $returnType = 'array';

	protected $allowedFields = ['wilayah_provinsi_nama'];
}
