<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// SEO Routes
$routes->get('robots.txt', 'Seo::robots');
$routes->get('sitemap.xml', 'Seo::sitemap');

$routes->get('/login', 'Auth::index');
$routes->post('/auth/login', 'Auth::login');
$routes->get('/logout', 'Auth::logout');
$routes->post('/auth/logout', 'Auth::logout');
$routes->get('/auth/register', 'Auth::register');
$routes->post('/auth/doRegister', 'Auth::doRegister');
$routes->post('/auth/forgot-password', 'Auth::submitForgotPassword');

// Verification QR code route
$routes->get('/verify/(:any)', 'Verify::index/$1');

// Impersonate Routes (Protected with auth filter & POST method to prevent CSRF)
$routes->post('/impersonate/start/(:num)', 'Impersonate::start/$1', ['filter' => 'auth']);
$routes->post('/impersonate/start-pindahan/(:num)', 'Impersonate::startPindahan/$1', ['filter' => 'auth']);
$routes->post('/impersonate/stop', 'Impersonate::stop', ['filter' => 'auth']);

// Public / Shared API Cari Sekolah
$routes->get('api/search-sekolah', 'Siswa\Biodata::searchSekolah');
$routes->get('siswa/biodata/search-sekolah', 'Siswa\Biodata::searchSekolah');

$routes->get('admin', function () {
    return redirect()->to('/admin/dashboard');
});

if (file_exists(APPPATH . 'Config/Routes/siswa.php')) {
    require APPPATH . 'Config/Routes/siswa.php';
}

if (file_exists(APPPATH . 'Config/Routes/admin.php')) {
    require APPPATH . 'Config/Routes/admin.php';
}

if (file_exists(APPPATH . 'Config/Routes/verifikator.php')) {
    require APPPATH . 'Config/Routes/verifikator.php';
}

// Routes khusus modul Siswa Pindahan (terisolasi dari siswa reguler)
if (file_exists(APPPATH . 'Config/Routes/pindahan_siswa.php')) {
    require APPPATH . 'Config/Routes/pindahan_siswa.php';
}

if (file_exists(APPPATH . 'Config/Routes/admin_pindahan.php')) {
    require APPPATH . 'Config/Routes/admin_pindahan.php';
}

if (file_exists(APPPATH . 'Config/Routes/verifikator_pindahan.php')) {
    require APPPATH . 'Config/Routes/verifikator_pindahan.php';
}

// API Routes
$routes->group('api/notifikasi', function ($routes) {
    $routes->get('count', 'API\NotifikasiPengumuman::count');
    $routes->get('recent', 'API\NotifikasiPengumuman::recent');
});

// Twibbon Public Routes
$routes->group('twibbon', function ($routes) {
    $routes->get('/', 'Twibbon::index');
    $routes->get('(:segment)', 'Twibbon::detail/$1');
    $routes->post('process', 'Twibbon::process');
});
