<?php

/**
 * QR Code Helper
 * 
 * Generates QR codes locally using endroid/qr-code library.
 * Returns base64 data URIs that can be used directly in <img> src attributes.
 */

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;

if (!function_exists('generate_qr_base64')) {
    /**
     * Generate a QR code image as a base64 data URI string.
     *
     * @param string $data The data/URL to encode in the QR code
     * @param int    $size The size in pixels (default: 200)
     * @param int    $margin The margin/padding in pixels (default: 10)
     * @param string $eccLevel Error correction level: L, M, Q, H (default: M) 
     * @return string Base64 data URI string (e.g., data:image/png;base64,...)
     */
    function generate_qr_base64(string $data, int $size = 200, int $margin = 10, string $eccLevel = 'M'): string
    {
        $eccMap = [
            'L' => ErrorCorrectionLevel::Low,
            'M' => ErrorCorrectionLevel::Medium,
            'Q' => ErrorCorrectionLevel::Quartile,
            'H' => ErrorCorrectionLevel::High,
        ];

        $ecc = $eccMap[strtoupper($eccLevel)] ?? ErrorCorrectionLevel::Medium;

        $result = Builder::create()
            ->data($data)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel($ecc)
            ->size($size)
            ->margin($margin)
            ->roundBlockSizeMode(RoundBlockSizeMode::Margin)
            ->build();

        return $result->getDataUri();
    }
}
