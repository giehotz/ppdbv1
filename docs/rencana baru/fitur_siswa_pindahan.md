# RANCANGAN FITUR: SISWA PINDAHAN
## PPDB v1 - Modul Terpisah Penuh

**Tanggal:** 10 September 2026  
**Status:** Rancangan (Draft)  
**Scope:** MVC baru sepenuhnya (Models, Controllers, Views) — tidak memodifikasi file MVC siswa reguler yang sudah ada.

---

## 1. RINGKASAN EKSEKUTIF

Fitur **Siswa Pindahan** adalah modul terpisah penuh dari siswa reguler yang menangani:
- Pendaftaran siswa yang **pindah dari Sekolah A → Sekolah B**
- **Aturan utama:** Sekolah asal dan sekolah tujuan **harus satu jenjang/setara** (contoh: SD→SD, MI→MI, SD→MI, SMP→SMP, MTs→MTs, SMP→MTs, dst.)
- Upload dokumen khusus pindahan (surat pindah dari sekolah asal, surat pindah dari Dapodik/EMIS, KK, ijazah, rapor, dll.)
- Verifikasi dokumen oleh admin/verifikator
- Dashboard khusus untuk pengelolaan siswa pindahan

### 1.1 Konsep Inti: Transfer Sekolah Sejenjang

Sistem ini **khusus** untuk siswa yang berpindah antar sekolah dalam jenjang yang **setara/sejenis**:

```
SEKOLAH ASAL ──────→ SEKOLAH TUJUAN
   (A)                      (B)
   ║                        ║
   ╚══ JENJANG SAMA/SETARA ═╝
```

**Contoh transfer yang diperbolehkan:**
| Sekolah Asal | Sekolah Tujuan | Status |
|---|---|---|
| SD | SD | ✅ Diperbolehkan |
| SD | MI | ✅ Diperbolehkan (setara) |
| MI | SD | ✅ Diperbolehkan (setara) |
| MI | MI | ✅ Diperbolehkan |
| SMP | SMP | ✅ Diperbolehkan |
| SMP | MTs | ✅ Diperbolehkan (setara) |
| MTs | SMP | ✅ Diperbolehkan (setara) |
| MTs | MTs | ✅ Diperbolehkan |
| SMA | SMA | ✅ Diperbolehkan |
| SMA | MA | ✅ Diperbolehkan (setara) |
| SMA | SMK | ✅ Diperbolehkan (setara) |
| SMK | SMA | ✅ Diperbolehkan (setara) |
| SMK | SMK | ✅ Diperbolehkan |
| SMK | MA | ✅ Diperbolehkan (setara) |
| MA | SMA | ✅ Diperbolehkan (setara) |
| MA | SMK | ✅ Diperbolehkan (setara) |
| MA | MA | ✅ Diperbolehkan |
| SD | SMP | ❌ **DITOLAK** (beda jenjang) |
| SMP | SMA | ❌ **DITOLAK** (beda jenjang) |
| SMA | SD | ❌ **DITOLAK** (beda jenjang) |

**Prinsip Utama:** Total isolation — menggunakan tabel database baru (`tbl_siswa_pindahan`, `tbl_berkas_pindahan`, `tbl_verifikasi_pindahan`), model, controller, dan view baru tanpa mengubah kode siswa reguler yang sudah ada.

---

## 2. REFERENSI JENJANG SEKOLAH & ATURAN SETARA

### 2.1 Mapping Jenjang Setara

Digunakan untuk validasi otomatis bahwa sekolah asal dan tujuan berada dalam jenjang yang setara.

```php
// Config/PindahanConfig.php

class PindahanConfig
{
    /**
     * Grup jenjang yang setara/sejenis.
     * Siswa pindahan HARUS dalam grup yang sama.
     */
    public static $grupJenjang = [
        // === GRUP SD/MI (Pendidikan Dasar) ===
        'SD/MI' => [
            'SD'   => 'Sekolah Dasar (SD)',
            'MI'   => 'Madrasah Ibtidaiyah (MI)',
            'SDLB' => 'Sekolah Dasar Luar Biasa (SDLB)',
            'MIBTs' => 'Madrasah Ibtidaiyah Tsanawiyah (sederajat)',
        ],

        // === GRUP SMP/MTs (Pendidikan Menengah Pertama) ===
        'SMP/MTs' => [
            'SMP'  => 'Sekolah Menengah Pertama (SMP)',
            'MTs'  => 'Madrasah Tsanawiyah (MTs)',
            'SMPLB' => 'Sekolah Menengah Pertama Luar Biasa (SMPLB)',
            'MTsLB' => 'Madrasah Tsanawiyah Luar Biasa (sederajat)',
        ],

        // === GRUP SMA/SMK/MA (Pendidikan Menengah Atas) ===
        'SMA/SMK/MA' => [
            'SMA'  => 'Sekolah Menengah Atas (SMA)',
            'SMK'  => 'Sekolah Menengah Kejuruan (SMK)',
            'MA'   => 'Madrasah Aliyah (MA)',
            'SMALB' => 'Sekolah Menengah Atas Luar Biasa (SMLB)',
            'MALB'  => 'Madrasah Aliyah Luar Biasa (sederajat)',
        ],
    ];

    /**
     * Validasi: apakah dua jenjang setara?
     * @return bool
     */
    public static function isJenjangSetara(string $jenjangAsal, string $jenjangTujuan): bool
    {
        foreach (self::$grupJenjang as $grup) {
            $asalValid   = array_key_exists(strtoupper($jenjangAsal), $grup);
            $tujuanValid = array_key_exists(strtoupper($jenjangTujuan), $grup);
            if ($asalValid && $tujuanValid) {
                return true;
            }
        }
        return false;
    }

    /**
     * Dapatkan nama grup jenjang dari nama jenjang
     * @return string|null
     */
    public static function getGrupName(string $jenjang): ?string
    {
        $jenjang = strtoupper($jenjang);
        foreach (self::$grupJenjang as $namaGrup => $items) {
            if (array_key_exists($jenjang, $items)) {
                return $namaGrup;
            }
        }
        return null;
    }

    /**
     * Ambil semua jenjang dalam satu grup
     * @return array
     */
    public static function getJenjangSejenis(string $jenjang): array
    {
        $grupName = self::getGrupName($jenjang);
        if ($grupName === null) return [];
        return self::$grupJenjang[$grupName];
    }
}
```

### 2.2 Alur Validasi di Form

```
Siswa isi: "Sekolah Asal = SD"  dan  "Sekolah Tujuan = MI"
    ↓
Sistem cek: SD → grup "SD/MI", MI → grup "SD/MI" → ✅ DITERIMA

Siswa isi: "Sekolah Asal = SD"  dan  "Sekolah Tujuan = SMP"
    ↓
Sistem cek: SD → grup "SD/MI", SMP → grup "SMP/MTs" → ❌ DITOLAK
    ↓
Error: "Sekolah asal dan tujuan harus berada dalam jenjang yang setara"
```

### 2.3 Tabel `tbl_siswa_pindahan`

