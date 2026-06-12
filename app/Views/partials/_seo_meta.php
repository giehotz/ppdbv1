<?php
/**
 * Partial SEO Meta Tags
 * 
 * Reusable partial yang meng-output tag <meta> SEO dan Open Graph.
 * Gunakan variabel $page_title di view untuk judul halaman khusus.
 * Data SEO global diambil dari $seo_global (di-inject via BaseController).
 *
 * Cara pakai di view/layout:
 *   <?= view('partials/_seo_meta') ?>
 */

$seo = $seo_global ?? [];

// Title: Page Title + Suffix, atau fallback ke site_name
$titleSuffix = $seo['meta_title_suffix'] ?? '';
$siteName    = $seo['site_name'] ?? ($app_alias ?? 'PPDB');
$fullTitle   = isset($page_title) ? esc($page_title) . esc($titleSuffix) : esc($siteName);

$metaDesc    = $seo['meta_description'] ?? '';
$metaKeys    = $seo['meta_keywords'] ?? '';

// OG Image Fallback: og_image -> web_logo -> empty
if (!empty($seo['og_image'])) {
    $ogImageSource = base_url('uploads/seo/' . $seo['og_image']);
} elseif (!empty($web_logo)) {
    $ogImageSource = base_url('uploads/logo/' . $web_logo);
} else {
    $ogImageSource = '';
}

$ogImage     = $ogImageSource;
$gaId        = $seo['google_analytics'] ?? '';
$siteUrl     = current_url();
?>

<!-- SEO Meta Tags -->
<meta name="description" content="<?= esc($metaDesc) ?>">
<meta name="keywords" content="<?= esc($metaKeys) ?>">
<meta name="robots" content="index, follow">
<link rel="canonical" href="<?= $siteUrl ?>">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="<?= $siteUrl ?>">
<meta property="og:title" content="<?= $fullTitle ?>">
<meta property="og:description" content="<?= esc($metaDesc) ?>">
<meta property="og:site_name" content="<?= esc($siteName) ?>">
<?php if (!empty($ogImage)): ?>
<meta property="og:image" content="<?= $ogImage ?>">
<meta property="og:image:secure_url" content="<?= $ogImage ?>">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<?php endif; ?>

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="<?= $siteUrl ?>">
<meta name="twitter:title" content="<?= $fullTitle ?>">
<meta name="twitter:description" content="<?= esc($metaDesc) ?>">
<?php if (!empty($ogImage)): ?>
<meta name="twitter:image" content="<?= $ogImage ?>">
<?php endif; ?>

<?php if (!empty($gaId)): ?>
<!-- Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=<?= esc($gaId) ?>"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', '<?= esc($gaId) ?>');
</script>
<?php endif; ?>
