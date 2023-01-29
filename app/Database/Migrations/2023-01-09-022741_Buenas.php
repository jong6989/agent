<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Buenas extends Migration
{
    public function up()
    {
        //accounts 
        $fields = [
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '120',
                'unique'     => true,
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
                'default'    => '',
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
                'default'    => '',
            ],
            'commission' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'code' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'default'    => '',
            ],
            'operator' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'default'    => '',
            ],
            'super_agent' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'default'    => '',
            ],
            'address' => [
                'type'       => 'VARCHAR',
                'constraint' => 300,
                'default'    => '',
            ],
            'online' => [
                'type'       => 'BOOLEAN',
                'default'    => false,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['active', 'banned', 'deleted','new'],
                'default'    => 'new',
            ],
            'access' => [
                'type'       => 'ENUM',
                'constraint' => ['agent','super_agent', 'operator', 'admin','super_admin'],
                'default'    => 'agent',
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ];
        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey(['id', 'username']);
        $this->forge->createTable('accounts', true);

        //inported data
        $fields = [
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'BET_TIME' => [
                'type'       => 'TEXT',
                'default'    => '',
            ],
            'TRANSACTION_ID' => [
                'type'       => 'TEXT',
                'default'    => '',
            ],
            'PLAYER_ID' => [
                'type'       => 'TEXT',
                'default'    => '',
            ],
            'CHANNEL_TYPE' => [
                'type'       => 'TEXT',
                'default'    => '',
            ],
            'BET_AMOUNT' => [
                'type'       => 'DOUBLE',
                'default'    => 0,
            ],
            'PAYOUT' => [
                'type'       => 'DOUBLE',
                'default'    => 0,
            ],
            'REFUND' => [
                'type'       => 'DOUBLE',
                'default'    => 0,
            ],
            'GROSS_GAMING_REVENUE' => [
                'type'       => 'DOUBLE',
                'default'    => 0,
            ],
            'completed' => [
                'type'       => 'BOOLEAN',
                'default'    => false,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ];
        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('transactions', true);

        //commission
        $fields = [
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'account_id' => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
                'default'    => '',
            ],
            'amount' => [
                'type'       => 'DOUBLE',
                'default'    => 0,
            ],
            'transaction' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
                'default'    => '',
            ],
            'created_at datetime default current_timestamp',
        ];
        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('commission', true);

        //player
        $fields = [
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'player_id' => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
                'default'    => '',
            ],
            'operator' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'default'    => '',
            ],
            'super_agent' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'default'    => '',
            ],
            'agent' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'default'    => '',
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
                'default'    => '',
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
                'default'    => '',
            ],
            'created_at datetime default current_timestamp',
        ];
        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('commission', true);
    }

    public function down()
    {
        //
    }
}
