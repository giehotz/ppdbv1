<?php

namespace App\Services;

use App\Models\Pindahan\SiswaPindahanModel;
use App\Models\Pindahan\BerkasPindahanModel;
use App\Models\Pindahan\VerifikasiPindahanModel;
use App\Models\TblWebModel;
use Config\PindahanConfig;
use CodeIgniter\HTTP\Files\UploadedFile;

/**
 * PindahanService — Service Layer untuk modul Siswa Pindahan.
 *
 * Mengkonsolidasikan business logic yang sebelumnya duplikat
 * di Siswa, Admin, dan Verifikator Pindahan controllers.
 *
 * @see \App\Controllers\Siswa\Pindahan
 * @see \App\Controllers\Admin\Pindahan
 * @see \App\Controllers\Verifikator\Pindahan
 */
class PindahanService
{
    protected SiswaPindahanModel $pindahanModel;
    protected BerkasPindahanModel $berkasModel;
    protected VerifikasiPindahanModel $verifikasiModel;

    public function __construct(
        ?SiswaPindahanModel $pindahanModel = null,
        ?BerkasPindahanModel $berkasModel = null,
        ?VerifikasiPindahanModel $verifikasiModel = null
    ) {
        $this->pindahanModel   = $pindahanModel ?? new SiswaPindahanModel();
        $this->berkasModel     = $berkasModel ?? new BerkasPindahanModel();
        $this->verifikasiModel = $verifikasiModel ?? new VerifikasiPindahanModel();
    }

    // ─────────────────────────────────────────────────────────────
    // RESOLVE PHOTO URL
    // Sebelumnya duplikat di Admin\Pindahan::resolvePhotoUrl()
    // dan Verifikator\Pindahan::resolvePhotoUrl()
    // ─────────────────────────────────────────────────────────────

    /**
     * Resolve path foto menjadi full URL.
     *
     * @param string|null $fotoPath Relative path foto dari database
     * @return string|null Full URL foto atau null jika kosong
     */
    public function resolvePhotoUrl(?string $fotoPath): ?string
    {
        if (empty($fotoPath)) {
            return null;
        }
        return base_url(ltrim($fotoPath, '/'));
    }

    // ─────────────────────────────────────────────────────────────
    // NORMALISASI JENJANG
    // Sebelumnya di Siswa\Pindahan::normalizeJenjangData()
    // dan inline di Verifikator\Pindahan::biodataStore()
    // ─────────────────────────────────────────────────────────────

    /**
     * Normalisasi jenjang asal + isi grup_jenjang_asal otomatis.
     *
     * @param array $data Data biodata yang berisi field jenjang
     * @return array Data yang sudah dinormalisasi
     */
    public function normalizeJenjangData(array $data): array
    {
        $asal = $data['jenjang_sekolah_asal'] ?? null;

        $normAsal = PindahanConfig::normalizeJenjang($asal);

        if ($normAsal !== null) {
            $data['jenjang_sekolah_asal'] = $normAsal;
            $data['grup_jenjang_asal']    = PindahanConfig::getGrupName($normAsal);
        }

        unset($data['jenjang_error']);

        return $data;
    }

    // ─────────────────────────────────────────────────────────────
    // HITUNG RATA-RATA NILAI
    // Sebelumnya di Siswa\Pindahan::hitungRataRata()
    // dan inline di Verifikator\Pindahan::biodataStore()
    // ─────────────────────────────────────────────────────────────

    /**
     * Hitung rata-rata nilai rapor berdasarkan mapel yang terisi.
     *
     * @param array $data Data biodata yang berisi field nilai
     * @return array Data dengan 'rata_rata_nilai' yang dihitung
     */
    public function hitungRataRata(array $data): array
    {
        $sum   = 0;
        $count = 0;
        foreach (array_keys(PindahanConfig::$mapelRapor) as $field) {
            if (isset($data[$field]) && $data[$field] !== '' && $data[$field] !== null && is_numeric($data[$field])) {
                $sum   += (float) $data[$field];
                $count++;
            }
        }
        if ($count > 0) {
            $data['rata_rata_nilai'] = round($sum / $count, 2);
        }
        return $data;
    }

