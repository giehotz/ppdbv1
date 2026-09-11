<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class PindahanConfig extends BaseConfig
{
    /**
     * Grup jenjang sekolah asal.
     * Dipakai untuk normalisasi jenjang asal dan mengisi grup_jenjang_asal
     * secara otomatis saat menyimpan data siswa pindahan.
     */
    public static $grupJenjang = [
        // === GRUP PENDIDIKAN DASAR (SD/MI) ===
        'SD/MI' => [
            'SD'    => 'Sekolah Dasar (SD)',
            'MI'    => 'Madrasah Ibtidaiyah (MI)',
            'SDLB'  => 'SD Luar Biasa (SDLB)',
            'MIBTs' => 'Madrasah Ibtidaiyah sederajat',
        ],

        // === GRUP PENDIDIKAN MENENGAH PERTAMA (SMP/MTs) ===
        'SMP/MTs' => [
            'SMP'   => 'Sekolah Menengah Pertama (SMP)',
            'MTs'   => 'Madrasah Tsanawiyah (MTs)',
            'SMPLB' => 'SMP Luar Biasa (SMPLB)',
        ],

        // === GRUP PENDIDIKAN MENENGAH ATAS (SMA/SMK/MA) ===
        'SMA/SMK/MA' => [
            'SMA'   => 'Sekolah Menengah Atas (SMA)',
            'SMK'   => 'Sekolah Menengah Kejuruan (SMK)',
            'MA'    => 'Madrasah Aliyah (MA)',
            'SMALB' => 'SMA Luar Biasa (SMALB)',
            'MALB'  => 'MA Luar Biasa (MALB)',
        ],
    ];

    /**
     * Kategori alasan pindah yang tersedia pada form biodata.
     */
    public static $kategoriAlasanPindah = [
        'mutasi_orang_tua'   => 'Mutasi / Pindah Tugas Orang Tua',
        'pindah_domisili'    => 'Pindah Tempat Tinggal (Domisili)',
        'alasan_kesehatan'   => 'Alasan Kesehatan',
        'prestasi_akademik'  => 'Prestasi Akademik / Non-Akademik',
        'kenyamanan_belajar' => 'Kenyamanan dan Keamanan Belajar',
        'kondisi_keluarga'   => 'Kondisi Keluarga',
        'lainnya'            => 'Alasan Lainnya',
    ];

    /**
     * Nilai rata-rata minimal yang dapat diinput.
     */
    public static $nilaiMin = 0;

    /**
     * Nilai rata-rata maksimal yang dapat diinput (pada skala 100).
     */
    public static $nilaiMaks = 100;

    /**
     * Daftar mata pelajaran yang diinput pada form nilai rapor terakhir.
     */
    public static $mapelRapor = [
        'nilai_bahasa_indonesia' => 'Bahasa Indonesia',
        'nilai_bahasa_inggris'   => 'Bahasa Inggris',
        'nilai_matematika'       => 'Matematika',
        'nilai_ipa'              => 'IPA',
        'nilai_ips'              => 'IPS',
        'nilai_pkn'              => 'Pendidikan Kewarganegaraan (PKn)',
        'nilai_agama'            => 'Pendidikan Agama',
        'nilai_penjaskes'        => 'Penjaskes / PJOK',
        'nilai_seni_budaya'      => 'Seni Budaya',
    ];

    /**
     * Normalisasi input jenjang ke bentuk kanonik.
     * Jenjang dibandingkan case-insensitive karena bentuk resminya
     * bercampur, contoh: 'MTs', 'MIBTs'.
     *
     * @param string|null $jenjang Nama jenjang asal input
     *
     * @return string|null Bentuk kanonik (misal 'MTs') atau null jika tidak dikenali
     */
    public static function normalizeJenjang(?string $jenjang): ?string
    {
        if (empty($jenjang)) {
            return null;
        }

        $upper = strtoupper(trim($jenjang));
        foreach (self::$grupJenjang as $items) {
            foreach ($items as $kode => $label) {
                if (strtoupper($kode) === $upper) {
                    return $kode;
                }
            }
        }

        return null;
    }

    /**
     * Ambil nama grup dari sebuah jenjang.
     *
     * @param string|null $jenjang Nama jenjang (misal 'SD')
     *
     * @return string|null Nama grup ('SD/MI', 'SMP/MTs', 'SMA/SMK/MA') atau null jika tidak dikenali
     */
    public static function getGrupName(?string $jenjang): ?string
    {
        $canonical = self::normalizeJenjang($jenjang);
        if ($canonical === null) {
            return null;
        }

        foreach (self::$grupJenjang as $namaGrup => $items) {
            if (array_key_exists($canonical, $items)) {
                return $namaGrup;
            }
        }

        return null;
    }

    /**
     * Ambil semua jenjang yang tersedia (untuk dropdown awal).
     *
     * @return array Daftar jenjang: ['SD', 'MI', 'SMP', 'MTs', 'SMA', 'SMK', 'MA', ...]
     */
    public static function getAllJenjang(): array
    {
        $result = [];
        foreach (self::$grupJenjang as $items) {
            foreach ($items as $kode => $label) {
                $result[$kode] = $label;
            }
        }

        return $result;
    }

    /**
     * Ambil label lengkap dari sebuah jenjang.
     *
     * @param string|null $jenjang Nama jenjang (misal 'SD')
     *
     * @return string|null Label lengkap atau null jika tidak dikenali
     */
    public static function getLabelJenjang(?string $jenjang): ?string
    {
        $canonical = self::normalizeJenjang($jenjang);
        if ($canonical === null) {
            return null;
        }

        foreach (self::$grupJenjang as $items) {
            if (array_key_exists($canonical, $items)) {
                return $items[$canonical];
            }
        }

        return null;
    }
}