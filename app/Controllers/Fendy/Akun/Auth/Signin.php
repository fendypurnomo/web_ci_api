<?php

namespace App\Controllers\Fendy\Akun\Auth;

class Signin extends \App\Controllers\Fendy\BaseAccountController
{
  // Index user signin
  public function index()
  {
    return $this->signin();
  }

  // Authentication user signin
  private function signin()
  {
    if ($this->validate($this->rules->signin)) {
      $post = getRequest();

      if ($row = $this->model->where('pengguna_nama', $post->username)->orWhere('pengguna_email', $post->username)->first()) {
        if ($row->pengguna_aktivasi == 1) {
          if ($row->pengguna_blokir == 0) {
            if (password_verify($post->password, $row->pengguna_sandi)) {

              $model = new \App\Controllers\Fendy\Akun\Photoprofile($row->pengguna_id);
              $photo = $model->getCurrentPhotoProfile();

              $accessToken = createToken([
                'id' => $row->pengguna_id,
                'email' => $row->pengguna_email
              ]);

              return $this->respond([
                'success' => true,
                'status' => 200,
                'isLoggedIn' => true,
                'accessToken' => $accessToken,
                'response' => [
                  'data' => [
                    'firstname' => $row->pengguna_nama_depan,
                    'lastname' => $row->pengguna_nama_belakang,
                    'email' => $row->pengguna_email,
                    'photoProfile' => getenv('app.imgURL') . 'profiles/' . $photo
                  ]
                ]
              ]);
            }

            return $this->fail($this->authWrongPassword);
          }

          return $this->fail($this->authBlocked);
        }

        return $this->fail($this->authNotActivated);
      }

      return $this->fail($this->authNotFound);
    }

    return $this->fail([
      'error' => 'inputFieldRequired',
      'field' => $this->validator->getErrors()
    ]);
  }
}