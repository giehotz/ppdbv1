<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\TblWebModel;
use App\Models\DaftarUlangModel;

class DaftarUlang extends BaseController
{
    public function index()
    {
        $idSiswa = session()->get('id_siswa');
        if (!$idSiswa) {
            return redirect()->to('/login');
        }

        $siswaModel = new SiswaModel();
        $siswa = $siswaModel->find($idSiswa);
        if (!$siswa) {
            return redirect()->to('/logout');
        }

        // Hanya siswa berstatus 'Lulus' yang boleh mengakses form daftar ulang
        if (($siswa['status_lulus'] ?? '') !== 'Lulus') {
            session()->setFlashdata('error', 'Fitur Daftar Ulang hanya tersedia bagi calon siswa yang telah dinyatakan Lulus Seleksi.');
            return redirect()->to(base_url('siswa/dashboard'));
        }

        $webModel = new TblWebModel();
        $web = $webModel->first() ?? [];

        $daftarUlangModel = new DaftarUlangModel();
        $daftarUlang = $daftarUlangModel->getBySiswa($idSiswa);

        // Cek status aktif dan batas waktu daftar ulang dari pengaturan admin
        $daftarUlangAktif = ($web['daftar_ulang_aktif'] ?? '1') == '1';
        $tglTutup = (!empty($web['tgl_tutup_daftar_ulang']) && $web['tgl_tutup_daftar_ulang'] !== '0000-00-00 00:00:00') ? strtotime($web['tgl_tutup_daftar_ulang']) : null;
        $isExpired = $tglTutup && $tglTutup < time();
        $isClosed = !$daftarUlangAktif || $isExpired;

        // Cek apakah bagian seragam diaktifkan/ditampilkan oleh admin
        $seragamAktif = ($web['seragam_aktif'] ?? '1') == '1';
        $seragamFields = DaftarUlangModel::getSeragamFields($web);

        // Parse jawaban seragam sebelumnya jika ada
        $seragamAnswers = [];
        if (!empty($daftarUlang['data_seragam'])) {
            $seragamAnswers = json_decode($daftarUlang['data_seragam'], true) ?: [];
        }

        $data = [
            'siswa'             => $siswa,
            'web'               => $web,
            'daftarUlang'       => $daftarUlang,
            'daftarUlangAktif'  => $daftarUlangAktif,
            'isExpired'         => $isExpired,
            'isClosed'          => $isClosed,
            'seragamAktif'      => $seragamAktif,
            'seragamFields'     => $seragamFields,
            'seragamAnswers'    => $seragamAnswers,
        ];

        $agent = $this->request->getUserAgent();
        if ($agent->isMobile()) {
            return view('siswa/mobile/daftar_ulang', $data);
        }

        return view('siswa/daftar_ulang/index', $data);
    }

    public function simpan()
    {
        $idSiswa = session()->get('id_siswa');
        if (!$idSiswa) {
            return redirect()->to('/login');
        }

        $siswaModel = new SiswaModel();
        $siswa = $siswaModel->find($idSiswa);
        if (!$siswa || ($siswa['status_lulus'] ?? '') !== 'Lulus') {
            return redirect()->to(base_url('siswa/dashboard'));
        }

        $webModel = new TblWebModel();
        $web = $webModel->first() ?? [];

        // Validasi apakah daftar ulang masih aktif & belum kedaluwarsa
        $daftarUlangAktif = ($web['daftar_ulang_aktif'] ?? '1') == '1';
        $tglTutup = (!empty($web['tgl_tutup_daftar_ulang']) && $web['tgl_tutup_daftar_ulang'] !== '0000-00-00 00:00:00') ? strtotime($web['tgl_tutup_daftar_ulang']) : null;
        if (!$daftarUlangAktif || ($tglTutup && $tglTutup < time())) {
            session()->setFlashdata('error', 'Akses pengisian formulir daftar ulang saat ini sedang ditutup atau telah berakhir oleh panitia.');
            return redirect()->to(base_url('siswa/daftar-ulang'));
        }

        $statusKonfirmasi = $this->request->getPost('status_konfirmasi');
        if (!in_array($statusKonfirmasi, ['bersedia', 'mengundurkan_diri'])) {
            $statusKonfirmasi = 'bersedia';
        }

        $seragamAktif = ($web['seragam_aktif'] ?? '1') == '1';
        $seragamFields = DaftarUlangModel::getSeragamFields($web);

        $dataSave = [
            'id_siswa'          => $idSiswa,
            'status_konfirmasi' => $statusKonfirmasi,
            'ukuran_baju'       => null,
            'ukuran_celana'     => null,
            'ukuran_peci'       => null,
            'ukuran_sepatu'     => null,
            'data_seragam'      => null,
            'alasan_mundur'     => $statusKonfirmasi === 'mengundurkan_diri' ? $this->request->getPost('alasan_mundur') : null,
            'catatan'           => $statusKonfirmasi === 'bersedia' ? $this->request->getPost('catatan') : null,
            'tgl_konfirmasi'    => date('Y-m-d H:i:s'),
        ];

        // Jika bersedia dan seragam diaktifkan oleh admin, proses seluruh field dinamis seragam
        if ($statusKonfirmasi === 'bersedia' && $seragamAktif) {
            $answers = [];
            foreach ($seragamFields as $f) {
                $fid = $f['id'];
                $val = $this->request->getPost($fid);
                $answers[$fid] = $val;

                // Sync ke kolom standar untuk kompatibilitas
                if ($fid === 'ukuran_baju') $dataSave['ukuran_baju'] = $val;
                if ($fid === 'ukuran_celana') $dataSave['ukuran_celana'] = $val;
                if ($fid === 'ukuran_peci') $dataSave['ukuran_peci'] = $val;
                if ($fid === 'ukuran_sepatu') $dataSave['ukuran_sepatu'] = $val;
            }
            $dataSave['data_seragam'] = json_encode($answers, JSON_UNESCAPED_UNICODE);
        }

        $daftarUlangModel = new DaftarUlangModel();
        $existing = $daftarUlangModel->getBySiswa($idSiswa);

        if ($existing) {
            $daftarUlangModel->update($existing['id_daftar_ulang'], $dataSave);
        } else {
            $daftarUlangModel->insert($dataSave);
        }

        $msg = ($statusKonfirmasi === 'bersedia' && $seragamAktif)
            ? 'Konfirmasi Daftar Ulang & data ukuran seragam berhasil disimpan!'
            : 'Konfirmasi Daftar Ulang berhasil disimpan!';

        session()->setFlashdata('success', $msg);
        return redirect()->to(base_url('siswa/daftar-ulang'));
    }
}
