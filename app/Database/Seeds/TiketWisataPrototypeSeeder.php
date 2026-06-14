<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TiketWisataPrototypeSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        $this->db->table('faqs')->truncate();
        $this->db->table('users')->where('email', 'admin@tiketwisata.test')->delete();
        $this->db->table('users')->where('email', 'user@tiketwisata.test')->delete();

        $this->db->table('faqs')->insertBatch([
            ['question' => 'Bagaimana cara memesan tiket?', 'answer' => 'Pilih destinasi, klik Beli Tiket, isi data kunjungan, lalu lanjutkan pembayaran simulasi.', 'sort_order' => 1, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['question' => 'Apakah pembayaran ini asli?', 'answer' => 'Tidak. Pada prototype ini pembayaran hanya simulasi dan langsung dianggap berhasil.', 'sort_order' => 2, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['question' => 'Bagaimana cara melihat e-ticket?', 'answer' => 'Setelah pembayaran sukses, halaman e-ticket akan tersedia dan dapat dicetak.', 'sort_order' => 3, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['question' => 'Apakah tiket bisa dibatalkan?', 'answer' => 'Bisa diajukan melalui menu Pembatalan Tiket. Refund mengikuti kebijakan pengelola.', 'sort_order' => 4, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
        ]);

        $this->db->table('users')->insert([
            'name' => 'Administrator',
            'email' => 'admin@tiketwisata.test',
            'password' => password_hash('password', PASSWORD_DEFAULT),
            'role' => 'admin',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $this->db->table('users')->insert([
            'name' => 'Pengguna Demo',
            'email' => 'user@tiketwisata.test',
            'password' => password_hash('password', PASSWORD_DEFAULT),
            'role' => 'user',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}
