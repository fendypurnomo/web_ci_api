<?php

namespace App\Controllers\Fendy\Akun;

class Photoprofile extends \CodeIgniter\Controller
{
  private $id;
  private $model;

  public $currentPhotoProfile;
  public $collectPhotoProfile = [];

  public function __construct($id = null)
  {
    $this->id = $id;
    $this->model = new \App\Models\Fendy\Akun\PhotoProfile();
  }

  public function getCurrentPhotoProfile(): string
  {
    $query = $this->model->where(['pengguna_id' => $this->id, 'foto_aktif' => 1])->first();
    return $this->currentPhotoProfile = $query ? $query->foto_nama : 'default.png';
  }

  public function getCollectPhotoProfile(): array
  {
    $query = $this->model->where('pengguna_id', $this->id)->findAll();

    if ($query) {
      foreach ($query as $row) {
        $data[] = [
          $row->foto_id,
          getenv('app.imgURL') . 'profiles/' . $row->foto_nama
        ];
      }
      return $this->collectPhotoProfile = $data;
    }

    return \Config\Services::response()->setJSON(['messages' => 'Tidak ada foto profil']);
  }
}