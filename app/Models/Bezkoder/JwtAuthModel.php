<?php

namespace App\Models\Bezkoder;

use CodeIgniter\Model;

class JwtAuthModel extends Model
{
	protected $table			= 'bezkoder_jwt_auth_web_api';
	protected $primaryKey	= 'id';
	protected $returnType	= 'array';

	protected $allowedFields = [
		'username',
		'email',
		'password'
	];
}
