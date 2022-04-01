<?php

namespace App\Validation\Admin\Blog;

class Category
{
    public $createCategory = [
        'name' => [
            'rules' => 'required|min_length[5]|max_length[50]',
            'errors' => [
                'required' => 'Masukkan nama kategori!',
                'min_length' => 'Masukkan nama kategori minimal 5 karakter!',
                'max_length' => 'Masukkan nama kategori maksimal 50 karakter!'
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
