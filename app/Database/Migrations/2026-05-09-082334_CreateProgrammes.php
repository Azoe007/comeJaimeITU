<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProgrammes extends Migration
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
            'id_user' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'id_regime' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'id_activite1' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'id_activite2' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'prix_total' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'date_debut' => [
                'type' => 'DATE',
            ],
            'date_fin' => [
                'type' => 'DATE',
            ],
            'duree_jours' => [
                'type' => 'INT',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        
        // Clés étrangères
        $this->forge->addForeignKey('id_user', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_regime', 'regimes', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_activite1', 'activites_sportives', 'id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('id_activite2', 'activites_sportives', 'id', 'SET NULL', 'CASCADE');

        $this->forge->createTable('programmes');
    }

    public function down()
    {
        $this->forge->dropTable('programmes');
    }
}