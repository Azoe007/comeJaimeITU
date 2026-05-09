<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStatutCode extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'=> [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'etat'=> [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('statutcodes');
    }

    public function down()
    {
        $this->forge->dropTable('statutcodes');
    }
}