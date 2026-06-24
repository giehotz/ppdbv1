<?php

if (!function_exists('image_to_base64')) {
    /**
     * Convert an image file to a base64 Data URI
     *
     * @param string $relativePath Relative path from FCPATH
     * @return string Base64 data URI or empty string if not found
     */
    function image_to_base64($relativePath)
    {
        $fullPath = FCPATH . $relativePath;
        if (file_exists($fullPath) && !is_dir($fullPath)) {
            $type = pathinfo($fullPath, PATHINFO_EXTENSION);
            $data = @file_get_contents($fullPath);
            if ($data !== false) {
                return 'data:image/' . $type . ';base64,' . base64_encode($data);
            }
        }
        return '';
    }
}

if (!function_exists('render_kop_surat')) {
    /**
     * Render the Kop Surat for PDF or printing
     *
     * @return string HTML of the Kop Surat
     */
    function render_kop_surat()
    {
        try {
            $kopModel = new \App\Models\SettingKopModel();
            $kop = $kopModel->find(1);
        } catch (\Exception $e) {
            $kop = null;
            log_message('warning', 'Gagal memuat SettingKopModel: ' . $e->getMessage());
        }

        if (!$kop) {
            // Default fallback if no data in database
            $kop = [
                'logo_kiri' => 'logo-kemenag.png',
                'kementerian_pusat' => 'KEMENTERIAN AGAMA REPUBLIK INDONESIA',
                'kementerian_kabupaten' => 'KANTOR KEMENTERIAN AGAMA KABUPATEN TANGGAMUS',
                'nama_madrasah' => 'MADRASAH IBTIDAIYAH NEGERI 2 TANGGAMUS',
                'alamat_madrasah' => 'Jln. Lap. Ampera No. 109 Purwodadi Kec. Gisting Kab. Tanggamus (0729) 347578 35378',
                'email_madrasah' => 'Email : minduatanggamus@gmail.com',
            ];
        }

        // Get logo image path for PDF (usually requires absolute local path or base64 for dompdf)
        $logoPath = 'uploads/kop/' . $kop['logo_kiri'];
        $logoSrc = '';

        // 1. Try base64 conversion first
        if (!empty($kop['logo_kiri'])) {
            $logoSrc = image_to_base64($logoPath);
        }

        // 2. If base64 failed but it is a custom uploaded logo, use base_url directly
        if (empty($logoSrc) && !empty($kop['logo_kiri']) && $kop['logo_kiri'] !== 'logo-kemenag.png') {
            $logoSrc = base_url($logoPath);
        }

        // 3. If logoSrc is still empty or the file does not exist, fall back to school logo from tbl_web
        $fullPath = FCPATH . $logoPath;
        if (empty($logoSrc) || !file_exists($fullPath) || is_dir($fullPath)) {
            try {
                $webModel = new \App\Models\TblWebModel();
                $web = $webModel->first();
                if ($web && !empty($web['logo_sekolah'])) {
                    $schoolLogoPath = 'uploads/logo/' . $web['logo_sekolah'];
                    $schoolLogoSrc = image_to_base64($schoolLogoPath);
                    if (empty($schoolLogoSrc)) {
                        $schoolLogoSrc = base_url($schoolLogoPath);
                    }
                    if (!empty($schoolLogoSrc)) {
                        $logoSrc = $schoolLogoSrc;
                    }
                }
            } catch (\Exception $e) {
                // Ignore
            }
        }

        // 4. Ultimate fallback
        if (empty($logoSrc)) {
            $logoSrc = base_url($logoPath);
        }

        $html = '
        <table width="100%" style="border-bottom: 3px solid #000; padding-bottom: 5px; margin-bottom: 15px;">
            <tr>
                <td width="15%" style="text-align: center; vertical-align: middle;">
                    <img src="' . $logoSrc . '" alt="Logo" style="width: 80px; height: auto;">
                </td>
                <td width="85%" style="text-align: center; vertical-align: middle;">
                    <div style="font-size: 12pt; font-weight: bold; margin-bottom: 2px;">' . htmlspecialchars($kop['kementerian_pusat']) . '</div>
                    <div style="font-size: 12pt; font-weight: bold; margin-bottom: 2px;">' . htmlspecialchars($kop['kementerian_kabupaten']) . '</div>
                    <div style="font-size: 12pt; font-weight: bold; margin-bottom: 2px;">' . htmlspecialchars($kop['nama_madrasah']) . '</div>
                    <div style="font-size: 9pt; margin-top: 5px;">' . htmlspecialchars($kop['alamat_madrasah']) . '</div>
                    <div style="font-size: 9pt;">' . htmlspecialchars($kop['email_madrasah']) . '</div>
                </td>
            </tr>
        </table>
        ';

        return $html;
    }
}
