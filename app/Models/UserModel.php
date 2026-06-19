<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'tbl_user';
    protected $primaryKey       = 'id_user';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'username',
        'password',
        'nama_lengkap',
        'alamat',
        'email',
        'website',
        'telp',
        'kab_sekolah',
        'ketua_panitia',
        'nip_ketua',
        'th_pelajaran',
        'no_surat',
        'kepsek',
        'nip_kepsek',
        'level',
        'last_login',
        'tgl_daftar',
    ];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'username' => 'required|alpha_numeric|min_length[3]|max_length[50]|is_unique[tbl_user.username,id_user,{id_user}]',
        'email'    => 'permit_empty|valid_email|max_length[100]',
        'level'    => 'required|in_list[admin,verifikator]',
    ];
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