    // ─────────────────────────────────────────────────────────────
    // SANITASI BIODATA
    // Sebelumnya di Siswa\Pindahan::getSanitizedBiodata()
    // dan sebagian inline di Verifikator\Pindahan::biodataStore()
    // ─────────────────────────────────────────────────────────────

    /**
     * Sanitasi data biodata: hapus field restricted, bersihkan NIK & HP.
     *
     * @param array $data Raw POST data
     * @param array $extraRestricted Field tambahan yang harus dihapus (opsional)
     * @return array Data yang sudah disanitasi
     */
    public function sanitizeBiodata(array $data, array $extraRestricted = []): array
    {
        // Mencegah Mass Assignment — field sistem tidak boleh diubah
        $restrictedFields = [
            'id_pindahan', 'id_siswa', 'no_pendaftaran', 'password', 'last_login',
            'status_verifikasi', 'status_pendaftaran', 'status_berkas', 'status_lulus',
            'status_lulus_kelompok',
            'tgl_verifikasi', 'verified_by', 'catatan_verifikasi',
            'jalur_pendaftaran', 'tgl_pindahan', 'is_checked',
        ];
        $restrictedFields = array_merge($restrictedFields, $extraRestricted);

        foreach ($restrictedFields as $field) {
            if (isset($data[$field])) {
                unset($data[$field]);
            }
        }
        unset($data['csrf_test_name'], $data['csrf_token'], $data['finish_skip']);

        // Nilai wajib tidak boleh nol-ganda / string kosong
        foreach ($data as $key => $val) {
            if ($key !== 'alasan_pindah' && $val === '') {
                $data[$key] = null;
            }
        }

        // Sanitasi NIK
        if (!empty($data['nik'])) {
            $data['nik'] = preg_replace('/[^0-9]/', '', (string) $data['nik']);
        }
        if (!empty($data['nik_ayah'])) {
            $data['nik_ayah'] = preg_replace('/[^0-9]/', '', (string) $data['nik_ayah']);
        }
        if (!empty($data['nik_ibu'])) {
            $data['nik_ibu'] = preg_replace('/[^0-9]/', '', (string) $data['nik_ibu']);
        }
        if (!empty($data['nik_wali'])) {
            $data['nik_wali'] = preg_replace('/[^0-9]/', '', (string) $data['nik_wali']);
        }

        // Sanitasi nomor HP
        foreach (['no_hp_siswa', 'no_hp_ortu'] as $hp) {
            if (!empty($data[$hp])) {
                $data[$hp] = preg_replace('/[^0-9+]/', '', (string) $data[$hp]);
            }
        }

        return $data;
    }

    // ─────────────────────────────────────────────────────────────
    // UPLOAD BERKAS
    // Sebelumnya duplikat di Siswa\Pindahan::uploadBerkas()
    // dan Verifikator\Pindahan::doUploadBerkas()
    // ─────────────────────────────────────────────────────────────

