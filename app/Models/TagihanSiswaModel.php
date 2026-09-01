<?php

namespace App\Models;

use CodeIgniter\Model;

class TagihanSiswaModel extends Model
{
    protected $table            = 'tbl_tagihan_siswa';
    protected $primaryKey       = 'id_tagihan';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'siswa_id',
        'item_id',
        'harga_satuan',
        'dibuat_oleh',
        'status_bayar',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';

    public function getTagihanBySiswa($siswaId)
    {
        return $this->select('tbl_tagihan_siswa.*, tbl_item_pembiayaan.nama as nama_item')
            ->join('tbl_item_pembiayaan', 'tbl_item_pembiayaan.id_item = tbl_tagihan_siswa.item_id')
            ->where('tbl_tagihan_siswa.siswa_id', $siswaId)
            ->orderBy('tbl_tagihan_siswa.created_at', 'ASC')
            ->findAll();
    }

    public function getTotalTagihan($siswaId)
    {
        $builder = $this->db->table('tbl_tagihan_siswa');
        $builder->selectSum('harga_satuan');
        $builder->where('siswa_id', $siswaId);
        $row = $builder->get()->getRow();
        return $row ? (int) $row->harga_satuan : 0;
    }

    public function getTotalLunas($siswaId)
    {
        $builder = $this->db->table('tbl_tagihan_siswa');
        $builder->selectSum('harga_satuan');
        $builder->where('siswa_id', $siswaId);
        $builder->where('status_bayar', 'lunas');
        $row = $builder->get()->getRow();
        return $row ? (int) $row->harga_satuan : 0;
    }

    public function isAllLunas($siswaId)
    {
        $total = $this->where('siswa_id', $siswaId)->countAllResults();
        $lunas = $this->where('siswa_id', $siswaId)->where('status_bayar', 'lunas')->countAllResults();
        return $total > 0 && $total === $lunas;
    }

    public function getUnpaidItems($siswaId)
    {
        return $this->select('tbl_tagihan_siswa.*, tbl_item_pembiayaan.nama as nama_item')
            ->join('tbl_item_pembiayaan', 'tbl_item_pembiayaan.id_item = tbl_tagihan_siswa.item_id')
            ->where('tbl_tagihan_siswa.siswa_id', $siswaId)
            ->where('tbl_tagihan_siswa.status_bayar', 'belum')
            ->orderBy('tbl_tagihan_siswa.created_at', 'ASC')
            ->findAll();
    }

    public function hasItem($siswaId, $itemId)
    {
        return $this->where('siswa_id', $siswaId)
            ->where('item_id', $itemId)
            ->countAllResults() > 0;
    }

    public function getPaidItems($siswaId)
    {
        return $this->select('tbl_tagihan_siswa.*, tbl_item_pembiayaan.nama as nama_item')
            ->join('tbl_item_pembiayaan', 'tbl_item_pembiayaan.id_item = tbl_tagihan_siswa.item_id')
            ->where('tbl_tagihan_siswa.siswa_id', $siswaId)
            ->where('tbl_tagihan_siswa.status_bayar', 'lunas')
            ->orderBy('tbl_tagihan_siswa.created_at', 'ASC')
            ->findAll();
    }

    public function markAsLunas($idTagihan)
    {
        return $this->update($idTagihan, ['status_bayar' => 'lunas']);
    }

    public function markAsBelum($idTagihan)
    {
        return $this->update($idTagihan, ['status_bayar' => 'belum']);
    }
}