```sql
CREATE TABLE tbl_siswa_pindahan (
    -- Primary
    id_pindahan INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    no_pendaftaran VARCHAR(20) DEFAULT NULL,
    th_pelajaran VARCHAR(20) DEFAULT NULL,
    
    -- Auth
    password TEXT NOT NULL,
    last_login DATETIME DEFAULT NULL,
    
    -- Identitas Siswa
    nisn VARCHAR(10) DEFAULT NULL,
    nik TEXT DEFAULT NULL,
    nama_lengkap VARCHAR(100) NOT NULL,
    email VARCHAR(100) DEFAULT NULL,
    jk VARCHAR(12) DEFAULT NULL,
    tempat_lahir TEXT DEFAULT NULL,
    tgl_lahir VARCHAR(10) DEFAULT NULL,
    agama VARCHAR(30) DEFAULT NULL,
    foto VARCHAR(255) DEFAULT NULL,
    
    -- Status Keluarga
    status_keluarga VARCHAR(30) DEFAULT NULL,
    anak_ke VARCHAR(100) DEFAULT NULL,
    jml_saudara VARCHAR(100) DEFAULT NULL,
    hobi VARCHAR(100) DEFAULT NULL,
    cita VARCHAR(100) DEFAULT NULL,
    
    -- Alamat
    alamat_siswa TEXT DEFAULT NULL,
    jenis_tinggal VARCHAR(100) DEFAULT NULL,
    desa VARCHAR(100) DEFAULT NULL,
    kec VARCHAR(100) DEFAULT NULL,
    kab VARCHAR(100) DEFAULT NULL,
    prov VARCHAR(100) DEFAULT NULL,
    kode_pos VARCHAR(100) DEFAULT NULL,
    no_hp_siswa VARCHAR(14) DEFAULT NULL,
    
    -- Kartu Keluarga
    no_kk VARCHAR(20) DEFAULT NULL,
    kepala_keluarga VARCHAR(100) DEFAULT NULL,
    
    -- Data Ayah
    nama_ayah VARCHAR(100) DEFAULT NULL,
    nik_ayah VARCHAR(100) DEFAULT NULL,
    tempat_lahir_ayah TEXT DEFAULT NULL,
    tgl_lahir_ayah TEXT DEFAULT NULL,
    status_ayah VARCHAR(100) DEFAULT NULL,
    pdd_ayah VARCHAR(100) DEFAULT NULL,
    pekerjaan_ayah VARCHAR(100) DEFAULT NULL,
    penghasilan_ayah VARCHAR(100) DEFAULT NULL,
    
    -- Data Ibu
    nama_ibu VARCHAR(100) DEFAULT NULL,
    nik_ibu VARCHAR(100) DEFAULT NULL,
    tempat_lahir_ibu TEXT DEFAULT NULL,
    tgl_lahir_ibu TEXT DEFAULT NULL,
    status_ibu VARCHAR(100) DEFAULT NULL,
    pdd_ibu VARCHAR(100) DEFAULT NULL,
    pekerjaan_ibu VARCHAR(100) DEFAULT NULL,
    penghasilan_ibu VARCHAR(100) DEFAULT NULL,
    
    -- Data Wali (opsional)
    nama_wali VARCHAR(100) DEFAULT NULL,
    nik_wali VARCHAR(100) DEFAULT NULL,
    tgl_lahir_wali TEXT DEFAULT NULL,
    pdd_wali VARCHAR(100) DEFAULT NULL,
    pekerjaan_wali VARCHAR(100) DEFAULT NULL,
    penghasilan_wali VARCHAR(100) DEFAULT NULL,
    no_hp_ortu VARCHAR(14) DEFAULT NULL,
    
    -- ═══════════════════════════════════════════════════════════
    -- DATA KHUSUS PINDAHAN: SEKOLAH ASAL → SEKOLAH TUJUAN
    -- Aturan: jenjang_asal DAN jenjang_tujuan HARUS SETARA
    -- ═══════════════════════════════════════════════════════════

    -- === SEKOLAH ASAL (dari mana siswa pindah) ===
    npsn_sekolah_asal VARCHAR(10) DEFAULT NULL,
    nama_sekolah_asal VARCHAR(100) DEFAULT NULL,
    alamat_sekolah_asal TEXT DEFAULT NULL,
    kota_asal VARCHAR(100) DEFAULT NULL,              -- kota/kabupaten sekolah asal
    provinsi_asal VARCHAR(100) DEFAULT NULL,
    jenjang_sekolah_asal VARCHAR(50) DEFAULT NULL,     -- SD/MI/SMP/MTs/SMA/SMK/MA
    grup_jenjang_asal VARCHAR(50) DEFAULT NULL,        -- auto: 'SD/MI', 'SMP/MTs', 'SMA/SMK/MA'
    tahun_masuk_sekolah_asal VARCHAR(10) DEFAULT NULL,
    tahun_keluar_sekolah_asal VARCHAR(10) DEFAULT NULL,
    kelas_sekolah_asal VARCHAR(20) DEFAULT NULL,       -- kelas terakhir di sekolah asal
    jurusan_sekolah_asal VARCHAR(100) DEFAULT NULL,    -- untuk SMK/SMA jurusan
    no_ijazah_sekolah_asal VARCHAR(50) DEFAULT NULL,
    tgl_ijazah_sekolah_asal VARCHAR(10) DEFAULT NULL,
    
    -- === SEKOLAH TUJUAN (ke mana siswa pindah / PPDB ini) ===
    npsn_sekolah_tujuan VARCHAR(10) DEFAULT NULL,
    nama_sekolah_tujuan VARCHAR(100) DEFAULT NULL,
    alamat_sekolah_tujuan TEXT DEFAULT NULL,
    kota_tujuan VARCHAR(100) DEFAULT NULL,
    provinsi_tujuan VARCHAR(100) DEFAULT NULL,
    jenjang_sekolah_tujuan VARCHAR(50) DEFAULT NULL,   -- harus setara dengan jenjang_asal
    grup_jenjang_tujuan VARCHAR(50) DEFAULT NULL,       -- auto: harus SAMA dengan grup_jenjang_asal
    
    -- === ALASAN PINDAH ===
    alasan_pindah TEXT DEFAULT NULL,
    alasan_pindah_kategori VARCHAR(50) DEFAULT NULL,    -- mutasi_orang_tua, pindah_domisili, putus_sekolah, lainnya
    
    -- === KELAS YANG DITUJU DI SEKOLAH BARU ===
    kelas_tujuan VARCHAR(20) DEFAULT NULL,              -- kelas yang akan dimasuki (misal: kelas 5)
    
    -- Rapor / Nilai Terakhir
    rata_rata_nilai DECIMAL(5,2) DEFAULT NULL,
    nilai_bahasa_indonesia DECIMAL(5,2) DEFAULT NULL,
    nilai_bahasa_inggris DECIMAL(5,2) DEFAULT NULL,
    nilai_matematika DECIMAL(5,2) DEFAULT NULL,
    nilai_ipa DECIMAL(5,2) DEFAULT NULL,
    nilai_ips DECIMAL(5,2) DEFAULT NULL,
    nilai_pkn DECIMAL(5,2) DEFAULT NULL,
    nilai_agama DECIMAL(5,2) DEFAULT NULL,
    nilai_penjaskes DECIMAL(5,2) DEFAULT NULL,
    nilai_seni_budaya DECIMAL(5,2) DEFAULT NULL,
    
    -- Data Kesejahteraan (sama seperti siswa reguler)
    no_kks VARCHAR(100) DEFAULT NULL,
    file_kks VARCHAR(255) DEFAULT NULL,
    no_pkh VARCHAR(100) DEFAULT NULL,
    file_pkh VARCHAR(255) DEFAULT NULL,
    no_kip VARCHAR(100) DEFAULT NULL,
    file_kip VARCHAR(255) DEFAULT NULL,
    komp_ahli VARCHAR(100) DEFAULT NULL,
    
    -- Pendaftaran
    jalur_pendaftaran VARCHAR(50) DEFAULT 'pindahan',
    tgl_pindahan DATETIME DEFAULT CURRENT_TIMESTAMP,
    
    -- Verifikasi
    status_verifikasi VARCHAR(30) DEFAULT 'Menunggu',  -- Menunggu/Terverifikasi/Ditolak
    status_pendaftaran VARCHAR(20) DEFAULT 'Draft',    -- Draft/Final
    tgl_verifikasi DATETIME DEFAULT NULL,
    verified_by INT(11) DEFAULT NULL,
    catatan_verifikasi TEXT DEFAULT NULL,
    
    -- Status
    status_berkas VARCHAR(50) DEFAULT NULL,
    status_lulus VARCHAR(50) DEFAULT 'Pending',  -- Pending/Lulus/Tidak Lulus
    is_checked TINYINT(1) DEFAULT 0,
    
    -- Timestamps
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at DATETIME DEFAULT NULL,
    
    PRIMARY KEY (id_pindahan),
    KEY idx_no_pendaftaran (no_pendaftaran),
    KEY idx_nisn (nisn),
    KEY idx_th_pelajaran (th_pelajaran),
    KEY idx_status_verifikasi (status_verifikasi),
    KEY idx_jalur_pendaftaran (jalur_pendaftaran)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

### 2.2 Tabel `tbl_berkas_pindahan`

```sql
CREATE TABLE tbl_berkas_pindahan (
    id_berkas_pindahan INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    id_pindahan INT(11) UNSIGNED NOT NULL,
    jenis_berkas VARCHAR(100) NOT NULL,  -- surat_pindah_sekolah, surat_pindah_dapodik, kk, ijazah, rapor, sktm, ktp_orang_tua, dll.
    nama_file VARCHAR(255) NOT NULL,
    path_file VARCHAR(500) NOT NULL,
    ukuran_file VARCHAR(20) DEFAULT NULL,
    deskripsi TEXT DEFAULT NULL,
    keterangan TEXT DEFAULT NULL,
    status_verifikasi ENUM('pending','valid','invalid') DEFAULT 'pending',
    
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    PRIMARY KEY (id_berkas_pindahan),
    KEY idx_id_pindahan (id_pindahan),
    CONSTRAINT fk_berkas_pindahan FOREIGN KEY (id_pindahan) REFERENCES tbl_siswa_pindahan(id_pindahan) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

### 2.3 Tabel `tbl_verifikasi_pindahan`

```sql
CREATE TABLE tbl_verifikasi_pindahan (
    id_verifikasi_pindahan INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    id_pindahan INT(11) UNSIGNED NOT NULL,
    isi TEXT DEFAULT NULL,
    ket VARCHAR(100) DEFAULT NULL,
    tgl_verifikasi DATETIME DEFAULT CURRENT_TIMESTAMP,
    verifikator INT(11) DEFAULT NULL,
    
    PRIMARY KEY (id_verifikasi_pindahan),
    KEY idx_id_pindahan (id_pindahan),
    CONSTRAINT fk_verifikasi_pindahan FOREIGN KEY (id_pindahan) REFERENCES tbl_siswa_pindahan(id_pindahan) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

### 2.4 Kolom Tambahan di `tbl_user`

```sql
ALTER TABLE tbl_user ADD COLUMN can_manage_pindahan TINYINT(1) DEFAULT 1;
```

> Kolom ini opsional — bisa juga cukup di level `admin`/`verifikator` yang sudah ada. Jika ingin hak akses lebih granular.

---

## 3. JENIS DOKUMEN (berkas_pindahan)

Daftar jenis berkas yang bisa diupload oleh siswa pindahan:

| # | `jenis_berkas` | Label | Wajib? | Keterangan |
|---|---|---|---|---|
| 1 | `surat_pindah_sekolah` | Surat Pindah dari Sekolah Asal | Ya | Surat keterangan pindah dari sekolah lama |
| 2 | `surat_pindah_dapodik` | Surat Pindah dari Dapodik/EMIS | Ya | Surat resmi dari sistem Dapodik atau EMIS |
| 3 | `kk` | Kartu Keluarga (KK) | Ya | KK terbaru |
| 4 | `ijazah` | Ijazah / Surat Keterangan Lulus | Ya | Ijazah atau SKL dari sekolah asal |
| 5 | `rapor` | Rapor Terakhir | Tidak | Fotocopy rapor kelas terakhir |
| 6 | `sktm` | Surat Keterangan Tidak Mampu | Tidak | Jika ada |
| 7 | `akta_kelahiran` | Akta Kelahiran | Tidak | |
| 8 | `ktp_orang_tua` | KTP Orang Tua/Wali | Tidak | |
| 9 | `sk_orang_tua` | Surat Keterangan Kerja Orang Tua | Tidak | Surat mutasi/penugasan |
| 10 | `surat_pernyataan` | Surat Pernyataan Orang Tua | Ya | Surat pernyataan kebenaran data |
| 11 | `foto_siswa` | Foto Siswa | Ya | Pas foto terbaru |
| 12 | `dokumen_lainnya` | Dokumen Lainnya | Tidak | Bebas |

---

## 4. MVC STRUCTURE — FILES TO CREATE

### 4.1 Models (`app/Models/Pindahan/`)

| File | Class | Table | Purpose |
|---|---|---|---|
| `SiswaPindahanModel.php` | `SiswaPindahanModel` | `tbl_siswa_pindahan` | CRUD utama siswa pindahan. Mirip `SiswaModel` dengan metode: `getStudents()`, `getStatusCounts()`, `getStudentDetail()`, `calculateCompletionPercentage()` |
| `BerkasPindahanModel.php` | `BerkasPindahanModel` | `tbl_berkas_pindahan` | Upload/manajemen dokumen. Metode: `getByPindahan()`, `getDocumentsWithStudent()`, `getStatusCounts()`, `deleteFile()` |
| `VerifikasiPindahanModel.php` | `VerifikasiPindahanModel` | `tbl_verifikasi_pindahan` | Riwayat verifikasi. Metode: `getByPindahan()`, `getLatest()`, `insertLog()` |

**Detail SiswaPindahanModel:**
```php
class SiswaPindahanModel extends Model
{
    protected $table            = 'tbl_siswa_pindahan';
    protected $primaryKey       = 'id_pindahan';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $useTimestamps    = false;
    protected $deletedField     = 'deleted_at';

    protected $allowedFields = [
        'no_pendaftaran', 'th_pelajaran', 'password', 'last_login',
        'nisn', 'nik', 'nama_lengkap', 'email', 'jk', 'tempat_lahir',
        'tgl_lahir', 'agama', 'foto',
        'status_keluarga', 'anak_ke', 'jml_saudara', 'hobi', 'cita',
        'alamat_siswa', 'jenis_tinggal', 'desa', 'kec', 'kab', 'prov',
        'kode_pos', 'no_hp_siswa',
        'no_kk', 'kepala_keluarga',
        'nama_ayah', 'nik_ayah', 'tempat_lahir_ayah', 'tgl_lahir_ayah',
        'status_ayah', 'pdd_ayah', 'pekerjaan_ayah', 'penghasilan_ayah',
        'nama_ibu', 'nik_ibu', 'tempat_lahir_ibu', 'tgl_lahir_ibu',
        'status_ibu', 'pdd_ibu', 'pekerjaan_ibu', 'penghasilan_ibu',
        'nama_wali', 'nik_wali', 'tgl_lahir_wali', 'pdd_wali',
        'pekerjaan_wali', 'penghasilan_wali', 'no_hp_ortu',
        // === KHUSUS PINDAHAN: SEKOLAH ASAL ===
        'npsn_sekolah_asal', 'nama_sekolah_asal', 'alamat_sekolah_asal',
        'kota_asal', 'provinsi_asal',
        'jenjang_sekolah_asal', 'grup_jenjang_asal',
        'tahun_masuk_sekolah_asal', 'tahun_keluar_sekolah_asal',
        'kelas_sekolah_asal', 'jurusan_sekolah_asal',
        'no_ijazah_sekolah_asal', 'tgl_ijazah_sekolah_asal',
        // === KHUSUS PINDAHAN: SEKOLAH TUJUAN ===
        'npsn_sekolah_tujuan', 'nama_sekolah_tujuan', 'alamat_sekolah_tujuan',
        'kota_tujuan', 'provinsi_tujuan',
        'jenjang_sekolah_tujuan', 'grup_jenjang_tujuan',
        'kelas_tujuan',
        // === ALASAN PINDAH ===
        'alasan_pindah', 'alasan_pindah_kategori',
        'rata_rata_nilai', 'nilai_bahasa_indonesia', 'nilai_bahasa_inggris',
        'nilai_matematika', 'nilai_ipa', 'nilai_ips', 'nilai_pkn',
        'nilai_agama', 'nilai_penjaskes', 'nilai_seni_budaya',
        'no_kks', 'file_kks', 'no_pkh', 'file_pkh', 'no_kip', 'file_kip',
        'komp_ahli',
        'jalur_pendaftaran', 'tgl_pindahan',
        'status_verifikasi', 'status_pendaftaran', 'tgl_verifikasi',
        'verified_by', 'catatan_verifikasi',
        'status_berkas', 'status_lulus', 'is_checked',
    ];

    // Metode mirip SiswaModel
    public function getActiveThPelajaran() { /* ... */ }
    public function getStatusCounts($thPelajaran) { /* ... */ }
    public function getStudents($search, $perPage, $sortOrder, $thPelajaran, $tab) { /* ... */ }
    public function getStudentDetail($id) { /* ... */ }
    public function calculateCompletionPercentage($siswa) { /* ... */ }
}
```

### 4.2 Controllers

#### `app/Controllers/Siswa/Pindahan.php` — Siswa Self-Service

| Method | Route | Purpose |
|---|---|---|
| `index()` | GET `/siswa/pindahan/dashboard` | Dashboard pindahan |
| `biodata()` | GET `/siswa/pindahan/biodata` | Form wizard biodata pindahan |
| `updateBiodata()` | POST `/siswa/pindahan/biodata/update` | Simpan biodata |
| `autoSave()` | POST `/siswa/pindahan/biodata/auto-save` | AJAX autosave |
| `finalize()` | POST `/siswa/pindahan/biodata/finalize` | Finalisasi biodata |
| `berkas()` | GET `/siswa/pindahan/berkas` | Halaman upload dokumen |
| `uploadBerkas()` | POST `/siswa/pindahan/berkas/upload` | Upload dokumen |
| `deleteBerkas($id)` | POST `/siswa/pindahan/berkas/delete/{id}` | Hapus dokumen |
| `status()` | GET `/siswa/pindahan/status` | Status pendaftaran |
| `cetakFormulir()` | GET `/siswa/pindahan/cetak-formulir` | Cetak formulir |
| `cetakKartu()` | GET `/siswa/pindahan/cetak-kartu` | Cetak kartu peserta |

#### `app/Controllers/Admin/Pindahan.php` — Admin Management

| Method | Route | Purpose |
|---|---|---|
| `index()` | GET `/admin/pindahan` | Daftar siswa pindahan (paginated, filterable) |
| `detail($id)` | GET `/admin/pindahan/detail/{id}` | Detail siswa pindahan |
| `quickDetail($id)` | GET `/admin/pindahan/quick-detail/{id}` | AJAX quick detail modal |
| `verify($id)` | POST `/admin/pindahan/verify/{id}` | Verifikasi/Tolak siswa |
| `bulkVerify()` | POST `/admin/pindahan/bulk-verify` | Bulk verifikasi |
| `delete($id)` | POST `/admin/pindahan/delete/{id}` | Soft delete |
| `bulkDelete()` | POST `/admin/pindahan/bulk-delete` | Bulk soft delete |
| `resetPassword($id)` | POST `/admin/pindahan/reset-password/{id}` | Reset password |
| `cetak($id)` | GET `/admin/pindahan/cetak/{id}` | Cetak formulir |
| `cetakKartu($id)` | GET `/admin/pindahan/cetak-kartu/{id}` | Cetak kartu |
| `verifyBerkas($id)` | POST `/admin/pindahan/berkas/verify/{id}` | Verifikasi dokumen |
| `exportExcel()` | GET `/admin/pindahan/export-excel` | Export ke Excel |

#### `app/Controllers/Verifikator/Pindahan.php` — Verifikator Management

| Method | Route | Purpose |
|---|---|---|
| `index()` | GET `/verifikator/pindahan` | Daftar siswa pindahan |
| `create()` | GET `/verifikator/pindahan/create` | Form pendaftaran offline |
| `store()` | POST `/verifikator/pindahan/store` | Simpan pendaftaran offline |
| `detail($id)` | GET `/verifikator/pindahan/detail/{id}` | Detail siswa pindahan |
| `biodata($id)` | GET `/verifikator/pindahan/biodata/{id}` | Edit biodata siswa |
| `biodataStore($id)` | POST `/verifikator/pindahan/biodataStore/{id}` | Simpan biodata |
| `berkas($id)` | GET `/verifikator/pindahan/berkas/{id}` | Kelola dokumen siswa |
| `berkasUpload($id)` | POST `/verifikator/pindahan/berkasUpload/{id}` | Upload untuk siswa |
| `berkasDelete($id)` | POST `/verifikator/pindahan/berkasDelete/{id}` | Hapus dokumen |
| `verify($id)` | POST `/verifikator/pindahan/verify/{id}` | Verifikasi siswa |
| `cetakAkun($id)` | GET `/verifikator/pindahan/cetak-akun/{id}` | Cetak akun |
| `delete($id)` | POST `/verifikator/pindahan/delete/{id}` | Hard delete + cleanup |

### 4.3 Views (`app/Views/pindahan/`)

#### Layout

| File | Purpose |
|---|---|
| `layouts/siswa_pindahan.php` | Layout khusus siswa pindahan (sidebar dengan menu pindahan) |
| `layouts/admin_pindahan.php` | Bisa reuse `layouts/admin.php` dengan modifikasi sidebar via variable |

#### Siswa Views

| File | Purpose |
|---|---|
| `siswa/dashboard.php` | Dashboard siswa pindahan (milestones, status, menu) |
| `siswa/biodata/index.php` | Wizard form biodata pindahan (7 step) |
| `siswa/biodata/_data_diri.php` | Step 1: Data diri |
| `siswa/biodata/_alamat.php` | Step 2: Alamat |
| `siswa/biodata/_orang_tua.php` | Step 3: Data orang tua |
| `siswa/biodata/_asal_sekolah.php` | Step 4: Data asal sekolah (KHUSUS PINDAHAN) |
| `siswa/biodata/_sekolah_tujuan.php` | Step 5: Sekolah tujuan & alasan pindah (KHUSUS PINDAHAN) |
| `siswa/biodata/_nilai_rapor.php` | Step 6: Input nilai rapor terakhir (KHUSUS PINDAHAN) |
| `siswa/biodata/_upload_berkas.php` | Step 7: Upload dokumen pindahan |
| `siswa/biodata/_scripts.php` | JavaScript autosave + navigasi |
| `siswa/berkas/index.php` | Manajemen upload dokumen (card grid) |
| `siswa/status/index.php` | Status pendaftaran & verifikasi |

#### Admin Views

| File | Purpose |
|---|---|
| `admin/pindahan/index.php` | Daftar siswa pindahan (tabel, search, filter, bulk action) |
| `admin/pindahan/detail.php` | Detail lengkap siswa pindahan + dokumen + riwayat verifikasi |
| `admin/pindahan/cetak_kartu.php` | Cetak kartu peserta |

#### Verifikator Views

| File | Purpose |
|---|---|
| `verifikator/pindahan/index.php` | Daftar siswa pindahan |
| `verifikator/pindahan/create.php` | Form pendaftaran offline |
| `verifikator/pindahan/detail.php` | Detail siswa pindahan |
| `verifikator/pindahan/berkas.php` | Kelola dokumen siswa |
| `verifikator/pindahan/cetak_akun.php` | Cetak akun siswa |

---

## 5. ROUTE DEFINITIONS

### 5.1 `app/Config/Routes/pindahan_siswa.php`

```php
$routes->group('siswa', ['filter' => ['siswa', 'csrf']], function ($routes) {
    // Dashboard Pindahan
    $routes->get('pindahan/dashboard', 'Siswa\Pindahan::index');
    $routes->get('pindahan', 'Siswa\Pindahan::index');

    // Biodata Pindahan
    $routes->get('pindahan/biodata', 'Siswa\Pindahan::biodata');
    $routes->post('pindahan/biodata/update', 'Siswa\Pindahan::updateBiodata');
    $routes->post('pindahan/biodata/auto-save', 'Siswa\Pindahan::autoSave');
    $routes->post('pindahan/biodata/finalize', 'Siswa\Pindahan::finalize');

    // Berkas Pindahan
    $routes->get('pindahan/berkas', 'Siswa\Pindahan::berkas');
    $routes->post('pindahan/berkas/upload', 'Siswa\Pindahan::uploadBerkas');
    $routes->post('pindahan/berkas/delete/(:num)', 'Siswa\Pindahan::deleteBerkas/$1');

    // Status
    $routes->get('pindahan/status', 'Siswa\Pindahan::status');

    // Cetak
    $routes->get('pindahan/cetak-formulir', 'Siswa\Pindahan::cetakFormulir');
    $routes->get('pindahan/cetak-kartu', 'Siswa\Pindahan::cetakKartu');
});
```

### 5.2 `app/Config/Routes/admin_pindahan.php`

```php
$routes->group('admin', ['filter' => ['admin', 'csrf']], function ($routes) {
    $routes->get('pindahan', 'Admin\Pindahan::index');
    $routes->get('pindahan/detail/(:num)', 'Admin\Pindahan::detail/$1');
    $routes->get('pindahan/quick-detail/(:num)', 'Admin\Pindahan::quickDetail/$1');
    $routes->post('pindahan/verify/(:num)', 'Admin\Pindahan::verify/$1');
    $routes->post('pindahan/bulk-verify', 'Admin\Pindahan::bulkVerify');
    $routes->post('pindahan/delete/(:num)', 'Admin\Pindahan::delete/$1');
    $routes->post('pindahan/bulk-delete', 'Admin\Pindahan::bulkDelete');
    $routes->post('pindahan/reset-password/(:num)', 'Admin\Pindahan::resetPassword/$1');
    $routes->get('pindahan/cetak/(:num)', 'Admin\Pindahan::cetak/$1');
    $routes->get('pindahan/cetak-kartu/(:num)', 'Admin\Pindahan::cetakKartu/$1');
    $routes->post('pindahan/berkas/verify/(:num)', 'Admin\Pindahan::verifyBerkas/$1');
    $routes->get('pindahan/export-excel', 'Admin\Pindahan::exportExcel');
});
```

### 5.3 `app/Config/Routes/verifikator_pindahan.php`

```php
$routes->group('verifikator', ['filter' => ['verifikator', 'csrf']], function ($routes) {
    $routes->get('pindahan', 'Verifikator\Pindahan::index');
    $routes->get('pindahan/create', 'Verifikator\Pindahan::create');
    $routes->post('pindahan/store', 'Verifikator\Pindahan::store');
    $routes->get('pindahan/detail/(:num)', 'Verifikator\Pindahan::detail/$1');
    $routes->get('pindahan/biodata/(:num)', 'Verifikator\Pindahan::biodata/$1');
    $routes->post('pindahan/biodataStore/(:num)', 'Verifikator\Pindahan::biodataStore/$1');
    $routes->get('pindahan/berkas/(:num)', 'Verifikator\Pindahan::berkas/$1');
    $routes->post('pindahan/berkasUpload/(:num)', 'Verifikator\Pindahan::berkasUpload/$1');
    $routes->post('pindahan/berkasDelete/(:num)', 'Verifikator\Pindahan::berkasDelete/$1');
    $routes->post('pindahan/verify/(:num)', 'Verifikator\Pindahan::verify/$1');
    $routes->get('pindahan/cetak-akun/(:num)', 'Verifikator\Pindahan::cetakAkun/$1');
    $routes->post('pindahan/delete/(:num)', 'Verifikator\Pindahan::delete/$1');
});
```

---

## 6. SIDEBAR MENU UPDATE

### 6.1 Sidebar Admin (`app/Views/layouts/admin.php`)

Tambahkan menu baru di array `$sidebarMenus`:

```php
'Pindahan' => [
    ['label' => 'Dashboard Pindahan',  'icon' => 'fa-solid fa-transfer',    'url' => '/admin/pindahan'],
    ['label' => 'Data Pindahan',       'icon' => 'fa-solid fa-users',       'url' => '/admin/pindahan'],
    ['label' => 'Export Pindahan',     'icon' => 'fa-solid fa-file-export', 'url' => '/admin/pindahan/export-excel'],
],
```

### 6.2 Sidebar Verifikator (`app/Views/layouts/verifikator.php`)

Tambahkan menu baru di array `$sidebarMenus`:

```php
'Pindahan' => [
    ['label' => 'Dashboard Pindahan',  'icon' => 'fa-solid fa-transfer',   'url' => '/verifikator/pindahan'],
    ['label' => 'Daftar Pindahan',     'icon' => 'fa-solid fa-users',      'url' => '/verifikator/pindahan'],
    ['label' => 'Tambah Offline',      'icon' => 'fa-solid fa-user-plus',  'url' => '/verifikator/pindahan/create'],
],
```

### 6.3 Sidebar Siswa Pindahan (Layout Baru `layouts/siswa_pindahan.php`)

```php
$sidebarMenus = [
    'Menu Pindahan' => [
        ['label' => 'Dashboard',        'icon' => 'fa-solid fa-house',       'url' => '/siswa/pindahan/dashboard'],
        ['label' => 'Biodata',          'icon' => 'fa-solid fa-pen-to-square','url' => '/siswa/pindahan/biodata'],
        ['label' => 'Upload Berkas',    'icon' => 'fa-solid fa-upload',      'url' => '/siswa/pindahan/berkas'],
        ['label' => 'Status',           'icon' => 'fa-solid fa-clipboard-check','url' => '/siswa/pindahan/status'],
    ],
    'Cetak' => [
        ['label' => 'Cetak Formulir',   'icon' => 'fa-solid fa-print',       'url' => '/siswa/pindahan/cetak-formulir'],
        ['label' => 'Cetak Kartu',      'icon' => 'fa-solid fa-id-card',     'url' => '/siswa/pindahan/cetak-kartu'],
    ],
];
```

---

## 7. WORKFLOW — ALUR PINDAHAN SEKOLAH

### 7.1 Konsep: Dari Sekolah A → Ke Sekolah B

```
┌─────────────────────────────────────────────────────────────────┐
│                    ALUR PINDAHAN SEKOLAH                        │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│   ┌──────────────┐         ┌──────────────────┐                │
│   │  SEKOLAH A   │         │   SEKOLAH B      │                │
│   │  (Asal)      │────────▶│   (Tujuan/PPDB)  │                │
│   │              │  PINDAH  │                  │                │
│   │  Jenjang: X  │         │  Jenjang: X      │  ← HARUS SAMA │
│   └──────────────┘         └──────────────────┘                │
│                                                                 │
│   Contoh Valid:                                                 │
│   SD  → SD    ✅    SMP → SMP    ✅    SMA → SMA   ✅         │
│   SD  → MI    ✅    SMP → MTs    ✅    SMA → SMK   ✅         │
│   MI  → SD    ✅    MTs → SMP    ✅    SMK → MA    ✅         │
│                                                                 │
│   Contoh TIDAK Valid:                                           │
│   SD  → SMP   ❌    SMP → SMA    ❌    SMA → SD    ❌         │
│                                                                 │
└─────────────────────────────────────────────────────────────────┘
```

### 7.2 Pendaftaran Siswa Pindahan

```
[1] Siswa pindah register via halaman publik
    (link "Daftar Pindahan" di landing page)
        ↓
[2] ISI BIODATA — 7 Step Wizard:
    ┌─────────────────────────────────────────────────┐
    │ Step 1: DATA DIRI                               │
    │   NISN, NIK, nama, tgl lahir, agama, foto       │
    ├─────────────────────────────────────────────────┤
    │ Step 2: ALAMAT                                  │
    │   Alamat, domisili, no KK, KK                   │
    ├─────────────────────────────────────────────────┤
    │ Step 3: ORANG TUA / WALI                        │
    │   Data ayah, ibu, wali, no hp ortu              │
    ├─────────────────────────────────────────────────┤
    │ Step 4: SEKOLAH ASAL ◄═══════════════════════   │
    │   NPSN, nama, alamat, kota sekolah asal         │
    │   Jenjang: [SD ▼] [MI ▼] [SMP ▼] [MTs ▼] ...  │
    │   Tahun masuk/keluar, kelas terakhir            │
    │   No & tgl ijazah                               │
    ├─────────────────────────────────────────────────┤
    │ Step 5: SEKOLAH TUJUAN ◄══ VALIDASI JENJANG     │
    │   NPSN, nama, alamat, kota sekolah tujuan       │
    │   Jenjang: [dropdown — hanya jenjang setara]    │
    │                                                 │
    │   ⚠ SISTEM VALIDASI:                           │
    │   "SD/MI" hanya bisa → "SD/MI"                  │
    │   "SMP/MTs" hanya bisa → "SMP/MTs"              │
    │   "SMA/SMK/MA" hanya bisa → "SMA/SMK/MA"        │
    │                                                 │
    │   Alasan pindah (kategori + teks bebas)         │
    │   Kelas yang akan dimasuki                      │
    ├─────────────────────────────────────────────────┤
    │ Step 6: NILAI RAPOR TERAKHIR                    │
    │   Input nilai per mata pelajaran                │
    │   Auto-calculate rata-rata                      │
    ├─────────────────────────────────────────────────┤
    │ Step 7: UPLOAD DOKUMEN PINDAHAN                 │
    │   Surat Pindah dari Sekolah A      [WAJIB]      │
    │   Surat Pindah dari Dapodik/EMIS   [WAJIB]      │
    │   Kartu Keluarga (KK)               [WAJIB]      │
    │   Ijazah / SKL                      [WAJIB]      │
    │   Rapor Terakhir                    [opsional]   │
    │   SKTM / Surat Tidak Mampu          [opsional]   │
    │   Akta Kelahiran                    [opsional]   │
    │   KTP Orang Tua / Wali              [opsional]   │
    │   Surat Keterangan Kerja Orang Tua  [opsional]   │
    │   Surat Pernyataan Orang Tua        [WAJIB]      │
    │   Foto Siswa                        [WAJIB]      │
    │   Dokumen Lainnya                   [opsional]   │
    └─────────────────────────────────────────────────┘
        ↓
[3] Finalisasi → status_pendaftaran = 'Final'
    Sistem menampilkan ringkasan:
    ┌──────────────────────────────────────┐
    │  PINDAHAN:                           │
    │  Dari: SDN 1 Sukamaju (SD)          │
    │  Ke  : SDN 3 Cendana (SD)  ✅ Setara│
    │  Kelas: 4 → Kelas 5                 │
    │  Alasan: Pindah domisili orang tua   │
    └──────────────────────────────────────┘
        ↓
[4] Admin/Verifikator review
    → Melihat data lengkap + dokumen
    → Verifikasi / Tolak
        ↓
[5] Status kelulusan → 'Lulus' / 'Tidak Lulus'
```

### 7.3 Validasi Otomatis di Form

```php
// Di controller atau model, saat menyimpan:
use App\Config\PindahanConfig;

// Step 4: Saat user pilih jenjang asal
$jenjangAsal = $this->request->getPost('jenjang_sekolah_asal');
$grupAsal    = PindahanConfig::getGrupName($jenjangAsal);
// Simpan: $grup_jenjang_asal = 'SD/MI'

// Step 5: Saat user pilih jenjang tujuan → VALIDASI
$jenjangTujuan = $this->request->getPost('jenjang_sekolah_tujuan');

if (!PindahanConfig::isJenjangSetara($jenjangAsal, $jenjangTujuan)) {
    // TOLAK!
    return redirect()->back()->withInput()->with('error',
        "Jenjang sekolah asal ($jenjangAsal) dan tujuan ($jenjangTujuan) harus setara. " .
        "Sekolah asal您 berada di grup '" . PindahanConfig::getGrupName($jenjangAsal) . "'. " .
        "Pilih jenjang tujuan yang sesuai."
    );
}

// Jika lolos validasi:
$grupTujuan = PindahanConfig::getGrupName($jenjangTujuan);
// Simpan: $grup_jenjang_tujuan = 'SD/MI' (harus SAMA dengan grup_asal)
```

### 7.4 Filter Dropdown Jenjang Tujuan (Frontend)

### 7.4 Filter Dropdown Jenjang Tujuan (Frontend)

Saat siswa memilih jenjang asal, dropdown jenjang tujuan **otomatis difilter** hanya menampilkan jenjang yang setara.

```html
<!-- HTML/Alpine.js logic -->
<div x-data="{
    jenjangAsal: '<?= $siswa['jenjang_sekolah_asal'] ?? '' ?>',
    daftarJenjang: {
        'SD/MI': ['SD', 'MI', 'SDLB'],
        'SMP/MTs': ['SMP', 'MTs', 'SMPLB'],
        'SMA/SMK/MA': ['SMA', 'SMK', 'MA']
    },
    getGrup(jenjang) {
        for (const [grup, items] of Object.entries(this.daftarJenjang)) {
            if (items.includes(jenjang)) return grup;
        }
        return null;
    },
    get jenjangTujuanOptions() {
        const grup = this.getGrup(this.jenjangAsal);
        return grup ? this.daftarJenjang[grup] : [];
    }
}">
    <!-- Dropdown Jenjang Asal -->
    <select x-model="jenjangAsal" name="jenjang_sekolah_asal">
        <option value="">-- Pilih --</option>
        <option value="SD">SD</option>
        <option value="MI">MI</option>
        <option value="SMP">SMP</option>
        <option value="MTs">MTs</option>
        <option value="SMA">SMA</option>
        <option value="SMK">SMK</option>
        <option value="MA">MA</option>
    </select>

    <!-- Dropdown Jenjang Tujuan (terfilter otomatis) -->
    <select x-model="jenjang_tujuan" name="jenjang_sekolah_tujuan"
            :disabled="!jenjangAsal">
        <option value="">-- Pilih jenjang asal dulu --</option>
        <template x-for="j in jenjangTujuanOptions" :key="j">
            <option :value="j" x-text="j"></option>
        </template>
    </select>

    <!-- Pesan Error -->
    <template x-if="jenjangAsal && jenjangTujuanOptions.length === 0">
        <p class="text-red-500">Jenjang asal tidak dikenali</p>
    </template>
