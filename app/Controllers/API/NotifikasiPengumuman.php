<?php

namespace App\Controllers\API;

use App\Controllers\BaseController;
use App\Models\PengumumanModel;

class NotifikasiPengumuman extends BaseController
{
    protected $pengumumanModel;

    public function __construct()
    {
        $this->pengumumanModel = new PengumumanModel();
    }

    /**
     * Get count of active announcements for students
     */
    public function count()
    {
        // Get current datetime in local timezone
        $now = date('Y-m-d H:i:s');

        // Count active announcements
        $count = $this->pengumumanModel
            ->where('is_active', 1)
            ->groupStart()
            ->where('publish_date <=', $now)
            ->orWhere('publish_date IS NULL')
            ->groupEnd()
            ->countAllResults();

        return $this->response->setJSON([
            'success' => true,
            'count' => $count
        ]);
    }

    /**
     * Get recent 5 announcements for students
     */
    public function recent()
    {
        $now = date('Y-m-d H:i:s');

        // Get last 5 active announcements
        $announcements = $this->pengumumanModel
            ->select('id_pengumuman, judul, tipe, publish_date')
            ->where('is_active', 1)
            ->groupStart()
            ->where('publish_date <=', $now)
            ->orWhere('publish_date IS NULL')
            ->groupEnd()
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->findAll();

        return $this->response->setJSON([
            'success' => true,
            'announcements' => $announcements
        ]);
    }
}
