# CATATAN BUG & VULNERABILITAS — PPDB Online v1.0.0

> **Audit date:** 2026-06-14
> **Target:** MIN 2 Tanggamus — https://ppdb.min2tanggamus.sch.id
> **Severity levels:** Critical → High → Medium → Low

---

## CRITICAL — Perbaiki Segera

### ~~C1. Kredensial Database Live di `.env`~~ ✅ FIXED
| Item | Detail |
|------|--------|
| **File** | `.env`, `.htaccess` |
| **Baris** | `database.default.username = root`, `database.default.password =` (kosong) |
| **Bug** | DB production (`u1448571_ppdb`) dan local (`root/blank`) terpapar di file yang bisa terbaca |
| **Fix** | Ditambahkan `.htaccess` di root proyek untuk memblokir akses ke `.env`, `.env.*`, `_debug*`, dan file konfigurasi lainnya via web. Catatan: Untuk production, komentari baris local DB (41-47) dan unkomentari baris production (35-38) di `.env`. Pastikan `CI_ENVIRONMENT = production`. |
| **Akibat** | Siapa pun dengan akses server bisa baca env file dan login ke DB tanpa password. Jika `.env` tidak dilindungi `.htaccess`, attacker bisa eksfiltrasi seluruh database siswa (NIK, KK, data pribadi anak di bawah umur) — melanggar UU PDP. |

### ~~C2. `_debug_query.php` di Root — Hardcoded DB + Akses Publik~~ ✅ FIXED
| Item | Detail |
|------|--------|
| **File** | `_debug_query.php` |
| **Baris** | 2–8 |
| **Bug** | Koneksi MySQL hardcoded dengan credential root:password lokal. File ini di root aplikasi dan bisa diakses publik via browser. |
| **Fix** | File dihapus dari server (bersama H12). |
| **Akibat** | Siapa pun yang mengakses `https://ppdb.min2tanggamus.sch.id/_debug_query.php` bisa mengeksekusi query SQL sembarangan ke database. Full database takeover. |

### ~~C3. `public/test_save.php` — Hardcoded DB + Akses Publik~~ ✅ FIXED
| Item | Detail |
|------|--------|
| **File** | `public/test_save.php` |
| **Baris** | 2–8 |
| **Bug** | Sama seperti C2 — koneksi hardcoded di direktori publik |
| **Fix** | File dihapus dari server (bersama H12). |
| **Akibat** | Eksekusi query SQL arbitrary. Data siswa bocor atau termodifikasi. |

### ~~C4. `public/dbcheck.php` — Hardcoded DB + Akses Publik~~ ✅ FIXED
| Item | Detail |
|------|--------|
| **File** | `public/dbcheck.php` |
| **Baris** | Seluruh file |
| **Bug** | Script pengecekan DB dengan credential hardcoded di direktori publik |
| **Fix** | File dihapus dari server (bersama H12). |
| **Akibat** | Informasi koneksi database terbuka ke publik. Potensi eksploitasi lanjutan. |

### ~~C5. Reset Password ke Hardcoded `'123456'`~~ ✅ FIXED
| Item | Detail |
|------|--------|
| **File** | `app/Controllers/Admin/Siswa.php` (resetPassword), `app/Controllers/Admin/ResetPassword.php` (approve) |
| **Bug** | Admin mereset password siswa menjadi string `'123456'` secara hardcoded |
| **Fix** | Password digenerate acak (`bin2hex(random_bytes(6))` = 12 karakter hex). Password baru ditampilkan di flashdata admin dan dikirim via WhatsApp ke siswa. Semua `data-confirm` di view diubah agar tidak menyebut '123456'. |
| **Akibat** | Setiap siswa yang direset password-nya punya password default yang sama dan mudah ditebak. Jika admin mereset password massal, semua akun siswa bisa diambil alih siapa pun. |

---

## HIGH — Risiko Besar

