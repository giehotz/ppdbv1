<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PengumumanModel;

class Pengumuman extends BaseController
{
    protected $pengumumanModel;

    public function __construct()
    {
        $this->pengumumanModel = new PengumumanModel();
    }

    public function index()
    {
        $search = $this->request->getGet('search');

        $totalAll      = $this->pengumumanModel->countAll();
        $totalGeneral  = $this->pengumumanModel->where('tipe', 'general')->countAllResults();
        $totalUjian    = $this->pengumumanModel->where('tipe', 'ujian')->countAllResults();
        $totalKelulusan = $this->pengumumanModel->where('tipe', 'kelulusan')->countAllResults();

        $data = [
            'pengumuman'     => $this->pengumumanModel->getAnnouncements($search),
            'pager'          => $this->pengumumanModel->pager,
            'search'         => $search,
            'totalAll'       => $totalAll,
            'totalGeneral'   => $totalGeneral,
            'totalUjian'     => $totalUjian,
            'totalKelulusan' => $totalKelulusan,
        ];

        return view('admin/pengumuman/index', $data);
    }

    public function create()
    {
        return view('admin/pengumuman/form');
    }

    public function store()
    {
        $rawContent = $this->request->getPost('isi_pengumuman');
        // Server-side HTML sanitization for CKEditor content
        $cleanContent = $this->sanitizeHtml($rawContent);

        $data = [
            'judul' => $this->request->getPost('judul'),
            'isi_pengumuman' => $cleanContent,
            'tipe' => $this->request->getPost('tipe'),
            'target_audience' => $this->request->getPost('target_audience'),
            'publish_date' => $this->request->getPost('publish_date'),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
            'is_popup' => $this->request->getPost('is_popup') ? 1 : 0,
            'popup_countdown' => $this->request->getPost('popup_countdown') ?: 0,
        ];

        // Handle file upload
        $lampiran = $this->request->getFile('lampiran');
        if ($lampiran && $lampiran->isValid() && !$lampiran->hasMoved()) {
            $newName = $lampiran->getRandomName();
            $lampiran->move(FCPATH . 'uploads/pengumuman', $newName);
            $data['lampiran'] = $newName;
        }

        if ($this->pengumumanModel->insert($data)) {
            session()->setFlashdata('success', 'Pengumuman berhasil ditambahkan.');
        } else {
            session()->setFlashdata('error', 'Gagal menambahkan pengumuman.');
        }

        return redirect()->to('/admin/pengumuman');
    }

    public function edit($id)
    {
        $data = [
            'pengumuman' => $this->pengumumanModel->find($id)
        ];

        if (!$data['pengumuman']) {
            session()->setFlashdata('error', 'Pengumuman tidak ditemukan.');
            return redirect()->to('/admin/pengumuman');
        }

        return view('admin/pengumuman/form', $data);
    }