    /**
     * Upload berkas pindahan.
     *
     * @param int          $idPindahan  ID siswa pindahan
     * @param UploadedFile $file        File yang diupload
     * @param string       $jenisBerkas Jenis berkas (lowercase)
     * @param array        $pindahan    Data siswa pindahan (minimal: nisn, nama_lengkap)
     * @return array ['success' => bool, 'message' => string]
     */
    public function doUploadBerkas(int $idPindahan, UploadedFile $file, string $jenisBerkas, array $pindahan): array
    {
        // Validasi jenis berkas
        $allowedJenis = array_keys(BerkasPindahanModel::getJenisBerkasOptions());
        if (!in_array($jenisBerkas, $allowedJenis, true)) {
            return ['success' => false, 'message' => 'Jenis berkas tidak valid.'];
        }

        // Validasi file
        if (!$file->isValid()) {
            return ['success' => false, 'message' => 'File tidak valid atau belum dipilih.'];
        }

        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'];
        if (!in_array($file->getMimeType(), $allowedTypes, true)) {
            return ['success' => false, 'message' => 'Hanya file JPG, PNG, atau PDF yang diperbolehkan.'];
        }

        if ($file->getSize() > 2048000) {
            return ['success' => false, 'message' => 'Ukuran file maksimal 2MB.'];
        }

        $allowedExts = ['jpg', 'jpeg', 'png', 'pdf'];
        if (!in_array(strtolower((string) $file->getExtension()), $allowedExts, true)) {
            return ['success' => false, 'message' => 'Ekstensi file tidak diizinkan.'];
        }

        // Siapkan path upload
        $safeNisn = preg_replace('/[^a-zA-Z0-9_-]/', '', (string) $pindahan['nisn']);
        $uploadPath = FCPATH . 'uploads/berkas/' . $safeNisn . '/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $jenisLabel = strtoupper($jenisBerkas);
        $namaClean = preg_replace('/[^a-zA-Z0-9_-]/', '_', str_replace(' ', '_', (string) $pindahan['nama_lengkap']));
        $fileName = $jenisLabel . '_' . $namaClean . '_' . $safeNisn . '.' . $file->getExtension();
        $pathFile = 'uploads/berkas/' . $safeNisn . '/' . $fileName;

        // Pindahkan file
        if (!$file->move($uploadPath, $fileName)) {
            return ['success' => false, 'message' => 'Gagal mengupload berkas.'];
        }

        // Simpan atau update record di database
        $existing = $this->berkasModel->where('id_pindahan', $idPindahan)
            ->where('jenis_berkas', $jenisBerkas)
            ->first();

        if ($existing) {
            // Hapus file lama
            $oldPath = FCPATH . $existing['path_file'];
            if ($existing['path_file'] && is_file($oldPath)) {
                @unlink($oldPath);
            }
            $this->berkasModel->update($existing['id_berkas_pindahan'], [
                'nama_file'   => $fileName,
                'path_file'   => $pathFile,
                'ukuran_file' => (string) $file->getSize(),
            ]);
        } else {
            $this->berkasModel->insert([
                'id_pindahan' => $idPindahan,
                'jenis_berkas'=> $jenisBerkas,
                'nama_file'   => $fileName,
                'path_file'   => $pathFile,
                'ukuran_file' => (string) $file->getSize(),
            ]);
        }

        // Foto siswa juga disinkronkan ke kolom foto utama
        if ($jenisBerkas === 'foto_siswa') {
            $this->pindahanModel->update($idPindahan, ['foto' => $pathFile]);
        }

        return ['success' => true, 'message' => 'Berkas pindahan berhasil diupload.'];
    }

    // ─────────────────────────────────────────────────────────────
    // DELETE BERKAS
    // Sebelumnya di Siswa\Pindahan::deleteBerkas()
    // dan Verifikator\Pindahan::berkasDelete()
    // ─────────────────────────────────────────────────────────────

    /**
     * Hapus berkas pindahan.
     *
     * @param int      $idBerkas    ID berkas yang akan dihapus
     * @param int|null $idPindahan  ID pindahan untuk ownership check (null = skip check)
     * @return array ['success' => bool, 'message' => string]
     */
    public function doDeleteBerkas(int $idBerkas, ?int $idPindahan = null): array
    {
        $berkas = $this->berkasModel->find($idBerkas);
        if (!$berkas) {
            return ['success' => false, 'message' => 'Berkas tidak ditemukan.'];
        }

        // Ownership check jika idPindahan diberikan
        if ($idPindahan !== null && (int) $berkas['id_pindahan'] !== (int) $idPindahan) {
            return ['success' => false, 'message' => 'Berkas tidak ditemukan.'];
        }

        $this->berkasModel->deleteFileRecord($idBerkas);

        // Jika foto siswa, kosongkan kolom foto utama
        if ($berkas['jenis_berkas'] === 'foto_siswa') {
            $this->pindahanModel->update($berkas['id_pindahan'], ['foto' => null]);
        }

        return ['success' => true, 'message' => 'Berkas berhasil dihapus.'];
    }

