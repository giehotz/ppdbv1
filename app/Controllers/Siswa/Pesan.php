<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
use App\Models\PesanModel;

class Pesan extends BaseController
{
    protected $pesanModel;

    public function __construct()
    {
        $this->pesanModel = new PesanModel();
    }

    public function index()
    {
        $id_siswa = session()->get('id_siswa');
        
        $data = [
            'pesan' => $this->pesanModel->getPesanMasukSiswa($id_siswa),
            'page_title' => 'Kotak Masuk'
        ];

        $agent = $this->request->getUserAgent();
        if ($agent->isMobile()) {
            return view('siswa/mobile/pesan', $data);
        }

        return view('siswa/pesan/index', $data);
    }

    public function detail($id)
    {
        $id_siswa = session()->get('id_siswa');
        $pesan = $this->pesanModel->getDetailPesanSiswa($id, $id_siswa);

        if (!$pesan) {
            session()->setFlashdata('error', 'Pesan tidak ditemukan.');
            return redirect()->to('siswa/pesan');
        }

        // Set status to read if unread
        if ($pesan['status'] === 'unread') {
            $this->pesanModel->update($id, ['status' => 'read']);
            $pesan['status'] = 'read';
        }

        $data = [
            'pesan' => $pesan,
            'page_title' => 'Detail Pesan'
        ];

        $agent = $this->request->getUserAgent();
        if ($agent->isMobile()) {
            return view('siswa/mobile/pesan_detail', $data);
        }

        return view('siswa/pesan/detail', $data);
    }
}
