<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\ItemPembiayaanModel;
use App\Models\TagihanSiswaModel;
use App\Models\PembayaranModel;
use App\Libraries\PdfGenerator;

class Pembiayaan extends BaseController
{
    protected $itemModel;
    protected $siswaModel;
    protected $tagihanModel;
    protected $pembayaranModel;

    public function __construct()
    {
        $this->itemModel       = new ItemPembiayaanModel();
        $this->siswaModel      = new SiswaModel();
        $this->tagihanModel    = new TagihanSiswaModel();
        $this->pembayaranModel = new PembayaranModel();
    }

    public function index()
    {
        $items = $this->itemModel->orderBy('urutan', 'ASC')->findAll();
        $db = \Config\Database::connect();
        $web = $db->table('tbl_web')->get()->getRowArray();
        
        $data = [
            'items' => $items,
            'web'   => $web
        ];
        return view('admin/pembiayaan/item_list', $data);
    }

    public function toggleMenuSiswa()
    {
        $status = $this->request->getPost('status');
        $db = \Config\Database::connect();
        $db->table('tbl_web')->update(['tampil_pembiayaan_siswa' => (int) $status]);
        
        catat_log('Ubah Fitur', "Admin mengubah status visibilitas menu pembiayaan siswa menjadi: " . ($status ? 'Tampil' : 'Sembunyi'));
        
        return $this->response->setJSON([
            'success' => true, 
            'message' => 'Pengaturan visibilitas menu pembiayaan siswa berhasil disimpan.'
        ]);
    }

    public function store()
    {
        $nama          = trim($this->request->getPost('nama') ?? '');
        $harga         = $this->request->getPost('harga');
        $jenis_kelamin = $this->request->getPost('jenis_kelamin');
        $urutan        = $this->request->getPost('urutan') ?? 0;

        if (empty($nama) || $harga === null || $harga === '') {
            session()->setFlashdata('error', 'Nama dan harga wajib diisi.');
            return redirect()->back()->withInput();
        }

        $this->itemModel->save([
            'nama'          => $nama,
            'harga'         => (int) $harga,
            'jenis_kelamin' => $jenis_kelamin ?: null,
            'urutan'        => (int) $urutan,
            'aktif'         => 1,
        ]);

        catat_log('Tambah Item Pembiayaan', "Admin menambah item: $nama");
        session()->setFlashdata('success', 'Item pembiayaan berhasil ditambahkan.');
        return redirect()->to('/admin/pembiayaan');
    }

    public function update()
    {
        $id            = $this->request->getPost('id_item');
        $nama          = trim($this->request->getPost('nama') ?? '');
        $harga         = $this->request->getPost('harga');
        $jenis_kelamin = $this->request->getPost('jenis_kelamin');
        $urutan        = $this->request->getPost('urutan') ?? 0;

        if (empty($id) || empty($nama) || $harga === null || $harga === '') {
            session()->setFlashdata('error', 'Data tidak lengkap.');
            return redirect()->back()->withInput();
        }

        $this->itemModel->update($id, [
            'nama'          => $nama,
            'harga'         => (int) $harga,
            'jenis_kelamin' => $jenis_kelamin ?: null,
            'urutan'        => (int) $urutan,
        ]);

        catat_log('Edit Item Pembiayaan', "Admin mengubah item ID $id: $nama");
        session()->setFlashdata('success', 'Item pembiayaan berhasil diperbarui.');
        return redirect()->to('/admin/pembiayaan');
    }

    public function delete($id)
    {
        $item = $this->itemModel->find($id);
        if (!$item) {
            session()->setFlashdata('error', 'Item tidak ditemukan.');
            return redirect()->to('/admin/pembiayaan');
        }

        $this->itemModel->update($id, ['aktif' => 0]);
        catat_log('Nonaktifkan Item Pembiayaan', "Admin menonaktifkan item: {$item['nama']}");
        session()->setFlashdata('success', 'Item berhasil dinonaktifkan.');
        return redirect()->to('/admin/pembiayaan');
    }

