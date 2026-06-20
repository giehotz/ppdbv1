<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\TwibbonSettingModel;

class TwibbonCleanup extends BaseCommand
{
    protected $group       = 'Twibbon';
    protected $name        = 'twibbon:cleanup';
    protected $description = 'Menghapus file twibbon hasil/temp yang sudah melebihi batas waktu.';

    public function run(array $params)
    {
        $settings = (new TwibbonSettingModel())->getSettings();

        if (empty($settings['cleanup_enabled'])) {
            CLI::write('Pembersihan otomatis dinonaktifkan di pengaturan.', 'yellow');
            return;
        }

        $resultsTTL = (int) $settings['results_ttl_hours'] * 3600;
        $tempTTL    = (int) $settings['temp_ttl_hours'] * 3600;

        CLI::write("Batas waktu hasil: {$settings['results_ttl_hours']} jam", 'cyan');
        CLI::write("Batas waktu temp:  {$settings['temp_ttl_hours']} jam", 'cyan');

        $deleted = 0;

        $resultsPath = FCPATH . 'uploads/twibbon/results';
        $deleted += $this->cleanDir($resultsPath, $resultsTTL, 'results/*');

        $tempPath = FCPATH . 'uploads/twibbon/temp';
        $deleted += $this->cleanDir($tempPath, $tempTTL, 'temp/*');

        CLI::write("Selesai. {$deleted} file dihapus.", 'green');
    }

    private function cleanDir(string $path, int $maxAge, string $label): int
    {
        if (!is_dir($path)) {
            return 0;
        }

        $now   = time();
        $count = 0;

        $files = glob($path . '/*');
        foreach ($files as $file) {
            if (is_file($file) && basename($file) !== '.gitkeep') {
                if ($now - filemtime($file) > $maxAge) {
                    unlink($file);
                    $count++;
                }
            }
        }

        if ($count > 0) {
            CLI::write("  {$label}: {$count} file expired dihapus.", 'yellow');
        }

        return $count;
    }
}
