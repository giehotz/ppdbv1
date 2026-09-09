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
        'th_pelajaran',
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
        'tgl_lahir_ayah',
        'status_ayah',
        'pdd_ayah',
        'pekerjaan_ayah',
        'penghasilan_ayah',
        'nama_ibu',
        'nik_ibu',
        'tempat_lahir_ibu',
        'tgl_lahir_ibu',
        'status_ibu',
        'pdd_ibu',
        'pekerjaan_ibu',
        'penghasilan_ibu',
        'nama_wali',
        'nik_wali',
        'tgl_lahir_wali',
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
        'status_lulus',
        'is_checked'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'nisn'          => 'permit_empty|numeric|min_length[10]|max_length[20]',
        'nik'           => 'permit_empty|numeric|min_length[16]|max_length[20]',
        'nama_lengkap'  => 'permit_empty|string|max_length[255]',
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
     * Dapatkan tahun pelajaran aktif dari tabel pengaturan tbl_web
     */
    public function getActiveThPelajaran(): string
    {
        $db = \Config\Database::connect();
        $web = $db->table('tbl_web')->select('th_pelajaran')->where('id_web', 1)->get()->getRowArray();
        return !empty($web['th_pelajaran']) ? $web['th_pelajaran'] : '2025/2026';
    }

    /**
     * Get status counts for filter tabs
     */
    public function getStatusCounts($thPelajaran = null): array
    {
        if ($thPelajaran === null) {
            $thPelajaran = $this->getActiveThPelajaran();
        }

        $db = \Config\Database::connect();
        $builder = $db->table('tbl_siswa')->where('deleted_at', null);
        if ($thPelajaran !== 'all') {
            $builder->where('th_pelajaran', $thPelajaran);
        }

        $total = (clone $builder)->countAllResults();
        $menunggu = (clone $builder)->groupStart()
            ->where('status_verifikasi', 'Menunggu')
            ->orWhere('status_verifikasi', '')
            ->orWhere('status_verifikasi IS NULL')
            ->groupEnd()->countAllResults();
        $terverifikasi = (clone $builder)->where('status_verifikasi', 'Terverifikasi')->countAllResults();
        $ditolak = (clone $builder)->where('status_verifikasi', 'Ditolak')->countAllResults();
        $incomplete = (clone $builder)->where("(nisn IS NULL OR nisn = '' OR nik IS NULL OR nik = '' OR nama_lengkap IS NULL OR nama_lengkap = '' OR jk IS NULL OR jk = '' OR tempat_lahir IS NULL OR tempat_lahir = '' OR tgl_lahir IS NULL OR agama IS NULL OR agama = '' OR alamat_siswa IS NULL OR alamat_siswa = '' OR desa IS NULL OR desa = '' OR kec IS NULL OR kec = '' OR kab IS NULL OR kab = '' OR prov IS NULL OR prov = '' OR nama_ayah IS NULL OR nama_ayah = '' OR nama_ibu IS NULL OR nama_ibu = '' OR no_hp_ortu IS NULL OR no_hp_ortu = '')")->countAllResults();

        return [
            'all'           => $total,
            'menunggu'      => $menunggu,
            'terverifikasi' => $terverifikasi,
            'ditolak'       => $ditolak,
            'incomplete'    => $incomplete,
        ];
    }

    /**
     * Get students with pagination, search, academic year filter, and tab filter
     */
    public function getStudents($search = '', $perPage = 20, $sortOrder = 'ASC', $thPelajaran = null, $tab = 'all')
    {
        // Jika thPelajaran null, default ke tahun pelajaran aktif
        if ($thPelajaran === null) {
            $thPelajaran = $this->getActiveThPelajaran();
        }

        // Jika bukan 'all', filter berdasarkan th_pelajaran
        if ($thPelajaran !== 'all') {
            $this->where('tbl_siswa.th_pelajaran', $thPelajaran);
        }

        // Filter status tab
        if ($tab === 'menunggu') {
            $this->groupStart()
                ->where('tbl_siswa.status_verifikasi', 'Menunggu')
                ->orWhere('tbl_siswa.status_verifikasi', '')
                ->orWhere('tbl_siswa.status_verifikasi IS NULL')
                ->groupEnd();
        } elseif ($tab === 'terverifikasi') {
            $this->where('tbl_siswa.status_verifikasi', 'Terverifikasi');
        } elseif ($tab === 'ditolak') {
            $this->where('tbl_siswa.status_verifikasi', 'Ditolak');
        } elseif ($tab === 'incomplete') {
            $this->where("(tbl_siswa.nisn IS NULL OR tbl_siswa.nisn = '' OR tbl_siswa.nik IS NULL OR tbl_siswa.nik = '' OR tbl_siswa.nama_lengkap IS NULL OR tbl_siswa.nama_lengkap = '' OR tbl_siswa.jk IS NULL OR tbl_siswa.jk = '' OR tbl_siswa.tempat_lahir IS NULL OR tbl_siswa.tempat_lahir = '' OR tbl_siswa.tgl_lahir IS NULL OR tbl_siswa.agama IS NULL OR tbl_siswa.agama = '' OR tbl_siswa.alamat_siswa IS NULL OR tbl_siswa.alamat_siswa = '' OR tbl_siswa.desa IS NULL OR tbl_siswa.desa = '' OR tbl_siswa.kec IS NULL OR tbl_siswa.kec = '' OR tbl_siswa.kab IS NULL OR tbl_siswa.kab = '' OR tbl_siswa.prov IS NULL OR tbl_siswa.prov = '' OR tbl_siswa.nama_ayah IS NULL OR tbl_siswa.nama_ayah = '' OR tbl_siswa.nama_ibu IS NULL OR tbl_siswa.nama_ibu = '' OR tbl_siswa.no_hp_ortu IS NULL OR tbl_siswa.no_hp_ortu = '')");
        }

        if (!empty($search)) {
            $this->groupStart()
                ->like('tbl_siswa.no_pendaftaran', $search)
                ->orLike('tbl_siswa.nisn', $search)
                ->orLike('tbl_siswa.nama_lengkap', $search)
                ->orLike('tbl_siswa.email', $search)
                ->groupEnd();
        }

        return $this->orderBy('tbl_siswa.tgl_siswa', $sortOrder)
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
