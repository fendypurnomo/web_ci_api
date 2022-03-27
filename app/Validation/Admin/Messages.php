<?php

namespace App\Validation\Admin;

class Messages
{
  public $createMessage = [
    'name' => [
      'rules' => 'required|max_length[50]',
      'errors' => [
        'required' => 'Masukkan nama Anda!',
        'max_length' => 'Masukkan nama Anda maksimal 50 karakter!'
      ]
    ],
    'email' => [
      'rules' => 'required|valid_email',
      'errors' => [
        'required' => 'Masukkan email Anda!',
        'valid_email' => 'Email yang Anda masukkan tidak valid!'
      ]
    ],
    'subject' => [
      'rules' => 'required|max_length[100]',
      'errors' => [
        'required' => 'Masukkan subjek pesan Anda!',
        'max_length' => 'Masukkan subjek pesan Anda maksimal 100 karakter!'
      ]
    ],
    'content' => [
      'rules' => 'required|min_length[20]',
      'errors' => [
        'required' => 'Masukkan isi pesan Anda!',
        'min_length' => 'Masukkan isi pesan minimal 20 karakter!'
      ]
    ]
  ];
}