<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingKopModel extends Model
{
    protected $table            = 'tb_setting_kop';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'logo_kiri',
        'kementerian_pusat',
        'kementerian_kabupaten',
        'nama_madrasah',
        'alamat_madrasah',
        'email_madrasah',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField  = '';
    protected $updatedField  = 'updated_at';
}
