<?php
/**
 * Partial: Auth Page <head> Content
 * 
 * Shared head section untuk semua halaman auth (login, register, dll).
 * 
 * Variables:
 *   $page_title  (string) - Judul halaman untuk <title> dan SEO
 *   $app_alias   (string) - Nama aplikasi (fallback: 'PPDB')
 */
$alias = $app_alias ?? 'PPDB';
?>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script>
    (function() {
        try {
            if (localStorage.getItem('darkMode') === 'true') {
                document.documentElement.classList.add('dark');
                document.documentElement.style.colorScheme = 'dark';
            } else {
                document.documentElement.classList.remove('dark');
                document.documentElement.style.colorScheme = 'light';
            }
        } catch (e) {}
    })();
</script>
<style>
    html.dark {
        color-scheme: dark;
        background-color: #111827;
    }
    html.dark body {
        background-color: #111827 !important;
        color: #f3f4f6;
    }
</style>
<title><?= esc($page_title ?? 'Auth') ?> - <?= esc($alias) ?> Online</title>

<?= view('partials/_seo_meta', ['page_title' => $page_title ?? '']) ?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="preconnect" href="https://cdnjs.cloudflare.com">
<link rel="preconnect" href="https://cdn.jsdelivr.net">

<link rel="preload" as="style" href="<?= base_url('assets/tailadmin/css/tailadmin.css') ?>">
<link rel="preload" as="style" href="<?= base_url('css/app.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/tailadmin/css/tailadmin.css') ?>">
<link rel="stylesheet" href="<?= base_url('css/app.css') ?>">

<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" media="print" onload="this.media='all'">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" media="print" onload="this.media='all'">

<noscript>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</noscript>
<style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; }
    .heading-font { font-family: 'Outfit', sans-serif; }
</style>
