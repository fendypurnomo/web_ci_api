<?php

namespace App\Models\Fendy\Akun;

class User extends \CodeIgniter\Model
{
	protected $table      = 'tabel_pengguna';
	protected $primaryKey = 'pengguna_id';
	protected $returnType = 'object';

	protected $allowedFields = [
		'pengguna_nama',
		'pengguna_nama_depan',
		'pengguna_nama_belakang',
		'pengguna_email',
		'pengguna_sandi',
		'pengguna_jenis_kelamin',
		'pengguna_aktivasi',
		'pengguna_blokir',
		'pengguna_kode_otp',
		'pengguna_sesi'
	];

	protected $useTimestamps = true;
	protected $createdField  = 'pengguna_tgl_dibuat';
	protected $updatedField  = 'pengguna_tgl_diperbaharui';
	protected $beforeInsert  = ['beforeInsertUpdate'];
	protected $beforeUpdate  = ['beforeInsertUpdate'];

	protected function beforeInsertUpdate(array $array): array
	{
		helper('text');

		if (isset($array['data']['pengguna_nama_depan'])) {
			$array['data']['pengguna_nama_depan'] = strip_slashes(ucfirst($array['data']['pengguna_nama_depan']));
		}
		if (isset($array['data']['pengguna_nama_belakang'])) {
			$array['data']['pengguna_nama_belakang'] = strip_slashes(ucfirst($array['data']['pengguna_nama_belakang']));
		}
		if (isset($array['data']['pengguna_sandi'])) {
			$array['data']['pengguna_sandi'] = password_hash($array['data']['pengguna_sandi'], PASSWORD_DEFAULT);
		}

		return $array;
	}
}
