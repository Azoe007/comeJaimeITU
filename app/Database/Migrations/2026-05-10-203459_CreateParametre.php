<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateParametre extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'prix_gold' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'duree_gold' => [
                'type' => 'INT',
            ],
            'reduction_gold' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('parametres');
    }

    public function down()
    {
        $this->forge->dropTable('parametres');
    }
}
