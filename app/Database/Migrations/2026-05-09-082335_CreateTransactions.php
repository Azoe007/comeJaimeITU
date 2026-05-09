<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTransactions extends Migration
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
            'id_programme' => [ // LIEN VERS LE PROGRAMME CHOISI
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true, // Peut être null si c'est une recharge simple
            ],
            'montant' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'reduction' => [
                'type'       => 'FLOAT',
                'default'    => 0, // 15% pour les membres Gold 
            ],
            'etat' => [
                'type'       => 'VARCHAR',
                'constraint' => '50', // 'en cours', 'valide', 'echec'
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_user', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_programme', 'programmes', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('transactions');
    }

    public function down()
    {
        $this->forge->dropTable('transactions');
    }
}