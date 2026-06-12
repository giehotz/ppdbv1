<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\Files\File;

class SettingKartuController extends BaseController
{
    protected $instansiModel;
    protected $layoutModel;
    protected $qrModel;
    protected $ttdModel;
    protected $printerModel;

    public function __construct()
    {
        $this->layoutModel = new \App\Models\LayoutKartuModel();
        $this->layoutModel = new \App\Models\LayoutKartuModel();
        $this->qrModel = new \App\Models\SettingQrModel();
        $this->ttdModel = new \App\Models\TandaTanganModel();
        $this->printerModel = new \App\Models\SettingPrinterModel();
    }

    public function index()
    {
        $webModel = new \App\Models\TblWebModel();

        $data = [
            'title'    => 'Pengaturan Kartu',
            'instansi' => $webModel->first() ?? [],
            'layout'   => $this->layoutModel->first() ?? [],
            'qr'       => $this->qrModel->first() ?? [],
            'ttd'      => $this->ttdModel->first() ?? [],
            'printer'  => $this->printerModel->first() ?? [],
        ];

        return view('admin/setting_kartu/index', $data);
    }

    public function preview()
    {
        $webModel = new \App\Models\TblWebModel();

        // Find a real student to preview, or use dummy data if table is empty
        $siswaModel = new \App\Models\SiswaModel();
        $siswa = $siswaModel->first();

        if (!$siswa) {
            $siswa = [
                'nama_lengkap' => 'CONTOH NAMA SISWA',
                'nisn' => '1234567890',
                'no_pendaftaran' => 'PPDB-000001',
                'tempat_lahir' => 'Jakarta',
                'tgl_lahir' => date('Y-m-d', strtotime('-15 years')),
                'alamat_siswa' => 'Jl. Contoh Alamat No. 123, Kel. Contoh, Kec. Contoh',
            ];
        }

        if (!empty($siswa['id_siswa'])) {
            $berkasModel = new \App\Models\BerkasModel();
            $berkasFoto = $berkasModel->where('id_siswa', $siswa['id_siswa'])
                                      ->where('jenis_berkas', 'foto')
                                      ->orderBy('created_at', 'DESC')
                                      ->first();
            if ($berkasFoto) {
                $siswa['foto_berkas'] = $berkasFoto['path_file'];
            }
        }

        $data = [
            'siswa'    => $siswa,
            'instansi' => $webModel->first() ?? [],
            'layout'   => $this->layoutModel->first() ?? [],
            'qr'       => $this->qrModel->first() ?? [],
            'ttd'      => $this->ttdModel->first() ?? [],
            'printer'  => $this->printerModel->first() ?? [],
        ];

        return view('admin/siswa/cetak_kartu', $data);
    }

    public function cetakMasal()
    {
        $webModel = new \App\Models\TblWebModel();
        $siswaModel = new \App\Models\SiswaModel();
        $berkasModel = new \App\Models\BerkasModel();

        $statusKelulusan = $this->request->getGet('status_kelulusan');
        $limit = $this->request->getGet('limit') ?? 50;
        $offset = $this->request->getGet('offset') ?? 0;
        $printMode = $this->request->getGet('print_mode') ?? 'duplex';

        // Base query
        $db = \Config\Database::connect();
        $builder = $db->table('tbl_siswa');

        if (!empty($statusKelulusan)) {
            $builder->where('status_lulus', $statusKelulusan);
        }

        $builder->orderBy('id_siswa', 'ASC');

        if ($limit > 0) {
            $builder->limit((int)$limit, (int)$offset);
        }

        $siswaList = $builder->get()->getResultArray();

        // Map foto from berkas
        $siswaIds = array_column($siswaList, 'id_siswa');
        if (!empty($siswaIds)) {
            $berkasFotoList = $berkasModel->whereIn('id_siswa', $siswaIds)
                                          ->where('jenis_berkas', 'foto')
                                          ->orderBy('created_at', 'ASC') // so later ones overwrite if multiple
                                          ->findAll();
            $fotoMap = [];
            foreach ($berkasFotoList as $bf) {
                $fotoMap[$bf['id_siswa']] = $bf['path_file'];
            }
            foreach ($siswaList as &$s) {
                $s['foto_berkas'] = $fotoMap[$s['id_siswa']] ?? null;
            }
            unset($s);
        }

        $data = [
            'students'   => $siswaList,
            'print_mode' => $printMode,
            'instansi'   => $webModel->first() ?? [],
            'layout'     => $this->layoutModel->first() ?? [],
            'qr'         => $this->qrModel->first() ?? [],
            'ttd'        => $this->ttdModel->first() ?? [],
            'printer'    => $this->printerModel->first() ?? [],
        ];

        return view('admin/siswa/cetak_kartu_masal', $data);
    }

