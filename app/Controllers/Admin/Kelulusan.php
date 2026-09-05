<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SiswaModel;

class Kelulusan extends BaseController
{
    protected $siswaModel;

    public function __construct()
    {
        $this->siswaModel = new SiswaModel();
    }

    public function index()
    {
        $search = $this->request->getGet('search');
        $status = $this->request->getGet('status');

        $activeTh = $this->siswaModel->getActiveThPelajaran();
        $selectedTh = $this->request->getGet('th_pelajaran') ?? $activeTh;

        $builder = $this->siswaModel->select('*');
        if ($selectedTh !== 'all') {
            $builder->where('th_pelajaran', $selectedTh);
        }

        if (!empty($search)) {
            $builder->groupStart()
                ->like('nama_lengkap', $search)
                ->orLike('no_pendaftaran', $search)
                ->orLike('nisn', $search)
                ->groupEnd();
        }

        if (!empty($status)) {
            $builder->where('status_lulus', $status);
        }

        // Hitung statistik pendaftar untuk tahun yang dipilih
        $countQuery = function() use ($selectedTh) {
            $m = new SiswaModel();
            if ($selectedTh !== 'all') {
                $m->where('th_pelajaran', $selectedTh);
            }
            return $m;
        };

        $totalAll    = $countQuery()->countAllResults();
        $totalLulus  = $countQuery()->where('status_lulus', 'Lulus')->countAllResults();
        $totalTl     = $countQuery()->where('status_lulus', 'Tidak Lulus')->countAllResults();
        $totalPending = $countQuery()->groupStart()
            ->where('status_lulus', 'Pending')
            ->orWhere('status_lulus IS NULL')
            ->orWhere('status_lulus', '')
            ->groupEnd()->countAllResults();

        $data = [
            'siswa'        => $builder->orderBy('id_siswa', 'DESC')->paginate(20),
            'pager'        => $this->siswaModel->pager,
            'search'       => $search,
            'status'       => $status,
            'totalAll'     => $totalAll,
            'totalLulus'   => $totalLulus,
            'totalTl'      => $totalTl,
            'totalPending' => $totalPending,
            'selectedTh'   => $selectedTh,
            'activeTh'     => $activeTh,
        ];

        return view('admin/kelulusan/index', $data);
    }

    public function update($id)
    {
        $status = $this->request->getPost('status_lulus'); // Lulus, Tidak Lulus, Pending

        // Validasi Whitelist Status (Kekurangan Analisa 6)
        $allowedStatus = ['Lulus', 'Tidak Lulus', 'Pending'];
        if (!in_array($status, $allowedStatus)) {
            session()->setFlashdata('error', 'Status kelulusan tidak valid.');
            return redirect()->back();
        }

        if ($this->siswaModel->update($id, ['status_lulus' => $status])) {
            session()->setFlashdata('success', 'Status kelulusan berhasil diperbarui.');
        } else {
            session()->setFlashdata('error', 'Gagal memperbarui status.');
        }

        return redirect()->back();
    }

    public function bulkUpdate()
    {
        $ids = $this->request->getPost('ids');
        $status = $this->request->getPost('status_lulus');

        if (empty($ids) || empty($status)) {
            session()->setFlashdata('error', 'Pilih data dan status terlebih dahulu.');
            return redirect()->back();
        }

        // Validasi Whitelist Status (Kekurangan Analisa 6)
        $allowedStatus = ['Lulus', 'Tidak Lulus', 'Pending'];
        if (!in_array($status, $allowedStatus)) {
            session()->setFlashdata('error', 'Status kelulusan tidak valid.');
            return redirect()->back();
        }

        $idArray = explode(',', $ids);

        // Memecahkan N+1 Query: Update semua row terkait secara serentak dalam 1 Query DB
        $db = \Config\Database::connect();
        $builder = $db->table('tbl_siswa');

        $builder->whereIn('id_siswa', $idArray);
        $builder->set('status_lulus', $status);
        $updated = $builder->update();

        if ($updated) {
            $count = count($idArray);
            session()->setFlashdata('success', "$count data berhasil diperbarui.");
        } else {
            session()->setFlashdata('error', "Gagal memperbarui sekumpulan data.");
        }

        return redirect()->back();
    }
}
