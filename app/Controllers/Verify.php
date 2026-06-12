<?php

namespace App\Controllers;

use App\Models\SiswaModel;
use App\Models\TblWebModel;

class Verify extends BaseController
{
    public function index($no_pendaftaran = null)
    {
        if (empty($no_pendaftaran)) {
            return view('verifikasi/index', [
                'status' => 'error',
                'message' => 'Nomor pendaftaran tidak valid atau tidak ditemukan.',
                'title' => 'Verifikasi Gagal'
            ]);
        }

        // Decode the URL encoded parameter just in case
        $no_pendaftaran = urldecode($no_pendaftaran);

        $siswaModel = new SiswaModel();
        $siswa = $siswaModel->where('no_pendaftaran', $no_pendaftaran)->first();

        $webModel = new TblWebModel();
        $instansi = $webModel->first();

        if ($siswa) {
            // Get foto if exists
            $berkasModel = new \App\Models\BerkasModel();
            $berkasFoto = $berkasModel->where('id_siswa', $siswa['id_siswa'])
                ->where('jenis_berkas', 'foto')
                ->orderBy('created_at', 'DESC')
                ->first();
                
            if ($berkasFoto) {
                $siswa['foto_berkas'] = $berkasFoto['path_file'];
            }

            return view('verifikasi/index', [
                'status' => 'success',
                'siswa' => $siswa,
                'instansi' => $instansi,
                'title' => 'Verifikasi Data Siswa'
            ]);
        } else {
            return view('verifikasi/index', [
                'status' => 'error',
                'message' => 'Data calon siswa dengan Nomor Pendaftaran ' . esc($no_pendaftaran) . ' tidak ditemukan di sistem kami.',
                'title' => 'Verifikasi Gagal'
            ]);
        }
    }
}