    public function activate($id)
    {
        $item = $this->itemModel->find($id);
        if (!$item) {
            session()->setFlashdata('error', 'Item tidak ditemukan.');
            return redirect()->to('/admin/pembiayaan');
        }

        $this->itemModel->update($id, ['aktif' => 1]);
        catat_log('Aktifkan Item Pembiayaan', "Admin mengaktifkan item: {$item['nama']}");
        session()->setFlashdata('success', 'Item berhasil diaktifkan.');
        return redirect()->to('/admin/pembiayaan');
    }

    public function siswaList()
    {
        $db = \Config\Database::connect();
        $activeYear = $this->siswaModel->getActiveThPelajaran();
        $selectedTh = $this->request->getGet('th_pelajaran') ?? $activeYear;

        $builder = $db->table('tbl_siswa');
        $builder->select('tbl_siswa.id_siswa, tbl_siswa.no_pendaftaran, tbl_siswa.nama_lengkap, tbl_siswa.jk, tbl_siswa.th_pelajaran');
        $builder->where('tbl_siswa.deleted_at', null);
        if ($selectedTh !== 'all') {
            $builder->where('tbl_siswa.th_pelajaran', $selectedTh);
        }
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
        return view('admin/pembiayaan/siswa_list', $viewData);
    }

    public function siswaDetail($siswaId)
    {
        $siswa = $this->siswaModel->find($siswaId);
        if (!$siswa) {
            session()->setFlashdata('error', 'Data siswa tidak ditemukan.');
            return redirect()->to('/admin/pembiayaan/siswa');
        }

        $tagihan       = $this->tagihanModel->getTagihanBySiswa($siswaId);
        $totalTagihan  = $this->tagihanModel->getTotalTagihan($siswaId);
        $totalLunas    = $this->tagihanModel->getTotalLunas($siswaId);
        $statusLunas   = $this->tagihanModel->isAllLunas($siswaId);
        $unpaidItems   = $this->tagihanModel->getUnpaidItems($siswaId);
        $riwayatBayar  = $this->pembayaranModel->getRiwayatBySiswa($siswaId);
        $items         = $this->itemModel->getAvailableForSiswa($siswaId);

        $data = [
            'siswa'        => $siswa,
            'tagihan'      => $tagihan,
            'totalTagihan' => $totalTagihan,
            'totalLunas'   => $totalLunas,
            'statusLunas'  => $statusLunas,
            'unpaidItems'  => $unpaidItems,
            'riwayatBayar' => $riwayatBayar,
            'items'        => $items,
        ];

        return view('admin/pembiayaan/siswa_detail', $data);
    }

