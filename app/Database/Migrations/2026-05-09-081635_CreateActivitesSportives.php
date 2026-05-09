<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateActivitesSportives extends Migration
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
            'description' => [
                'type' => 'TEXT',
            ],
            'diminution_poids' => [
                'type' => 'FLOAT',
            ],
            'frequence' => [
                'type' => 'INT', // fois par semaine
            ],
            'duree' => [
                'type' => 'INT', // jours
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('activites_sportives');
    }

    public function down()
    {
        $this->forge->dropTable('activites_sportives');
    }
}