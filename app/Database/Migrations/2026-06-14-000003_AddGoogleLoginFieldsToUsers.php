<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddGoogleLoginFieldsToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'google_id' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'after' => 'email',
            ],
            'avatar' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'role',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', ['google_id', 'avatar']);
    }
}
