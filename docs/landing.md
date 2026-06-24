# Rancangan Alur CMS Sederhana untuk Landing Page PPDB dengan CI4

## 1. **Alur Navigasi Sistem**

### Halaman Publik (Landing Page)
```
Beranda (landing page)
├── Hero Section
├── Fitur/Keunggulan
├── Galeri
├── Testimoni
├── Kontak & Lokasi
└── Footer
```

### Halaman Admin (CMS)
```
Login Admin
├── Dashboard
├── Kelola Hero Section
├── Kelola Fitur
├── Kelola Galeri
├── Kelola Testimoni
├── Kelola Kontak
├── Pengaturan Umum
└── Logout
```

## 2. **Alur Data**

### Alur Upload & Tampil Konten
```
Admin Input → Validasi → Upload File (gambar) → Simpan ke DB → Tampil di Landing Page
```

### Alur Edit Konten
```
Admin Pilih Menu → Ambil Data dari DB → Tampilkan Form → Update DB → Refresh Landing Page
```

## 3. **Struktur Database Sederhana**

```sql
-- 1. Tabel hero_section
hero_id | judul | subjudul | gambar | tombol_teks | tombol_link | status

-- 2. Tabel fitur
fitur_id | ikon | judul | deskripsi | urutan | status

-- 3. Tabel galeri
galeri_id | gambar | judul | deskripsi | urutan | status

-- 4. Tabel testimoni
testimoni_id | nama | peran | isi | avatar | rating | status

-- 5. Tabel kontak
kontak_id | alamat | telepon | email | maps | jam_operasional

-- 6. Tabel pengaturan
pengaturan_id | key | value | tipe

-- 7. Tabel admin
admin_id | username | password | nama | email
```

## 4. **Alur Routing**

```
HTTP Request
    ├── /                 → LandingPage::index
    ├── /admin            → Admin\Auth::index (login)
    ├── /admin/dashboard  → Admin\Dashboard::index
    ├── /admin/hero       → Admin\Hero::index (CRUD)
    ├── /admin/fitur      → Admin\Fitur::index (CRUD)
    ├── /admin/galeri     → Admin\Galeri::index (CRUD)
    ├── /admin/testimoni  → Admin\Testimoni::index (CRUD)
    └── /admin/kontak     → Admin\Kontak::index (CRUD)
```

## 5. **Alur CRUD Sederhana**

### CREATE (Tambah Data)
```
Form Input → Validasi → Upload File (jika ada) → Simpan ke DB → Redirect dengan pesan sukses
```

### READ (Tampil Data)
```
Ambil dari DB → Loop data → Tampilkan di view
```

### UPDATE (Edit Data)
```
Pilih ID → Ambil data → Tampilkan di form → Update DB → Redirect
```

### DELETE (Hapus Data)
```
Pilih ID → Hapus file (jika ada) → Hapus dari DB → Redirect
```

## 6. **Alur Autentikasi**

### Login
```
Input username/password → Cek ke DB → Cocok? → Set session → Redirect ke dashboard
                    ↓
                Tidak cocok → Kembali ke login dengan error
```

### Logout
```
Klik logout → Hapus session → Redirect ke halaman login
```

### Proteksi Halaman
```
Akses halaman admin → Cek session? → Ada → Tampilkan halaman
                            ↓
                        Tidak ada → Redirect ke login
```

## 7. **Alur Upload File**

```
Pilih file → Validasi type/ukuran → Generate nama unik → Pindahkan ke folder uploads → Simpan nama file ke DB
```

## 8. **Alur Tampilan Landing Page**

```
Landing Page Controller
    ├── Ambil data hero dari DB
    ├── Ambil data fitur dari DB
    ├── Ambil data galeri dari DB
    ├── Ambil data testimoni dari DB
    └── Ambil data kontak dari DB
            ↓
    Kirim semua data ke view
            ↓
    Tampilkan halaman lengkap
```

## 9. **Struktur Controller Sederhana**

### Landing Page Controller
- `index()` - Menampilkan semua section

### Admin Base Controller
- `__construct()` - Cek login

### Hero Controller
- `index()` - Tampil data
- `create()` - Form tambah
- `save()` - Simpan data
- `edit($id)` - Form edit
- `update($id)` - Update data
- `delete($id)` - Hapus data

*(Pattern yang sama untuk Fitur, Galeri, Testimoni)*

## 10. **Flow Penggunaan Sistem**

```
1. Admin login ke panel
2. Pilih menu yang akan diedit
3. Tambah/edit konten (teks, gambar)
4. Simpan perubahan
5. Buka landing page untuk lihat hasil
6. Ulangi langkah 2-5 sesuai kebutuhan
```

## 11. **Keamanan Sederhana**

- Password di-hash (bcrypt)
- Session untuk login
- Validasi input
- Filter tipe file upload
- Proteksi route admin

## 12. **Teknologi yang Digunakan**

- **Backend:** CodeIgniter 4 (PHP)
- **Database:** MySQL
- **Frontend:** Tailwind CSS (untuk cepat)
- **Upload:** File system lokal

---

Dengan alur ini, Anda bisa mulai membuat CMS sederhana untuk landing page PPDB secara bertahap. Mulai dari setup database, buat model, controller, dan view sesuai urutan di atas.