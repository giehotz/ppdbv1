
## 8. Kekurangan (Weaknesses)

### 8.1 Duplikasi Kode (Code Duplication)

| # | Kekurangan | Severity | Detail |
|---|-----------|----------|--------|
| 1 | **Upload berkas ~90% copy-paste** | 🔴 Tinggi | `Siswa\Pindahan::uploadBerkas()` (L456-545) dan `Verifikator\Pindahan::doUploadBerkas()` (L368-452) nyaris identik. Perubahan di salah satu harus direplikasi manual ke yang lain. |
| 2 | **Verify logic duplikat** | 🔴 Tinggi | `Admin::verify()` dan `Verifikator::verify()` hampir 95% identik (perbedaan hanya nama verifikator default). |
| 3 | **Hitung rata-rata inline** | 🟡 Sedang | `Verifikator::biodataStore()` menduplikasi logika `hitungRataRata()` yang sudah ada sebagai method di Siswa controller. |
| 4 | **Normalisasi jenjang inline** | 🟡 Sedang | `Verifikator::biodataStore()` menduplikasi normalisasi jenjang yang sudah ada di `Siswa::normalizeJenjangData()`. |
| 5 | **`resolvePhotoUrl()` duplikat** | 🟢 Rendah | Identik di Admin dan Verifikator controller — seharusnya di Model atau BaseController. |

### 8.2 Arsitektur & Design

| # | Kekurangan | Severity | Detail |
|---|-----------|----------|--------|
| 6 | ~~**View admin terlalu besar**~~ | ✅ Fixed | `admin/index.php` (89.5 KB) dipecah menjadi 7 partials (`_header`, `_filter_tabs`, `_table`, `_bulk_actions`, `_modals`, `_scripts`) — file utama kini **32 baris**. |
| 7 | ~~**View verifikator/detail terlalu besar**~~ | ✅ Fixed | `verifikator/detail.php` (46.6 KB) dipecah menjadi 10 partials — file utama kini **56 baris**; data partial di-`setData()` di parent view body. |
| 8 | ~~**Fat controller**~~ | ✅ Fixed | Business logic (sanitasi, normalisasi, rata-rata, verify, delete, finalize) dipindah ke `PindahanService`; controller kini delegasi ke service. |
| 9 | ~~**Tidak ada Service Layer**~~ | ✅ Fixed | Dibuat `app/Services/PindahanService.php` yang mengabstraksi business logic, digunakan oleh Admin, Siswa, dan Verifikator. |
| 10 | ~~**Direct DB query di Controller**~~ | ✅ Fixed | `Siswa\Pindahan::biodata()` kini memakai `PenghasilanModel::getAllOrdered()` dan `PekerjaanModel::getAllOrdered()` — tidak lagi `$db->table()` langsung. |
| 11 | ~~**Model `getStatusCounts()` raw SQL**~~ | ✅ Fixed | `getStatusCounts()` jadi single-query `COUNT(CASE WHEN ...)`; `getStudents()` memakai konstanta status; kondisi incomplete di-ekstrak ke satu `buildIncompleteCondition()`. |
| 12 | ~~**Constructor DI tidak konsisten**~~ | ✅ Fixed | Ketiga controller memakai optional constructor-injection (`PindahanService|SiswaPindahanModel|null ... = null` + fallback `?? new ...`) — konsisten. |

> **Status:** 7 kelemahan §8.2 telah diperbaiki pada 2026-09-11: view dipecah ke partials (R2), dibuat `PindahanService` (R1), query langsung diganti model, `getStatusCounts()` dioptimasi single-query (R6), dan constructor DI konsisten (R7).

> **Perubahan 2026-09-11:** Fitur "Sekolah Tujuan" (8 kolom: `npsn_sekolah_tujuan`, `nama_sekolah_tujuan`, `alamat_sekolah_tujuan`, `kota_tujuan`, `provinsi_tujuan`, `jenjang_sekolah_tujuan`, `grup_jenjang_tujuan`, `kelas_tujuan`) **dihapus** karena tidak terpakai dan membuat persentase kelengkapan biodata tidak pernah 100%. Melibatkan migration `2026-09-11-000000_DropSekolahTujuanFromTblSiswaPindahan`, penghapusan `PindahanConfig::isJenjangSetara()` & `getJenjangSejenis()`, `SiswaPindahanModel::getJenjangTujuanOptions()` & `setGrupJenjang()`, serta pembersihan semua view/controller terkait. `calculateCompletionPercentage()` kini hanya menghitung asal (18 field, termasuk `kelas_diterima` yang ditambahkan 2026-09-11 via migration `2026-09-11-000001_AddKelasDiterimaToTblSiswaPindahan`).

### 8.3 Keamanan

