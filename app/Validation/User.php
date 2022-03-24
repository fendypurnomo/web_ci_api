<?php

namespace App\Validation;

class User
{
  /*
  |-----------------------------------------------------------------
  | SIGNIN
  |-----------------------------------------------------------------
  */
  public $signin = [
    'username' => [
      'rules' => 'trim|required',
      'errors' => [
        'required' => 'Masukkan e-mail atau nama pengguna Anda!'
      ]
    ],
    'password' => [
      'rules' => 'required',
      'errors' => [
        'required' => 'Masukkan kata sandi Anda!'
      ]
    ]
  ];

  /*
  |-----------------------------------------------------------------
  | SIGNUP
  |-----------------------------------------------------------------
  */
  public $signup = [
    'firstname' => [
      'rules'  => 'required|alpha|min_length[2]|max_length[12]',
      'errors' => [
        'required'   => 'Masukkan nama depan Anda!',
        'alpha'      => 'Masukkan hanya karakter huruf!',
        'min_length' => 'Masukkan nama depan minimal 2 karakter!',
        'max_length' => ''
      ]
    ],
    'lastname' => [
      'rules'  => 'required|alpha|min_length[2]|max_length[12]',
      'errors' => [
        'required'   => 'Masukkan nama belakang Anda!',
        'alpha'      => 'Masukkan hanya karakter huruf!',
        'min_length' => 'Masukkan nama belakang minimal 2 karakter!',
        'max_length' => ''
      ]
    ],
    'email' => [
      'rules'  => 'required|valid_email|is_unique[tabel_pengguna.pengguna_email]',
      'errors' => [
        'required'    => 'Masukkan e-mail Anda!',
        'valid_email' => 'Email yang Anda masukkan tidak valid',
        'is_unique'   => 'Email yang Anda masukkan sudah terdaftar, ganti dengan email lain!'
      ]
    ],
    'password' => [
      'rules'  => 'required|min_length[8]|checkPasswordStrength',
      'errors' => [
        'required'              => 'Masukkan kata sandi Anda!',
        'min_length'            => 'Kata sandi minimal 8 karakter',
        'checkPasswordStrength' => 'Kata sandi harus mengandung minimal 1 karakter huruf besar, kecil dan angka!'
      ]
    ],
    'confirmPassword' => [
      'rules'  => 'required|matches[password]',
      'errors' => [
        'required' => 'Masukkan konfirmasi kata sandi Anda!',
        'matches'  => 'Konfirmasi kata sandi tidak cocok!'
      ]
    ],
    'gender' => [
      'rules'  => 'required|is_natural|greater_than_equal_to[1]|less_than_equal_to[2]',
      'errors' => [
        'required'              => 'Pilih jenis kelamin Anda!',
        'is_natural'            => 'Masukkan hanya karakter angka!',
        'greater_than_equal_to' => 'Kode jenis kelamin adalah 1 = Laki-laki dan 2 = Perempuan',
        'less_than_equal_to'    => 'Kode jenis kelamin adalah 1 = Laki-laki dan 2 = Perempuan'
      ]
    ]
  ];

  /*
  |-----------------------------------------------------------------
  | RECOVERY
  |-----------------------------------------------------------------
  */
  public $checkEmailAddress = [
    'email' => [
      'rules' => 'required|valid_email|is_not_unique[tabel_pengguna.pengguna_email]',
      'errors' => [
        'required' => 'Masukkan e-mail Anda!',
        'valid_email' => 'E-mail yang Anda masukkan tidak valid!',
        'is_not_unique' => 'E-mail Anda tidak dapat kami temukan!'
      ]
    ]
  ];

  public $checkOTPCode = [
    'otp' => [
      'rules' => 'required|min_length[5]|max_length[6]|is_natural',
      'errors' => [
        'required' => 'Masukkan Kode OTP!',
        'min_length' => 'Masukkan Kode OTP minimal 5 karakter!',
        'max_length' => 'Masukkan Kode OTP maksimal 6 karakter!',
        'is_natural' => 'Masukkan Kode OTP hanya karakter angka!'
      ]
    ]
  ];

