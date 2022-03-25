<?php

namespace App\Models\Bezkoder;

use CodeIgniter\Model;

class CrudModel extends Model
{
  protected $table = 'table_bezkoder_crud_web_api';
  protected $primaryKey = 'id';
  protected $returnType = 'array';
  protected $allowedFields = ['title', 'description', 'published'];
}