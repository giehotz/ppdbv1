<?php

if (!function_exists('render_kop_surat')) {
    /**
     * Render the Kop Surat for PDF or printing
     *
     * @return string HTML of the Kop Surat
     */
    function render_kop_surat()
    {
        $kopModel = new \App\Models\SettingKopModel();
        $kop = $kopModel->find(1);

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
        if (file_exists(FCPATH . $logoPath)) {
            $logoSrc = base_url($logoPath);
        } else {
            // Fallback to default asset if uploaded file doesn't exist
            $logoSrc = base_url('assets/images/logo-kemenag.png');
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
