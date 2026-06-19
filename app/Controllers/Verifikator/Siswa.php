<?php

namespace App\Controllers\Verifikator;

use App\Controllers\BaseController;
use App\Models\SiswaModel;

class Siswa extends BaseController
{
    protected $siswaModel;

    public function __construct()
    {
        $this->siswaModel = new SiswaModel();
    }

    public function index()
    {
        $search = $this->request->getGet('search');

        $siswaList = $this->siswaModel->getStudents($search);

        // Add completion percentage
        foreach ($siswaList as &$s) {
            $completionData = $this->siswaModel->calculateCompletionPercentage($s);
            $s['kelengkapan'] = $completionData['percentage'];
        }

        $data = [
            'siswa' => $siswaList,
            'pager' => $this->siswaModel->pager,
            'search' => $search
        ];

        return view('verifikator/siswa/index', $data);
    }

    public function detail($id)
    {
        // Use getStudentDetail() to include verification details (JOIN)
        $student = $this->siswaModel->getStudentDetail($id);

        if (!$student) {
            session()->setFlashdata('error', 'Data siswa tidak ditemukan.');
            return redirect()->to('/verifikator/siswa');
        }

        $completionData = $this->siswaModel->calculateCompletionPercentage($student);
        $student['kelengkapan'] = $completionData['percentage'];

        $data = [
            'siswa' => $student
        ];

        return view('verifikator/siswa/detail', $data);
    }

    public function verify($id)
    {
        $status = $this->request->getPost('status');
        $catatan = $this->request->getPost('catatan');

        $verifikasiModel = new \App\Models\VerifikasiModel();

        // Check if verification record exists
        $existing = $verifikasiModel->where('id_siswa', $id)->first();

        $data = [
            'id_siswa' => $id,
            'ket' => $status, // Map status to 'ket'
            'isi' => $catatan, // Map catatan to 'isi'
            'tgl_verifikasi' => date('Y-m-d H:i:s'),
            'verifikator' => session()->get('nama_lengkap')
        ];

        if ($existing) {
            $verifikasiModel->update($existing['id_verifikasi'], $data);
        } else {
            $verifikasiModel->insert($data);
        }

        // Update student verification status
        $this->siswaModel->update($id, [
            'status_verifikasi' => $status
        ]);
        
        $siswaInfo = $this->siswaModel->find($id);
        $namaSiswa = $siswaInfo ? $siswaInfo['nama_lengkap'] : "ID {$id}";
        catat_log('Verifikasi Siswa', "Mengubah status verifikasi untuk $namaSiswa menjadi $status");

        session()->setFlashdata('success', 'Status verifikasi berhasil diperbarui.');
        return redirect()->to('/verifikator/siswa/detail/' . $id);
    }

    public function cetak($id)
    {
        $student = $this->siswaModel->find($id);

        if (!$student) {
            session()->setFlashdata('error', 'Data siswa tidak ditemukan.');
            return redirect()->to('/verifikator/siswa');
        }

        $webModel = new \App\Models\TblWebModel();

        $data = [
            'siswa' => $student,
            'web' => $webModel->find(1)
        ];

        return view('siswa/cetak_formulir', $data);
    }
    // --- FUNGSI PENDAFTARAN OFFLINE OLEH VERIFIKATOR ---

    public function create()
    {
        return view('verifikator/siswa/create');
    }

    public function store()
    {
        $siswaModel = new SiswaModel();
        $session = session();

        // Validation rules
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nisn' => 'required|numeric|min_length[10]|max_length[10]|is_unique[tbl_siswa.nisn]',
            'nama_lengkap' => 'required|min_length[3]',
            'email' => 'required|valid_email|is_unique[tbl_siswa.email]',
            'no_hp' => 'required|numeric',
            'password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            $session->setFlashdata('errors', $validation->getErrors());
            return redirect()->to('/verifikator/siswa/create')->withInput();
        }

        $db = \Config\Database::connect();
        $db->transStart();

