<?php

namespace App\Validation\Admin\User;

class Userphoto
{
  public $uploadPhotoProfile = [
    'img' => [
      'rules' => 'uploaded[img]|max_size[img,1024]|ext_in[img,png,jpg,jpeg,gif]|is_image[img]',
      'errors' => [
        'uploaded' => 'Masukkan berkas foto profil Anda!',
        'max_size' => 'Ukuran berkas foto maksimal 1MB!',
        'ext_in' => 'Ektensi berkas foto harus png, jpg/jpeg atau gif!'
      ]
    ]
  ];
}