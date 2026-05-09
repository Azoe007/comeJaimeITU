<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCode extends Migration
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
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true, 
            ],
            'id_statut_code' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'type' => [
                'type'       => 'ENUM',
                'constraint' => ['Promo', 'Gold'],
                'default'    => 'Promo',
            ],
            'valeur_en_ar' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0.00,
            ],
            'code' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'unique'     => true,
            ],
            'date_usage' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_user', 'users', 'id', 'CASCADE');
        $this->forge->addForeignKey('id_statut_code', 'statutcodes', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('codes');
    }

    public function down()
    {
        $this->forge->dropTable('codes');
    }
}