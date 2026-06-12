<?php

namespace App\Models;

use CodeIgniter\Model;

class PendaftarPublikModel extends Model
{
    protected $table = 'tbl_siswa';
    protected $primaryKey = 'id_siswa';
    protected $returnType = 'array';

    public function getPublicStudents($search = '', $perPage = 20)
    {
        // Select limited fields to avoid exposing sensitive data
        $builder = $this->select('id_siswa, nisn, nama_lengkap, no_pendaftaran, tgl_siswa');

        if (!empty($search)) {
            $builder->groupStart()
                ->like('nisn', $search)
                ->orLike('nama_lengkap', $search)
                ->groupEnd();
        }

        // Ordered by latest first
        return $builder->orderBy('tgl_siswa', 'DESC')->paginate($perPage, 'pendaftar');
    }
}