    /**
     * Tambah satu item tagihan ke siswa dengan pencegahan duplikasi
     */
    public function tambahTagihan($siswaId)
    {
        $itemId = $this->request->getPost('item_id');
        if (empty($itemId)) {
            session()->setFlashdata('error', 'Pilih item tagihan terlebih dahulu.');
            return redirect()->back();
        }

        // Cek apakah siswa sudah memiliki tagihan item ini
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
            'dibuat_oleh'  => session()->get('nama_lengkap') ?? 'Admin',
            'status_bayar' => 'belum',
        ]);

        catat_log('Tambah Tagihan Siswa', "Admin menambah tagihan {$item['nama']} untuk siswa ID $siswaId");
        session()->setFlashdata('success', "Tagihan \"{$item['nama']}\" berhasil ditambahkan.");
        return redirect()->to('/admin/pembiayaan/siswa/' . $siswaId);
    }

    /**
     * Tambah semua item tagihan yang belum ada ke siswa secara transaksional
     */
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
            // Validasi ganda
            if (!$this->tagihanModel->hasItem($siswaId, $item['id_item'])) {
                $this->tagihanModel->save([
                    'siswa_id'     => $siswaId,
                    'item_id'      => $item['id_item'],
                    'harga_satuan' => $item['harga'],
                    'dibuat_oleh'  => session()->get('nama_lengkap') ?? 'Admin',
                    'status_bayar' => 'belum',
                ]);
                $count++;
            }
        }

        if ($db->transStatus() === false) {
            $db->transRollback();
            session()->setFlashdata('error', 'Gagal menambahkan seluruh tagihan.');
            return redirect()->back();
        }

        $db->transCommit();
        catat_log('Tambah Semua Tagihan', "Admin menambah $count tagihan untuk siswa ID $siswaId");
        session()->setFlashdata('success', "$count tagihan berhasil ditambahkan.");
        return redirect()->to('/admin/pembiayaan/siswa/' . $siswaId);
    }

    /**
     * Hapus tagihan (hanya jika belum lunas)
     */
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
        catat_log('Hapus Tagihan Siswa', "Admin menghapus tagihan ID $idTagihan dari siswa ID $siswaId");
        session()->setFlashdata('success', 'Tagihan berhasil dihapus.');
        return redirect()->to('/admin/pembiayaan/siswa/' . $siswaId);
    }

    /**
     * Catat pembayaran resmi dengan Database Transaction dan pencegahan double-submit
     */
    public function bayar($siswaId)
    {
        $jumlah     = (int) $this->request->getPost('jumlah');
        $tanggal    = $this->request->getPost('tanggal');
        $metode     = $this->request->getPost('metode') ?: 'Tunai';
        $keterangan = trim($this->request->getPost('keterangan') ?? '');
        $tagihanIds = $this->request->getPost('tagihan_ids');

        if ($jumlah <= 0 || empty($tanggal)) {
            session()->setFlashdata('error', 'Jumlah pembayaran dan tanggal wajib diisi secara valid.');
            return redirect()->back()->withInput();
        }

        // Pencegahan Double Submit (Idempotency Guard dalam jendela 8 detik)
        if ($this->pembayaranModel->isDuplicatePayment($siswaId, $jumlah, $tanggal, 8)) {
            session()->setFlashdata('error', 'Transaksi pembayaran yang sama baru saja tercatat. Hindari melakukan klik ganda.');
            return redirect()->to('/admin/pembiayaan/siswa/' . $siswaId);
        }

        // Parsing tagihan_ids jika dikirim sebagai string CSV
        if (!is_array($tagihanIds) && !empty($tagihanIds)) {
            $tagihanIds = array_filter(array_map('intval', explode(',', $tagihanIds)));
        }

        $buktiPaths = $this->uploadBuktiFiles($siswaId);

        $db = \Config\Database::connect();
        $db->transBegin();

        // 1. Simpan Transaksi Pembayaran
        $this->pembayaranModel->save([
            'siswa_id'          => $siswaId,
            'jumlah'            => $jumlah,
            'tanggal'           => $tanggal,
            'metode'            => $metode,
            'keterangan'        => $keterangan,
            'bukti_pembayaran'  => !empty($buktiPaths) ? json_encode($buktiPaths) : null,
            'diverifikasi_oleh' => session()->get('nama_lengkap') ?? 'Admin',
        ]);

        // 2. Tandai Tagihan Terpilih Sebagai LUNAS
        if (!empty($tagihanIds) && is_array($tagihanIds)) {
            foreach ($tagihanIds as $idTagihan) {
                $t = $this->tagihanModel->find($idTagihan);
                if ($t && $t['siswa_id'] == $siswaId) {
                    $this->tagihanModel->markAsLunas($idTagihan);
                }
            }
        } else {
            // Alokasikan nominal ke tagihan belum lunas secara otomatis
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
            session()->setFlashdata('error', 'Terjadi kesalahan sistem saat menyimpan pembayaran.');
            return redirect()->back();
        }

        $db->transCommit();

        catat_log('Catat Pembayaran', "Admin mencatat pembayaran Rp " . number_format($jumlah, 0, ',', '.') . " untuk siswa ID $siswaId");
        session()->setFlashdata('success', 'Pembayaran sebesar ' . format_rupiah($jumlah) . ' berhasil dicatat.');
        return redirect()->to('/admin/pembiayaan/siswa/' . $siswaId);
    }

    /**
     * Batalkan/Hapus Transaksi Pembayaran dan Revert Status Tagihan
     */
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

        // Hapus file bukti fisik jika ada
        if (!empty($pembayaran['bukti_pembayaran'])) {
            $files = json_decode($pembayaran['bukti_pembayaran'], true) ?: [];
            foreach ($files as $file) {
                $filePath = FCPATH . 'uploads/bukti_pembayaran/' . $file;
                if (file_exists($filePath)) {
                    @unlink($filePath);
                }
            }
        }

        // Hapus baris pembayaran
        $this->pembayaranModel->delete($idPembayaran);

        // Sinkronisasi status tagihan:
        // Hitung ulang total pembayaran riil yang tersisa
        $totalBayarTersisa = $this->pembayaranModel->getTotalBayar($siswaId);
        
        // Reset semua tagihan siswa ke 'belum', lalu tandai lunas sesuai total pembayaran riil
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

        catat_log('Hapus Pembayaran', "Admin menghapus pembayaran ID $idPembayaran untuk siswa ID $siswaId");
        session()->setFlashdata('success', 'Transaksi pembayaran berhasil dibatalkan dan status tagihan disinkronkan kembali.');
        return redirect()->to('/admin/pembiayaan/siswa/' . $siswaId);
    }

    /**
     * Upload bukti pembayaran tambahan
     */
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
            session()->setFlashdata('error', 'Gagal mengupload bukti pembayaran. Pilih file gambar yang valid.');
            return redirect()->back();
        }

        $existing = !empty($pembayaran['bukti_pembayaran']) ? json_decode($pembayaran['bukti_pembayaran'], true) : [];
        $merged   = array_merge($existing, $buktiPaths);

        $this->pembayaranModel->update($idPembayaran, [
            'bukti_pembayaran' => json_encode($merged),
        ]);

        catat_log('Upload Bukti Bayar', "Admin upload bukti pembayaran untuk transaksi ID $idPembayaran, siswa ID $siswaId");
        session()->setFlashdata('success', count($buktiPaths) . ' bukti pembayaran berhasil diupload.');
        return redirect()->to('/admin/pembiayaan/siswa/' . $siswaId);
    }

    /**
     * Hapus satu file bukti pembayaran
     */
    public function hapusBukti($siswaId)
    {
        $idPembayaran = $this->request->getPost('id_pembayaran');
        $index        = $this->request->getPost('index');

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
        return redirect()->to('/admin/pembiayaan/siswa/' . $siswaId);
    }

    protected function uploadBuktiFiles($siswaId)
    {
        $files = $this->request->getFileMultiple('bukti_pembayaran');
        if (empty($files) || empty($files[0]->getClientName())) {
            return [];
        }

        $uploadDir = FCPATH . 'uploads/bukti_pembayaran';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $allowedMimes = ['image/jpeg', 'image/png', 'image/webp', 'application/pdf'];
        $allowedExts  = ['jpg', 'jpeg', 'png', 'webp', 'pdf'];
        $maxSize      = 2097152; // 2MB

        $paths = [];
        foreach ($files as $file) {
            if ($file->isValid() && !$file->hasMoved()) {
                $mime = $file->getMimeType();
                $ext  = strtolower($file->getExtension());
                if (!in_array($mime, $allowedMimes, true) || !in_array($ext, $allowedExts, true) || $file->getSize() > $maxSize) {
                    continue; // Skip invalid or dangerous file types
                }
                $newName = 'bukti_' . $siswaId . '_' . time() . '_' . $file->getRandomName();
                $file->move($uploadDir, $newName);
                $paths[] = $newName;
            }
        }
        return $paths;
    }

    public function kuitansi($siswaId)
    {
        $siswa = $this->siswaModel->find($siswaId);
        if (!$siswa) {
            session()->setFlashdata('error', 'Data siswa tidak ditemukan.');
            return redirect()->to('/admin/pembiayaan/siswa');
        }

        $statusLunas = $this->tagihanModel->isAllLunas($siswaId);

        if (!$statusLunas) {
            session()->setFlashdata('error', 'Kuitansi hanya bisa dicetak setelah semua tagihan lunas.');
            return redirect()->back();
        }

        $tagihan      = $this->tagihanModel->getTagihanBySiswa($siswaId);
        $totalTagihan = $this->tagihanModel->getTotalTagihan($siswaId);
        $totalLunas   = $this->tagihanModel->getTotalLunas($siswaId);
        $riwayatBayar = $this->pembayaranModel->getRiwayatBySiswa($siswaId);

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
