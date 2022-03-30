<?php

namespace App\Controllers\Fendy\Admin\User;

use Exception;

class User extends \App\Controllers\Fendy\BaseAdminController
{
  protected $modelName = 'App\Models\Fendy\User\User';
  protected $rules;

  public function __construct()
  {
    parent::__construct();
    $this->rules = new \App\Validation\Admin\User\User;
  }

  // Index user account
  public function index()
  {
    $data = self::data();

    return $this->respond([
      'success' => true,
      'response' => $data
    ]);
  }

  // Update personal information
  public function updatePersonalInformation()
  {
    try {
      if ($this->validate($this->rules->updatePersonalInformation)) {
        $put = getRequest();
        $user = checkUserToken();
        $this->model->updatePersonalInformation($put, $user);
        $data = self::data();
        return $this->respondUpdated([
          'success' => true,
          'status' => 200,
          'messages' => 'Informasi akun Anda berhasil diperbaharui.',
          'response' => $data
        ]);
      }
      return $this->respond([
        'success' => false,
        'error' => 'badRequest',
        'messages' => $this->validator->getErrors()
      ]);
    }
    catch (Exception $e) {
      return $this->respond(['success' => false, 'messages' => $e->getMessage()]);
    }
  }

  // Update password
  public function updatePassword()
  {
    try {
      if ($this->validate($this->rules->updatePassword)) {
        $put = getRequest();
        $user = checkUserToken();
        $this->model->updatePassword($put, $user);
        return $this->respond([
          'success' => true,
          'status' => 200,
          'messages' => 'Kata sandi berhasil diperbarui'
        ]);
      }
      return $this->respond([
        'success' => false,
        'error' => 'badRequest',
        'messages' => $this->validator->getErrors()
      ]);
    }
    catch (Exception $e) {
      return $this->respond(['success' => false, 'messages' => $e->getMessage()]);
    }
  }

  private function data()
  {
    $user = checkUserToken();

    return (array) [
      'data' => [
        'username' => $user->pengguna_nama,
        'firstname' => $user->pengguna_nama_depan,
        'lastname' => $user->pengguna_nama_belakang,
        'email' => $user->pengguna_email,
        'gender' => $user->pengguna_jenis_kelamin,
        'createdAt' => $user->pengguna_tgl_dibuat,
        'updatedAt' => $user->pengguna_tgl_diperbaharui
      ]
    ];
  }
}