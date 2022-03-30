<?php

namespace App\Controllers\Fendy\Auth;

use Exception;

class Recovery extends \App\Controllers\Fendy\BaseAuthController
{
  protected $rules;

  public function __construct()
  {
    parent::__construct();
    $this->rules = new \App\Validation\Auth\Recovery;
  }

  // Check user email address
  public function checkEmailAddress()
  {
    if ($this->validate($this->rules->checkEmailAddress)) {
      $row = $this->model->where('pengguna_email', getRequest()->email)->first();
      $OTPCode = random_string('numeric', 6);

      $this->model->update($row->pengguna_id, ['pengguna_kode_otp' => $OTPCode]);

      // sendmail([
      // 	'email'    => $input['email'],
      // 	'subject'  => 'Permintaan setel ulang kata sandi',
      // 	'messages' => 'Kami kirimkan kode OTP untuk setel ulang kata sandi Anda. Masukkan Kode OTP:' . $OTPCode
      // ]);

      $accessToken = createToken([
        'id' => $row->pengguna_id,
        'email' => $row->pengguna_email,
        'isEmailVerified' => true
      ], 300);

      return $this->respond([
        'success' => true,
        'status' => 200,
        'isEmailVerified' => true,
        'accessToken' => $accessToken,
        'messages' => 'Permintaan setel ulang kata sandi berhasil. Buka pesan baru email Anda dan masukkan kode OTP yang telah Kami kirim'
      ]);
    }

    return $this->respond([
      'success' => false,
      'error' => 'badRequest',
      'messages' => $this->validator->getErrors()
    ]);
  }

  // Check user OTP Code validation
  public function checkOTPCode()
  {
    try {
      if ($this->validate($this->rules->checkOTPCode)) {
        $post = getRequest();
        $token = getRequestQueryParam('token');
        $decode = decodeToken($token);
        $data = $decode->data;
        $isEmailVerified = $data->isEmailVerified;

        if ($isEmailVerified) {
          if ($this->model->where(['pengguna_email' => $decode->data->email, 'pengguna_kode_otp' => $post->otp])->first()) {
            $accessToken = createToken([
              'id' => $decode->data->id,
              'email' => $decode->data->email,
              'otp' => $post->otp,
              'isEmailVerified' => true,
              'isOTPVerified' => true
            ], 300);

            return $this->respond([
              'success' => true,
              'status' => 200,
              'isOTPVerified' => 'OTP_CODE_VERIFIED',
              'accessToken' => $accessToken,
              'messages' => 'Verifikasi Kode OTP berhasil'
            ]);
          }

          throw new \RuntimeException($this->rules->checkOTPCodeInvalid);
        }

        throw new \RuntimeException($this->rules->errorTokenInvalid);
      }

      return $this->respond([
        'success' => false,
        'error' => 'badRequest',
        'messages' => $this->validator->getErrors()
      ]);
    }
    catch (Exception $e) {
      return $this->respond(['success' => false, 'messages' => $e->getMessage()]);
    }
  }

  // Reset password user
  public function createNewPassword()
  {
    try {
      if ($this->validate($this->rules->createNewPassword)) {
        $post = getRequest();
        $token = getRequestQueryParam('token');
        $decode = decodeToken($token);
        $data = $decode->data;
        $isEmailVerified = $data->isEmailVerified;
        $isOTPVerified = $data->isOTPVerified;

        if ($isEmailVerified && $isOTPVerified) {
          if ($row = $this->model->where(['pengguna_email' => $data->email, 'pengguna_kode_otp' => $data->otp])->first()) {
            $this->model->update($row->pengguna_id, ['pengguna_sandi' => $post->newPassword, 'pengguna_kode_otp' => null]);

            return $this->respondUpdated([
              'success' => true,
              'status' => 200,
              'messages' => 'Kata sandi berhasil di setel ulang'
            ]);
          }

          throw new \RuntimeException($this->rules->createNewPasswordFailed);
        }

        throw new \RuntimeException($this->rules->errorTokenInvalid);
      }

      return $this->respond([
        'success' => false,
        'error' => 'badRequest',
        'messages' => $this->validator->getErrors()
      ]);
    }
    catch (Exception $e) {
      return $this->respond(['success' => false, 'messages' => $e->getMessage()]);
    }
  }
}