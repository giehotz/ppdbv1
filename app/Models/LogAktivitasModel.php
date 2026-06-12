<?php

namespace App\Models;

use CodeIgniter\Model;

class LogAktivitasModel extends Model
{
    protected $table            = 'log_aktivitas';
    protected $primaryKey       = 'id_log';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'role',
        'nama_user',
        'tindakan',
        'keterangan',
        'ip_address',
        'user_agent',
        'created_at'
    ];

    // Dates
    protected $useTimestamps = false; // We will handle created_at manually in the helper

    /**
     * Get paginated logs with optional filters
     */
    public function getLogs($role = null, $tindakan = null, $keyword = null, $perPage = 20)
    {
        $builder = $this->builder();

        if (!empty($role)) {
            $builder->where('role', $role);
        }

        if (!empty($tindakan)) {
            $builder->like('tindakan', $tindakan);
        }

        if (!empty($keyword)) {
            $builder->groupStart()
                ->like('nama_user', $keyword)
                ->orLike('keterangan', $keyword)
                ->groupEnd();
        }

        $builder->orderBy('created_at', 'DESC');
        return $this;
    }
}
