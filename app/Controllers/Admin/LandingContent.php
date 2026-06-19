<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LandingContentModel;
use App\Models\FiturModel;
use App\Models\GaleriModel;
use App\Models\TestimoniModel;
use App\Models\FaqModel;

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

        $data = [
            'sections' => $sections,
            'fitur' => $fitur,
            'galeri' => $galeri,
            'testimoni' => $testimoni,
            'faqs' => $faqs
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
            $allowedHtmlFields = ['headline', 'subheadline', 'announcement'];
            if (in_array($key, $allowedHtmlFields, true)) {
                $value = $this->sanitizeHtml($value);
            }

            $data = [
                'content_value' => $value
            ];

            $this->contentModel->upsertContent($section, $key, $data);
        }

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

        // Upload file
        $newName = $file->getRandomName();
        $file->move(FCPATH . 'uploads/landing', $newName);

        // Update database
        $data = [
            'media_path' => 'uploads/landing/' . $newName
        ];

        $this->contentModel->upsertContent($section, $contentKey, $data);

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

        session()->setFlashdata('success', 'Data Fitur berhasil disimpan.');
        return redirect()->to('/admin/landing-content');
    }

    public function deleteFitur($id)
    {
        $this->fiturModel->delete($id);
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
            'judul' => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'urutan' => $this->request->getPost('urutan'),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0
        ];

        // Handle File Upload
        if ($file && $file->isValid()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/landing/galeri', $newName);
            $data['gambar'] = 'uploads/landing/galeri/' . $newName;
        }

        if ($id) {
            $this->galeriModel->update($id, $data);
        } else {
            if (!isset($data['gambar'])) {
                session()->setFlashdata('error', 'Gambar wajib diupload untuk data baru.');
                return redirect()->back()->withInput();
            }
            $this->galeriModel->insert($data);
        }

        session()->setFlashdata('success', 'Data Galeri berhasil disimpan.');
        return redirect()->to('/admin/landing-content');
    }

    public function deleteGaleri($id)
    {
        // Optional: Delete file from server
        // $item = $this->galeriModel->find($id);
        // if ($item && file_exists(FCPATH . $item['gambar'])) {
        //     unlink(FCPATH . $item['gambar']);
        // }

        $this->galeriModel->delete($id);
        session()->setFlashdata('success', 'Data Galeri berhasil dihapus.');
        return redirect()->to('/admin/landing-content');
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

        session()->setFlashdata('success', 'Data Testimoni berhasil disimpan.');
        return redirect()->to('/admin/landing-content');
    }

    public function deleteTestimoni($id)
    {
        $this->testimoniModel->delete($id);
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

        session()->setFlashdata('success', 'Data FAQ berhasil disimpan.');
        return redirect()->to('/admin/landing-content');
    }

    public function deleteFaq($id)
    {
        $this->faqModel->delete($id);
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
}