</div>
```

### 7.5 Pendaftaran Offline oleh Verifikator

```
[1] Verifikator buka form pendaftaran offline (/verifikator/pindahan/create)
[2] Isi data siswa pindahan (formulir lengkap + upload dokumen)
[3] Simpan → langsung terdaftar, status_verifikasi = 'Menunggu'
[4] Review oleh admin atau verifikator lain
```

### 7.3 Alur Verifikasi Dokumen & Data Sekolah

```
Admin/Verifikator membuka detail siswa pindahan
    ↓
[1] CEK DATA SEKOLAH (VALIDASI VISUAL):
    ┌─────────────────────────────────────────────────────┐
    │  Sekolah Asal  : SDN 1 Sukamaju (SD)               │
    │  Grup Jenjang  : SD/MI                              │
    │                                                     │
    │  Sekolah Tujuan: SDN 3 Cendana (SD)                │
    │  Grup Jenjang  : SD/MI                              │
    │  Status: ✅ SETARA                                   │
    └─────────────────────────────────────────────────────┘
    ↓
[2] CEK DOKUMEN:
    Untuk setiap dokumen:
    - Lihat preview (jika gambar/PDF)
    - Set status: pending → valid / invalid
    - Tambah catatan verifikasi
    ↓
[3] VERIFIKASI KESELURUHAN:
    - Status: Menunggu → Terverifikasi / Ditolak
    - Catatan verifikasi (wajib jika ditolak)
    ↓
