<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LandingContentModel;
use App\Models\FiturModel;
use App\Models\GaleriModel;
use App\Models\TestimoniModel;
use App\Models\FaqModel;
use App\Libraries\ImageOptimizer;

class LandingContent extends BaseController
{
    protected $contentModel;
    protected $fiturModel;
    protected $galeriModel;
    protected $testimoniModel;
    protected $faqModel;

    public function __construct()
    {
        $this->contentModel = new LandingContentModel();
        $this->fiturModel = new FiturModel();
        $this->galeriModel = new GaleriModel();
        $this->testimoniModel = new TestimoniModel();
        $this->faqModel = new FaqModel();
    }

    public function index()
    {
        // Get all content grouped by section
        $allContent = $this->contentModel->findAll();

        // Group by section
        $sections = [];
        foreach ($allContent as $content) {
            if (!isset($sections[$content['section']])) {
                $sections[$content['section']] = [];
            }
            $sections[$content['section']][$content['content_key']] = $content;
        }

        // Get dynamic content
        $fitur = $this->fiturModel->orderBy('urutan', 'ASC')->findAll();
        $galeri = $this->galeriModel->orderBy('urutan', 'ASC')->findAll();
        $testimoni = $this->testimoniModel->orderBy('created_at', 'DESC')->findAll();
        $faqs = $this->faqModel->orderBy('created_at', 'DESC')->findAll();

        // Hitung statistik file galeri
        $totalGaleriBytes = 0;
        $nonWebpCount = 0;
        foreach ($galeri as &$g) {
            $path = FCPATH . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $g['gambar'] ?? '');
            if (!empty($g['gambar']) && file_exists($path) && is_file($path)) {
                $bytes = filesize($path);
                $g['file_size'] = $bytes;
                $g['file_size_formatted'] = ImageOptimizer::formatSize($bytes);
                $g['is_webp'] = strtolower(pathinfo($path, PATHINFO_EXTENSION)) === 'webp';
                $totalGaleriBytes += $bytes;
                if (!$g['is_webp']) {
                    $nonWebpCount++;
                }
            } else {
                $g['file_size'] = 0;
                $g['file_size_formatted'] = '0 B';
                $g['is_webp'] = false;
            }
        }
        unset($g);

        $data = [
            'sections' => $sections,
            'fitur' => $fitur,
            'galeri' => $galeri,
            'testimoni' => $testimoni,
            'faqs' => $faqs,
            'totalGaleriSize' => ImageOptimizer::formatSize($totalGaleriBytes),
            'nonWebpCount' => $nonWebpCount,
        ];

