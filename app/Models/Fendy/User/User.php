<?php

namespace App\Models\Fendy\User;

class User extends \CodeIgniter\Model
{
  protected $table = 'tabel_pengguna';
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
  protected $createdField = 'pengguna_tgl_dibuat';
  protected $updatedField = 'pengguna_tgl_diperbaharui';
  protected $beforeInsert = ['beforeInsertUpdate'];
  protected $beforeUpdate = ['beforeInsertUpdate'];

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

  public function updatePersonalInformation($put, $user) {
    $data = [
      'pengguna_nama' => $put->username,
      'pengguna_nama_depan' => $put->firstname,
      'pengguna_nama_belakang' => $put->lastname,
      'pengguna_jenis_kelamin' => $put->gender
    ];

    if ($user->pengguna_nama != $put->username) {
      if (! $this->checkUsernameAvailability($put->username)) {
        throw new \RuntimeException('Nama pengguna yang Anda masukkan telah terpakai!');
      }
      $data = array_merge($data, ['pengguna_nama' => $put->username]);
    }

    $this->update($user->pengguna_id, $data);
  }

  public function updatePassword($put, $user) {
    $rules = new \App\Validation\Admin\User\User;

    if (! password_verify($put->currentPassword, $user->pengguna_sandi)) {
      throw new \RuntimeException($rules->currentPasswordWrong);
    }
    if ($put->currentPassword === $put->newPassword) {
      throw new \RuntimeException($rules->newPasswordEqualToCurrentPassword);
    }

    $this->update($user->pengguna_id, ['pengguna_sandi' => $put->newPassword]);
  }

  public function checkUsernameAvailability($username)
  {
    $query = $this->where('pengguna_nama', $username)->first();

    if ($query) {
      return false;
    }

    return true;
  }
}