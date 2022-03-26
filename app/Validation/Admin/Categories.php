<?php

namespace App\Validation\Admin;

class Categories
{
  public $createCategory = [
    'name' => [
      'rules' => 'required',
      'errors' => [
        'required' => 'Masukkan nama kategori!'
      ]
    ],
    'seo' => [
      'rules' => 'required',
      'errors' => [
        'required' => 'Masukkan seo kategori!'
      ]
    ],
    'active' => [
      'rules' => 'required',
      'errors' => [
        'required' => 'Pilih kategori aktif!'
      ]
    ]
  ];
}