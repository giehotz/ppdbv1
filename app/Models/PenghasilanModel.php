<?php

namespace App\Models;

use CodeIgniter\Model;

class PenghasilanModel extends Model
{
    protected $table            = 'tbl_penghasilan';
    protected $primaryKey       = 'id_penghasilan';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nama_penghasilan',
        'urutan',
    ];

    protected $useTimestamps = false;

    /**
     * Ambil semua penghasilan terurut berdasarkan kolom 'urutan'.
     */
    public function getAllOrdered(): array
    {
        return $this->orderBy('urutan', 'ASC')->findAll();
    }
}