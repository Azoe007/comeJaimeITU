<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateConfigRegime extends Migration
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
            'id_regime' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'duree_jours' => [
                'type' => 'INT',
            ],
            'prix' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_regime', 'regimes', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('config_regime');
    }

    public function down()
    {
        $this->forge->dropTable('config_regime');
    }
}