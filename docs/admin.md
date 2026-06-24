Berikut adalah **roadmap pembuatan aplikasi admin PPDB** berdasarkan **struktur database yang ada di file SQL** (ppdb_db). Roadmap ini dibuat secara realistis dan bertahap, **hanya menggunakan tabel & field yang benar-benar ada di SQL** — tidak menambahkan fitur atau tabel baru.

Urutan dibuat dari yang paling mendasar (setup + dashboard + autentikasi) menuju fitur inti PPDB (siswa & verifikasi berkas), lalu ke pengelolaan konten pendukung.

### Roadmap Pembuatan Admin PPDB (CodeIgniter 4)

#### Phase 0 – Persiapan & Setup Dasar (1–2 hari)
1. Install CodeIgniter 4 fresh (via composer create-project)
2. Konfigurasi `.env` → database (ppdb_db), baseURL, app.timezone = 'Asia/Jakarta'
3. Aktifkan CSRF protection (default sudah on)
4. Install library tambahan (opsional tapi direkomendasikan):
   - codeigniter4/shield (untuk autentikasi modern) → atau buat manual pakai session
   - myth/auth (jika ingin lebih sederhana & banyak tutorial)
5. Buat layout admin dasar:
   - `app/Views/layouts/admin.php` → sidebar + header + footer (gunakan Bootstrap 5 + Font Awesome)
   - Sidebar menu awal: Dashboard, Pengguna, Pengaturan Sistem, Calon Siswa, Berkas, Pengumuman, Landing Content

#### Phase 1 – Dashboard Admin & Autentikasi (Prioritas pertama)
Tabel yang dipakai: `tbl_user`, `tbl_web`

1. **Login & Autentikasi** (tbl_user)
   - Buat Controller: AuthController (login, logout, forgot password sederhana)
   - Model: UserModel (tabel tbl_user)
   - View: login.php (halaman terpisah, bukan pakai layout admin)
   - Filter 'auth' → redirect jika belum login ke /admin/login

2. **Dashboard Utama** (Halaman pertama setelah login)
   - Controller: Dashboard (method index)
   - Tampilkan ringkasan statistik sederhana (dari tabel yang sudah ada):
     - Jumlah calon siswa terdaftar (COUNT tbl_siswa)
     - Jumlah siswa verified / lulus / pending (GROUP BY status_verifikasi, status_pendaftaran)
     - Status PPDB saat ini (dari tbl_web.status_ppdb)
     - Tanggal pengumuman terdekat (tbl_web.tgl_pengumuman jika aktif)
     - Jumlah berkas pending verifikasi (COUNT tbl_berkas WHERE status_verifikasi = 'pending')
   - Gunakan card Bootstrap (4–6 card) + chart sederhana (Chart.js jika mau)

3. **Pengaturan Sistem Dasar** (tbl_web)
   - Controller: Pengaturan / WebSetting
   - CRUD sederhana (hanya 1 record id_web = 1 biasanya)
   - Field yang diizinkan di form:
     - status_ppdb (buka/tutup)
     - pengumuman_aktif & tgl_pengumuman
     - ujian_aktif & tgl_ujian
     - nama_sekolah, alamat_sekolah, logo_sekolah, nsm, npsn, kecamatan, kabupaten, provinsi, nama_kepala, nip_kepala, telepon, email, website

#### Phase 2 – Manajemen Calon Siswa (Core PPDB – paling penting)
Tabel utama: `tbl_siswa`

1. **Daftar Calon Siswa** (SiswasController – index)
   - List dengan pagination + search (no_pendaftaran, nama_lengkap, nisn, status_verifikasi, status_pendaftaran, jalur_pendaftaran)
   - Kolom tampil utama: no_pendaftaran, nama_lengkap, nisn, jk, tgl_lahir, status_verifikasi (badge warna), status_pendaftaran, tgl_siswa
   - Tombol: Detail, Edit, Hapus, Verifikasi (modal)

