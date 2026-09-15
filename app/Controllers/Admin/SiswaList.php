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
        $activeTh   = $this->siswaListModel->getActiveThPelajaran();
        $selectedTh = $this->request->getGet('th_pelajaran');
        if ($selectedTh === null || $selectedTh === '') {
            $selectedTh = $activeTh;
        }

        $tahunModel = new \App\Models\TahunPelajaranModel();
        $tahunList  = $tahunModel->orderBy('id_tahun', 'DESC')->findAll();

        if (empty($tahunList)) {
            $db = \Config\Database::connect();
            $distinctYears = $db->table('tbl_siswa')
                ->select('th_pelajaran')
                ->distinct()
                ->where('deleted_at', null)
                ->where('th_pelajaran !=', null)
                ->orderBy('th_pelajaran', 'DESC')
                ->get()->getResultArray();
            foreach ($distinctYears as $dy) {
                $tahunList[] = [
                    'tahun_pelajaran' => $dy['th_pelajaran'],
                    'status'          => ($dy['th_pelajaran'] === $activeTh) ? 'Aktif' : 'Tidak Aktif',
                ];
            }
        }

        return view('admin/siswa_list/dashboard', [
            'activeTh'   => $activeTh,
            'selectedTh' => $selectedTh,
            'tahunList'  => $tahunList,
        ]);
    }

    /**
     * Endpoint AJAX GET — mengembalikan JSON data siswa aktif terfilter tahun ajaran
     */
    public function getDataAjax()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON(['error' => 'Forbidden']);
        }

        $activeTh    = $this->siswaListModel->getActiveThPelajaran();
        $thPelajaran = $this->request->getGet('th_pelajaran');
        if ($thPelajaran === null || $thPelajaran === '') {
            $thPelajaran = $activeTh;
        }

        $data = $this->siswaListModel->getAllSiswaAktif($thPelajaran);

        return $this->response->setJSON([
            'status'       => 'success',
            'th_pelajaran' => $thPelajaran,
            'data'         => $data,
            'csrf'         => csrf_hash(),
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
     * Endpoint AJAX POST — update massal is_checked seluruh siswa aktif (per tahun pelajaran)
     */
    public function updateAllChecklist()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON(['error' => 'Forbidden']);
        }

        $is_checked  = (int) $this->request->getPost('is_checked');
        $thPelajaran = $this->request->getPost('th_pelajaran');

        if (!in_array($is_checked, [0, 1], true)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status'  => 'error',
                'message' => 'Parameter tidak valid',
                'csrf'    => csrf_hash(),
            ]);
        }

        $result = $this->siswaListModel->updateAllChecklist($is_checked, $thPelajaran);

        return $this->response->setJSON([
            'status'  => $result ? 'success' : 'error',
            'message' => $result ? 'Semua checklist diperbarui' : 'Gagal memperbarui',
            'csrf'    => csrf_hash(),
        ]);
    }
}
