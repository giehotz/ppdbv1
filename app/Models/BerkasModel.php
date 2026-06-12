<?php

namespace App\Models;

use CodeIgniter\Model;

class BerkasModel extends Model
{
    protected $table            = 'tbl_berkas';
    protected $primaryKey       = 'id_berkas';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_siswa',
        'jenis_berkas',
        'nama_file',
        'path_file',
        'ukuran_file',
        'deskripsi',
        'keterangan',
        'status_verifikasi'
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Get documents with student information
     */
    public function getDocumentsWithStudent($search = '', $perPage = 20)
    {
        $builder = $this->select('tbl_berkas.*, tbl_siswa.no_pendaftaran, tbl_siswa.nama_lengkap, tbl_siswa.nisn')
            ->join('tbl_siswa', 'tbl_siswa.id_siswa = tbl_berkas.id_siswa');

        if (!empty($search)) {
            $builder->groupStart()
                ->like('tbl_siswa.no_pendaftaran', $search)
                ->orLike('tbl_siswa.nama_lengkap', $search)
                ->orLike('tbl_berkas.jenis_berkas', $search)
                ->groupEnd();
        }

        return $builder->orderBy('tbl_berkas.created_at', 'DESC')
            ->paginate($perPage);
    }

    /**
     * Get distinct students who have uploaded files
     */
    public function getDistinctStudents($search = '', $perPage = 10)
    {
        // Select student info and group by student ID to get unique students
        // We select MAX(created_at) to order by the latest upload date distinct per student
        $builder = $this->select('tbl_siswa.id_siswa, tbl_siswa.no_pendaftaran, tbl_siswa.nama_lengkap, tbl_siswa.nisn, MAX(tbl_berkas.created_at) as latest_upload')
            ->join('tbl_siswa', 'tbl_siswa.id_siswa = tbl_berkas.id_siswa')
            ->groupBy('tbl_berkas.id_siswa');

        if (!empty($search)) {
            $builder->groupStart()
                ->like('tbl_siswa.no_pendaftaran', $search)
                ->orLike('tbl_siswa.nama_lengkap', $search)
                ->orLike('tbl_siswa.nisn', $search)
                ->groupEnd();
        }

        return $builder->orderBy('latest_upload', 'DESC')
            ->paginate($perPage);
    }

    /**
     * Get documents by student ID
     */
    public function getByStudent($id_siswa)
    {
        return $this->where('id_siswa', $id_siswa)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    /**
     * Get document counts by status
     */
    public function getStatusCounts()
    {
        return [
            'pending' => $this->where('status_verifikasi', 'pending')->countAllResults(),
            'valid' => $this->where('status_verifikasi', 'valid')->countAllResults(),
            'invalid' => $this->where('status_verifikasi', 'invalid')->countAllResults(),
        ];
    }
}
