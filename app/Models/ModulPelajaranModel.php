<?php

namespace App\Models;

use CodeIgniter\Model;

class ModulPelajaranModel extends Model
{
    protected $table = 'modul_pelajaran';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useAutoIncrement = true;
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $allowedFields = [
        'judul',
        'slug',
        'deskripsi',
        'gambar',
        'urutan',
        'status',
    ];

    public function getModulAktif()
    {
        return $this->where('status', 'aktif')
            ->orderBy('urutan', 'ASC')
            ->orderBy('id', 'ASC')
            ->findAll();
    }

    public function getModulArsip()
    {
        return $this->where('status', 'arsip')
            ->orderBy('updated_at', 'DESC')
            ->findAll();
    }

    public function arsipkan(int $id): bool
    {
        return $this->update($id, ['status' => 'arsip']);
    }

    public function pulihkan(int $id): bool
    {
        return $this->update($id, ['status' => 'aktif']);
    }

    public function getModulDenganMateri(int $id): ?array
    {
        $modul = $this->find($id);

        if ($modul === null) {
            return null;
        }

        $materiModel = new MateriPelajaranModel();

        $modul['materi'] = $materiModel
            ->where('modul_id', $id)
            ->orderBy('urutan', 'ASC')
            ->orderBy('id', 'ASC')
            ->findAll();

        return $modul;
    }
}
