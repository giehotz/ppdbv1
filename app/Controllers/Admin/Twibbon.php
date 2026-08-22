<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TwibbonCampaignModel;
use App\Models\TwibbonFrameModel;
use App\Models\TwibbonStatisticModel;
use App\Models\TwibbonSettingModel;

class Twibbon extends BaseController
{
    protected $campaignModel;
    protected $frameModel;
    protected $statisticModel;
    protected $settingModel;

    public function __construct()
    {
        $this->campaignModel  = new TwibbonCampaignModel();
        $this->frameModel     = new TwibbonFrameModel();
        $this->statisticModel = new TwibbonStatisticModel();
        $this->settingModel   = new TwibbonSettingModel();
    }

    public function index()
    {
        $campaigns = $this->campaignModel->orderBy('created_at', 'DESC')->findAll();
        
        // Add total downloads & frame to each campaign
        foreach ($campaigns as &$c) {
            $c['total_downloads'] = $this->statisticModel->getTotalDownloads($c['id']);
            $c['frame'] = $this->frameModel->where('campaign_id', $c['id'])->first();
        }

        return view('admin/twibbon/index', ['campaigns' => $campaigns]);
    }

    public function create()
    {
        return view('admin/twibbon/create');
    }

    public function store()
    {
        $rules = [
            'title'       => 'required|max_length[255]',
            'description' => 'permit_empty',
            'start_date'  => 'permit_empty|valid_date[Y-m-d]',
            'end_date'    => 'permit_empty|valid_date[Y-m-d]',
            'is_active'   => 'required|in_list[0,1]',
            'frame'       => 'uploaded[frame]|is_image[frame]|mime_in[frame,image/png]|ext_in[frame,png]|max_size[frame,5120]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Create slug
        $slug = url_title($this->request->getPost('title'), '-', true);
        // Ensure slug is unique
        $existing = $this->campaignModel->where('slug', $slug)->first();
        if ($existing) {
            $slug = $slug . '-' . time();
        }

        $campaignData = [
            'title'       => $this->request->getPost('title'),
            'slug'        => $slug,
            'description' => $this->request->getPost('description'),
            'start_date'  => $this->request->getPost('start_date') ?: null,
            'end_date'    => $this->request->getPost('end_date') ?: null,
            'is_active'   => $this->request->getPost('is_active'),
        ];

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $campaignId = $this->campaignModel->insert($campaignData);

            // Handle Frame File Upload
            $file = $this->request->getFile('frame');
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $uploadPath = FCPATH . 'uploads/twibbon/frames';
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }

                // Get dimensions
                list($width, $height) = getimagesize($file->getTempName());

                $newName = $file->getRandomName();
                $file->move($uploadPath, $newName);

                $frameData = [
                    'campaign_id' => $campaignId,
                    'file_path'   => 'uploads/twibbon/frames/' . $newName,
                    'width'       => $width,
                    'height'      => $height,
                    'config'      => json_encode([
                        'photo_area' => [
                            'x'      => 0,
                            'y'      => 0,
                            'width'  => $width,
                            'height' => $height,
                            'shape'  => ($width === $height) ? 'square' : 'rectangle'
                        ]
                    ]),
                    'sort_order'  => 0
                ];

                $this->frameModel->insert($frameData);
            }

            if ($db->transStatus() === false) {
                $db->transRollback();
                session()->setFlashdata('error', 'Gagal menyimpan data kampanye.');
                return redirect()->back()->withInput();
            }

