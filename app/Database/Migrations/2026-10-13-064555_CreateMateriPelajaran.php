<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMateriPelajaran extends Migration
{
    public function up()
    {
        if ($this->db->tableExists('materi_pelajaran')) {
            return;
        }

        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'modul_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
            ],
            'judul' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
            ],
            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => 160,
            ],
            'tipe_konten' => [
                'type' => 'ENUM',
                'constraint' => ['teks', 'interaktif'],
                'default' => 'teks',
            ],
            'konten' => [
                'type' => 'LONGTEXT',
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
        $this->forge->addUniqueKey(
            ['modul_id', 'slug'],
            'uq_materi_modul_slug'
        );
        $this->forge->addKey('modul_id');

        $this->forge->addForeignKey(
            'modul_id',
            'modul_pelajaran',
            'id',
            'CASCADE',
            'RESTRICT'
        );

        $this->forge->createTable('materi_pelajaran');
    }

    public function down()
    {
    }
}