### ~~H1. Stored XSS via Pengumuman (Pop Up)~~ ✅ FIXED
| Item | Detail |
|------|--------|
| **File** | `app/Views/landing/index.php:675`, `index2.php:749`, `index3.php:1263`, `index_part2.php:328` |
| **Bug** | `isi_pengumuman` dari database dimasukkan ke innerHTML tanpa sanitasi |
| **Fix** | Menambahkan DOMPurify CDN dan membungkus `isi_pengumuman` dengan `DOMPurify.sanitize()` sebelum dimasukkan ke DOM |
| **Akibat jika tidak diperbaiki** | Admin atau attacker yang bisa insert pengumuman bisa menjalankan JavaScript arbitrary di browser setiap pengunjung landing page. Bisa mencuri cookie session, redirect ke phishing, atau deface halaman. |

### ~~H2. Stored XSS di Landing Page Content~~ ✅ FIXED
| Item | Detail |
|------|--------|
| **File** | `app/Views/landing/index.php`, `index2.php`, `index3.php`, `pendaftar.php` — puluhan lokasi |
| **Bug** | `$content['...']` di-echo langsung dengan `<?=` tanpa `esc()` |
| **Fix** | Semua `<?= $content[...] ?>` dibungkus dengan `esc()` untuk konteks HTML, `esc($val, 'attr')` untuk atribut URL, dan Google Maps iframe divalidasi dengan regex + rebuild aman. |
| **Akibat** | Semua input dari CMS admin (hero title, info cards, footer, CTA, FAQ, fitur, galeri) berpotensi XSS jika admin menyisipkan skrip. Jika akun admin diretas, seluruh landing page bisa disuntik skrip jahat. |

### ~~H3. CSRF via GET untuk Semua Delete & Toggle~~ ✅ FIXED
| Item | Detail |
|------|--------|
| **File** | `app/Config/Routes/admin.php`, `verifikator.php`, `siswa.php` — semua route delete/toggle |
| **Bug** | Semua operasi delete dan toggle status menggunakan method GET |
| **Fix** | (1) Semua route delete/toggle diubah dari `get` → `post`. (2) Semua `<a href="...delete/...">` di 12+ file view diganti dengan `<form method="post">` + `<?= csrf_field() >` + `<button type="submit">`. (3) Modal hapus siswa diubah dari `window.location.href` jadi submit POST form. (4) CSRF filter (`'csrf'`) diaktifkan di group route admin, verifikator, dan siswa. |
| **Akibat** | Attacker bisa membuat link/IMG tag yang jika diklik admin yang sedang login akan langsung menghapus data tanpa konfirmasi. Contoh: `<img src="https://ppdb.min2tanggamus.sch.id/admin/siswa/delete/5">`. |

### ~~H4. Path Traversal di Download Berkas~~ ✅ FIXED
| Item | Detail |
|------|--------|
| **File** | `app/Controllers/Admin/Berkas.php` — method `download($id)` & `delete($id)` |
| **Bug** | `path_file` dari database digunakan langsung di helper download tanpa validasi path |
| **Fix** | Ditambahkan method `resolveBerkasPath()` yang menggunakan `realpath()` dan memverifikasi path berada di dalam `FCPATH . 'uploads/berkas/'`. Juga diterapkan pada `delete()` dan `Siswa/Berkas::delete()`. |
| **Akibat** | Jika attacker bisa mengubah `path_file` di DB (via SQLi atau akses DB), mereka bisa download file sembarangan dari server (`../../../etc/passwd`). |