[4] Log aktivitas tercatat
```

---

## 8. PERBEDAAN UTAMA DENGAN SISWA REGULER

| Aspek | Siswa Reguler | Siswa Pindahan |
|---|---|---|
| **Tabel DB** | `tbl_siswa` | `tbl_siswa_pindahan` (tabel baru) |
| **Konsep** | Mendaftar dari rumah/tps | **Transfer dari Sekolah A → Sekolah B** |
| **Data Sekolah** | Hanya asal sekolah | **Sekolah Asal + Sekolah Tujuan + Validasi jenjang setara** |
| **Validasi Jenjang** | Tidak ada | **WAJIB: jenjang asal & tujuan harus setara** |
| **Info Tambahan** | Tidak ada | Grup jenjang, kota asal/tujuan, kelas tujuan |
| **Dokumen** | Ijazah, SKL, KK, SKTM | **Surat pindah sekolah, Surat pindah Dapodik/EMIS, KK, Ijazah, Rapor** |
| **Form Biodata** | 6 step | 7 step (+ data asal sekolah + validasi jenjang tujuan + nilai rapor) |
| **Nilai Rapor** | Tidak ada form khusus | Ada form input nilai + auto average |
| **Jalur Pendaftaran** | Beberapa jalur | Khusus `pindahan` |
| **URL Prefix** | `/siswa/` | `/siswa/pindahan/` |
| **Layout Sidebar** | `layouts/siswa.php` | `layouts/siswa_pindahan.php` (menu berbeda) |
| **Admin Panel** | `/admin/siswa` | `/admin/pindahan` (panel terpisah) |
| **Verifikator Panel** | `/verifikator/siswa` | `/verifikator/pindahan` (panel terpisah) |

---

## 8A. VALIDASI JENJANG SAAT VERIFIKASI

Ketika admin/verifikator memverifikasi siswa pindahan, mereka harus memastikan:

```
✅ CEK DATA SEKOLAH:
   Sekolah Asal  : SDN 1 Sukamaju (SD)  → Grup: SD/MI
   Sekolah Tujuan : SDN 3 Cendana (SD)   → Grup: SD/MI
   Status: SETARA ✅

