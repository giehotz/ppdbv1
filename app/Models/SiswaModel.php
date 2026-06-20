<?php

namespace App\Models;

use CodeIgniter\Model;

class SiswaModel extends Model
{
    protected $table            = 'tbl_siswa';
    protected $primaryKey       = 'id_siswa';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'no_pendaftaran',
        'last_login',
        'password',
        'nis',
        'nisn',
        'nik',
        'nama_lengkap',
        'email',
        'jk',
        'tempat_lahir',
        'tgl_lahir',
        'agama',
        'status_keluarga',
        'anak_ke',
        'jml_saudara',
        'hobi',
        'cita',
        'paud',
        'tk',
        'foto',
        'alamat_siswa',
        'jenis_tinggal',
        'desa',
        'kec',
        'kab',
        'prov',
        'kode_pos',
        'jarak', // Migration calls it 'jarak', model had 'jarak_rumah'? Migration line 137: 'jarak'
        'trans', // Migration line 142: 'trans', model had 'transportasi'
        'no_hp_siswa',
        'no_kk',
        'kepala_keluarga', // Migration line 157: 'kepala_keluarga', model had 'nama_kk'
        'nama_ayah',
        'nik_ayah',
        'tempat_lahir_ayah',
        'tgl_lahir_ayah', // Migration line 177: 'tgl_lahir_ayah'. Model 'tanggal_lahir_ayah'. Migration type DATE.
        'status_ayah',
        'th_lahir_ayah',
        'pdd_ayah',
        'pekerjaan_ayah',
        'penghasilan_ayah',
        'nama_ibu',
        'nik_ibu',
        'tempat_lahir_ibu',
        'tgl_lahir_ibu', // Migration line 221: 'tgl_lahir_ibu'.
        'status_ibu',
        'th_lahir_ibu',
        'pdd_ibu',
        'pekerjaan_ibu',
        'penghasilan_ibu',
        'nama_wali',
        'nik_wali',
        'th_lahir_wali',
        'pdd_wali',
        'pekerjaan_wali',
        'penghasilan_wali',
        'no_hp_ortu',
        'npsn_sekolah',
        'nama_sekolah',
        'status_sekolah',
        'jenjang_sekolah',
        'lokasi_sekolah',
        'no_kks',
        'file_kks',
        'no_pkh',
        'file_pkh',
        'no_kip',
        'file_kip',
        'komp_ahli', // Migration line 340: 'komp_ahli', model 'pilihan_komp'? Migration line 340: 'komp_ahli'.
        'jalur_pendaftaran',
        'tgl_siswa',
        'status_verifikasi',
        'status_pendaftaran',
        'tgl_verifikasi',
        'verified_by',
        'catatan_verifikasi',
        'status_berkas',
        'status_lulus'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'nisn'          => 'required|numeric|min_length[10]|max_length[20]',
        'nik'           => 'required|numeric|min_length[16]|max_length[20]',
        'nama_lengkap'  => 'required|string|max_length[255]',
        'email'         => 'permit_empty|valid_email|max_length[100]',
        'no_hp_siswa'   => 'permit_empty|regex_match[/^[0-9+\-\s]+$/]|max_length[20]',
        'no_hp_ortu'    => 'permit_empty|regex_match[/^[0-9+\-\s]+$/]|max_length[20]',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Get students with pagination and search
     */
    public function getStudents($search = '', $perPage = 20, $sortOrder = 'ASC')
    {
        if (!empty($search)) {
            $this->groupStart()
                ->like('no_pendaftaran', $search)
                ->orLike('nisn', $search)
                ->orLike('nama_lengkap', $search)
                ->orLike('email', $search)
                ->groupEnd();
        }

        return $this->orderBy('tgl_siswa', $sortOrder)
            ->paginate($perPage);
    }

    /**
     * Get student detail with verification status
     */
    public function getStudentDetail($id)
    {
        return $this->select('tbl_siswa.*, tbl_verifikasi.isi as verifikasi_isi, tbl_verifikasi.ket as verifikasi_ket')
            ->join('tbl_verifikasi', 'tbl_verifikasi.id_siswa = tbl_siswa.id_siswa', 'left')
            ->where('tbl_siswa.id_siswa', $id)
            ->first();
    }

    /**
     * Calculate student biodata completion percentage
     */
    public function calculateCompletionPercentage($siswa)
    {
        // Define required fields with labels
        $requiredFields = [
            'nisn' => 'NISN',
            'nik' => 'NIK',
            'nama_lengkap' => 'Nama Lengkap',
            'jk' => 'Jenis Kelamin',
            'tempat_lahir' => 'Tempat Lahir',
            'tgl_lahir' => 'Tanggal Lahir',
            'agama' => 'Agama',
            'alamat_siswa' => 'Alamat',
            'desa' => 'Desa/Kelurahan',
            'kec' => 'Kecamatan',
            'kab' => 'Kabupaten/Kota',
            'prov' => 'Provinsi',
            'nama_ayah' => 'Nama Ayah',
            'nama_ibu' => 'Nama Ibu',
            'no_hp_ortu' => 'No. HP Orang Tua',
        ];

        $filled = 0;
        $incompleteFields = [];

        foreach ($requiredFields as $field => $label) {
            if (!empty($siswa[$field])) {
                $filled++;
            } else {
                $incompleteFields[] = $label;
            }
        }

        return [
            'percentage' => round(($filled / count($requiredFields)) * 100),
            'incomplete' => $incompleteFields
        ];
    }
}
