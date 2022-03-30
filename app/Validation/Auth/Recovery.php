<?php

namespace App\Validation\Auth;

class Recovery
{
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

  public $checkOTPCodeInvalid	= 'Kode OTP yang Anda masukkan tidak valid!';
  public $createNewPasswordFailed = 'Terjadi kesalahan. Data Anda tidak dapat kami temukan, permintaan Anda tidak dapat diproses!';
  public $errorTokenInvalid = 'Terjadi kesalahan. Token Anda tidak valid, permintaan Anda tidak dapat diproses!';
}