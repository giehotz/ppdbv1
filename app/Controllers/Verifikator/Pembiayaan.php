<?php

namespace App\Controllers\Verifikator;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\ItemPembiayaanModel;
use App\Models\TagihanSiswaModel;
use App\Models\PembayaranModel;
use App\Libraries\PdfGenerator;

class Pembiayaan extends BaseController
{
    protected $siswaModel;
    protected $itemModel;
    protected $tagihanModel;
    protected $pembayaranModel;

    public function __construct()
    {
        $this->siswaModel      = new SiswaModel();
        $this->itemModel       = new ItemPembiayaanModel();
        $this->tagihanModel    = new TagihanSiswaModel();
        $this->pembayaranModel = new PembayaranModel();
    }

    public function index()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tbl_siswa');
        $builder->select('tbl_siswa.id_siswa, tbl_siswa.no_pendaftaran, tbl_siswa.nama_lengkap, tbl_siswa.jk');
        $builder->where('tbl_siswa.deleted_at', null);
        $siswaList = $builder->orderBy('tbl_siswa.nama_lengkap', 'ASC')->get()->getResultArray();

        $data = [];
        foreach ($siswaList as $s) {
            $id = $s['id_siswa'];
            $totalTagihan = $this->tagihanModel->getTotalTagihan($id);
            $totalLunas   = $this->tagihanModel->getTotalLunas($id);
            $statusLunas  = $this->tagihanModel->isAllLunas($id);
            $totalBayar   = $this->pembayaranModel->getTotalBayar($id);
            $sisa         = sisa_tagihan($totalTagihan, $totalBayar);

            $data[] = array_merge($s, [
                'totalTagihan' => $totalTagihan,
                'totalLunas'   => $totalLunas,
                'statusLunas'  => $statusLunas,
                'totalBayar'   => $totalBayar,
                'sisa'         => $sisa,
            ]);
        }

