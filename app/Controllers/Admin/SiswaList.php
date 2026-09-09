<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SiswaListModel;

class SiswaList extends BaseController
{
    protected SiswaListModel $siswaListModel;

    public function __construct()
    {
        $this->siswaListModel = new SiswaListModel();
    }

    /**
     * Halaman utama dashboard SiswaList
     */
    public function index()
    {
        return view('admin/siswa_list/dashboard');
    }

    /**
     * Endpoint AJAX GET — mengembalikan JSON data siswa aktif
     */
    public function getDataAjax()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON(['error' => 'Forbidden']);
        }

        $data = $this->siswaListModel->getAllSiswaAktif();

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $data,
            'csrf'   => csrf_hash(),
        ]);
    }

    /**
     * Endpoint AJAX POST — update is_checked untuk 1 siswa
     */
    public function updateChecklist()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON(['error' => 'Forbidden']);
        }

        $id_siswa   = (int) $this->request->getPost('id_siswa');
        $is_checked = (int) $this->request->getPost('is_checked');

        if ($id_siswa <= 0 || !in_array($is_checked, [0, 1], true)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status'  => 'error',
                'message' => 'Parameter tidak valid',
                'csrf'    => csrf_hash(),
            ]);
        }

        $result = $this->siswaListModel->updateChecklistById($id_siswa, $is_checked);

        return $this->response->setJSON([
            'status'  => $result ? 'success' : 'error',
            'message' => $result ? 'Checklist diperbarui' : 'Gagal memperbarui',
            'csrf'    => csrf_hash(),
        ]);
    }

    /**
     * Endpoint AJAX POST — update massal is_checked seluruh siswa aktif
     */
    public function updateAllChecklist()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON(['error' => 'Forbidden']);
        }

        $is_checked = (int) $this->request->getPost('is_checked');

        if (!in_array($is_checked, [0, 1], true)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status'  => 'error',
                'message' => 'Parameter tidak valid',
                'csrf'    => csrf_hash(),
            ]);
        }

        $result = $this->siswaListModel->updateAllChecklist($is_checked);

        return $this->response->setJSON([
            'status'  => $result ? 'success' : 'error',
            'message' => $result ? 'Semua checklist diperbarui' : 'Gagal memperbarui',
            'csrf'    => csrf_hash(),
        ]);
    }
}