        // Insert initial data dengan temporary no_pendaftaran
        $data = [
            'no_pendaftaran' => 'TEMP-' . uniqid(),
            'nisn' => $this->request->getPost('nisn'),
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'email' => $this->request->getPost('email'),
            'no_hp' => $this->request->getPost('no_hp'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'tgl_siswa' => date('Y-m-d H:i:s'),
            'status_verifikasi' => 'Menunggu'
        ];

        $insertId = $siswaModel->insert($data);
        $no_pendaftaran = '';

        if ($insertId) {
            $tblWebModel = new \App\Models\TblWebModel();
            $web = $tblWebModel->find(1);
            $format = !empty($web['format_no_daftar']) ? $web['format_no_daftar'] : 'PPDB-{TAHUN}-{URUT}';
            
            $year = !empty($web['th_pelajaran']) ? substr($web['th_pelajaran'], 0, 4) : date('Y');
            $month = date('m');
            $newNumber = str_pad($insertId, 4, '0', STR_PAD_LEFT);
            
            $no_pendaftaran = str_replace(
                ['{TAHUN}', '{BULAN}', '{URUT}'], 
                [$year, $month, $newNumber], 
                $format
            );

            $siswaModel->update($insertId, ['no_pendaftaran' => $no_pendaftaran]);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            $session->setFlashdata('error', 'Registrasi gagal karena kendala sistem.');
            return redirect()->to('/verifikator/siswa/create')->withInput();
        } else {
            catat_log('Pendaftaran Offline', 'Verifikator ' . session()->get('nama_lengkap') . ' mendaftarkan siswa: ' . $this->request->getPost('nama_lengkap'));
            $session->setFlashdata('success', 'Akun siswa berhasil dibuat! Silakan lengkapi biodata.');
            return redirect()->to('/verifikator/siswa/biodata/' . $insertId);
        }
    }

    public function biodata($id)
    {
        $siswa = $this->siswaModel->find($id);
        if (!$siswa) {
            session()->setFlashdata('error', 'Data siswa tidak ditemukan.');
            return redirect()->to('/verifikator/siswa');
        }

        $data = [
            'siswa' => $siswa,
            'provinsi' => $this->siswaModel->getProvinsi()
        ];

        return view('verifikator/siswa/biodata', $data);
    }

