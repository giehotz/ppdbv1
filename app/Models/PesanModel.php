<?php

namespace App\Models;

use CodeIgniter\Model;

class PesanModel extends Model
{
    protected $table            = 'tbl_pesan';
    protected $primaryKey       = 'id_pesan';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'pengirim_id',
        'pengirim_type',
        'penerima_id',
        'subjek',
        'isi_pesan',
        'lampiran',
        'status',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Dapatkan pesan yang diterima oleh siswa
     */
    public function getPesanMasukSiswa($id_siswa)
    {
        return $this->select('tbl_pesan.*, tbl_user.nama_lengkap as nama_pengirim')
            ->join('tbl_user', 'tbl_user.id_user = tbl_pesan.pengirim_id', 'left')
            ->where('penerima_id', $id_siswa)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    /**
     * Dapatkan pesan terkirim oleh Admin/Verifikator tertentu
     */
    public function getPesanTerkirim($pengirim_id, $pengirim_type)
    {
        return $this->select('tbl_pesan.*, tbl_siswa.nama_lengkap as nama_penerima')
            ->join('tbl_siswa', 'tbl_siswa.id_siswa = tbl_pesan.penerima_id', 'left')
            ->where('pengirim_id', $pengirim_id)
            ->where('pengirim_type', $pengirim_type)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    /**
     * Hitung jumlah pesan masuk belum dibaca (Siswa)
     */
    public function countUnreadSiswa($id_siswa)
    {
        return $this->where('penerima_id', $id_siswa)
            ->where('status', 'unread')
            ->countAllResults();
    }

    /**
     * Dapatkan detail pesan beserta join datanya (untuk siswa pembaca)
     */
    public function getDetailPesanSiswa($id_pesan, $id_siswa)
    {
        return $this->select('tbl_pesan.*, tbl_user.nama_lengkap as nama_pengirim')
            ->join('tbl_user', 'tbl_user.id_user = tbl_pesan.pengirim_id', 'left')
            ->where('id_pesan', $id_pesan)
            ->where('penerima_id', $id_siswa)
            ->first();
    }

    /**
     * Dapatkan detail pesan beserta join datanya (untuk pengirim membaca)
     */
    public function getDetailPesanTerkirim($id_pesan, $pengirim_id, $pengirim_type)
    {
        return $this->select('tbl_pesan.*, tbl_siswa.nama_lengkap as nama_penerima')
            ->join('tbl_siswa', 'tbl_siswa.id_siswa = tbl_pesan.penerima_id', 'left')
            ->where('id_pesan', $id_pesan)
            ->where('pengirim_id', $pengirim_id)
            ->where('pengirim_type', $pengirim_type)
            ->first();
    }
}
