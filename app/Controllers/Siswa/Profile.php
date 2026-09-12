<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
use App\Models\SiswaModel;

class Profile extends BaseController
{
    protected $siswaModel;

    public function __construct()
    {
        $this->siswaModel = new SiswaModel();
    }

    public function index()
    {
        $nisn = session()->get('nisn');
        $siswa = $this->siswaModel->where('nisn', $nisn)->first();

        if (!$siswa) {
            return redirect()->to('/siswa/dashboard')->with('error', 'Data siswa tidak ditemukan');
        }

        // Cek foto profil khusus siswa
        $fotoPath = '';
        $isFromBerkas = false;
        $hasCustomFoto = !empty($siswa['foto']) && file_exists(FCPATH . 'uploads/berkas/' . $nisn . '/' . basename($siswa['foto']));

        if ($hasCustomFoto) {
            $fotoPath = 'uploads/berkas/' . $nisn . '/' . basename($siswa['foto']);
        } else {
            // Fallback: ambil dari berkas (pas foto) jika siswa tidak mengunggah foto khusus profil
            $berkasModel = new \App\Models\BerkasModel();
            $berkasFoto = $berkasModel->where('id_siswa', $siswa['id_siswa'])
                ->where('jenis_berkas', 'foto')
                ->first();

            if (!empty($berkasFoto['nama_file']) && file_exists(FCPATH . 'uploads/berkas/' . $nisn . '/' . $berkasFoto['nama_file'])) {
                $fotoPath = 'uploads/berkas/' . $nisn . '/' . $berkasFoto['nama_file'];
                $isFromBerkas = true;
            }
        }

        $data = [
            'siswa'        => $siswa,
            'fotoPath'     => $fotoPath,
            'isFromBerkas' => $isFromBerkas,
        ];

        $agent = $this->request->getUserAgent();
        if ($agent->isMobile()) {
            return view('siswa/mobile/profile', $data);
        }

        return view('siswa/profile/index', $data);
    }

    public function updateFoto()
    {
        $nisn = session()->get('nisn');

        // Validation
        $validationRules = [
            'foto' => [
                'rules' => 'uploaded[foto]|max_size[foto,2048]|is_image[foto]',
                'errors' => [
                    'uploaded' => 'Silakan pilih file foto',
                    'max_size' => 'Ukuran file maksimal 2MB',
                    'is_image' => 'File harus berupa gambar'
                ]
            ]
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $foto = $this->request->getFile('foto');

        if ($foto->isValid() && !$foto->hasMoved()) {
            $cleanNisn = preg_replace('/[^a-zA-Z0-9_-]/', '', (string)$nisn);
            // Create directory if not exists
            $uploadPath = FCPATH . 'uploads/berkas/' . $cleanNisn;
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            // Delete old photo if exists with safe path check
            $siswa = $this->siswaModel->where('nisn', $nisn)->first();
            if (!empty($siswa['foto'])) {
                $safeName = basename($siswa['foto']);
                $oldFotoPath = realpath($uploadPath . '/' . $safeName);
                if ($oldFotoPath !== false && strpos($oldFotoPath, realpath($uploadPath)) === 0 && file_exists($oldFotoPath)) {
                    unlink($oldFotoPath);
                }
            }

            // Generate new filename
            $newName = 'foto_' . time() . '.' . $foto->getExtension();

            // Move file
            $foto->move($uploadPath, $newName);

            // Update database and session
            $this->siswaModel->where('nisn', $nisn)->set(['foto' => $newName])->update();
            session()->set('foto', $newName);

            return redirect()->to('/siswa/profile')->with('success', 'Foto profil berhasil diupdate');
        }

        return redirect()->back()->with('error', 'Gagal mengupload foto');
    }

    public function deleteFoto()
    {
        $nisn = session()->get('nisn');
        $cleanNisn = preg_replace('/[^a-zA-Z0-9_-]/', '', (string)$nisn);
        $siswa = $this->siswaModel->where('nisn', $nisn)->first();

        if (!empty($siswa['foto'])) {
            $uploadPath = FCPATH . 'uploads/berkas/' . $cleanNisn;
            $safeName = basename($siswa['foto']);
            $fotoPath = realpath($uploadPath . '/' . $safeName);
            if ($fotoPath !== false && strpos($fotoPath, realpath($uploadPath)) === 0 && file_exists($fotoPath)) {
                unlink($fotoPath);
            }

            // Update database - set foto to null and sync session
            $this->siswaModel->where('nisn', $nisn)->set(['foto' => null])->update();
            session()->set('foto', null);

            return redirect()->to('/siswa/profile')->with('success', 'Foto profil berhasil dihapus');
        }

        return redirect()->to('/siswa/profile')->with('error', 'Tidak ada foto untuk dihapus');
    }


    public function ubahPassword()
    {
        $agent = $this->request->getUserAgent();
        if ($agent->isMobile()) {
            return view('siswa/mobile/ubah_password');
        }

        return view('siswa/profile/ubah_password');
    }

    public function updatePassword()
    {
        $nisn = session()->get('nisn');

        // Validation
        $validationRules = [
            'password_lama' => [
                'rules' => 'required',
                'errors' => ['required' => 'Password lama harus diisi']
            ],
            'password_baru' => [
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'required' => 'Password baru harus diisi',
                    'min_length' => 'Password minimal 6 karakter'
                ]
            ],
            'konfirmasi_password' => [
                'rules' => 'required|matches[password_baru]',
                'errors' => [
                    'required' => 'Konfirmasi password harus diisi',
                    'matches' => 'Konfirmasi password tidak sama'
                ]
            ]
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $siswa = $this->siswaModel->where('nisn', $nisn)->first();

        // Verify old password
        if (!password_verify($this->request->getPost('password_lama'), $siswa['password'])) {
            return redirect()->back()->with('error', 'Password lama tidak sesuai');
        }

        // Update password
        $newPasswordHash = password_hash($this->request->getPost('password_baru'), PASSWORD_DEFAULT);
        $this->siswaModel->where('nisn', $nisn)->set(['password' => $newPasswordHash])->update();

        return redirect()->to('/siswa/profile')->with('success', 'Password berhasil diubah');
    }
}