    public function biodataStore($id)
    {
        $siswa = $this->siswaModel->find($id);
        if (!$siswa) {
            session()->setFlashdata('error', 'Data siswa tidak ditemukan.');
            return redirect()->to('/verifikator/siswa');
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'nik' => "required|numeric|min_length[16]|max_length[16]|is_unique[tbl_siswa.nik,id_siswa,{$id}]",
            'tempat_lahir' => 'required',
            'tgl_lahir' => 'required|valid_date',
            'jenis_kelamin' => 'required|in_list[Laki-laki,Perempuan]',
            'agama' => 'required',
            'asal_sekolah' => 'required'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'nik' => $this->request->getPost('nik'),
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'tempat_lahir' => $this->request->getPost('tempat_lahir'),
            'tgl_lahir' => $this->request->getPost('tgl_lahir'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'agama' => $this->request->getPost('agama'),
            'asal_sekolah' => $this->request->getPost('asal_sekolah'),
            'no_hp' => $this->request->getPost('no_hp'),
            'alamat_lengkap' => $this->request->getPost('alamat_lengkap'),
            'id_provinsi' => $this->request->getPost('provinsi'),
            'id_kabupaten' => $this->request->getPost('kab_kota'),
            'id_kecamatan' => $this->request->getPost('kecamatan'),
            'id_desa' => $this->request->getPost('desa'),
            'nama_ayah' => $this->request->getPost('nama_ayah'),
            'pekerjaan_ayah' => $this->request->getPost('pekerjaan_ayah'),
            'no_hp_ayah' => $this->request->getPost('no_hp_ayah'),
            'nama_ibu' => $this->request->getPost('nama_ibu'),
            'pekerjaan_ibu' => $this->request->getPost('pekerjaan_ibu'),
            'no_hp_ibu' => $this->request->getPost('no_hp_ibu'),
            'nama_wali' => $this->request->getPost('nama_wali'),
            'pekerjaan_wali' => $this->request->getPost('pekerjaan_wali'),
            'no_hp_wali' => $this->request->getPost('no_hp_wali'),
        ];

        $this->siswaModel->update($id, $data);
        catat_log('Update Biodata (Verifikator)', "Verifikator memperbarui biodata siswa ID $id");

        if ($this->request->getPost('finish_skip')) {
            session()->setFlashdata('success', 'Biodata berhasil disimpan.');
            return redirect()->to('/verifikator/siswa/cetak-akun/' . $id);
        }

        session()->setFlashdata('success', 'Biodata berhasil disimpan. Silakan unggah berkas persyaratan.');
        return redirect()->to('/verifikator/siswa/berkas/' . $id);
    }

    public function berkas($id)
    {
        $siswa = $this->siswaModel->find($id);
        if (!$siswa) {
            session()->setFlashdata('error', 'Data siswa tidak ditemukan.');
            return redirect()->to('/verifikator/siswa');
        }

        $berkasModel = new \App\Models\BerkasModel();
        $berkas = $berkasModel->where('id_siswa', $id)->findAll();

        $requiredDocs = [
            'kk' => 'Kartu Keluarga (KK)',
            'akte' => 'Akte Kelahiran',
            'ijazah' => 'Ijazah/SKHUN',
            'foto' => 'Pas Foto 3x4',
            'ktp_ortu' => 'KTP Orang Tua',
        ];

        $uploadedBerkas = [];
        foreach ($berkas as $item) {
            $uploadedBerkas[$item['jenis_berkas']] = $item;
        }

        $data = [
            'siswa' => $siswa,
            'requiredDocs' => $requiredDocs,
            'uploadedBerkas' => $uploadedBerkas
        ];

        return view('verifikator/siswa/berkas', $data);
    }

    public function berkasUpload($id)
    {
        $berkasModel = new \App\Models\BerkasModel();
        $siswa = $this->siswaModel->find($id);
        
        $jenisBerkas = $this->request->getPost('jenis_berkas');
        $file = $this->request->getFile('file_berkas');

        if (!$file->isValid()) {
            session()->setFlashdata('error', 'File tidak valid.');
            return redirect()->back();
        }

        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'];
        if (!in_array($file->getMimeType(), $allowedTypes)) {
            session()->setFlashdata('error', 'Hanya file JPG, PNG, atau PDF yang diperbolehkan.');
            return redirect()->back();
        }

        if ($file->getSize() > 2048000) {
            session()->setFlashdata('error', 'Ukuran file maksimal 2MB.');
            return redirect()->back();
        }

        $nisn = $siswa['nisn'];
        $uploadPath = FCPATH . 'uploads/berkas/' . $nisn . '/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $extension = strtolower($file->getExtension());
        $jenisLabel = strtoupper($jenisBerkas);
        $namaClean = str_replace(' ', '_', $siswa['nama_lengkap']);
        $fileName = $jenisLabel . '_' . $namaClean . '_' . $nisn . '.' . $extension;

        if ($file->move($uploadPath, $fileName)) {
            $existing = $berkasModel->where('id_siswa', $id)->where('jenis_berkas', $jenisBerkas)->first();

            if ($existing) {
                $oldFilePath = FCPATH . 'uploads/berkas/' . $nisn . '/' . $existing['nama_file'];
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
                $berkasModel->update($existing['id_berkas'], [
                    'nama_file' => $fileName,
                    'path_file' => 'uploads/berkas/' . $nisn . '/' . $fileName,
                    'ukuran_file' => $file->getSize(),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            } else {
                $berkasModel->insert([
                    'id_siswa' => $id,
                    'jenis_berkas' => $jenisBerkas,
                    'nama_file' => $fileName,
                    'path_file' => 'uploads/berkas/' . $nisn . '/' . $fileName,
                    'ukuran_file' => $file->getSize(),
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }
            session()->setFlashdata('success', 'Berkas berhasil diupload.');
        } else {
            session()->setFlashdata('error', 'Gagal mengupload berkas.');
        }

        return redirect()->back();
    }

    public function berkasDelete($id)
    {
        $idBerkas = $this->request->getPost('id_berkas');
        $berkasModel = new \App\Models\BerkasModel();
        
        $berkas = $berkasModel->find($idBerkas);
        if (!$berkas || $berkas['id_siswa'] != $id) {
            session()->setFlashdata('error', 'Berkas tidak ditemukan.');
            return redirect()->back();
        }

        $siswa = $this->siswaModel->find($id);
        $nisn = $siswa['nisn'];

        $safeNisn = preg_replace('/[^a-zA-Z0-9_-]/', '', $nisn);
        $baseDir = realpath(FCPATH . 'uploads/berkas/') ?: FCPATH . 'uploads/berkas/';
        $filePath = realpath(FCPATH . 'uploads/berkas/' . $safeNisn . '/' . $berkas['nama_file']);
        
        if ($filePath !== false && strpos($filePath, $baseDir) === 0 && file_exists($filePath)) {
            unlink($filePath);
        }

        $berkasModel->delete($idBerkas);
        session()->setFlashdata('success', 'Berkas berhasil dihapus.');
        return redirect()->back();
    }

    public function cetakAkun($id)
    {
        $siswa = $this->siswaModel->find($id);
        if (!$siswa) {
            session()->setFlashdata('error', 'Data siswa tidak ditemukan.');
            return redirect()->to('/verifikator/siswa');
        }

        return view('verifikator/siswa/cetak_akun', ['siswa' => $siswa]);
    }
}
