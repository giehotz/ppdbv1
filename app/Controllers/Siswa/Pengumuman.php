<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
use App\Models\PengumumanModel;

class Pengumuman extends BaseController
{
    protected $pengumumanModel;

    public function __construct()
    {
        $this->pengumumanModel = new PengumumanModel();
    }

    public function index()
    {
        // Get active announcements for students
        $now = date('Y-m-d H:i:s');

        $announcements = $this->pengumumanModel
            ->where('is_active', 1)
            ->groupStart()
            ->where('publish_date <=', $now)
            ->orWhere('publish_date IS NULL')
            ->groupEnd()
            ->orderBy('created_at', 'DESC')
            ->findAll();

        $data = [
            'announcements' => $announcements
        ];

        $agent = $this->request->getUserAgent();
        if ($agent->isMobile()) {
            return view('siswa/mobile/pengumuman', $data);
        }

        return view('siswa/pengumuman/index', $data);
    }
}
