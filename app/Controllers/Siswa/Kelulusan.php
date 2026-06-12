<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\TblWebModel;

class Kelulusan extends BaseController
{
    public function index()
    {
        $siswaModel = new SiswaModel();
        $webModel = new TblWebModel();
        $idSiswa = session()->get('id_siswa');
        $siswa = $siswaModel->find($idSiswa);
        $web = $webModel->find(1);

        if (!$siswa) {
            return redirect()->to('/logout');
        }

        $data = [
            'siswa' => $siswa,
            'web' => $web
        ];

        $agent = $this->request->getUserAgent();
        if ($agent->isMobile()) {
            return view('siswa/mobile/kelulusan', $data);
        }

        return view('siswa/kelulusan/index', $data);
    }

    public function cetak()
    {
        $siswaModel = new SiswaModel();
        $webModel = new TblWebModel();

        $idSiswa = session()->get('id_siswa');
        $siswa = $siswaModel->find($idSiswa);

        if (!$siswa || $siswa['status_lulus'] != 'Lulus') {
            return redirect()->to('/siswa/kelulusan');
        }

        $data = [
            'siswa' => $siswa,
            'web' => $webModel->find(1)
        ];

        return view('siswa/kelulusan/cetak', $data);
    }
}