| # | Kekurangan | Severity | Status | Detail |
|---|-----------|----------|--------|--------|
| 13 | ~~**`skipValidation(true)` berulang**~~ | 🔴 Tinggi | ✅ Fixed | Dihapus `skipValidation(true)` di `Verifikator\Pindahan`, `Siswa\Pindahan`, dan `PindahanService`; model validation diaktifkan dengan penanganan error yang tepat. |
| 14 | ~~**Hapus Admin vs Verifikator tidak simetris**~~ | 🟡 Sedang | ✅ Fixed | Admin dan Verifikator kini konsisten menggunakan `PindahanService::deletePindahanPermanently()` — file fisik dan relasi DB dibersihkan tanpa meninggalkan orphaned file. |
| 15 | ~~**Password tersimpan di session**~~ | 🟡 Sedang | ✅ Fixed | Plain text password dihapus segera dari session setelah dicetak (`session()->remove('pindahan_pwd_' . $id)`) dan dihapus dari `Admin\Pindahan::resetPassword`. |
| 16 | ~~**Flash message mengandung HTML**~~ | 🟢 Rendah | ✅ Fixed | Tag HTML `<strong>` dihapus dari flash message `resetPassword()` agar aman dari potensi injeksi/salah render. |
| 17 | ~~**`mkdir 0777`**~~ | 🟢 Rendah | ✅ Fixed | Seluruh pemanggilan `mkdir()` pada upload direktori berkas dan profil diubah ke permission aman `0755`. |

> **Status:** 5 kelemahan keamanan §8.3 telah diperbaiki pada 2026-09-11: validasi model aktif, penghapusan simetris dan bersih, session password langsung dibersihkan, flash message plain-text, dan permission direktori 0755.

### 8.4 Performa `✅ Fixed`

| # | Kekurangan | Severity | Status | Detail & Solusi |
|---|-----------|----------|--------|-----------------|
| 18 | **N+1 kalkulasi di index** | 🟡 Sedang | `✅ Fixed` | `SiswaPindahanModel::getCompletionPercentageOnly()` & parameter `$includeDetails = false` ditambahkan untuk melewati pembuatan array field yang tidak terisi saat kalkulasi hanya butuh persentase di loop `Admin::index()` dan `Verifikator::index()`. |
| 19 | **`isWajibLengkap()` query ganda** | 🟡 Sedang | `✅ Fixed` | `BerkasPindahanModel::isWajibLengkap($idPindahan, ?array $berkasList = null)` sekarang menerima data list berkas yang sudah di-fetch controller sebelumnya, mengeliminasi query `findAll()` kedua. |
| 20 | **Clone builder / multi query di `getStatusCounts()`** | 🟢 Rendah | `✅ Fixed` | Dioptimalkan menjadi single query aggregation dengan `SUM(CASE WHEN status_verifikasi = ... THEN 1 ELSE 0 END)` pada `BerkasPindahanModel` dan `SiswaPindahanModel`. |

> **Status:** 3 poin performa §8.4 telah dioptimasi pada 2026-09-11: penghematan query builder berkas menjadi 1 query, bypass query ganda pada berkas wajib, dan kalkulasi persentase ringan tanpa alokasi array label field kosong pada list index.

### 8.5 Maintenance & Testing `✅ Fixed`

| # | Kekurangan | Severity | Status | Detail & Solusi |
|---|-----------|----------|--------|-----------------|
| 21 | **Tidak ada unit test** | 🟡 Sedang | `✅ Fixed` | Dibuat test suite `tests/unit/PindahanModuleTest.php` dan `tests/unit/PindahanConfigTest.php` (total 17 test, 115 assertions passing) yang mencakup aturan jenjang, kalkulasi kelengkapan, checklist berkas wajib, konstanta, dan helper service. |
| 22 | **Magic string / hardcoded status** | 🟡 Sedang | `✅ Fixed` | Menggunakan `SiswaPindahanModel::STATUS_*`, `ALL_STATUS`, `PENDAFTARAN_*`, dan `BerkasPindahanModel::STATUS_*`, `ALL_STATUS` di seluruh controller, model, dan `PindahanService`. |
| 23 | **Tidak ada constants untuk file size/type** | 🟢 Rendah | `✅ Fixed` | Konstanta `PindahanConfig::MAX_FILE_SIZE`, `ALLOWED_MIME_TYPES`, dan `ALLOWED_FILE_EXTENSIONS` telah didefinisikan dan digunakan di `PindahanService::doUploadBerkas()`. |

> **Status:** 3 poin maintenance & testing §8.5 telah diselesaikan pada 2026-09-11: test suite komprehensif aktif, magic string digantikan class constants, dan limit/ekstensi upload berkas tersentralisasi pada config.

---

## 9. Rekomendasi Perbaikan

### 9.1 Prioritas Tinggi

#### R1. Buat Service Layer (`PindahanService`)
Pindahkan business logic yang duplikat ke sebuah service class:

```
app/Services/PindahanService.php
├── sanitizeBiodata(array $raw): array
├── normalizeJenjangData(array $data): array
├── hitungRataRata(array $data): array
├── uploadBerkas(int $idPindahan, $file, string $jenisBerkas): bool
├── deleteBerkas(int $idBerkas): bool
├── verify(int $idPindahan, string $status, string $catatan, string $actor): void
└── resolvePhotoUrl(?string $fotoPath): ?string
```

**Dampak:** Menghilangkan ~6 titik duplikasi kode, mempermudah unit testing, dan menjamin konsistensi behavior lintas controller.