  public $createNewPassword = [
    'newPassword' => [
      'rules' => 'required|min_length[8]|checkPasswordStrength',
      'errors' => [
        'required' => 'Masukkan kata sandi baru Anda!',
        'min_length' => 'Masukkan kata sandi baru Anda minimal 8 karakter!',
        'checkPasswordStrength' => 'Kata sandi harus mengandung minimal 1 karakter huruf besar, kecil dan angka!'
      ]
    ],
    'confirmNewPassword' => [
      'rules' => 'required|matches[newPassword]',
      'errors' => [
        'required' => 'Masukkan konfirmasi kata sandi baru Anda!',
        'matches' => 'Konfirmasi kata sandi baru Anda tidak cocok!'
      ]
    ]
  ];

  /*
  |-----------------------------------------------------------------
  | ACCOUNT
  |-----------------------------------------------------------------
  */
  public $updatePersonalInformation = [
    'username' => [
      'rules'  => 'required|checkUsername|min_length[5]',
      'errors' => [
        'required'      => 'Masukkan nama pengguna Anda!',
        'min_length'    => 'Masukkan nama pengguna Anda minimal 5 karakter!',
        'checkUsername' => 'Masukkan nama pengguna hanya karakter huruf kecil, dan atau titik dan angka!'
      ]
    ],
    'firstname' => [
      'rules'  => 'required|alpha|min_length[2]',
      'errors' => [
        'alpha'      => 'Masukkan nama depan Anda hanya karakter huruf!',
        'required'   => 'Maaf, masukkan nama depan Anda!',
        'min_length' => 'Maaf, masukkan minimal nama depan Anda 2 karakter!'
      ]
    ],
    'lastname' => [
      'rules'  => 'required|alpha|min_length[2]',
      'errors' => [
        'alpha'      => 'Masukkan nama belakang Anda hanya karakter huruf!',
        'required'   => 'Maaf, masukkan nama belakang Anda!',
        'min_length' => 'Maaf, masukkan minimal nama belakang Anda 2 karakter!'
      ]
    ],
    'gender' => [
      'rules'  => 'required|is_natural|greater_than_equal_to[1]|less_than_equal_to[2]',
      'errors' => [
        'required'              => 'Pilih jenis kelamin Anda!',
        'is_natural'            => 'Masukkan hanya karakter angka!',
        'less_than_equal_to'    => 'Kode jenis kelamin adalah 1 = Laki-laki dan 2 = Perempuan',
        'greater_than_equal_to' => 'Kode jenis kelamin adalah 1 = Laki-laki dan 2 = Perempuan'
      ]
    ]
  ];

  public $changePassword = [
    'oldPassword' => [
      'rules'  => 'required',
      'errors' => [
        'required' => 'Masukkan kata sandi lama Anda!'
      ]
    ],
    'newPassword' => [
      'rules'  => 'required|min_length[8]|checkPasswordStrength',
      'errors' => [
        'required'              => 'Masukkan kata sandi baru Anda!',
        'min_length'            => 'Masukkan kata sandi baru minimal 8 karakter!',
        'checkPasswordStrength' => 'Kata sandi baru harus mengandung minimal 1 karakter huruf besar, kecil dan angka!'
      ]
    ],
    'confirmNewPassword' => [
      'rules'  => 'required|matches[newPassword]',
      'errors' => [
        'required' => 'Masukkan konfirmasi kata sandi baru Anda!',
        'matches'  => 'Konfirmasi kata sandi baru tidak cocok!'
      ]
    ]
  ];

  public $uploadPhotoProfile = [
    'imgFile' => [
      'rules'  => 'uploaded[imgFile]|max_size[imgFile,1024]|ext_in[imgFile,png,jpg,jpeg,gif]|is_image[imgFile]',
      'errors' => [
        'max_size' => 'Ukuran berkas foto maksimal 1MB!',
        'ext_in'   => 'Ektensi berkas foto harus png, jpg/jpeg atau gif!'
      ]
    ]
  ];
}