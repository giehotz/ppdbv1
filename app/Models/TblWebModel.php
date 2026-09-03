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
        'tgl_pengumuman',
        'pengumuman_aktif',
        'format_no_daftar',
        'link_grup_wa',
        'tampil_grup_wa',
        'landing_variant',
        'wajib_biodata_100',
        'popup_biodata_welcome',
        'popup_biodata_warning',
        'tampil_pembiayaan_siswa',
    ];

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
