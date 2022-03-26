<?php

namespace App\Controllers\Fendy\Auth;

class Signup extends \App\Controllers\Fendy\BaseAccountController
{
  // Index user signup
  public function index()
  {
    return $this->signup();
  }

  // Create user signup
  private function signup()
  {
    if ($this->validate($this->rules->signup)) {
      $post = getRequest();
      $numb = random_string('numeric', 7);

      $data = [
        'pengguna_nama' => strtolower($post->firstname . $post->lastname) . '.' . $numb,
        'pengguna_nama_depan' => $post->firstname,
        'pengguna_nama_belakang' => $post->lastname,
        'pengguna_email' => $post->email,
        'pengguna_sandi' => $post->password,
        'pengguna_jenis_kelamin' => $post->gender
      ];

      $this->model->insert($data);

      $code = createToken([
        'id' => (int) $this->model->getInsertID(),
        'email' => $post->email
      ], 300);

      // sendmail([
      // 	'email' => $post->email,
      // 	'subject' => 'Aktivasi pendaftaran akun',
      // 	'messages' => 'Klik link di bawah ini untuk aktivasi akun Anda.\n' . base_url('auth/activateAccount?code=') . $code
      // ]);

      return $this->respondCreated([
        'success' => true,
        'status' => 200,
        'code' => $code,
        'message' => 'Pendaftaran akun berhasil. Buka pesan baru email Anda untuk aktivasi akun.'
      ]);
    }

    return $this->fail([
      'error' => 'errorInputField',
      'field' => $this->validator->getErrors()
    ]);
  }
}