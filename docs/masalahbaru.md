1. **Menghapus nomor pendaftaran sebagai opsi login** – sehingga login hanya menggunakan email, NISN, atau NIK.
2. **Mengatasi loncatan nomor pendaftaran** – dengan menerapkan **soft delete**, sehingga data yang dihapus tidak benar-benar hilang dan nomor pendaftaran tetap berurutan.

---

## 1. Modifikasi Login (Hilangkan Opsi No. Pendaftaran)

### a. Ubah Controller `Auth` (Method `login`)

Pada bagian pencarian siswa, hapus baris `->orWhere('no_pendaftaran', $identifier)`. Sehingga kodenya menjadi:

```php
// Try student login (NISN, Email)
$siswa = $siswaModel->where('nisn', $identifier)
    ->orWhere('email', $identifier)
    ->first();
```

Sekarang siswa hanya bisa login menggunakan NISN atau email.

### b. Sesuaikan Form Login

Di file view `auth/login.php`, ubah label input menjadi "Email / NISN" (atau tambahkan NIK jika diperlukan). Misalnya:

```html
<input type="text" name="username" placeholder="Email atau NISN" required>
```

Jika nanti Anda juga ingin mendukung login menggunakan NIK, cukup tambahkan `orWhere('nik', $identifier)` di query.

---

## 2. Mengatasi Loncatan Nomor Pendaftaran (Soft Delete)

### a. Tambahkan Kolom `deleted_at` di Tabel `tbl_siswa`

Jalankan migrasi atau query manual:

```sql
ALTER TABLE tbl_siswa ADD COLUMN deleted_at DATETIME NULL DEFAULT NULL;
```

### b. Aktifkan Soft Delete di Model `SiswaModel`

Buka `app/Models/SiswaModel.php` dan tambahkan properti berikut:

```php
<?php

namespace App\Models;

use CodeIgniter\Model;

class SiswaModel extends Model
{
    protected $table            = 'tbl_siswa';
    protected $primaryKey       = 'id_siswa';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;          // Aktifkan soft delete
    protected $protectFields    = true;
    protected $allowedFields    = [               // Daftar kolom yang boleh diisi
        'no_pendaftaran', 'nisn', 'nama_lengkap', 'email',
        'no_hp', 'password', 'tgl_siswa', 'status_verifikasi',
        'foto', 'last_login'
    ];

    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $deletedField  = 'deleted_at';     // Nama kolom penanda hapus

    // ... method lainnya jika ada
}
```

Dengan pengaturan ini, setiap kali Anda memanggil `$siswaModel->delete($id)`, model tidak akan menghapus baris secara permanen, tetapi hanya mengisi `deleted_at` dengan waktu sekarang. Data yang sudah di-*soft delete* secara otomatis tidak akan muncul pada query biasa (kecuali Anda menggunakan `withDeleted()`).

### c. Ubah Proses Hapus di Controller Admin

Di controller admin yang menangani penghapusan data siswa, ganti perintah `delete()` dengan metode model yang sudah mendukung soft delete. Contoh:

```php
// Sebelumnya: $this->siswaModel->delete($id);
// Setelahnya (cukup gunakan delete biasa, karena model sudah di-set soft delete)
$this->siswaModel->delete($id);
```

Pastikan Anda tidak menggunakan hard delete (`$this->db->query("DELETE ...")`) di mana pun.

### d. Pastikan Login Hanya untuk Siswa Aktif (Belum Dihapus)

Karena model sudah menggunakan soft delete, secara default query `$siswaModel->where(...)->first()` akan mengabaikan data yang sudah terhapus. Jadi kode login Anda sudah aman tanpa tambahan kondisi.

### e. Tampilan Daftar Siswa di Admin

Di halaman admin, tampilkan data siswa seperti biasa. Karena soft delete aktif, hanya siswa yang belum terhapus yang muncul. Nomor pendaftaran akan tetap berurutan karena ID auto-increment tidak pernah hilang. Contoh:

| No | No. Pendaftaran     | Nama Lengkap | ... |
|----|---------------------|--------------|-----|
| 1  | PPDB-2026-0001      | Andi         | ... |
| 2  | PPDB-2026-0002      | Budi         | ... |
| 3  | PPDB-2026-0003      | Cici         | ... |

Jika admin menghapus Budi (ID 2), data Budi tetap ada di database tetapi `deleted_at` terisi. Maka di daftar admin, Budi tidak muncul, dan nomor pendaftaran yang tampil adalah:

| No | No. Pendaftaran     | Nama Lengkap |
|----|---------------------|--------------|
| 1  | PPDB-2026-0001      | Andi         |
| 2  | PPDB-2026-0003      | Cici         |

Nomor pendaftaran tetap berurutan karena ID yang hilang (2) tidak dihapus, hanya disembunyikan. Jadi **tidak ada loncatan** pada nomor pendaftaran.

### f. (Opsional) Tampilkan Nomor Urut Sementara di Admin

Jika Anda ingin kolom "No" berurutan (1,2,3) meskipun ada data yang dihapus, Anda bisa menambahkan nomor urut saat menampilkan data di view. Caranya di controller:

```php
$data['siswa'] = $this->siswaModel->orderBy('id_siswa', 'ASC')->findAll();
$no = 1;
foreach ($data['siswa'] as &$row) {
    $row['no_urut'] = $no++;
}
```

Kemudian di view, tampilkan `$row['no_urut']` sebagai nomor urut.

---

## 3. Menangani Data yang Dihapus Secara Permanen (Jika Diperlukan)

Kadang admin ingin menghapus data secara permanen. Anda dapat membuat fitur "Hapus Permanen" di halaman khusus yang menampilkan data yang sudah di-soft delete. Contoh:

```php
// Di controller admin
public function permanentDelete($id)
{
    $this->siswaModel->withDeleted()->where('id_siswa', $id)->delete(true); // true = hard delete
    // atau
    // $this->siswaModel->delete($id, true);
}
```

**Peringatan:** Jika Anda melakukan hard delete, maka akan terjadi gap pada nomor pendaftaran karena ID yang dihapus tidak akan bisa digunakan lagi. Namun karena hard delete jarang dilakukan (biasanya hanya untuk pembersihan data yang sudah tidak diperlukan), gap bisa dianggap wajar. Jika Anda tetap ingin menghindari gap meski setelah hard delete, Anda bisa melakukan renumbering ulang, tetapi ini sangat **tidak disarankan** karena nomor pendaftaran yang sudah tercetak akan berubah.

---

## 4. Kesimpulan

- **Login** sekarang menggunakan email atau NISN, sehingga Anda bebas menghapus data tanpa mempengaruhi kemampuan login siswa.
- Dengan **soft delete**, nomor pendaftaran tidak akan pernah loncat karena data yang "dihapus" tetap tersimpan di database. Urutan nomor pendaftaran berdasarkan ID auto-increment akan tetap berurutan meskipun ada data yang disembunyikan.
- Sistem menjadi lebih rapi dan aman, serta data historis tetap terjaga.

Jika ada kebutuhan khusus terkait format nomor pendaftaran (misalnya ingin menggunakan urutan berdasarkan tanggal pendaftaran, bukan ID), beri tahu saya agar bisa menyesuaikan.
