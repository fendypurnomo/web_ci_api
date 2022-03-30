<?php

namespace App\Validation\Admin\User;

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
        'required' => 'Masukkan nama depan Anda!',
        'min_length' => 'Masukkan nama depan Anda minimal 2 karakter!',
        'max_length' => 'Masukkan nama depan Anda maksimal 20 karakter!'
      ]
    ],
    'lastname' => [
      'rules' => 'required|alpha|min_length[2]|max_length[20]',
      'errors' => [
        'alpha' => 'Masukkan nama belakang Anda hanya karakter huruf!',
        'required' => 'Masukkan nama belakang Anda!',
        'min_length' => 'Masukkan nama belakang Anda minimal 2 karakter!',
        'max_length' => 'Masukkan nama belakang Anda maksimal 20 karakter!'
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

  public $updatePassword = [
    'currentPassword' => [
      'rules' => 'required',
      'errors' => [
        'required' => 'Masukkan kata sandi Anda saat ini!'
      ]
    ],
    'newPassword' => [
      'rules' => 'required|min_length[8]|checkPasswordStrength',
      'errors' => [
        'required' => 'Masukkan kata sandi baru Anda!',
        'min_length' => 'Masukkan kata sandi baru Anda minimal 8 karakter!',
        'checkPasswordStrength' => 'Kata sandi baru Anda harus mengandung minimal 1 karakter huruf besar, kecil dan angka!'
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

  public $newPasswordEqualToCurrentPassword = 'Kata sandi baru tidak boleh sama dengan kata sandi Anda saat ini!';
  public $currentPasswordWrong = 'Kata sandi saat ini yang Anda masukkan tidak cocok dengan kata sandi Anda saat ini!';
}