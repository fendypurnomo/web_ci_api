<?php

function getRequest(): object
{
    $input = request()->getJSON(true);

    if (empty($input)) {
        $input = request()->getPost();
        if (empty($input)) {
            $input = request()->getRawInput();
        }
    }
    return (object) $input;
}

function getRequestQueryParam(string $parameter): string
{
    $request = request()->getGet($parameter);

    if (!isset($request) || isset($request) && empty($request) || $request === null) {
        throw new \RuntimeException('Terjadi kesalahan. Permintaan Anda tidak dapat kami proses!');
    }
    return $request;
}

function getRequestQueryParamPagination()
{
    $page = request()->getGet('page');
    $perPage = request()->getGet('perPage');

    if (!isset($page) || isset($page) && empty($page) || $page === null) {
        $page = (int) 1;
    }

    if (!isset($perPage) || isset($perPage) && empty($perPage) || $perPage === null) {
        $perPage = (int) 10;
    }

    if ($perPage > 100) {
        throw new \RuntimeException('Jumlah data per halaman yang Anda masukkan melebihi batas maksimal!');
    }
    return (object) ['page' => (int) $page, 'perPage' => (int) $perPage];
}

function request()
{
    return \Config\Services::request();
}
