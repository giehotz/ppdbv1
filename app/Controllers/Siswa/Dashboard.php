<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
use App\Models\SiswaModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $siswaModel = new SiswaModel();

        // Get current student data
        $idSiswa = session()->get('id_siswa');
        $siswa = $siswaModel->find($idSiswa);

        if (!$siswa) {
            session()->setFlashdata('error', 'Data siswa tidak ditemukan.');
            return redirect()->to('/logout');
        }

        // Calculate completion percentage
        $completionData = $siswaModel->calculateCompletionPercentage($siswa);

        $tblWebModel = new \App\Models\TblWebModel();
        $web = $tblWebModel->find(1);

        $data = [
            'siswa' => $siswa,
            'completionPercentage' => $completionData['percentage'],
            'incompleteFields' => $completionData['incomplete'],
            'web' => $web
        ];

        $agent = $this->request->getUserAgent();
        if ($agent->isMobile()) {
            return view('siswa/mobile/dashboard', $data);
        }

        return view('siswa/dashboard', $data);
    }
}