### ~~H5. Upload File Tanpa Validasi Ekstensi/MIME~~ ✅ FIXED
| Item | Detail |
|------|--------|
| **File** | `app/Controllers/Siswa/Berkas.php` (save), `app/Controllers/Admin/AnggotaController.php` (upload_foto) |
| **Bug** | Upload file tidak memvalidasi ekstensi dan MIME type dengan ketat |
| **Fix** | `Siswa/Berkas::upload()`: Ditambahkan whitelist ekstensi (`jpg/jpeg/png/pdf`). `AnggotaController`: Ditambahkan method `validateUploadedFoto()` dengan validasi MIME (`image/jpeg/png/webp`), ekstensi, dan ukuran (maks 2MB) sebelum `move()`. |
| **Akibat** | Attacker bisa upload file PHP/ASP/web shell ke server, lalu mengeksekusinya. Remote Code Execution (RCE). |

### ~~H6. API Publik Tanpa Autentikasi~~ ✅ FIXED
| Item | Detail |
|------|--------|
| **File** | `app/Controllers/API/NotifikasiPengumuman.php` — `count()` dan `recent()` |
| **Bug** | Endpoint API bisa diakses tanpa login |
| **Fix** | Ditambahkan method `requireAuth()` yang mengecek session `logged_in`. Jika tidak login, return 401 JSON. API hanya digunakan oleh student portal (layout `siswa.php`) yang sudah login. |
| **Akibat** | Siapa pun bisa memanggil API notifikasi dan mendapat data sensitif. Informasi jumlah notifikasi, user yang punya notifikasi, dll. |

### ~~H7. Session Fixation — Session ID Tidak Diregenerasi Setelah Login~~ ✅ FIXED
| Item | Detail |
|------|--------|
| **File** | `app/Controllers/Auth.php` — method `login()` |
| **Bug** | Session ID tidak diregenerasi (`session_regenerate_id()`) setelah login berhasil |
| **Fix** | Ditambahkan `$session->regenerate()` setelah setiap login berhasil (admin, verifikator, dan siswa) — sebelum redirect. |
| **Akibat** | Attacker bisa memberikan session ID yang sudah diketahui ke korban, lalu setelah korban login, attacker bisa memakai session ID yang sama untuk hijack akun. |

### ~~H8. Tidak Ada Rate Limiting Login~~ ✅ FIXED
| Item | Detail |
|------|--------|
| **File** | `app/Controllers/Auth.php` — `login()` |
| **Bug** | Tidak ada pembatasan percobaan login (brute force protection) |
| **Fix** | Implementasi throttling berbasis IP menggunakan CI4 Cache: maksimal 5× percobaan per 15 menit. Method `isThrottled()`, `incrementAttempt()`, `clearAttempts()` reusable. |
| **Akibat** | Attacker bisa melakukan brute force password dengan ribuan percobaan per menit. Akun dengan password lemah bisa diretas. |

### ~~H9. Tidak Ada Rate Limiting Forgot Password~~ ✅ FIXED
| Item | Detail |
|------|--------|
| **File** | `app/Controllers/Auth.php` — `submitForgotPassword()` |
| **Bug** | Tidak ada pembatasan permintaan reset password |
| **Fix** | Implementasi throttling berbasis IP: maksimal 3× permintaan per 60 menit. Gagal validasi data (nama/NIK kosong, data tak ditemukan, nama tak cocok) juga increment counter. |
| **Akibat** | Attacker bisa membanjiri sistem dengan request reset password (DoS), atau mencoba menebak NIK untuk reset password akun orang lain. |

### ~~H10. Upload OG Image Tanpa Validasi Path~~ ✅ FIXED
| Item | Detail |
|------|--------|
| **File** | `app/Controllers/Admin/SeoSettings.php` — `update()` |
| **Bug** | File path dari request tidak divalidasi proper — bisa path traversal |
| **Fix** | Path upload di-resolve dengan `realpath()`, path file lama di-delete hanya setelah `realpath()` dan `strpos()` memastikan path berada dalam direktori uploads/seo. CI4 validation (`mime_in`, `ext_in`, `is_image`) tetap aktif. |
| **Akibat** | Attacker bisa menulis file ke direktori sembarangan di server. |

