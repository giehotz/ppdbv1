<?php

/**
 * Helper Cetak & PDF
 * Menyediakan CSS konsisten (@page, typography, print-color-adjust, line-height reset),
 * komponen kontrol aksi cetak, dan shortcut PDF generator untuk sistem PPDB.
 */

if (!function_exists('cetak_css')) {
    /**
     * Menghasilkan blok CSS standar agar layout cetak selalu konsisten di layar & print PDF
     */
    function cetak_css(string $paperSize = 'A4', string $orientation = 'portrait', string $margin = '8mm'): string
    {
        $paperSizeSafe   = preg_replace('/[^a-zA-Z0-9]/', '', $paperSize);
        $orientationSafe = in_array(strtolower($orientation), ['portrait', 'landscape'], true) ? strtolower($orientation) : 'portrait';
        $marginSafe      = htmlspecialchars($margin, ENT_QUOTES, 'UTF-8');

        return '
        <style>
            @page {
                size: ' . $paperSizeSafe . ' ' . $orientationSafe . ';
                margin: ' . $marginSafe . ';
            }
            *, *::before, *::after {
                box-sizing: border-box;
            }
            body {
                margin: 0;
                padding: 0;
                background-color: #f1f5f9;
                color: #0f172a;
                font-family: "Segoe UI", Arial, Helvetica, sans-serif;
                font-size: 11px;
                line-height: normal;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .paper-container, .print-sheet {
                background: #ffffff;
                width: 100%;
                max-width: 210mm;
                margin: 15px auto;
                padding: 15mm 15mm;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
                border-radius: 4px;
                box-sizing: border-box;
                line-height: normal;
            }
            table {
                border-collapse: collapse;
                width: 100%;
                line-height: normal;
            }
            tr, .avoid-break {
                page-break-inside: avoid;
                break-inside: avoid;
            }
            .no-print {
                display: block;
            }
            @media print {
                body {
                    background: transparent !important;
                    margin: 0 !important;
                    padding: 0 !important;
                }
                .paper-container, .print-sheet {
                    box-shadow: none !important;
                    border: none !important;
                    margin: 0 auto !important;
                    padding: 0 !important;
                    max-width: 100% !important;
                    width: 100% !important;
                }
                .no-print {
                    display: none !important;
                }
            }
        </style>';
    }
}

if (!function_exists('cetak_tombol_aksi')) {
    /**
     * Menghasilkan toolbar cetak (tombol Cetak dan Tutup/Kembali yang aman tanpa error browser)
     */
    function cetak_tombol_aksi(string $title = 'Cetak Dokumen', string $fallbackUrl = ''): string
    {
        $safeFallback = !empty($fallbackUrl) ? $fallbackUrl : base_url();

        return '
        <div class="no-print" style="position: fixed; top: 12px; right: 16px; z-index: 9999; display: flex; align-items: center; gap: 8px; font-family: sans-serif;">
            <button type="button" onclick="window.print()" style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; background: #0f172a; color: #ffffff; border: none; border-radius: 6px; font-size: 13px; font-weight: 600; cursor: pointer; box-shadow: 0 2px 6px rgba(0,0,0,0.2);">
                &#128438; ' . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . '
            </button>
            <button type="button" onclick="cetakTutupAtauKembali(\'' . esc($safeFallback, 'attr') . '\')" style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 14px; background: #ef4444; color: #ffffff; border: none; border-radius: 6px; font-size: 13px; font-weight: 600; cursor: pointer; box-shadow: 0 2px 6px rgba(0,0,0,0.15);">
                &#10005; Tutup
            </button>
        </div>
        <script>
            function cetakTutupAtauKembali(fallback) {
                if (window.opener) {
                    window.close();
                } else if (document.referrer && document.referrer.indexOf(window.location.host) !== -1) {
                    window.history.back();
                } else {
                    window.location.href = fallback;
                }
            }
        </script>';
    }
}

if (!function_exists('unduh_pdf')) {
    /**
     * Shortcut untuk generate PDF dari view menggunakan PdfGenerator Dompdf
     */
    function unduh_pdf(string $viewPath, array $data, string $filename, bool $download = false): void
    {
        $generator = new \App\Libraries\PdfGenerator();
        $generator->generate($viewPath, $data, $filename, $download);
    }
}
