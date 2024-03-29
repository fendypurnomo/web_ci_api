<?php

namespace App\Controllers\Fendy\Admin\User;

use Exception;

class UserPhoto extends \App\Controllers\BaseController
{
    protected $model;
    protected $rules;

    public function __construct()
    {
        $this->model = new \App\Models\Fendy\User\UserPhoto;
        $this->rules = new \App\Validation\Admin\User\UserPhoto;
    }

    /**
     * --------------------------------------------------
     * Get current photo profile
     * --------------------------------------------------
     */
    public function getCurrentPhotoProfile(int $userID = null, string $type = 'array')
    {
        $photo = $this->model->getCurrentPhotoProfile($userID);

        if ($type === 'string') {
            return $photo;
        }
        return \Config\Services::response()->setJSON(['photo' => $photo]);
    }

    /**
     * --------------------------------------------------
     * Get collect photo profile
     * --------------------------------------------------
    */
    public function getAllPhotoProfile(int $userID = null)
    {
        try {
            $request = \Config\Services::request();
            $page = $request->getGet('page');
            $data = $this->model->getAllPhotoProfile($userID, $page);
            return \Config\Services::response()->setJSON($data);
        }
        catch (Exception $e) {
            return \Config\Services::response()->setJSON(['success' => false, 'messages' => $e->getMessage()]);
        }
    }

    /**
     * --------------------------------------------------
     * Upload photo profile
     * --------------------------------------------------
    */
    public function uploadPhotoProfile()
    {
        try {
            if (! $this->validate($this->rules->uploadPhotoProfile)) {
                return \Config\Services::response()->setJSON([
                    'success' => false,
                    'error' => 'badRequest',
                    'messsages' => $this->validator->getErrors()
                ]);
            }

            $request = \Config\Services::request();
            $img = $request->getFile('img');

            if (! $img->isValid() && $img->hasMoved()) {
                throw new \RuntimeException($img->getErrorString() . '(' . $img->getError() . ')');
            }

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
        catch (Exception $e) {
            return \Config\Services::response()->setJSON(['success' => false, 'messages' => $e->getMessage()]);
        }
    }
}
