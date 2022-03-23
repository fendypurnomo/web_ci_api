<?php

namespace App\Validation;

class Wilayah
{
  public $provinsi	= [
    'kode_provinsi' => [
      'rules'  => 'required',
      'errors' => [
        'required' => 'Masukkan Kode Provinsi!'
      ]
    ],
    'nama_provinsi' => [
      'rules'  => 'required',
      'errors' => [
        'required' => 'Masukkan Nama Provinsi!'
      ]
    ]
  ];

  public $kabupatenKota	= [
    'kode_provinsi' => [
      'rules'  => 'required',
      'errors' => [
        'required' => 'Masukkan Kode Provinsi!'
      ]
    ],
    'kode_kab_kota' => [
      'rules'  => 'required',
      'errors' => [
        'required' => 'Masukkan Kode Kabupaten/Kota!'
      ]
    ],
    'nama_kab_kota' => [
      'rules'  => 'required',
      'errors' => [
        'required' => 'Masukkan Nama Kabupaten/Kota!'
      ]
    ],
    'kode_jenis' => [
      'rules'  => 'required',
      'errors' => [
        'required' => 'Masukkan Kode Jenis Kabupaten atau Kota!'
      ]
    ]
  ];

  public $kecamatan	= [
    'kode_kab_kota' => [
      'rules'  => 'required',
      'errors' => [
        'required' => 'Masukkan Kode Kabupaten/Kota!'
      ]
    ],
    'kode_kecamatan' => [
      'rules'  => 'required',
      'errors' => [
        'required' => 'Masukkan Kode Kecamatan!'
      ]
    ],
    'nama_kecamatan' => [
      'rules'  => 'required',
      'errors' => [
        'required' => 'Masukkan Nama Kecamatan!'
      ]
    ]
  ];

  public $kelurahanDesa	= [
    'kode_kecamatan' => [
      'rules'  => 'required',
      'errors' => [
        'required' => 'Masukkan Kode Kecamatan!'
      ]
    ],
    'kode_kel_desa' => [
      'rules'  => 'required',
      'errors' => [
        'required' => 'Masukkan Kode Kelurahan/Desa!'
      ]
    ],
    'nama_kel_desa' => [
      'rules'  => 'required',
      'errors' => [
        'required' => 'Masukkan Nama Kelurahan/Desa!'
      ]
    ],
    'kode_jenis' => [
      'rules'  => 'required',
      'errors' => [
        'required' => 'Masukkan Kode Jenis Kelurahan atau Desa!'
      ]
    ]
  ];
}
