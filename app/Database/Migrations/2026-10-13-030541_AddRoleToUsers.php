
<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRoleToUsers extends Migration
{
    public function up()
    {
        if (
            $this->db->tableExists('users')
            && !$this->db->fieldExists('role', 'users')
        ) {
            $this->forge->addColumn('users', [
                'role' => [
                    'type'       => 'ENUM',
                    'constraint' => ['siswa', 'admin'],
                    'default'    => 'siswa',
                ],
            ]);
        }
    }

    public function down()
    {
        if (
            $this->db->tableExists('users')
            && $this->db->fieldExists('role', 'users')
        ) {
            $this->forge->dropColumn('users', 'role');
        }
    }
}
