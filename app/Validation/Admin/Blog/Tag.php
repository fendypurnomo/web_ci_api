<?php

namespace App\Validation\Admin\Blog;

class Tag
{
    public $createTag = [
        'name' => [
            'rules' => 'required|min_length[5]',
            'errors' => [
                'required' => 'Masukkan nama tag!',
                'min_length' => 'Masukkan nama tag minimal 5 karakter!'
            ]
        ]
    ];
}
