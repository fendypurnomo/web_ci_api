<?php

namespace App\Controllers\Fendy\Auth;

use Exception;

class Activation extends \App\Controllers\Fendy\BaseAuthController
{
  protected $rules;

  public function __construct()
  {
    parent::__construct();
    $this->rules = new \App\Validation\Auth\Activation;
  }

  // Index activate account user
  public function index()
  {
    $method = $this->request->getMethod(true);

    if ($method === 'GET') {
      return $this->confirmActivation();
    } elseif ($method === 'POST') {
      return $this->requestActivation();
    } else {
      return $this->respond($this->requestNotFound);
    }
  }

  // Activate account user
  private function confirmActivation()
  {
    try {
      $decode = decodeToken(getRequestQueryParam('code'));

      if ($row = $this->model->find($decode->data->id)) {
        if ($row->pengguna_aktivasi != 1) {
          $this->model->update($row->pengguna_id, ['pengguna_aktivasi' => 1]);

          return $this->respond([
            'success' => true,
            'status' => 200,
            'message' => 'Akun Anda berhasil diaktivasi'
          ]);
        }

        return $this->respond($this->rules->accountHasActivated);
      }

      return $this->respond($this->requestNotFound);
    } catch (Exception $e) {
      return $this->fail($e->getMessage());
    }
  }

  // Request activate account user
  private function requestActivation()
  {
    if ($this->validate($this->rules->activation)) {
      $post = getRequest();
      $user = $this->model->where('pengguna_email', $post->email)->first();

      $code = createToken([
        'id' => $user->pengguna_id,
        'email' => $user->pengguna_email
      ], 300);

      // sendmail([
      // 	'email'    => $post->email,
      // 	'messages' => 'Klik link di bawah ini untuk aktivasi akun Anda.\n https://api.ci4.local/auth/activation?code=' . $code
      // ]);

      return $this->respond([
        'success' => true,
        'status' => 200,
        'message' => 'Permintaan link aktivasi akun telah kami kirim ke email Anda. ' . $code
      ]);
    }

    return $this->respond([
      'success' => false,
      'error' => 'badRequest',
      'messages' => $this->validator->getErrors()
    ]);
  }
}