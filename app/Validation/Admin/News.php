<?php

namespace App\Validation\Admin;

class News
{
  public $createNews = [
    'category' => [
      'rules' => 'required',
      'errors' => [
        'required' => 'Masukkan kategori berita'
      ]
    ],
    'title' => [
      'rules' => 'required|min_length[5]',
      'errors' => [
        'required' => 'Masukkan judul berita',
        'min_length' => ''
      ]
    ],
    'content' => [
      'rules' => 'required|min_length[50]',
      'errors' => [
        'required' => 'Masukkan isi konten berita',
        'min_length' => ''
      ]
    ],
    'img' => [
      'rules' => 'required',
      'errors' => [
        'required' => 'Masukkan gambar thumbnil berita'
      ]
    ],
    'headline' => [
      'rules' => 'required',
      'errors' => [
        'required' => 'Masukkan headline berita'
      ]
    ],
    'tag' => [
      'rules' => 'required|min_length[5]',
      'errors' => [
        'required' => 'Masukkan tag berita',
        'min_length' => ''
      ]
    ]
  ];
}