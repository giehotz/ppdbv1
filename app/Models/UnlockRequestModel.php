<?php

namespace App\Models;

use CodeIgniter\Model;

class UnlockRequestModel extends Model
{
    protected $table            = 'tbl_unlock_requests';
    protected $primaryKey       = 'id_request';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_siswa',
        'alasan',
        'status',
        'created_at'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    /**
     * Get pending unlock requests with student details
     */
    public function getPendingRequests()
    {
        return $this->select('tbl_unlock_requests.*, tbl_siswa.nama_lengkap, tbl_siswa.no_pendaftaran, tbl_siswa.nisn')
            ->join('tbl_siswa', 'tbl_siswa.id_siswa = tbl_unlock_requests.id_siswa')
            ->where('tbl_unlock_requests.status', 'Pending')
            ->orderBy('tbl_unlock_requests.created_at', 'ASC')
            ->findAll();
    }

    /**
     * Get unread pending requests count
     */
    public function getPendingCount()
    {
        return $this->where('status', 'Pending')->countAllResults();
    }
}
