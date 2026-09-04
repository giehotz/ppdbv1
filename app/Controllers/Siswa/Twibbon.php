<?php

namespace App\Controllers\Siswa;

use App\Controllers\BaseController;
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
        $this->campaignModel  = new TwibbonCampaignModel();
        $this->frameModel     = new TwibbonFrameModel();
        $this->statisticModel = new TwibbonStatisticModel();
        $this->tblWebModel    = new TblWebModel();
    }

    public function index()
    {
        $campaigns = $this->campaignModel->getActiveCampaigns();

        foreach ($campaigns as &$c) {
            $c['frame'] = $this->frameModel->where('campaign_id', $c['id'])->first();
        }

        $web = $this->tblWebModel->find(1);

        return view('siswa/twibbon/list', [
            'campaigns' => $campaigns,
            'web'       => $web,
        ]);
    }

    public function detail($slug)
    {
        $campaign = $this->campaignModel->where('slug', $slug)->first();
        if (!$campaign) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Kampanye tidak ditemukan.');
        }

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
            return redirect()->to('/siswa/twibbon');
        }

        $frame = $this->frameModel->where('campaign_id', $campaign['id'])->first();
        if (!$frame) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Bingkai kampanye belum dikonfigurasi.');
        }

        $web = $this->tblWebModel->find(1);

        $data = [
            'campaign' => $campaign,
            'frame'    => $frame,
            'web'      => $web,
        ];

        return view('siswa/twibbon/detail', $data);
    }

    public function process()
    {
        // 1. High-Fidelity Client-Rendered Composite Support (100% WYSIWYG)
        $json = $this->request->getJSON(true) ?? [];
        $imageData = $json['image_data'] ?? $this->request->getPost('image_data');
        $campaignId = $json['campaign_id'] ?? $this->request->getPost('campaign_id');

        if (!empty($imageData)) {
            $campaign = $this->campaignModel->find($campaignId);
            if (!$campaign) {
                return $this->response->setJSON([
                    'status'  => 'error',
                    'success' => false,
                    'message' => 'Kampanye tidak valid.',
                ]);
            }

            if (preg_match('/^data:image\/(\w+);base64,/', $imageData)) {
                $rawBase64 = substr($imageData, strpos($imageData, ',') + 1);
                $binaryData = base64_decode($rawBase64);
                if ($binaryData === false) {
                    return $this->response->setJSON([
                        'status'  => 'error',
                        'success' => false,
                        'message' => 'Format gambar base64 tidak valid.',
                    ]);
                }
            } else {
                return $this->response->setJSON([
                    'status'  => 'error',
                    'success' => false,
                    'message' => 'Data gambar tidak valid.',
                ]);
            }

            $resultsPath = FCPATH . 'uploads/twibbon/results';
            if (!is_dir($resultsPath)) {
                mkdir($resultsPath, 0755, true);
            }

            $outputName = 'twibbon_' . time() . '_' . rand(1000, 9999) . '.jpg';
            $fullOutputPath = $resultsPath . '/' . $outputName;

            file_put_contents($fullOutputPath, $binaryData);

            // Record statistic
            $this->statisticModel->insert([
                'campaign_id' => $campaignId,
                'ip_address'  => $this->request->getIPAddress(),
                'user_agent'  => (string) $this->request->getUserAgent(),
            ]);

            // Periodic cleanup: ~5% chance
            if (mt_rand(1, 20) === 1) {
                $this->cleanupExpiredFiles();
            }

            $downloadUrl = base_url('uploads/twibbon/results/' . $outputName);

            return $this->response->setJSON([
                'status'       => 'success',
                'success'      => true,
                'download_url' => $downloadUrl,
                'image_url'    => $downloadUrl,
            ]);
        }

        // 2. Fallback to multipart file upload and server GD rendering
        $rules = [
            'campaign_id' => 'required|is_not_unique[twibbon_campaigns.id]',
            'photo'       => 'uploaded[photo]|is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/png,image/webp]|ext_in[photo,jpg,jpeg,png,webp]|max_size[photo,5120]',
            'x'           => 'required|numeric',
            'y'           => 'required|numeric',
            'width'       => 'required|numeric',
            'height'      => 'required|numeric',
            'rotate'      => 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'success' => false,
                'message' => implode(' ', $this->validator->getErrors()),
            ]);
        }

        $campaignId = $this->request->getPost('campaign_id');
        $frame = $this->frameModel->where('campaign_id', $campaignId)->first();
        if (!$frame) {
            return $this->response->setJSON([
                'status'  => 'error',
                'success' => false,
                'message' => 'Bingkai kampanye tidak ditemukan.',
            ]);
        }

        $photoFile = $this->request->getFile('photo');
        if (!$photoFile || !$photoFile->isValid()) {
            return $this->response->setJSON([
                'status'  => 'error',
                'success' => false,
                'message' => 'Gagal mengunggah foto.',
            ]);
        }

        $tempPath = FCPATH . 'uploads/twibbon/temp';
        if (!is_dir($tempPath)) {
            mkdir($tempPath, 0755, true);
        }

        $tempName = $photoFile->getRandomName();
        $photoFile->move($tempPath, $tempName);
        $fullPhotoPath = $tempPath . '/' . $tempName;

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
            'rotate' => $this->request->getPost('rotate'),
        ];

        $twibbonLib = new TwibbonLib();
        $framePath = FCPATH . $frame['file_path'];
        $generateSuccess = $twibbonLib->generate($framePath, $fullPhotoPath, $cropData, $fullOutputPath);

        if (file_exists($fullPhotoPath)) {
            unlink($fullPhotoPath);
        }

        if ($generateSuccess) {
            $this->statisticModel->insert([
                'campaign_id' => $campaignId,
                'ip_address'  => $this->request->getIPAddress(),
                'user_agent'  => (string) $this->request->getUserAgent(),
            ]);

            if (mt_rand(1, 20) === 1) {
                $this->cleanupExpiredFiles();
            }

            $downloadUrl = base_url('uploads/twibbon/results/' . $outputName);

            return $this->response->setJSON([
                'status'       => 'success',
                'success'      => true,
                'download_url' => $downloadUrl,
                'image_url'    => $downloadUrl,
            ]);
        }

        return $this->response->setJSON([
            'status'  => 'error',
            'success' => false,
            'message' => 'Gagal memproses penggabungan twibbon.',
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
}
