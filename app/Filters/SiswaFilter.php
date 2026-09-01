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

        // Determine user type with all possible fallbacks
        $userType = session()->get('user_type') ?? session()->get('level') ?? session()->get('role');

        // Check if user is student
        if ($userType !== 'siswa') {
            if ($userType === 'verifikator') {
                return redirect()->to('/verifikator/dashboard')->withCookies();
            }
            if ($userType === 'admin') {
                return redirect()->to('/admin/dashboard')->withCookies();
            }
            // Sesi korup / tidak valid -> destroy dan kembali ke login
            session()->destroy();
            return redirect()->to('/login')->withCookies();
        }

        // Cek apakah fitur wajib biodata 100% diaktifkan oleh admin — gunakan cache
        $cache      = \Config\Services::cache();
        $appData    = $cache->get('app_settings');
        if ($appData === null) {
            $tblWebModel = new \App\Models\TblWebModel();
            $seoModel    = new \App\Models\SeoModel();
            $appData     = [
                'web' => $tblWebModel->first() ?? [],
                'seo' => $seoModel->find(1) ?? [],
            ];
            $cache->save('app_settings', $appData, 1800);
        }
        $web = $appData['web'];
        $wajibBiodata = ($web['wajib_biodata_100'] ?? 1) == 1;

        if ($wajibBiodata) {
            $siswaId = session()->get('id_siswa');
            if ($siswaId) {
                $siswaModel = new \App\Models\SiswaModel();
                $siswa = $siswaModel->find($siswaId);
                
                if ($siswa) {
                    // Cache completion percentage per siswa (2 menit)
                    $cacheKey      = 'completion_' . $siswaId;
                    $completionData = $cache->get($cacheKey);
                    if ($completionData === null) {
                        $completionData = $siswaModel->calculateCompletionPercentage($siswa);
                        $cache->save($cacheKey, $completionData, 120); // 2 menit
                    }
                    if ($completionData['percentage'] < 100) {
                        $uriPath = (string) $request->getUri()->getPath();
                        
                        $isAllowed = false;
                        // Semua route biodata yang boleh diakses saat belum 100%
                        $allowedRoutes = [
                            'siswa/biodata',
                            'siswa/biodata/update',
                            'siswa/biodata/auto-save',
                            'siswa/biodata/finalize',
                            'siswa/biodata/ajukan-buka',
                        ];

                        // Bersihkan leading slash agar perbandingan konsisten
                        $cleanPath = ltrim($uriPath, '/');
                        
                        foreach ($allowedRoutes as $route) {
                            // Cocokkan dari awal path atau sebagai substring (untuk sub-route)
                            if ($cleanPath === $route || strpos($cleanPath, $route) === 0) {
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
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