❌ CEK DATA SEKOLAH:
   Sekolah Asal  : SMPN 1 Harapan (SMP)  → Grup: SMP/MTs
   Sekolah Tujuan : SMKN 2 Teknologi (SMK) → Grup: SMA/SMK/MA
   Status: TIDAK SETARA ❌ → Datanya tidak seharusnya bisa masuk sistem.
                               Perlu ditelusuri apakah ada error di validasi.
```

**Opsi untuk admin:** Dapat melihat "Grup Jenjang Asal" dan "Grup Jenjang Tujuan" di detail siswa pindahan untuk verifikasi visual.

---

## 9. ALUR KONEKSI DENGAN SISTEM YANG SUDAH ADA

### 9.1 Tidak Memodifikasi File yang Ada

- **Tidak ada perubahan** pada `SiswaModel.php`, `BerkasModel.php`, atau `VerifikasiModel.php`
- **Tidak ada perubahan** pada controller siswa reguler
- **Tidak ada perubahan** pada view siswa reguler
- **Tidak ada perubahan** pada tabel `tbl_siswa`, `tbl_berkas`, `tbl_verifikasi`
- Route siswa reguler tetap di `app/Config/Routes/siswa.php`

### 9.2 File yang Dimodifikasi (Hanya Sidebar)

| File | Perubahan |
|---|---|
| `app/Views/layouts/admin.php` | Tambah menu "Pindahan" di `$sidebarMenus` |
| `app/Views/layouts/verifikator.php` | Tambah menu "Pindahan" di `$sidebarMenus` |
| `app/Config/Routes.php` | Tambah `require` untuk 3 file route baru |

---

## 10. DRAFT MIGRATION

```php
<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTblSiswaPindahan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_pindahan'                => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'no_pendaftaran'             => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'th_pelajaran'               => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'password'                   => ['type' => 'TEXT', 'null' => false],
            'last_login'                 => ['type' => 'DATETIME', 'null' => true],
            'nisn'                       => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => true],
            'nik'                        => ['type' => 'TEXT', 'null' => true],
            'nama_lengkap'               => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => false],
            'email'                      => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'jk'                         => ['type' => 'VARCHAR', 'constraint' => 12, 'null' => true],
            'tempat_lahir'               => ['type' => 'TEXT', 'null' => true],
            'tgl_lahir'                  => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => true],
            'agama'                      => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'foto'                       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            // ... semua kolom sesuai schema di atas ...
            'deleted_at'                 => ['type' => 'DATETIME', 'null' => true],
            'created_at'                 => ['type' => 'DATETIME', 'null' => true],
            'updated_at'                 => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_pindahan', true);
        $this->forge->addKey('no_pendaftaran');
        $this->forge->addKey('nisn');
        $this->forge->addKey('th_pelajaran');
        $this->forge->addKey('status_verifikasi');
        $this->forge->addKey('jalur_pendaftaran');
        $this->forge->createTable('tbl_siswa_pindahan');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_siswa_pindahan');
    }
}

