<?php

namespace App\Validation\Admin\Wilayah;

class Provinsi
{
    public $tambahProvinsi = [
        'kode_provinsi' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Masukkan Kode Provinsi!'
            ]
        ],
        'nama_provinsi' => [
            'rules' => 'required|min_length[3]',
            'errors' => [
                'required' => 'Masukkan Nama Provinsi!',
                'min_length' => 'Masukkan Nama Provinsi minimal 3 karakter!'
            ]
        ]
    ];
}
