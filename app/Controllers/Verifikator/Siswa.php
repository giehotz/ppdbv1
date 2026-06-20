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
        $createdIds = session()->get('verifikator_created_students') ?? [];
        $siswaList = [];
        if (!empty($createdIds)) {
            $siswaList = $this->siswaModel
                ->whereIn('id_siswa', $createdIds)
                ->orderBy('tgl_siswa', 'DESC')
                ->findAll();
            foreach ($siswaList as &$s) {
                $cd = $this->siswaModel->calculateCompletionPercentage($s);
                $s['kelengkapan'] = $cd['percentage'];
            }
        }
        return view('verifikator/siswa/create', ['siswaList' => $siswaList]);
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
            'no_hp_siswa' => $this->request->getPost('no_hp'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'tgl_siswa' => date('Y-m-d H:i:s'),
            'status_verifikasi' => 'Menunggu'
        ];

        $insertId = $siswaModel->skipValidation(true)->insert($data);
        $no_pendaftaran = '';

        if (!$insertId) {
            $db->transRollback();
            $session->setFlashdata('error', 'Registrasi gagal saat menyimpan ke database.');
            return redirect()->to('/verifikator/siswa/create')->withInput();
        }

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
            $plainPassword = $this->request->getPost('password');
            session()->set('siswa_pwd_' . $insertId, $plainPassword);
            $createdIds = session()->get('verifikator_created_students') ?? [];
            $createdIds[] = $insertId;
            session()->set('verifikator_created_students', $createdIds);
            catat_log('Pendaftaran Offline', 'Verifikator ' . session()->get('nama_lengkap') . ' mendaftarkan siswa: ' . $this->request->getPost('nama_lengkap'));
            $session->setFlashdata('success', 'Akun siswa berhasil dibuat!');
            return redirect()->to('/verifikator/siswa/create');
        }
    }

    public function biodata($id)
    {
        $siswa = $this->siswaModel->find($id);
        if (!$siswa) {
            session()->setFlashdata('error', 'Data siswa tidak ditemukan.');
            return redirect()->to('/verifikator/siswa');
        }

        $db = \Config\Database::connect();
        $penghasilan = $db->table('tbl_penghasilan')->orderBy('urutan', 'ASC')->get()->getResultArray();
        $tblWebModel = new \App\Models\TblWebModel();
        $web = $tblWebModel->find(1);

        $berkasModel = new \App\Models\BerkasModel();
        $berkas = $berkasModel->where('id_siswa', $id)->findAll();
        $uploadedBerkas = [];
        foreach ($berkas as $item) {
            $uploadedBerkas[$item['jenis_berkas']] = $item;
        }

        $completionData = $this->siswaModel->calculateCompletionPercentage($siswa);

        $data = [
            'layout' => 'layouts/verifikator',
            'formAction' => '/verifikator/siswa/biodataStore/' . $id,
            'isVerifikator' => true,
            'berkasUploadUrl' => '/verifikator/siswa/berkasUpload/' . $id,
            'berkasDeleteUrl' => '/verifikator/siswa/berkasDelete/',
            'siswa' => $siswa,
            'penghasilan' => $penghasilan,
            'web' => $web,
            'completionPercentage' => $completionData['percentage'],
            'incompleteFields' => $completionData['incomplete'],
            'requiredDocs' => [
                'kk' => 'Kartu Keluarga (KK)',
                'akte' => 'Akte Kelahiran',
                'ijazah' => 'Ijazah/SKHUN',
                'foto' => 'Pas Foto 3x4',
                'ktp_ortu' => 'KTP Orang Tua',
            ],
            'uploadedBerkas' => $uploadedBerkas,
        ];

        return view('siswa/biodata/index', $data);
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
            'jk' => 'required|in_list[L,P]',
            'agama' => 'required',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'nik' => $this->request->getPost('nik'),
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'jk' => $this->request->getPost('jk'),
            'tempat_lahir' => $this->request->getPost('tempat_lahir'),
            'tgl_lahir' => $this->request->getPost('tgl_lahir'),
            'agama' => $this->request->getPost('agama'),
            'status_keluarga' => $this->request->getPost('status_keluarga'),
            'anak_ke' => $this->request->getPost('anak_ke'),
            'jml_saudara' => $this->request->getPost('jml_saudara'),
            'hobi' => $this->request->getPost('hobi'),
            'cita' => $this->request->getPost('cita'),
            'paud' => $this->request->getPost('paud'),
            'tk' => $this->request->getPost('tk'),
            'email' => $this->request->getPost('email'),
            'no_hp_siswa' => $this->request->getPost('no_hp_siswa'),
            'no_kk' => $this->request->getPost('no_kk'),
            'kepala_keluarga' => $this->request->getPost('kepala_keluarga'),
            'alamat_siswa' => $this->request->getPost('alamat_siswa'),
            'prov' => $this->request->getPost('prov'),
            'kab' => $this->request->getPost('kab'),
            'kec' => $this->request->getPost('kec'),
            'desa' => $this->request->getPost('desa'),
            'kode_pos' => $this->request->getPost('kode_pos'),
            'jenis_tinggal' => $this->request->getPost('jenis_tinggal'),
            'jarak' => $this->request->getPost('jarak'),
            'trans' => $this->request->getPost('trans'),
            'jalur_pendaftaran' => $this->request->getPost('jalur_pendaftaran'),
            'nama_ayah' => $this->request->getPost('nama_ayah'),
            'status_ayah' => $this->request->getPost('status_ayah'),
            'nik_ayah' => $this->request->getPost('nik_ayah'),
            'tempat_lahir_ayah' => $this->request->getPost('tempat_lahir_ayah'),
            'tgl_lahir_ayah' => $this->request->getPost('tgl_lahir_ayah'),
            'th_lahir_ayah' => $this->request->getPost('th_lahir_ayah'),
            'pdd_ayah' => $this->request->getPost('pdd_ayah'),
            'pekerjaan_ayah' => $this->request->getPost('pekerjaan_ayah'),
            'penghasilan_ayah' => $this->request->getPost('penghasilan_ayah'),
            'nama_ibu' => $this->request->getPost('nama_ibu'),
            'status_ibu' => $this->request->getPost('status_ibu'),
            'nik_ibu' => $this->request->getPost('nik_ibu'),
            'tempat_lahir_ibu' => $this->request->getPost('tempat_lahir_ibu'),
            'tgl_lahir_ibu' => $this->request->getPost('tgl_lahir_ibu'),
            'th_lahir_ibu' => $this->request->getPost('th_lahir_ibu'),
            'pdd_ibu' => $this->request->getPost('pdd_ibu'),
            'pekerjaan_ibu' => $this->request->getPost('pekerjaan_ibu'),
            'penghasilan_ibu' => $this->request->getPost('penghasilan_ibu'),
            'nama_wali' => $this->request->getPost('nama_wali'),
            'nik_wali' => $this->request->getPost('nik_wali'),
            'th_lahir_wali' => $this->request->getPost('th_lahir_wali'),
            'pdd_wali' => $this->request->getPost('pdd_wali'),
            'pekerjaan_wali' => $this->request->getPost('pekerjaan_wali'),
            'penghasilan_wali' => $this->request->getPost('penghasilan_wali'),
            'no_hp_ortu' => $this->request->getPost('no_hp_ortu'),
            'nama_sekolah' => $this->request->getPost('nama_sekolah'),
            'npsn_sekolah' => $this->request->getPost('npsn_sekolah'),
            'jenjang_sekolah' => $this->request->getPost('jenjang_sekolah'),
            'komp_ahli' => $this->request->getPost('komp_ahli'),
            'status_sekolah' => $this->request->getPost('status_sekolah'),
            'lokasi_sekolah' => $this->request->getPost('lokasi_sekolah'),
            'no_kks' => $this->request->getPost('no_kks'),
            'no_pkh' => $this->request->getPost('no_pkh'),
            'no_kip' => $this->request->getPost('no_kip'),
        ];

        $this->siswaModel->update($id, $data);
        catat_log('Update Biodata (Verifikator)', "Verifikator memperbarui biodata siswa ID $id");

        if ($this->request->getPost('finish_skip')) {
            session()->setFlashdata('success', 'Biodata berhasil disimpan.');
            return redirect()->to('/verifikator/siswa/cetak-akun/' . $id);
        }

        session()->setFlashdata('success', 'Biodata berhasil disimpan. Silakan unggah berkas persyaratan.');
        return redirect()->to('/verifikator/siswa/biodata/' . $id)->with('tab', 'berkas');
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
        $namaClean = preg_replace('/[^a-zA-Z0-9_-]/', '_', str_replace(' ', '_', $siswa['nama_lengkap']));
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

    public function berkasDelete($idBerkas)
    {
        $berkasModel = new \App\Models\BerkasModel();
        
        $berkas = $berkasModel->find($idBerkas);
        if (!$berkas) {
            session()->setFlashdata('error', 'Berkas tidak ditemukan.');
            return redirect()->back();
        }

        $idSiswa = $berkas['id_siswa'];
        $siswa = $this->siswaModel->find($idSiswa);
        $nisn = $siswa['nisn'];

        $safeNisn = preg_replace('/[^a-zA-Z0-9_-]/', '', $nisn);
        $baseDir = realpath(FCPATH . 'uploads/berkas/') ?: FCPATH . 'uploads/berkas/';
        $filePath = realpath(FCPATH . 'uploads/berkas/' . $safeNisn . '/' . $berkas['nama_file']);
        
        if ($filePath !== false && strpos($filePath, $baseDir) === 0 && file_exists($filePath)) {
            unlink($filePath);
        }

        $berkasModel->delete($idBerkas);
        session()->setFlashdata('success', 'Berkas berhasil dihapus.');
        return redirect()->back()->with('tab', 'berkas');
    }

    public function resetPassword($id)
    {
        $newPassword = $this->request->getPost('new_password');
        if (empty($newPassword)) {
            $newPassword = bin2hex(random_bytes(6));
        }

        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $student = $this->siswaModel->find($id);

        if ($student && $this->siswaModel->update($id, ['password' => $hashedPassword])) {
            $printData = [
                'nama' => $student['nama_lengkap'],
                'nisn' => $student['nisn'] ?? '-',
                'no_daftar' => $student['no_pendaftaran'],
                'password' => $newPassword,
                'tanggal' => date('d-m-Y H:i:s')
            ];
            session()->setFlashdata('success', 'Password siswa berhasil direset. Menyiapkan dokumen cetak...');
            session()->setFlashdata('print_password', $printData);
        } else {
            session()->setFlashdata('error', 'Gagal mereset password siswa.');
        }

        return redirect()->back();
    }

    public function cetakPassword()
    {
        $printData = session()->getFlashdata('print_password');

        if (!$printData) {
            return redirect()->to(base_url('verifikator/siswa'))->with('error', 'Data password tidak ditemukan atau sesi cetak telah kedaluwarsa.');
        }

        return view('admin/siswa/cetak_password', ['data' => $printData]);
    }

    public function cetakAkun($id)
    {
        helper('kop');
        $siswa = $this->siswaModel->find($id);
        if (!$siswa) {
            session()->setFlashdata('error', 'Data siswa tidak ditemukan.');
            return redirect()->to('/verifikator/siswa');
        }

        $sessionPwdKey = 'siswa_pwd_' . $id;
        $siswa['password_asli'] = session()->get($sessionPwdKey);

        return view('verifikator/siswa/cetak_akun', ['siswa' => $siswa]);
    }

    public function delete($id)
    {
        $siswa = $this->siswaModel->find($id);
        if (!$siswa) {
            session()->setFlashdata('error', 'Data siswa tidak ditemukan.');
            return redirect()->to('/verifikator/siswa');
        }

        $db = \Config\Database::connect();
        $db->transStart();

        // 1. Delete associated berkas files
        $berkasModel = new \App\Models\BerkasModel();
        $berkasList = $berkasModel->where('id_siswa', $id)->findAll();
        
        $nisn = $siswa['nisn'];
        $safeNisn = preg_replace('/[^a-zA-Z0-9_-]/', '', $nisn);
        $baseDir = realpath(FCPATH . 'uploads/berkas/') ?: FCPATH . 'uploads/berkas/';
        
        foreach ($berkasList as $berkas) {
            $filePath = realpath(FCPATH . 'uploads/berkas/' . $safeNisn . '/' . $berkas['nama_file']);
            if ($filePath !== false && strpos($filePath, $baseDir) === 0 && file_exists($filePath)) {
                unlink($filePath);
            }
        }
        
        // Also remove the student's directory if empty
        $studentDir = FCPATH . 'uploads/berkas/' . $safeNisn;
        if (is_dir($studentDir)) {
            $files = array_diff(scandir($studentDir), ['.', '..']);
            if (empty($files)) {
                rmdir($studentDir);
            }
        }

        // 2. Delete from database (foreign keys constraints should handle related data, but we explicitly delete to be safe)
        $berkasModel->where('id_siswa', $id)->delete();
        $db->table('tbl_verifikasi')->where('id_siswa', $id)->delete();
        $db->table('tbl_pesan')->where('id_siswa', $id)->delete();
        $db->table('tbl_unlock_request')->where('id_siswa', $id)->delete();
        
        $this->siswaModel->delete($id);

        $db->transComplete();

        if ($db->transStatus() === false) {
            session()->setFlashdata('error', 'Gagal menghapus data siswa. Terjadi kesalahan pada database.');
            return redirect()->to('/verifikator/siswa/detail/' . $id);
        }

        catat_log('Hapus Siswa', 'Verifikator ' . session()->get('nama_lengkap') . ' menghapus permanen siswa: ' . $siswa['nama_lengkap']);
        
        session()->setFlashdata('success', 'Data siswa beserta seluruh berkasnya berhasil dihapus secara permanen.');
        return redirect()->to('/verifikator/siswa');
    }
}
