<?php

namespace App\Validation\Admin\Wilayah;

class KabupatenKota
{
    public $tambahKabupatenKota = [
        'kode_provinsi' => [
            'rules' => 'required|min_length[3]',
            'errors' => [
                'required' => 'Masukkan Kode Provinsi!'
            ]
        ],
        'kode_kab_kota' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Masukkan Kode Kabupaten/Kota!'
            ]
        ],
        'nama_kab_kota' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Masukkan Nama Kabupaten/Kota!',
                'min_length' => 'Masukkan Nama Kabupaten/Kota minimal 3 karakter!'
            ]
        ],
        'kode_jenis' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Masukkan Kode Jenis Kabupaten atau Kota!'
            ]
        ]
    ];
}
