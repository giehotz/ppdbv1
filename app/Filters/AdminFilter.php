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

        // Determine user type with all possible fallbacks
        $userType = session()->get('user_type') ?? session()->get('level') ?? session()->get('role');

        // Check if user is admin
        if ($userType !== 'admin') {
            if ($userType === 'verifikator') {
                return redirect()->to('/verifikator/dashboard')->withCookies();
            }
            if ($userType === 'siswa') {
                return redirect()->to('/siswa/dashboard')->withCookies();
            }
            // Sesi korup / tidak valid -> destroy dan kembali ke login
            session()->destroy();
            return redirect()->to('/login')->withCookies();
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
