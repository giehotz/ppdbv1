<?php

namespace App\Controllers;

use App\Models\TwibbonCampaignModel;
use App\Models\TwibbonFrameModel;
use App\Models\TwibbonStatisticModel;
use App\Models\TwibbonSettingModel;
use App\Models\TblWebModel;
use App\Libraries\TwibbonLib;

class Twibbon extends BaseController
{
    protected $campaignModel;
    protected $frameModel;
    protected $statisticModel;
    protected $tblWebModel;

    public function __construct()
    {
        $this->campaignModel = new TwibbonCampaignModel();
        $this->frameModel = new TwibbonFrameModel();
        $this->statisticModel = new TwibbonStatisticModel();
        $this->tblWebModel = new TblWebModel();
    }

    public function index()
    {
        $campaigns = $this->campaignModel->getActiveCampaigns();
        
        // Load frames for campaigns
        foreach ($campaigns as &$c) {
            $c['frame'] = $this->frameModel->where('campaign_id', $c['id'])->first();
        }

        $web = $this->tblWebModel->find(1);

        return view('twibbon/list', [
            'campaigns' => $campaigns,
            'web'       => $web
        ]);
    }

    public function detail($slug)
    {
        $campaign = $this->campaignModel->where('slug', $slug)->first();
        if (!$campaign) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Kampanye tidak ditemukan.");
        }

        // Check if campaign is active and currently within active dates
        $today = date('Y-m-d');
        $isActive = ($campaign['is_active'] == 1);
        if ($campaign['start_date'] && $campaign['start_date'] > $today) {
            $isActive = false;
        }
        if ($campaign['end_date'] && $campaign['end_date'] < $today) {
            $isActive = false;
        }

        if (!$isActive) {
            session()->setFlashdata('error', 'Kampanye Twibbon ini sedang tidak aktif.');
            return redirect()->to('/twibbon');
        }

        $frame = $this->frameModel->where('campaign_id', $campaign['id'])->first();
        if (!$frame) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Bingkai kampanye belum dikonfigurasi.");
        }

        $web = $this->tblWebModel->find(1);

        return view('twibbon/detail', [
            'campaign' => $campaign,
            'frame'    => $frame,
            'web'       => $web
        ]);
    }

    private function cleanupExpiredFiles(): void
    {
        $settings = (new TwibbonSettingModel())->getSettings();

        if (empty($settings['cleanup_enabled'])) return;

        $now = time();
        $dirs = [
            FCPATH . 'uploads/twibbon/results' => (int) $settings['results_ttl_hours'] * 3600,
            FCPATH . 'uploads/twibbon/temp'    => (int) $settings['temp_ttl_hours'] * 3600,
        ];
        foreach ($dirs as $path => $maxAge) {
            if (!is_dir($path)) continue;
            foreach (glob($path . '/*') as $file) {
                if (is_file($file) && basename($file) !== '.gitkeep' && ($now - filemtime($file) > $maxAge)) {
                    @unlink($file);
                }
            }
        }
    }

    public function process()
    {
        $rules = [
            'campaign_id' => 'required|is_not_unique[twibbon_campaigns.id]',
            'photo'       => 'uploaded[photo]|is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/png,image/webp]|ext_in[photo,jpg,jpeg,png,webp]|max_size[photo,5120]',
            'x'           => 'required|numeric',
            'y'           => 'required|numeric',
            'width'       => 'required|numeric',
            'height'      => 'required|numeric',
            'rotate'      => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => implode(' ', $this->validator->getErrors())
            ]);
        }

        $campaignId = $this->request->getPost('campaign_id');
        $frame = $this->frameModel->where('campaign_id', $campaignId)->first();
        if (!$frame) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Bingkai kampanye tidak ditemukan.'
            ]);
        }

        $photoFile = $this->request->getFile('photo');
        if (!$photoFile || !$photoFile->isValid()) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Gagal mengunggah foto.'
            ]);
        }

        // Temporary storage path
        $tempPath = FCPATH . 'uploads/twibbon/temp';
        if (!is_dir($tempPath)) {
            mkdir($tempPath, 0755, true);
        }

        // Save original uploaded photo temporarily
        $tempName = $photoFile->getRandomName();
        $photoFile->move($tempPath, $tempName);
        $fullPhotoPath = $tempPath . '/' . $tempName;

        // Output results path
        $resultsPath = FCPATH . 'uploads/twibbon/results';
        if (!is_dir($resultsPath)) {
            mkdir($resultsPath, 0755, true);
        }

        $outputName = 'twibbon_' . time() . '_' . rand(1000, 9999) . '.jpg';
        $fullOutputPath = $resultsPath . '/' . $outputName;

        $cropData = [
            'x'      => $this->request->getPost('x'),
            'y'      => $this->request->getPost('y'),
            'width'  => $this->request->getPost('width'),
            'height' => $this->request->getPost('height'),
            'rotate' => $this->request->getPost('rotate')
        ];

        // Call TwibbonLib
        $twibbonLib = new TwibbonLib();
        $framePath = FCPATH . $frame['file_path'];

        $generateSuccess = $twibbonLib->generate($framePath, $fullPhotoPath, $cropData, $fullOutputPath);

        // Delete temporary photo file
        if (file_exists($fullPhotoPath)) {
            unlink($fullPhotoPath);
        }

        if ($generateSuccess) {
            // Save statistic
            $this->statisticModel->insert([
                'campaign_id' => $campaignId,
                'ip_address'  => $this->request->getIPAddress(),
                'user_agent'  => (string) $this->request->getUserAgent()
            ]);

            // Periodic cleanup: ~5% chance to delete expired files (tanpa cron)
            if (mt_rand(1, 20) === 1) {
                $this->cleanupExpiredFiles();
            }

            return $this->response->setJSON([
                'status'       => 'success',
                'download_url' => base_url('uploads/twibbon/results/' . $outputName)
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Gagal memproses penggabungan twibbon.'
            ]);
        }
    }
}
