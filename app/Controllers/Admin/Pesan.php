<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PesanModel;
use App\Models\SiswaModel;

class Pesan extends BaseController
{
    protected $pesanModel;
    protected $siswaModel;

    public function __construct()
    {
        $this->pesanModel = new PesanModel();
        $this->siswaModel = new SiswaModel();
    }

    public function index()
    {
        $id_pengirim = session()->get('id_user');
        
        $data = [
            'pesan' => $this->pesanModel->getPesanTerkirim($id_pengirim, 'admin'),
        ];

        return view('admin/pesan/index', $data);
    }

    public function create()
    {
        $data = [
            'siswaList' => $this->siswaModel->findAll() // For select dropdown
        ];
        return view('admin/pesan/create', $data);
    }

    public function store()
    {
        $id_pengirim = session()->get('id_user');
        
        if (!$id_pengirim) {
            return redirect()->to('login');
        }

        $rules = [
            'penerima_id' => 'required|numeric',
            'subjek'      => 'required|min_length[3]|max_length[255]',
            'isi_pesan'   => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'pengirim_id'   => $id_pengirim,
            'pengirim_type' => 'admin',
            'penerima_id'   => $this->request->getPost('penerima_id'),
            'subjek'        => $this->request->getPost('subjek'),
            'isi_pesan'     => $this->request->getPost('isi_pesan'),
            'status'        => 'unread',
        ];

        if ($this->pesanModel->insert($data)) {
            session()->setFlashdata('success', 'Pesan berhasil dikirim.');
        } else {
            session()->setFlashdata('error', 'Gagal mengirim pesan.');
        }

        return redirect()->to('admin/pesan');
    }

    public function detail($id)
    {
        $id_pengirim = session()->get('id_user');
        $pesan = $this->pesanModel->getDetailPesanTerkirim($id, $id_pengirim, 'admin');

        if (!$pesan) {
            session()->setFlashdata('error', 'Pesan tidak ditemukan.');
            return redirect()->to('admin/pesan');
        }

        $data = [
            'pesan' => $pesan
        ];

        return view('admin/pesan/detail', $data);
    }
    
    public function delete($id)
    {
        $id_pengirim = session()->get('id_user');
        $pesan = $this->pesanModel->where('id_pesan', $id)
                                  ->where('pengirim_id', $id_pengirim)
                                  ->where('pengirim_type', 'admin')
                                  ->first();

        if ($pesan) {
            $this->pesanModel->delete($id);
            session()->setFlashdata('success', 'Pesan berhasil dihapus.');
        } else {
            session()->setFlashdata('error', 'Pesan tidak ditemukan.');
        }

        return redirect()->to('admin/pesan');
    }
}
