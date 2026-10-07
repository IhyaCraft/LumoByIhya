<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRememberTokens extends Migration
{
    public function up()
    {
        if ($this->db->tableExists('remember_tokens')) {
            return;
        }

        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true
            ],
            'token_hash' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'expires_at' => [
                'type' => 'DATETIME'
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('user_id');

        $this->forge->createTable('remember_tokens');
    }

    public function down()
    {
        if ($this->db->tableExists('remember_tokens')) {
            return;
        }
    }
}