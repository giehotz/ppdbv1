<?php

$routes->group('siswa', ['filter' => ['siswa', 'csrf']], function ($routes) {
    $routes->get('dashboard', 'Siswa\Dashboard::index');
    $routes->get('biodata', 'Siswa\Biodata::index');
    $routes->post('biodata/update', 'Siswa\Biodata::update');
    $routes->post('biodata/auto-save', 'Siswa\Biodata::autoSave');
    $routes->post('biodata/finalize', 'Siswa\Biodata::finalize');
    $routes->post('biodata/ajukan-buka', 'Siswa\Biodata::ajukanBukaKunci');
    $routes->get('berkas', 'Siswa\Berkas::index');
    $routes->post('berkas/upload', 'Siswa\Berkas::upload');
    $routes->post('berkas/delete/(:num)', 'Siswa\Berkas::delete/$1');
    $routes->get('status', 'Siswa\Status::index');
    $routes->get('pengumuman', 'Siswa\Pengumuman::index');
    $routes->get('cetak-formulir', 'Siswa\CetakFormulir::index');

    // Pesan (Private Messages)
    $routes->get('pesan', 'Siswa\Pesan::index');
    $routes->get('pesan/detail/(:num)', 'Siswa\Pesan::detail/$1');

    // Kelulusan
    $routes->get('kelulusan', 'Siswa\Kelulusan::index');
    $routes->get('kelulusan/cetak', 'Siswa\Kelulusan::cetak');

    // Twibbon
    $routes->group('twibbon', function ($routes) {
        $routes->get('/', 'Siswa\Twibbon::index');
        $routes->get('(:segment)', 'Siswa\Twibbon::detail/$1');
        $routes->post('process', 'Siswa\Twibbon::process');
    });

    // Profile
    $routes->get('profile', 'Siswa\Profile::index');
    $routes->post('profile/update-foto', 'Siswa\Profile::updateFoto');
    $routes->post('profile/delete-foto', 'Siswa\Profile::deleteFoto');
    $routes->get('ubah-password', 'Siswa\Profile::ubahPassword');
    $routes->post('profile/update-password', 'Siswa\Profile::updatePassword');
});
