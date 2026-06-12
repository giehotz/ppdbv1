<?php

namespace App\Models;

use CodeIgniter\Model;

class ResetPasswordModel extends Model
{
    protected $table            = 'reset_password_requests';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_siswa',
        'nama',
        'nik',
        'status',
        'created_at'
    ];

    protected $useTimestamps = false;

    /**
     * Get pending reset requests with student info (phone numbers)
     */
    public function getPendingRequests()
    {
        return $this->select('reset_password_requests.*, tbl_siswa.no_hp_siswa, tbl_siswa.no_hp_ortu, tbl_siswa.nama_lengkap, tbl_siswa.no_pendaftaran')
            ->join('tbl_siswa', 'tbl_siswa.id_siswa = reset_password_requests.id_siswa', 'left')
            ->where('reset_password_requests.status', 'Pending')
            ->orderBy('reset_password_requests.created_at', 'DESC')
            ->findAll();
    }

    /**
     * Get all requests (for history view)
     */
    public function getAllRequests()
    {
        return $this->select('reset_password_requests.*, tbl_siswa.no_hp_siswa, tbl_siswa.no_hp_ortu, tbl_siswa.nama_lengkap, tbl_siswa.no_pendaftaran')
            ->join('tbl_siswa', 'tbl_siswa.id_siswa = reset_password_requests.id_siswa', 'left')
            ->orderBy('reset_password_requests.created_at', 'DESC');
    }
}