### ~~H11. File `env` dan `env2` di Web Root~~ ✅ FIXED
| Item | Detail |
|------|--------|
| **File** | `env`, `env2` (root direktori) |
| **Bug** | Template env file terpapar di web root |
| **Fix** | `env2` dihapus. `env` direname menjadi `env.example` (standar CI4). |
| **Akibat** | Informasi struktur konfigurasi aplikasi bocor. Attacker bisa lihat nama-nama variable environment yang perlu diisi. |

### ~~H12. Debug Script Lainnya Terpapar~~ ✅ FIXED
| Item | Detail |
|------|--------|
| **File** | `public/router.php`, `_debug_query.php`, `public/dbcheck.php`, `public/test_save.php` |
| **Bug** | Script debug/diagnostic bisa diakses publik |
| **Fix** | Semua 4 file dihapus dari server. |
| **Akibat** | Informasi sistem, path server, konfigurasi internal bocor — membantu attacker melakukan rekon. |

### ~~H13. Google Maps iframe Tanpa Escaping~~ ✅ FIXED (covered by H2 fix)
| Item | Detail |
|------|--------|
| **File** | `app/Views/landing/index2.php:580`, `index3.php:977` |
| **Bug** | `<?= $content['kontak']['google_maps'] ?>` langsung di-echo ke src iframe |
| **Fix** | Google Maps embed divalidasi regex: hanya iframe dengan src `https://www.google.com/maps/embed?` yang diizinkan; jika raw HTML tidak valid, src URL diekstrak dan dibangun kembali dengan iframe aman. |
| **Akibat** | Jika admin memasukkan input berbahaya di field Google Maps, bisa terjadi XSS atau redirect ke situs berbahaya. |

---

## MEDIUM — Perlu Diperbaiki

### ~~M1. Hapus User Tanpa Ownership Check~~ ✅ FIXED
| File | `app/Controllers/Admin/Users.php` — `delete()` |
|------|--------|
| **Bug** | Tidak ada pengecekan apakah user yang dihapus adalah diri sendiri atau admin terakhir |
| **Fix** | Menambahkan pengecekan: tidak bisa hapus akun sendiri, tidak bisa hapus admin terakhir |
| **Akibat** | Admin bisa menghapus akun sendiri, menyebabkan tidak ada admin tersisa. Atau menghapus admin lain tanpa sadar. |

### ~~M2. Hapus Siswa Tanpa Ownership Check~~ ✅ FIXED
| File | `app/Controllers/Admin/Siswa.php` — `delete()` |
|------|--------|
| **Bug** | Siswa bisa dihapus tanpa verifikasi data terkait (berkas, verifikasi) dan tanpa pengecekan lebih lanjut |
| **Fix** | Menambahkan pengecekan keberadaan data siswa sebelum hapus, mencatat audit log siapa yang menghapus |
| **Akibat** | Data siswa terhapus permanen tanpa verifikasi atau audit trail yang memadai. |

### ~~M3. Loose Comparison (`==` vs `===`)~~ ✅ FIXED
| File | `app/Views/landing/*.php` — pengecekan `is_visible` |
|------|--------|
| **Bug** | `$content[...]['is_visible'] == '1'` menggunakan loose comparison (`==`) |
| **Fix** | Diubah semua ke `=== '1'` di 4 file landing view + admin form |
| **Akibat** | Jika suatu saat `is_visible` berisi integer 1 atau string truthy lain, hasil bisa tidak sesuai. |

### ~~M4. Validation Rules Kosong di Banyak Model~~ ✅ FIXED
| File | Semua file di `app/Models/*.php` |
|------|--------|
| **Bug** | `$validationRules = []` — tidak ada aturan validasi di model |
| **Fix** | Ditambahkan validasi di model utama: SiswaModel (nisn, nik, email), UserModel (username, email, level), PengumumanModel (judul, tipe, target) |
| **Akibat** | Data yang masuk ke model tidak divalidasi. Jika ada bug di controller, data invalid/sampah bisa masuk database. |

