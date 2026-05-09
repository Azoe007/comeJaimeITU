<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRegimes extends Migration
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
            'viande' => [
                'type' => 'FLOAT', // Pourcentage
            ],
            'poisson' => [
                'type' => 'FLOAT', // Pourcentage
            ],
            'volaille' => [
                'type' => 'FLOAT', // Pourcentage
            ],
            'variation' => [
                'type' => 'FLOAT', // en kilo
            ],
            'duree' => [
                'type' => 'INT', // En jours
            ],
            'type' => [
                'type' => 'ENUM',
                'constraint' => ['augmentation', 'diminution'],
                'default' => 'augmentation',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('regimes');
    }

    public function down()
    {
        $this->forge->dropTable('regimes');
    }
}
