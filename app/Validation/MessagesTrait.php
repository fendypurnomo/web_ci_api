<?php

namespace App\Validation;

trait MessagesTrait
{
  protected $pageNotFound = 'Permintaan Anda tidak dapat kami proses. Laman tidak dapat kami temukan!';
  protected $tokenInvalid = 'Terjadi kesalahan. Token Anda tidak valid!';
  protected $requestNotFound = 'Terjadi kesalahan. Permintaan Anda tidak dapat kami proses!';
  protected $requestCantProcessed = 'Teradi kesalahan. Permintaan Anda gagal kami proses!';

  /* Table Messages */
  protected $tableRecordEmpty = 'Tidak ada data!';
  protected $tableRecordNotFound = 'Data tidak dapat ditemukan!';
}