<?php

namespace App\Models;

use CodeIgniter\Model;

class ItemPembiayaanModel extends Model
{
    protected $table            = 'tbl_item_pembiayaan';
    protected $primaryKey       = 'id_item';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nama',
        'harga',
        'jenis_kelamin',
        'urutan',
        'aktif',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getAllActive()
    {
        return $this->where('aktif', 1)->orderBy('urutan', 'ASC')->findAll();
    }

    public function getByGender($kelamin)
    {
        return $this->where('aktif', 1)
            ->groupStart()
            ->where('jenis_kelamin', null)
            ->orWhere('jenis_kelamin', $kelamin)
            ->groupEnd()
            ->orderBy('urutan', 'ASC')
            ->findAll();
    }

    public function getAvailableForSiswa($siswaId)
    {
        $db = \Config\Database::connect();
        
        // Get student's gender (jk)
        $siswa = $db->table('tbl_siswa')
            ->select('jk')
            ->where('id_siswa', $siswaId)
            ->get()
            ->getRowArray();
        $jk = $siswa ? strtoupper($siswa['jk']) : null;

        $builder = $db->table('tbl_item_pembiayaan');
        $builder->where('tbl_item_pembiayaan.aktif', 1);

        // Filter based on gender
        if ($jk === 'L' || $jk === 'P') {
            $builder->groupStart()
                ->where('tbl_item_pembiayaan.jenis_kelamin', null)
                ->orWhere('tbl_item_pembiayaan.jenis_kelamin', $jk)
                ->groupEnd();
        }

        $builder->whereNotIn('tbl_item_pembiayaan.id_item', function ($sub) use ($siswaId) {
            $sub->select('item_id')->from('tbl_tagihan_siswa')->where('siswa_id', $siswaId);
        });
        $builder->orderBy('tbl_item_pembiayaan.urutan', 'ASC');
        return $builder->get()->getResultArray();
    }
}
