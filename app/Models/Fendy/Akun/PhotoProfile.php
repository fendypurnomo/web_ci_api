<?php

namespace App\Models\Fendy\Akun;

class PhotoProfile extends \CodeIgniter\Model
{
  protected $table      = 'tabel_foto_profil';
  protected $primaryKey = 'foto_id';
  protected $returnType = 'object';

  protected $allowedFields = [
    'foto_nama',
    'foto_tgl_dibuat',
    'foto_tgl_diperbarui',
    'foto_aktif',
    'pengguna_id'
  ];
}
