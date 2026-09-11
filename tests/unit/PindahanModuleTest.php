<?php

namespace Tests\Unit;

use CodeIgniter\Test\CIUnitTestCase;
use App\Models\Pindahan\SiswaPindahanModel;
use App\Models\Pindahan\BerkasPindahanModel;
use App\Services\PindahanService;
use Config\PindahanConfig;

/**
 * Unit test suite untuk modul Pindahan:
 * - Status constants & upload config constants
 * - Kelengkapan biodata calculation & optimization
 * - Berkas wajib checklist dengan preloaded data
 * - Sanitasi input, hitung rata-rata nilai & normalisasi jenjang pada PindahanService
 */
final class PindahanModuleTest extends CIUnitTestCase
{
    /**
     * Test konstanta status siswa pindahan.
     */
    public function testSiswaPindahanStatusConstants(): void
    {
        $this->assertSame('Menunggu', SiswaPindahanModel::STATUS_MENUNGGU);
        $this->assertSame('Terverifikasi', SiswaPindahanModel::STATUS_TERVERIFIKASI);
        $this->assertSame('Ditolak', SiswaPindahanModel::STATUS_DITOLAK);

        $this->assertContains('Menunggu', SiswaPindahanModel::ALL_STATUS);
        $this->assertContains('Terverifikasi', SiswaPindahanModel::ALL_STATUS);
        $this->assertContains('Ditolak', SiswaPindahanModel::ALL_STATUS);

        $this->assertSame('Draft', SiswaPindahanModel::PENDAFTARAN_DRAFT);
        $this->assertSame('Final', SiswaPindahanModel::PENDAFTARAN_FINAL);
    }

    /**
     * Test konstanta status berkas dan dokumen wajib.
     */
    public function testBerkasPindahanConstants(): void
    {
        $this->assertSame('pending', BerkasPindahanModel::STATUS_PENDING);
        $this->assertSame('valid', BerkasPindahanModel::STATUS_VALID);
        $this->assertSame('invalid', BerkasPindahanModel::STATUS_INVALID);

        $this->assertContains('pending', BerkasPindahanModel::ALL_STATUS);
        $this->assertContains('valid', BerkasPindahanModel::ALL_STATUS);
        $this->assertContains('invalid', BerkasPindahanModel::ALL_STATUS);

        $this->assertCount(6, BerkasPindahanModel::JENIS_WAJIB);
        $this->assertContains('surat_pindah_sekolah', BerkasPindahanModel::JENIS_WAJIB);
        $this->assertContains('foto_siswa', BerkasPindahanModel::JENIS_WAJIB);
    }

    /**
     * Test konstanta upload file di PindahanConfig.
     */
    public function testUploadConfigConstants(): void
    {
        $this->assertSame(2048000, PindahanConfig::MAX_FILE_SIZE);
        $this->assertContains('image/jpeg', PindahanConfig::ALLOWED_MIME_TYPES);
        $this->assertContains('application/pdf', PindahanConfig::ALLOWED_MIME_TYPES);
        $this->assertContains('jpg', PindahanConfig::ALLOWED_FILE_EXTENSIONS);
        $this->assertContains('pdf', PindahanConfig::ALLOWED_FILE_EXTENSIONS);
    }

    /**
     * Test perhitungan persentase kelengkapan biodata.
     */
    public function testCalculateCompletionPercentage(): void
    {
        $model = new SiswaPindahanModel();

        // Kasus 1: Data kosong
        $emptySiswa = [];
        $resultEmpty = $model->calculateCompletionPercentage($emptySiswa);
        $this->assertSame(0, $resultEmpty['percentage']);
        $this->assertNotEmpty($resultEmpty['incomplete']);

        // Kasus 2: Data lengkap (18 field wajib)
        $fullSiswa = [
            'nisn'                   => '1234567890',
            'nik'                    => '1234567890123456',
            'nama_lengkap'           => 'Ahmad Santoso',
            'jk'                     => 'L',
            'tempat_lahir'           => 'Tanggamus',
            'tgl_lahir'              => '2015-05-10',
            'agama'                  => 'Islam',
            'alamat_siswa'           => 'Jl. Raya No. 1',
            'desa'                   => 'Kuripan',
            'kec'                    => 'Kota Agung',
            'kab'                    => 'Tanggamus',
            'prov'                   => 'Lampung',
            'nama_ayah'              => 'Budi',
            'nama_ibu'               => 'Siti',
            'no_hp_ortu'             => '08123456789',
            'nama_sekolah_asal'    => 'SD Negeri 1',
            'jenjang_sekolah_asal' => 'SD',
            'kelas_diterima'       => '3',
        ];
        $resultFull = $model->calculateCompletionPercentage($fullSiswa);
        $this->assertSame(100, $resultFull['percentage']);
        $this->assertEmpty($resultFull['incomplete']);

        // Kasus 3: Optimasi includeDetails = false
        $fastResult = $model->calculateCompletionPercentage($fullSiswa, false);
        $this->assertSame(100, $fastResult['percentage']);
        $this->assertEmpty($fastResult['incomplete']);

        // Kasus 4: getCompletionPercentageOnly helper
        $this->assertSame(100, $model->getCompletionPercentageOnly($fullSiswa));
        $this->assertSame(0, $model->getCompletionPercentageOnly($emptySiswa));
    }

