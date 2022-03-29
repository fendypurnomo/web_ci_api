<?php

namespace App\Controllers\Fendy\Auth;

class Signup extends \App\Controllers\Fendy\BaseAuthController
{
  protected $rules;

  public function __construct()
  {
    parent::__construct();
    $this->rules = new \App\Validation\Auth\Signup;
  }

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
      $username = username($post->firstname . $post->lastname);

      if ($this->model->checkUsernameAvailability($username)) {
        $username = $username;
      }
      else
      {
        $numb = random_string('numeric', 7);
        $username = $username . '.' . $numb;
      }

      $data = [
        'pengguna_nama' => $username,
        'pengguna_nama_depan' => htmlspecialchars($post->firstname, ENT_QUOTES),
        'pengguna_nama_belakang' => htmlspecialchars($post->lastname, ENT_QUOTES),
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
        'messages' => 'Pendaftaran akun berhasil. Buka pesan baru email Anda untuk aktivasi akun.'
      ]);
    }

    return $this->respond([
      'success' => false,
      'error' => 'badRequest',
      'messages' => $this->validator->getErrors()
    ]);
  }
}