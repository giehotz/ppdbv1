<?php

namespace App\Controllers\Verifikator;

use App\Controllers\BaseController;
use App\Models\BerkasModel;

class Berkas extends BaseController
{
    protected $berkasModel;

    public function __construct()
    {
        $this->berkasModel = new BerkasModel();
    }

    public function index()
    {
        $search = $this->request->getGet('search');

        $students = $this->berkasModel->getDistinctStudents($search, 10);

        // Fetch files for each student
        foreach ($students as &$student) {
            $student['berkas_list'] = $this->berkasModel->getByStudent($student['id_siswa']);
        }

        $data = [
            'students' => $students,
            'pager' => $this->berkasModel->pager,
            'search' => $search,
            'statusCounts' => $this->berkasModel->getStatusCounts()
        ];

        return view('verifikator/berkas/index', $data);
    }

    public function updateStatus($id)
    {
        $status = $this->request->getPost('status');
        $keterangan = $this->request->getPost('keterangan');

        $data = [
            'status_verifikasi' => $status,
            'keterangan' => $keterangan
        ];

        if ($this->berkasModel->update($id, $data)) {
            session()->setFlashdata('success', 'Status berkas berhasil diperbarui.');
        } else {
            session()->setFlashdata('error', 'Gagal memperbarui status berkas.');
        }

        return redirect()->to('/verifikator/berkas');
    }

    public function download($id)
    {
        $berkas = $this->berkasModel->find($id);

        if (!$berkas) {
            session()->setFlashdata('error', 'Berkas tidak ditemukan.');
            return redirect()->to('/verifikator/berkas');
        }

        // Build file path using path_file or fallback to NISN subfolder
        if (!empty($berkas['path_file'])) {
            $filePath = FCPATH . $berkas['path_file'];
        } else {
            $siswaModel = new \App\Models\SiswaModel();
            $siswa = $siswaModel->find($berkas['id_siswa']);
            $filePath = FCPATH . 'uploads/berkas/' . ($siswa['nisn'] ?? '') . '/' . $berkas['nama_file'];
        }

        if (!file_exists($filePath)) {
            session()->setFlashdata('error', 'File tidak ditemukan di server.');
            return redirect()->to('/verifikator/berkas');
        }

        return $this->response->download($filePath, null);
    }

    public function bulkUpdateStatus()
    {
        $ids = $this->request->getPost('ids');
        $status = $this->request->getPost('status');
        $keterangan = $this->request->getPost('keterangan');

        if (empty($ids) || empty($status)) {
            session()->setFlashdata('error', 'Pilih berkas dan status terlebih dahulu.');
            return redirect()->to('/verifikator/berkas');
        }

        $idArray = explode(',', $ids);
        $updated = 0;

        foreach ($idArray as $id) {
            $data = [
                'status_verifikasi' => $status,
                'keterangan' => $keterangan
            ];
            if ($this->berkasModel->update(trim($id), $data)) {
                $updated++;
            }
        }

        session()->setFlashdata('success', "$updated berkas berhasil diperbarui statusnya menjadi " . ucfirst($status) . ".");
        return redirect()->to('/verifikator/berkas');
    }
}
