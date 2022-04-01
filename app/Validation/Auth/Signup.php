<?php

namespace App\Validation\Auth;

class Signup
{
    public $signup = [
        'firstname' => [
            'rules' => 'required|alpha|min_length[2]|max_length[20]',
            'errors' => [
                'required' => 'Masukkan nama depan Anda!',
                'alpha' => 'Masukkan hanya karakter huruf!',
                'min_length' => 'Masukkan nama depan minimal 2 karakter!',
                'max_length' => 'Masukkan nama depan maksimal 20 karakter!'
            ]
        ],
        'lastname' => [
            'rules' => 'required|alpha|min_length[2]|max_length[20]',
            'errors' => [
                'required' => 'Masukkan nama belakang Anda!',
                'alpha' => 'Masukkan hanya karakter huruf!',
                'min_length' => 'Masukkan nama belakang minimal 2 karakter!',
                'max_length' => 'Masukkan nama belakang maksimal 20 karakter!'
            ]
        ],
        'email' => [
            'rules' => 'required|valid_email|is_unique[tabel_pengguna.pengguna_email]',
            'errors' => [
                'required' => 'Masukkan e-mail Anda!',
                'valid_email' => 'Email yang Anda masukkan tidak valid',
                'is_unique' => 'Email yang Anda masukkan sudah terdaftar, ganti dengan email lain!'
            ]
        ],
        'password' => [
            'rules' => 'required|min_length[8]|checkPasswordStrength',
            'errors' => [
                'required' => 'Masukkan kata sandi Anda!',
                'min_length' => 'Kata sandi minimal 8 karakter',
                'checkPasswordStrength' => 'Kata sandi harus mengandung minimal 1 karakter huruf besar, kecil dan angka!'
            ]
        ],
        'confirmPassword' => [
            'rules' => 'required|matches[password]',
            'errors' => [
                'required' => 'Masukkan konfirmasi kata sandi Anda!',
                'matches' => 'Konfirmasi kata sandi tidak cocok!'
            ]
        ],
        'gender' => [
            'rules' => 'required|is_natural|greater_than_equal_to[1]|less_than_equal_to[2]',
            'errors' => [
                'required' => 'Pilih jenis kelamin Anda!',
                'is_natural' => 'Masukkan hanya karakter angka!',
                'greater_than_equal_to' => 'Kode jenis kelamin adalah 1 = Laki-laki dan 2 = Perempuan',
                'less_than_equal_to' => 'Kode jenis kelamin adalah 1 = Laki-laki dan 2 = Perempuan'
            ]
        ]
    ];
}
