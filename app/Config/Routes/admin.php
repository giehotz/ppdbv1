<?php

$routes->group('admin', ['filter' => ['admin', 'csrf']], function ($routes) {
    $routes->get('dashboard', 'Admin\Dashboard::index');

    // Settings
    $routes->get('settings', 'Admin\Settings::index');
    $routes->post('settings/update', 'Admin\Settings::update');

    // Profile
    $routes->get('profile', 'Admin\Profile::index');
    $routes->post('profile/update', 'Admin\Profile::updateProfile');
    $routes->post('profile/updatePassword', 'Admin\Profile::updatePassword');
    $routes->post('profile/updateFoto', 'Admin\Profile::updateFoto');
    $routes->post('profile/deleteFoto', 'Admin\Profile::deleteFoto');

    // Users
    $routes->get('users', 'Admin\Users::index');
    $routes->get('users/create', 'Admin\Users::create');
    $routes->post('users/store', 'Admin\Users::store');
    $routes->get('users/edit/(:num)', 'Admin\Users::edit/$1');
    $routes->post('users/update/(:num)', 'Admin\Users::update/$1');
    $routes->post('users/delete/(:num)', 'Admin\Users::delete/$1');

    // Siswa (Students)
    $routes->get('siswa', 'Admin\Siswa::index');
    $routes->get('siswa/detail/(:num)', 'Admin\Siswa::detail/$1');
    $routes->post('siswa/verify/(:num)', 'Admin\Siswa::verify/$1');
    $routes->post('siswa/delete/(:num)', 'Admin\Siswa::delete/$1');
    $routes->post('siswa/resetPassword/(:num)', 'Admin\Siswa::resetPassword/$1');
    $routes->get('siswa/reset-throttle', 'Admin\Siswa::resetThrottle');
    $routes->post('siswa/reset-throttle', 'Admin\Siswa::resetThrottle');
    $routes->get('siswa/cetak/(:num)', 'Admin\Siswa::cetak/$1');
    $routes->get('siswa/cetak-kartu/(:num)', 'Admin\Siswa::cetakKartu/$1');
    $routes->get('siswa/cetak-password', 'Admin\Siswa::cetakPassword');
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

    // Laporan & Analisis
    $routes->get('laporan', 'Admin\Laporan::index');
    $routes->get('laporan/cetak', 'Admin\Laporan::cetak');

    // Log Aktivitas
    $routes->get('log_aktivitas', 'Admin\LogAktivitas::index');
    $routes->post('log_aktivitas/clear', 'Admin\LogAktivitas::clear');
    $routes->get('log_aktivitas/export-excel', 'Admin\LogAktivitas::exportExcel');

    // Berkas (Documents)
    $routes->get('berkas', 'Admin\Berkas::index');
    $routes->post('berkas/updateStatus/(:num)', 'Admin\Berkas::updateStatus/$1');
    $routes->post('berkas/bulkUpdateStatus', 'Admin\Berkas::bulkUpdateStatus');
    $routes->get('berkas/download/(:num)', 'Admin\Berkas::download/$1');
    $routes->post('berkas/delete/(:num)', 'Admin\Berkas::delete/$1');

    // Pengumuman (Announcements)
    $routes->get('pengumuman', 'Admin\Pengumuman::index');
    $routes->get('pengumuman/create', 'Admin\Pengumuman::create');
    $routes->post('pengumuman/store', 'Admin\Pengumuman::store');
    $routes->get('pengumuman/edit/(:num)', 'Admin\Pengumuman::edit/$1');
    $routes->post('pengumuman/update/(:num)', 'Admin\Pengumuman::update/$1');
    $routes->post('pengumuman/delete/(:num)', 'Admin\Pengumuman::delete/$1');
    $routes->post('pengumuman/toggleStatus/(:num)', 'Admin\Pengumuman::toggleStatus/$1');

    // Pesan (Private Messages)
    $routes->get('pesan', 'Admin\Pesan::index');
    $routes->get('pesan/create', 'Admin\Pesan::create');
    $routes->post('pesan/store', 'Admin\Pesan::store');
    $routes->get('pesan/detail/(:num)', 'Admin\Pesan::detail/$1');
    $routes->post('pesan/delete/(:num)', 'Admin\Pesan::delete/$1');

    // Landing Content (CMS)
    $routes->get('landing-content', 'Admin\LandingContent::index');
    $routes->post('landing-content/update', 'Admin\LandingContent::update');
    $routes->post('landing-content/uploadMedia', 'Admin\LandingContent::uploadMedia');
    $routes->post('landing-content/saveFitur', 'Admin\LandingContent::saveFitur');
    $routes->post('landing-content/deleteFitur/(:num)', 'Admin\LandingContent::deleteFitur/$1');
    $routes->post('landing-content/saveGaleri', 'Admin\LandingContent::saveGaleri');
    $routes->post('landing-content/deleteGaleri/(:num)', 'Admin\LandingContent::deleteGaleri/$1');
    $routes->post('landing-content/saveTestimoni', 'Admin\LandingContent::saveTestimoni');
    $routes->post('landing-content/deleteTestimoni/(:num)', 'Admin\LandingContent::deleteTestimoni/$1');
    $routes->post('landing-content/saveFaq', 'Admin\LandingContent::saveFaq');
    $routes->post('landing-content/deleteFaq/(:num)', 'Admin\LandingContent::deleteFaq/$1');
    $routes->post('landing-content/updateFavicon', 'Admin\LandingContent::updateFavicon');
    
    // Anggota
    $routes->get('anggota', 'Admin\AnggotaController::index');
    $routes->post('anggota/store', 'Admin\AnggotaController::store');
    $routes->post('anggota/update/(:num)', 'Admin\AnggotaController::update/$1');
    $routes->post('anggota/delete/(:num)', 'Admin\AnggotaController::delete/$1');

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

    // Pembiayaan (Payment/Fee)
    $routes->get('pembiayaan', 'Admin\Pembiayaan::index');
    $routes->post('pembiayaan/store', 'Admin\Pembiayaan::store');
    $routes->post('pembiayaan/update', 'Admin\Pembiayaan::update');
    $routes->post('pembiayaan/delete/(:num)', 'Admin\Pembiayaan::delete/$1');
    $routes->post('pembiayaan/activate/(:num)', 'Admin\Pembiayaan::activate/$1');
    $routes->get('pembiayaan/siswa', 'Admin\Pembiayaan::siswaList');
    $routes->get('pembiayaan/siswa/(:num)', 'Admin\Pembiayaan::siswaDetail/$1');
    $routes->post('pembiayaan/siswa/(:num)/tagihan/tambah', 'Admin\Pembiayaan::tambahTagihan/$1');
    $routes->post('pembiayaan/siswa/(:num)/tagihan/tambah-semua', 'Admin\Pembiayaan::tambahSemuaTagihan/$1');
    $routes->post('pembiayaan/siswa/(:num)/tagihan/hapus', 'Admin\Pembiayaan::hapusTagihan/$1');
    $routes->post('pembiayaan/siswa/(:num)/bayar', 'Admin\Pembiayaan::bayar/$1');
    $routes->post('pembiayaan/siswa/(:num)/pembayaran/hapus', 'Admin\Pembiayaan::hapusPembayaran/$1');
    $routes->post('pembiayaan/siswa/(:num)/upload-bukti', 'Admin\Pembiayaan::uploadBukti/$1');
    $routes->post('pembiayaan/siswa/(:num)/hapus-bukti', 'Admin\Pembiayaan::hapusBukti/$1');
    $routes->post('pembiayaan/siswa/(:num)/update-status', 'Admin\Pembiayaan::updateStatusBayar/$1');
    $routes->get('pembiayaan/siswa/(:num)/kuitansi', 'Admin\Pembiayaan::kuitansi/$1');

    // SEO Settings
    $routes->get('seo', 'Admin\SeoSettings::index');
    $routes->post('seo/update', 'Admin\SeoSettings::update');

    // Twibbon Campaigns
    $routes->group('twibbon', function ($routes) {
        $routes->get('/', 'Admin\Twibbon::index');
        $routes->get('create', 'Admin\Twibbon::create');
        $routes->post('store', 'Admin\Twibbon::store');
        $routes->get('edit/(:num)', 'Admin\Twibbon::edit/$1');
        $routes->post('update/(:num)', 'Admin\Twibbon::update/$1');
        $routes->post('delete/(:num)', 'Admin\Twibbon::delete/$1');
        $routes->get('stats/(:num)', 'Admin\Twibbon::stats/$1');
        $routes->get('setting', 'Admin\Twibbon::setting');
        $routes->post('saveSetting', 'Admin\Twibbon::saveSetting');
        $routes->post('cleanup', 'Admin\Twibbon::cleanup');
        $routes->get('download-zip', 'Admin\Twibbon::downloadZip');
    });
});
