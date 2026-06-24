# Dokumen Persyaratan Produk (PRD)  
**Aplikasi Twibbon Berbasis PHP CodeIgniter**

---

## 1. Tujuan & Gambaran Umum
Membangun aplikasi web yang memungkinkan pengguna membuat foto berbingkai kampanye (twibbon) dengan cara menggabungkan foto profil mereka ke dalam bingkai yang disediakan. Aplikasi ini memiliki panel admin untuk mengelola bingkai dan kampanye, serta halaman publik bagi pengguna untuk langsung membuat dan mengunduh hasil twibbon.

**Target Pengguna:**
- Pengunjung yang ingin membuat dan membagikan twibbon.
- Admin/pengelola kampanye yang menambahkan bingkai.

---

## 2. Peran Pengguna
1. **Admin**
   - Mengelola kampanye (judul, deskripsi, tanggal aktif, template bingkai).
   - Mengunggah bingkai (format PNG transparan).
   - Melihat statistik sederhana (jumlah unduhan per kampanye).

2. **Pengunjung (Guest)**
   - Memilih kampanye yang tersedia.
   - Mengunggah foto dari perangkat atau mengambil foto langsung via kamera.
   - Menyesuaikan posisi/zoom foto dalam bingkai (drag/resize).
   - Mengunduh hasil twibbon.
   - Membagikan ke media sosial (opsional).

---

## 3. Fitur Fungsional

### 3.1. Admin Panel
- **Manajemen Kampanye**
  - CRUD kampanye (nama, deskripsi, tanggal mulai–selesai, status aktif/nonaktif).
  - Setiap kampanye memiliki satu atau lebih bingkai (versi).
- **Upload Bingkai**
  - Format: PNG dengan area transparan di tengah.
  - Dimensi rekomendasi: 1080×1080 px (bisa dikonfigurasi).
  - Otomatis validasi: ukuran file, dimensi, format, dan keberadaan transparansi.
- **Dashboard Statistik**
  - Jumlah pembuatan per kampanye/hari.
  - Total unduhan.

### 3.2. Halaman Publik
- **Daftar Kampanye**
  - Menampilkan kampanye aktif, dengan thumbnail bingkai.
- **Halaman Pembuatan Twibbon**
  - Dropzone/input untuk upload foto (JPG/PNG, maks. 5 MB).
  - Preview real-time: foto ditampilkan di belakang bingkai; pengguna dapat menggeser (drag) dan memperbesar/memperkecil (scale).
  - Tombol: “Unduh Hasil”, “Reset”, “Ganti Foto”.
- **Unduhan**
  - Hasil akhir dalam format JPEG kualitas tinggi.
  - Metadata foto dipertahankan? Tidak diperlukan.
- **Bagikan (Opsional)**
  - Tombol salin tautan, atau integrasi Facebook/Twitter/WhatsApp.

### 3.3. Keamanan & Validasi
- Upload hanya menerima gambar (cek MIME type dan ekstensi).
- Batas ukuran upload (client & server side).
- Anti-CSRF pada semua form.
- XSS filtering (CodeIgniter otomatis).
- Pembatasan rate pembuatan twibbon per IP (mencegah abuse).

---

## 4. Alur Pengguna Utama

1. Pengunjung membuka halaman depan → melihat daftar kampanye.
2. Klik kampanye → masuk halaman creator.
3. Upload foto atau ambil via kamera.
4. Sistem menampilkan preview foto di dalam bingkai.
5. Pengguna menyesuaikan posisi/zoom (via JavaScript).
6. Klik “Proses” → server menggabungkan foto dengan bingkai (menerapkan transformasi sesuai pengaturan klien).
7. Hasil ditampilkan, lalu pengguna mengunduh.

**Alur Admin:**
1. Login → dashboard.
2. Kelola kampanye: buat baru, upload bingkai.
3. Lihat statistik.

---

