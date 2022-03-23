<?php

use Config\Services;

function getRequest(): object
{
  $request = Services::request();
  $input   = $request->getJSON(true);

  if (empty($input)) {
    $input = $request->getPost();

    if (empty($input)) {
      $input = $request->getRawInput();
    }
  }

  return (object) $input;
}

function getQueryParamRequest(string $parameter): string
{
  $request = Services::request()->getGet($parameter);

  if (!isset($request) || isset($request) && empty($request) || $request === null) {
    throw new Exception('Terjadi kesalahan. Permintaan Anda tidak dapat kami proses!');
  }

  return (string) $request;
}

function getQueryParamPagination(): object
{
  $page    = Services::request()->getGet('page');
  $perPage = Services::request()->getGet('perPage');

  if (!isset($page) || isset($page) && empty($page) || $page === null) {
    $page = (int) 1;
  }
  if (!isset($perPage) || isset($perPage) && empty($perPage) || $perPage === null || $perPage > 100) {
    $perPage = (int) 5;
  }

  return (object) ['page' => (int) $page, 'perPage' => (int) $perPage];
}