    // ─────────────────────────────────────────────────────────────
    // VERIFIKASI
    // Sebelumnya duplikat di Admin\Pindahan::verify()
    // dan Verifikator\Pindahan::verify()
    // ─────────────────────────────────────────────────────────────

    /**
     * Proses verifikasi siswa pindahan.
     *
     * @param int    $id        ID siswa pindahan
     * @param string $status    Status verifikasi (Terverifikasi|Menunggu|Ditolak)
     * @param string $catatan   Catatan verifikasi
     * @param string $actorName Nama pelaku verifikasi
     * @param string $actorRole Role default jika nama kosong ('Admin' atau 'Verifikator')
     * @return array ['success' => bool, 'message' => string]
     */
    public function doVerify(int $id, string $status, ?string $catatan, string $actorName, string $actorRole = 'Admin'): array
    {
        if (!in_array($status, ['Terverifikasi', 'Menunggu', 'Ditolak'], true)) {
            return ['success' => false, 'message' => 'Status verifikasi tidak valid.'];
        }

        $verifikatorName = $actorName ?: $actorRole;

        $this->verifikasiModel->insertLog($id, [
            'isi'         => $catatan,
            'ket'         => $status,
            'verifikator' => $verifikatorName,
        ]);

        $updateData = [
            'status_verifikasi' => $status,
            'tgl_verifikasi'    => date('Y-m-d H:i:s'),
            'verified_by'       => session()->get('id_user') ?? null,
            'catatan_verifikasi'=> $catatan,
        ];

        // Jika Ditolak, buka kembali form agar bisa diperbaiki
        if ($status === 'Ditolak') {
            $updateData['status_pendaftaran'] = '';
        }

        $this->pindahanModel->update($id, $updateData);

        $siswaInfo = $this->pindahanModel->find($id);
        $namaSiswa = $siswaInfo ? $siswaInfo['nama_lengkap'] : "ID {$id}";
        catat_log('Verifikasi Siswa Pindahan', "Mengubah status verifikasi $namaSiswa menjadi $status");

        return ['success' => true, 'message' => 'Status verifikasi berhasil diperbarui.'];
    }

    // ─────────────────────────────────────────────────────────────
    // VERIFIKASI MASSAL
    // Sebelumnya inline di Admin\Pindahan::bulkVerify()
    // ─────────────────────────────────────────────────────────────

    /**
     * Verifikasi massal beberapa siswa pindahan.
     *
     * @param int[]  $ids       Daftar ID siswa pindahan
     * @param string $status    Status verifikasi (Terverifikasi|Menunggu|Ditolak)
     * @param string $catatan   Catatan verifikasi massal
     * @param string $actorName Nama pelaku verifikasi
     * @return array ['success' => bool, 'message' => string, 'count' => int]
     */
    public function doBulkVerify(array $ids, string $status, string $catatan, string $actorName): array
    {
        $ids = array_filter(array_map('intval', $ids));

        if (empty($ids) || !in_array($status, SiswaPindahanModel::ALL_STATUS, true)) {
            return ['success' => false, 'message' => 'Data atau status verifikasi tidak valid.', 'count' => 0];
        }

        $count = 0;
        foreach ($ids as $id) {
            $this->verifikasiModel->insertLog($id, [
                'isi'         => $catatan,
                'ket'         => $status,
                'verifikator' => $actorName,
            ]);

            $updateData = [
                'status_verifikasi' => $status,
                'tgl_verifikasi'    => date('Y-m-d H:i:s'),
                'catatan_verifikasi'=> $catatan,
            ];
            if ($status === SiswaPindahanModel::STATUS_DITOLAK) {
                $updateData['status_pendaftaran'] = '';
            }
            $this->pindahanModel->update($id, $updateData);
            $count++;
        }

        return [
            'success' => true,
            'message' => "Berhasil memperbarui status verifikasi $count siswa menjadi $status.",
            'count'   => $count,
        ];
    }

