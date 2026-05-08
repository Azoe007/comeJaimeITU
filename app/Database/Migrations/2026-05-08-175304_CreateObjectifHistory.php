<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateObjectifHistory extends Migration
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
            'id_objectif' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'poids_kg' => [
                'type' => 'FLOAT',
            ],
            'taille_cm' => [
                'type' => 'FLOAT',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_user', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_objectif', 'objectifs', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('objectif_history');
    }

    public function down()
    {
        $this->forge->dropTable('objectif_history');
    }
}