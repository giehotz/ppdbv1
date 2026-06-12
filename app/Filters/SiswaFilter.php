<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class SiswaFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Check if user is logged in
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        // Check if user is student
        if (session()->get('user_type') !== 'siswa') {
            session()->setFlashdata('error', 'Akses ditolak. Halaman ini hanya untuk siswa.');
            if (session()->get('user_type') === 'verifikator') {
                return redirect()->to('/verifikator/dashboard')->withCookies();
            }
            return redirect()->to('/admin/dashboard')->withCookies();
        }

        // Cek apakah fitur wajib biodata 100% diaktifkan oleh admin
        $tblWebModel = new \App\Models\TblWebModel();
        $web = $tblWebModel->find(1);
        $wajibBiodata = ($web['wajib_biodata_100'] ?? 1) == 1;

        if ($wajibBiodata) {
            // Cek kelengkapan biodata 100%
            $siswaModel = new \App\Models\SiswaModel();
            $siswa = $siswaModel->find(session()->get('id_siswa'));
            
            if ($siswa) {
                $completionData = $siswaModel->calculateCompletionPercentage($siswa);
                if ($completionData['percentage'] < 100) {
                    $uriPath = (string) $request->getUri()->getPath();
                    
                    $isAllowed = false;
                    $allowedRoutes = [
                        'siswa/biodata',
                        'siswa/biodata/update',
                        'siswa/biodata/auto-save'
                    ];
                    
                    foreach ($allowedRoutes as $route) {
                        if (strpos($uriPath, $route) !== false) {
                            $isAllowed = true;
                            break;
                        }
                    }

                    if (!$isAllowed) {
                        session()->setFlashdata('warning', 'Akses dibatasi. Anda wajib melengkapi formulir biodata ini hingga 100% sebelum dapat menggunakan sistem. (Saat ini kelengkapan Anda: ' . $completionData['percentage'] . '%)');
                        return redirect()->to('/siswa/biodata');
                    }
                }
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
