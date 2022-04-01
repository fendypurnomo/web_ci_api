<?php

namespace App\Validation\Auth;

class Activation
{
    public $activation = [
        'email' => [
            'rules' => 'required|valid_email|is_not_unique[tabel_pengguna.pengguna_email]',
            'errors' => [
                'required' => 'Masukkan alamat e-mail Anda!',
                'valid_email' => 'E-mail yang Anda masukkan tidak valid!',
                'is_not_unique' => 'E-mail yang Anda masukkan tidak dapat kami temukan!'
            ]
        ]
    ];

    public $accountHasActivated = [
        'success' => false,
        'error' => 'accountHasActivated',
        'messages' => 'Anda telah melakukan aktivasi akun sebelumnya!'
    ];
}
