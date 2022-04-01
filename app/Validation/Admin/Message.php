<?php

namespace App\Validation\Admin;

class Message
{
    public $createMessage = [
        'name' => [
            'rules' => 'required|max_length[5]|max_length[50]',
            'errors' => [
                'required' => 'Masukkan nama Anda!',
                'max_length' => 'Masukkan nama Anda minimal 5 karakter!',
                'max_length' => 'Masukkan nama Anda maksimal 50 karakter!'
            ]
        ],
        'subject' => [
            'rules' => 'required|min_length[5]|max_length[100]',
            'errors' => [
                'required' => 'Masukkan subjek pesan Anda!',
                'min_length' => 'Masukkan subjek pesan Anda minimal 5 karakter!',
                'max_length' => 'Masukkan subjek pesan Anda maksimal 100 karakter!'
            ]
        ],
        'email' => [
            'rules' => 'required|valid_email',
            'errors' => [
                'required' => 'Masukkan e-mail Anda!',
                'valid_email' => 'E-mail yang Anda masukkan tidak valid!'
            ]
        ],
        'content' => [
            'rules' => 'required|min_length[20]',
            'errors' => [
                'required' => 'Masukkan isi pesan Anda!',
                'min_length' => 'Masukkan isi pesan Anda minimal 20 karakter!'
            ]
        ]
    ];
}
