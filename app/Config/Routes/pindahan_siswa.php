<?php

$routes->group('siswa', ['filter' => ['pindahan', 'csrf']], function ($routes) {
    // Dashboard Pindahan
    $routes->get('pindahan/dashboard', 'Siswa\Pindahan::index');
    $routes->get('pindahan', 'Siswa\Pindahan::index');

    // Biodata Pindahan (7 step wizard)
    $routes->get('pindahan/biodata', 'Siswa\Pindahan::biodata');
    $routes->post('pindahan/biodata/update', 'Siswa\Pindahan::updateBiodata');
    $routes->post('pindahan/biodata/auto-save', 'Siswa\Pindahan::autoSave');
    $routes->post('pindahan/biodata/finalize', 'Siswa\Pindahan::finalize');

    // Berkas Pindahan
    $routes->get('pindahan/berkas', 'Siswa\Pindahan::berkas');
    $routes->post('pindahan/berkas/upload', 'Siswa\Pindahan::uploadBerkas');
    $routes->post('pindahan/berkas/delete/(:num)', 'Siswa\Pindahan::deleteBerkas/$1');

    // Status
    $routes->get('pindahan/status', 'Siswa\Pindahan::status');

    // Cetak
    $routes->get('pindahan/cetak-formulir', 'Siswa\Pindahan::cetakFormulir');
    $routes->get('pindahan/cetak-kartu', 'Siswa\Pindahan::cetakKartu');
});