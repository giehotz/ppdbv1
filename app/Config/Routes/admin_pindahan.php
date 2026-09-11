<?php

$routes->group('admin', ['filter' => ['admin', 'csrf']], function ($routes) {
    $routes->get('pindahan', 'Admin\Pindahan::index');
    $routes->get('pindahan/detail/(:num)', 'Admin\Pindahan::detail/$1');
    $routes->get('pindahan/quick-detail/(:num)', 'Admin\Pindahan::quickDetail/$1');
    $routes->post('pindahan/verify/(:num)', 'Admin\Pindahan::verify/$1');
    $routes->post('pindahan/bulk-verify', 'Admin\Pindahan::bulkVerify');
    $routes->post('pindahan/delete/(:num)', 'Admin\Pindahan::delete/$1');
    $routes->post('pindahan/bulk-delete', 'Admin\Pindahan::bulkDelete');
    $routes->post('pindahan/reset-password/(:num)', 'Admin\Pindahan::resetPassword/$1');
    $routes->get('pindahan/cetak/(:num)', 'Admin\Pindahan::cetak/$1');
    $routes->get('pindahan/cetak-kartu/(:num)', 'Admin\Pindahan::cetakKartu/$1');
    $routes->post('pindahan/berkas/verify/(:num)', 'Admin\Pindahan::verifyBerkas/$1');
    $routes->get('pindahan/export-excel', 'Admin\Pindahan::exportExcel');
});