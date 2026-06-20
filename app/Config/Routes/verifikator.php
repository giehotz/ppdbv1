<?php

$routes->group('verifikator', ['filter' => ['verifikator', 'csrf']], function ($routes) {
    $routes->get('dashboard', 'Verifikator\Dashboard::index');

    // Siswa (Students)
    $routes->get('siswa', 'Verifikator\Siswa::index');
    $routes->get('siswa/create', 'Verifikator\Siswa::create');
    $routes->post('siswa/store', 'Verifikator\Siswa::store');
    $routes->get('siswa/biodata/(:num)', 'Verifikator\Siswa::biodata/$1');
    $routes->post('siswa/biodataStore/(:num)', 'Verifikator\Siswa::biodataStore/$1');
    $routes->get('siswa/berkas/(:num)', 'Verifikator\Siswa::berkas/$1');
    $routes->post('siswa/berkasUpload/(:num)', 'Verifikator\Siswa::berkasUpload/$1');
    $routes->post('siswa/berkasDelete/(:num)', 'Verifikator\Siswa::berkasDelete/$1');
    $routes->get('siswa/cetak-password', 'Verifikator\Siswa::cetakPassword');
    $routes->get('siswa/cetak-akun/(:num)', 'Verifikator\Siswa::cetakAkun/$1');
    $routes->get('siswa/detail/(:num)', 'Verifikator\Siswa::detail/$1');
    $routes->post('siswa/verify/(:num)', 'Verifikator\Siswa::verify/$1');
    $routes->get('siswa/cetak/(:num)', 'Verifikator\Siswa::cetak/$1');
    $routes->post('siswa/resetPassword/(:num)', 'Verifikator\Siswa::resetPassword/$1');
    $routes->post('siswa/delete/(:num)', 'Verifikator\Siswa::delete/$1');

    // Berkas (Documents)
    $routes->get('berkas', 'Verifikator\Berkas::index');
    $routes->post('berkas/updateStatus/(:num)', 'Verifikator\Berkas::updateStatus/$1');
    $routes->post('berkas/bulkUpdateStatus', 'Verifikator\Berkas::bulkUpdateStatus');
    $routes->get('berkas/download/(:num)', 'Verifikator\Berkas::download/$1');

    // Unlock Requests
    $routes->get('unlockrequest', 'Verifikator\UnlockRequest::index');
    $routes->post('unlockrequest/approve/(:num)', 'Verifikator\UnlockRequest::approve/$1');
    $routes->post('unlockrequest/reject/(:num)', 'Verifikator\UnlockRequest::reject/$1');

    // Pesan (Private Messages)
    $routes->get('pesan', 'Verifikator\Pesan::index');
    $routes->get('pesan/create', 'Verifikator\Pesan::create');
    $routes->post('pesan/store', 'Verifikator\Pesan::store');
    $routes->get('pesan/detail/(:num)', 'Verifikator\Pesan::detail/$1');
    $routes->post('pesan/delete/(:num)', 'Verifikator\Pesan::delete/$1');
});
