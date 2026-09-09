<?php

namespace App\Controllers\Verifikator;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\LogAktivitasModel;

class Profile extends BaseController
{
    protected $userModel;
    protected $logModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->logModel  = new LogAktivitasModel();
    }

    public function index()
    {
        $id_user = session()->get('id_user');
        if (!$id_user) {
            return redirect()->to('/login')->with('msg', 'Silakan login terlebih dahulu.');
        }

        $user = $this->userModel->find($id_user);
        if (!$user) {
            return redirect()->to('/verifikator/dashboard')->with('error', 'Data pengguna tidak ditemukan.');
        }

        // Recent activity logs for this user
        $logs = $this->logModel
            ->groupStart()
                ->where('nama_user', $user['nama_lengkap'])
                ->orWhere('nama_user', $user['username'])
            ->groupEnd()
            ->orderBy('created_at', 'DESC')
            ->findAll(8);

        // Avatar URL
        $avatarUrl = !empty($user['foto']) && file_exists(FCPATH . 'uploads/profile/' . $user['foto'])
            ? base_url('uploads/profile/' . esc($user['foto'], 'url'))
            : base_url('assets/tailadmin/images/user/owner.jpg');

        $data = [
            'user'       => $user,
            'logs'       => $logs,
            'avatarUrl'  => $avatarUrl,
        ];

        return view('verifikator/profile/index', $data);
    }

    public function updateProfile()
    {
        $id_user = session()->get('id_user');
        if (!$id_user) {
            return redirect()->to('/login');
        }

        $user = $this->userModel->find($id_user);
        if (!$user) {
            return redirect()->to('/verifikator/dashboard')->with('error', 'User tidak ditemukan.');
        }

        $validationRules = [
            'nama_lengkap' => [
                'rules'  => 'required|min_length[3]|max_length[100]',
                'errors' => [
                    'required'   => 'Nama Lengkap wajib diisi.',
                    'min_length' => 'Nama Lengkap minimal 3 karakter.',
                    'max_length' => 'Nama Lengkap maksimal 100 karakter.',
                ],
            ],
            'username' => [
                'rules'  => "required|alpha_numeric|min_length[3]|max_length[50]|is_unique[tbl_user.username,id_user,{$id_user}]",
                'errors' => [
                    'required'      => 'Username wajib diisi.',
                    'alpha_numeric' => 'Username hanya boleh berisi huruf dan angka.',
                    'min_length'    => 'Username minimal 3 karakter.',
                    'max_length'    => 'Username maksimal 50 karakter.',
                    'is_unique'     => 'Username sudah digunakan oleh akun lain.',
                ],
            ],
            'email' => [
                'rules'  => 'permit_empty|valid_email|max_length[100]',
                'errors' => [
                    'valid_email' => 'Format email tidak valid.',
                    'max_length'  => 'Email maksimal 100 karakter.',
                ],
            ],
            'telp' => [
                'rules'  => 'permit_empty|max_length[30]',
                'errors' => [
                    'max_length' => 'Nomor telepon maksimal 30 karakter.',
                ],
            ],
            'alamat' => [
                'rules'  => 'permit_empty|max_length[255]',
                'errors' => [
                    'max_length' => 'Alamat maksimal 255 karakter.',
                ],
            ],
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $dataUpdate = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'username'     => $this->request->getPost('username'),
            'email'        => $this->request->getPost('email'),
            'telp'         => $this->request->getPost('telp'),
            'alamat'       => $this->request->getPost('alamat'),
        ];

        if ($this->userModel->update($id_user, $dataUpdate)) {
            // Update session data
            session()->set([
                'username'     => $dataUpdate['username'],
                'nama'         => $dataUpdate['nama_lengkap'] ?? $dataUpdate['username'],
                'nama_lengkap' => $dataUpdate['nama_lengkap'],
            ]);

            if (function_exists('catat_log')) {
                catat_log('Update Profile', 'Memperbarui data profil akun (' . $dataUpdate['username'] . ')');
            }

            return redirect()->to('/verifikator/profile')->with('success', 'Profil berhasil diperbarui.');
        }

        return redirect()->back()->withInput()->with('error', 'Gagal memperbarui profil.');
    }

    public function updatePassword()
    {
        $id_user = session()->get('id_user');
        if (!$id_user) {
            return redirect()->to('/login');
        }

        $user = $this->userModel->find($id_user);
        if (!$user) {
            return redirect()->to('/verifikator/dashboard')->with('error', 'User tidak ditemukan.');
        }

        $validationRules = [
            'password_lama' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Password saat ini wajib diisi.',
                ],
            ],
            'password_baru' => [
                'rules'  => 'required|min_length[6]',
                'errors' => [
                    'required'   => 'Password baru wajib diisi.',
                    'min_length' => 'Password baru minimal 6 karakter.',
                ],
            ],
            'konfirmasi_password' => [
                'rules'  => 'required|matches[password_baru]',
                'errors' => [
                    'required' => 'Konfirmasi password baru wajib diisi.',
                    'matches'  => 'Konfirmasi password tidak cocok dengan password baru.',
                ],
            ],
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $passwordLama = $this->request->getPost('password_lama');
        $passwordBaru = $this->request->getPost('password_baru');

        if (!password_verify($passwordLama, $user['password'])) {
            return redirect()->back()->with('error', 'Password saat ini tidak sesuai.');
        }

        $hashedPassword = password_hash($passwordBaru, PASSWORD_DEFAULT);

        if ($this->userModel->update($id_user, ['password' => $hashedPassword])) {
            if (function_exists('catat_log')) {
                catat_log('Ganti Password', 'Mengubah kata sandi akun');
            }

            return redirect()->to('/verifikator/profile')->with('success', 'Kata sandi berhasil diperbarui.');
        }

        return redirect()->back()->with('error', 'Gagal memperbarui kata sandi.');
    }

    public function updateFoto()
    {
        $id_user = session()->get('id_user');
        if (!$id_user) {
            return redirect()->to('/login');
        }

        $user = $this->userModel->find($id_user);
        if (!$user) {
            return redirect()->to('/verifikator/dashboard')->with('error', 'User tidak ditemukan.');
        }

        $validationRules = [
            'foto' => [
                'rules'  => 'uploaded[foto]|max_size[foto,2048]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png,image/webp]',
                'errors' => [
                    'uploaded' => 'Silakan pilih file foto terlebih dahulu.',
                    'max_size' => 'Ukuran file foto maksimal 2MB.',
                    'is_image' => 'File harus berupa gambar.',
                    'mime_in'  => 'Format gambar harus JPG, JPEG, PNG, atau WebP.',
                ],
            ],
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $foto = $this->request->getFile('foto');
        if ($foto->isValid() && !$foto->hasMoved()) {
            $uploadPath = FCPATH . 'uploads/profile';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Delete old photo if exists
            if (!empty($user['foto'])) {
                $oldFotoPath = $uploadPath . '/' . $user['foto'];
                if (file_exists($oldFotoPath)) {
                    @unlink($oldFotoPath);
                }
            }

            $newName = 'avatar_' . $id_user . '_' . time() . '.' . $foto->getExtension();
            $foto->move($uploadPath, $newName);

            $this->userModel->update($id_user, ['foto' => $newName]);
            session()->set('foto', $newName);

            if (function_exists('catat_log')) {
                catat_log('Update Foto Profil', 'Memperbarui foto profil akun');
            }

            return redirect()->to('/verifikator/profile')->with('success', 'Foto profil berhasil diperbarui.');
        }

        return redirect()->back()->with('error', 'Gagal mengunggah foto profil.');
    }

    public function deleteFoto()
    {
        $id_user = session()->get('id_user');
        if (!$id_user) {
            return redirect()->to('/login');
        }

        $user = $this->userModel->find($id_user);
        if (!$user) {
            return redirect()->to('/verifikator/dashboard')->with('error', 'User tidak ditemukan.');
        }

        if (!empty($user['foto'])) {
            $fotoPath = FCPATH . 'uploads/profile/' . $user['foto'];
            if (file_exists($fotoPath)) {
                @unlink($fotoPath);
            }

            $this->userModel->update($id_user, ['foto' => null]);
            session()->remove('foto');

            if (function_exists('catat_log')) {
                catat_log('Hapus Foto Profil', 'Menghapus foto profil akun');
            }

            return redirect()->to('/verifikator/profile')->with('success', 'Foto profil berhasil dihapus.');
        }

        return redirect()->to('/verifikator/profile')->with('error', 'Tidak ada foto profil untuk dihapus.');
    }
}