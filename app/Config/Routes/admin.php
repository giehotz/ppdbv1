<?php

$routes->group('admin', ['filter' => 'admin'], function ($routes) {
    $routes->get('dashboard', 'Admin\Dashboard::index');

    // Settings
    $routes->get('settings', 'Admin\Settings::index');
    $routes->post('settings/update', 'Admin\Settings::update');

    // Users
    $routes->get('users', 'Admin\Users::index');
    $routes->get('users/create', 'Admin\Users::create');
    $routes->post('users/store', 'Admin\Users::store');
    $routes->get('users/edit/(:num)', 'Admin\Users::edit/$1');
    $routes->post('users/update/(:num)', 'Admin\Users::update/$1');
    $routes->get('users/delete/(:num)', 'Admin\Users::delete/$1');

    // Siswa (Students)
    $routes->get('siswa', 'Admin\Siswa::index');
    $routes->get('siswa/detail/(:num)', 'Admin\Siswa::detail/$1');
    $routes->post('siswa/verify/(:num)', 'Admin\Siswa::verify/$1');
    $routes->get('siswa/delete/(:num)', 'Admin\Siswa::delete/$1');
    $routes->post('siswa/resetPassword/(:num)', 'Admin\Siswa::resetPassword/$1');
    $routes->get('siswa/cetak/(:num)', 'Admin\Siswa::cetak/$1');
    $routes->get('siswa/cetak-kartu/(:num)', 'Admin\Siswa::cetakKartu/$1');
    $routes->get('siswa/export-excel', 'Admin\ExportSiswa::exportExcel');

    // Unlock Requests (Permohonan Buka Kunci)
    $routes->get('unlockrequest', 'Admin\UnlockRequest::index');
    $routes->post('unlockrequest/approve/(:num)', 'Admin\UnlockRequest::approve/$1');
    $routes->post('unlockrequest/reject/(:num)', 'Admin\UnlockRequest::reject/$1');

    // Reset Password Requests
    $routes->get('reset-password', 'Admin\ResetPassword::index');
    $routes->post('reset-password/approve/(:num)', 'Admin\ResetPassword::approve/$1');
    $routes->post('reset-password/reject/(:num)', 'Admin\ResetPassword::reject/$1');

    // Kelulusan
    $routes->get('kelulusan', 'Admin\Kelulusan::index');
    $routes->post('kelulusan/update/(:num)', 'Admin\Kelulusan::update/$1');
    $routes->post('kelulusan/bulkUpdate', 'Admin\Kelulusan::bulkUpdate');

    // Log Aktivitas
    $routes->get('log_aktivitas', 'Admin\LogAktivitas::index');
    $routes->post('log_aktivitas/clear', 'Admin\LogAktivitas::clear');
    $routes->get('log_aktivitas/export-excel', 'Admin\LogAktivitas::exportExcel');

    // Berkas (Documents)
    $routes->get('berkas', 'Admin\Berkas::index');
    $routes->post('berkas/updateStatus/(:num)', 'Admin\Berkas::updateStatus/$1');
    $routes->post('berkas/bulkUpdateStatus', 'Admin\Berkas::bulkUpdateStatus');
    $routes->get('berkas/download/(:num)', 'Admin\Berkas::download/$1');
    $routes->get('berkas/delete/(:num)', 'Admin\Berkas::delete/$1');

    // Pengumuman (Announcements)
    $routes->get('pengumuman', 'Admin\Pengumuman::index');
    $routes->get('pengumuman/create', 'Admin\Pengumuman::create');
    $routes->post('pengumuman/store', 'Admin\Pengumuman::store');
    $routes->get('pengumuman/edit/(:num)', 'Admin\Pengumuman::edit/$1');
    $routes->post('pengumuman/update/(:num)', 'Admin\Pengumuman::update/$1');
    $routes->get('pengumuman/delete/(:num)', 'Admin\Pengumuman::delete/$1');
    $routes->get('pengumuman/toggleStatus/(:num)', 'Admin\Pengumuman::toggleStatus/$1');

    // Pesan (Private Messages)
    $routes->get('pesan', 'Admin\Pesan::index');
    $routes->get('pesan/create', 'Admin\Pesan::create');
    $routes->post('pesan/store', 'Admin\Pesan::store');
    $routes->get('pesan/detail/(:num)', 'Admin\Pesan::detail/$1');
    $routes->get('pesan/delete/(:num)', 'Admin\Pesan::delete/$1');

    // Landing Content (CMS)
    $routes->get('landing-content', 'Admin\LandingContent::index');
    $routes->post('landing-content/update', 'Admin\LandingContent::update');
    $routes->post('landing-content/uploadMedia', 'Admin\LandingContent::uploadMedia');
    $routes->post('landing-content/saveFitur', 'Admin\LandingContent::saveFitur');
    $routes->get('landing-content/deleteFitur/(:num)', 'Admin\LandingContent::deleteFitur/$1');
    $routes->post('landing-content/saveGaleri', 'Admin\LandingContent::saveGaleri');
    $routes->get('landing-content/deleteGaleri/(:num)', 'Admin\LandingContent::deleteGaleri/$1');
    $routes->post('landing-content/saveTestimoni', 'Admin\LandingContent::saveTestimoni');
    $routes->get('landing-content/deleteTestimoni/(:num)', 'Admin\LandingContent::deleteTestimoni/$1');
    $routes->post('landing-content/saveFaq', 'Admin\LandingContent::saveFaq');
    $routes->get('landing-content/deleteFaq/(:num)', 'Admin\LandingContent::deleteFaq/$1');
    $routes->post('landing-content/updateFavicon', 'Admin\LandingContent::updateFavicon');
    
    // Kartu Anggota (Member Cards)
    // Setting Cetak Kartu
    $routes->get('setting-kartu', 'Admin\SettingKartuController::index');
    $routes->get('setting-kartu/preview', 'Admin\SettingKartuController::preview');
    $routes->get('setting-kartu/cetak-masal', 'Admin\SettingKartuController::cetakMasal');
    $routes->post('setting-kartu/saveLayout', 'Admin\SettingKartuController::saveLayout');
    $routes->post('setting-kartu/deleteImage', 'Admin\SettingKartuController::deleteImage');
    $routes->post('setting-kartu/saveQr', 'Admin\SettingKartuController::saveQr');
    $routes->post('setting-kartu/saveTandaTangan', 'Admin\SettingKartuController::saveTandaTangan');
    $routes->post('setting-kartu/savePrinter', 'Admin\SettingKartuController::savePrinter');

    // SEO Settings
    $routes->get('seo', 'Admin\SeoSettings::index');
    $routes->post('seo/update', 'Admin\SeoSettings::update');
});
