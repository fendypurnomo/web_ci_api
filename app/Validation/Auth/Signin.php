<?php

namespace App\Validation\Auth;

class Signin
{
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

  public $accountWrongPassword = [
    'success' => false,
    'error' => 'accountWrongPassword',
    'messages' => [
      'password' => 'Kata sandi yang Anda masukkan salah!'
    ]
  ];

  public $accountBlocked = [
    'success' => false,
    'error' => 'accountBlocked',
    'messages' => [
      'username' => 'Akun Anda telah diblokir untuk sementara!'
    ]
  ];

  public $accountHasNotBeenActivated = [
    'success' => false,
    'error' => 'accountHasNotBeenActivated',
    'messages' => [
      'username' => 'Anda belum melakukan aktivasi akun!'
    ]
  ];

  public $accountNotFound = [
    'success' => false,
    'error' => 'accountNotFound',
    'messages' => [
      'username' => 'Akun Anda tidak dapat kami temukan!'
    ]
  ];
}