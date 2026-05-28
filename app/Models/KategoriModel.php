<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $table      = 'kategori_tempat';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = ['nama', 'icon'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = false; // tabel tidak punya updated_at
}