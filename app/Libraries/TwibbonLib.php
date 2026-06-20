<?php

namespace App\Libraries;

class TwibbonLib
{
    /**
     * Generate Twibbon by combining cropped photo and frame
     * 
     * @param string $framePath Path to the transparent frame PNG
     * @param string $photoPath Path to the user's uploaded photo
     * @param array $cropData Array containing crop coordinates: [x, y, width, height, rotate]
     * @param string $outputPath Path where the merged image should be saved
     * @return bool
     */
    public function generate(string $framePath, string $photoPath, array $cropData, string $outputPath): bool
    {
        // 1. Check if files exist
        if (!file_exists($framePath) || !file_exists($photoPath)) {
            log_message('error', 'TwibbonLib: Frame or Photo file not found.');
            return false;
        }

        // 2. Load the original photo
        $photoInfo = getimagesize($photoPath);
        if (!$photoInfo) {
            log_message('error', 'TwibbonLib: Invalid photo format.');
            return false;
        }

        $photoMime = $photoInfo['mime'];
        switch ($photoMime) {
            case 'image/jpeg':
            case 'image/jpg':
                $photoImg = imagecreatefromjpeg($photoPath);
                break;
            case 'image/png':
                $photoImg = imagecreatefrompng($photoPath);
                break;
            case 'image/webp':
                if (function_exists('imagecreatefromwebp')) {
                    $photoImg = imagecreatefromwebp($photoPath);
                } else {
                    log_message('error', 'TwibbonLib: WebP not supported by GD.');
                    return false;
                }
                break;
            default:
                log_message('error', 'TwibbonLib: Unsupported photo type ' . $photoMime);
                return false;
        }

        if (!$photoImg) {
            log_message('error', 'TwibbonLib: Failed to load photo resource.');
            return false;
        }

        // 3. Load the frame (must be PNG for transparency support)
        $frameImg = imagecreatefrompng($framePath);
        if (!$frameImg) {
            log_message('error', 'TwibbonLib: Failed to load frame resource.');
            imagedestroy($photoImg);
            return false;
        }

        // Keep alpha transparency of the frame
        imagealphablending($frameImg, true);
        imagesavealpha($frameImg, true);

        // Get frame dimensions (e.g. 1080x1080)
        $frameWidth = imagesx($frameImg);
        $frameHeight = imagesy($frameImg);

        // 4. Create the background canvas (same size as frame)
        $canvas = imagecreatetruecolor($frameWidth, $frameHeight);
        
        // Fill canvas with white background
        $white = imagecolorallocate($canvas, 255, 255, 255);
        imagefill($canvas, 0, 0, $white);

        // 5. Handle rotation of the photo if needed
        $rotate = isset($cropData['rotate']) ? floatval($cropData['rotate']) : 0;
        if ($rotate != 0) {
            $transparentColor = imagecolorallocatealpha($photoImg, 255, 255, 255, 127);
            $photoImg = imagerotate($photoImg, -$rotate, $transparentColor);
            imagealphablending($photoImg, true);
            imagesavealpha($photoImg, true);
        }

        // 6. Crop and resize photo to fit the canvas
        $cropX = isset($cropData['x']) ? intval($cropData['x']) : 0;
        $cropY = isset($cropData['y']) ? intval($cropData['y']) : 0;
        $cropW = isset($cropData['width']) ? intval($cropData['width']) : imagesx($photoImg);
        $cropH = isset($cropData['height']) ? intval($cropData['height']) : imagesy($photoImg);

        // Ensure crop boundaries are within the image
        $photoW = imagesx($photoImg);
        $photoH = imagesy($photoImg);
        $cropX = max(0, min($cropX, $photoW - 1));
        $cropY = max(0, min($cropY, $photoH - 1));
        $cropW = max(1, min($cropW, $photoW - $cropX));
        $cropH = max(1, min($cropH, $photoH - $cropY));

        // Copy and resample photo onto canvas (photo goes to layer 0, background)
        imagecopyresampled(
            $canvas,      // destination
            $photoImg,    // source
            0, 0,         // destination X, Y
            $cropX, $cropY, // source X, Y
            $frameWidth, $frameHeight, // destination width, height
            $cropW, $cropH // source width, height
        );

        // 7. Overlay the frame PNG (goes to layer 1, foreground)
        imagecopy(
            $canvas,      // destination
            $frameImg,    // source
            0, 0,         // destination X, Y
            0, 0,         // source X, Y
            $frameWidth, $frameHeight // width, height
        );

        // 8. Ensure destination folder exists
        $dir = dirname($outputPath);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        // 9. Save final image as JPEG (90% quality)
        $success = imagejpeg($canvas, $outputPath, 90);

        // 10. Clean up memory resources
        imagedestroy($photoImg);
        imagedestroy($frameImg);
        imagedestroy($canvas);

        return $success;
    }
}
