<?php

namespace App\Validation\Auth;

class Activation
{
	public $accountHasActivated = [
		'success' => false,
		'error' => 'accountHasActivated',
		'messages' => 'Anda telah melakukan aktivasi akun sebelumnya!'
	];
}