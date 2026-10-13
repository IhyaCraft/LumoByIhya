<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class EnsureModulPelajaranTable extends Migration
{
    public function up()
    {
        if ($this->db->tableExists('modul_pelajaran')) {
            return;
        }

        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'judul' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
            ],
            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => 160,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'gambar' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'urutan' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'default' => 0,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['aktif', 'arsip'],
                'default' => 'aktif',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('slug', 'uq_modul_pelajaran_slug');
        $this->forge->createTable('modul_pelajaran');
    }

    public function down()
    {
    }
}