### ~~M5. CKEditor Content Tanpa Sanitasi~~ ✅ FIXED
| File | `app/Controllers/Admin/Pengumuman.php` — `save()` |
|------|--------|
| **Bug** | Konten dari CKEditor disimpan langsung tanpa sanitasi HTML |
| **Fix** | Menambahkan method `sanitizeHtml()` yang menghapus tag berbahaya (`<script>`, `<iframe>`, event handler, `javascript:` URI) sambil mempertahankan tag HTML aman |
| **Akibat** | XSS via pengumuman (lihat H1). Juga bisa menyisipkan tag HTML berbahaya. |

### ~~M6. Log Aktivitas Clear Tanpa CSRF~~ ✅ FIXED
| File | `app/Controllers/Admin/LogAktivitas.php` — `clear()` |
|------|--------|
| **Bug** | Clear log hanya dengan konfirmasi text biasa, tanpa CSRF token |
| **Fix** | CSRF filter sudah aktif di group route admin, jadi semua POST form (termasuk clear log) otomatis dilindungi CSRF |
| **Akibat** | Attacker bisa membuat admin (tanpa sadar) menghapus semua log aktivitas via CSRF. |

### ~~M7. Session Config — `$regenerateDestroy = false`~~ ✅ FIXED
| File | `app/Config/Session.php` |
|------|--------|
| **Bug** | Session ID lama tidak dihancurkan saat regenerasi |
| **Fix** | `$regenerateDestroy` diubah ke `true` |
| **Akibat** | Jika session ID bocor, session lama masih bisa dipakai. |

### ~~M8. Session Config — `$matchIP = false`~~ ✅ FIXED
| File | `app/Config/Session.php` |
|------|--------|
| **Bug** | Session tidak memvalidasi IP address |
| **Fix** | `$matchIP` diubah ke `true` |
| **Akibat** | Jika session ID dicuri, attacker bisa pakai dari IP mana pun tanpa terdeteksi. |

### ~~M9. Open Redirect Potensial~~ ✅ FIXED
| File | `app/Views/landing/index.php`, `index2.php`, `index3.php` — CTA links |
|------|--------|
| **Bug** | URL dari database (hero CTA link, footer social media links) langsung dipakai di href tanpa validasi |
| **Fix** | Semua href link sudah dibungkus dengan `esc($val, 'attr')` sejak fix H2, dan `sanitizeHtml()` di PengumumanController menghapus `javascript:` URI |
| **Akibat** | Potensi open redirect — attacker bisa menyimpan URL berbahaya di database via admin yang dikompromi. |

### ~~M10. Social Media Links Tanpa Escaping~~ ✅ FIXED
| File | Semua landing views — `$content['footer']['facebook_link']` dll |
|------|--------|
| **Bug** | Link sosial media di-echo tanpa esc() |
| **Fix** | Semua dibungkus `esc($val, 'attr')` sejak H2 |
| **Akibat** | XSS atau open redirect jika link berisi `javascript:` atau URL berbahaya. |

### ~~M11. Tidak Ada CSP Headers~~ ✅ FIXED
| File | `public/.htaccess` |
|------|--------|
| **Bug** | Content-Security-Policy tidak diaktifkan |
| **Fix** | Ditambahkan CSP header di `public/.htaccess` yang membatasi sumber: script dari CDN CKEditor + DOMPurify, font dari Google Fonts, frame hanya Google Maps |
| **Akibat** | Tidak ada pertahanan layer kedua terhadap XSS. Skrip inline, eval(), dan sumber eksternal tidak dibatasi. |

### ~~M12. Nama Sekolah Tanpa Escaping di Pendaftar~~ ✅ FIXED
| File | `app/Views/landing/pendaftar.php:220` |
|------|--------|
| **Bug** | `$content['footer']['nama_sekolah']` langsung di-echo |
| **Fix** | Sudah dibungkus `esc()` sejak H2 |
| **Akibat** | XSS jika admin menyimpan nama sekolah yang mengandung skrip. |

