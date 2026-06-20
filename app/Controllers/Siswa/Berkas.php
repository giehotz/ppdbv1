<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\BerkasModel;

class Berkas extends BaseController
{
    public function index()
    {
        $siswaModel = new SiswaModel();
        $berkasModel = new BerkasModel();

        // Get current student data
        $idSiswa = session()->get('id_siswa');
        $siswa = $siswaModel->find($idSiswa);

        if (!$siswa) {
            session()->setFlashdata('error', 'Data siswa tidak ditemukan.');
            return redirect()->to('/siswa/dashboard');
        }

        // Get uploaded berkas
        $berkas = $berkasModel->where('id_siswa', $idSiswa)->findAll();

        // Define required documents
        $requiredDocs = [
            'kk' => 'Kartu Keluarga (KK)',
            'akte' => 'Akte Kelahiran',
            'ijazah' => 'Ijazah/SKHUN',
            'foto' => 'Pas Foto 3x4',
            'ktp_ortu' => 'KTP Orang Tua',
        ];

        // Map uploaded berkas by jenis
        $uploadedBerkas = [];
        foreach ($berkas as $item) {
            $uploadedBerkas[$item['jenis_berkas']] = $item;
        }

        $data = [
            'siswa' => $siswa,
            'requiredDocs' => $requiredDocs,
            'uploadedBerkas' => $uploadedBerkas
        ];

        $agent = $this->request->getUserAgent();
        if ($agent->isMobile()) {
            return view('siswa/mobile/berkas', $data);
        }

        return view('siswa/berkas/index', $data);
    }

    public function upload()
    {
        $siswaModel = new SiswaModel();
        $berkasModel = new BerkasModel();

        $idSiswa = session()->get('id_siswa');
        $jenisBerkas = $this->request->getPost('jenis_berkas');
        $file = $this->request->getFile('file_berkas');

        // Validation
        if (!$file->isValid()) {
            session()->setFlashdata('error', 'File tidak valid.');
            return redirect()->back();
        }

        // Check file type
        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'];
        if (!in_array($file->getMimeType(), $allowedTypes)) {
            session()->setFlashdata('error', 'Hanya file JPG, PNG, atau PDF yang diperbolehkan.');
            return redirect()->back();
        }

        // Check file size (max 2MB)
        if ($file->getSize() > 2048000) {
            session()->setFlashdata('error', 'Ukuran file maksimal 2MB.');
            return redirect()->back();
        }

        // Get NISN for folder name
        $siswa = $siswaModel->find($idSiswa);
        $nisn = $siswa['nisn'];

        // Create upload directory if not exists
        $uploadPath = FCPATH . 'uploads/berkas/' . $nisn . '/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        // Validate extension
        $allowedExts = ['jpg', 'jpeg', 'png', 'pdf'];
        $extension = strtolower($file->getExtension());
        if (!in_array($extension, $allowedExts)) {
            session()->setFlashdata('error', 'Ekstensi file tidak diizinkan. Hanya JPG, PNG, atau PDF.');
            return redirect()->back();
        }

        // Generate filename: e.g. KK_Nama Siswa_NISN.pdf
        $jenisLabel = strtoupper($jenisBerkas);
        $namaClean = preg_replace('/[^a-zA-Z0-9_-]/', '_', str_replace(' ', '_', $siswa['nama_lengkap']));
        $fileName = $jenisLabel . '_' . $namaClean . '_' . $nisn . '.' . $extension;

        // Move file
        if ($file->move($uploadPath, $fileName)) {
            // Check if berkas already exists
            $existing = $berkasModel->where('id_siswa', $idSiswa)
                ->where('jenis_berkas', $jenisBerkas)
                ->first();

            if ($existing) {
                // Delete old file
                $oldFilePath = FCPATH . 'uploads/berkas/' . $nisn . '/' . $existing['nama_file'];
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }

                // Update existing record
                $berkasModel->update($existing['id_berkas'], [
                    'nama_file' => $fileName,
                    'path_file' => 'uploads/berkas/' . $nisn . '/' . $fileName,
                    'ukuran_file' => $file->getSize(),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            } else {
                // Insert new record
                $berkasModel->insert([
                    'id_siswa' => $idSiswa,
                    'jenis_berkas' => $jenisBerkas,
                    'nama_file' => $fileName,
                    'path_file' => 'uploads/berkas/' . $nisn . '/' . $fileName,
                    'ukuran_file' => $file->getSize(),
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }

            session()->setFlashdata('success', 'Berkas berhasil diupload.');
        } else {
            session()->setFlashdata('error', 'Gagal mengupload berkas.');
        }

        return redirect()->back()->with('tab', 'berkas');
    }

    public function delete($id)
    {
        $berkasModel = new BerkasModel();
        $siswaModel = new SiswaModel();

        $idSiswa = session()->get('id_siswa');
        $berkas = $berkasModel->find($id);

        // Check if berkas belongs to current student
        if (!$berkas || $berkas['id_siswa'] != $idSiswa) {
            session()->setFlashdata('error', 'Berkas tidak ditemukan.');
            return redirect()->back();
        }

        // Get NISN
        $siswa = $siswaModel->find($idSiswa);
        $nisn = $siswa['nisn'];

        // Delete file with path traversal protection
        $safeNisn = preg_replace('/[^a-zA-Z0-9_-]/', '', $nisn);
        $baseDir = realpath(FCPATH . 'uploads/berkas/') ?: FCPATH . 'uploads/berkas/';
        $filePath = realpath(FCPATH . 'uploads/berkas/' . $safeNisn . '/' . $berkas['nama_file']);
        if ($filePath !== false && strpos($filePath, $baseDir) === 0 && file_exists($filePath)) {
            unlink($filePath);
        }

        // Delete record
        $berkasModel->delete($id);

        session()->setFlashdata('success', 'Berkas berhasil dihapus.');
        return redirect()->back()->with('tab', 'berkas');
    }
}
