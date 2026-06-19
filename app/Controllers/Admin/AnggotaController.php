<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class AnggotaController extends BaseController
{
    protected $anggotaModel;

    public function __construct()
    {
        $this->anggotaModel = new \App\Models\AnggotaModel();
    }

    public function index()
    {
        $data = [
            'title'   => 'Data Anggota / Siswa',
            'anggota' => $this->anggotaModel->findAll()
        ];
        return view('admin/anggota/index', $data);
    }

    public function store()
    {
        $data = [
            'nama'           => $this->request->getPost('nama'),
            'tempat_lahir'   => $this->request->getPost('tempat_lahir'),
            'tgl_lahir'      => $this->request->getPost('tgl_lahir'),
            'nomor_induk'    => $this->request->getPost('nomor_induk'),
            'departemen'     => $this->request->getPost('departemen'),
            'sub_departemen' => $this->request->getPost('sub_departemen'),
            'alamat'         => $this->request->getPost('alamat'),
            'qr_text'        => $this->request->getPost('qr_text'),
        ];

        $foto = $this->request->getFile('foto');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            if (!$this->validateUploadedFoto($foto)) {
                return redirect()->to(base_url('admin/anggota'))->with('error', 'File foto harus berformat JPG, PNG, atau WebP maksimal 2MB.');
            }
            $newName = $foto->getRandomName();
            $foto->move('uploads/kartu', $newName);
            $data['foto'] = $newName;
        }

        $this->anggotaModel->insert($data);
        return redirect()->to(base_url('admin/anggota'))->with('success', 'Data Anggota berhasil ditambahkan.');
    }

    public function update($id)
    {
        $data = [
            'nama'           => $this->request->getPost('nama'),
            'tempat_lahir'   => $this->request->getPost('tempat_lahir'),
            'tgl_lahir'      => $this->request->getPost('tgl_lahir'),
            'nomor_induk'    => $this->request->getPost('nomor_induk'),
            'departemen'     => $this->request->getPost('departemen'),
            'sub_departemen' => $this->request->getPost('sub_departemen'),
            'alamat'         => $this->request->getPost('alamat'),
            'qr_text'        => $this->request->getPost('qr_text'),
        ];

        $foto = $this->request->getFile('foto');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            if (!$this->validateUploadedFoto($foto)) {
                return redirect()->to(base_url('admin/anggota'))->with('error', 'File foto harus berformat JPG, PNG, atau WebP maksimal 2MB.');
            }
            $newName = $foto->getRandomName();
            $foto->move('uploads/kartu', $newName);
            $data['foto'] = $newName;

            $old = $this->anggotaModel->find($id);
            if ($old && !empty($old['foto']) && file_exists('uploads/kartu/' . $old['foto'])) {
                unlink('uploads/kartu/' . $old['foto']);
            }
        }

        $this->anggotaModel->update($id, $data);
        return redirect()->to(base_url('admin/anggota'))->with('success', 'Data Anggota berhasil diperbarui.');
    }

    public function delete($id)
    {
        $old = $this->anggotaModel->find($id);
        if ($old && !empty($old['foto'])) {
            $cleanName = basename($old['foto']);
            $fotoPath = FCPATH . 'uploads/kartu/' . $cleanName;
            if (file_exists($fotoPath)) {
                unlink($fotoPath);
            }
        }
        $this->anggotaModel->delete($id);
        return redirect()->to(base_url('admin/anggota'))->with('success', 'Data Anggota berhasil dihapus.');
    }

    private function validateUploadedFoto($file): bool
    {
        $allowedMime = ['image/jpeg', 'image/png', 'image/webp'];
        $allowedExt = ['jpg', 'jpeg', 'png', 'webp'];

        if (!in_array($file->getMimeType(), $allowedMime)) {
            return false;
        }
        if (!in_array(strtolower($file->getExtension()), $allowedExt)) {
            return false;
        }
        if ($file->getSize() > 2048000) {
            return false;
        }

        return true;
    }
}
