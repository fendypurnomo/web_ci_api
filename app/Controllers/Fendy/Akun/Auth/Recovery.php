<?php

namespace App\Controllers\Fendy\Akun\Auth;

use Exception;

class Recovery extends \App\Controllers\Fendy\BaseAccountController
{
  /**
   * Index recovery account
   */
  public function index()
  {
    try {
      $request = getQueryParamRequest('req');

      if ($request === 'checkEmailAddress') {
        return $this->checkEmailAddress();
      } elseif ($request === 'checkOTPCode') {
        return $this->checkOTPCode();
      } elseif ($request === 'createNewPassword') {
        return $this->createNewPassword();
      } else {
        return $this->failNotFound($this->requestNotFound);
      }
    } catch (Exception $e) {
      return $this->fail($e->getMessage());
    }
  }

  /**
   * Check user email address
   */
  private function checkEmailAddress()
  {
    if ($this->validate($this->rules->checkEmailAddress)) {
      $row     = $this->model->where('pengguna_email', getRequest()->email)->first();
      $OTPCode = random_string('numeric', 6);

      $this->model->update($row->pengguna_id, ['pengguna_kode_otp' => $OTPCode]);

      // sendmail([
      // 	'email'    => $input['email'],
      // 	'subject'  => 'Permintaan setel ulang kata sandi',
      // 	'messages' => 'Kami kirimkan kode OTP untuk setel ulang kata sandi Anda. Masukkan Kode OTP:' . $OTPCode
      // ]);

      $accessToken = createToken([
        'id'              => $row->pengguna_id,
        'email'           => $row->pengguna_email,
        'isEmailVerified' => true
      ], 300);

      return $this->respond([
        'success'         => true,
        'status'          => 200,
        'isEmailVerified' => 'EMAIL_VERIFIED',
        'accessToken'     => $accessToken,
        'message'         => 'Permintaan setel ulang kata sandi berhasil. Buka pesan baru email Anda dan masukkan kode OTP yang telah Kami kirim'
      ]);
    }
    return $this->fail($this->validator->getErrors());
  }

  /**
   * Check user OTP Code validation
   */
  private function checkOTPCode()
  {
    try {
      if ($this->validate($this->rules->checkOTPCode)) {
        $decode = decodeToken(getQueryParamRequest('token'));

        if ($decode->data->isEmailVerified) {
          $post = getRequest();

          if ($this->model->where(['pengguna_email' => $decode->data->email, 'pengguna_kode_otp' => $post->otp])->first()) {
            $accessToken = createToken([
              'id'              => $decode->data->id,
              'email'           => $decode->data->email,
              'otp'             => $post->otp,
              'isEmailVerified' => true,
              'isOTPVerified'   => true
            ], 300);

            return $this->respond([
              'success'       => true,
              'status'        => 200,
              'isOTPVerified' => 'OTP_CODE_VERIFIED',
              'accessToken'   => $accessToken,
              'message'       => 'Verifikasi Kode OTP berhasil'
            ]);
          }
          return $this->fail($this->authOtpInvalid);
        }
        return $this->fail($this->authOtpFailed);
      }
      return $this->fail($this->validator->getErrors());
    } catch (Exception $e) {
      return $this->fail($e->getMessage());
    }
  }

  /**
   * Reset password user
   */
  private function createNewPassword()
  {
    try {
      if ($this->validate($this->rules->createNewPassword)) {
        $decode = decodeToken(getQueryParamRequest('token'));
        $data = $decode->data;

        if ($data->isEmailVerified && $data->isOTPVerified) {
          if ($row = $this->model->where(['pengguna_email' => $data->email, 'pengguna_kode_otp' => $data->otp])->first()) {
            $this->model->update($row->pengguna_id, ['pengguna_sandi' => getRequest()->newPassword, 'pengguna_kode_otp' => null]);

            return $this->respondUpdated([
              'success' => true,
              'status'  => 200,
              'message' => 'Kata sandi berhasil di setel ulang'
            ]);
          }
          return $this->fail($this->authOtpInvalid);
        }
        return $this->fail($this->tokenInvalid);
      }
      return $this->fail($this->validator->getErrors());
    } catch (Exception $e) {
      return $this->fail($e->getMessage());
    }
  }
}
