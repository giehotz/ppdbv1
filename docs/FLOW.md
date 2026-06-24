Kamu adalah expert CodeIgniter 4 (versi 4.5+) dengan pengalaman membangun sistem PPDB / penerimaan siswa baru.

Tugasmu: Buat struktur MVC + konfigurasi dasar untuk aplikasi PPDB Online berbasis CodeIgniter 4 sesuai skema database berikut.

Database: MySQL, nama database = ppdb_db
Semua tabel menggunakan prefix tbl_ (kecuali beberapa tabel master tanpa prefix)

Urutan pembuatan & prioritas penting:
1. tbl_user               → user admin / panitia
2. tbl_web                → pengaturan global sekolah & status PPDB
3. tbl_siswa              → data calon siswa (core table paling kompleks)
4. tbl_berkas             → upload berkas pendukung siswa
5. tbl_verifikasi         → (opsional – catatan verifikasi manual)
6. tbl_pengumuman         → pengumuman resmi
7. tbl_komp               → daftar kompetensi keahlian / jurusan
8. tbl_pdd                → riwayat pendidikan orang tua/wali
9. tbl_pekerjaan          → daftar pekerjaan orang tua/wali
10. tbl_penghasilan       → rentang penghasilan orang tua/wali
11. jalur_pendaftaran     → jalur zonasi, afirmasi, prestasi, dll
12. alur_pendaftaran      → langkah-langkah pendaftaran (untuk landing page)
13. faqs                  → pertanyaan umum
14. tbl_landing_content   → konten dinamis halaman depan (hero, cards, gallery, dll)
15. tbl_static_page       → halaman statis (misal: visi misi, profil, dll)

Aturan wajib yang HARUS diikuti:

A. Naming Convention
   - Model     : [NamaTabelSingular]Model   → contoh: SiswaModel, UserModel, BerkasModel
   - Controller: [NamaTabelPlural]          → contoh: Siswas, Users, Berkass
   - View folder: [nama_tabel_lowercase]    → contoh: siswas/, berkass/, pengumumans/
   - Primary Key hampir semua tabel → id_[nama_tabel] atau id (kecuali tbl_siswa → id_siswa)

B. Fitur yang WAJIB ada di setiap resource (kecuali tabel master sederhana)
   - index()     → daftar data + pencarian sederhana + pagination (10/baris)
   - new()       → form tambah data
   - create()    → simpan data baru + validasi
   - edit($id)   → form edit
   - update($id) → simpan perubahan
   - delete($id) → hapus + konfirmasi SweetAlert2
   - Gunakan $this->validate() dengan rules dari Model
   - Flashdata success/error/validation
   - CSRF protection aktif

C. Khusus untuk tabel penting

tbl_siswa
   - Form sangat panjang → split menjadi tab/step wizard (data diri, orang tua, alamat, berkas, pilihan jurusan)
   - no_pendaftaran harus auto generate (format: PPDB-YYYY-NNNN)
   - password di-hash bcrypt
   - status_verifikasi & status_pendaftaran punya warna berbeda di tabel list
   - Tampilkan foto siswa jika ada (dari berkas jenis 'Pas Foto')

tbl_berkas
   - Upload file (jpeg,png,pdf,max 5MB)
   - Kolom status_verifikasi: pending → valid → invalid
   - Hanya admin/panitia yang bisa ubah status_verifikasi + tambah catatan

tbl_user
   - Login sederhana (username + password)
   - level: admin / panitia / verifikator (minimal admin & panitia)
   - Filter 'auth' di group route admin

D. Layout & Frontend
   - Gunakan Bootstrap 5.3 + Font Awesome 6
   - Layout utama: app/Views/layouts/admin.php & app/Views/layouts/landing.php
   - Admin sidebar: Dashboard, Data Calon Siswa, Berkas Upload, Verifikasi, Pengumuman, Pengaturan, dll
   - Gunakan SweetAlert2 untuk konfirmasi & notifikasi

E. Routing (app/Config/Routes.php)
   - Route landing page (publik) → tanpa filter
   - Route admin → group('admin', ['filter' => 'auth'])

Contoh route minimal:
$routes->get('/', 'Landing::index');
$routes->get('alur', 'AlurPendaftaran::index');
$routes->group('admin', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'Dashboard::index');
    $routes->resource('siswas', ['except' => 'show']);
    $routes->resource('berkass');
    $routes->resource('pengumumans');
    $routes->resource('users');
    // dst ...
});

Output yang diharapkan (urutan file yang harus kamu buatkan):

1. app/Config/Database.php → contoh koneksi (comment saja credential)
2. app/Config/Routes.php → semua route yang relevan
3. app/Views/layouts/admin.php
4. app/Views/layouts/landing.php (sangat sederhana)
5. Untuk setiap tabel (ikut urutan di atas):
   - Model lengkap (termasuk validationRules())
   - Controller lengkap (dengan fitur CRUD + search + pagination)
   - View: index.php (tabel list), form.php (create & edit)

Gunakan bahasa Indonesia pada:
- Label form
- Pesan validasi
- Flashdata
- Tombol

Mulai buat dari tabel paling penting dulu (tbl_user → tbl_web → tbl_siswa → tbl_berkas), baru lanjut ke tabel referensi.

Jika kode terlalu panjang, pisahkan per tabel dan beri keterangan "=== Akhir Tabel XXX ==="

Mulai sekarang.