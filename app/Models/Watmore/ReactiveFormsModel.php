<?php

namespace App\Models\Watmore;

use CodeIgniter\Model;

class ReactiveFormsModel extends Model
{
  protected $table = 'watmore_crud_reactive_forms';
  protected $primaryKey = 'id';
  protected $returnType = 'array';
  protected $allowedFields = ['title', 'firstName', 'lastName', 'email', 'role', 'password'];
}