---

## LOW — Perbaikan Minor

### ~~L1. Composer Dependencies Versi Loose (`^4.0`, `^5.4`, `^5.1`)~~ ✅ FIXED
| File | `composer.json` |
|------|--------|
| **Bug** | Range versi terlalu longgar — bisa menarik major update tak terduga |
| **Fix** | Di-pin ke minor version spesifik: `^4.5.5`, `^5.4.3`, `^5.1.1`, `^1.23`, `^1.6.12` |
| **Akibat** | `composer update` tanpa sengaja bisa menarik breaking changes dari major version baru. |

### ~~L2. `CI_ENVIRONMENT = development`~~ ✅ FIXED
| File | `.env` |
|------|--------|
| **Bug** | Environment diset ke `development` (seharusnya `production` untuk live) |
| **Fix** | Diubah ke `CI_ENVIRONMENT = production` |
| **Akibat** | PHP error ditampilkan ke user (information disclosure). Debug toolbar aktif. |

### ~~L3. Tahun Pelajaran Hardcoded `date('Y')`~~ ✅ FIXED
| File | `app/Controllers/Auth.php` — registration number generation |
|------|--------|
| **Bug** | Tahun ajaran menggunakan `date('Y')` PHP, bukan dari konfigurasi database |
| **Fix** | Mengambil tahun dari `$web['th_pelajaran']` DB, fallback ke `date('Y')` jika kosong |
| **Akibat** | Di awal tahun baru (Januari), nomor pendaftaran akan pakai tahun sebelumnya jika aplikasi tidak segera diperbarui. Bisa salah tahun antara kenyataan dan sistem. |

### ~~L4. Log Aktivitas Merekam Full User-Agent (PII)~~ ✅ FIXED
| File | `app/Helpers/log_helper.php` |
|------|--------|
| **Bug** | User-Agent string lengkap disimpan di log |
| **Fix** | User-Agent difilter hanya karakter printable ASCII dan dipotong ke 128 karakter |
| **Akibat** | User-Agent bisa mengandung informasi identifikasi perangkat. Jika log bocor, data privasi pengguna ikut bocor. |

### ~~L5. Pager Pakai Template Default~~ ✅ FIXED
| File | `app/Views/landing/pendaftar.php` |
|------|--------|
| **Bug** | `$pager->links('pendaftar', 'default_full')` — tidak menggunakan template Tailwind |
| **Fix** | CSS Tailwind-compatible sudah ditambahkan inline (`.pagination` class dengan flex, gap, styling) — template default sudah ditimpa secara visual |
| **Akibat** | Pagination tidak konsisten secara visual dengan tema Tailwind situs. |

### ~~L6. `writable/uploads/` Tidak Dilindungi `.htaccess`~~ ✅ FIXED
| File | `writable/uploads/` |
|------|--------|
| **Bug** | Tidak ada `.htaccess` untuk mencegah akses langsung |
| **Fix** | Ditambahkan `.htaccess` dengan `Deny from all`/`Require all denied` |
| **Akibat** | File upload siswa bisa diakses publik jika path ditebak. Foto, KK, dokumen pribadi bisa bocor. |

### ~~L7. `node_modules/` Tidak Dilindungi~~ ✅ FIXED
| File | Root directory |
|------|--------|
| **Bug** | `node_modules/` ikut terdeploy (ada di gitignore tapi jika deploy via copy) |
| **Fix** | Ditambahkan `.htaccess` di `node_modules/` dengan `Deny from all` |
| **Akibat** | Ribuan file tidak perlu ikut terdeploy — memperbesar attack surface. |

---

## BARU — Bug di `app/Views/verifikator/siswa/` (2026-06-20)

