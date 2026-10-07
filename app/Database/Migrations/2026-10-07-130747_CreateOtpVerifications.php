<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOtpVerifications extends Migration
{
    public function up()
    {
        if ($this->db->tableExists('otp_verifications')) {
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
            'otp_hash' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'type' => [
                'type' => 'VARCHAR',
                'constraint' => 30
            ],
            'expires_at' => [
                'type' => 'DATETIME'
            ],
            'attempts' => [
                'type' => 'TINYINT',
                'constraint' => 3,
                'unsigned' => true,
                'default' => 0
            ],
            'verified_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('user_id');

        $this->forge->createTable('otp_verifications');
    }

    public function down()
    {
        if ($this->db->tableExists('otp_verifications')) {
            return;
        }
    }
}
