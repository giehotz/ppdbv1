Rancangan Arsitektur SEO Modular - CodeIgniter 4Dokumen ini menjelaskan struktur folder, skema database, dan logika alur kerja untuk sistem pengaturan SEO (Search Engine Optimization) yang terpisah dari logika utama aplikasi.1. Skema Database (site_settings)Sistem ini menggunakan tabel tunggal dengan satu baris data (single row) untuk menyimpan konfigurasi global.KolomTipeDeskripsiidINT (PK)Selalu bernilai 1 (untuk konfigurasi global).site_nameVARCHARNama brand atau website utama.meta_title_suffixVARCHARAkhiran judul (misal: "meta_descriptionTEXTDeskripsi global untuk mesin pencari.meta_keywordsVARCHARKata kunci utama yang dipisahkan koma.og_imageVARCHARNama file gambar untuk share media sosial (Open Graph).google_analyticsVARCHARID pelacakan Google Analytics (Opsional).updated_atDATETIMEWaktu terakhir pembaruan data.2. Struktur Folder & FilePemisahan dilakukan agar fitur SEO bersifat modular dan mudah dikelola tanpa mengganggu file core aplikasi lainnya.app/
├── Controllers/
│   ├── Admin/
│   │   └── SeoSettings.php      <-- Handler CRUD pengaturan SEO di panel Admin
│   └── BaseController.php       <-- Jembatan injeksi data SEO ke seluruh sistem
├── Models/
│   └── SeoModel.php             <-- Model khusus interaksi tabel 'site_settings'
└── Views/
    ├── admin/
    │   └── seo/
    │       └── index.php        <-- Form antarmuka pengaturan SEO untuk admin
    └── layout/
        └── partials/
            └── _seo_meta.php    <-- Template kecil khusus tag <meta> (Reusable)
public/
└── uploads/
    └── seo/                     <-- Folder penyimpanan aset gambar Open Graph
3. Logika Alur Kerja (Workflow)A. Alur Manajemen (Sisi Admin)Akses: Admin membuka menu "Pengaturan SEO".Input: Admin mengisi field metadata dan mengunggah gambar untuk Open Graph.Proses: Controller SeoSettings.php memvalidasi input dan memproses unggahan gambar ke folder public/uploads/seo/.Update: Data disimpan ke database menggunakan SeoModel.php dengan metode update pada baris ID 1.B. Alur Penayangan (Sisi Frontend/User)Inisialisasi Global: Di dalam BaseController.php, sistem memanggil SeoModel untuk mengambil data setting SEO.Variabel Global: Data tersebut disimpan ke dalam properti class (misal: $this->data['seo']) sehingga tersedia secara otomatis di semua Controller yang menginduk ke BaseController.Logika Prioritas (Fallback): * Jika sebuah halaman (misal: Detail Produk) memiliki judulnya sendiri, sistem akan menggabungkannya dengan meta_title_suffix.Jika halaman tidak memiliki deskripsi khusus, sistem akan menggunakan meta_description global dari database.Render Meta: File layout utama memanggil partial view _seo_meta.php yang bertugas menyusun tag HTML <meta> berdasarkan data yang sudah difilter.4. Keunggulan Sistem IniClean Architecture: Logika SEO tidak tersebar di banyak controller, melainkan terpusat di SeoModel dan BaseController.User Friendly: Pemilik website bisa mengubah kata kunci atau gambar promosi tanpa harus menyentuh kode program.Efisiensi: Query database hanya dilakukan sekali saat inisialisasi aplikasi.Modular: Mudah dipindahkan ke proyek CI4 lainnya hanya dengan menyalin struktur folder di atas.