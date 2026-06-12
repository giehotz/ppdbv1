<?php

namespace App\Models;

use CodeIgniter\Model;

class VerifikasiModel extends Model
{
    protected $table            = 'tbl_verifikasi';
    protected $primaryKey       = 'id_verifikasi';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_siswa',
        'isi',
        'ket',
        'tgl_verifikasi',
        'verifikator'
    ];

    protected $useTimestamps = false;
}
