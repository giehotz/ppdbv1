<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Services\UnlockRequestService;

class UnlockRequest extends BaseController
{
    protected UnlockRequestService $service;

    public function __construct()
    {
        $this->service = new UnlockRequestService();
    }

    public function index()
    {
        $data = [
            'requests' => $this->service->getPendingRequests()
        ];

        return view('admin/unlock_requests/index', $data);
    }

    public function approve($idRequest)
    {
        $actor = session()->get('nama_lengkap') ?? 'Admin';
        $result = $this->service->approve($idRequest, $actor);

        $flashKey = $result['success'] ? 'success' : 'error';
        session()->setFlashdata($flashKey, $result['message']);

        return redirect()->to('/admin/unlockrequest');
    }

    public function reject($idRequest)
    {
        $actor = session()->get('nama_lengkap') ?? 'Admin';
        $result = $this->service->reject($idRequest, $actor);

        $flashKey = $result['success'] ? 'success' : 'error';
        session()->setFlashdata($flashKey, $result['message']);

        return redirect()->to('/admin/unlockrequest');
    }
}

