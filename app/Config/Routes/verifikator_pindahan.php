<?php

$routes->group('verifikator', ['filter' => ['verifikator', 'csrf']], function ($routes) {
    $routes->get('pindahan', 'Verifikator\Pindahan::index');
    $routes->get('pindahan/create', 'Verifikator\Pindahan::create');
    $routes->post('pindahan/store', 'Verifikator\Pindahan::store');
    $routes->get('pindahan/detail/(:num)', 'Verifikator\Pindahan::detail/$1');
    $routes->get('pindahan/biodata/(:num)', 'Verifikator\Pindahan::biodata/$1');
    $routes->post('pindahan/biodataStore/(:num)', 'Verifikator\Pindahan::biodataStore/$1');
    $routes->get('pindahan/berkas/(:num)', 'Verifikator\Pindahan::berkas/$1');
    $routes->post('pindahan/berkasUpload/(:num)', 'Verifikator\Pindahan::berkasUpload/$1');
    $routes->post('pindahan/berkasDelete/(:num)', 'Verifikator\Pindahan::berkasDelete/$1');
    $routes->post('pindahan/verify/(:num)', 'Verifikator\Pindahan::verify/$1');
    $routes->get('pindahan/cetak-akun/(:num)', 'Verifikator\Pindahan::cetakAkun/$1');
    $routes->post('pindahan/delete/(:num)', 'Verifikator\Pindahan::delete/$1');
});