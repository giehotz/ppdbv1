Berikut adalah rancangan struktur implementasi fitur **Pembiayaan Pendaftaran** berbasis CodeIgniter 4 sebagai modul tambahan pada sistem yang sudah ada. Hanya struktur direktori, penamaan kelas, file, dan metode utama yang disebutkan—tanpa baris kode.

---

## 1. Asumsi Sistem Existing
- Sudah terdapat autentikasi dengan grup/role `admin` dan `verifikator`.
- Data siswa (`siswa`) sudah ada (model: `SiswaModel`, tabel: `siswa`).
- Sistem menggunakan template utama dan layout terpisah untuk admin/verifikator.

---

## 2. Penambahan Modul `Pembiayaan`

### 2.1 Routing (`app/Config/Routes.php`)
Tambahan rute (grup berdasarkan role):
```php
// Admin
$routes->group('admin', ['filter' => 'role:admin'], function($routes) {
    $routes->get('pembiayaan/item', 'Admin\Pembiayaan::item');
    $routes->post('pembiayaan/item/save', 'Admin\Pembiayaan::itemSave');
    $routes->get('pembiayaan/item/delete/(:num)', 'Admin\Pembiayaan::itemDelete/$1');
    // ... (tambah, edit, status)
});

// Verifikator (atau admin juga bisa akses)
$routes->group('verifikator', ['filter' => 'role:verifikator,admin'], function($routes) {
    $routes->get('pembiayaan/siswa/(:num)', 'Verifikator\Pembiayaan::detail/$1');
    $routes->post('pembiayaan/siswa/(:num)/tagihan/tambah', 'Verifikator\Pembiayaan::tambahItemTagihan/$1');
    $routes->post('pembiayaan/siswa/(:num)/tagihan/hapus', 'Verifikator\Pembiayaan::hapusItemTagihan/$1');
    $routes->post('pembiayaan/siswa/(:num)/bayar', 'Verifikator\Pembiayaan::catatPembayaran/$1');
    $routes->get('pembiayaan/siswa/(:num)/kuitansi', 'Verifikator\Pembiayaan::kuitansi/$1');
});
```

### 2.2 Controller

#### `app/Controllers/Admin/Pembiayaan.php`
- Method:
  - `item()` – menampilkan daftar item pembiayaan
  - `itemSave()` – menyimpan item baru/perubahan
  - `itemDelete($id)` – menonaktifkan/menghapus item

#### `app/Controllers/Verifikator/Pembiayaan.php`
- Method:
  - `detail($siswa_id)` – menampilkan halaman pembiayaan per siswa (tagihan, riwayat bayar, form pembayaran, tombol kuitansi)
  - `tambahItemTagihan($siswa_id)` – menambah item tagihan secara manual
  - `hapusItemTagihan($siswa_id)` – menghapus item tagihan
  - `catatPembayaran($siswa_id)` – mencatat pembayaran manual
  - `kuitansi($siswa_id)` – generate & unduh PDF kuitansi lunas

### 2.3 Model

#### `app/Models/ItemPembiayaanModel.php`
- Tabel: `item_pembiayaan`
- Method terkait: `getAllActive()`, `getByGender($kelamin)` dll.

#### `app/Models/TagihanSiswaModel.php`
- Tabel: `tagihan_siswa`
- Relasi: `siswa_id`, `item_id`
- Method: `getTagihanBySiswa($siswa_id)`, `tambahItem()`, `hapusItem()`, `getTotalTagihan()`

#### `app/Models/PembayaranModel.php`
- Tabel: `pembayaran`
- Method: `getRiwayatBySiswa($siswa_id)`, `insertPembayaran($data)`, `getTotalBayar($siswa_id)`

#### `app/Models/SiswaModel.php` (existing)
- Diasumsikan sudah ada, ditambahkan relasi atau method bantu untuk mengambil data kelamin.

### 2.4 Views

Struktur direktori dalam `app/Views/`:

```
app/Views/
├── admin/
│   └── pembiayaan/
│       ├── item_list.php       (tabel item, form tambah/edit)
│       └── item_form.php       (opsional, modal atau halaman terpisah)
├── verifikator/
│   └── pembiayaan/
│       ├── detail_siswa.php    (info siswa, daftar tagihan, riwayat bayar, form bayar)
│       └── kuitansi_pdf.php    (template PDF untuk kuitansi)
└── layouts/                    (template admin/verifikator existing)
```

