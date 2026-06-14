# Prototype Tiket Wisata Surabaya - CodeIgniter 4 Tahap 1

Paket ini berisi file siap pakai untuk membuat tiruan tahap pertama website Tiket Wisata Surabaya menggunakan CodeIgniter 4.

## Batasan tahap 1

Fitur yang dibuat:

- Database/Migration
- Seeder data dummy
- Routes dasar
- Models
- Controller Home dan Destination
- Halaman beranda
- Halaman daftar destinasi
- Halaman detail destinasi

Fitur yang belum dibuat:

- Booking form
- Konfirmasi booking
- Pembayaran
- QRIS
- E-ticket
- Validasi tiket
- Pembatalan tiket
- FAQ page lengkap
- Contact form

---

## Cara menggunakan

### 1. Buat project CodeIgniter 4 baru

Jika belum punya project CI4:

```bash
composer create-project codeigniter4/appstarter tiket-wisata-surabaya
cd tiket-wisata-surabaya
```

Jika sudah punya project CI4, langsung lanjut ke langkah 2.

### 2. Extract isi ZIP ini ke root project CodeIgniter 4

Root project adalah folder yang berisi:

```txt
app/
public/
writable/
spark
composer.json
```

Saat diminta overwrite file `app/Config/Routes.php`, pilih overwrite.

### 3. Atur file `.env`

Jika belum ada file `.env`:

```bash
copy env .env
```

Untuk Linux/Mac:

```bash
cp env .env
```

Lalu ubah bagian berikut:

```env
CI_ENVIRONMENT = development

app.baseURL = 'http://localhost:8080/'

database.default.hostname = localhost
database.default.database = db_tiket_wisata_surabaya
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
database.default.port = 3306
```

### 4. Buat database

Buat database di phpMyAdmin/HeidiSQL/Adminer:

```sql
CREATE DATABASE db_tiket_wisata_surabaya;
```

### 5. Jalankan migration

```bash
php spark migrate
```

### 6. Jalankan seeder

```bash
php spark db:seed TiketWisataTahap1Seeder
```

### 7. Jalankan server

```bash
php spark serve
```

Buka:

```txt
http://localhost:8080/
```

---

## URL testing tahap 1

```txt
http://localhost:8080/
http://localhost:8080/destinations
http://localhost:8080/destinations/detail/1
```

---

## Catatan penting

Tombol `Beli Tiket` dan tombol `Pesan Tiket` belum masuk ke booking/pembayaran. Pada tahap 1 tombol hanya diarahkan ke detail destinasi atau menampilkan alert placeholder.
