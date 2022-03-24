<?php

namespace App\Libraries;

trait MessagesTrait
{
  protected $pageNotFound = 'Permintaan Anda tidak dapat kami proses. Laman tidak dapat kami temukan!';
  protected $tokenInvalid = 'Terjadi kesalahan. Token Anda tidak valid!';
  protected $requestNotFound = 'Terjadi kesalahan. Permintaan Anda tidak dapat kami proses!';
  protected $requestCantProcessed = 'Teradi kesalahan. Permintaan Anda gagal kami proses!';

  /* Auth Messages */
  // Signin messages
  protected $authWrongPassword = [
    'success' => false,
    'error' => 'wrongPassword',
    'messages' => [
      'password' => 'Kata sandi yang Anda masukkan salah!'
    ]
  ];
  protected $authBlocked = [
    'success' => false,
    'error' => 'accountBlocked',
    'messages' => [
      'username' => 'Akun Anda telah diblokir untuk sementara!'
    ]
  ];
  protected $authNotActivated = [
    'success' => false,
    'error' => 'accountHasNotBeenActivated',
    'messages' => [
      'username' => 'Anda belum melakukan aktivasi akun!'
    ]
  ];
  protected $authNotFound = [
    'success' => false,
    'error' => 'accountNotFound',
    'messages' => [
      'username' => 'Akun Anda tidak dapat kami temukan!'
    ]
  ];

  // Recovery account messages
  protected $authOtpInvalid	= [
    'success' => false,
    'error' => 'invalidOTPCode',
    'message' => 'Kode OTP yang Anda masukkan tidak valid!'
  ];
  protected $authOtpFailed = [
    'success' => false,
    'error' => 'failed',
    'message' => 'Terjadi kesalahan. Permintaan Anda tidak dapat diproses!'
  ];
  protected $createNewPasswordFailed = [
    'success' => false,
    'error' => 'failed',
    'message' => 'Terjadi kesalahan. Permintaan Anda tidak dapat diproses!'
  ];

  // Activate account messages
  protected $authHasActivated = 'Anda telah melakukan aktivasi akun sebelumnya!';

  /* Account Messages */
  // Change password messages
  protected $accountNewEqualOldPassword = [
    'errors' => 'newPasswordSameOldPassword',
    'field'  => [
      'newPassword' => 'Kata sandi baru tidak boleh sama dengan kata sandi lama Anda!'
    ]
  ];
  protected $accountOldPasswordInvalid = [
    'errors' => 'oldPasswordNotValid',
    'field'  => [
      'oldPassword' => 'Kata sandi lama yang Anda masukkan tidak cocok dengan kata sandi Anda saat ini!'
    ]
  ];

  /* Table Messages */
  protected $tableRecordEmpty    = 'Tidak ada data!';
  protected $tableRecordNotFound = 'Data tidak dapat ditemukan!';
}