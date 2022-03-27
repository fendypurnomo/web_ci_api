<?php

namespace App\Controllers\Fendy\Admin\Akun;

use Exception;

class User extends \App\Controllers\Fendy\BaseAdminController
{
  protected $rules;

  public function __construct()
  {
    parent::__construct();
    $this->rules = new \App\Validation\Admin\User;
  }

  // Index user account
  public function index()
  {
    try {
      $method = $this->request->getMethod(true);

      if ($method === 'GET') {
        return $this->personalInformation();
      } else {
        $request = getRequestQueryParam('req');

        if ($method === 'PUT') {
          if ($request === 'updatePersonalInformation') {
            return $this->updatePersonalInformation();
          } elseif ($request === 'changePassword') {
            return $this->changePassword();
          } else {
            return $this->respond($this->requestNotFound);
          }
        } elseif ($method === 'POST' && $request === 'uploadPhotoProfile') {
          return $this->uploadPhotoProfile();
        } else {
          return $this->respond($this->requestNotFound);
        }
      }
    } catch (Exception $e) {
      return $this->fail($e->getMessage());
    }
  }

  // Get personal information
  private function personalInformation()
  {
    $user = checkUserToken();

    return $this->respond([
      'data' => [
        'username' => $user->pengguna_nama,
        'firstname' => $user->pengguna_nama_depan,
        'lastname' => $user->pengguna_nama_belakang,
        'email' => $user->pengguna_email,
        'gender' => $user->pengguna_jenis_kelamin,
        'createdAt' => $user->pengguna_tgl_dibuat,
        'updatedAt' => $user->pengguna_tgl_diperbaharui
      ]
    ]);
  }

  // Update personal information
  private function updatePersonalInformation()
  {
    if ($this->validate($this->rules->updatePersonalInformation)) {
      $put = getRequest();
      $user = checkUserToken();

      $data = [
        'pengguna_nama_depan' => $put->firstname,
        'pengguna_nama_belakang' => $put->lastname,
        'pengguna_jenis_kelamin' => $put->gender
      ];

      if ($user->pengguna_nama != $put->username) {
        if ($this->model->where('pengguna_nama', $put->username)->first()) {
          return $this->respond([
            'success' => false,
            'error' => 'usernameNotAvailable',
            'messages' => 'Nama pengguna tidak tersedia!'
          ]);
        }
        $data = array_merge($data, ['pengguna_nama' => $put->username]);
      }

      $this->model->update($user->pengguna_id, $data);

      return $this->respondUpdated([
        'success' => true,
        'status' => 200,
        'messages' => 'Informasi akun Anda berhasil diperbaharui.'
      ]);
    }

    return $this->respond([
      'success' => false,
      'error' => 'badRequest',
      'messages' => $this->validator->getErrors()
    ]);
  }

  // Change password
  private function changePassword()
  {
    if ($this->validate($this->rules->changePassword)) {
      $put = getRequest();
      $user = checkUserToken();

      if (password_verify($put->oldPassword, $user->pengguna_sandi)) {
        if ($put->oldPassword !== $put->newPassword) {
          $this->model->update($user->pengguna_id, ['pengguna_sandi' => $put->newPassword]);

          return $this->respond([
            'success' => true,
            'status' => 200,
            'messages' => 'Kata sandi berhasil diperbarui'
          ]);
        }

        return $this->respond($this->rules->accountNewEqualOldPassword);
      }

      return $this->respond($this->rules->accountOldPasswordInvalid);
    }

    return $this->respond([
      'success' => false,
      'error' => 'badRequest',
      'messages' => $this->validator->getErrors()
    ]);
  }

  // Upload photo profile
  private function uploadPhotoProfile()
  {
    if ($this->validate($this->rules->uploadPhotoProfile)) {
      $img = $this->request->getFile('imgFile');

      if ($img->isValid() && !$img->hasMoved()) {
        $newName = $img->getRandomName();
        $filepath = '../../../../../../../Pictures/Images/profiles/';
        $model = new \App\Models\Fendy\Akun\PhotoProfile();
        $userID = checkUserToken()->pengguna_id;

        if ($img->move($filepath, $newName)) {
          $model->insert([
            'pengguna_id' => $userID,
            'foto_nama' => $newName,
            'foto_aktif' => 1
          ]);

          $model->where('pengguna_id = ' . $userID . ' AND foto_id != ' . $model->getInsertID())->set(['foto_aktif' => 0])->update();

          return $this->respond([
            'success' => true,
            'status' => 200,
            'messages' => 'Unggah foto profil berhasil'
          ]);
        }

        throw new \RuntimeException($img->getErrorString() . '(' . $img->getError() . ')');
      }

      throw new \RuntimeException($img->getErrorString() . '(' . $img->getError() . ')');
    }

    return $this->respond([
      'success' => false,
      'error' => 'badRequest',
      'messsages' => $this->validator->getErrors()
    ]);
  }
}