<?php

namespace App\Validation\Admin\Blog;

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
            'rules' => 'uploaded[img]|is_image[img]|mime_in[img,image/jpg,image/jpeg,image/gif,image/png,image/webp]|max_size[img,1024]|max_dims[img,1024,768]',
            'errors' => [
                'uploaded' => 'Masukkan ilustrasi gambar berita!',
                'mime_in' => 'Format gambar yang Anda masukkan tidak valid!',
                'max_size' => 'Ukuran maksimal gambar adalah 1MB!',
                'max_dims' => 'Dimensi gambar maksimal 1024 x 768 pixel!'
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
