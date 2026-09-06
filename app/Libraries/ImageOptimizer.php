<?php

namespace App\Libraries;

use CodeIgniter\HTTP\Files\UploadedFile;

/**
 * ImageOptimizer Library
 * Mengonversi gambar (JPG, PNG, GIF, WebP, BMP) ke format WebP super ringan,
 * menangani kompresi proporsional, preservasi transparansi alpha, dan penghapusan file lama.
 */
class ImageOptimizer
{
    /**
     * Mengonversi UploadedFile atau file path lokal menjadi file WebP.
     *
     * @param UploadedFile|string $source
     * @param string $targetSubdir Direktori relatif terhadap FCPATH (misal: 'uploads/landing/galeri')
     * @param int $maxWidth Maksimal lebar gambar dalam pixel
     * @param int $maxHeight Maksimal tinggi gambar dalam pixel
     * @param int $quality Kualitas WebP (1-100, default 82)
     * @return array [success, message, relative_path, filename, original_size, new_size, savings_pct, width, height]
     */
    public static function convertToWebp(
        $source,
        string $targetSubdir = 'uploads/landing/galeri',
        int $maxWidth = 1600,
        int $maxHeight = 1600,
        int $quality = 82
    ): array {
        // 1. Verifikasi dukungan GD WebP pada PHP
        if (!function_exists('imagewebp')) {
            return [
                'success' => false,
                'message' => 'PHP GD WebP extension tidak aktif pada server.',
            ];
        }

        // 2. Ambil path dan info file sumber
        $sourcePath = null;
        $originalSize = 0;

        if ($source instanceof UploadedFile) {
            if (!$source->isValid() || $source->hasMoved()) {
                return [
                    'success' => false,
                    'message' => 'File upload tidak valid atau sudah dipindahkan.',
                ];
            }
            $sourcePath = $source->getTempName();
            $originalSize = $source->getSize();
        } elseif (is_string($source) && file_exists($source)) {
            $sourcePath = $source;
            $originalSize = filesize($source);
        } else {
            return [
                'success' => false,
                'message' => 'Sumber gambar tidak ditemukan.',
            ];
        }

        // 3. Baca data biner gambar
        $rawContent = @file_get_contents($sourcePath);
        if ($rawContent === false || strlen($rawContent) === 0) {
            return [
                'success' => false,
                'message' => 'Gagal membaca isi berkas gambar sumber.',
            ];
        }

        // Buat resource GD image dari string
        $imageResource = @imagecreatefromstring($rawContent);
        if (!$imageResource) {
            return [
                'success' => false,
                'message' => 'Format gambar tidak didukung atau berkas rusak.',
            ];
        }

        $origWidth  = imagesx($imageResource);
        $origHeight = imagesy($imageResource);
        $targetWidth = $origWidth;
        $targetHeight = $origHeight;

        // 4. Hitung skala proporsional jika resolusi melebihi batas
        $needsResize = ($origWidth > $maxWidth || $origHeight > $maxHeight);
        if ($needsResize) {
            $ratio = min($maxWidth / $origWidth, $maxHeight / $origHeight);
            $targetWidth  = max(1, (int) round($origWidth * $ratio));
            $targetHeight = max(1, (int) round($origHeight * $ratio));

            $resizedResource = imagecreatetruecolor($targetWidth, $targetHeight);

            // Pertahankan transparansi alpha channel
            imagealphablending($resizedResource, false);
            imagesavealpha($resizedResource, true);

            imagecopyresampled(
                $resizedResource,
                $imageResource,
                0, 0, 0, 0,
                $targetWidth,
                $targetHeight,
                $origWidth,
                $origHeight
            );

            imagedestroy($imageResource);
            $imageResource = $resizedResource;
        }

        // Pastikan transparansi tetap aktif pada image akhir
        imagepalettetotruecolor($imageResource);
        imagealphablending($imageResource, true);
        imagesavealpha($imageResource, true);

        // 5. Siapkan direktori tujuan
        $destDir = rtrim(FCPATH, '/\\') . DIRECTORY_SEPARATOR . trim(str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $targetSubdir), '/\\');
        if (!is_dir($destDir)) {
            mkdir($destDir, 0755, true);
        }

        // 6. Buat nama file unik .webp
        $filename = time() . '_' . bin2hex(random_bytes(8)) . '.webp';
        $destPath = $destDir . DIRECTORY_SEPARATOR . $filename;

        // 7. Simpan file sebagai WebP
        $saved = @imagewebp($imageResource, $destPath, $quality);
        imagedestroy($imageResource);

        if (!$saved || !file_exists($destPath)) {
            return [
                'success' => false,
                'message' => 'Gagal mengompresi dan menyimpan file WebP ke disk server.',
            ];
        }

        $newSize = filesize($destPath);
        $savingsBytes = max(0, $originalSize - $newSize);
        $savingsPct = $originalSize > 0 ? round(($savingsBytes / $originalSize) * 100, 1) : 0;

        $relativePath = trim($targetSubdir, '/\\') . '/' . $filename;

        return [
            'success'        => true,
            'message'        => 'Gambar berhasil dikonversi ke WebP.',
            'filename'       => $filename,
            'relative_path'  => $relativePath,
            'absolute_path'  => $destPath,
            'original_size'  => $originalSize,
            'new_size'       => $newSize,
            'savings_bytes'  => $savingsBytes,
            'savings_pct'    => $savingsPct,
            'width'          => $targetWidth,
            'height'         => $targetHeight,
        ];
    }

    /**
     * Hapus file gambar dari disk server secara aman.
     *
     * @param string|null $relativePath Path relatif terhadap FCPATH (misal: 'uploads/landing/galeri/abc.webp')
     * @return bool
     */
    public static function deleteFile(?string $relativePath): bool
    {
        if (empty($relativePath)) {
            return false;
        }

        // Cegah directory traversal
        if (str_contains($relativePath, '..')) {
            return false;
        }

        $cleanPath = trim($relativePath, '/\\');

        // Pastikan hanya menghapus file di dalam folder uploads/
        if (!str_starts_with($cleanPath, 'uploads/')) {
            return false;
        }

        $fullPath = rtrim(FCPATH, '/\\') . DIRECTORY_SEPARATOR . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $cleanPath);

        if (file_exists($fullPath) && is_file($fullPath)) {
            return @unlink($fullPath);
        }

        return false;
    }

    /**
     * Format ukuran bytes ke teks yang mudah dibaca (KB / MB).
     *
     * @param int $bytes
     * @return string
     */
    public static function formatSize(int $bytes): string
    {
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 1) . ' MB';
        }
        if ($bytes >= 1024) {
            return number_format($bytes / 1024, 0) . ' KB';
        }
        return $bytes . ' B';
    }
}
