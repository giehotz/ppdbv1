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
        $this->itemModel      = new ItemPembiayaanModel();
        $this->siswaModel     = new SiswaModel();
        $this->tagihanModel   = new TagihanSiswaModel();
        $this->pembayaranModel = new PembayaranModel();
    }

    public function index()
    {
        $items = $this->itemModel->orderBy('urutan', 'ASC')->findAll();
        $data = ['items' => $items];
        return view('admin/pembiayaan/item_list', $data);
    }

    public function store()
    {
        $nama = $this->request->getPost('nama');
        $harga = $this->request->getPost('harga');
        $jenis_kelamin = $this->request->getPost('jenis_kelamin');
        $urutan = $this->request->getPost('urutan') ?? 0;

        if (empty($nama) || $harga === null) {
            session()->setFlashdata('error', 'Nama dan harga wajib diisi.');
            return redirect()->back()->withInput();
        }

        $this->itemModel->save([
            'nama'           => $nama,
            'harga'          => $harga,
            'jenis_kelamin'  => $jenis_kelamin ?: null,
            'urutan'         => $urutan,
            'aktif'          => 1,
        ]);

        catat_log('Tambah Item Pembiayaan', "Admin menambah item: $nama");
        session()->setFlashdata('success', 'Item pembiayaan berhasil ditambahkan.');
        return redirect()->to('/admin/pembiayaan');
    }

    public function update()
    {
        $id = $this->request->getPost('id_item');
        $nama = $this->request->getPost('nama');
        $harga = $this->request->getPost('harga');
        $jenis_kelamin = $this->request->getPost('jenis_kelamin');
        $urutan = $this->request->getPost('urutan') ?? 0;

        if (empty($id) || empty($nama) || $harga === null) {
            session()->setFlashdata('error', 'Data tidak lengkap.');
            return redirect()->back()->withInput();
        }

        $this->itemModel->update($id, [
            'nama'           => $nama,
            'harga'          => $harga,
            'jenis_kelamin'  => $jenis_kelamin ?: null,
            'urutan'         => $urutan,
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
            'siswa'         => $siswa,
            'tagihan'       => $tagihan,
            'totalTagihan'  => $totalTagihan,
            'totalLunas'    => $totalLunas,
            'statusLunas'   => $statusLunas,
            'unpaidItems'   => $unpaidItems,
            'riwayatBayar'  => $riwayatBayar,
            'items'         => $items,
        ];

        return view('admin/pembiayaan/siswa_detail', $data);
    }

    public function updateStatusBayar($siswaId)
    {
        $tagihanIds = $this->request->getPost('tagihan_ids');
        $allTagihan = $this->tagihanModel->where('siswa_id', $siswaId)->findAll();

        foreach ($allTagihan as $t) {
            $id = $t['id_tagihan'];
            if (in_array($id, $tagihanIds ?? [])) {
                $this->tagihanModel->markAsLunas($id);
            } else {
                $this->tagihanModel->markAsBelum($id);
            }
        }

        catat_log('Update Status Bayar', "Admin memperbarui status bayar siswa ID $siswaId");
        session()->setFlashdata('success', 'Status pembayaran berhasil diperbarui.');
        return redirect()->to('/admin/pembiayaan/siswa/' . $siswaId);
    }

    public function tambahTagihan($siswaId)
    {
        $itemId = $this->request->getPost('item_id');
        if (empty($itemId)) {
            session()->setFlashdata('error', 'Pilih item tagihan terlebih dahulu.');
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
            'dibuat_oleh'  => session()->get('nama_lengkap'),
            'status_bayar' => 'belum',
        ]);

        catat_log('Tambah Tagihan Siswa', "Admin menambah tagihan {$item['nama']} untuk siswa ID $siswaId");
        session()->setFlashdata('success', "Tagihan \"{$item['nama']}\" berhasil ditambahkan.");
        return redirect()->to('/admin/pembiayaan/siswa/' . $siswaId);
    }

    public function tambahSemuaTagihan($siswaId)
    {
        $items = $this->itemModel->getAvailableForSiswa($siswaId);

        if (empty($items)) {
            session()->setFlashdata('error', 'Tidak ada item baru yang bisa ditambahkan.');
            return redirect()->back();
        }

        $count = 0;
        foreach ($items as $item) {
            $this->tagihanModel->save([
                'siswa_id'     => $siswaId,
                'item_id'      => $item['id_item'],
                'harga_satuan' => $item['harga'],
                'dibuat_oleh'  => session()->get('nama_lengkap'),
                'status_bayar' => 'belum',
            ]);
            $count++;
        }

        catat_log('Tambah Semua Tagihan', "Admin menambah $count tagihan untuk siswa ID $siswaId");
        session()->setFlashdata('success', "$count tagihan berhasil ditambahkan.");
        return redirect()->to('/admin/pembiayaan/siswa/' . $siswaId);
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

        $this->tagihanModel->delete($idTagihan);
        catat_log('Hapus Tagihan Siswa', "Admin menghapus tagihan ID $idTagihan dari siswa ID $siswaId");
        session()->setFlashdata('success', 'Tagihan berhasil dihapus.');
        return redirect()->to('/admin/pembiayaan/siswa/' . $siswaId);
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
            'siswa'         => $siswa,
            'tagihan'       => $tagihan,
            'totalTagihan'  => $totalTagihan,
            'totalLunas'    => $totalLunas,
            'riwayatBayar'  => $riwayatBayar,
        ], 'kuitansi_' . $siswa['no_pendaftaran'] . '.pdf');
    }
}
