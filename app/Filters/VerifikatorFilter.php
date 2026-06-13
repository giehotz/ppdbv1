<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class VerifikatorFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Check if user is logged in
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        // Check if user is verifikator
        if (session()->get('user_type') !== 'verifikator') {
            session()->setFlashdata('error', 'Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman verifikator.');
            // Redirect based on their actual role
            if (session()->get('user_type') === 'admin') {
                return redirect()->to('/admin/dashboard')->withCookies();
            } else {
                return redirect()->to('/siswa/dashboard')->withCookies();
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