## 5. Kebutuhan Non-Fungsional
- **Performa:** Proses penggabungan gambar tidak boleh > 3 detik.
- **Kompatibilitas:** Responsif di desktop dan mobile.
- **Keamanan:** Folder upload tidak bisa dieksekusi, gunakan .htaccess.
- **Skalabilitas:** Siap di-cache (file statis) di CDN untuk kampanye populer.
- **Kemudahan Deployment:** Bisa di-deploy di shared hosting standar (PHP 7.4+ / 8.x, GD Library/Imagick).

---

## 6. Arsitektur CodeIgniter (Panduan)

Gunakan **CodeIgniter 3** (stabil dan banyak digunakan di shared hosting) atau **CodeIgniter 4** (lebih modern). Panduan ini berlaku untuk keduanya dengan penyesuaian.

### 6.1. Struktur Direktori
```
/app (atau application)
  /Controllers
    Admin.php
    Campaign.php
    Home.php
  /Models
    Campaign_model.php
    Frame_model.php
    Statistic_model.php
  /Views
    /admin
    /public
    /templates
  /Libraries
    Twibbon_lib.php   (proses penggabungan gambar)
  /Helpers
    image_helper.php  (fungsi bantu resize, crop)
/public (atau root)
  /uploads
    /frames           (bingkai asli)
    /temp             (foto pengguna sementara, hapus setelah diproses)
    /results          (hasil twibbon, bisa dihapus berkala)
  /assets
```

### 6.2. Library Khusus: Twibbon_lib
- Method utama: `generate($framePath, $photoPath, $offsetX, $offsetY, $scale, $outputPath)`
- Algoritma:
  1. Buka gambar bingkai (PNG) dan foto pengguna (JPG/PNG).
  2. Resize & crop foto sesuai ukuran bingkai (atau area yang sudah ditentukan konfigurasi kampanye, misal lingkaran/persegi di tengah). Gunakan `imagecopyresampled` atau Imagick.
  3. Tempatkan foto di belakang bingkai (bingkai di layer atas). Pastikan transparansi bingkai dipertahankan.
  4. Simpan hasil sebagai JPEG (kualitas 90%).
- Pertimbangkan menggunakan **Imagick** jika tersedia, karena lebih cepat dan mendukung banyak format. Jika tidak, fallback ke **GD Library**.

### 6.3. Controller Utama
- `Home::index()` – daftar kampanye.
- `Campaign::detail($id)` – halaman creator.
- `Campaign::process()` – menerima AJAX upload foto + parameter transformasi, mengembalikan URL hasil atau download langsung.
- `Admin::login()`, `Admin::dashboard()` – CRUD kampanye/bingkai.

### 6.4. Model Database
- Gunakan Query Builder CodeIgniter.
- Tabel kampanye: `id, title, description, start_date, end_date, is_active, created_at, updated_at`
- Tabel bingkai: `id, campaign_id, file_name, original_name, width, height, config_json` (misal: area x, y, width, height untuk tempat foto, atau bentuk mask).
- Tabel statistik: `id, campaign_id, ip_address, user_agent, created_at` (untuk tracking sederhana).

### 6.5. Frontend Interaktif
- Gunakan JavaScript **Cropper.js** atau pustaka serupa untuk mengatur posisi/zoom foto di dalam area yang telah ditentukan.
- Saat tombol proses diklik, kirim data: `{ image: file, x: ..., y: ..., scale: ... }` via AJAX ke server.
- Server menyimpan gambar sementara, memanggil library Twibbon, lalu mengembalikan path gambar hasil.

### 6.6. Keamanan Upload
- Gunakan `$this->upload->initialize($config)` dengan pengaturan:
  - `allowed_types = 'jpg|jpeg|png'`
  - `max_size = 5120` (5MB)
  - `encrypt_name = TRUE` (nama file diacak)
- Validasi MIME sebenarnya menggunakan `finfo` atau `getimagesize()`.

---

## 7. Basis Data – Rancangan Tabel

