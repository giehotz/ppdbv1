# Analisa Kekurangan Fungsionalitas Proyek SPMBM Online (CI4)

Berikut adalah hasil analisa kekurangan fungsionalitas, *bug*, dan potensi celah inefisiensi/keamanan berdasarkan *source code* proyek di sistem saat ini. Analisa ini merujuk murni pada fungsionalitas yang ada tanpa menyarankan penambahan fitur baru di luar struktur kerja yang sudah dibangun.

## 1. Celah *Mass Assignment* (Siswa/Biodata)
**Lokasi File:** `app/Controllers/Siswa/Biodata.php` pada method `update()`
**Penjelasan:** 
Sistem mengambil seluruh data dari POST request (`$this->request->getPost()`) dan langsung memasukannya sebagai parameter ke `$siswaModel->update()`. Karena daftar `allowedFields` pada model `SiswaModel` mencakup kolom-kolom status internal/sekolah (seperti `status_verifikasi`, `status_lulus`, dan `verified_by`), seorang siswa pada dasarnya dapat menyisipkan _parameter_ ini secara paksa dalam _request payload_ mereka ke server dan mengubah status verifikasi atau kelulusan milik mereka sendiri tanpa verifikasi ulang admin.

## 2. Ketiadaan Validasi *File Upload* Logo (Admin/Settings)
**Lokasi File:** `app/Controllers/Admin/Settings.php` pada method `update()`
**Penjelasan:**
Pada proses ubah bagian *settings*, upload `logo_sekolah` langsung dipindahkan menggunakan `$fileLogo->move()` tanpa dilakukan pemeriksaan atau pembatasan tipe file terunggah (`mime_type`) dan ukurannya (`max_size`). Fungsionalitas ini rawan terhadap error server dan keamanan jika ada file besar yang masuk atau jika administrator tidak teliti mengunggah sembarang file (misal *script* PHP yang eksekutabel apabila `.htaccess` terekspos).

## 3. Resiko *Memory Exhaustion* pada Ekspor Excel (Admin/ExportSiswa)
**Lokasi File:** `app/Controllers/Admin/ExportSiswa.php` pada method `exportExcel()`
**Penjelasan:**
Proses pengambilan data siswa ke Excel menggunakan `$this->siswaModel->findAll()` . Metode ini menampung _seluruh array_ ke memori (RAM) PHP script secara bersamaan. Dalam skenario di mana pengguna kelak memiliki pendaftar mencapai beberapa ribu baris, hal ini sangat berpotensi menyebabkan PHP mengalami _Memory Limit Exhausted_ yang berujung pada kegagalan ekspor atau *crash* web-server ringan. Fungsionalitas idealnya menggunakan _chunking_ (potongan bertahap).

## 4. Masalah Konkurensi (Race Condition) di Penomoran Pendaftaran (Auth)
**Lokasi File:** `app/Controllers/Auth.php` pada method `doRegister()`
**Penjelasan:**
Pada saat registrasi pertama kali, pembuatan `no_pendaftaran` otomatis didasari dari data record terakhir di database lalu nomornya dijumlahkan `+1`. Jika aplikasi dipublis dan memiliki *traffic* pendaftaran masif, di mana beberapa individu mendaftar di detik/milidetik yang bersinggungan langsung, keduanya bisa mengambil *ID* awal yang sama sehingga teralokasikan `no_pendaftaran` yang terduplikasi.

## 5. Inefisiensi Eksekusi Query N+1 pada *Bulk Update* (Admin/Kelulusan)
**Lokasi File:** `app/Controllers/Admin/Kelulusan.php` pada method `bulkUpdate()`
**Penjelasan:**
Saat Admin ingin merubah status kelulusan untuk banyak siswa dari skema pilihan ganda (checkbox/bulk), sistem saat ini melakukan proses iterasi (`foreach`) terhadap setiap ID siswa yang terpilih tunggal dan mengeksekusi operasi `UPDATE` database satu kali di setiap perulangannya. Fungsionalitas ini menciptakan kelebihan beban *database query*.

## 6. Ketiadaan *Whitelist* Status Kelulusan (Admin/Kelulusan)
**Lokasi File:** `app/Controllers/Admin/Kelulusan.php` pada method `update()` dan `bulkUpdate()`
**Penjelasan:**
Sistem mengambil `$status = $this->request->getPost('status_lulus');` lalu serta-merta menyimpannya tanpa melalui aturan _Validation_ apakah isian string tersebut masuk akal (contoh khusus harus berupa: "Lulus", "Tidak Lulus", atau "Pending"). Tanpa validasi ini, jika format *request payload* diubah secara keliru, teks acak bisa mengisi *record database* dan melumpuhkan relasi atau visualisasi antar-muka pada bagian yang mengharapkan ketiga nilai di atas.
