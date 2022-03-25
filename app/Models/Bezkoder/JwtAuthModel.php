<?php

namespace App\Models\Bezkoder;

use CodeIgniter\Model;

class JwtAuthModel extends Model
{
  protected $table = 'table_bezkoder_jwt_auth_web_api';
  protected $primaryKey = 'id';
  protected $returnType = 'array';
  protected $allowedFields = ['username', 'email', 'password'];
}