### 2.5 Migration (Database Tables)

File migration baru:

- `app/Database/Migrations/2026-06-24-001_CreateItemPembiayaan.php`  
  Tabel: `item_pembiayaan` (id, nama, harga, jenis_kelamin, aktif)
- `app/Database/Migrations/2026-06-24-002_CreateTagihanSiswa.php`  
  Tabel: `tagihan_siswa` (id, siswa_id, item_id, harga_satuan_saat_itu, dibuat_oleh)
- `app/Database/Migrations/2026-06-24-003_CreatePembayaran.php`  
  Tabel: `pembayaran` (id, siswa_id, jumlah, tanggal, metode, keterangan, diverifikasi_oleh)

Semua migration menggunakan tipe data standar CI4, dengan foreign key ke tabel `siswa` dan `item_pembiayaan`.

### 2.6 Entities (Opsional)
- `app/Entities/PembayaranEntity.php` – untuk memastikan format tanggal.
- `app/Entities/TagihanSiswaEntity.php`

### 2.7 Libraries/Helpers

#### Helper: `app/Helpers/pembiayaan_helper.php`
- Fungsi-fungsi umum: `formatRupiah($angka)`, `statusLunas($totalTagihan, $totalBayar)`, `generateKuitansiHTML()`.

#### Library untuk PDF: gunakan pustaka eksternal seperti Dompdf atau TCPDF.
- Kuitansi di-render dari `kuitansi_pdf.php` menggunakan library `PdfGenerator` (dibuat di `app/Libraries/PdfGenerator.php`). Method: `generate($view, $data, $filename)`.

### 2.8 Filter (Role)
Filter `role:admin` dan `role:verifikator` diasumsikan sudah ada. Jika belum, tambahkan:
- `app/Filters/RoleFilter.php` – memeriksa grup pengguna.

---

## 3. Struktur Direktori Keseluruhan (Tambahan)

```
app/
├── Controllers/
│   ├── Admin/
│   │   └── Pembiayaan.php
│   └── Verifikator/
│       └── Pembiayaan.php
├── Models/
│   ├── ItemPembiayaanModel.php
│   ├── TagihanSiswaModel.php
│   ├── PembayaranModel.php
│   └── SiswaModel.php (existing, mungkin ditambah method)
├── Views/
│   ├── admin/pembiayaan/...
│   └── verifikator/pembiayaan/...
├── Database/Migrations/
│   ├── 2026-06-24-001_CreateItemPembiayaan.php
│   ├── 2026-06-24-002_CreateTagihanSiswa.php
│   └── 2026-06-24-003_CreatePembayaran.php
├── Helpers/
│   └── pembiayaan_helper.php
├── Libraries/
│   └── PdfGenerator.php
└── Config/
    └── Routes.php (tambahan rute)
```

---

## 4. Catatan Pengembangan
- Fitur transfer bank masih berupa rancangan, sehingga tidak dibuat controller/model khusus. Cukup ditampilkan placeholder di view `detail_siswa` dengan teks “Segera Hadir”.
- Semua penghapusan item bersifat logis (soft delete) atau set flag `aktif=0`.
- Log aktivitas perubahan tagihan/pembayaran bisa ditambahkan dengan library `Spatie/Activitylog` atau tabel `log_aktivitas` secara manual di versi berikutnya.

Struktur di atas siap diimplementasikan secara terpisah tanpa mengganggu modul lain yang sudah berjalan.

Berikut adalah contoh tampilan (view) **Status Pembiayaan di Dashboard Siswa** beserta tombol cetak kuitansi.  
View ini diletakkan di `app/Views/siswa/dashboard/pembiayaan_status.php` dan diasumsikan sudah tersedia layout utama siswa.

---

