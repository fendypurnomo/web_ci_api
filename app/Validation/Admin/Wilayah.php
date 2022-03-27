<?php

namespace App\Validation\Admin;

class Wilayah
{
  public $provinsi = [
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

  public $kabupatenKota = [
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

  public $kecamatan = [
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

  public $kelurahanDesa = [
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