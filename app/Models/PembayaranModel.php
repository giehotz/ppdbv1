<?php

namespace App\Models;

use CodeIgniter\Model;

class PembayaranModel extends Model
{
    protected $table            = 'tbl_pembayaran';
    protected $primaryKey       = 'id_pembayaran';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'siswa_id',
        'jumlah',
        'tanggal',
        'metode',
        'keterangan',
        'bukti_pembayaran',
        'diverifikasi_oleh',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';

    public function getRiwayatBySiswa($siswaId)
    {
        return $this->where('siswa_id', $siswaId)
            ->orderBy('tanggal', 'DESC')
            ->findAll();
    }

    public function getTotalBayar($siswaId)
    {
        $builder = $this->db->table('tbl_pembayaran');
        $builder->selectSum('jumlah');
        $builder->where('siswa_id', $siswaId);
        $row = $builder->get()->getRow();
        return $row ? (int) $row->jumlah : 0;
    }

    /**
     * Check if a duplicate payment was recently inserted within $windowSeconds seconds
     */
    public function isDuplicatePayment($siswaId, $jumlah, $tanggal, $windowSeconds = 10)
    {
        $since = date('Y-m-d H:i:s', time() - $windowSeconds);
        return $this->where('siswa_id', $siswaId)
            ->where('jumlah', $jumlah)
            ->where('tanggal', $tanggal)
            ->where('created_at >=', $since)
            ->countAllResults() > 0;
    }
}