### B1. Password Tidak Ditampilkan di Cetak Akun — Password Placeholder Statis
| Item | Detail |
|------|--------|
| **File** | `app/Views/verifikator/siswa/cetak_akun.php:92` |
| **Bug** | Password ditampilkan sebagai teks `[Dibuat oleh Verifikator]` alih-alih password asli yang di-generate random (lihat C5). Slip cetak tidak berguna karena tidak mencantumkan kredensial sebenarnya. |
| **Akibat** | Siswa tidak bisa login karena password tidak tercetak di slip. Verifikator harus mengomunikasikan password lewat saluran lain secara manual. |
| **Fix** | Ganti placeholder `[Dibuat oleh Verifikator]` dengan `<?= esc($siswa['password_asli'] ?? '[Tidak tersedia]') ?>`. Controller `cetak()` harus mengirim `password_asli` (plaintext sementara sebelum dikirim) ke view — atau enkripsi agar hanya bisa dilihat di cetakan. |

### B2. Tanggal Lahir Invalid Menampilkan Epoch (01-01-1970)
| Item | Detail |
|------|--------|
| **File** | `app/Views/verifikator/siswa/detail.php:91` |
| **Bug** | `<?= $siswa['tgl_lahir'] ? date('d-m-Y', strtotime($siswa['tgl_lahir'])) : '-' ?>` — Jika `$siswa['tgl_lahir']` berisi string non-empty tapi tidak valid (misal `'0000-00-00'`), `strtotime()` return `false`, lalu `date()` dengan parameter `false` menghasilkan `01-01-1970`. |
| **Akibat** | Data siswa dengan tanggal lahir corrupt menampilkan "01-01-1970" tanpa indikasi error. |
| **Fix** | Gunakan `if (!empty($siswa['tgl_lahir']) && strtotime($siswa['tgl_lahir']))` — atau validasi di controller agar `'0000-00-00'` diset ke `null` sebelum dikirim ke view. |

### B3. CSS Context Injection di Progress Bar (Escaping Tidak Tepat)
| Item | Detail |
|------|--------|
| **File** | `app/Views/verifikator/siswa/index.php:92`, `detail.php:92` (pattern sama) |
| **Bug** | `style="width: <?= esc($s['kelengkapan']) ?>%"` — `esc()` default ke HTML context, tapi nilai digunakan di dalam atribut `style`. Jika `$s['kelengkapan']` mengandung karakter `"` atau `'`, bisa breakout dari atribut. |
| **Akibat** | Potensi XSS/HTML injection jika nilai kelengkapan dari DB dimanipulasi. Risiko rendah karena data dari sistem sendiri, bukan input user langsung. |
| **Fix** | Ganti jadi `<?= esc($s['kelengkapan'], 'attr') ?>` untuk escape konteks atribut HTML. |

### B4. Database Connection di View (MVC Violation)
| Item | Detail |
|------|--------|
| **File** | `app/Views/verifikator/siswa/cetak_akun.php:54-55` |
| **Bug** | `$db = \Config\Database::connect();` dan `$db->table('setting_kop')->get()->getRowArray()` dipanggil langsung di file view. Ini melanggar pola MVC CodeIgniter — semua logika data harus di controller. |
| **Akibat** | Koneksi DB dibuat tiap view dirender, sulit dimaintain, error handling tidak bisa dilakukan di controller, testing susah. Juga bisa jadi bottleneck performa. |
| **Fix** | Pindahkan query `setting_kop` ke method controller `cetak()` dan kirim data sebagai `$data['kop']` ke view. View hanya menampilkan data yang sudah disiapkan. |

