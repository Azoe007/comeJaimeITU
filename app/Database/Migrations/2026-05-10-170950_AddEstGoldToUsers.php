<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddEstGoldToUsers extends Migration
{
    public function up()
    {
        $fields = [
            'est_gold' => [
                'type'      => 'TINYINT',
                'constraint'=> 1,
                'default'   => 0,
                'after'     => 'role_id',
            ],
        ];

        $this->forge->addColumn('users', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'est_gold');
    }
}