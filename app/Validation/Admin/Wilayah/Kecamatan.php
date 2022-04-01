<?php

namespace App\Validation\Admin\Wilayah;

class Kecamatan
{
    public $tambahKecamatan = [
        'kode_kab_kota' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Masukkan Kode Kabupaten/Kota!'
            ]
        ],
        'kode_kecamatan' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Masukkan Kode Kecamatan!'
            ]
        ],
        'nama_kecamatan' => [
            'rules' => 'required|min_length[3]',
            'errors' => [
                'required' => 'Masukkan Nama Kecamatan!',
                'min_length' => 'Masukkan Nama Kecamatan minimal 3 karakter!'
            ]
        ]
    ];
}
