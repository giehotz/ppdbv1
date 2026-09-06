<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\TblWebModel;
use App\Models\BerkasModel;
use App\Models\TagihanSiswaModel;
use App\Models\FaqModel;
use App\Models\DaftarUlangModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $siswaModel = new SiswaModel();

        // Get current student data
        $idSiswa = session()->get('id_siswa');
        if (!$idSiswa) {
            return redirect()->to('/login');
        }

        $siswa = $siswaModel->find($idSiswa);

        if (!$siswa) {
            session()->setFlashdata('error', 'Data siswa tidak ditemukan.');
            return redirect()->to('/logout');
        }

        // 1. Calculate completion percentage
        $completionData = $siswaModel->calculateCompletionPercentage($siswa);
        $completionPct  = $completionData['percentage'];

        // 2. Berkas calculation
        $berkasModel = new BerkasModel();
        $berkasList  = $berkasModel->where('id_siswa', $idSiswa)->findAll();
        $berkasCount = count($berkasList);

        // Required docs: kk, akte, ijazah, foto, ktp_ortu (5 items)
        $berkasRequiredCount = 5;

        // Check if any berkas rejected
        $hasRejectedBerkas = false;
        foreach ($berkasList as $b) {
            if (($b['status_verifikasi'] ?? '') === 'invalid') {
                $hasRejectedBerkas = true;
                break;
            }
        }

        // 3. Web & Settings
        $tblWebModel = new TblWebModel();
        $web = $tblWebModel->find(1) ?? [];

        // 4. Financial Summary
        $tagihanModel = new TagihanSiswaModel();
        $totalTagihan = $tagihanModel->getTotalTagihan($idSiswa);
        $totalLunas   = $tagihanModel->getTotalLunas($idSiswa);
        $statusLunas  = $tagihanModel->isAllLunas($idSiswa);
        $sisaTagihan  = max(0, $totalTagihan - $totalLunas);

        // 5. Post-Admission / Daftar Ulang Status
        $daftarUlang = null;
        if (($siswa['status_lulus'] ?? '') === 'Lulus') {
            $daftarUlangModel = new DaftarUlangModel();
            $daftarUlang = $daftarUlangModel->getBySiswa($idSiswa);
        }

        // 6. FAQs for Helpdesk
        $faqModel = new FaqModel();
        $faqs = $faqModel->orderBy('id', 'ASC')->findAll(6);

        // 7. Milestone Stepper Steps (Dinamis dari Pengaturan Admin)
        $tampilPembiayaan = !isset($web['tampil_pembiayaan_siswa']) || $web['tampil_pembiayaan_siswa'] == 1;
        $stepperAktif = ($web['stepper_aktif'] ?? '1') == '1';

        // Pre-compute standard status variables for system handlers
        $verifStatus = $siswa['status_verifikasi'] ?? 'Menunggu';
        $verifStepStatus = 'pending';
        if ($verifStatus === 'Terverifikasi') {
            $verifStepStatus = 'completed';
        } elseif ($verifStatus === 'Ditolak' || $hasRejectedBerkas) {
            $verifStepStatus = 'warning';
        } elseif ($berkasCount >= $berkasRequiredCount) {
            $verifStepStatus = 'current';
        }

        $ujianAktif = ($web['ujian_aktif'] ?? '0') == '1';
        $tglUjian   = $web['tgl_ujian'] ?? null;
        $ujianDesc  = 'Menunggu Jadwal';
        $ujianStepStatus = 'pending';
        if ($ujianAktif && !empty($tglUjian)) {
            $ujianDesc = date('d M Y', strtotime($tglUjian));
            $ujianStepStatus = (strtotime($tglUjian) < time()) ? 'completed' : 'current';
        }

        $statusLulus = $siswa['status_lulus'] ?? 'Menunggu';
        $lulusStepStatus = 'pending';
        if ($statusLulus === 'Lulus') {
            $lulusStepStatus = 'completed';
        } elseif ($statusLulus === 'Tidak Lulus') {
            $lulusStepStatus = 'danger';
        }

        $duAktif   = ($web['daftar_ulang_aktif'] ?? '1') == '1';
        $tglTutupDu = (!empty($web['tgl_tutup_daftar_ulang']) && $web['tgl_tutup_daftar_ulang'] !== '0000-00-00 00:00:00') ? strtotime($web['tgl_tutup_daftar_ulang']) : null;
        $duExpired = $tglTutupDu && $tglTutupDu < time();
        $isDuOpen  = $duAktif && !$duExpired;

        $daftarUlangStatus = 'pending';
        $daftarUlangDesc   = 'Belum Tersedia';
        if (!empty($daftarUlang)) {
            $daftarUlangStatus = 'completed';
            $daftarUlangDesc   = $daftarUlang['status_konfirmasi'] === 'bersedia' ? 'Terkonfirmasi Masuk' : 'Mundur';
        } elseif ($statusLulus === 'Lulus') {
            if ($isDuOpen) {
                $daftarUlangStatus = 'current';
                $daftarUlangDesc   = 'Harap Konfirmasi';
            } elseif ($duExpired) {
                $daftarUlangStatus = 'pending';
                $daftarUlangDesc   = 'Telah Ditutup';
            } else {
                $daftarUlangStatus = 'pending';
                $daftarUlangDesc   = 'Belum Dibuka';
            }
        }

        $milestones = [];

        if ($stepperAktif) {
            $configuredSteps = \App\Models\TblWebModel::getStepperConfig($web);

            foreach ($configuredSteps as $cStep) {
                // Lewati tahapan yang dinonaktifkan
                if (($cStep['is_active'] ?? 1) == 0) {
                    continue;
                }

                $stepTitle = !empty($cStep['title']) ? $cStep['title'] : 'Tahapan';
                $stepIcon  = !empty($cStep['icon']) ? $cStep['icon'] : 'circle';
                $stepUrlRaw = $cStep['url'] ?? '';
                $stepUrl   = null;
                if (!empty($stepUrlRaw)) {
                    $stepUrl = str_starts_with($stepUrlRaw, 'http') ? $stepUrlRaw : base_url($stepUrlRaw);
                }

                $handler = $cStep['system_handler'] ?? null;
                $isSystem = ($cStep['is_system'] ?? 0) == 1;

                if ($isSystem && $handler) {
                    switch ($handler) {
                        case 'akun':
                            $milestones[] = [
                                'step'        => count($milestones) + 1,
                                'title'       => $stepTitle,
                                'description' => !empty($cStep['description']) ? $cStep['description'] : 'Akun Terdaftar',
                                'status'      => 'completed',
                                'icon'        => $stepIcon,
                                'url'         => $stepUrl,
                            ];
                            break;

                        case 'biodata':
                            $milestones[] = [
                                'step'        => count($milestones) + 1,
                                'title'       => $stepTitle,
                                'description' => $completionPct . '% Selesai',
                                'status'      => $completionPct == 100 ? 'completed' : 'current',
                                'icon'        => $stepIcon,
                                'url'         => $stepUrl ?: base_url('siswa/biodata'),
                            ];
                            break;

                        case 'berkas':
                            $milestones[] = [
                                'step'        => count($milestones) + 1,
                                'title'       => $stepTitle,
                                'description' => $berkasCount . '/' . $berkasRequiredCount . ' Dokumen',
                                'status'      => $berkasCount >= $berkasRequiredCount ? 'completed' : ($completionPct == 100 ? 'current' : 'pending'),
                                'icon'        => $stepIcon,
                                'url'         => $stepUrl ?: base_url('siswa/berkas'),
                            ];
                            break;

                        case 'pembiayaan':
                            if (!$tampilPembiayaan) {
                                break; // Sembunyikan jika sekolah menonaktifkan fitur biaya
                            }
                            $milestones[] = [
                                'step'        => count($milestones) + 1,
                                'title'       => $stepTitle,
                                'description' => $totalTagihan == 0 ? 'Bebas Biaya' : ($statusLunas ? 'Lunas' : 'Belum Lunas'),
                                'status'      => ($totalTagihan == 0 || $statusLunas) ? 'completed' : 'current',
                                'icon'        => $stepIcon,
                                'url'         => $stepUrl ?: base_url('siswa/pembiayaan'),
                            ];
                            break;

                        case 'verifikasi':
                            $milestones[] = [
                                'step'        => count($milestones) + 1,
                                'title'       => $stepTitle,
                                'description' => $verifStatus,
                                'status'      => $verifStepStatus,
                                'icon'        => $stepIcon,
                                'url'         => $stepUrl ?: base_url('siswa/status'),
                            ];
                            break;

                        case 'ujian':
                            $milestones[] = [
                                'step'        => count($milestones) + 1,
                                'title'       => $stepTitle,
                                'description' => $ujianDesc,
                                'status'      => $ujianStepStatus,
                                'icon'        => $stepIcon,
                                'url'         => $stepUrl ?: base_url('siswa/cetak-kartu'),
                            ];
                            break;

                        case 'pengumuman':
                            $milestones[] = [
                                'step'        => count($milestones) + 1,
                                'title'       => $stepTitle,
                                'description' => $statusLulus,
                                'status'      => $lulusStepStatus,
                                'icon'        => $stepIcon,
                                'url'         => $stepUrl ?: base_url('siswa/kelulusan'),
                            ];
                            break;

                        case 'daftar_ulang':
                            $milestones[] = [
                                'step'        => count($milestones) + 1,
                                'title'       => $stepTitle,
                                'description' => $daftarUlangDesc,
                                'status'      => $daftarUlangStatus,
                                'icon'        => $stepIcon,
                                'url'         => ($statusLulus === 'Lulus' && ($isDuOpen || !empty($daftarUlang))) ? ($stepUrl ?: base_url('siswa/daftar-ulang')) : null,
                            ];
                            break;

                        default:
                            $milestones[] = [
                                'step'        => count($milestones) + 1,
                                'title'       => $stepTitle,
                                'description' => $cStep['description'] ?? '-',
                                'status'      => $cStep['custom_status'] ?? 'pending',
                                'icon'        => $stepIcon,
                                'url'         => $stepUrl,
                            ];
                            break;
                    }
                } else {
                    // Tahapan Kustom Tambahan Admin
                    $customStatus = $cStep['custom_status'] ?? 'pending';
                    $customDesc   = !empty($cStep['description']) ? $cStep['description'] : '-';

                    if ($customStatus === 'auto_after_lulus') {
                        $customStatus = ($statusLulus === 'Lulus') ? 'completed' : 'pending';
                        if ($statusLulus === 'Lulus' && empty($cStep['description'])) {
                            $customDesc = 'Terlaksana';
                        }
                    }

                    $milestones[] = [
                        'step'        => count($milestones) + 1,
                        'title'       => $stepTitle,
                        'description' => $customDesc,
                        'status'      => $customStatus,
                        'icon'        => $stepIcon,
                        'url'         => $stepUrl,
                    ];
                }
            }
        }

        // 8. Determine Smart Action Alert
        $smartAlert = null;
        if (($siswa['status_verifikasi'] ?? '') === 'Ditolak' || $hasRejectedBerkas) {
            $smartAlert = [
                'type'        => 'danger',
                'icon'        => 'error',
                'title'       => 'Perhatian: Berkas Dokumen Ditolak',
                'message'     => !empty($siswa['catatan_verifikasi']) 
                                 ? 'Catatan Verifikator: "' . esc($siswa['catatan_verifikasi']) . '". Silakan periksa dan unggah kembali dokumen yang sesuai.'
                                 : 'Beberapa berkas persyaratan Anda ditolak oleh tim verifikator. Silakan periksa dan perbaiki berkas pendaftaran Anda.',
                'btn_text'    => 'Perbaiki Berkas Sekarang',
                'btn_url'     => base_url('siswa/berkas'),
                'btn_color'   => 'bg-red-600 hover:bg-red-700',
            ];
        } elseif ($completionPct < 100) {
            $smartAlert = [
                'type'        => 'warning',
                'icon'        => 'warning',
                'title'       => 'Kelengkapan Biodata Masih ' . $completionPct . '%',
                'message'     => 'Panitia memerlukan data lengkap untuk memvalidasi pendaftaran Anda. Masih terdapat beberapa data yang belum diisi.',
                'btn_text'    => 'Lengkapi Formulir Biodata',
                'btn_url'     => base_url('siswa/biodata'),
                'btn_color'   => 'bg-amber-600 hover:bg-amber-700',
            ];
        } elseif ($berkasCount < $berkasRequiredCount) {
            $smartAlert = [
                'type'        => 'info',
                'icon'        => 'cloud_upload',
                'title'       => 'Unggah Berkas Persyaratan (' . $berkasCount . '/' . $berkasRequiredCount . ')',
                'message'     => 'Biodata Anda telah 100% lengkap! Segera lengkapi berkas persyaratan (KK, Akte, Ijazah, Foto, KTP Ortu) agar dapat diverifikasi.',
                'btn_text'    => 'Unggah Berkas Sekarang',
                'btn_url'     => base_url('siswa/berkas'),
                'btn_color'   => 'bg-brand-600 hover:bg-brand-700',
            ];
        } elseif ($tampilPembiayaan && $totalTagihan > 0 && !$statusLunas) {
            $smartAlert = [
                'type'        => 'billing',
                'icon'        => 'receipt_long',
                'title'       => 'Tagihan Pendaftaran Belum Selesai',
                'message'     => 'Terdapat sisa kewajiban pembayaran sebesar Rp ' . number_format($sisaTagihan, 0, ',', '.') . '. Harap selesaikan pembayaran untuk memvalidasi pendaftaran.',
                'btn_text'    => 'Lihat Tagihan & Cara Bayar',
                'btn_url'     => base_url('siswa/pembiayaan'),
                'btn_color'   => 'bg-blue-600 hover:bg-blue-700',
            ];
        } elseif (($siswa['status_lulus'] ?? '') === 'Lulus') {
            if (empty($daftarUlang)) {
                if ($isDuOpen) {
                    $smartAlert = [
                        'type'        => 'success',
                        'icon'        => 'celebration',
                        'title'       => 'Selamat! Anda Dinyatakan LULUS SELEKSI PPDB',
                        'message'     => 'Tahap selanjutnya adalah konfirmasi Daftar Ulang dan pendataan ukuran seragam sekolah. Silakan klik tombol di bawah.',
                        'btn_text'    => 'Konfirmasi Daftar Ulang & Seragam',
                        'btn_url'     => base_url('siswa/daftar-ulang'),
                        'btn_color'   => 'bg-emerald-600 hover:bg-emerald-700',
                    ];
                } else {
                    $smartAlert = [
                        'type'        => 'success',
                        'icon'        => 'celebration',
                        'title'       => 'Selamat! Anda Dinyatakan LULUS SELEKSI PPDB',
                        'message'     => 'Selamat atas kelulusan Anda! Akses formulir konfirmasi Daftar Ulang saat ini ' . ($duExpired ? 'telah ditutup' : 'belum dibuka oleh panitia') . '. Silakan cetak Surat Bukti Kelulusan.',
                        'btn_text'    => 'Cetak Surat Bukti Kelulusan',
                        'btn_url'     => base_url('siswa/kelulusan/cetak'),
                        'btn_color'   => 'bg-emerald-600 hover:bg-emerald-700',
                    ];
                }
            } else {
                $smartAlert = [
                    'type'        => 'success',
                    'icon'        => 'check_circle',
                    'title'       => 'Konfirmasi Daftar Ulang Telah Disimpan',
                    'message'     => 'Terima kasih telah melakukan konfirmasi pendaftaran. Anda dapat mencetak Surat Kelulusan resmi sebagai tanda bukti penerimaan.',
                    'btn_text'    => 'Cetak Surat Kelulusan',
                    'btn_url'     => base_url('siswa/kelulusan/cetak'),
                    'btn_color'   => 'bg-emerald-600 hover:bg-emerald-700',
                ];
            }
        } elseif ($completionPct == 100 && $berkasCount >= $berkasRequiredCount && $verifStatus === 'Menunggu') {
            $smartAlert = [
                'type'        => 'info',
                'icon'        => 'hourglass_top',
                'title'       => 'Pendaftaran Berhasil Dikirim',
                'message'     => 'Seluruh data dan berkas telah lengkap! Data Anda saat ini sedang dalam antrean verifikasi oleh panitia PPDB.',
                'btn_text'    => 'Pantau Status Verifikasi',
                'btn_url'     => base_url('siswa/status'),
                'btn_color'   => 'bg-indigo-600 hover:bg-indigo-700',
            ];
        }

        $data = [
            'siswa'                => $siswa,
            'completionPercentage' => $completionPct,
            'incompleteFields'     => $completionData['incomplete'],
            'web'                  => $web,
            'berkasCount'          => $berkasCount,
            'berkasRequiredCount'  => $berkasRequiredCount,
            'totalTagihan'         => $totalTagihan,
            'totalLunas'           => $totalLunas,
            'statusLunas'          => $statusLunas,
            'sisaTagihan'          => $sisaTagihan,
            'tampilPembiayaan'     => $tampilPembiayaan,
            'daftarUlang'          => $daftarUlang,
            'faqs'                 => $faqs,
            'milestones'           => $milestones,
            'smartAlert'           => $smartAlert,
            'canPrintCard'         => ($completionPct >= 100 || ($siswa['status_verifikasi'] ?? '') === 'Terverifikasi'),
        ];

        $agent = $this->request->getUserAgent();
        if ($agent->isMobile()) {
            return view('siswa/mobile/dashboard', $data);
        }

        return view('siswa/dashboard', $data);
    }
}
