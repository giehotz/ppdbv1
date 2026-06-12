# Catatan Persiapan Deployment SPMB / PPDB
*Dibuat pada: 21 Februari 2026*

Dokumen ini berisi daftar periksa (checklist) teknis dan saran peningkatan fitur sebelum aplikasi web PPDB ini diluncurkan (*deploy*) ke server produksi (hosting/VPS).

## 1. 🛡️ Keamanan & Konfigurasi Server (Wajib Sebelum Deploy)
- **Ubah Environment ke Production:** 
  Di dalam file `.env` root, pastikan nilai `CI_ENVIRONMENT` diubah menjadi `production`. 
  *Alasan:* Hal ini amat sangat penting untuk menonaktifkan bilah toolbar debug kuning dari CodeIgniter 4 agar jika terjadi error, detail database/struktur direktori Anda tidak bocor ke publik.
- **Deklarasikan Base URL:** 
  Setel ulang URL domain di bawah `# app.baseURL = ''` di `.env` dan isilah dengan domain resmi. 
  *Contoh:* `app.baseURL = 'https://ppdb.sekolah-anda.sch.id/'`. 
  *Alasan:* Fitur routing, validasi CORS, serta pemanggilan gambar profil/logo akan rusak (*broken link*) jika variabel ini tidak disetel persis dengan domain hosting.
- **Perketat Folder Root (DocumentRoot):** 
  Pastikan setelan web server (Apache/Nginx/cPanel) mengarahkan *DocumentRoot* (direktori utama) langsung jatuh ke dalam folder `/public`. 
  *Alasan:* Jangan biarkan pengunjung dunia maya bisa melihat atau menelusuri struktur kerangka web tingkat dasar seperti folder `/app`, `/system/`, apalagi direktori log `/writable`.

password db GiVr^-PP}T9BHbQc

## 2. ⚡ Peningkatan Fungsi Sistem Jangka Panjang (Saran)
- **Fitur Lupa Password (Reset Sandi):** 
  Biasanya, calon pendaftar sering lupa *password* mereka beberapa hari/minggu pasca pendaftaran awal jika jeda seleksi cukup lama. Jika memungkinkan, rencanakanlah alur "Lupa Sandi" dengan *Email OTP* (via SMTP) atau konfirmasi sinkronisasi WhatsApp OTP ke bot / nomor staf.
- **Mode Pemeliharaan (Maintenance / Freeze Mode):** 
  Tambahkan sebuah sklar (toggle) pada pengaturan *Website* Admin untuk menutup sistem penerimaan sementara (freeze). Ini krusial agar tidak ada data siswa (atau unggahan berkas) yang tiba-tiba berubah saat Panitia / Verifikator sedang merekapitulasi dokumen final atau melangsungkan rapat penentuan kelulusan.
- **Export Excel yang Spesifik & Terintegrasi EMIS/Dapodik:** 
  Pastikan rutinitas *Export Data* di Dashboard Admin benar-benar mencakup seratus persen field formulir (Data Diri, Alamat, Orang Tua, Asal Sekolah, Nilai). Sekolah-sekolah biasanya mensyaratkan tabulasi ketat karena file Excel rekapitulasi PPDB ini wajib diimpor kembali ke sistem tata usaha pusat (*Dapodik Nasional / EMIS Kemenag*).

## 3. ✨ Kualitas Pengalaman Pengguna (Optimasi UX)
- **Limitasi \`Client-Side\` pada Upload Berkas:** 
  Walau Anda sudah memiliki proteksi batasan ukuran file di *Backend* (Controller CI4), terapkan juga validasi `JavaScript` pada elemen `<input type="file">` siswa. Hal ini memblokir pengguna dari menekan *"Submit"* bila dokumen yang dikaitkan lebih besar dari 2MB sedari awal form, sehingga menghemat konsumsi memori bandwidth server saat *upload*.
- **Efek Pemuat (Loader / Spinner):** 
  Beri inisiasi sintaks Javascript agar ketika pendaftar menekan tombol *[Simpan & Lanjut]* atau *[Upload Berkas]*, tombolnya langsung beralih wujud (disabled) dan berteks *"Sedang Diproses..."*. Trik antarmuka ini terbukti efektif mengatasi kendala duplikasi data (*Duplicate Entry*) bila internet pengguna sedang lamban sehingga mereka tak sengaja menekan klik dobel berkali-kali.

## 4. 🚀 Konfigurasi Spesifik Deployment ke `ppdb.min2tanggamus.sch.id`

Berikut adalah daftar file dan baris yang **WAJIB** diubah/ditambah pada server Anda (Document Root: `public_html/ppdb/spmbm-online-ci4/public`):

### 1. File `.env` (Utama)
Buat file `.env` di direktori utama `public_html/ppdb/spmbm-online-ci4/` (atau ubah nama file `env` bawaan menjadi `.env`), lalu ubah/tambah baris berikut:

```ini
# Ubah environment ke production agar error tidak tampil di layar pengguna
CI_ENVIRONMENT = production

# Sesuaikan baseURL dengan nama domain
app.baseURL = 'https://ppdb.min2tanggamus.sch.id/'