    /**
     * Test isWajibLengkap menggunakan preloaded array data (tanpa DB query ganda).
     */
    public function testIsWajibLengkapWithPreloadedList(): void
    {
        $berkasModel = new BerkasPindahanModel();

        // Kasus 1: Belum ada berkas yang diupload
        $emptyList = [];
        $checkEmpty = $berkasModel->isWajibLengkap(999, $emptyList);
        $this->assertSame(0, $checkEmpty['sudah']);
        $this->assertSame(6, $checkEmpty['total']);
        $this->assertFalse($checkEmpty['lengkap']);
        $this->assertCount(6, $checkEmpty['kurang']);

        // Kasus 2: Berkas lengkap
        $completeList = [
            ['jenis_berkas' => 'surat_pindah_sekolah'],
            ['jenis_berkas' => 'surat_pindah_dapodik'],
            ['jenis_berkas' => 'kk'],
            ['jenis_berkas' => 'ijazah'],
            ['jenis_berkas' => 'surat_pernyataan'],
            ['jenis_berkas' => 'foto_siswa'],
            ['jenis_berkas' => 'rapor'], // opsional tambahan
        ];
        $checkComplete = $berkasModel->isWajibLengkap(999, $completeList);
        $this->assertSame(6, $checkComplete['sudah']);
        $this->assertSame(6, $checkComplete['total']);
        $this->assertTrue($checkComplete['lengkap']);
        $this->assertEmpty($checkComplete['kurang']);
    }

    /**
     * Test sanitasi data biodata pada PindahanService.
     */
    public function testSanitizeBiodata(): void
    {
        $service = new PindahanService();

        $rawPost = [
            'nik'            => '1234-5678-9012-3456',
            'nik_ayah'       => '1234.5678.9012.3456',
            'no_hp_siswa'    => '0812-3456-7890',
            'csrf_test_name' => 'secret_token',
            'finish_skip'    => '1',
            'email'          => '',
            'alasan_pindah'  => '',
        ];

        $sanitized = $service->sanitizeBiodata($rawPost);

        $this->assertSame('1234567890123456', $sanitized['nik']);
        $this->assertSame('1234567890123456', $sanitized['nik_ayah']);
        $this->assertSame('081234567890', $sanitized['no_hp_siswa']);
        $this->assertArrayNotHasKey('csrf_test_name', $sanitized);
        $this->assertArrayNotHasKey('finish_skip', $sanitized);
        $this->assertNull($sanitized['email']);
        $this->assertSame('', $sanitized['alasan_pindah']);
    }

    /**
     * Test URL resolusi foto siswa.
     */
    public function testResolvePhotoUrl(): void
    {
        $service = new PindahanService();

        // 1. Null / Kosong -> mengembalikan null
        $this->assertNull($service->resolvePhotoUrl(null));
        $this->assertNull($service->resolvePhotoUrl(''));

        // 2. Local path relative -> URL dengan base_url
        $localPath = 'uploads/berkas/12345/foto.jpg';
        $resolved = $service->resolvePhotoUrl($localPath);
        $this->assertNotNull($resolved);
        $this->assertStringContainsString('uploads/berkas/12345/foto.jpg', $resolved);
    }

    /**
     * Test hitung rata-rata nilai rapor pada PindahanService.
     */
    public function testHitungRataRata(): void
    {
        $service = new PindahanService();

        $inputNilai = [
            'nilai_bahasa_indonesia' => '80',
            'nilai_matematika'       => '90',
            'nilai_ipa'              => '85',
        ];

        $result = $service->hitungRataRata($inputNilai);
        $this->assertArrayHasKey('rata_rata_nilai', $result);
        $this->assertSame(85.0, (float) $result['rata_rata_nilai']);
    }

    /**
     * Test normalisasi data jenjang dan pengisian grup jenjang asal.
     */
    public function testNormalizeJenjangData(): void
    {
        $service = new PindahanService();

        $input = [
            'jenjang_sekolah_asal' => 'mts',
            'nama_sekolah_asal'    => 'MTs Negeri 1 Tanggamus',
        ];

        $normalized = $service->normalizeJenjangData($input);

        $this->assertSame('MTs', $normalized['jenjang_sekolah_asal']);
        $this->assertSame('SMP/MTs', $normalized['grup_jenjang_asal']);
    }
}
