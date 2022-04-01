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
            //     'email' => $input['email'],
            //     'subject' => 'Permintaan setel ulang kata sandi',
            //     'messages' => 'Kami kirimkan kode OTP untuk setel ulang kata sandi Anda. Masukkan Kode OTP:' . $OTPCode
            // ]);

            $accessToken = createToken([
                'id' => $row->pengguna_id,
                'email' => $row->pengguna_email,
                'step' => 2
            ], 300);

            return $this->respond([
                'success' => true,
                'status' => 200,
                'isEmailVerified' => 'EMAIL_VERIFIED',
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

                if ($data->step !== 2) {
                    throw new \RuntimeException($this->rules->errorTokenInvalid);
                }

                $query = $this->model->where(['pengguna_email' => $decode->data->email, 'pengguna_kode_otp' => $post->otp])->first();

                if (! $query) {
                    throw new \RuntimeException($this->rules->checkOTPCodeInvalid);
                }

                $accessToken = createToken([
                    'id' => $decode->data->id,
                    'email' => $decode->data->email,
                    'otp' => $post->otp,
                    'step' => 3
                ], 300);

                return $this->respond([
                    'success' => true,
                    'status' => 200,
                    'isOTPVerified' => 'OTP_CODE_VERIFIED',
                    'accessToken' => $accessToken,
                    'messages' => 'Verifikasi Kode OTP berhasil'
                ]);
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

                if ($data->step !== 3) {
                    throw new \RuntimeException($this->rules->errorTokenInvalid);
                }

                $query = $this->model->where(['pengguna_email' => $data->email, 'pengguna_kode_otp' => $data->otp])->first();

                if (! $query) {
                    throw new \RuntimeException($this->rules->createNewPasswordFailed);
                }

                $this->model->update($query->pengguna_id, ['pengguna_sandi' => $post->newPassword, 'pengguna_kode_otp' => null]);

                return $this->respondUpdated([
                    'success' => true,
                    'status' => 200,
                    'messages' => 'Kata sandi berhasil di setel ulang'
                ]);
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