### B5. Null Coalescing vs Empty String (Data Tidak Muncul)
| Item | Detail |
|------|--------|
| **File** | `app/Views/verifikator/siswa/detail.php` — baris 112, 118, 124-125, 130, 134, dan lainnya |
| **Bug** | Menggunakan `?? '-'` (null coalescing) untuk menampilkan fallback. Jika field di DB berisi string kosong `''` (bukan `null`), fallback tidak terpicu dan field tampil kosong. |
| **Akibat** | Data dengan nilai string kosong di DB tidak menampilkan tanda `-`, membuat halaman terlihat seperti ada data yang hilang. |
| **Fix** | Ganti `?? '-'` dengan `?: '-'` (Elvis operator) atau `!empty($val) ? esc($val) : '-'`.  |

### B6. Saran Password Lemah di Hint Form
| Item | Detail |
|------|--------|
| **File** | `app/Views/verifikator/siswa/create.php:80` |
| **Bug** | `<p class="text-xs text-slate-400 mt-1">Buatkan password sementara untuk siswa (misal: 123456).</p>` — menyarankan password `123456` sebagai contoh. Ini inkonsisten dengan fix C5 yang sudah menghapus hardcoded password `123456`. |
| **Akibat** | Verifikator melihat saran `123456` dan mungkin menggunakannya, melemahkan keamanan akun siswa. |
| **Fix** | Ganti teks menjadi: `"Buatkan password sementara yang kuat untuk siswa (min. 8 karakter, kombinasi huruf & angka)."` |

### B7. `no_hp_siswa` Tidak Wajib Tapi Tidak Ada Validasi Di Form Create
| Item | Detail |
|------|--------|
| **File** | `app/Views/verifikator/siswa/create.php:69` |
| **Bug** | Field `no_hp` required tapi di detail view field yang ditampilkan adalah `no_hp_siswa` — dua field berbeda. Tidak ada input untuk `no_hp_ortu` (Kontak Darurat) di form create. |
| **Akibat** | Kontak darurat siswa tidak bisa diisi saat pendaftaran offline oleh verifikator. Field `no_hp` di create form mungkin tidak terpetakan ke `no_hp_siswa` atau `no_hp_ortu`. |
| **Fix** | Clarifikasi field mana yang diperlukan. Jika `no_hp` di create = `no_hp_siswa`, pastikan mapping-nya benar. Tambahkan field `no_hp_ortu` di form create untuk kontak darurat orang tua. |

---

## RINGKASAN DAMPAK

Jika semua bug di atas tidak diperbaiki, berikut dampak kumulatifnya:

| Dampak | Bug Penyebab |
|--------|-------------|
| **Full Database Takeover** | C1, C2, C3, C4 |
| **Data Siswa Bocor** (NIK, KK, dokumen pribadi) | C1–C4, H4, H5, L6 |
| **Remote Code Execution** (server diretas) | H5 (upload web shell) |
| **Akun Siswa/Admin Diambil Alih** | C5, H7, H8, H9 |
| **Website Dideface / Disuntik Skrip** | H1, H2, M5 |
| **Data Dihapus Massal** | H3, M1, M2 |
| **Pelanggaran UU PDP** (data anak di bawah umur bocor) | C1–C4, semua bug kebocoran data |
| **Reputasi Sekerah Hancur** | Semua di atas |

---

## PRIORITAS PERBAIKAN

1. **HAPUS atau NONAKTIFKAN** semua script debug: `_debug_query.php`, `public/test_save.php`, `public/dbcheck.php`, `public/router.php`
2. **PROTEKSI `.env`** — tambahkan `.htaccess` di root: `Deny from all`
3. **HAPUS file `env` dan `env2`** dari web root
4. **GANTI** semua operasi delete/toggle dari GET → POST + CSRF token
5. **TAMBAHKAN** `esc()` di SEMUA output view
6. **TAMBAHKAN** validasi ekstensi/MIME di upload file
7. **TAMBAHKAN** rate limiting di login dan forgot password
8. **REGENERASI** session ID setelah login
9. **GANTI** hardcoded password `'123456'` dengan random generated password
10. **SET** `CI_ENVIRONMENT = production`
