<?php

namespace App\Controllers\Admin;

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

        return view('admin/berkas/index', $data);
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
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Status berkas berhasil diperbarui menjadi ' . ucfirst((string)$status) . '.'
                ]);
            }
        } else {
            session()->setFlashdata('error', 'Gagal memperbarui status berkas.');
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal memperbarui status berkas.'
                ]);
            }
        }

        return redirect()->to('/admin/berkas');
    }


    private function resolveBerkasPath(array $berkas): ?string
    {
        $baseDir = realpath(FCPATH . 'uploads/berkas/') ?: FCPATH . 'uploads/berkas/';

        if (!empty($berkas['path_file'])) {
            $filePath = realpath(FCPATH . $berkas['path_file']);
        } else {
            $siswaModel = new \App\Models\SiswaModel();
            $siswa = $siswaModel->find($berkas['id_siswa']);
            $nisn = $siswa['nisn'] ?? '';
            $cleanNisn = preg_replace('/[^a-zA-Z0-9_-]/', '', $nisn);
            $filePath = realpath(FCPATH . 'uploads/berkas/' . $cleanNisn . '/' . $berkas['nama_file']);
        }

        if ($filePath === false || strpos($filePath, $baseDir) !== 0) {
            return null;
        }

        return $filePath;
    }

    public function delete($id)
    {
        $berkas = $this->berkasModel->find($id);

        if ($berkas) {
            $filePath = $this->resolveBerkasPath($berkas);
            if ($filePath !== null && file_exists($filePath)) {
                unlink($filePath);
            }

            if ($this->berkasModel->delete($id)) {
                session()->setFlashdata('success', 'Berkas berhasil dihapus.');
            } else {
                session()->setFlashdata('error', 'Gagal menghapus berkas.');
            }
        } else {
            session()->setFlashdata('error', 'Berkas tidak ditemukan.');
        }

        return redirect()->to('/admin/berkas');
    }

    public function download($id)
    {
        $berkas = $this->berkasModel->find($id);

        if (!$berkas) {
            session()->setFlashdata('error', 'Berkas tidak ditemukan.');
            return redirect()->to('/admin/berkas');
        }

        $filePath = $this->resolveBerkasPath($berkas);

        if ($filePath === null || !file_exists($filePath)) {
            session()->setFlashdata('error', 'File tidak ditemukan di server.');
            return redirect()->to('/admin/berkas');
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
            return redirect()->to('/admin/berkas');
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
        return redirect()->to('/admin/berkas');
    }
}
