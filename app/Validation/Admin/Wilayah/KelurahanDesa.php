<?php

namespace App\Validation\Admin\Wilayah;

class KelurahanDesa
{
    public $tambahKelurahanDesa = [
        'kode_kecamatan' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Masukkan Kode Kecamatan!'
            ]
        ],
        'kode_kel_desa' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Masukkan Kode Kelurahan/Desa!'
            ]
        ],
        'nama_kel_desa' => [
            'rules' => 'required|min_length[3]',
            'errors' => [
                'required' => 'Masukkan Nama Kelurahan/Desa!',
                'min_length' => 'Masukkan Nama Kelurahan/Desa minimal 3 karakter!'
            ]
        ],
        'kode_jenis' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Masukkan Kode Jenis Kelurahan atau Desa!'
            ]
        ]
    ];
}
