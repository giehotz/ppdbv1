<?php

/**
 * PHP Built-in Server Router
 * 
 * This file is used by `php spark serve` to serve static files
 * (images, PDFs, CSS, JS, etc.) from the public directory.
 * Without this, the built-in PHP server cannot serve static assets
 * and returns 404 for files like uploaded berkas.
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? ''
);

// If the requested file exists as a real file, serve it directly
$path = __DIR__ . $uri;

if ($uri !== '/' && is_file($path)) {
    // Set proper MIME types for common file extensions
    $mimeTypes = [
        'css'  => 'text/css',
        'js'   => 'application/javascript',
        'json' => 'application/json',
        'png'  => 'image/png',
        'jpg'  => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'gif'  => 'image/gif',
        'svg'  => 'image/svg+xml',
        'ico'  => 'image/x-icon',
        'webp' => 'image/webp',
        'pdf'  => 'application/pdf',
        'woff' => 'font/woff',
        'woff2'=> 'font/woff2',
        'ttf'  => 'font/ttf',
        'eot'  => 'application/vnd.ms-fontobject',
        'mp4'  => 'video/mp4',
        'webm' => 'video/webm',
        'xml'  => 'application/xml',
        'txt'  => 'text/plain',
        'zip'  => 'application/zip',
    ];

    $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));

    if (isset($mimeTypes[$ext])) {
        header('Content-Type: ' . $mimeTypes[$ext]);
    }

    // Return false to let PHP built-in server handle the file directly
    return false;
}

// Otherwise, route to CodeIgniter's front controller
require_once __DIR__ . '/index.php';