    public function saveLayout()
    {
        $id = $this->request->getPost('id_layout');
        $data = [
            'nama_layout'  => $this->request->getPost('nama_layout'),
            'panjang_cm'   => $this->request->getPost('panjang_cm'),
            'lebar_cm'     => $this->request->getPost('lebar_cm'),
            'masa_berlaku' => $this->request->getPost('masa_berlaku'),
        ];

        foreach (['bg_depan', 'bg_belakang'] as $field) {
            $file = $this->request->getFile($field);
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move('uploads/kartu', $newName);
                $data[$field] = $newName;

                // Delete old file
                if ($id) {
                    $old = $this->layoutModel->find($id);
                    if ($old && !empty($old[$field]) && file_exists('uploads/kartu/' . $old[$field])) {
                        unlink('uploads/kartu/' . $old[$field]);
                    }
                }
            }
        }

        if ($id) {
            $this->layoutModel->update($id, $data);
        } else {
            $this->layoutModel->insert($data);
        }

        return redirect()->to(base_url('admin/setting-kartu'))->with('success', 'Layout Kartu berhasil disimpan.');
    }

    public function deleteImage()
    {
        $field = $this->request->getPost('field');
        $id = $this->request->getPost('id_layout');

        if (!in_array($field, ['bg_depan', 'bg_belakang'])) {
            return redirect()->to(base_url('admin/setting-kartu'))->with('error', 'Field tidak valid.');
        }

        if (!$id) {
            return redirect()->to(base_url('admin/setting-kartu'))->with('error', 'ID layout tidak ditemukan.');
        }

        $layout = $this->layoutModel->find($id);
        if ($layout && !empty($layout[$field])) {
            $filePath = FCPATH . 'uploads/kartu/' . $layout[$field];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            $this->layoutModel->update($id, [$field => null]);
            catat_log('Hapus Gambar Kartu', "Menghapus gambar {$field} dari layout kartu.");
        }

        return redirect()->to(base_url('admin/setting-kartu'))->with('success', 'Gambar berhasil dihapus.');
    }

    public function saveQr()
    {
        $id = $this->request->getPost('id_qr');
        $data = [
            'version'      => $this->request->getPost('version'),
            'ecc_level'    => $this->request->getPost('ecc_level'),
            'size_pixel'   => $this->request->getPost('size_pixel'),
            'padding_tepi' => $this->request->getPost('padding_tepi'),
            'global_text'  => $this->request->getPost('global_text'),
            'posisi_kartu' => $this->request->getPost('posisi_kartu'),
        ];

        if ($id) {
            $this->qrModel->update($id, $data);
        } else {
            $this->qrModel->insert($data);
        }

        return redirect()->to(base_url('admin/setting-kartu'))->with('success', 'Pengaturan QR Code berhasil disimpan.');
    }

    public function saveTandaTangan()
    {
        $id = $this->request->getPost('id_ttd');
        $data = [
            'kota_ttd'     => $this->request->getPost('kota_ttd'),
            'nama_pejabat' => $this->request->getPost('nama_pejabat'),
            'nip_pejabat'  => $this->request->getPost('nip_pejabat'),
            'jabatan'      => $this->request->getPost('jabatan'),
            'tgl_ttd'      => $this->request->getPost('tgl_ttd'),
        ];

        foreach (['file_ttd', 'file_cap'] as $field) {
            $file = $this->request->getFile($field);
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move('uploads/kartu', $newName);
                $data[$field] = $newName;

                // Delete old file
                if ($id) {
                    $old = $this->ttdModel->find($id);
                    if ($old && !empty($old[$field]) && file_exists('uploads/kartu/' . $old[$field])) {
                        unlink('uploads/kartu/' . $old[$field]);
                    }
                }
            }
        }

        if ($id) {
            $this->ttdModel->update($id, $data);
        } else {
            $this->ttdModel->insert($data);
        }

        return redirect()->to(base_url('admin/setting-kartu'))->with('success', 'Pengaturan Penandatangan berhasil disimpan.');
    }

    public function savePrinter()
    {
        $id = $this->request->getPost('id_printer');
        $data = [
            'dpi'                   => $this->request->getPost('dpi'),
            'margin_kiri'           => $this->request->getPost('margin_kiri'),
            'margin_atas'           => $this->request->getPost('margin_atas'),
            'margin_kartu_kanan'    => $this->request->getPost('margin_kartu_kanan'),
            'margin_kartu_bawah'    => $this->request->getPost('margin_kartu_bawah'),
            'margin_depan_belakang' => $this->request->getPost('margin_depan_belakang'),
        ];

        if ($id) {
            $this->printerModel->update($id, $data);
        } else {
            $this->printerModel->insert($data);
        }

        return redirect()->to(base_url('admin/setting-kartu'))->with('success', 'Pengaturan Printer berhasil disimpan.');
    }
}