    // ─────────────────────────────────────────────────────────────
    // PENDAFTARAN OFFLINE
    // Sebelumnya inline di Verifikator\Pindahan::store()
    // ─────────────────────────────────────────────────────────────

    /**
     * Daftarkan siswa pindahan baru secara offline (oleh Verifikator).
     *
     * @param array $post Data POST yang sudah tervalidasi oleh controller
     * @return array ['success' => bool, 'message' => string, 'insertId' => int, 'noPendaftaran' => string, 'plainPassword' => string]
     */
    public function createOffline(array $post): array
    {
        $db = \Config\Database::connect();

        $webModel     = new TblWebModel();
        $web          = $webModel->find(1) ?? [];
        $thPelajaran  = !empty($web['th_pelajaran']) ? $web['th_pelajaran'] : '2025/2026';

        $jenjangAsal = PindahanConfig::normalizeJenjang($post['jenjang_sekolah_asal'] ?? null);

        if ($jenjangAsal === null) {
            return [
                'success'    => false,
                'message'    => 'Jenjang sekolah asal wajib diisi.',
                'insertId'   => 0,
                'noPendaftaran' => '',
                'plainPassword' => '',
            ];
        }

        $cleanPhone = preg_replace('/[^0-9]/', '', (string) ($post['no_hp'] ?? ''));

        $db->transStart();

        $data = [
            'no_pendaftaran'         => 'TEMP-' . uniqid(),
            'th_pelajaran'           => $thPelajaran,
            'nisn'                   => $post['nisn'] ?? null,
            'nama_lengkap'           => $post['nama_lengkap'] ?? null,
            'email'                  => $post['email'] ?? null,
            'no_hp_siswa'            => $cleanPhone,
            'password'               => password_hash((string) ($post['password'] ?? ''), PASSWORD_DEFAULT),
            'jalur_pendaftaran'      => 'pindahan',
            'jenjang_sekolah_asal'   => $jenjangAsal,
            'grup_jenjang_asal'      => PindahanConfig::getGrupName($jenjangAsal),
            'tgl_pindahan'           => date('Y-m-d H:i:s'),
            'status_verifikasi'      => SiswaPindahanModel::STATUS_MENUNGGU,
            'status_pendaftaran'     => 'Draft',
        ];

        $insertId = $this->pindahanModel->skipValidation(true)->insert($data);
        if (!$insertId) {
            $db->transRollback();
            return [
                'success'    => false,
                'message'    => 'Registrasi gagal saat menyimpan ke database.',
                'insertId'   => 0,
                'noPendaftaran' => '',
                'plainPassword' => '',
            ];
        }

        $format = !empty($web['format_no_daftar']) ? $web['format_no_daftar'] : 'PPDB-{TAHUN}-{URUT}';
        $year   = !empty($web['th_pelajaran']) ? substr($web['th_pelajaran'], 0, 4) : date('Y');
        $month  = date('m');
        $newNumber = str_pad((string) $insertId, 4, '0', STR_PAD_LEFT);
        $noPendaftaran = str_replace(['{TAHUN}', '{BULAN}', '{URUT}'], [$year, $month, $newNumber], $format);

        $this->pindahanModel->update($insertId, ['no_pendaftaran' => $noPendaftaran]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return [
                'success'    => false,
                'message'    => 'Registrasi gagal karena kendala sistem.',
                'insertId'   => 0,
                'noPendaftaran' => '',
                'plainPassword' => '',
            ];
        }

        return [
            'success'       => true,
            'message'       => 'Akun siswa pindahan berhasil dibuat! (No. ' . $noPendaftaran . ')',
            'insertId'      => (int) $insertId,
            'noPendaftaran' => $noPendaftaran,
            'plainPassword' => (string) ($post['password'] ?? ''),
        ];
    }

    // ─────────────────────────────────────────────────────────────
    // HAPUS SISWA PINDAHAN
    // Sebelumnya inline di Admin\Pindahan (soft delete) dan
    // Verifikator\Pindahan::delete() (hard delete + file fisik)
    // ─────────────────────────────────────────────────────────────

