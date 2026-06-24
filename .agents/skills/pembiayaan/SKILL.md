---
name: pembiayaan
description: Menangani logika bisnis, model, view, dan controller yang berkaitan dengan sistem pembiayaan/pembayaran siswa pada PPDB.
---

# Panduan Logika Bisnis & Struktur Pembiayaan

Gunakan panduan ini saat membaca, memodifikasi, atau mendebug fitur pembiayaan (fees & payments) siswa di sistem PPDB ini.

## 1. Arsitektur Data Pembiayaan

Sistem pembiayaan terdiri dari 3 entitas utama:
* **Item Pembiayaan (`tbl_item_pembiayaan`)**: Daftar barang/jasa yang ditawarkan (misal: Peci, Batik, Infak).
  * Field penting: `jenis_kelamin` (nilai: `'L'`, `'P'`, atau `null` untuk semua gender), `aktif` (`1` untuk aktif, `0` untuk nonaktif).
* **Tagihan Siswa (`tbl_tagihan_siswa`)**: Item pembiayaan yang ditagihkan kepada siswa tertentu.
  * Field penting: `status_bayar` (nilai: `'belum'` atau `'lunas'`).
* **Pembayaran (`tbl_pembayaran`)**: Log transaksi pembayaran riil yang dilakukan siswa (jumlah bayar, tanggal, metode, bukti pembayaran).

## 2. Aturan Bisnis Penting

### Penyaringan Berdasarkan Gender (Laki-laki/Perempuan)
Saat menampilkan atau menambahkan tagihan baru untuk siswa:
* Ambil data jenis kelamin siswa (`jk` pada `tbl_siswa`, bernilai `'L'` atau `'P'`).
* Saring item pembiayaan dari `tbl_item_pembiayaan` agar hanya menampilkan item yang bersifat umum (`jenis_kelamin` bernilai `null`) atau item yang sesuai dengan gender siswa (`jenis_kelamin` sama dengan `jk` siswa).
* Logika ini harus diimplementasikan di method [ItemPembiayaanModel::getAvailableForSiswa()](file:///d:/ppdbv1/app/Models/ItemPembiayaanModel.php#L44).

### Status Lunas & Pencetakan Kuitansi PDF
* Kuitansi PDF hanya boleh dicetak/diakses jika **seluruh** tagihan siswa sudah berstatus `'lunas'`.
* Gunakan method `isAllLunas($siswaId)` dari `TagihanSiswaModel` untuk memvalidasi status kelunasan sebelum pencetakan.
* Cetak Kuitansi PDF menggunakan library `PdfGenerator` dengan template view [siswa/kuitansi_pdf.php](file:///d:/ppdbv1/app/Views/siswa/kuitansi_pdf.php).
* **PENTING**: Ketika memanggil `$pdf->generate()`, pastikan menyertakan data riwayat pembayaran (`riwayatBayar`) yang diambil dari `PembayaranModel::getRiwayatBySiswa($siswaId)` agar detail pembayaran tercetak dengan lengkap dan tidak menimbulkan error undefined variable di template PDF.

## 3. Komponen Utama Fitur Pembiayaan

* **Models**:
  * [ItemPembiayaanModel](file:///d:/ppdbv1/app/Models/ItemPembiayaanModel.php)
  * [TagihanSiswaModel](file:///d:/ppdbv1/app/Models/TagihanSiswaModel.php)
  * [PembayaranModel](file:///d:/ppdbv1/app/Models/PembayaranModel.php)
* **Controllers**:
  * [Admin\Pembiayaan](file:///d:/ppdbv1/app/Controllers/Admin/Pembiayaan.php)
  * [Verifikator\Pembiayaan](file:///d:/ppdbv1/app/Controllers/Verifikator/Pembiayaan.php)
  * [Siswa\Pembiayaan](file:///d:/ppdbv1/app/Controllers/Siswa/Pembiayaan.php)
* **Views**:
  * Admin: [admin/pembiayaan/siswa_detail.php](file:///d:/ppdbv1/app/Views/admin/pembiayaan/siswa_detail.php)
  * Verifikator: [verifikator/pembiayaan/detail_siswa.php](file:///d:/ppdbv1/app/Views/verifikator/pembiayaan/detail_siswa.php)
  * Siswa: [siswa/pembiayaan.php](file:///d:/ppdbv1/app/Views/siswa/pembiayaan.php)