            $db->transCommit();
            session()->setFlashdata('success', 'Kampanye Twibbon berhasil dibuat.');
            return redirect()->to('/admin/twibbon');

        } catch (\Exception $e) {
            $db->transRollback();
            session()->setFlashdata('error', 'Terjadi kesalahan: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function edit($id)
    {
        $campaign = $this->campaignModel->find($id);
        if (!$campaign) {
            session()->setFlashdata('error', 'Kampanye tidak ditemukan.');
            return redirect()->to('/admin/twibbon');
        }

        $frame = $this->frameModel->where('campaign_id', $id)->first();

        return view('admin/twibbon/edit', [
            'campaign' => $campaign,
            'frame'    => $frame
        ]);
    }

    public function update($id)
    {
        $campaign = $this->campaignModel->find($id);
        if (!$campaign) {
            session()->setFlashdata('error', 'Kampanye tidak ditemukan.');
            return redirect()->to('/admin/twibbon');
        }

        $rules = [
            'title'       => 'required|max_length[255]',
            'description' => 'permit_empty',
            'start_date'  => 'permit_empty|valid_date[Y-m-d]',
            'end_date'    => 'permit_empty|valid_date[Y-m-d]',
            'is_active'   => 'required|in_list[0,1]',
            'frame'       => 'permit_empty|uploaded[frame]|is_image[frame]|mime_in[frame,image/png]|ext_in[frame,png]|max_size[frame,5120]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Create slug if title changes
        $slug = $campaign['slug'];
        if ($campaign['title'] !== $this->request->getPost('title')) {
            $slug = url_title($this->request->getPost('title'), '-', true);
            $existing = $this->campaignModel->where('slug', $slug)->where('id !=', $id)->first();
            if ($existing) {
                $slug = $slug . '-' . time();
            }
        }

        $campaignData = [
            'title'       => $this->request->getPost('title'),
            'slug'        => $slug,
            'description' => $this->request->getPost('description'),
            'start_date'  => $this->request->getPost('start_date') ?: null,
            'end_date'    => $this->request->getPost('end_date') ?: null,
            'is_active'   => $this->request->getPost('is_active'),
        ];

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $this->campaignModel->update($id, $campaignData);

            // Handle Frame File Upload (Optional on update)
            $file = $this->request->getFile('frame');
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $uploadPath = FCPATH . 'uploads/twibbon/frames';
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }

                // Delete old frame file
                $oldFrame = $this->frameModel->where('campaign_id', $id)->first();
                if ($oldFrame && file_exists(FCPATH . $oldFrame['file_path'])) {
                    unlink(FCPATH . $oldFrame['file_path']);
                }

                // Get dimensions
                list($width, $height) = getimagesize($file->getTempName());

                $newName = $file->getRandomName();
                $file->move($uploadPath, $newName);

                $frameData = [
                    'file_path'   => 'uploads/twibbon/frames/' . $newName,
                    'width'       => $width,
                    'height'      => $height,
                    'config'      => json_encode([
                        'photo_area' => [
                            'x'      => 0,
                            'y'      => 0,
                            'width'  => $width,
                            'height' => $height,
                            'shape'  => ($width === $height) ? 'square' : 'rectangle'
                          ]
                      ])
                  ];

                  if ($oldFrame) {
                      $this->frameModel->update($oldFrame['id'], $frameData);
                  } else {
                      $frameData['campaign_id'] = $id;
                      $frameData['sort_order'] = 0;
                      $this->frameModel->insert($frameData);
                  }
              }

              if ($db->transStatus() === false) {
                  $db->transRollback();
                  session()->setFlashdata('error', 'Gagal memperbarui kampanye.');
                  return redirect()->back()->withInput();
              }

              $db->transCommit();
              session()->setFlashdata('success', 'Kampanye Twibbon berhasil diperbarui.');
              return redirect()->to('/admin/twibbon');

          } catch (\Exception $e) {
              $db->transRollback();
              session()->setFlashdata('error', 'Terjadi kesalahan: ' . $e->getMessage());
              return redirect()->back()->withInput();
          }
      }

      public function delete($id)
      {
          $campaign = $this->campaignModel->find($id);
          if (!$campaign) {
              session()->setFlashdata('error', 'Kampanye tidak ditemukan.');
              return redirect()->to('/admin/twibbon');
          }

          // Delete frame file
          $frame = $this->frameModel->where('campaign_id', $id)->first();
          if ($frame && file_exists(FCPATH . $frame['file_path'])) {
              unlink(FCPATH . $frame['file_path']);
          }

          if ($this->campaignModel->delete($id)) {
              session()->setFlashdata('success', 'Kampanye Twibbon berhasil dihapus.');
          } else {
              session()->setFlashdata('error', 'Gagal menghapus kampanye.');
          }

          return redirect()->to('/admin/twibbon');
      }

      public function stats($id)
      {
          $campaign = $this->campaignModel->find($id);
          if (!$campaign) {
              session()->setFlashdata('error', 'Kampanye tidak ditemukan.');
              return redirect()->to('/admin/twibbon');
          }

          $totalDownloads = $this->statisticModel->getTotalDownloads($id);
          $dailyStats = $this->statisticModel->getDailyStats($id, 14); // 14 days
          $recentDownloads = $this->statisticModel->where('campaign_id', $id)
              ->orderBy('created_at', 'DESC')
              ->limit(100)
              ->findAll();

          return view('admin/twibbon/stats', [
              'campaign'        => $campaign,
              'total_downloads' => $totalDownloads,
              'daily_stats'     => $dailyStats,
              'recent_downloads'=> $recentDownloads
          ]);
      }

      public function setting()
      {
          $settings = $this->settingModel->getSettings();
          return view('admin/twibbon/setting', ['settings' => $settings]);
      }

      public function saveSetting()
      {
          $rules = [
              'cleanup_enabled'   => 'required|in_list[0,1]',
              'results_ttl_hours' => 'required|integer|greater_than[0]|less_than[8760]',
              'temp_ttl_hours'    => 'required|integer|greater_than[0]|less_than[8760]',
          ];

          if (!$this->validate($rules)) {
              return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
          }

          $this->settingModel->update(1, [
              'cleanup_enabled'   => $this->request->getPost('cleanup_enabled'),
              'results_ttl_hours' => $this->request->getPost('results_ttl_hours'),
              'temp_ttl_hours'    => $this->request->getPost('temp_ttl_hours'),
          ]);

          session()->setFlashdata('success', 'Pengaturan Twibbon berhasil disimpan.');
          return redirect()->to('/admin/twibbon/setting');
      }

      public function cleanup()
      {
          $settings = $this->settingModel->getSettings();
          $resultsTTL = (int) $settings['results_ttl_hours'] * 3600;
          $tempTTL    = (int) $settings['temp_ttl_hours'] * 3600;

          $now = time();
          $deleted = 0;

          $dirs = [
              FCPATH . 'uploads/twibbon/results' => $resultsTTL,
              FCPATH . 'uploads/twibbon/temp'    => $tempTTL,
          ];

          foreach ($dirs as $path => $maxAge) {
              if (!is_dir($path)) continue;
              foreach (glob($path . '/*') as $file) {
                  if (is_file($file) && basename($file) !== '.gitkeep' && ($now - filemtime($file) > $maxAge)) {
                      @unlink($file);
                      $deleted++;
                  }
              }
          }

          session()->setFlashdata('success', "Pembersihan selesai. {$deleted} file kadaluarsa telah dihapus.");
          return redirect()->to('/admin/twibbon/setting');
      }

      public function downloadZip()
      {
          $resultsPath = FCPATH . 'uploads/twibbon/results';
          $files = glob($resultsPath . '/*.jpg');

          if (empty($files)) {
              session()->setFlashdata('error', 'Tidak ada file hasil twibbon untuk diunduh.');
              return redirect()->to('/admin/twibbon/setting');
          }

          $zipPath = tempnam(sys_get_temp_dir(), 'twibbon_') . '.zip';
          $zip = new \ZipArchive();

          if ($zip->open($zipPath, \ZipArchive::CREATE) !== true) {
              session()->setFlashdata('error', 'Gagal membuat file ZIP.');
              return redirect()->to('/admin/twibbon/setting');
          }

          foreach ($files as $file) {
              if (is_file($file)) {
                  $zip->addFile($file, basename($file));
              }
          }
          $zip->close();

          return $this->response->download($zipPath, null)->setFileName('twibbon_results.zip');
      }
  }
