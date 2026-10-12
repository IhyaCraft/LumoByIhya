<?php

namespace App\Models;

use CodeIgniter\Model;

class ProgresPelajaranModel extends Model
{
    protected $table         = 'progres_pelajaran';
    protected $primaryKey    = 'id_progres';
    protected $returnType    = 'array';
    protected $allowedFields = [
        'id',
        'slug_pelajaran',
        'skor',
        'selesai',
    ];
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
