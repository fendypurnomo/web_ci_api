<?php

namespace App\Controllers\Fendy\Admin\Akun;

use Exception;

class Userphoto extends \App\Controllers\BaseController {
  protected $model;
  protected $rules;

  public function __construct()
  {
    $this->model = new \App\Models\Fendy\Akun\Userphoto;
    $this->rules = new \App\Validation\Admin\Userphoto;
  }

  // Get current photo profile
  public function getCurrentPhotoProfile(int $userID = null, $type = 'array')
  {
    $photo = $this->model->getCurrentPhotoProfile($userID);
    if ($type === 'string') {
      return $photo;
    }
    return \Config\Services::response()->setJSON(['photo' => $photo]);
  }

  // Get collect photo profile
  public function getAllPhotoProfile(int $userID = null)
  {
    try {
      $request = \Config\Services::request();
      $page = $request->getGet('page');
      $data = $this->model->getAllPhotoProfile($userID, $page);
      return \Config\Services::response()->setJSON($data);
    }
    catch (Exception $e) {
      return \Config\Services::response()->setJSON([
        'success' => false,
        'messages' => $e->getMessage()
      ]);
    }
  }

  // Upload photo profile
  public function uploadPhotoProfile()
  {
    try {
      if ($this->validate($this->rules->uploadPhoto)) {
        $request = \Config\Services::request();
        $img = $request->getFile('img');
  
        if ($img->isValid() && !$img->hasMoved()) {
          $filepath = '../../../../../../../Pictures/Images/profiles/';
          $newName = $img->getRandomName();
          $userID = checkUserToken()->pengguna_id;
          $img->move($filepath, $newName);
          $this->model->uploadPhotoProfile($userID, $newName);
          return \Config\Services::response()->setJSON([
            'success' => true,
            'status' => 200,
            'messages' => 'Unggah foto profil berhasil'
          ]);
        }
        throw new \RuntimeException($img->getErrorString() . '(' . $img->getError() . ')');
      }
      return \Config\Services::response()->setJSON([
        'success' => false,
        'error' => 'badRequest',
        'messsages' => $this->validator->getErrors()
      ]);
    }
    catch (Exception $e) {
      return \Config\Services::response()->setJSON([
        'success' => false,
        'messages' => $e->getMessage()
      ]);
    }
  }
}