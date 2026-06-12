<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TblWebModel;

class Settings extends BaseController
{
    protected $tblWebModel;

    public function __construct()
    {
        $this->tblWebModel = new TblWebModel();
    }

    public function index()
    {
        $web = $this->tblWebModel->find(1);

        if (!$web) {
            // If no settings found, insert default one
            $this->tblWebModel->insert([
                'id_web' => 1,
                'nama_sekolah' => 'MIN 2 Tanggamus',
                'status_ppdb' => 'Buka',
                'th_pelajaran' => date('Y') . '/' . (date('Y') + 1),
                'semester' => 'Ganjil',
            ]);
            $web = $this->tblWebModel->find(1);
        }

        $db = \Config\Database::connect();
        $penghasilan = $db->table('tbl_penghasilan')->orderBy('urutan', 'ASC')->get()->getResultArray();
        $penghasilan_list = '';
        if (empty($penghasilan)) {
            // Default list as requested
            $penghasilan_list = "Di bawah Rp800.000\nRp800.000 – Rp1.200.000\nRp1.200.000 – Rp1.800.000\nRp1.800.000 – Rp2.500.000\nRp2.500.000 – Rp3.500.000\nRp3.500.000 – Rp4.800.000\nRp4.800.000 – Rp6.500.000\nRp6.500.000 – Rp10.000.000\nRp10.000.000 – Rp20.000.000\nDi atas Rp20.000.000";
        } else {
            foreach ($penghasilan as $p) {
                $penghasilan_list .= $p['nama_penghasilan'] . "\n";
            }
        }

        $data = [
            'web' => $web,
            'penghasilan_list' => trim($penghasilan_list)
        ];
        return view('admin/settings/index', $data);
    }

    public function update()
    {
        $id = 1; // Assuming single record for settings

        // Handle Penghasilan List first
        $penghasilan_list = $this->request->getPost('penghasilan_list');
        if ($penghasilan_list !== null) {
            $lines = explode("\n", $penghasilan_list);
            $db = \Config\Database::connect();
            $builder = $db->table('tbl_penghasilan');
            $builder->emptyTable();
            $urutan = 1;
            $insertData = [];
            foreach ($lines as $line) {
                $line = trim($line);
                if (!empty($line)) {
                    $insertData[] = [
                        'nama_penghasilan' => $line,
                        'urutan' => $urutan++
                    ];
                }
            }
            if (!empty($insertData)) {
                $builder->insertBatch($insertData);
            }
        }

        $data = [
            'app_alias'         => $this->request->getPost('app_alias'),
            'app_name'          => $this->request->getPost('app_name'),
            'nama_sekolah'      => $this->request->getPost('nama_sekolah'),
            'nsm'               => $this->request->getPost('nsm'),
            'npsn'              => $this->request->getPost('npsn'),
            'status_ppdb'       => $this->request->getPost('status_ppdb'),
            'alamat_sekolah'    => $this->request->getPost('alamat_sekolah'),
            'kecamatan'         => $this->request->getPost('kecamatan'),
            'kabupaten'         => $this->request->getPost('kabupaten'),
            'provinsi'          => $this->request->getPost('provinsi'),
            'telepon'           => $this->request->getPost('telepon'),
            'email'             => $this->request->getPost('email'),
            'website'           => $this->request->getPost('website'),
            'nama_kepala'       => $this->request->getPost('nama_kepala'),
            'nip_kepala'        => $this->request->getPost('nip_kepala'),
            'th_pelajaran'      => $this->request->getPost('th_pelajaran'),
            'semester'          => $this->request->getPost('semester'),
            'tgl_pengumuman'    => !empty($this->request->getPost('tgl_pengumuman')) ? date('Y-m-d H:i:s', strtotime($this->request->getPost('tgl_pengumuman'))) : null,
            'pengumuman_aktif'  => $this->request->getPost('pengumuman_aktif'),
            'format_no_daftar'  => $this->request->getPost('format_no_daftar'),
            'link_grup_wa'      => $this->request->getPost('link_grup_wa'),
            'tampil_grup_wa'    => $this->request->getPost('tampil_grup_wa') ?? 0,
            'landing_variant'   => $this->request->getPost('landing_variant') ?? 'index',
            'wajib_biodata_100' => $this->request->getPost('wajib_biodata_100') ?? 1,
            'popup_biodata_welcome' => $this->request->getPost('popup_biodata_welcome'),
            'popup_biodata_warning' => $this->request->getPost('popup_biodata_warning'),
        ];

        // Handle File Upload (Logo)
        $fileLogo = $this->request->getFile('logo_sekolah');
        if ($fileLogo && $fileLogo->isValid() && !$fileLogo->hasMoved()) {

            // Validate logo upload
            $validationRule = [
                'logo_sekolah' => [
                    'label' => 'Logo Sekolah',
                    'rules' => 'uploaded[logo_sekolah]'
                        . '|is_image[logo_sekolah]'
                        . '|mime_in[logo_sekolah,image/jpg,image/jpeg,image/png]'
                        . '|ext_in[logo_sekolah,jpg,jpeg,png]'
                        . '|max_size[logo_sekolah,2048]',
                ],
            ];

            if (!$this->validate($validationRule)) {
                $errorMsg = $this->validator->getError('logo_sekolah');
                session()->setFlashdata('error', 'Gagal memuat logo: ' . $errorMsg);
                return redirect()->back()->withInput();
            }

            // Move the valid logo
            $newName = $fileLogo->getRandomName();
            $fileLogo->move('uploads/logo', $newName);
            $data['logo_sekolah'] = $newName;
        }

        if ($this->tblWebModel->update($id, $data)) {
            // Update custom format untuk semua siswa dengan format baru
            if (isset($data['format_no_daftar'])) {
                $siswaModel = new \App\Models\SiswaModel();
                $semuaSiswa = $siswaModel->orderBy('id_siswa', 'ASC')->findAll();
                
                if (!empty($semuaSiswa)) {
                    $format = $data['format_no_daftar'];
                    $db = \Config\Database::connect();
                    $db->transStart();
                    
                    foreach ($semuaSiswa as $siswa) {
                        $newNumber = str_pad($siswa['id_siswa'], 4, '0', STR_PAD_LEFT);
                        $siswaYear = !empty($siswa['tgl_siswa']) ? date('Y', strtotime($siswa['tgl_siswa'])) : date('Y');
                        $siswaMonth = !empty($siswa['tgl_siswa']) ? date('m', strtotime($siswa['tgl_siswa'])) : date('m');
                        
                        $no_pendaftaran = str_replace(
                            ['{TAHUN}', '{BULAN}', '{URUT}'], 
                            [$siswaYear, $siswaMonth, $newNumber], 
                            $format
                        );
                        
                        // Update bulk or single
                        $siswaModel->update($siswa['id_siswa'], ['no_pendaftaran' => $no_pendaftaran]);
                    }
                    
                    $db->transComplete();
                }
            }

            session()->setFlashdata('success', 'Pengaturan berhasil diperbarui. Format No. Pendaftaran pada Data Siswa juga ikut disesuaikan!');
        } else {
            session()->setFlashdata('error', 'Gagal memperbarui pengaturan.');
        }

        return redirect()->to('/admin/settings');
    }
}
