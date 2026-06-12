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
        $contentModel = new LandingContentModel();
        $fiturModel = new FiturModel();
        $galeriModel = new GaleriModel();
        $testimoniModel = new TestimoniModel();
        $faqModel = new FaqModel();

        // Get all active content as array
        $content = $contentModel->getContentArray();

        // Get dynamic content
        $fitur = $fiturModel->where('is_active', 1)->orderBy('urutan', 'ASC')->findAll();
        $galeri = $galeriModel->where('is_active', 1)->orderBy('urutan', 'ASC')->findAll();
        $testimoni = $testimoniModel->where('is_active', 1)->orderBy('created_at', 'DESC')->findAll();
        $faqs = $faqModel->orderBy('created_at', 'ASC')->findAll();

        $tblWebModel = new \App\Models\TblWebModel();
        $web = $tblWebModel->find(1);

        $pengumumanModel = new \App\Models\PengumumanModel();
        
        // Build query for active popups
        $popups = $pengumumanModel->where('is_active', 1)
            ->where('is_popup', 1)
            ->groupStart()
                ->where('publish_date <=', date('Y-m-d H:i:s'))
                ->orWhere('publish_date', null)
            ->groupEnd()
            ->orderBy('publish_date', 'DESC')
            ->findAll();

        $data = [
            'content' => $content,
            'fitur' => $fitur,
            'galeri' => $galeri,
            'testimoni' => $testimoni,
            'web' => $web,
            'popups' => $popups,
            'faqs' => $faqs
        ];

        // Determine which landing page variant to use
        $variant = $web['landing_variant'] ?? 'index';
        $viewPath = 'landing/' . $variant;

        // Fallback to default if the variant view doesn't exist
        if (!is_file(APPPATH . 'Views/landing/' . $variant . '.php')) {
            $viewPath = 'landing/index';
        }

        return view($viewPath, $data);
    }
}
