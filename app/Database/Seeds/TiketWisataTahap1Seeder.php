<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TiketWisataTahap1Seeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        // Agar seeder bisa dijalankan ulang tanpa error foreign key.
        $this->db->disableForeignKeyChecks();
        $tables = [
            'cancellations',
            'e_tickets',
            'payments',
            'bookings',
            'contact_messages',
            'contact_infos',
            'social_media',
            'footer_links',
            'static_pages',
            'terms_and_conditions',
            'ticket_types',
            'visit_schedules',
            'tourism_destinations',
            'destination_categories',
            'banners',
            'navigation_menu',
            'website_profile',
        ];

        foreach ($tables as $table) {
            if ($this->db->tableExists($table)) {
                $this->db->table($table)->truncate();
            }
        }

        $this->db->enableForeignKeyChecks();

        $this->db->table('website_profile')->insert([
            'site_name' => 'Tiket Wisata Surabaya',
            'agency_name' => 'Dinas Kebudayaan, Kepemudaan dan Olahraga serta Pariwisata Pemerintah Kota Surabaya',
            'tagline' => 'Budaya Baru Berwisata Di Kota Surabaya',
            'description' => 'Aplikasi Tiket Wisata Surabaya hadir sebagai solusi bagi masyarakat untuk menikmati obyek wisata Kota Surabaya dengan kemudahan informasi pemesanan tiket berbasis online.',
            'logo' => null,
            'hero_image' => 'https://images.unsplash.com/photo-1563807894768-f28bee0d37b6?q=80&w=1600&auto=format&fit=crop',
            'address' => 'Jl. Tunjungan No. 1-3, Kel. Genteng, Kec. Genteng, Surabaya, Jawa Timur 60275',
            'phone' => '081553870855',
            'email' => 'disbudporapar@surabaya.go.id',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $profileId = $this->db->insertID();

        $menus = [
            ['Beranda', '/', 1],
            ['Harga Tiket', '#', 2],
            ['Cara Pesan Tiket', '#', 3],
            ['FAQ', '#', 4],
            ['Kontak Kami', '#', 5],
            ['Tiket Masif', '#', 6],
            ['Pembatalan Tiket', '#', 7],
        ];

        foreach ($menus as $menu) {
            $this->db->table('navigation_menu')->insert([
                'website_profile_id' => $profileId,
                'parent_id' => null,
                'title' => $menu[0],
                'url' => $menu[1],
                'sort_order' => $menu[2],
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $this->db->table('banners')->insertBatch([
            [
                'website_profile_id' => $profileId,
                'title' => 'Budaya Baru Berwisata Di Kota Surabaya',
                'subtitle' => 'Rencanakan kunjungan wisata Anda dengan mudah dan nyaman.',
                'image_url' => 'https://images.unsplash.com/photo-1563807894768-f28bee0d37b6?q=80&w=1600&auto=format&fit=crop',
                'button_text' => 'Jelajahi Wisata',
                'button_url' => '/destinations',
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'website_profile_id' => $profileId,
                'title' => 'Nikmati Wisata Kota Surabaya',
                'subtitle' => 'Temukan museum, wisata kota, pantai, dan destinasi pilihan lainnya.',
                'image_url' => 'https://images.unsplash.com/photo-1578922746465-3a80a228f223?q=80&w=1600&auto=format&fit=crop',
                'button_text' => 'Lihat Destinasi',
                'button_url' => '/destinations',
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        $categoryData = [
            'Pantai dan Hiburan' => 'Destinasi wisata rekreasi, hiburan, dan kawasan pantai.',
            'Museum' => 'Destinasi wisata edukasi dan sejarah di Kota Surabaya.',
            'Wisata Kota' => 'Destinasi wisata kota, monumen, dan tur keliling Surabaya.',
        ];

        $categoryIds = [];
        foreach ($categoryData as $name => $description) {
            $this->db->table('destination_categories')->insert([
                'name' => $name,
                'description' => $description,
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            $categoryIds[$name] = $this->db->insertID();
        }

        $destinations = [
            ['Pantai dan Hiburan', 'Taman Hiburan Pantai Kenjeran', 'taman-hiburan-pantai-kenjeran', 'Taman Hiburan Pantai Kenjeran merupakan destinasi rekreasi keluarga yang menawarkan suasana pantai, area bermain, dan pemandangan kawasan pesisir Surabaya.', 'Jl. Pantai Kenjeran, Surabaya', 'https://placehold.co/900x600?text=Taman+Hiburan+Pantai+Kenjeran', 'Buka', 15000],
            ['Museum', 'Museum Sepuluh Nopember', 'museum-sepuluh-nopember', 'Museum Sepuluh Nopember menyajikan informasi sejarah perjuangan Arek-Arek Suroboyo dan peristiwa bersejarah 10 November.', 'Kompleks Tugu Pahlawan, Surabaya', 'https://placehold.co/900x600?text=Museum+Sepuluh+Nopember', 'Buka', 8000],
            ['Museum', 'Museum Dr. Soetomo', 'museum-dr-soetomo', 'Museum Dr. Soetomo merupakan destinasi edukasi yang mengenalkan tokoh pergerakan nasional dan sejarah kebangkitan bangsa.', 'Jl. Bubutan, Surabaya', 'https://placehold.co/900x600?text=Museum+Dr+Soetomo', 'Buka', 5000],
            ['Museum', 'Museum Pendidikan', 'museum-pendidikan', 'Museum Pendidikan menghadirkan koleksi dan informasi mengenai perkembangan pendidikan dari masa ke masa.', 'Jl. Genteng Kali, Surabaya', 'https://placehold.co/900x600?text=Museum+Pendidikan', 'Buka', 5000],
            ['Museum', 'Museum Surabaya Gedung Siola', 'museum-surabaya-gedung-siola', 'Museum Surabaya Gedung Siola menyimpan berbagai koleksi sejarah, budaya, dan perkembangan Kota Surabaya.', 'Gedung Siola, Jl. Tunjungan, Surabaya', 'https://placehold.co/900x600?text=Museum+Surabaya+Gedung+Siola', 'Buka', 0],
            ['Museum', 'Museum H.O.S Tjokroaminoto', 'museum-hos-tjokroaminoto', 'Museum H.O.S Tjokroaminoto merupakan rumah bersejarah yang berkaitan dengan tokoh pergerakan nasional Indonesia.', 'Jl. Peneleh, Surabaya', 'https://placehold.co/900x600?text=Museum+HOS+Tjokroaminoto', 'Buka', 5000],
            ['Museum', 'Museum W.R. Soepratman', 'museum-wr-soepratman', 'Museum W.R. Soepratman mengenalkan kehidupan dan karya pencipta lagu kebangsaan Indonesia Raya.', 'Jl. Mangga, Surabaya', 'https://placehold.co/900x600?text=Museum+WR+Soepratman', 'Buka', 5000],
            ['Museum', 'Museum Olahraga', 'museum-olahraga', 'Museum Olahraga menyajikan informasi dan koleksi terkait perkembangan olahraga serta prestasi atlet.', 'Kawasan Gelora Pancasila, Surabaya', 'https://placehold.co/900x600?text=Museum+Olahraga', 'Buka', 5000],
            ['Wisata Kota', 'Bus SSCT - Balai Pemuda', 'bus-ssct-balai-pemuda', 'Bus SSCT atau Surabaya Sightseeing and City Tour merupakan layanan wisata keliling kota untuk mengenal ikon-ikon Surabaya.', 'Balai Pemuda, Surabaya', 'https://placehold.co/900x600?text=Bus+SSCT+Balai+Pemuda', 'Tutup hari ini', 0],
            ['Wisata Kota', 'Wisata Perahu Kalimas Rute Taman Prestasi - Museum Pendidikan', 'wisata-perahu-kalimas-taman-prestasi-museum-pendidikan', 'Wisata Perahu Kalimas menyajikan pengalaman menyusuri Sungai Kalimas dengan rute Taman Prestasi menuju Museum Pendidikan.', 'Dermaga Taman Prestasi, Surabaya', 'https://placehold.co/900x600?text=Perahu+Kalimas+Museum+Pendidikan', 'Buka', 7000],
            ['Museum', 'Rumah Kelahiran Bung Karno', 'rumah-kelahiran-bung-karno', 'Rumah Kelahiran Bung Karno merupakan destinasi sejarah yang mengenalkan jejak awal kehidupan Presiden pertama Republik Indonesia.', 'Jl. Pandean, Surabaya', 'https://placehold.co/900x600?text=Rumah+Kelahiran+Bung+Karno', 'Buka', 0],
            ['Wisata Kota', 'Monumen Tugu Pahlawan', 'monumen-tugu-pahlawan', 'Monumen Tugu Pahlawan merupakan ikon sejarah perjuangan rakyat Surabaya dalam mempertahankan kemerdekaan.', 'Jl. Pahlawan, Surabaya', 'https://placehold.co/900x600?text=Monumen+Tugu+Pahlawan', 'Tutup hari ini', 0],
            ['Wisata Kota', 'Wisata Perahu Kalimas Rute Taman Prestasi - MONKASEL', 'wisata-perahu-kalimas-taman-prestasi-monkasel', 'Wisata Perahu Kalimas rute Taman Prestasi menuju MONKASEL menghadirkan pengalaman wisata sungai dengan suasana kota Surabaya.', 'Dermaga Taman Prestasi, Surabaya', 'https://placehold.co/900x600?text=Perahu+Kalimas+MONKASEL', 'Buka', 10000],
        ];

        foreach ($destinations as $item) {
            [$category, $name, $slug, $description, $location, $image, $status, $price] = $item;

            $this->db->table('tourism_destinations')->insert([
                'category_id' => $categoryIds[$category],
                'name' => $name,
                'slug' => $slug,
                'description' => $description,
                'location' => $location,
                'image_url' => $image,
                'status' => $status,
                'is_featured' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $destinationId = $this->db->insertID();

            $this->db->table('ticket_types')->insert([
                'destination_id' => $destinationId,
                'name' => $price > 0 ? 'Tiket Reguler' : 'Tiket Gratis',
                'description' => $price > 0 ? 'Tiket masuk reguler destinasi wisata.' : 'Tiket tanpa biaya masuk.',
                'price' => $price,
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            if (str_contains(strtolower($name), 'kalimas')) {
                $this->db->table('ticket_types')->insert([
                    'destination_id' => $destinationId,
                    'name' => 'Tiket Anak',
                    'description' => 'Tiket anak untuk wisata perahu.',
                    'price' => max(0, $price - 2000),
                    'is_active' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }

            $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
            foreach ($days as $day) {
                $isClosed = ($day === 'Senin' && $category === 'Museum') ? 1 : 0;
                $open = str_contains(strtolower($name), 'kalimas') ? '15:00:00' : '08:00:00';
                $close = str_contains(strtolower($name), 'kalimas') ? '20:00:00' : '16:00:00';

                $this->db->table('visit_schedules')->insert([
                    'destination_id' => $destinationId,
                    'day_name' => $day,
                    'open_time' => $isClosed ? null : $open,
                    'close_time' => $isClosed ? null : $close,
                    'quota' => 100,
                    'is_closed' => $isClosed,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }

            $terms = [
                'Pengunjung wajib menjaga kebersihan dan ketertiban selama berada di area wisata.',
                'Tiket yang sudah dibeli tidak dapat dikembalikan.',
                'Pengunjung wajib mengikuti arahan petugas di lokasi wisata.',
            ];

            if (str_contains(strtolower($name), 'kalimas')) {
                $terms[] = 'Wisata Perahu Kalimas tidak melayani pembelian tiket on the spot.';
                $terms[] = 'Pemberangkatan dapat dibatalkan apabila kondisi sungai tidak memungkinkan.';
            }

            foreach ($terms as $index => $term) {
                $this->db->table('terms_and_conditions')->insert([
                    'destination_id' => $destinationId,
                    'content' => $term,
                    'sort_order' => $index + 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }

        $this->db->table('static_pages')->insertBatch([
            ['website_profile_id' => $profileId, 'title' => 'Harga Tiket', 'slug' => 'harga-tiket', 'content' => 'Informasi harga tiket dapat dilihat pada setiap detail destinasi.', 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['website_profile_id' => $profileId, 'title' => 'Cara Pesan Tiket', 'slug' => 'cara-pesan-tiket', 'content' => 'Panduan pemesanan tiket akan dibuat pada tahap berikutnya.', 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['website_profile_id' => $profileId, 'title' => 'FAQ', 'slug' => 'faq', 'content' => 'Halaman FAQ akan dibuat pada tahap berikutnya.', 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['website_profile_id' => $profileId, 'title' => 'Kontak Kami', 'slug' => 'kontak-kami', 'content' => 'Form kontak akan dibuat pada tahap berikutnya.', 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
        ]);

        $this->db->table('footer_links')->insertBatch([
            ['website_profile_id' => $profileId, 'title' => 'Home', 'url' => '/', 'group_name' => 'Navigasi', 'sort_order' => 1, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['website_profile_id' => $profileId, 'title' => 'Destinasi', 'url' => '/destinations', 'group_name' => 'Navigasi', 'sort_order' => 2, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['website_profile_id' => $profileId, 'title' => 'Tutorial', 'url' => '#', 'group_name' => 'Lainnya', 'sort_order' => 3, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['website_profile_id' => $profileId, 'title' => 'Cancel', 'url' => '#', 'group_name' => 'Lainnya', 'sort_order' => 4, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
        ]);

        $this->db->table('social_media')->insertBatch([
            ['website_profile_id' => $profileId, 'platform' => 'Instagram', 'username' => '@disbudporaparsby', 'url' => 'https://instagram.com/disbudporaparsby', 'icon' => 'bi bi-instagram', 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['website_profile_id' => $profileId, 'platform' => 'Instagram', 'username' => '@surabayasparkling', 'url' => 'https://instagram.com/surabayasparkling', 'icon' => 'bi bi-instagram', 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
        ]);

        $this->db->table('contact_infos')->insertBatch([
            ['website_profile_id' => $profileId, 'type' => 'address', 'label' => 'Alamat', 'value' => 'Jl. Tunjungan No. 1-3, Surabaya, Jawa Timur 60275', 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['website_profile_id' => $profileId, 'type' => 'phone', 'label' => 'UPTD Pengelola Obyek Wisata', 'value' => '081553870855', 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['website_profile_id' => $profileId, 'type' => 'phone', 'label' => 'UPTD Museum dan Gedung Seni Budaya', 'value' => '081937001040', 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['website_profile_id' => $profileId, 'type' => 'email', 'label' => 'Email', 'value' => 'disbudporapar@surabaya.go.id', 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
