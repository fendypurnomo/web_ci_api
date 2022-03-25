<?php

namespace App\Validation;

class Messages
{
  public $createMessage = [
    'name' => [
      'rules'  => 'required',
      'errors' => [
        'required' => 'Masukkan nama Anda!'
      ]
    ],
    'email' => [
      'rules'  => 'required|valid_email',
      'errors' => [
        'required'    => 'Masukkan email Anda!',
        'valid_email' => 'Email yang Anda masukkan tidak valid!'
      ]
    ],
    'subject' => [
      'rules'  => 'required',
      'errors' => [
        'required' => 'Masukkan subjek pesan!'
      ]
    ],
    'content' => [
      'rules'  => 'required|min_length[20]',
      'errors' => [
        'required'   => 'Masukkan isi pesan Anda!',
        'min_length' => 'Masukkan isi pesan minimal 20 karakter!'
      ]
    ]
  ];
}