### 7.1. `campaigns`
| Kolom         | Tipe         | Keterangan |
|---------------|--------------|------------|
| id            | int(11) PK   | Auto increment |
| title         | varchar(255) | Judul kampanye |
| slug          | varchar(255) | URL friendly |
| description   | text         | Deskripsi (HTML) |
| start_date    | date         | |
| end_date      | date         | |
| is_active     | tinyint(1)   | 0/1 |
| created_at    | datetime     | |
| updated_at    | datetime     | |

### 7.2. `frames`
| Kolom         | Tipe         | Keterangan |
|---------------|--------------|------------|
| id            | int(11) PK   | |
| campaign_id   | int(11) FK   | |
| file_path     | varchar(255) | Path relatif ke file bingkai |
| width         | int          | Lebar asli |
| height        | int          | Tinggi asli |
| config        | text (JSON)  | Misal: `{"photo_area": {"x":100,"y":150,"width":800,"height":800,"shape":"circle"}}` |
| sort_order    | int          | Urutan tampil |
| created_at    | datetime     | |

### 7.3. `statistics`
| Kolom         | Tipe         | Keterangan |
|---------------|--------------|------------|
| id            | int(11) PK   | |
| campaign_id   | int(11)      | |
| ip_address    | varchar(45)  | |
| user_agent    | varchar(255) | |
| created_at    | datetime     | |

### 7.4. `users` (admin)
| Kolom         | Tipe         | Keterangan |
|---------------|--------------|------------|
| id            | int(11) PK   | |
| username      | varchar(100) | |
| password      | varchar(255) | Hash bcrypt |
| email         | varchar(255) | |
| last_login    | datetime     | |

---

## 8. Panduan Pengembangan (Tahapan)

1. **Inisialisasi Proyek**
   - Siapkan CodeIgniter, konfigurasi base URL, database, autoload (session, database, upload).
   - Buat database sesuai skema.

2. **Backend Admin**
   - Autentikasi (login/logout) dengan library Session.
   - CRUD `campaigns` dan `frames`.
   - Pada form upload bingkai: periksa transparansi (fungsi GD/Imagick), pastikan area transparan cukup besar.

3. **Library Twibbon**
   - Buat library yang menerima path foto, path bingkai, array konfigurasi (x,y,scale, ukuran area), dan menghasilkan gambar.
   - Untuk bentuk lingkaran (circle mask), gunakan teknik alpha masking.

4. **Halaman Depan & Creator**
   - Tampilkan kampanye aktif (query campaign dengan where is_active=1 dan start_date <= now <= end_date).
   - Di halaman creator, tentukan area foto dari config bingkai. Inisialisasi Cropper.js dengan aspect ratio dan batas area.
   - Tangani upload via AJAX: simpan gambar sementara di folder `temp/`, kirim parameter cropping/scaling.
   - Panggil library Twibbon, hasilkan gambar, simpan di `results/`, dan beri link unduhan.

5. **Tracking**
   - Setiap kali proses generate sukses, insert ke tabel statistics.

6. **Keamanan & Optimasi**
   - Gunakan CSRF token untuk form.
   - Cron job untuk menghapus file temporary yang lebih dari 1 jam.
   - Siapkan `robot.txt` untuk memblokir folder uploads.

7. **Testing**
   - Uji upload gambar besar (10MB+ tetapi ditolak).
   - Uji gambar non-foto (file teks disamarkan).
   - Uji beban ringan: 10 permintaan bersamaan.

---

## 9. Catatan Penting

- **Tanpa Kode:** Dokumen ini sengaja tidak menyertakan cuplikan kode. Pengembang harus mengimplementasikan sendiri menggunakan logika MVC CodeIgniter dengan mengacu pada prinsip-prinsip di atas.
- **Fleksibilitas:** Desain bisa diperluas dengan fitur teks di atas bingkai, multi-bingkai per kampanye, atau watermark otomatis.
- **Library Pihak Ketiga:** Disarankan menggunakan **Intervention Image** (jika memungkinkan) untuk manipulasi gambar yang lebih mudah, tetapi pustaka asli PHP juga cukup.