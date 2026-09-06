<?php

namespace App\Models;

use CodeIgniter\Model;

class TblWebModel extends Model
{
    protected $table            = 'tbl_web';
    protected $primaryKey       = 'id_web';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'app_alias',
        'app_name',
        'nama_sekolah',
        'nsm',
        'npsn',
        'status_ppdb',
        'logo_sekolah',
        'alamat_sekolah',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'telepon',
        'email',
        'website',
        'nama_kepala',
        'nip_kepala',
        'th_pelajaran',
        'semester',
        'ujian_aktif',
        'tgl_ujian',
        'tgl_pengumuman',
        'pengumuman_aktif',
        'format_no_daftar',
        'link_grup_wa',
        'tampil_grup_wa',
        'landing_variant',
        'wajib_biodata_100',
        'popup_biodata_welcome',
        'popup_biodata_warning',
        'daftar_ulang_aktif',
        'tgl_tutup_daftar_ulang',
        'pesan_daftar_ulang',
        'seragam_aktif',
        'seragam_fields',
        'tampil_pembiayaan_siswa',
        'stepper_aktif',
        'stepper_config',
    ];

    /**
     * Definisi default 8 tahapan alur pendaftaran PPDB
     */
    public static function getDefaultStepperConfig(): array
    {
        return [
            [
                'id'             => 'akun',
                'title'          => 'Pendaftaran Akun',
                'description'    => 'Akun Terdaftar',
                'icon'           => 'how_to_reg',
                'url'            => '',
                'is_active'      => 1,
                'is_system'      => 1,
                'system_handler' => 'akun',
                'custom_status'  => 'completed',
            ],
            [
                'id'             => 'biodata',
                'title'          => 'Isi Biodata',
                'description'    => 'Kelengkapan Profil',
                'icon'           => 'edit_note',
                'url'            => 'siswa/biodata',
                'is_active'      => 1,
                'is_system'      => 1,
                'system_handler' => 'biodata',
                'custom_status'  => 'current',
            ],
            [
                'id'             => 'berkas',
                'title'          => 'Unggah Berkas',
                'description'    => 'Dokumen Persyaratan',
                'icon'           => 'upload_file',
                'url'            => 'siswa/berkas',
                'is_active'      => 1,
                'is_system'      => 1,
                'system_handler' => 'berkas',
                'custom_status'  => 'pending',
            ],
            [
                'id'             => 'pembiayaan',
                'title'          => 'Biaya PPDB',
                'description'    => 'Status Pembayaran',
                'icon'           => 'payments',
                'url'            => 'siswa/pembiayaan',
                'is_active'      => 1,
                'is_system'      => 1,
                'system_handler' => 'pembiayaan',
                'custom_status'  => 'pending',
            ],
            [
                'id'             => 'verifikasi',
                'title'          => 'Verifikasi Berkas',
                'description'    => 'Validasi Dokumen Panitia',
                'icon'           => 'verified_user',
                'url'            => 'siswa/status',
                'is_active'      => 1,
                'is_system'      => 1,
                'system_handler' => 'verifikasi',
                'custom_status'  => 'pending',
            ],
            [
                'id'             => 'ujian',
                'title'          => 'Ujian Seleksi',
                'description'    => 'Tes / Pemetaan Masuk',
                'icon'           => 'assignment',
                'url'            => 'siswa/cetak-kartu',
                'is_active'      => 1,
                'is_system'      => 1,
                'system_handler' => 'ujian',
                'custom_status'  => 'pending',
            ],
            [
                'id'             => 'pengumuman',
                'title'          => 'Pengumuman',
                'description'    => 'Hasil Seleksi PPDB',
                'icon'           => 'school',
                'url'            => 'siswa/kelulusan',
                'is_active'      => 1,
                'is_system'      => 1,
                'system_handler' => 'pengumuman',
                'custom_status'  => 'pending',
            ],
            [
                'id'             => 'daftar_ulang',
                'title'          => 'Daftar Ulang',
                'description'    => 'Konfirmasi Siswa Baru',
                'icon'           => 'backpack',
                'url'            => 'siswa/daftar-ulang',
                'is_active'      => 1,
                'is_system'      => 1,
                'system_handler' => 'daftar_ulang',
                'custom_status'  => 'pending',
            ],
        ];
    }

    /**
     * Ambil konfigurasi stepper aktif, fallback ke default jika kosong
     */
    public static function getStepperConfig($web = null): array
    {
        if (is_array($web) && !empty($web['stepper_config'])) {
            $decoded = json_decode($web['stepper_config'], true);
            if (is_array($decoded) && !empty($decoded)) {
                return $decoded;
            }
        }
        return self::getDefaultStepperConfig();
    }

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
