
<?php

namespace App\Models;

use CodeIgniter\Model;

class MateriPelajaranModel extends Model
{
    protected $table = 'materi_pelajaran';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useAutoIncrement = true;
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $allowedFields = [
        'modul_id',
        'judul',
        'slug',
        'tipe_konten',
        'konten',
        'gambar',
        'urutan',
    ];

    public function getMateriModul(int $modulId): array
    {
        return $this->where('modul_id', $modulId)
            ->orderBy('urutan', 'ASC')
            ->orderBy('id', 'ASC')
            ->findAll();
    }

    public function getMateriDenganModul(int $id): ?array
    {
        return $this->select('materi_pelajaran.*, modul_pelajaran.judul AS judul_modul, modul_pelajaran.slug AS slug_modul')
            ->join('modul_pelajaran', 'modul_pelajaran.id = materi_pelajaran.modul_id')
            ->where('materi_pelajaran.id', $id)
            ->first();
    }

    public function getMateriBerdasarkanSlug(int $modulId, string $slug): ?array
    {
        return $this->where('modul_id', $modulId)
            ->where('slug', $slug)
            ->first();
    }
}
