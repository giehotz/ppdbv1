<?php

namespace App\Models;

use CodeIgniter\Model;

class TahunPelajaranModel extends Model
{
    protected $table            = 'tbl_tahun_pelajaran';
    protected $primaryKey       = 'id_tahun';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'tahun_pelajaran',
        'status',
        'keterangan',
        'created_at',
        'updated_at',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'tahun_pelajaran' => 'required|regex_match[/^[0-9]{4}\/[0-9]{4}$/]|is_unique[tbl_tahun_pelajaran.tahun_pelajaran,id_tahun,{id_tahun}]',
        'status'          => 'permit_empty|in_list[Aktif,Tidak Aktif]',
    ];

    protected $validationMessages = [
        'tahun_pelajaran' => [
            'required'    => 'Tahun Pelajaran wajib diisi.',
            'regex_match' => 'Format Tahun Pelajaran harus format tahun (contoh: 2026/2027).',
            'is_unique'   => 'Tahun Pelajaran ini sudah ada di dalam riwayat.',
        ],
    ];

    /**
     * Dapatkan data Tahun Pelajaran yang sedang aktif
     */
    public function getActive(): ?array
    {
        return $this->where('status', 'Aktif')->first();
    }

    /**
     * Set tahun pelajaran tertentu sebagai aktif, menonaktifkan tahun lainnya,
     * dan menyinkronkan ke tbl_web.th_pelajaran
     */
    public function setActive(int $id): bool
    {
        $target = $this->find($id);
        if (!$target) {
            return false;
        }

        $db = \Config\Database::connect();
        $db->transStart();

        // 1. Nonaktifkan semua tahun pelajaran
        $this->builder()->update(['status' => 'Tidak Aktif', 'updated_at' => date('Y-m-d H:i:s')]);

        // 2. Aktifkan tahun pelajaran yang dipilih
        $this->update($id, ['status' => 'Aktif', 'updated_at' => date('Y-m-d H:i:s')]);

        // 3. Sinkronkan ke tbl_web
        $db->table('tbl_web')->where('id_web', 1)->update([
            'th_pelajaran' => $target['tahun_pelajaran']
        ]);

        $db->transComplete();

        if ($db->transStatus() !== false) {
            // Hapus cache pengaturan agar langsung aktif seketika
            $cache = \Config\Services::cache();
            $cache->delete('app_settings');
            $cache->delete('web_settings');
            $cache->delete('home_landing_data');
            return true;
        }

        return false;
    }

    /**
     * Dapatkan semua riwayat tahun pelajaran lengkap dengan jumlah pendaftar
     */
    public function getWithStudentCount(): array
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tbl_tahun_pelajaran t');
        $builder->select('t.*, COUNT(s.id_siswa) as total_siswa');
        $builder->join('tbl_siswa s', 's.th_pelajaran = t.tahun_pelajaran AND s.deleted_at IS NULL', 'left');
        $builder->groupBy('t.id_tahun');
        $builder->orderBy('t.id_tahun', 'DESC');

        return $builder->get()->getResultArray();
    }
}
