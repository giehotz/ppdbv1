# Rekomendasi Penambahan Fitur Krusial SPMBM Online (CI4)

Berikut adalah daftar rekomendasi penambahan fitur yang esensial (wajib/sangat penting) untuk melengkapi alur manajemen Penerimaan Siswa Baru pada platform ini. Rekomendasi di bawah disusun berdasarkan standar *best-practice* sistem akademik tanpa memasukkan fungsi pelengkap ('nice-to-have') yang sekiranya membebani proyek pengembang:

## 🎓 **Untuk Akses Calon Siswa (Pendaftar)**

### 1. Fitur *Forgot Password* (Lupa Sandi) via Email Aktif
**Alasan:**
Banyak calon pendaftar di demografi sekolah awal yang belum terbiasa menghafalkan kredensial secara rapi. Jika tidak bisa `reset password` otomatis via Email/WhatsApp Gateway (melalui verifikasi OTP/Tautan Enkripsi), calon siswa akan kesulitan melanjutkan proses pengisian biodata, berkepanjangan lapor ke admin, atau mendaftar ganda dari awal yang menyebabkan penumpukan data.

### 2. Fitur *Preview Draft* & *Finalisasi / Lock* Biodata Bersyarat
**Alasan:**
Saat ini setelah mendaftar, siswa dapat mengubah formulir secara bebas *online*. Namun, sistem aplikasi akademik harus memiliki tombol "Finalisasi Data". Ketika tombol ini ditekan:
*   Aplikasi memeriksa kelengkapan % (validasi tak boleh kosong).
*   Jika beres, maka data **terkunci permanen (Disable Editing)** untuk mencegah pendaftar mengubah nilainya saat dokumen sedang atau telah usai diverifikasi Admin.
*   Pendaftar hanya bisa membaca dan mencetak draf dokumen bukti (`cetak formulir`).

### 3. Integrasi Pemberitahuan *Real-time* Notifikasi Status (WhatsApp *Notification*)
**Alasan:**
Walau siswa bisa melihat *progress* kelulusan/verifikasi dari _Dashboard_, jarang sekali mereka *login* setiap menit mengeceknya. WhatsApp Gateway/Bot sangat krusial agar pengumuman "Selamat Dokumen Terverifikasi" atau "Maaf, Berkas Anda Belum valid" bisa sampai cepat tanpa butuh campur tangan Admin menelepon/menge-WA manual satu persatu dari data *excel*.

---

## 👨‍💻 **Untuk Akses Administrator (Sekolah)**

### 4. Fitur *Auto-Archiving* (Arsip Pendaftaran Tahunan/Gelombang)
**Alasan:**
Aplikasi web tidak bisa terus digabung databasenya dari tahun ajaran 2026, 2027, hingga 2030 di _table_ yang sama tanpa penanda pemisah. Harus ada menu `Manajemen Gelombang / Tahun Ajaran` di Panel Admin yang memberikan fungsi:
*   Membuat *Session PPDB* Aktif.
*   Pemetaan data siswa per tahun (Supaya data pendaftar masa lalu tidak ikut muncul atau mengacaukan statistik laporan kelulusan dan ekspor data tahun baru).

### 5. Fitur Konfirmasi *Upload* Ulang pada Dokumen Invalid
**Alasan:**
Sistem saat ini memiliki fungsionalitas admin memverifikasi kelulusan dan memvalidasi `Berkas.php`. Tetapi, ketika admin menyetel berkas "Ditolak / Invalid (misal KTP Ayah buram/tidak terbaca)", harus ada panel otomatis (*Revision Flow*) yang mengirim alert kembali ke Dashboard Siswa meminta mereka spesifik mengganti _field_ dokumen tersebut & membiarkan mereka *re-upload* khusus file yang ditolak itu saja.

### 6. Rekapitulasi Grafis & *Dashboard Analytics* Kuota Sekolah
**Alasan:**
Pada dashboard awal, administrator butuh data _bird-eye-view_. Perlu ditambahkan *chart widget* untuk:
*   Grafik jumlah kuota jurusan / rombel terhadap jumlah pendaftar saat ini.
*   Statistik asal sekolah *Mts/SMP* calon siswa, sebaran domisili (provinsi), rasio _gender_ hingga persentase jalur pendaftaran yang padat. Ini krusial bagi analisis marketing Kepala Sekolah pada tahun ajaran mendayang.

---
_Catatan:_ Fitur opsional semacam `Forum Diskusi Siswa`, `Pembayaran Seragam`, `Cetak Kartu Ujian (jika tiada test tulis)` sangat tidak direkomendasikan pada tahap awal untuk menjaga _Scope_ MVP (_Minimum Viable Product_) kode CI4 tetap bersih dan ringan. 🌟
