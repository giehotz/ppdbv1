# Rancangan Integrasi WhatsApp Gateway & Email Notifikasi

Dokumen ini merinci teknis implementasi untuk meningkatkan sistem notifikasi dari link manual menjadi sistem otomatis 24/7.

## 1. Arsitektur Notifikasi (Helper)
Dibuat satu helper terpusat `notification_helper.php` agar pengiriman bisa dipanggil dari controller mana pun dengan satu baris kode.

```php
// Contoh pemanggilan:
send_whatsapp($phone, $message);
send_email($to, $subject, $view, $data);
```

---

## 2. WhatsApp Gateway (Integrasi API)
Menggunakan penyedia layanan pihak ketiga (seperti Fonnte, Wablas, atau RuangWA) karena sifat transaksionalnya yang cepat.

### A. Konfigurasi Database (`tbl_web`)
Tambahkan field baru untuk menyimpan kredensial:
*   `wa_gateway_api_key` (String)
*   `wa_gateway_sender_number` (String)
*   `wa_is_active` (Boolean)

### B. Trigger Pengiriman Otomatis:
1.  **Registrasi Berhasil**: Mengirim No. Pendaftaran & Password ke Siswa.
2.  **Verifikasi Berkas**: Memberitahu siswa jika berkas "Disetujui" atau "Ditolak" (Serta alasan penolakan).
3.  **Reset Password**: Mengirim password baru setelah disetujui admin.
4.  **Pengumuman Kelulusan**: Notifikasi massal hasil seleksi.

---

## 3. Email Notifikasi (SMTP)
Menggunakan library bawaan CodeIgniter 4 `CodeIgniter\Email\Email`.

### A. Rekomendasi Service:
*   **Gmail SMTP**: Gratis (Limit 500/hari), cocok untuk skala sekolah.
*   **Mailersend / SendGrid**: Lebih profesional dan jarang masuk folder spam.

### B. Konfigurasi `.env`:
```env
email.protocol = smtp
email.SMTPHost = smtp.gmail.com
email.SMTPUser = emailsekolah@gmail.com
email.SMTPPass = app-password-dari-google
email.SMTPPort = 465
email.SMTPCrypto = ssl
```

### C. Template Email (Reusable Views):
Membuat view khusus di `app/Views/emails/` yang menggunakan layout HTML profesional (Logo sekolah, warna brand, button login).

---

## 4. Sistem Antrean (Queue) - Optional tapi Disarankan
Agar performa aplikasi tidak lambat saat mengirim banyak pesan sekaligus (misal: pengumuman lulus ke 500 siswa):

*   Pesan disimpan ke tabel `tbl_notifications_queue`.
*   Dijalankan via **Cron Job** setiap 1 menit menggunakan perintah:
    `php spark queue:work`

---

## 5. Rencana Estimasi Pengerjaan
1.  **Tahap 1**: Penambahan konfigurasi API & SMTP di menu Pengaturan Admin.
2.  **Tahap 2**: Pembuatan helper `NotificationHelper`.
3.  **Tahap 3**: Implementasi trigger di Controller (Auth, Admin/Siswa, Admin/ResetPassword).
4.  **Tahap 4**: Pembuatan Template Email (HTML).