2. **Detail Siswa** (method show / detail)
   - Tampilkan hampir semua field dalam bentuk read-only (gunakan accordion atau tab)
   - Bagian penting: data diri, alamat, orang tua (ayah, ibu, wali), sekolah asal, berkas terkait

3. **Verifikasi Siswa** (method verifikasi)
   - Update field: status_verifikasi, status_pendaftaran, tgl_verifikasi, verified_by (id_user admin), catatan_verifikasi
   - Logika sederhana: jika status_verifikasi = 'valid' → status_pendaftaran bisa diubah ke 'Lulus' / 'Cadangan'

4. **Form Tambah/Edit Siswa** (new / edit)
   - Form sangat panjang → gunakan **tab wizard** (Bootstrap nav-tabs atau step-by-step JS)
     - Tab 1: Data Pribadi (no_pendaftaran auto, nama, nisn, nik, jk, tempat/tgl lahir, agama, dll)
     - Tab 2: Data Keluarga & Orang Tua
     - Tab 3: Alamat & Kontak
     - Tab 4: Riwayat Pendidikan & Prestasi (paud, tk, sekolah asal)
     - Tab 5: Pilihan Jurusan (komp_ahli dari tbl_komp), jalur_pendaftaran
   - no_pendaftaran auto generate → format PPDB-tahun-urut (contoh: PPDB-2026-0001)

#### Phase 3 – Manajemen Berkas Siswa
Tabel: `tbl_berkas`

1. **Daftar Berkas** (BerkassController)
   - Filter per siswa (id_siswa) atau semua berkas pending
   - Kolom: nama siswa (join tbl_siswa), jenis_berkas, nama_file (link preview), status_verifikasi, keterangan

2. **Verifikasi Berkas** (update status)
   - Ganti status_verifikasi → pending → valid / invalid
   - Tambah keterangan/catatan admin

3. **Upload Berkas** (jika admin perlu upload manual – jarang dipakai)

#### Phase 4 – Pengumuman & Konten Pendukung
1. **Pengumuman** (PengumumansController – tbl_pengumuman)
   - CRUD pengumuman (judul, isi, tipe, target_audience, lampiran, publish_date, is_active)

2. **Master Data Referensi** (read-only atau CRUD minimal)
   - Kompetensi (tbl_komp)
   - Pendidikan (tbl_pdd)
   - Pekerjaan (tbl_pekerjaan)
   - Penghasilan (tbl_penghasilan)
   - Jalur Pendaftaran (jalur_pendaftaran) – jika sudah ada data

3. **Alur Pendaftaran** (AlurPendaftaranController – alur_pendaftaran)
   - Urutkan berdasarkan field urutan

4. **Landing Content** (LandingContentController – tbl_landing_content)
   - CRUD per section (hero, info_cards, keunggulan, countdown, dll)

5. **FAQs** (FaqsController – faqs)

#### Phase 5 – Finishing & Polish (setelah semua CRUD selesai)
- Tambah filter & export (CSV/Excel) di daftar siswa & berkas
- SweetAlert2 + Toast notification untuk semua aksi
- Role sederhana (jika pakai Shield): admin vs verifikator
- Audit log sederhana (opsional – tabel terpisah)
- Testing: login, tambah siswa dummy, verifikasi, ubah status PPDB

### Urutan Prioritas Pengerjaan (Rekomendasi)
1. Auth + Dashboard + Pengaturan Sistem (tbl_user & tbl_web)
2. Manajemen Siswa (tbl_siswa) – paling krusial
3. Manajemen Berkas & Verifikasi (tbl_berkas)
4. Pengumuman (tbl_pengumuman)
5. Master data referensi & konten landing

Dengan mengikuti urutan ini, admin sudah bisa berfungsi untuk verifikasi pendaftaran siswa dalam waktu relatif singkat.

Jika ingin detail langkah + contoh kode untuk salah satu phase (misal Dashboard atau Form Siswa), beri tahu ya.