    public function update($id)
    {
        $rawContent = $this->request->getPost('isi_pengumuman');
        $cleanContent = $this->sanitizeHtml($rawContent);

        $data = [
            'judul' => $this->request->getPost('judul'),
            'isi_pengumuman' => $cleanContent,
            'tipe' => $this->request->getPost('tipe'),
            'target_audience' => $this->request->getPost('target_audience'),
            'publish_date' => $this->request->getPost('publish_date'),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
            'is_popup' => $this->request->getPost('is_popup') ? 1 : 0,
            'popup_countdown' => $this->request->getPost('popup_countdown') ?: 0,
        ];

        // Handle file upload
        $lampiran = $this->request->getFile('lampiran');
        if ($lampiran && $lampiran->isValid() && !$lampiran->hasMoved()) {
            // Delete old file if exists
            $oldData = $this->pengumumanModel->find($id);
            if ($oldData && $oldData['lampiran']) {
                $oldPath = FCPATH . 'uploads/pengumuman/' . $oldData['lampiran'];
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            $newName = $lampiran->getRandomName();
            $lampiran->move(FCPATH . 'uploads/pengumuman', $newName);
            $data['lampiran'] = $newName;
        }

        if ($this->pengumumanModel->update($id, $data)) {
            session()->setFlashdata('success', 'Pengumuman berhasil diperbarui.');
        } else {
            session()->setFlashdata('error', 'Gagal memperbarui pengumuman.');
        }

        return redirect()->to('/admin/pengumuman');
    }

    public function delete($id)
    {
        $pengumuman = $this->pengumumanModel->find($id);

        if ($pengumuman) {
            // Delete file if exists
            if ($pengumuman['lampiran']) {
                $filePath = FCPATH . 'uploads/pengumuman/' . $pengumuman['lampiran'];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            if ($this->pengumumanModel->delete($id)) {
                session()->setFlashdata('success', 'Pengumuman berhasil dihapus.');
            } else {
                session()->setFlashdata('error', 'Gagal menghapus pengumuman.');
            }
        } else {
            session()->setFlashdata('error', 'Pengumuman tidak ditemukan.');
        }

        return redirect()->to('/admin/pengumuman');
    }

    public function toggleStatus($id)
    {
        $pengumuman = $this->pengumumanModel->find($id);

        if ($pengumuman) {
            $newStatus = $pengumuman['is_active'] ? 0 : 1;

            if ($this->pengumumanModel->update($id, ['is_active' => $newStatus])) {
                session()->setFlashdata('success', 'Status pengumuman berhasil diubah.');
            } else {
                session()->setFlashdata('error', 'Gagal mengubah status pengumuman.');
            }
        }

        return redirect()->to('/admin/pengumuman');
    }

    private function sanitizeHtml($html)
    {
        if ($html === null || $html === '') {
            return '';
        }

        // Strip dangerous tags but preserve safe formatting
        static $allowedTags = '<p><br><b><strong><i><em><u><s><sub><sup><ol><ul><li><blockquote><pre><code><h1><h2><h3><h4><h5><h6><hr><table><thead><tbody><tr><th><td><div><span><a><img><figure><figcaption>';

        // Decode entities first to avoid double-encoding issues
        $html = html_entity_decode($html, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        // Strip event handlers (onclick, onload, etc.)
        $html = preg_replace('/\bon\w+\s*=\s*(?:"[^"]*"|\'[^\']*\'|[^\s>]+)/i', '', $html);

        // Strip javascript: and data: URIs in href/src
        $html = preg_replace('/\s+(href|src|action|formaction)\s*=\s*"(?:javascript|data|vbscript):[^"]*"/i', ' $1="#"', $html);
        $html = preg_replace('/\s+(href|src|action|formaction)\s*=\s*\'(?:javascript|data|vbscript):[^\']*\'/i', " $1='#'", $html);

        // Strip <script> and <iframe> tags and their content
        $html = preg_replace('/<script[^>]*>.*?<\/script>/is', '', $html);
        $html = preg_replace('/<iframe[^>]*>.*?<\/iframe>/is', '', $html);
        $html = preg_replace('/<embed[^>]*>.*?<\/embed>/is', '', $html);
        $html = preg_replace('/<object[^>]*>.*?<\/object>/is', '', $html);

        // Strip <base>, <link>, <meta>, <style> tags
        $html = preg_replace('/<(?:base|link|meta|style)[^>]*>/i', '', $html);
        $html = preg_replace('/<style[^>]*>.*?<\/style>/is', '', $html);

        // Strip <form> tags (keep content)
        $html = preg_replace('/<\/?form[^>]*>/i', '', $html);

        // Strip <input>, <button>, <select>, <textarea>, <label> tags
        $html = preg_replace('/<\/?(?:input|button|select|textarea|label|option|optgroup|fieldset|legend)[^>]*>/i', '', $html);

        return strip_tags($html, $allowedTags);
    }
}
