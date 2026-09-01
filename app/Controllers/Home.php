<?php

namespace App\Controllers;

use App\Models\LandingContentModel;
use App\Models\FiturModel;
use App\Models\GaleriModel;
use App\Models\TestimoniModel;
use App\Models\FaqModel;

class Home extends BaseController
{
    public function index()
    {
        $cache     = \Config\Services::cache();
        $cacheKey  = 'home_landing_data';
        $data      = $cache->get($cacheKey);

        if ($data === null) {
            $contentModel   = new LandingContentModel();
            $fiturModel     = new FiturModel();
            $galeriModel    = new GaleriModel();
            $testimoniModel = new TestimoniModel();
            $faqModel       = new FaqModel();

            $content   = $contentModel->getContentArray();
            $fitur     = $fiturModel->where('is_active', 1)->orderBy('urutan', 'ASC')->findAll();
            $galeri    = $galeriModel->where('is_active', 1)->orderBy('urutan', 'ASC')->findAll();
            $testimoni = $testimoniModel->where('is_active', 1)->orderBy('created_at', 'DESC')->findAll();
            $faqs      = $faqModel->orderBy('created_at', 'ASC')->findAll();

            // web settings — gunakan cache yang sama dengan BaseController
            $web = $cache->get('web_settings');
            if ($web === null) {
                $tblWebModel = new \App\Models\TblWebModel();
                $web         = $tblWebModel->first() ?? [];
                $cache->save('web_settings', $web, 300);
            }

            $pengumumanModel = new \App\Models\PengumumanModel();
            $popups = $pengumumanModel
                ->where('is_active', 1)
                ->where('is_popup', 1)
                ->groupStart()
                    ->where('publish_date <=', date('Y-m-d H:i:s'))
                    ->orWhere('publish_date', null)
                ->groupEnd()
                ->orderBy('publish_date', 'DESC')
                ->findAll();

            $data = compact('content', 'fitur', 'galeri', 'testimoni', 'web', 'popups', 'faqs');
            $cache->save($cacheKey, $data, 300); // cache 5 menit
        }

        // Tentukan variant landing page
        $preview = $this->request->getGet('template');
        if (!empty($preview) && in_array($preview, ['index', 'index2', 'index3'], true)) {
            $variant = $preview;
        } else {
            $variant = $data['web']['landing_variant'] ?? 'index';
        }

        $viewPath = 'landing/' . $variant;
        if (!is_file(APPPATH . 'Views/landing/' . $variant . '.php')) {
            $viewPath = 'landing/index';
        }

        return view($viewPath, $data);
    }
}
