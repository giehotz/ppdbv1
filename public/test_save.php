<?php
// Load CodeIgniter 4 Environment
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);
chdir(FCPATH);

require FCPATH . '../app/Config/Paths.php';
$paths = new Config\Paths();
require rtrim($paths->systemDirectory, '\\/ ') . DIRECTORY_SEPARATOR . 'bootstrap.php';

// Try to update using SiswaModel
$siswaModel = new \App\Models\SiswaModel();
$result = $siswaModel->update(1, ['status_keluarga' => 'Anak Kandung']);

echo "Update result: " . ($result ? 'true' : 'false') . "\n";
$siswa = $siswaModel->find(1);
print_r($siswaModel->allowedFields());
echo "\nValue in DB: " . ($siswa['status_keluarga'] ?? 'NOT FOUND');
