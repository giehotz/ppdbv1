<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Check if user is logged in
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        // Check if user is admin
        if (session()->get('user_type') !== 'admin') {
            session()->setFlashdata('error', 'Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman admin.');
            if (session()->get('user_type') === 'verifikator') {
                return redirect()->to('/verifikator/dashboard')->withCookies();
            }
            return redirect()->to('/siswa/dashboard')->withCookies();
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
