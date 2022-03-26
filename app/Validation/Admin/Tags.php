<?php

namespace App\Validation\Admin;

class Tags
{	
  public $createTag = [
    'name' => [
      'rules' => 'required',
      'errors' => [
        'required' => 'Masukkan nama tag!'
      ]
    ],
    'seo' => [
      'rules' => 'required',
      'errors' => [
        'required' => 'Masukkan seo tag'
      ]
    ]
  ];
}