        $viewData = ['siswaList' => $data];
        return view('verifikator/pembiayaan/siswa_list', $viewData);
    }

    public function tambahTagihanSemuaSiswa()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tbl_siswa');
        $builder->where('deleted_at', null);
        $siswaList = $builder->get()->getResultArray();

        $allItems = $this->itemModel->where('aktif', 1)->findAll();

        if (empty($allItems)) {
            session()->setFlashdata('error', 'Tidak ada item pembiayaan yang aktif.');
            return redirect()->to('/verifikator/pembiayaan');
        }

        $db->transBegin();
        $totalAdded = 0;
        foreach ($siswaList as $s) {
            $available = $this->itemModel->getAvailableForSiswa($s['id_siswa']);
            foreach ($available as $item) {
                if (!$this->tagihanModel->hasItem($s['id_siswa'], $item['id_item'])) {
                    $this->tagihanModel->save([
                        'siswa_id'     => $s['id_siswa'],
                        'item_id'      => $item['id_item'],
                        'harga_satuan' => $item['harga'],
                        'dibuat_oleh'  => session()->get('nama_lengkap') ?? 'Verifikator',
                        'status_bayar' => 'belum',
                    ]);
                    $totalAdded++;
                }
            }
        }

        if ($db->transStatus() === false) {
            $db->transRollback();
            session()->setFlashdata('error', 'Gagal menambahkan tagihan ke semua siswa.');
            return redirect()->to('/verifikator/pembiayaan');
        }

        $db->transCommit();
        catat_log('Tambah Tagihan Semua Siswa', "Verifikator menambah $totalAdded tagihan ke semua siswa");
        session()->setFlashdata('success', "Berhasil menambahkan $totalAdded tagihan ke " . count($siswaList) . " siswa.");
        return redirect()->to('/verifikator/pembiayaan');
    }

    public function detail($siswaId)
    {
        $siswa = $this->siswaModel->find($siswaId);
        if (!$siswa) {
            session()->setFlashdata('error', 'Data siswa tidak ditemukan.');
            return redirect()->to('/verifikator/pembiayaan');
        }

        $tagihan       = $this->tagihanModel->getTagihanBySiswa($siswaId);
        $totalTagihan  = $this->tagihanModel->getTotalTagihan($siswaId);
        $totalLunas    = $this->tagihanModel->getTotalLunas($siswaId);
        $statusLunas   = $this->tagihanModel->isAllLunas($siswaId);
        $unpaidItems   = $this->tagihanModel->getUnpaidItems($siswaId);
        $items         = $this->itemModel->getAvailableForSiswa($siswaId);
        $riwayatBayar  = $this->pembayaranModel->getRiwayatBySiswa($siswaId);

        $data = [
            'siswa'        => $siswa,
            'tagihan'      => $tagihan,
            'totalTagihan' => $totalTagihan,
            'totalLunas'   => $totalLunas,
            'statusLunas'  => $statusLunas,
            'unpaidItems'  => $unpaidItems,
            'items'        => $items,
            'riwayatBayar' => $riwayatBayar,
        ];

        return view('verifikator/pembiayaan/detail_siswa', $data);
    }

    public function tambahTagihan($siswaId)
    {
        $itemId = $this->request->getPost('item_id');
        if (empty($itemId)) {
            session()->setFlashdata('error', 'Pilih item tagihan terlebih dahulu.');
            return redirect()->back();
        }

        if ($this->tagihanModel->hasItem($siswaId, $itemId)) {
            session()->setFlashdata('error', 'Item tagihan ini sudah ada pada daftar tagihan siswa.');
            return redirect()->back();
        }

        $item = $this->itemModel->find($itemId);
        if (!$item) {
            session()->setFlashdata('error', 'Item tidak ditemukan.');
            return redirect()->back();
        }

        $this->tagihanModel->save([
            'siswa_id'     => $siswaId,
            'item_id'      => $itemId,
            'harga_satuan' => $item['harga'],
            'dibuat_oleh'  => session()->get('nama_lengkap') ?? 'Verifikator',
            'status_bayar' => 'belum',
        ]);

        catat_log('Tambah Tagihan Siswa', "Verifikator menambah tagihan {$item['nama']} untuk siswa ID $siswaId");
        session()->setFlashdata('success', "Tagihan \"{$item['nama']}\" berhasil ditambahkan.");
        return redirect()->to('/verifikator/pembiayaan/siswa/' . $siswaId);
    }

    public function tambahSemuaTagihan($siswaId)
    {
        $items = $this->itemModel->getAvailableForSiswa($siswaId);

        if (empty($items)) {
            session()->setFlashdata('error', 'Tidak ada item baru yang bisa ditambahkan.');
            return redirect()->back();
        }

        $db = \Config\Database::connect();
        $db->transBegin();

        $count = 0;
        foreach ($items as $item) {
            if (!$this->tagihanModel->hasItem($siswaId, $item['id_item'])) {
                $this->tagihanModel->save([
                    'siswa_id'     => $siswaId,
                    'item_id'      => $item['id_item'],
                    'harga_satuan' => $item['harga'],
                    'dibuat_oleh'  => session()->get('nama_lengkap') ?? 'Verifikator',
                    'status_bayar' => 'belum',
                ]);
                $count++;
            }
        }

        if ($db->transStatus() === false) {
            $db->transRollback();
            session()->setFlashdata('error', 'Gagal menambahkan tagihan.');
            return redirect()->back();
        }

        $db->transCommit();
        catat_log('Tambah Semua Tagihan', "Verifikator menambah $count tagihan untuk siswa ID $siswaId");
        session()->setFlashdata('success', "$count tagihan berhasil ditambahkan.");
        return redirect()->to('/verifikator/pembiayaan/siswa/' . $siswaId);
    }

    public function hapusTagihan($siswaId)
    {
        $idTagihan = $this->request->getPost('id_tagihan');
        if (empty($idTagihan)) {
            session()->setFlashdata('error', 'Tagihan tidak valid.');
            return redirect()->back();
        }

        $tagihan = $this->tagihanModel->find($idTagihan);
        if (!$tagihan || $tagihan['siswa_id'] != $siswaId) {
            session()->setFlashdata('error', 'Tagihan tidak ditemukan.');
            return redirect()->back();
        }

        if ($tagihan['status_bayar'] === 'lunas') {
            session()->setFlashdata('error', 'Tagihan yang sudah berstatus LUNAS tidak dapat dihapus. Batalkan transaksi pembayaran terkait terlebih dahulu.');
            return redirect()->back();
        }

        $this->tagihanModel->delete($idTagihan);
        catat_log('Hapus Tagihan Siswa', "Verifikator menghapus tagihan ID $idTagihan dari siswa ID $siswaId");
        session()->setFlashdata('success', 'Tagihan berhasil dihapus.');
        return redirect()->to('/verifikator/pembiayaan/siswa/' . $siswaId);
    }

    public function bayar($siswaId)
    {
        $jumlah     = (int) $this->request->getPost('jumlah');
        $tanggal    = $this->request->getPost('tanggal');
        $metode     = $this->request->getPost('metode') ?: 'Tunai';
        $keterangan = trim($this->request->getPost('keterangan') ?? '');
        $tagihanIds = $this->request->getPost('tagihan_ids');

        if ($jumlah <= 0 || empty($tanggal)) {
            session()->setFlashdata('error', 'Jumlah bayar dan tanggal wajib diisi.');
            return redirect()->back()->withInput();
        }

        // Idempotency Guard (8 seconds window)
        if ($this->pembayaranModel->isDuplicatePayment($siswaId, $jumlah, $tanggal, 8)) {
            session()->setFlashdata('error', 'Transaksi pembayaran yang sama baru saja tercatat. Hindari melakukan klik ganda.');
            return redirect()->to('/verifikator/pembiayaan/siswa/' . $siswaId);
        }

        if (!is_array($tagihanIds) && !empty($tagihanIds)) {
            $tagihanIds = array_filter(array_map('intval', explode(',', $tagihanIds)));
        }

        $buktiPaths = $this->uploadBuktiFiles($siswaId);

        $db = \Config\Database::connect();
        $db->transBegin();

        $this->pembayaranModel->save([
            'siswa_id'          => $siswaId,
            'jumlah'            => $jumlah,
            'tanggal'           => $tanggal,
            'metode'            => $metode,
            'keterangan'        => $keterangan,
            'bukti_pembayaran'  => !empty($buktiPaths) ? json_encode($buktiPaths) : null,
            'diverifikasi_oleh' => session()->get('nama_lengkap') ?? 'Verifikator',
        ]);

        if (!empty($tagihanIds) && is_array($tagihanIds)) {
            foreach ($tagihanIds as $idTagihan) {
                $t = $this->tagihanModel->find($idTagihan);
                if ($t && $t['siswa_id'] == $siswaId) {
                    $this->tagihanModel->markAsLunas($idTagihan);
                }
            }
        } else {
            $sisaBayar = $jumlah;
            $unpaid = $this->tagihanModel->where('siswa_id', $siswaId)
                ->where('status_bayar', 'belum')
                ->orderBy('harga_satuan', 'ASC')
                ->findAll();

            foreach ($unpaid as $item) {
                if ($sisaBayar <= 0) break;
                $harga = (int) $item['harga_satuan'];
                if ($sisaBayar >= $harga) {
                    $this->tagihanModel->markAsLunas($item['id_tagihan']);
                    $sisaBayar -= $harga;
                }
            }
        }

        if ($db->transStatus() === false) {
            $db->transRollback();
            session()->setFlashdata('error', 'Gagal mencatat transaksi pembayaran.');
            return redirect()->back();
        }

        $db->transCommit();

        catat_log('Catat Pembayaran', "Verifikator mencatat pembayaran Rp " . number_format($jumlah, 0, ',', '.') . " untuk siswa ID $siswaId");
        session()->setFlashdata('success', 'Pembayaran sebesar ' . format_rupiah($jumlah) . ' berhasil dicatat.');
        return redirect()->to('/verifikator/pembiayaan/siswa/' . $siswaId);
    }

    public function hapusPembayaran($siswaId)
    {
        $idPembayaran = $this->request->getPost('id_pembayaran');
        if (empty($idPembayaran)) {
            session()->setFlashdata('error', 'ID pembayaran tidak valid.');
            return redirect()->back();
        }

        $pembayaran = $this->pembayaranModel->find($idPembayaran);
        if (!$pembayaran || $pembayaran['siswa_id'] != $siswaId) {
            session()->setFlashdata('error', 'Data pembayaran tidak ditemukan.');
            return redirect()->back();
        }

        $db = \Config\Database::connect();
        $db->transBegin();

        if (!empty($pembayaran['bukti_pembayaran'])) {
            $files = json_decode($pembayaran['bukti_pembayaran'], true) ?: [];
            foreach ($files as $file) {
                $filePath = FCPATH . 'uploads/bukti_pembayaran/' . $file;
                if (file_exists($filePath)) {
                    @unlink($filePath);
                }
            }
        }

        $this->pembayaranModel->delete($idPembayaran);

        $totalBayarTersisa = $this->pembayaranModel->getTotalBayar($siswaId);
        $allTagihan = $this->tagihanModel->where('siswa_id', $siswaId)->orderBy('created_at', 'ASC')->findAll();
        $sisaAlokasi = $totalBayarTersisa;

        foreach ($allTagihan as $t) {
            $harga = (int) $t['harga_satuan'];
            if ($sisaAlokasi >= $harga) {
                $this->tagihanModel->markAsLunas($t['id_tagihan']);
                $sisaAlokasi -= $harga;
            } else {
                $this->tagihanModel->markAsBelum($t['id_tagihan']);
            }
        }

        if ($db->transStatus() === false) {
            $db->transRollback();
            session()->setFlashdata('error', 'Gagal membatalkan transaksi pembayaran.');
            return redirect()->back();
        }

        $db->transCommit();

        catat_log('Hapus Pembayaran', "Verifikator menghapus pembayaran ID $idPembayaran untuk siswa ID $siswaId");
        session()->setFlashdata('success', 'Transaksi pembayaran berhasil dibatalkan dan status tagihan disinkronkan kembali.');
        return redirect()->to('/verifikator/pembiayaan/siswa/' . $siswaId);
    }

    public function uploadBukti($siswaId)
    {
        $idPembayaran = $this->request->getPost('id_pembayaran');
        if (empty($idPembayaran)) {
            session()->setFlashdata('error', 'ID pembayaran tidak valid.');
            return redirect()->back();
        }

        $pembayaran = $this->pembayaranModel->find($idPembayaran);
        if (!$pembayaran || $pembayaran['siswa_id'] != $siswaId) {
            session()->setFlashdata('error', 'Pembayaran tidak ditemukan.');
            return redirect()->back();
        }

        $buktiPaths = $this->uploadBuktiFiles($siswaId);

        if (empty($buktiPaths)) {
            session()->setFlashdata('error', 'Gagal mengupload bukti pembayaran.');
            return redirect()->back();
        }

        $existing = !empty($pembayaran['bukti_pembayaran']) ? json_decode($pembayaran['bukti_pembayaran'], true) : [];
        $merged = array_merge($existing, $buktiPaths);

        $this->pembayaranModel->update($idPembayaran, [
            'bukti_pembayaran' => json_encode($merged),
        ]);

        catat_log('Upload Bukti Bayar', "Verifikator upload bukti pembayaran untuk pembayaran ID $idPembayaran, siswa ID $siswaId");
        session()->setFlashdata('success', count($buktiPaths) . ' bukti pembayaran berhasil diupload.');
        return redirect()->to('/verifikator/pembiayaan/siswa/' . $siswaId);
    }

    public function hapusBukti($siswaId)
    {
        $idPembayaran = $this->request->getPost('id_pembayaran');
        $index = $this->request->getPost('index');

        $pembayaran = $this->pembayaranModel->find($idPembayaran);
        if (!$pembayaran || $pembayaran['siswa_id'] != $siswaId) {
            session()->setFlashdata('error', 'Pembayaran tidak ditemukan.');
            return redirect()->back();
        }

        $files = !empty($pembayaran['bukti_pembayaran']) ? json_decode($pembayaran['bukti_pembayaran'], true) : [];
        if (isset($files[$index])) {
            $filePath = FCPATH . 'uploads/bukti_pembayaran/' . $files[$index];
            if (file_exists($filePath)) {
                @unlink($filePath);
            }
            array_splice($files, $index, 1);
            $this->pembayaranModel->update($idPembayaran, [
                'bukti_pembayaran' => !empty($files) ? json_encode($files) : null,
            ]);
        }

        session()->setFlashdata('success', 'Bukti pembayaran berhasil dihapus.');
        return redirect()->to('/verifikator/pembiayaan/siswa/' . $siswaId);
    }

    protected function uploadBuktiFiles($siswaId)
    {
        $files = $this->request->getFileMultiple('bukti_pembayaran');
        if (empty($files) || empty($files[0]->getClientName())) {
            return [];
        }

        $uploadDir = FCPATH . 'uploads/bukti_pembayaran';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $paths = [];
        foreach ($files as $file) {
            if ($file->isValid() && !$file->hasMoved()) {
                $newName = 'bukti_' . $siswaId . '_' . time() . '_' . $file->getRandomName();
                $file->move($uploadDir, $newName);
                $paths[] = $newName;
            }
        }
        return $paths;
    }

    public function kuitansi($siswaId)
    {
        $siswa       = $this->siswaModel->find($siswaId);
        if (!$siswa) {
            session()->setFlashdata('error', 'Data siswa tidak ditemukan.');
            return redirect()->to('/verifikator/pembiayaan');
        }

        $totalTagihan = $this->tagihanModel->getTotalTagihan($siswaId);
        $totalLunas   = $this->tagihanModel->getTotalLunas($siswaId);
        $tagihan      = $this->tagihanModel->getTagihanBySiswa($siswaId);
        $riwayatBayar = $this->pembayaranModel->getRiwayatBySiswa($siswaId);

        if (!$this->tagihanModel->isAllLunas($siswaId)) {
            session()->setFlashdata('error', 'Kuitansi hanya bisa dicetak setelah semua tagihan lunas.');
            return redirect()->back();
        }

        $pdf = new PdfGenerator();
        $pdf->generate('siswa/kuitansi_pdf', [
            'siswa'        => $siswa,
            'tagihan'      => $tagihan,
            'totalTagihan' => $totalTagihan,
            'totalLunas'   => $totalLunas,
            'riwayatBayar' => $riwayatBayar,
        ], 'kuitansi_' . $siswa['no_pendaftaran'] . '.pdf');
    }
}
