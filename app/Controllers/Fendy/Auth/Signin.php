<?php

namespace App\Controllers\Fendy\Auth;

class Signin extends \App\Controllers\Fendy\BaseAuthController
{
  protected $rules;

  public function __construct()
  {
    parent::__construct();
    $this->rules = new \App\Validation\Auth\Signin;
  }

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

              $model = new \App\Controllers\Fendy\Admin\Akun\Userphoto();
              $photo = $model->getCurrentPhotoProfile($row->pengguna_id, 'string');

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
                    'photoProfile' => $photo
                  ]
                ]
              ]);
            }

            return $this->respond($this->rules->accountWrongPassword);
          }

          return $this->respond($this->rules->accountBlocked);
        }

        return $this->respond($this->rules->accountHasNotBeenActivated);
      }

      return $this->respond($this->rules->accountNotFound);
    }

    return $this->respond([
      'success' => false,
      'error' => 'badRequest',
      'messages' => $this->validator->getErrors()
    ]);
  }
}