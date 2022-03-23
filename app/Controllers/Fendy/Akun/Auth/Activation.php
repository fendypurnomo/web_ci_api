<?php

namespace App\Controllers\Fendy\Akun\Auth;

use Exception;

class Activation extends \App\Controllers\Fendy\BaseAccountController
{
  /**
   * Index activate account user
   */
  public function index()
  {
    $method = $this->request->getMethod(true);

    if ($method == 'GET') {
      return $this->activateAccount();
    } elseif ($method == 'POST') {
      return $this->requestActivationAccount();
    } else {
      return $this->failNotFound($this->requestNotFound);
    }
  }

  /**
   * Activate account user
   */
  private function activateAccount()
  {
    try {
      $decode = decodeToken(getQueryParamRequest('code'));

      if ($row = $this->model->find($decode->data->id)) {
        if ($row->pengguna_aktivasi != 1) {
          $this->model->update($row->pengguna_id, ['pengguna_aktivasi' => 1]);

          return $this->respond([
            'success' => true,
            'status'  => 200,
            'message' => 'Akun Anda berhasil diaktivasi'
          ]);
        }

        return $this->fail($this->authHasActivated);
      }

      return $this->fail($this->requestNotFound);
    } catch (Exception $e) {
      return $this->fail($e->getMessage());
    }
  }

  /**
   * Request activate account user
   */
  private function requestActivationAccount()
  {
    if ($this->validate($this->rules->checkEmailAddress)) {
      $post = getRequest();
      $user = $this->model->where('pengguna_email', $post->email)->first();

      $code = createToken([
        'id'    => $user->pengguna_id,
        'email' => $user->pengguna_email
      ], 300);

      // sendmail([
      // 	'email'    => $post->email,
      // 	'messages' => 'Klik link di bawah ini untuk aktivasi akun Anda.\n https://api.local/auth/activationAccount?code=' . $code
      // ]);

      return $this->respond([
        'success' => true,
        'status'  => 200,
        'message' => 'Permintaan link aktivasi akun telah kami kirim ke email Anda. ' . $code
      ]);
    }

    return $this->fail([
      'error' => 'inputInvalid',
      'field' => $this->validator->getErrors()
    ]);
  }
}