class CreateTblBerkasPindahan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_berkas_pindahan' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_pindahan'        => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'jenis_berkas'       => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => false],
            'nama_file'          => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false],
            'path_file'          => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => false],
            'ukuran_file'        => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'deskripsi'          => ['type' => 'TEXT', 'null' => true],
            'keterangan'         => ['type' => 'TEXT', 'null' => true],
            'status_verifikasi'  => ['type' => 'ENUM', 'constraint' => ['pending', 'valid', 'invalid'], 'default' => 'pending'],
            'created_at'         => ['type' => 'DATETIME', 'null' => true],
            'updated_at'         => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_berkas_pindahan', true);
        $this->forge->addForeignKey('id_pindahan', 'tbl_siswa_pindahan', 'id_pindahan', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tbl_berkas_pindahan');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_berkas_pindahan');
    }
}

class CreateTblVerifikasiPindahan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_verifikasi_pindahan' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_pindahan'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'isi'                    => ['type' => 'TEXT', 'null' => true],
            'ket'                    => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'tgl_verifikasi'         => ['type' => 'DATETIME', 'null' => true],
            'verifikator'            => ['type' => 'INT', 'null' => true],
        ]);
        $this->forge->addKey('id_verifikasi_pindahan', true);
        $this->forge->addForeignKey('id_pindahan', 'tbl_siswa_pindahan', 'id_pindahan', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tbl_verifikasi_pindahan');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_verifikasi_pindahan');
    }
}
```

---

## 11. REGISTRASI PUBLIK — OPSI PENDAFTARAN

Untuk registrasi publik siswa pindahan, ada dua opsi:

### Opsi A: Link Terpisah di Landing Page
- Tambah tombol "Daftar Pindahan" di halaman landing
- URL: `/register-pindahan` atau `/pindahan/register`
- Form registrasi (NISN, email, password) mirip tapi ke `SiswaPindahanModel`

### Opsi B: Pilihan Jalur saat Registrasi
- Di form registrasi yang sudah ada, tambah pilihan "Siswa Baru" atau "Siswa Pindahan"
- Jika memilih pindahan, redirect ke form pindahan

**Rekomendasi:** Opsi A — lebih bersih dan terpisah.

---

## 12. AUTH & SESSION PINDAHAN

### 12.1 Login

Login siswa pindahan menggunakan mekanisme yang sama:
1. Cek di `tbl_user` (admin/verifikator) → gagal
2. Cek di `tbl_siswa` (siswa reguler) → gagal
3. **Baru:** Cek di `tbl_siswa_pindahan` → jika cocok, set session:
   ```php
   session()->set([
       'logged_in'  => true,
       'user_type'  => 'siswa_pindahan',  // jenis baru
       'id_siswa'   => $pindahan['id_pindahan'],
       'nama_lengkap' => $pindahan['nama_lengkap'],
       'foto'       => $pindahan['foto'] ?? null,
   ]);
   ```

### 12.2 Filter Auth

Perlu tambah pengecekan `user_type === 'siswa_pindahan'` di `SiswaFilter.php` agar bisa mengakses route pindahan. Alternatif: buat `PindahanFilter.php` baru.

**Rekomendasi:** Buat `PindahanFilter.php` baru yang mirip `SiswaFilter` tapi mengecek `user_type === 'siswa_pindahan'`.

### 12.3 Route Filter

```php
// Di Routes.php
$routes->group('siswa', ['filter' => ['pindahan', 'csrf']], function ($routes) {
    // ... routes pindahan
});
```

---

## 13. FOLDER STRUCTURE FINAL

```
app/
├── Config/
│   ├── PindahanConfig.php              ← NEW (aturan jenjang setara)
│   └── Routes/
│       ├── pindahan_siswa.php          ← NEW
│       ├── admin_pindahan.php          ← NEW
│       └── verifikator_pindahan.php    ← NEW
│
├── Controllers/
│   ├── Siswa/
│   │   └── Pindahan.php               ← NEW
│   ├── Admin/
│   │   └── Pindahan.php               ← NEW
│   └── Verifikator/
│       └── Pindahan.php               ← NEW
│
├── Filters/
│   └── PindahanFilter.php             ← NEW
│
├── Models/
│   └── Pindahan/
│       ├── SiswaPindahanModel.php     ← NEW
│       ├── BerkasPindahanModel.php    ← NEW
│       └── VerifikasiPindahanModel.php← NEW
│
├── Views/
│   ├── pindahan/
│   │   ├── layouts/
│   │   │   └── siswa_pindahan.php     ← NEW (layout siswa pindahan)
│   │   ├── siswa/
│   │   │   ├── dashboard.php          ← NEW
│   │   │   ├── berkas/
│   │   │   │   └── index.php          ← NEW
│   │   │   ├── status/
│   │   │   │   └── index.php          ← NEW
│   │   │   └── biodata/
│   │   │       ├── index.php          ← NEW
│   │   │       ├── _data_diri.php     ← NEW
│   │   │       ├── _alamat.php        ← NEW
│   │   │       ├── _orang_tua.php     ← NEW
│   │   │       ├── _asal_sekolah.php  ← NEW (KHUSUS: input jenjang asal)
│   │   │       ├── _sekolah_tujuan.php← NEW (KHUSUS: dropdown jenjang terfilter)
│   │   │       ├── _nilai_rapor.php   ← NEW (KHUSUS)
│   │   │       ├── _upload_berkas.php ← NEW (KHUSUS: dokumen pindahan)
│   │   │       └── _scripts.php       ← NEW (termasuk logic filter jenjang)
│   │   ├── admin/
│   │   │   ├── index.php              ← NEW
│   │   │   ├── detail.php             ← NEW (tampilkan grup jenjang asal & tujuan)
│   │   │   └── cetak_kartu.php        ← NEW
│   │   └── verifikator/
│   │       ├── index.php              ← NEW
│   │       ├── create.php             ← NEW
│   │       ├── detail.php             ← NEW
│   │       ├── berkas.php             ← NEW
│   │       └── cetak_akun.php         ← NEW
│   └── layouts/
│       ├── admin.php                  ← MODIFY (tambah menu sidebar)
│       └── verifikator.php            ← MODIFY (tambah menu sidebar)
│
└── Database/
    └── Migrations/
        ├── XXXX_CreateTblSiswaPindahan.php       ← NEW
        ├── XXXX_CreateTblBerkasPindahan.php      ← NEW
        └── XXXX_CreateTblVerifikasiPindahan.php  ← NEW
