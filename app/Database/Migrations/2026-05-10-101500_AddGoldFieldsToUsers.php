<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddGoldFieldsToUsers extends Migration
{
    public function up()
    {
        if (! $this->db->fieldExists('est_gold', 'users')) {
            $this->forge->addColumn('users', [
                'est_gold' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'default' => 0,
                ],
            ]);
        }

        if (! $this->db->fieldExists('gold_expires_at', 'users')) {
            $this->forge->addColumn('users', [
                'gold_expires_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
            ]);
        }
    }

    public function down()
    {
        if ($this->db->fieldExists('gold_expires_at', 'users')) {
            $this->forge->dropColumn('users', 'gold_expires_at');
        }

        if ($this->db->fieldExists('est_gold', 'users')) {
            $this->forge->dropColumn('users', 'est_gold');
        }
    }
}
