<?php

namespace App\Models\Fendy\User;

class UserPhoto extends \CodeIgniter\Model
{
  protected $table = 'tabel_foto_profil';
  protected $primaryKey = 'foto_id';
  protected $returnType = 'object';
  protected $allowedFields = ['foto_nama', 'foto_tgl_dibuat', 'foto_tgl_diperbarui', 'foto_aktif', 'pengguna_id'];

  public function getCurrentPhotoProfile(int $userID) {
    $query = $this->where(['pengguna_id' => $userID, 'foto_aktif' => 1])->first();
    $photo = $query ? $query->foto_nama : 'default.png';
    return getenv('app.imgURL') . 'profiles/' . $photo;
  }

  public function getAllPhotoProfile(int $userID, int $page) {
    $query = $this->where('pengguna_id', $userID)->paginate(10, '', $page);
    
    if (! $query) throw new \RuntimeException('Tidak ada foto profil!');

    $totalRecords = $this->countAll();
    $totalPages = ceil($totalRecords / $page);

    foreach ($query as $row) {
      $data[] = [
        'photo_id' => $row->foto_id,
        'photo_name' => getenv('app.imgURL') . 'profiles/' . $row->foto_nama
      ];
    }

    $response = [
      'data' => $data,
      'page' => $page,
      'totalPages' => $totalPages,
      'totalRecords' => $totalRecords
    ];
    return $response;
  }

  public function uploadPhotoProfile($userID, $newName) {
    $this->insert(['pengguna_id' => $userID, 'foto_nama' => $newName, 'foto_aktif' => 1]);
    $this->where('pengguna_id = ' . $userID . ' AND foto_id != ' . $this->getInsertID())->set(['foto_aktif' => 0])->update();
  }
}