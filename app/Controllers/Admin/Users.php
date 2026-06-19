<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Users extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = [
            'users' => $this->userModel->findAll()
        ];
        return view('admin/users/index', $data);
    }

    public function create()
    {
        return view('admin/users/form');
    }

    public function store()
    {
        $data = [
            'username'      => $this->request->getPost('username'),
            'password'      => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'nama_lengkap'  => $this->request->getPost('nama_lengkap'),
            'alamat'        => $this->request->getPost('alamat'),
            'email'         => $this->request->getPost('email'),
            'telp'          => $this->request->getPost('telp'),
            'level'         => $this->request->getPost('level'),
            'tgl_daftar'    => date('Y-m-d H:i:s'),
        ];

        if ($this->userModel->insert($data)) {
            session()->setFlashdata('success', 'User berhasil ditambahkan.');
        } else {
            session()->setFlashdata('error', 'Gagal menambahkan user.');
        }

        return redirect()->to('/admin/users');
    }

    public function edit($id)
    {
        $data = [
            'user' => $this->userModel->find($id)
        ];
        return view('admin/users/form', $data);
    }

    public function update($id)
    {
        $data = [
            'username'      => $this->request->getPost('username'),
            'nama_lengkap'  => $this->request->getPost('nama_lengkap'),
            'alamat'        => $this->request->getPost('alamat'),
            'email'         => $this->request->getPost('email'),
            'telp'          => $this->request->getPost('telp'),
            'level'         => $this->request->getPost('level'),
        ];

        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        if ($this->userModel->update($id, $data)) {
            session()->setFlashdata('success', 'User berhasil diperbarui.');
        } else {
            session()->setFlashdata('error', 'Gagal memperbarui user.');
        }

        return redirect()->to('/admin/users');
    }

    public function delete($id)
    {
        $currentUserId = session()->get('id_user');
        if ((int)$id === (int)$currentUserId) {
            session()->setFlashdata('error', 'Tidak dapat menghapus akun sendiri.');
            return redirect()->to('/admin/users');
        }

        $targetUser = $this->userModel->find($id);
        if (!$targetUser) {
            session()->setFlashdata('error', 'User tidak ditemukan.');
            return redirect()->to('/admin/users');
        }

        // Prevent deleting last admin
        if ($targetUser['level'] === 'admin') {
            $adminCount = $this->userModel->where('level', 'admin')->countAllResults();
            if ($adminCount <= 1) {
                session()->setFlashdata('error', 'Tidak dapat menghapus admin terakhir.');
                return redirect()->to('/admin/users');
            }
        }

        if ($this->userModel->delete($id)) {
            session()->setFlashdata('success', 'User berhasil dihapus.');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus user.');
        }

        return redirect()->to('/admin/users');
    }
}
