---
name: project_structure
description: Panduan arsitektur dan tata letak direktori proyek PPDB berbasis CodeIgniter 4.
---

# Panduan Struktur Proyek PPDB (CodeIgniter 4)

Proyek ini dibangun menggunakan framework **CodeIgniter 4**. Berikut adalah gambaran struktur direktori utama di dalam folder `app/` beserta fungsi masing-masing komponen.

## 1. Direktori Utama & Pola MVC

Aplikasi ini memisahkan logika berdasarkan tiga peran pengguna utama: **Admin**, **Verifikator**, dan **Siswa**. Pemisahan ini diterapkan di tingkat Controller dan View.

### `app/Config/`
Tempat konfigurasi global aplikasi.
* **Routing**: Menggunakan pemisahan rute berbasis file di dalam [app/Config/Routes.php](file:///d:/ppdbv1/app/Config/Routes.php). Rute untuk masing-masing peran dimuat secara terpisah dari:
  * [Config/Routes/admin.php](file:///d:/ppdbv1/app/Config/Routes/admin.php)
  * [Config/Routes/verifikator.php](file:///d:/ppdbv1/app/Config/Routes/verifikator.php)
  * [Config/Routes/siswa.php](file:///d:/ppdbv1/app/Config/Routes/siswa.php)
* **Filters**: [Config/Filters.php](file:///d:/ppdbv1/app/Config/Filters.php) mendefinisikan middleware seperti otentikasi peran (`admin`, `verifikator`, `siswa`) dan perlindungan CSRF.

### `app/Controllers/`
Logika backend penanganan permintaan HTTP. Terbagi menjadi sub-folder sesuai peran:
* [Controllers/Admin/](file:///d:/ppdbv1/app/Controllers/Admin) - Fitur manajemen dashboard, pengaturan, siswa, unlock request, kelulusan, dan pembiayaan admin.
* [Controllers/Verifikator/](file:///d:/ppdbv1/app/Controllers/Verifikator) - Fitur verifikasi berkas, biodata, dan pembiayaan siswa oleh staf verifikator.
* [Controllers/Siswa/](file:///d:/ppdbv1/app/Controllers/Siswa) - Fitur pendaftaran, upload berkas, twibbon, dan pembiayaan mandiri siswa.

### `app/Models/`
Model representasi tabel basis data (menggunakan kelas bawaan CodeIgniter Model). Semua model diletakkan langsung di bawah [app/Models/](file:///d:/ppdbv1/app/Models).
* Contoh: `SiswaModel.php`, `ItemPembiayaanModel.php`, `TagihanSiswaModel.php`.

### `app/Views/`
Template tampilan HTML/CSS. Menggunakan sistem layout/view inheritance (`$this->extend(...)`).
* **Layouts**: [app/Views/layouts/](file:///d:/ppdbv1/app/Views/layouts) berisi kerangka dasar halaman per peran (misal: `admin.php`, `verifikator.php`, `siswa.php`).
* **Role Views**: Sub-folder per peran:
  * [Views/admin/](file:///d:/ppdbv1/app/Views/admin)
  * [Views/verifikator/](file:///d:/ppdbv1/app/Views/verifikator)
  * [Views/siswa/](file:///d:/ppdbv1/app/Views/siswa)
* **Landing Page**: [app/Views/landing/](file:///d:/ppdbv1/app/Views/landing) untuk halaman depan publik.

---

## 2. Direktori Pendukung

* `app/Database/`:
  * `Migrations/`: Skema DDL tabel database (berurutan berdasarkan tanggal pembuatan).
  * `Seeds/`: Seeder data awal/pengujian untuk tabel database.
* `app/Helpers/`: Berisi helper custom PHP (seperti `pembiayaan_helper.php` untuk pemformatan rupiah dan kalkulasi sisa pembayaran).
* `app/Libraries/`: Berisi library eksternal/custom (seperti `PdfGenerator.php` yang membungkus Dompdf untuk konversi view HTML ke PDF).
