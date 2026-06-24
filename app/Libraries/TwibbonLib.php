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

        $photoW = imagesx($photoImg);
        $photoH = imagesy($photoImg);

        // Calculate intersection between crop box and photo in photo's coordinate space
        $interX1 = max($cropX, 0);
        $interY1 = max($cropY, 0);
        $interX2 = min($cropX + $cropW, $photoW);
        $interY2 = min($cropY + $cropH, $photoH);

        $interW = $interX2 - $interX1;
        $interH = $interY2 - $interY1;

        if ($interW > 0 && $interH > 0 && $cropW > 0 && $cropH > 0) {
            // Scale factors
            $scaleX = $frameWidth / $cropW;
            $scaleY = $frameHeight / $cropH;

            // Offsets of the intersection inside the crop box
            $offsetX = $interX1 - $cropX;
            $offsetY = $interY1 - $cropY;

            // Destination dimensions and coordinates on the canvas
            $destX = intval($offsetX * $scaleX);
            $destY = intval($offsetY * $scaleY);
            $destW = intval($interW * $scaleX);
            $destH = intval($interH * $scaleY);

            // Copy and resample only the visible part of the photo onto canvas
            imagecopyresampled(
                $canvas,        // destination
                $photoImg,      // source
                $destX, $destY, // destination X, Y
                $interX1, $interY1, // source X, Y
                $destW, $destH, // destination width, height
                $interW, $interH // source width, height
            );
        }

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