# Hilangkan indexPage agar URL lebih bersih (tanpa index.php)
app.indexPage = ''

# Konfigurasi Database (Sesuaikan nama database dan username Anda di cPanel)
database.default.hostname = localhost
database.default.database = nama_database_ppdb
database.default.username = username_database
database.default.password = GiVr^-PP}T9BHbQc
database.default.DBDriver = MySQLi
```

### 2. File `app/Config/App.php` (Sebagai Cadangan / opsional jika sudah di-set di .env)
Pastikan pengaturan berikut juga sesuai:
```php
public string $baseURL = 'https://ppdb.min2tanggamus.sch.id/';
public string $indexPage = '';
```

### 3. File `.htaccess` pada folder `public`
Karena Document Root sudah di-set ke `.../public`, file `.htaccess` bawaan CodeIgniter 4 di dalam folder `public/` sudah cukup. Pastikan file `public/.htaccess` ada di server untuk menghilangkan `index.php` pada URL.

### 4. Permission (Hak Akses) Folder
Pastikan folder-folder berikut memiliki hak akses **Writeable (755 atau 777)** di cPanel/File Manager agar aplikasi bisa menyimpan sesi, cache, dan file upload:
- `writable/` beserta seluruh subfolder di dalamnya.
- `public/uploads/` beserta subfoldernya (misal: `berkas/`, `bukti_bayar/` dll jika ada).

---
*Catatan ini bisa dihapus setelah keseluruhan poin esensialnya sudah terpenuhi di Environment Production.*


Betul, setiap aplikasi selalu bisa ditingkatkan. Jika dilihat dari sisi fungsionalitas profesional (standar industri/SaaS), ada beberapa area penting yang bisa kita sempurnakan agar sistem ini lebih tangguh dan bernilai jual tinggi:

### 1. Keamanan & Validasi (Sangat Penting)
*   **Rate Limiting**: Tambahkan pembatasan jumlah percobaan login atau reset password (misal: maksimal 5x salah dalam 10 menit) untuk mencegah serangan *brute force*.
*   **Validasi File Upload**: Saat ini kita mengizinkan upload gambar, tapi perlu dipastikan sistem benar-benar mengecek *MIME Type* dan ukuran maksimal file di sisi server agar user tidak bisa mengunggah file berbahaya (seperti [.php](cci:7://file:///d:/spmbm-online-ci4/app/Config/Routes.php:0:0-0:0) yang disamarkan jadi `.jpg`).
*   **CSRF Protection**: Pastikan seluruh form menggunakan `<?= csrf_field() ?>` (kita sudah melakukannya di beberapa tempat, tapi harus konsisten di setiap form).

### 2. Integrasi & Notifikasi Otomatis
*   **WhatsApp Gateway Otomatis**: Saat ini kita menggunakan Link WA (user harus klik dulu). Akan jauh lebih profesional jika sistem otomatis mengirim pesan WA (melalui API seperti Fonnte, Wablas, dll.) ketika:
    *   Siswa baru mendaftar (Kiriman No. Pendaftaran).
    *   Admin menyetujui/menolak verifikasi.
    *   Password di-reset oleh admin.
*   **Notifikasi Email**: Sebagai cadangan jika WA sedang gangguan.

### 3. Fungsionalitas Administrasi
*   **Laporan Excel/PDF Dinamis**: Tambahkan fitur ekspor data pendaftar ke Excel yang bisa difilter berdasarkan jalur pendaftaran, status kelulusan, atau periode waktu tertentu.
*   **Import Data Siswa Lama**: Fitur untuk mengimpor data dari Excel ke database agar admin tidak perlu input manual satu per satu.
*   **Pengaturan Jadwal Pendaftaran**: Fitur untuk membuka/menutup pendaftaran secara otomatis berdasarkan tanggal yang ditentukan di database (sekarang mungkin masih manual).

### 4. Pengalaman Pengguna (UX)
*   **Step-by-Step Wizard**: Saat pendaftaran/isi biodata, buat form yang dibagi menjadi beberapa tahap (Step 1: Data Diri, Step 2: Orang Tua, Step 3: Berkas). Ini jauh lebih ringan buat user daripada melihat satu form panjang ke bawah.
*   **Status Verifikasi Real-time**: Siswa bisa melihat alasan detail (catatan dari verifikator) jika berkas ditolak, langsung di dashboard mereka.

### 5. Arsitektur Data (Database)
*   **Audit Trail yang Lebih Detail**: Simpan status data sebelum dan sesudah diubah (perbandingan nilai lama vs nilai baru) di tabel `log_aktivitas` agar admin bisa melakukan *roll-back* jika ada kesalahan input.
*   **Relasi Data yang Kuat**: Pastikan menggunakan `Foreign Keys` (kunci tamu) di database agar jika data siswa dihapus, data berkas atau log miliknya tidak menjadi "sampah" di database (Cascading Delete).

---

**Saran Langkah Berikutnya:**
Mana dari poin di atas yang paling mendesak untuk kebutuhan Anda saat ini? Saya bisa membantu mengimplementasikan salah satunya, misalnya **Fitur Export Excel dengan Filter** atau **Pembatasan (Validation) Upload yang lebih ketat**.