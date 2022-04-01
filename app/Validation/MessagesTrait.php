<?php

namespace App\Validation;

trait MessagesTrait
{
    protected $pageNotFound = 'Permintaan Anda tidak dapat kami proses. Laman tidak dapat kami temukan!';
    protected $tokenInvalid = 'Terjadi kesalahan. Token Anda tidak valid!';

    /* Request */
    protected $requestNotFound = [
        'success' => false,
        'messages' => 'Terjadi kesalahan. Permintaan Anda tidak dapat kami proses!'
    ];

    protected $requestCantProcessed = 'Terjadi kesalahan. Permintaan Anda gagal kami proses!';

    /* Table Messages */
    protected $tableRecordEmpty = [
        'success' => false,
        'messages' => 'Tidak ada data!'
    ];

    protected $tableRecordNotFound = [
        'success' => false,
        'messages' => 'Data tidak dapat ditemukan!'
    ];
}
