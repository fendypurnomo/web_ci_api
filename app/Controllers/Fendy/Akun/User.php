<?php

namespace App\Controllers\Fendy\Akun;

use Exception;

class User extends \App\Controllers\Fendy\BaseAccountController
{
	protected $user;

	public function __construct()
	{
		parent::__construct();

		$this->user = new \App\Libraries\Authorization();
	}

	/**
	 * Index user account
	 */
	public function index()
	{
		try {
			$method = $this->request->getMethod(true);

			if ($method === 'GET') {
				return $this->personalInformation();
			} else {
				$request = getQueryParamRequest('req');

				if ($method === 'PUT') {
					if ($request === 'updatePersonalInformation') {
						return $this->updatePersonalInformation();
					} elseif ($request === 'changePassword') {
						return $this->changePassword();
					} else {
						return $this->failNotFound($this->requestNotFound);
					}
				} elseif ($method === 'POST' && $request === 'uploadPhotoProfile') {
					return $this->uploadPhotoProfile();
				} else {
					return $this->failNotFound($this->requestNotFound);
				}
			}
		} catch (Exception $e) {
			return $this->fail($e->getMessage());
		}
	}

	/**
	 * Get personal information
	 */
	private function personalInformation()
	{
		$user = $this->user->account;

		return $this->respond([
			'data' => [
				'username'  => $user->pengguna_nama,
				'firstname' => $user->pengguna_nama_depan,
				'lastname'  => $user->pengguna_nama_belakang,
				'email'     => $user->pengguna_email,
				'gender'    => $user->pengguna_jenis_kelamin,
				'createdAt' => $user->pengguna_tgl_dibuat,
				'updatedAt' => $user->pengguna_tgl_diperbaharui
			]
		]);
	}

	/**
	 * Update personal information
	 */
	private function updatePersonalInformation()
	{
		if ($this->validate($this->rules->updatePersonalInformation)) {
			$put  = getRequest();
			$user = $this->user->account;

			$data = [
				'pengguna_nama_depan'    => $put->firstname,
				'pengguna_nama_belakang' => $put->lastname,
				'pengguna_jenis_kelamin' => $put->gender
			];

			if ($user->pengguna_nama != $put->username) {
				if ($this->model->where('pengguna_nama', $put->username)->first()) {
					return $this->fail('Nama pengguna tidak tersedia!');
				}
				$data = array_merge($data, ['pengguna_nama' => $put->username]);
			}

			$this->model->update($user->pengguna_id, $data);

			return $this->respondUpdated([
				'success' => true,
				'status'  => 200,
				'message' => 'Informasi akun Anda berhasil diperbaharui.'
			]);
		}

		return $this->fail([
			'errors' => 'badRequest',
			'field'  => $this->validator->getErrors()
		]);
	}

	/**
	 * Change password
	 */
	private function changePassword()
	{
		if ($this->validate($this->rules->changePassword)) {
			$put  = getRequest();
			$user = $this->user->account;

			if (password_verify($put->oldPassword, $user->pengguna_sandi)) {
				if ($put->oldPassword !== $put->newPassword) {
					$this->model->update($user->pengguna_id, ['pengguna_sandi' => $put->newPassword]);

					return $this->respond([
						'success' => true,
						'status'  => 200,
						'message' => 'Kata sandi berhasil diperbarui'
					]);
				}

				return $this->fail($this->accountNewEqualOldPassword);
			}

			return $this->fail($this->accountOldPasswordInvalid);
		}

		return $this->fail([
			'errors' => 'badRequest',
			'field'  => $this->validator->getErrors()
		]);
	}

	/**
	 * Upload photo profile
	 */
	private function uploadPhotoProfile()
	{
		if ($this->validate($this->rules->uploadPhotoProfile)) {
			$file = $this->request->getFile('imgFile');

			if ($file->isValid() && !$file->hasMoved()) {
				$name  = $file->getRandomName();
				$path  = '../../../../../../../Pictures/Assets/img/profiles/';
				$model = new \App\Models\Fendy\Akun\PhotoProfile();

				if ($file->move($path, $name)) {
					$model->insert([
						'pengguna_id' => $this->user->account->pengguna_id,
						'foto_nama'   => $name,
						'foto_aktif'  => 1
					]);

					$model->where('pengguna_id = ' . $this->user->account->pengguna_id . ' AND foto_id != ' . $model->getInsertID())
						->set(['foto_aktif' => 0])
						->update();

					return $this->respond([
						'success' => true,
						'status'  => 200,
						'message' => 'Unggah foto profil berhasil'
					]);
				}

				throw new \RuntimeException($file->getErrorString() . '(' . $file->getError() . ')');
			}

			throw new \RuntimeException($file->getErrorString() . '(' . $file->getError() . ')');
		}

		return $this->fail([
			'errors' => 'badRequest',
			'field'  => $this->validator->getErrors()
		]);
	}
}