#### R2. Pecah View Besar ke Partials

```
admin/index.php (89.5 KB) → split menjadi:
├── admin/_table_header.php
├── admin/_table_row.php
├── admin/_filter_tabs.php
├── admin/_bulk_actions.php
├── admin/_modals.php
└── admin/_scripts.php

verifikator/detail.php (46.6 KB) → split menjadi:
├── verifikator/detail/_biodata_card.php
├── verifikator/detail/_berkas_section.php
├── verifikator/detail/_verifikasi_panel.php
├── verifikator/detail/_timeline.php
└── verifikator/detail/_actions.php
```

#### R3. Hapus `skipValidation(true)` — Perbaiki Validation Rules

Daripada melewati validasi, perbaiki `$validationRules` pada model agar menerima field yang perlu di-update secara parsial (gunakan `permit_empty` yang sudah ada, atau buat rule groups).

### 9.2 Prioritas Sedang

#### R4. Gunakan Enum/Constants untuk Status

```php
// app/Enums/StatusVerifikasi.php (atau di PindahanConfig)
class StatusVerifikasi {
    const MENUNGGU      = 'Menunggu';
    const TERVERIFIKASI = 'Terverifikasi';
    const DITOLAK       = 'Ditolak';
    
    const ALL = [self::MENUNGGU, self::TERVERIFIKASI, self::DITOLAK];
}
```

#### R5. Konsistenkan Delete Behavior

- Admin: soft delete ✅ (benar)
- Verifikator: hard delete + file fisik ❌ (tidak konsisten)

**Rekomendasi:** Seharusnya kedua role menggunakan soft delete sebagai default. Hard delete hanya via admin dengan konfirmasi ganda (atau cron cleanup).

#### R6. Optimasi `getStatusCounts()` — Single Query

```sql
SELECT
    COUNT(*) as total,
    SUM(CASE WHEN status_verifikasi IN ('Menunggu','') OR status_verifikasi IS NULL THEN 1 ELSE 0 END) as menunggu,
    SUM(CASE WHEN status_verifikasi = 'Terverifikasi' THEN 1 ELSE 0 END) as terverifikasi,
    SUM(CASE WHEN status_verifikasi = 'Ditolak' THEN 1 ELSE 0 END) as ditolak
FROM tbl_siswa_pindahan
WHERE deleted_at IS NULL
```

#### R7. Gunakan CI4 Dependency Injection

```php
// Bukan:
public function __construct() {
    $this->pindahanModel = new SiswaPindahanModel();
}

// Tapi:
public function __construct(
    protected SiswaPindahanModel $pindahanModel,
    protected BerkasPindahanModel $berkasModel,
    protected VerifikasiPindahanModel $verifikasiModel,
) {}
```

#### R8. Extract Upload Config ke Constants

```php
// Di PindahanConfig atau BerkasPindahanModel
const MAX_FILE_SIZE = 2048000; // 2 MB
const ALLOWED_MIMES = ['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'];
const ALLOWED_EXTS  = ['jpg', 'jpeg', 'png', 'pdf'];
const UPLOAD_DIR_PERMISSION = 0755; // bukan 0777
```

### 9.3 Prioritas Rendah

#### R9. Buat Model untuk `tbl_penghasilan` dan `tbl_pekerjaan`
Ganti direct DB query di controller dengan model khusus.

#### R10. Tambahkan Unit Test
Minimal test untuk:
- `PindahanConfig::normalizeJenjang()` / `getGrupName()`
- `SiswaPindahanModel::calculateCompletionPercentage()`
- `BerkasPindahanModel::isWajibLengkap()`
- Upload/delete berkas flow

#### R11. Tambahkan Type Hints & Return Types
Model dan controller belum konsisten menggunakan PHP 8 type hints (terutama return type).

---

## 10. Ringkasan Skor

| Aspek | Skor | Catatan |
|-------|:----:|---------|
| **Organisasi Modul** | 9/10 | Isolasi sangat baik, namespace rapi |
| **Keamanan** | 7/10 | Validasi baik tapi `skipValidation` dan plain-text password di session |
| **Code Reusability** | 5/10 | Banyak duplikasi lintas controller |
| **Maintainability** | 5/10 | View terlalu besar, tidak ada service layer |
| **Performa** | 7/10 | Cukup baik, beberapa optimasi minor diperlukan |
| **Testing** | 2/10 | Tidak ada test suite |
| **UX/Feature Richness** | 9/10 | Auto-save, smart alert, dark mode, cetak, export |
| **Skor Keseluruhan** | **6.3/10** | Fungsionalitas kaya, arsitektur internal perlu refactoring |

---

> **Quick Win:** Memulai dengan R1 (Service Layer) dan R4 (Enum/Constants) akan memberikan dampak terbesar dengan effort paling kecil. R2 (pecah view) penting untuk maintainability jangka panjang.

> **Prioritas paling kritis:** Hilangkan `skipValidation(true)` (R3) dan konsistenkan delete behavior (R5) — keduanya menyangkut integritas data.
