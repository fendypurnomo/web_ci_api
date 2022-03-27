<?php

namespace App\Validation\Admin;

class User
{
  public $updatePersonalInformation = [
    'username' => [
      'rules' => 'required|checkUsername|min_length[5]',
      'errors' => [
        'required' => 'Masukkan nama pengguna Anda!',
        'min_length' => 'Masukkan nama pengguna Anda minimal 5 karakter!',
        'checkUsername' => 'Masukkan nama pengguna hanya karakter huruf kecil, dan atau titik dan angka!'
      ]
    ],
    'firstname' => [
      'rules' => 'required|alpha|min_length[2]|max_length[20]',
      'errors' => [
        'alpha' => 'Masukkan nama depan Anda hanya karakter huruf!',
        'required' => 'Maaf, masukkan nama depan Anda!',
        'min_length' => 'Maaf, masukkan nama depan Anda minimal 2 karakter!',
        'max_length' => 'Maaf, masukkan nama depan Anda maksimal 20 karakter!'
      ]
    ],
    'lastname' => [
      'rules' => 'required|alpha|min_length[2]|max_length[20]',
      'errors' => [
        'alpha' => 'Masukkan nama belakang Anda hanya karakter huruf!',
        'required' => 'Maaf, masukkan nama belakang Anda!',
        'min_length' => 'Maaf, masukkan nama belakang Anda minimal 2 karakter!',
        'max_length' => 'Maaf, masukkan nama belakang Anda maksimal 20 karakter!'
      ]
    ],
    'gender' => [
      'rules' => 'required|is_natural|greater_than_equal_to[1]|less_than_equal_to[2]',
      'errors' => [
        'required' => 'Pilih jenis kelamin Anda!',
        'is_natural' => 'Masukkan hanya karakter angka!',
        'less_than_equal_to' => 'Kode jenis kelamin adalah 1 = Laki-laki dan 2 = Perempuan',
        'greater_than_equal_to' => 'Kode jenis kelamin adalah 1 = Laki-laki dan 2 = Perempuan'
      ]
    ]
  ];

  public $changePassword = [
    'oldPassword' => [
      'rules' => 'required',
      'errors' => [
        'required' => 'Masukkan kata sandi lama Anda!'
      ]
    ],
    'newPassword' => [
      'rules' => 'required|min_length[8]|checkPasswordStrength',
      'errors' => [
        'required' => 'Masukkan kata sandi baru Anda!',
        'min_length' => 'Masukkan kata sandi baru minimal 8 karakter!',
        'checkPasswordStrength' => 'Kata sandi baru harus mengandung minimal 1 karakter huruf besar, kecil dan angka!'
      ]
    ],
    'confirmNewPassword' => [
      'rules' => 'required|matches[newPassword]',
      'errors' => [
        'required' => 'Masukkan konfirmasi kata sandi baru Anda!',
        'matches' => 'Konfirmasi kata sandi baru tidak cocok!'
      ]
    ]
  ];

  public $uploadPhotoProfile = [
    'imgFile' => [
      'rules' => 'uploaded[imgFile]|max_size[imgFile,1024]|ext_in[imgFile,png,jpg,jpeg,gif]|is_image[imgFile]',
      'errors' => [
        'max_size' => 'Ukuran berkas foto maksimal 1MB!',
        'ext_in' => 'Ektensi berkas foto harus png, jpg/jpeg atau gif!'
      ]
    ]
  ];

  public $accountNewEqualOldPassword = [
    'success' => false,
    'error' => 'newPasswordSameOldPassword',
    'messages' => [
      'newPassword' => 'Kata sandi baru tidak boleh sama dengan kata sandi lama Anda!'
    ]
  ];

  public $accountOldPasswordInvalid = [
    'success' => false,
    'error' => 'oldPasswordNotValid',
    'messages' => [
      'oldPassword' => 'Kata sandi lama yang Anda masukkan tidak cocok dengan kata sandi Anda saat ini!'
    ]
  ];
}