```php
<?= $this->extend('layouts/siswa') ?> <!-- layout dashboard siswa -->

<?= $this->section('content') ?>

<div class="container py-4">
    <h4 class="mb-4">Status Pembiayaan Pendaftaran</h4>

    <!-- Informasi Siswa -->
    <div class="card mb-4">
        <div class="card-body">
            <table class="table table-sm table-borderless mb-0">
                <tr>
                    <td style="width: 150px;">Nama</td>
                    <td>: <?= esc($siswa->nama) ?></td>
                </tr>
                <tr>
                    <td>NIS</td>
                    <td>: <?= esc($siswa->nis) ?></td>
                </tr>
                <tr>
                    <td>Kelas</td>
                    <td>: <?= esc($siswa->kelas) ?></td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Daftar Item Tagihan -->
    <div class="card mb-4">
        <div class="card-header fw-bold">
            Rincian Tagihan
        </div>
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Item</th>
                        <th class="text-end">Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($tagihan)): ?>
                        <tr>
                            <td colspan="3" class="text-center">Belum ada item tagihan.</td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1; foreach ($tagihan as $item): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= esc($item['nama_item']) ?></td>
                                <td class="text-end">Rp <?= number_format($item['harga'], 0, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
                <tfoot class="table-light fw-bold">
                    <tr>
                        <td colspan="2" class="text-end">Total Tagihan</td>
                        <td class="text-end">Rp <?= number_format($total_tagihan, 0, ',', '.') ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Status Pembayaran -->
    <div class="row g-3">
        <div class="col-md-4">
            <div class="card border-primary">
                <div class="card-body text-center">
                    <small class="text-muted">Total Dibayar</small>
                    <h5 class="text-primary mt-1">Rp <?= number_format($total_bayar, 0, ',', '.') ?></h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-warning">
                <div class="card-body text-center">
                    <small class="text-muted">Sisa Tagihan</small>
                    <h5 class="text-warning mt-1">Rp <?= number_format($sisa, 0, ',', '.') ?></h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card <?= $status_lunas ? 'border-success' : 'border-danger' ?>">
                <div class="card-body text-center">
                    <small class="text-muted">Status</small>
                    <h5 class="<?= $status_lunas ? 'text-success' : 'text-danger' ?> mt-1">
                        <?= $status_lunas ? 'LUNAS' : 'BELUM LUNAS' ?>
                    </h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Tombol Cetak Kuitansi (hanya jika lunas) -->
    <?php if ($status_lunas): ?>
        <div class="mt-4 text-end">
            <a href="<?= base_url('siswa/kuitansi/' . $siswa->id) ?>" 
               class="btn btn-success btn-lg" 
               target="_blank">
                <i class="bi bi-printer me-2"></i> Cetak / Unduh Kuitansi
            </a>
        </div>
        <div class="alert alert-info mt-2">
            Kuitansi hanya dapat dicetak setelah pelunasan. Simpan kuitansi ini sebagai bukti pembayaran resmi.
        </div>
    <?php else: ?>
        <div class="alert alert-warning mt-4">
            <i class="bi bi-exclamation-circle me-2"></i> 
            Pembayaran Anda belum lunas. Segera selesaikan pembayaran untuk mencetak kuitansi.
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
```

---

### Penjelasan Data yang Dikirim ke View

| Variabel         | Tipe       | Deskripsi |
|------------------|------------|-----------|
| `$siswa`         | object     | Data siswa (nama, nis, kelas, id) |
| `$tagihan`       | array      | Daftar item tagihan, setiap item punya `nama_item` dan `harga` |
| `$total_tagihan` | integer    | Total seluruh item tagihan |
| `$total_bayar`   | integer    | Akumulasi pembayaran yang sudah dicatat |
| `$sisa`          | integer    | `total_tagihan - total_bayar` (0 jika lunas) |
| `$status_lunas`  | boolean    | `true` jika `$sisa <= 0` |

---

### Rute Terkait (Tambahan di `app/Config/Routes.php`)

Untuk melayani halaman dashboard siswa dan unduh kuitansi, tambahkan:

```php
// Siswa dashboard – status pembiayaan
$routes->get('siswa/dashboard', 'Siswa\Dashboard::index', ['filter' => 'role:siswa']);

// Unduh kuitansi
$routes->get('siswa/kuitansi/(:num)', 'Siswa\Kuitansi::unduh/$1', ['filter' => 'role:siswa']);
```

Controller `Siswa\Dashboard` akan memuat data di atas, sedangkan `Siswa\Kuitansi::unduh()` akan menghasilkan file PDF menggunakan template kuitansi yang sudah disiapkan (misal `app/Views/verifikator/pembiayaan/kuitansi_pdf.php`).

Dengan demikian, siswa dapat memantau status pembiayaan langsung dari dashboard dan mencetak kuitansi setelah pelunasan.