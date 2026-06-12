<?php

namespace App\Models;

use CodeIgniter\Model;

class PengumumanModel extends Model
{
    protected $table            = 'tbl_pengumuman';
    protected $primaryKey       = 'id_pengumuman';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'judul',
        'isi_pengumuman',
        'tipe',
        'target_audience',
        'lampiran',
        'publish_date',
        'is_active',
        'is_popup',
        'popup_countdown'
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Get announcements with pagination
     */
    public function getAnnouncements($search = '', $perPage = 20)
    {
        if (!empty($search)) {
            $this->groupStart()
                ->like('judul', $search)
                ->orLike('isi_pengumuman', $search)
                ->groupEnd();
        }

        return $this->orderBy('publish_date', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->paginate($perPage);
    }

    /**
     * Get active announcements
     */
    public function getActiveAnnouncements()
    {
        return $this->where('is_active', 1)
            ->orderBy('publish_date', 'DESC')
            ->findAll();
    }
}
