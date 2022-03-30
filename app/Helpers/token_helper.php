<?php

use Firebase\JWT\JWT;

function createToken(array $data, int $ttl = 3600): string
{
  $issuedAtTime = time();
  $notBefore = $issuedAtTime + 10;
  $timeToLive = $ttl;
  $expiration = $issuedAtTime + $timeToLive;

  return JWT::encode(
    [
      'iat' => $issuedAtTime,
      'nbf' => $notBefore,
      'exp' => $expiration,
      'data' => $data
    ],
    getenv('jwt.secretKey')
  );
}

function getToken(): string
{
  $authorization = \Config\Services::request()->getServer('HTTP_AUTHORIZATION');

  if (is_null($authorization)) {
    throw new \RuntimeException('Permintaan Anda tidak dapat kami proses. Anda tidak memiliki akses token yang valid!');
  }

  return explode(' ', $authorization)[1];
}

function decodeToken(string $token): object
{
  return JWT::decode($token, getenv('jwt.secretKey'), ['HS256']);
}

function checkIDUserToken(int $id)
{
  $model = new App\Models\Fendy\User\User();
  $query = $model->find($id);

  if (!$query) {
    throw new \RuntimeException('Maaf, kami tidak dapat menemukan akun Anda!');
  }

  return $query;
}

function checkUserToken(): object
{
  $token = getToken();
  $decodeToken = decodeToken($token);
  $user = checkIDUserToken($decodeToken->data->id);
  return $user;
}