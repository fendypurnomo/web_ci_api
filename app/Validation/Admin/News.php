<?php

namespace App\Validation\Admin;

class News
{
  public $createNews = [
    'category' => [
      'rules' => 'required',
      'errors' => [
        'required' => 'Masukkan kategori berita!'
      ]
    ],
    'user' => [
      'rules' => 'required',
      'errors' => [
        'required' => 'Masukkan nama Editor berita!'
      ]
    ],
    'title' => [
      'rules' => 'required|min_length[5]|max_length[100]',
      'errors' => [
        'required' => 'Masukkan judul berita!',
        'min_length' => 'Masukkan judul berita minimal 5 karakter!',
        'max_length' => 'Masukkan judul berita maksimal 100 karakter!'
      ]
    ],
    'content' => [
      'rules' => 'required|min_length[50]',
      'errors' => [
        'required' => 'Masukkan isi konten berita!',
        'min_length' => 'Masukkan isi berita minimal 50 karakter!'
      ]
    ],
    'img' => [
      'rules' => 'required',
      'errors' => [
        'required' => 'Masukkan gambar thumbnail berita!'
      ]
    ],
    'headline' => [
      'rules' => 'required',
      'errors' => [
        'required' => 'Masukkan headline berita!'
      ]
    ],
    'tag' => [
      'rules' => 'required|min_length[5]|max_length[100]',
      'errors' => [
        'required' => 'Masukkan tag berita!',
        'min_length' => 'Masukkan tag berita minimal 5 karakter!',
        'max_length' => 'Masukkan tag berita maksimal 100 karakter!'
      ]
    ]
  ];
}