        return view('admin/landing-content/index', $data);
    }

    public function update()
    {
        $section = $this->request->getPost('section');
        $updates = $this->request->getPost('content');

        if (!$section || !$updates) {
            session()->setFlashdata('error', 'Data tidak valid.');
            return redirect()->to('/admin/landing-content');
        }

        foreach ($updates as $key => $value) {
            // Sanitize HTML fields to allow safe HTML while preventing XSS
            $allowedHtmlFields = ['headline', 'subheadline', 'announcement', 'title'];
            if (in_array($key, $allowedHtmlFields, true)) {
                $value = $this->sanitizeHtml($value);
            }

            $data = [
                'content_value' => $value
            ];

            $this->contentModel->upsertContent($section, $key, $data);
        }

        $this->clearLandingCache();
        session()->setFlashdata('success', 'Konten berhasil diperbarui.');
        return redirect()->to('/admin/landing-content');
    }

    public function uploadMedia()
    {
        $section = $this->request->getPost('section');
        $contentKey = $this->request->getPost('content_key');
        $file = $this->request->getFile('media');

        if (!$file || !$file->isValid()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'File tidak valid.'
            ]);
        }

        $allowedMimes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif', 'image/svg+xml'];
        $allowedExts  = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg'];
        $maxSize      = 2097152; // 2MB

        $mime = $file->getMimeType();
        $ext  = strtolower($file->getExtension());

        if (!in_array($mime, $allowedMimes, true) || !in_array($ext, $allowedExts, true) || $file->getSize() > $maxSize) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Format file tidak diizinkan. Hanya gambar (JPG, PNG, WebP, GIF, SVG) maksimal 2MB.'
            ]);
        }

        // Upload file
        $newName = $file->getRandomName();
        $file->move(FCPATH . 'uploads/landing', $newName);

        // Update database
        $data = [
            'media_path' => 'uploads/landing/' . $newName
        ];

        $this->contentModel->upsertContent($section, $contentKey, $data);
        $this->clearLandingCache();

        return $this->response->setJSON([
            'success' => true,
            'path' => base_url('uploads/landing/' . $newName),
            'relative_path' => 'uploads/landing/' . $newName,
            'token' => csrf_hash() // Return new CSRF token
        ]);
    }
    // =========================================================================
    // FITUR / KEUNGGULAN
    // =========================================================================

    public function saveFitur()
    {
        $id = $this->request->getPost('fitur_id');
        $data = [
            'ikon' => $this->request->getPost('ikon'),
            'judul' => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'urutan' => $this->request->getPost('urutan'),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0
        ];

        if ($id) {
            $this->fiturModel->update($id, $data);
        } else {
            $this->fiturModel->insert($data);
        }

        $this->clearLandingCache();
        session()->setFlashdata('success', 'Data Fitur berhasil disimpan.');
        return redirect()->to('/admin/landing-content');
    }

    public function deleteFitur($id)
    {
        $this->fiturModel->delete($id);
        $this->clearLandingCache();
        session()->setFlashdata('success', 'Data Fitur berhasil dihapus.');
        return redirect()->to('/admin/landing-content');
    }

    // =========================================================================
    // GALERI
    // =========================================================================

    public function saveGaleri()
    {
        $id = $this->request->getPost('galeri_id');
        $file = $this->request->getFile('gambar');

        $data = [
            'judul'     => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'urutan'    => $this->request->getPost('urutan'),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0
        ];

        // Handle File Upload & WebP Conversion
        if ($file && $file->isValid()) {
            $allowedMimes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif', 'image/bmp'];
            if (!in_array($file->getMimeType(), $allowedMimes, true)) {
                session()->setFlashdata('error', 'Format file tidak diizinkan. Hanya gambar (JPG, PNG, WebP, GIF) maksimal 10MB.');
                return redirect()->to('/admin/landing-content#galeri')->withInput();
            }

            // Convert to WebP & downscale proportionally (maks 1600px)
            $result = ImageOptimizer::convertToWebp($file, 'uploads/landing/galeri', 1600, 1600, 82);

            if ($result['success']) {
                // Jika sedang mengedit foto, hapus file gambar lama dari disk
                if ($id) {
                    $existing = $this->galeriModel->find($id);
                    if ($existing && !empty($existing['gambar'])) {
                        ImageOptimizer::deleteFile($existing['gambar']);
                    }
                }

                $data['gambar'] = $result['relative_path'];
            } else {
                session()->setFlashdata('error', 'Gagal memproses gambar: ' . ($result['message'] ?? 'Terjadi kesalahan.'));
                return redirect()->to('/admin/landing-content#galeri')->withInput();
            }
        }

        if ($id) {
            $this->galeriModel->update($id, $data);
            $msg = 'Data Galeri berhasil diperbarui.';
        } else {
            if (!isset($data['gambar'])) {
                session()->setFlashdata('error', 'Gambar wajib diupload untuk data baru.');
                return redirect()->to('/admin/landing-content#galeri')->withInput();
            }
            $this->galeriModel->insert($data);
            $msg = 'Foto galeri baru berhasil disimpan dan dikonversi ke format WebP super ringan.';
        }

        $this->clearLandingCache();
        session()->setFlashdata('success', $msg);
        return redirect()->to('/admin/landing-content#galeri');
    }

    public function deleteGaleri($id)
    {
        $item = $this->galeriModel->find($id);
        if ($item && !empty($item['gambar'])) {
            ImageOptimizer::deleteFile($item['gambar']);
        }

        $this->galeriModel->delete($id);
        $this->clearLandingCache();
        session()->setFlashdata('success', 'Data Galeri dan file gambar berhasil dihapus dari server.');
        return redirect()->to('/admin/landing-content#galeri');
    }

    /**
     * Konversi semua foto galeri yang ada ke format WebP (Batch Optimization)
     */
    public function convertAllGaleriToWebp()
    {
        $items = $this->galeriModel->findAll();
        if (empty($items)) {
            session()->setFlashdata('warning', 'Belum ada data galeri untuk dikonversi.');
            return redirect()->to('/admin/landing-content#galeri');
        }

        $convertedCount = 0;
        $totalOldBytes = 0;
        $totalNewBytes = 0;

        foreach ($items as $item) {
            $currentPath = $item['gambar'] ?? '';
            if (empty($currentPath)) continue;

            $fullPath = FCPATH . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $currentPath);
            if (!file_exists($fullPath) || !is_file($fullPath)) continue;

            $ext = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));
            $oldSize = filesize($fullPath);

            // Konversi jika bukan webp atau jika ukurannya masih terlalu besar (> 400KB)
            if ($ext !== 'webp' || $oldSize > 409600) {
                $result = ImageOptimizer::convertToWebp($fullPath, 'uploads/landing/galeri', 1600, 1600, 82);

                if ($result['success']) {
                    // Update database path
                    $this->galeriModel->update($item['galeri_id'], [
                        'gambar' => $result['relative_path']
                    ]);

                    // Hapus file lama jika nama file berbeda
                    if ($result['relative_path'] !== $currentPath) {
                        ImageOptimizer::deleteFile($currentPath);
                    }

                    $convertedCount++;
                    $totalOldBytes += $oldSize;
                    $totalNewBytes += $result['new_size'];
                }
            }
        }

        $this->clearLandingCache();

        if ($convertedCount > 0) {
            $savedBytes = max(0, $totalOldBytes - $totalNewBytes);
            $savedFormatted = ImageOptimizer::formatSize($savedBytes);
            $savedPct = $totalOldBytes > 0 ? round(($savedBytes / $totalOldBytes) * 100, 1) : 0;

            session()->setFlashdata('success', "Sukses! Berhasil mengonversi {$convertedCount} foto galeri ke WebP. Menghemat {$savedFormatted} ({$savedPct}% lebih ringan).");
        } else {
            session()->setFlashdata('info', 'Semua foto galeri sudah dalam format WebP yang optimal.');
        }

        return redirect()->to('/admin/landing-content#galeri');
    }

    // =========================================================================
    // TESTIMONI
    // =========================================================================

    public function saveTestimoni()
    {
        $id = $this->request->getPost('testimoni_id');
        $file = $this->request->getFile('avatar');

        $data = [
            'nama' => $this->request->getPost('nama'),
            'peran' => $this->request->getPost('peran'),
            'isi' => $this->request->getPost('isi'),
            'rating' => $this->request->getPost('rating'),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0
        ];

        // Handle File Upload
        if ($file && $file->isValid()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/landing/testimoni', $newName);
            $data['avatar'] = 'uploads/landing/testimoni/' . $newName;
        }

        if ($id) {
            $this->testimoniModel->update($id, $data);
        } else {
            $this->testimoniModel->insert($data);
        }

        $this->clearLandingCache();
        session()->setFlashdata('success', 'Data Testimoni berhasil disimpan.');
        return redirect()->to('/admin/landing-content');
    }

    public function deleteTestimoni($id)
    {
        $this->testimoniModel->delete($id);
        $this->clearLandingCache();
        session()->setFlashdata('success', 'Data Testimoni berhasil dihapus.');
        return redirect()->to('/admin/landing-content');
    }

    // =========================================================================
    // FAQ
    // =========================================================================

    public function saveFaq()
    {
        $id = $this->request->getPost('faq_id');
        $data = [
            'pertanyaan' => $this->request->getPost('pertanyaan'),
            'jawaban'    => $this->request->getPost('jawaban'),
        ];

        if ($id) {
            $this->faqModel->update($id, $data);
        } else {
            $this->faqModel->insert($data);
        }

        $this->clearLandingCache();
        session()->setFlashdata('success', 'Data FAQ berhasil disimpan.');
        return redirect()->to('/admin/landing-content');
    }

    public function deleteFaq($id)
    {
        $this->faqModel->delete($id);
        $this->clearLandingCache();
        session()->setFlashdata('success', 'Data FAQ berhasil dihapus.');
        return redirect()->to('/admin/landing-content');
    }

    public function updateFavicon()
    {
        $file = $this->request->getFile('favicon');

        if (!$file || !$file->isValid()) {
            session()->setFlashdata('error', 'File tidak valid.');
            return redirect()->to('/admin/landing-content#favicon');
        }

        // Validate extension
        $ext = $file->getExtension();
        if (!in_array($ext, ['ico', 'png', 'jpg', 'jpeg'])) {
            session()->setFlashdata('error', 'Format file tidak didukung. Gunakan .ico, .png, atau .jpg');
            return redirect()->to('/admin/landing-content#favicon');
        }

        // Replace public/favicon.ico
        // We always use the name favicon.ico regardless of original extension
        // Modern browsers handle PNG/JPG as favicon even if the extension is .ico
        try {
            if (file_exists(FCPATH . 'favicon.ico')) {
                unlink(FCPATH . 'favicon.ico');
            }
            $file->move(FCPATH, 'favicon.ico');
            $this->clearLandingCache();
            session()->setFlashdata('success', 'Favicon berhasil diperbarui. (Mungkin butuh CTRL+F5/Hard Refresh untuk melihat perubahan di browser)');
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Gagal mengganti file: ' . $e->getMessage());
        }

        return redirect()->to('/admin/landing-content');
    }

    private function sanitizeHtml($html)
    {
        if ($html === null || $html === '') {
            return '';
        }

        static $allowedTags = '<p><br><b><strong><i><em><u><s><sub><sup><ol><ul><li><blockquote><pre><code><h1><h2><h3><h4><h5><h6><hr><table><thead><tbody><tr><th><td><div><span><a><img><figure><figcaption>';

        $html = html_entity_decode($html, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $html = preg_replace('/\bon\w+\s*=\s*(?:"[^"]*"|\'[^\']*\'|[^\s>]+)/i', '', $html);
        $html = preg_replace('/\s+(href|src|action|formaction)\s*=\s*"(?:javascript|data|vbscript):[^"]*"/i', ' $1="#"', $html);
        $html = preg_replace('/\s+(href|src|action|formaction)\s*=\s*\'(?:javascript|data|vbscript):[^\']*\'/i', " $1='#'", $html);
        $html = preg_replace('/<script[^>]*>.*?<\/script>/is', '', $html);
        $html = preg_replace('/<iframe[^>]*>.*?<\/iframe>/is', '', $html);
        $html = preg_replace('/<embed[^>]*>.*?<\/embed>/is', '', $html);
        $html = preg_replace('/<object[^>]*>.*?<\/object>/is', '', $html);
        $html = preg_replace('/<(?:base|link|meta|style)[^>]*>/i', '', $html);
        $html = preg_replace('/<style[^>]*>.*?<\/style>/is', '', $html);
        $html = preg_replace('/<\/?form[^>]*>/i', '', $html);
        $html = preg_replace('/<\/?(?:input|button|select|textarea|label|option|optgroup|fieldset|legend)[^>]*>/i', '', $html);

        return strip_tags($html, $allowedTags);
    }

    private function clearLandingCache(): void
    {
        $cache = \Config\Services::cache();
        $cache->delete('home_landing_data');
        $cache->delete('app_settings');
        $cache->delete('web_settings');
    }
}