```

---

## 14. RINGKASAN FILE

| Aksi | File | Jumlah |
|------|------|--------|
| **NEW** | Config (1), Models (3), Controllers (3), Filters (1), Routes (3), Views (16+), Migrations (3) | **~30 file** |
| **MODIFY** | `layouts/admin.php`, `layouts/verifikator.php`, `Config/Routes.php`, `Auth.php` (login check) | **4 file** |
| **TOTAL NEW FILES** | | **~30 file** |

---

## 15. ESTIMASI PENGEMBANGAN

| Fase | Detail | Estimasi |
|------|--------|----------|
| Fase 1 | Config: PindahanConfig.php (aturan jenjang setara) | 0.5 jam |
| Fase 2 | Database: 3 tabel baru + migration | 1 jam |
| Fase 3 | Models: 3 model baru (dengan validasi jenjang) | 2 jam |
| Fase 4 | Auth: PindahanFilter + login integration | 1 jam |
| Fase 5 | Controllers: 3 controller baru (dengan validasi jenjang di form) | 4 jam |
| Fase 6 | Routes: 3 route files + registrasi di Routes.php | 0.5 jam |
| Fase 7 | Views: Layout siswa pindahan + biodata wizard (7 step) | 6 jam |
| Fase 8 | Views: Filter dropdown jenjang (Alpine.js auto-filter) | 1 jam |
| Fase 9 | Views: Admin panel (list, detail, cetak) | 3 jam |
| Fase 10 | Views: Verifikator panel (list, create, detail, berkas) | 3 jam |
| Fase 11 | Sidebar update (admin + verifikator) | 0.5 jam |
| Fase 12 | Testing & bug fixing (termasuk test validasi jenjang) | 3 jam |
| **TOTAL** | | **~25.5 jam** |

---

*Rancangan ini dirancang untuk pemisahan total dari siswa reguler. Tidak ada kode pindahan yang menyentuh tabel atau model siswa reguler. Semua operasi CRUD berdiri sendiri. Aturan inti: siswa pindah dari Sekolah A ke Sekolah B dengan **jenjang yang setara** (SD↔SD/MI, SMP↔SMP/MTs, SMA↔SMA/SMK/MA).*
