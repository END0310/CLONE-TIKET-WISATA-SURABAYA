<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePrototypeTahap2To8 extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'booking_code' => ['type' => 'VARCHAR', 'constraint' => 40],
            'destination_id' => ['type' => 'INT', 'unsigned' => true],
            'ticket_type_id' => ['type' => 'INT', 'unsigned' => true],
            'visitor_name' => ['type' => 'VARCHAR', 'constraint' => 150],
            'visitor_email' => ['type' => 'VARCHAR', 'constraint' => 150],
            'visitor_phone' => ['type' => 'VARCHAR', 'constraint' => 50],
            'visit_date' => ['type' => 'DATE'],
            'visit_day' => ['type' => 'VARCHAR', 'constraint' => 30],
            'visit_time' => ['type' => 'TIME'],
            'quantity' => ['type' => 'INT', 'default' => 1],
            'ticket_price' => ['type' => 'DECIMAL', 'constraint' => '12,2', 'default' => 0],
            'total_price' => ['type' => 'DECIMAL', 'constraint' => '12,2', 'default' => 0],
            'booking_status' => ['type' => 'VARCHAR', 'constraint' => 30, 'default' => 'pending'],
            'payment_status' => ['type' => 'VARCHAR', 'constraint' => 30, 'default' => 'unpaid'],
            'notes' => ['type' => 'TEXT', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('booking_code');
        $this->forge->addForeignKey('destination_id', 'tourism_destinations', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('ticket_type_id', 'ticket_types', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('bookings', true);

        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'booking_id' => ['type' => 'INT', 'unsigned' => true],
            'payment_code' => ['type' => 'VARCHAR', 'constraint' => 40],
            'payment_method' => ['type' => 'VARCHAR', 'constraint' => 50],
            'payment_amount' => ['type' => 'DECIMAL', 'constraint' => '12,2', 'default' => 0],
            'payment_status' => ['type' => 'VARCHAR', 'constraint' => 30, 'default' => 'paid'],
            'paid_at' => ['type' => 'DATETIME', 'null' => true],
            'proof_image' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('booking_id');
        $this->forge->addUniqueKey('payment_code');
        $this->forge->addForeignKey('booking_id', 'bookings', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('payments', true);

        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'booking_id' => ['type' => 'INT', 'unsigned' => true],
            'ticket_code' => ['type' => 'VARCHAR', 'constraint' => 50],
            'qr_code_text' => ['type' => 'VARCHAR', 'constraint' => 100],
            'ticket_status' => ['type' => 'VARCHAR', 'constraint' => 30, 'default' => 'active'],
            'issued_at' => ['type' => 'DATETIME', 'null' => true],
            'used_at' => ['type' => 'DATETIME', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('booking_id');
        $this->forge->addUniqueKey('ticket_code');
        $this->forge->addForeignKey('booking_id', 'bookings', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('e_tickets', true);

        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'booking_id' => ['type' => 'INT', 'unsigned' => true],
            'cancellation_code' => ['type' => 'VARCHAR', 'constraint' => 50],
            'reason' => ['type' => 'TEXT'],
            'cancellation_status' => ['type' => 'VARCHAR', 'constraint' => 30, 'default' => 'requested'],
            'requested_at' => ['type' => 'DATETIME', 'null' => true],
            'approved_at' => ['type' => 'DATETIME', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('booking_id');
        $this->forge->addUniqueKey('cancellation_code');
        $this->forge->addForeignKey('booking_id', 'bookings', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('cancellations', true);

        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'question' => ['type' => 'VARCHAR', 'constraint' => 255],
            'answer' => ['type' => 'TEXT'],
            'sort_order' => ['type' => 'INT', 'default' => 0],
            'is_active' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('faqs', true);

        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'name' => ['type' => 'VARCHAR', 'constraint' => 150],
            'email' => ['type' => 'VARCHAR', 'constraint' => 150],
            'phone' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'subject' => ['type' => 'VARCHAR', 'constraint' => 200],
            'message' => ['type' => 'TEXT'],
            'status' => ['type' => 'VARCHAR', 'constraint' => 30, 'default' => 'new'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('contact_messages', true);

        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'name' => ['type' => 'VARCHAR', 'constraint' => 150],
            'email' => ['type' => 'VARCHAR', 'constraint' => 150],
            'password' => ['type' => 'VARCHAR', 'constraint' => 255],
            'role' => ['type' => 'VARCHAR', 'constraint' => 30, 'default' => 'admin'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('email');
        $this->forge->createTable('users', true);
    }

    public function down()
    {
        $this->forge->dropTable('users', true);
        $this->forge->dropTable('contact_messages', true);
        $this->forge->dropTable('faqs', true);
        $this->forge->dropTable('cancellations', true);
        $this->forge->dropTable('e_tickets', true);
        $this->forge->dropTable('payments', true);
        $this->forge->dropTable('bookings', true);
    }
}
