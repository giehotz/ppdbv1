# Struktur Kode index copy.php

Dokumen ini menjelaskan pembagian bagian-bagian kode dalam file `app/Views/landing/index copy.php`.

## 1. Bagian Head (`<head>`)
- **Metadata**: Pengaturan charset, viewport, dan title dinamis.
- **Open Graph & Twitter Card**: Untuk optimasi berbagi di media sosial.
- **Assets CDN**:
  - Tailwind CSS (Framework CSS)
  - Google Fonts (Plus Jakarta Sans)
  - Font Awesome 6.4.0 (Ikon)
- **Tailwind Configuration**: Pengaturan custom font dan warna `madrasah`.
- **Custom CSS Styles**:
  - Hero Parallax effect.
  - Testimonial Marquee (animasi scroll horizontal).
  - Custom Scrollbar (tema emerald).
  - Lightbox & Mobile Menu transitions.

## 2. Bagian Body (`<body>`)
- **NAVBAR**:
  - Logo sekolah (dinamis).
  - Menu navigasi desktop (Beranda, Jadwal, Syarat, Kontak, Data Pendaftar).
  - Tombol aksi (Login & Daftar).
  - Menu dropdown untuk perangkat mobile.
- **HERO SECTION**:
  - Background image dinamis dengan efek parallax.
  - Headline dan subheadline dinamis.
  - Tombol Call-to-Action (CTA).
- **FITUR / KEUNGGULAN**:
  - Grid kartu keunggulan madrasah dengan ikon dinamis.
- **JADWAL PELAKSANAAN**:
  - Timeline proses PPDB (Tahap 1, 2, dan 3).
- **PERSYARATAN**:
  - Informasi dokumen yang diperlukan untuk pendaftaran.
- **GALERI**:
  - Grid foto kegiatan dengan efek hover dan integrasi lightbox.
- **LIGHTBOX MODAL**:
  - Komponen pop-up untuk memperbesar foto galeri.
- **TESTIMONI**:
  - Marquee (teks berjalan) berisi ulasan dari wali murid dan siswa.
- **KONTAK**:
  - Informasi alamat, WhatsApp panitia, dan integrasi Google Maps.
- **FOOTER**:
  - Logo, deskripsi singkat, dan link media sosial.
  - Informasi pendaftaran dan hak cipta.
- **BACK TO TOP BUTTON**:
  - Tombol melayang untuk kembali ke atas halaman.

## 3. Bagian Scripts (`<script>`)
- **Navbar Scroll Effect**: Mengubah tampilan navbar saat di-scroll.
- **Mobile Menu Toggle**: Logika membuka/menutup menu di HP.
- **Smooth Scroll**: Animasi perpindahan antar bagian halaman.
- **Lightbox Logic**: Menampilkan dan menutup foto galeri.
- **Back to Top**: Menampilkan tombol scroll up setelah posisi tertentu.
- **Active Nav Highlight**: Menandai menu yang aktif sesuai posisi scroll.
- **Popup Announcement Logic**: Menampilkan pengumuman penting secara pop-up berurutan dengan fitur countdown.

## 4. Bagian Khusus Lainnya
- **Announcement Popup Modal**: Struktur HTML untuk modal pengumuman.
- **Custom Scrollbar Styles**: Styling tambahan untuk scrollbar di dalam modal.
