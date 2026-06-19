<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SeoModel;

class SeoSettings extends BaseController
{
    protected $seoModel;

    public function __construct()
    {
        $this->seoModel = new SeoModel();
    }

    public function index()
    {
        $seo = $this->seoModel->find(1);

        if (!$seo) {
            // Insert default row if not exists
            $this->seoModel->insert([
                'id'                => 1,
                'site_name'         => 'PPDB MIN 2 Tanggamus',
                'meta_title_suffix' => ' | PPDB MIN 2 Tanggamus',
                'meta_description'  => 'Portal Penerimaan Peserta Didik Baru (PPDB) Online MIN 2 Tanggamus.',
                'meta_keywords'     => 'PPDB, MIN 2 Tanggamus, pendaftaran siswa baru',
                'updated_at'        => date('Y-m-d H:i:s'),
            ]);
            $seo = $this->seoModel->find(1);
        }

        return view('admin/seo/index', ['seo' => $seo]);
    }

    public function update()
    {
        $data = [
            'site_name'         => $this->request->getPost('site_name'),
            'meta_title_suffix' => $this->request->getPost('meta_title_suffix'),
            'meta_description'  => $this->request->getPost('meta_description'),
            'meta_keywords'     => $this->request->getPost('meta_keywords'),
            'google_analytics'  => $this->request->getPost('google_analytics'),
            'updated_at'        => date('Y-m-d H:i:s'),
        ];

        // Handle OG Image Upload
        $fileOg = $this->request->getFile('og_image');
        if ($fileOg && $fileOg->isValid() && !$fileOg->hasMoved()) {

            $validationRule = [
                'og_image' => [
                    'label' => 'Gambar Open Graph',
                    'rules' => 'uploaded[og_image]'
                        . '|is_image[og_image]'
                        . '|mime_in[og_image,image/jpg,image/jpeg,image/png,image/webp]'
                        . '|ext_in[og_image,jpg,jpeg,png,webp]'
                        . '|max_size[og_image,2048]',
                ],
            ];

            if (!$this->validate($validationRule)) {
                $errorMsg = $this->validator->getError('og_image');
                session()->setFlashdata('error', 'Gagal mengunggah gambar: ' . $errorMsg);
                return redirect()->back()->withInput();
            }

            // Create upload directory if not exists
            $uploadPath = realpath(FCPATH . 'uploads/seo') ?: FCPATH . 'uploads/seo';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
                $uploadPath = realpath($uploadPath);
            }

            // Delete old image if exists
            $oldSeo = $this->seoModel->find(1);
            if (!empty($oldSeo['og_image'])) {
                $oldPath = realpath($uploadPath . '/' . basename($oldSeo['og_image']));
                if ($oldPath && strpos($oldPath, $uploadPath) === 0 && file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            $newName = $fileOg->getRandomName();
            $fileOg->move($uploadPath, $newName);
            $data['og_image'] = $newName;
        }

        if ($this->seoModel->update(1, $data)) {
            session()->setFlashdata('success', 'Pengaturan SEO berhasil disimpan!');
        } else {
            session()->setFlashdata('error', 'Gagal menyimpan pengaturan SEO.');
        }

        return redirect()->to('/admin/seo');
    }
}
