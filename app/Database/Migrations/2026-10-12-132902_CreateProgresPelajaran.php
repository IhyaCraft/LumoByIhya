<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProgresPelajaran extends Migration
{
    public function up()
    {
        $this->forge->addField([
            
            'id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'slug_pelajaran' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'skor' => [
                'type'       => 'INT',
                'constraint' => 3,
                'unsigned'   => true,
                'default'    => 0,
            ],
            'selesai' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
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
        $this->forge->addUniqueKey(['id_user', 'slug_pelajaran']);

        $this->forge->createTable('progres_pelajaran');
    }

    public function down()
    {
        $this->forge->dropTable('progres_pelajaran');
    }
}