    /**
     * Soft delete siswa pindahan (Admin).
     */
    public function softDeletePindahan(int $id): bool
    {
        $siswa = $this->pindahanModel->find($id);
        if (!$siswa) {
            return false;
        }

        return (bool) $this->pindahanModel->delete($id);
    }

    /**
     * Hard delete siswa pindahan beserta seluruh berkas & relasinya (Verifikator).
     *
     * @return array ['success' => bool, 'message' => string, 'siswa' => array|null]
     */
    public function deletePindahanPermanently(int $id): array
    {
        $siswa = $this->pindahanModel->find($id);
        if (!$siswa) {
            return ['success' => false, 'message' => 'Data siswa pindahan tidak ditemukan.', 'siswa' => null];
        }

        $db = \Config\Database::connect();
        $db->transStart();

        // Hapus file fisik berkas
        $berkasList = $this->berkasModel->where('id_pindahan', $id)->findAll();
        $safeNisn = preg_replace('/[^a-zA-Z0-9_-]/', '', (string) ($siswa['nisn'] ?? ''));
        $baseDir  = realpath(FCPATH . 'uploads/berkas/') ?: FCPATH . 'uploads/berkas/';

        foreach ($berkasList as $berkas) {
            $filePath = realpath(FCPATH . 'uploads/berkas/' . $safeNisn . '/' . basename((string) ($berkas['nama_file'] ?? '')));
            if ($filePath !== false && strpos($filePath, $baseDir) === 0 && is_file($filePath)) {
                @unlink($filePath);
            }
        }

        // Hapus record relasi (FK cascade juga membersihkan)
        $this->berkasModel->where('id_pindahan', $id)->delete();
        $this->verifikasiModel->deleteByPindahan($id);
        $db->table('tbl_registrasi')->where('id_pindahan', $id)->delete();

        $this->pindahanModel->delete($id);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return ['success' => false, 'message' => 'Gagal menghapus data siswa pindahan.', 'siswa' => $siswa];
        }

        return [
            'success' => true,
            'message' => 'Data siswa pindahan beserta seluruh berkasnya berhasil dihapus.',
            'siswa'   => $siswa,
        ];
    }

    // ─────────────────────────────────────────────────────────────
    // FINALISASI & VALIDASI NIK
    // Sebelumnya inline di Siswa\Pindahan (finalize, updateBiodata)
    // dan Verifikator\Pindahan::biodataStore()
    // ─────────────────────────────────────────────────────────────

    /**
     * Finalisasi biodata siswa pindahan (status_pendaftaran => 'Final').
     *
     * @return array ['success' => bool, 'message' => string, 'namaSiswa' => string|null]
     */
    public function doFinalize(int $id): array
    {
        $pindahan = $this->pindahanModel->find($id);
        if (!$pindahan) {
            return ['success' => false, 'message' => 'Data pendaftaran pindahan tidak ditemukan.', 'namaSiswa' => null];
        }

        $jenjangAsal = $pindahan['jenjang_sekolah_asal'] ?? null;

        if (empty($jenjangAsal)) {
            return ['success' => false, 'message' => 'Jenjang sekolah asal wajib diisi sebelum finalisasi.', 'namaSiswa' => null];
        }

        if ($this->pindahanModel->update($id, ['status_pendaftaran' => 'Final'])) {
            return [
                'success'   => true,
                'message'   => 'Data biodata berhasil dikirim secara permanen (Final).',
                'namaSiswa' => $pindahan['nama_lengkap'] ?? "ID {$id}",
            ];
        }

        return ['success' => false, 'message' => 'Gagal memfinalisasi data biodata.', 'namaSiswa' => null];
    }

    /**
     * Cek apakah NIK sudah dipakai pendaftar lain.
     */
    public function nikTerdaftar(string $nik, int $exceptId): bool
    {
        return (bool) $this->pindahanModel
            ->where('nik', $nik)
            ->where('id_pindahan !=', $exceptId)
            ->first();
    }
}
