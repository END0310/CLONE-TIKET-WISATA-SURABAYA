<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTiketWisataTahap1 extends Migration
{
    public function up()
    {
        // 1. website_profile
        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'site_name' => ['type' => 'VARCHAR', 'constraint' => 150],
            'agency_name' => ['type' => 'VARCHAR', 'constraint' => 255],
            'tagline' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'description' => ['type' => 'TEXT', 'null' => true],
            'logo' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'hero_image' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'address' => ['type' => 'TEXT', 'null' => true],
            'phone' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'email' => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('website_profile', true);

        // 2. navigation_menu
        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'website_profile_id' => ['type' => 'INT', 'unsigned' => true],
            'parent_id' => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'title' => ['type' => 'VARCHAR', 'constraint' => 100],
            'url' => ['type' => 'VARCHAR', 'constraint' => 255, 'default' => '#'],
            'sort_order' => ['type' => 'INT', 'default' => 0],
            'is_active' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('website_profile_id', 'website_profile', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('navigation_menu', true);

        // 3. banners
        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'website_profile_id' => ['type' => 'INT', 'unsigned' => true],
            'title' => ['type' => 'VARCHAR', 'constraint' => 150],
            'subtitle' => ['type' => 'TEXT', 'null' => true],
            'image_url' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'button_text' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'button_url' => ['type' => 'VARCHAR', 'constraint' => 255, 'default' => '#'],
            'is_active' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('website_profile_id', 'website_profile', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('banners', true);

        // 4. destination_categories
        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'name' => ['type' => 'VARCHAR', 'constraint' => 100],
            'description' => ['type' => 'TEXT', 'null' => true],
            'is_active' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('destination_categories', true);

        // 5. tourism_destinations
        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'category_id' => ['type' => 'INT', 'unsigned' => true],
            'name' => ['type' => 'VARCHAR', 'constraint' => 200],
            'slug' => ['type' => 'VARCHAR', 'constraint' => 220],
            'description' => ['type' => 'TEXT'],
            'location' => ['type' => 'TEXT', 'null' => true],
            'image_url' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'status' => ['type' => 'VARCHAR', 'constraint' => 30, 'default' => 'Buka'],
            'is_featured' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('slug');
        $this->forge->addForeignKey('category_id', 'destination_categories', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('tourism_destinations', true);

        // 6. visit_schedules
        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'destination_id' => ['type' => 'INT', 'unsigned' => true],
            'day_name' => ['type' => 'VARCHAR', 'constraint' => 30],
            'open_time' => ['type' => 'TIME', 'null' => true],
            'close_time' => ['type' => 'TIME', 'null' => true],
            'quota' => ['type' => 'INT', 'default' => 100],
            'is_closed' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('destination_id', 'tourism_destinations', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('visit_schedules', true);

        // 7. ticket_types
        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'destination_id' => ['type' => 'INT', 'unsigned' => true],
            'name' => ['type' => 'VARCHAR', 'constraint' => 100],
            'description' => ['type' => 'TEXT', 'null' => true],
            'price' => ['type' => 'DECIMAL', 'constraint' => '12,2', 'default' => 0],
            'is_active' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('destination_id', 'tourism_destinations', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('ticket_types', true);

        // 8. terms_and_conditions
        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'destination_id' => ['type' => 'INT', 'unsigned' => true],
            'content' => ['type' => 'TEXT'],
            'sort_order' => ['type' => 'INT', 'default' => 0],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('destination_id', 'tourism_destinations', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('terms_and_conditions', true);

        // 9. static_pages
        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'website_profile_id' => ['type' => 'INT', 'unsigned' => true],
            'title' => ['type' => 'VARCHAR', 'constraint' => 150],
            'slug' => ['type' => 'VARCHAR', 'constraint' => 180],
            'content' => ['type' => 'TEXT'],
            'is_active' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('slug');
        $this->forge->addForeignKey('website_profile_id', 'website_profile', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('static_pages', true);

        // 10. footer_links
        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'website_profile_id' => ['type' => 'INT', 'unsigned' => true],
            'title' => ['type' => 'VARCHAR', 'constraint' => 100],
            'url' => ['type' => 'VARCHAR', 'constraint' => 255, 'default' => '#'],
            'group_name' => ['type' => 'VARCHAR', 'constraint' => 100, 'default' => 'Lainnya'],
            'sort_order' => ['type' => 'INT', 'default' => 0],
            'is_active' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('website_profile_id', 'website_profile', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('footer_links', true);

        // 11. social_media
        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'website_profile_id' => ['type' => 'INT', 'unsigned' => true],
            'platform' => ['type' => 'VARCHAR', 'constraint' => 100],
            'username' => ['type' => 'VARCHAR', 'constraint' => 150],
            'url' => ['type' => 'VARCHAR', 'constraint' => 255, 'default' => '#'],
            'icon' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'is_active' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('website_profile_id', 'website_profile', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('social_media', true);

        // 12. contact_infos
        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'website_profile_id' => ['type' => 'INT', 'unsigned' => true],
            'type' => ['type' => 'VARCHAR', 'constraint' => 50],
            'label' => ['type' => 'VARCHAR', 'constraint' => 150],
            'value' => ['type' => 'VARCHAR', 'constraint' => 255],
            'is_active' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('website_profile_id', 'website_profile', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('contact_infos', true);
    }

    public function down()
    {
        $this->forge->dropTable('contact_infos', true);
        $this->forge->dropTable('social_media', true);
        $this->forge->dropTable('footer_links', true);
        $this->forge->dropTable('static_pages', true);
        $this->forge->dropTable('terms_and_conditions', true);
        $this->forge->dropTable('ticket_types', true);
        $this->forge->dropTable('visit_schedules', true);
        $this->forge->dropTable('tourism_destinations', true);
        $this->forge->dropTable('destination_categories', true);
        $this->forge->dropTable('banners', true);
        $this->forge->dropTable('navigation_menu', true);
        $this->forge->dropTable('website_profile', true);
    }
}
