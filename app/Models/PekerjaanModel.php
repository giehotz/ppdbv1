<?php

namespace App\Models;

use CodeIgniter\Model;

class PekerjaanModel extends Model
{
    protected $table            = 'tbl_pekerjaan';
    protected $primaryKey       = 'id_pekerjaan';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nama_pekerjaan',
        'kategori_peruntukan',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Ambil semua pekerjaan terurut berdasarkan kolom 'urutan'.
     */
    public function getAllOrdered(): array
    {
        return $this->orderBy('urutan', 'ASC')->findAll();
    }
}